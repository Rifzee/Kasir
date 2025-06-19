<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\DetailPenjualan;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $totalPenjualan = Penjualan::whereBetween('tanggal', [$from, $to])->sum('total');
        $totalPembelian = Pembelian::whereBetween('tanggal', [$from, $to])->sum('total');

        $laba = DetailPenjualan::whereHas('penjualan', function ($q) use ($from, $to) {
            $q->whereBetween('tanggal', [$from, $to]);
        })->selectRaw('SUM((harga - harga_beli) * qty) as total_laba')->first()->total_laba ?? 0;

        return view('laporan.index', compact('from', 'to', 'totalPenjualan', 'totalPembelian', 'laba'));
    }

    public function export(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $totalPenjualan = Penjualan::whereBetween('tanggal', [$from, $to])->sum('total');
        $totalPembelian = Pembelian::whereBetween('tanggal', [$from, $to])->sum('total');
        $laba = DetailPenjualan::whereHas('penjualan', function ($q) use ($from, $to) {
            $q->whereBetween('tanggal', [$from, $to]);
        })->selectRaw('SUM((harga - harga_beli) * qty) as total_laba')->first()->total_laba ?? 0;

        $pdf = PDF::loadView('laporan.pdf', compact('from', 'to', 'totalPenjualan', 'totalPembelian', 'laba'));
        return $pdf->download('laporan-keuangan.pdf');
    }
}
