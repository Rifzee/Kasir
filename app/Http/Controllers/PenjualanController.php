<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('user')->latest()->get();
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $produk = Produk::all();
        return view('penjualan.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'produk_id' => 'required|array',
            'qty' => 'required|array',
            'harga' => 'required|array'
        ]);

        // Validasi stok
        foreach ($request->produk_id as $i => $id_produk) {
            $produk = Produk::findOrFail($id_produk);
            $qty    = $request->qty[$i];

            if ($produk->stok < $qty) {
                return back()->withErrors([
                    'msg' => "Stok produk '{$produk->nama}' tidak cukup. Tersedia: {$produk->stok}, diminta: {$qty}."
                ])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->produk_id as $i => $id_produk) {
                $subtotal = $request->qty[$i] * $request->harga[$i];
                $total += $subtotal;
            }

            $diskonPersen = $request->diskon ?? 0;
            $totalBayar = $total - ($total * $diskonPersen / 100);

            $penjualan = Penjualan::create([
                'user_id' => Auth::id(),
                'tanggal' => $request->tanggal,
                'diskon' => $request->diskon ?? 0,
                'total' => $totalBayar,
            ]);

            foreach ($request->produk_id as $i => $id_produk) {
                $produk = Produk::findOrFail($id_produk);

                $harga_jual = $produk->harga_jual;
                $qty = $request->qty[$i];
                $subtotal = $harga_jual * $qty;

                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id' => $produk->id,
                    'qty' => $qty,
                    'harga' => $harga_jual, // diambil dari tabel produk
                    'harga_beli' => $produk->harga_beli,
                    'subtotal' => $subtotal,
                ]);

                // Update stok
                $produk->stok -= $qty;
                $produk->save();
            }

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal menyimpan penjualan.'])->withInput();
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('detailPenjualans.produk', 'user')->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->detailPenjualans()->delete();
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Data berhasil dihapus.');
    }
}
