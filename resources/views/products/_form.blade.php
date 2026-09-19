<div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select" required>
        <option value="">Select category</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }} ({{ ucfirst($cat->type) }})
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Product Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Price (₱)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Unit</label>
        <input type="text" name="unit" class="form-control" placeholder="kg, sack, piece" value="{{ old('unit', $product->unit ?? 'kg') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Stock Quantity</label>
        <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Product Image</label>
    <input type="file" name="image" class="form-control">
</div>
