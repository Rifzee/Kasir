@extends('layouts.app')
@section('title', 'Detail Pembelian')

@section('content')
<h4 class="mb-4">Detail Pembelian</h4>

<div class="card mb-3">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Tanggal</th>
                <td>{{ $pembelian->tanggal }}</td>
            </tr>
            <tr>
                <th>Supplier</th>
                <td>{{ $pembelian->supplier->nama ?? '-' }} ({{ $pembelian->supplier->nama_perusahaan ?? '-' }})</td>
            </tr>
            <tr>
                <th>Dibuat Oleh</th>
                <td>{{ $pembelian->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Diskon</th>
                <td>{{ $pembelian->diskon }}% (Rp {{ number_format($pembelian->total * $pembelian->diskon / (100 - $pembelian->diskon), 0, ',', '.') }})</td>
            </tr>
            <tr>
                <th>Total</th>
                <td><strong>Rp {{ number_format($pembelian->total, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header fw-semibold">Detail Produk Dibeli</div>
    <div class="card-body p-0">
        <table class="table table-bordered m-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelian->detailPembelians as $i => $d)
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
    <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
