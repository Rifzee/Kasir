@extends('layouts.app')
@section('title', 'Data Pembelian')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h4>Data Pembelian</h4>
    <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-primary">+ Tambah Pembelian</a>
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
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelians as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->tanggal }}</td>
                    <td>{{ $p->supplier->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('pembelian.show', $p->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <form action="{{ route('pembelian.destroy', $p->id) }}" method="POST" class="d-inline form-hapus">
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
