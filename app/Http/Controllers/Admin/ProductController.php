<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['seller', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function approve(Product $product): RedirectResponse
    {
        $product->update(['status' => 'approved']);
        return back()->with('status', 'Product approved.');
    }

    public function reject(Product $product): RedirectResponse
    {
        $product->update(['status' => 'rejected']);
        return back()->with('status', 'Product rejected.');
    }

    public function categories(): View
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:produce,input'],
        ]);

        Category::create($request->only('name', 'type'));

        return back()->with('status', 'Category added.');
    }
}
