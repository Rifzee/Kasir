<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with('supplier', 'user')->latest()->get();
        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $supplier = Supplier::all();
        $produk = Produk::all();
        return view('pembelian.create', compact('supplier', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'tanggal' => 'required|date',
            'produk_id' => 'required|array',
            'qty' => 'required|array',
            'harga' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->produk_id as $i => $id_produk) {
                $subtotal = $request->qty[$i] * $request->harga[$i];
                $total += $subtotal;
            }
            $diskonPersen = $request->diskon ?? 0;
            $totalBayar = $total - ($total * $diskonPersen / 100);

            $pembelian = Pembelian::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id(),
                'tanggal' => $request->tanggal,
                'diskon' => $request->diskon ?? 0,
                'total' => $totalBayar,
            ]);

            foreach ($request->produk_id as $i => $id_produk) {
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'produk_id' => $id_produk,
                    'qty' => $request->qty[$i],
                    'harga' => $request->harga[$i],
                    'subtotal' => $request->qty[$i] * $request->harga[$i],
                ]);

                // update stok produk
                $produk = Produk::find($id_produk);
                $produk->stok += $request->qty[$i];
                $produk->harga_beli = $request->harga[$i]; // update harga beli terakhir
                $produk->save();
            }

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Terjadi kesalahan saat menyimpan pembelian.'])->withInput();
        }
    }

    public function show($id)
    {
        $pembelian = Pembelian::with('detailPembelians.produk', 'supplier', 'user')->findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->detailPembelians()->delete();
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Data berhasil dihapus.');
    }

    // Edit/update tidak disiapkan karena pembelian biasanya tidak diedit, hanya dihapus
}
