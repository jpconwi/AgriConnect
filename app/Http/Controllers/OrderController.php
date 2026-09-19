<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function checkout(Request $request): View|RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $items = $products->map(fn (Product $p) => [
            'product' => $p,
            'quantity' => $cart[$p->id],
            'subtotal' => $cart[$p->id] * $p->price,
        ]);
        $total = $items->sum('subtotal');

        return view('cart.checkout', compact('items', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'delivery_address' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'payment_method' => ['required', 'in:cod,gcash,bank_transfer'],
            'reference_no' => ['nullable', 'string', 'max:100'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        foreach ($cart as $productId => $qty) {
            $product = $products->get($productId);
            if (! $product || $product->stock_quantity < $qty) {
                return back()->withErrors(['cart' => 'Some items in your cart are no longer available in the requested quantity.']);
            }
        }

        $order = DB::transaction(function () use ($cart, $products, $request) {
            $total = 0;
            foreach ($cart as $productId => $qty) {
                $total += $products->get($productId)->price * $qty;
            }

            $order = Order::create([
                'order_number' => 'AC-'.strtoupper(Str::random(8)),
                'buyer_id' => $request->user()->id,
                'total_amount' => $total,
                'status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
            ]);

            foreach ($cart as $productId => $qty) {
                $product = $products->get($productId);

                $order->items()->create([
                    'product_id' => $product->id,
                    'seller_id' => $product->user_id,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'subtotal' => $product->price * $qty,
                ]);

                $product->decrement('stock_quantity', $qty);
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'amount' => $total,
                'status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
                'reference_no' => $request->reference_no,
                'paid_at' => $request->payment_method === 'cod' ? null : now(),
            ]);

            Delivery::create([
                'order_id' => $order->id,
                'tracking_number' => 'TRK-'.strtoupper(Str::random(10)),
                'status' => 'preparing',
            ]);

            return $order;
        });

        $request->session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('status', 'Order placed successfully!');
    }

    // Buyer's own orders
    public function index(Request $request): View
    {
        $orders = Order::with(['items', 'delivery', 'payment'])
            ->where('buyer_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $user = auth()->user();
        $isBuyer = $order->buyer_id === $user->id;
        $isSellerOnOrder = $order->items()->where('seller_id', $user->id)->exists();

        if (! $isBuyer && ! $isSellerOnOrder && ! $user->isAdmin()) {
            abort(403);
        }

        $order->load(['items.product', 'buyer', 'payment', 'delivery']);

        return view('orders.show', compact('order'));
    }

    // Seller view of orders containing their products
    public function sales(Request $request): View
    {
        $orderIds = \App\Models\OrderItem::where('seller_id', $request->user()->id)
            ->pluck('order_id')
            ->unique();

        $orders = Order::with(['items' => function ($q) use ($request) {
                $q->where('seller_id', $request->user()->id);
            }, 'buyer', 'delivery'])
            ->whereIn('id', $orderIds)
            ->latest()
            ->paginate(10);

        return view('orders.sales', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $user = $request->user();
        $isSellerOnOrder = $order->items()->where('seller_id', $user->id)->exists();

        if (! $isSellerOnOrder && ! $user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,out_for_delivery,delivered,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('status', 'Order status updated.');
    }
}
