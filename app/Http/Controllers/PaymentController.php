<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Admin/seller confirms a COD or bank/GCash payment was received
    public function markPaid(Request $request, Payment $payment): RedirectResponse
    {
        $user = $request->user();
        $isSellerOnOrder = $payment->order->items()->where('seller_id', $user->id)->exists();

        if (! $isSellerOnOrder && ! $user->isAdmin()) {
            abort(403);
        }

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        if ($payment->order->status === 'pending') {
            $payment->order->update(['status' => 'confirmed']);
        }

        return back()->with('status', 'Payment marked as paid.');
    }
}
