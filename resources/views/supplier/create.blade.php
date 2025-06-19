@extends('layouts.app')
@section('title', 'Tambah Supplier')

@section('content')
<h4 class="mb-3">Tambah Supplier</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            @include('supplier.form')
        </form>
    </div>
</div>
@endsection
