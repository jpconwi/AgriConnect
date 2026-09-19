<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    // Public marketplace listing (buyers browse here)
    public function index(Request $request): View
    {
        $query = Product::with(['seller', 'category'])->approved()->where('stock_quantity', '>', 0);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    // Seller (farmer/supplier) product management
    public function manage(Request $request): View
    {
        $products = Product::with('category')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('products.manage', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:20'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'pending';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.manage')->with('status', 'Product submitted for admin approval.');
    }

    public function edit(Product $product): View
    {
        $this->authorizeOwner($product);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeOwner($product);

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:20'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Edits go back through moderation.
        $data['status'] = 'pending';

        $product->update($data);

        return redirect()->route('products.manage')->with('status', 'Product updated and re-submitted for approval.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeOwner($product);
        $product->delete();

        return redirect()->route('products.manage')->with('status', 'Product removed.');
    }

    private function authorizeOwner(Product $product): void
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
