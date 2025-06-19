@extends('layouts.app')
@section('title', 'Detail Penjualan')

@section('content')
<h4 class="mb-4">Detail Penjualan</h4>

<div class="card mb-3">
    <div class="card-body">
        <table class="table">
            <tr><th>Tanggal</th><td>{{ $penjualan->tanggal }}</td></tr>
            <tr><th>User</th><td>{{ $penjualan->user->name ?? '-' }}</td></tr>
            <tr><th>Diskon</th><td>{{ $penjualan->diskon }}% (Rp {{ number_format($penjualan->total * $penjualan->diskon / (100 - $penjualan->diskon), 0, ',', '.') }})</td></tr>
            <tr><th>Total</th><td><strong>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</strong></td></tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header fw-semibold">Produk Terjual</div>
    <div class="card-body p-0">
        <table class="table table-bordered m-0">
            <thead class="table-light">
                <tr><th>#</th><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach($penjualan->detailPenjualans as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $d->produk->nama ?? '-' }}</td>
                    <td>{{ $d->qty }}</td>
                    <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
