<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return view('dashboard.admin', [
                'totalUsers' => User::count(),
                'pendingUsers' => User::where('status', 'pending')->count(),
                'pendingProducts' => Product::where('status', 'pending')->count(),
                'totalOrders' => Order::count(),
                'totalProducts' => Product::count(),
            ]);
        }

        if ($user->isSeller()) {
            $products = Product::where('user_id', $user->id)->latest()->get();
            $orderItemsCount = \App\Models\OrderItem::where('seller_id', $user->id)->count();

            return view('dashboard.seller', [
                'products' => $products,
                'orderItemsCount' => $orderItemsCount,
            ]);
        }

        // buyer
        $orders = Order::where('buyer_id', $user->id)->latest()->take(5)->get();

        return view('dashboard.buyer', [
            'orders' => $orders,
        ]);
    }
}
