@extends('layouts.app')
@section('title', 'Categories')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-tags me-2 text-success"></i>Categories</h3>
<div class="row g-4">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Add Category</h6>
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-2">
                        <input type="text" name="name" class="form-control" placeholder="Category name" required>
                    </div>
                    <div class="mb-3">
                        <select name="type" class="form-select" required>
                            <option value="produce">Produce</option>
                            <option value="input">Farm Input</option>
                        </select>
                    </div>
                    <button class="btn btn-success w-100"><i class="bi bi-plus-lg me-1"></i>Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Name</th><th>Type</th><th>Products</th></tr></thead>
            <tbody>
            @foreach($categories as $cat)
                <tr>
                    <td class="fw-semibold">{{ $cat->name }}</td>
                    <td><span class="ac-cat-pill {{ $cat->type === 'input' ? 'input-type' : '' }}">{{ ucfirst($cat->type) }}</span></td>
                    <td>{{ $cat->products_count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
