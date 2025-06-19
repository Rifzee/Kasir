@extends('layouts.app')
@section('title', 'Edit Jenis Produk')

@section('content')
<h4 class="mb-3">Edit Jenis Produk</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('kategori-produk.update', $kategori->id) }}" method="POST">
            @csrf @method('PUT')
            @include('kategori-produk.form', ['kategori' => $kategori])
        </form>
    </div>
</div>
@endsection
