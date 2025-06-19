@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')
    <div class="mb-4">
        <h4>Tambah Satuan</h4>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('satuan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Satuan</label>
                    <input type="text" name="nama" id="nama" class="form-control" required value="{{ old('nama') }}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('satuan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
