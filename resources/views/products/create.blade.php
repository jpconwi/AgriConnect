@extends('layouts.app')
@section('title', 'Add Product')
@section('content')
<h3 class="mb-3">Add Product</h3>
<div class="card shadow-sm" style="max-width:600px;">
<div class="card-body">
<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    @include('products._form')
    <button class="btn btn-success">Submit for Approval</button>
</form>
</div>
</div>
@endsection
