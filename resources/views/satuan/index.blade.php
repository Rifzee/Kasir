@extends('layouts.app')

@section('title', 'Data Satuan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Data Satuan</h4>
        <a href="{{ route('satuan.create') }}" class="btn btn-sm btn-primary">+ Tambah Satuan</a>
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
                        <th>Nama Satuan</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($satuans as $index => $satuan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $satuan->nama }}</td>
                            <td class="text-center">
                                <a href="{{ route('satuan.edit', $satuan->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('satuan.destroy', $satuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data satuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
