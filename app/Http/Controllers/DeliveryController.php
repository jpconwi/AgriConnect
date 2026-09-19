<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    // Public-ish tracking page for the buyer
    public function track(Order $order): View
    {
        $user = auth()->user();
        if ($order->buyer_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $order->load('delivery');

        return view('orders.track', compact('order'));
    }

    // Admin updates delivery progress
    public function update(Request $request, Delivery $delivery): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:preparing,in_transit,delivered'],
            'courier_name' => ['nullable', 'string', 'max:255'],
            'current_location' => ['nullable', 'string', 'max:255'],
            'estimated_arrival' => ['nullable', 'date'],
        ]);

        $delivery->update($request->only('status', 'courier_name', 'current_location', 'estimated_arrival'));

        if ($request->status === 'delivered') {
            $delivery->order->update(['status' => 'delivered']);
        } elseif ($request->status === 'in_transit') {
            $delivery->order->update(['status' => 'out_for_delivery']);
        }

        return back()->with('status', 'Delivery updated.');
    }
}
