@extends('layouts.app')
@section('title', 'Data Produk')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h4>Data Produk</h4>
    <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary">+ Tambah Produk</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th class="text-center" width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->kategori->nama ?? '-' }}</td>
                    <td>{{ $p->satuan->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($p->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                    <td>{{ $p->stok }}</td>
                    <td class="text-center">
                        <a href="{{ route('produk.edit', $p->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
