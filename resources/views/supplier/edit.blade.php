@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
<h4 class="mb-3">Edit Supplier</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
            @csrf @method('PUT')
            @include('supplier.form', ['supplier' => $supplier])
        </form>
    </div>
</div>
@endsection
