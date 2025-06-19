@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<h4 class="mb-3">Edit Produk</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST">
            @csrf @method('PUT')
            @include('produk.form', ['produk' => $produk])
        </form>
    </div>
</div>
@endsection
