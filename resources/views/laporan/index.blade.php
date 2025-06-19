@extends('layouts.app')
@section('title', 'Laporan Keuangan')

@section('content')
<h4 class="mb-3">Laporan Keuangan</h4>

<form class="row g-3 mb-4" method="GET" action="{{ route('laporan.index') }}">
    <div class="col-md-3">
        <input type="date" name="from" class="form-control" value="{{ $from }}">
    </div>
    <div class="col-md-3">
        <input type="date" name="to" class="form-control" value="{{ $to }}">
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('laporan.export', ['from' => $from, 'to' => $to]) }}" class="btn btn-success">Export PDF</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Total Penjualan</th>
                <td>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Pembelian</th>
                <td>Rp {{ number_format($totalPembelian, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Keuntungan Bersih</th>
                <td><strong>Rp {{ number_format($laba, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
</div>
@endsection
