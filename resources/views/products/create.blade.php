@extends('layouts.app')
@section('title', 'Add Product')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-plus-circle me-2 text-success"></i>Add Product</h3>
<div class="card" style="max-width:640px;">
<div class="card-body p-4">
<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    @include('products._form')
    <button class="btn btn-success w-100 py-2">Submit for Approval</button>
</form>
</div>
</div>
@endsection
