@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<h4 class="mb-3">Tambah Produk</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('produk.store') }}" method="POST">
            @csrf
            @include('produk.form')
        </form>
    </div>
</div>
@endsection
