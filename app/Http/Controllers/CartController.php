<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->cart($request);
        $products = Product::whereIn('id', array_keys($cart))->get();

        $items = $products->map(function (Product $product) use ($cart) {
            $qty = $cart[$product->id];
            return [
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => $qty * $product->price,
            ];
        });

        $total = $items->sum('subtotal');

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);

        $cart = $this->cart($request);
        $qty = $request->integer('quantity');
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;

        $request->session()->put('cart', $cart);

        return back()->with('status', 'Added to cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);

        $cart = $this->cart($request);
        $cart[$product->id] = $request->integer('quantity');
        $request->session()->put('cart', $cart);

        return back()->with('status', 'Cart updated.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->cart($request);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('status', 'Item removed.');
    }

    private function cart(Request $request): array
    {
        return $request->session()->get('cart', []);
    }
}
