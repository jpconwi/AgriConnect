@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
<h3 class="mb-3">Edit Product</h3>
<div class="card shadow-sm" style="max-width:600px;">
<div class="card-body">
<form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('products._form')
    <button class="btn btn-success">Save Changes</button>
</form>
</div>
</div>
@endsection
