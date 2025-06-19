<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk     = Produk::count();
        $totalKategori   = DB::table('kategori_produks')->count();
        $totalPenjualan  = Penjualan::count();
        $totalPembelian  = Pembelian::count();
        $produkStokMenipis = Produk::where('stok', '<', 10)->get();

        // Hitung keuntungan total dari detail penjualan
        $keuntungan = DetailPenjualan::select(DB::raw('SUM((harga - harga_beli) * qty) as total_laba'))->first()->total_laba ?? 0;

        return view('dashboard', compact(
            'totalProduk',
            'totalKategori',
            'totalPenjualan',
            'totalPembelian',
            'keuntungan',
            'produkStokMenipis'
        ));
    }
    public function chartData(Request $request)
    {
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();
    
        $data = DB::table('penjualan')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total - diskon) as keuntungan, COUNT(*) as penjualan')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    
        $labels = [];
        $keuntungan = [];
        $penjualan = [];
    
        $period = Carbon::parse($start)->daysUntil($end);
    
        foreach ($period as $date) {
            $labels[] = $date->format('Y-m-d');
            $dayData = $data->firstWhere('tanggal', $date->format('Y-m-d'));
            $keuntungan[] = $dayData ? $dayData->keuntungan : 0;
            $penjualan[] = $dayData ? $dayData->penjualan : 0;
        }
    
        return response()->json([
            'labels' => $labels,
            'keuntungan' => $keuntungan,
            'penjualan' => $penjualan,
        ]);
    }
}
