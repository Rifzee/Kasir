@extends('layouts.app')
@section('title', 'Data Penjualan')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h4>Data Penjualan</h4>
    <a href="{{ route('penjualan.create') }}" class="btn btn-sm btn-primary">+ Transaksi Baru</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualans as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->tanggal }}</td>
                    <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('penjualan.show', $p->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <form action="{{ route('penjualan.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus transaksi?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
