@extends('layouts.app')
@section('title', 'Categories')
@section('content')
<h3 class="mb-3">Categories</h3>
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Add Category</h6>
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-2">
                        <input type="text" name="name" class="form-control" placeholder="Category name" required>
                    </div>
                    <div class="mb-2">
                        <select name="type" class="form-select" required>
                            <option value="produce">Produce</option>
                            <option value="input">Farm Input</option>
                        </select>
                    </div>
                    <button class="btn btn-success w-100">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <table class="table bg-white shadow-sm">
            <thead><tr><th>Name</th><th>Type</th><th>Products</th></tr></thead>
            <tbody>
            @foreach($categories as $cat)
                <tr><td>{{ $cat->name }}</td><td>{{ ucfirst($cat->type) }}</td><td>{{ $cat->products_count }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
