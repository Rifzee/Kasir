@extends('layouts.app')
@section('title', 'Tambah Jenis Produk')

@section('content')
<h4 class="mb-3">Tambah Jenis Produk</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('kategori-produk.store') }}" method="POST">
            @csrf
            @include('kategori-produk.form')
        </form>
    </div>
</div>
@endsection
