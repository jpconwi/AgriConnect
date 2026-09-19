@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-pencil-square me-2 text-success"></i>Edit Product</h3>
<div class="card" style="max-width:640px;">
<div class="card-body p-4">
<form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('products._form')
    <button class="btn btn-success w-100 py-2">Save Changes</button>
</form>
</div>
</div>
@endsection
