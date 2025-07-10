<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan semua pesanan milik customer yang sedang login.
     */
    public function index()
    {
        $user = auth()->guard('customer')->user();

        $orders = Order::where('customer_id', $user->id)
            ->with([
                'customer',
                'items' => fn($query) => $query->orderByDesc('created_at'),
                'items.product',
            ])
            ->withCount('items')
            ->latest()
            ->get();

        $orderData = [];

        foreach ($orders as $order) {
            $totalAmount = 0;
            $lastAddedToCart = null;

            foreach ($order->items as $item) {
                if ($item->product) {
                    $totalAmount += $item->price * $item->quantity;
                }

                if (!$lastAddedToCart || $item->created_at > $lastAddedToCart) {
                    $lastAddedToCart = $item->created_at;
                }
            }

            $orderData[] = [
                'order_id'               => $order->id,
                'customer_name'          => optional($order->customer)->name ?? '-',
                'total_amount'           => $totalAmount,
                'items_count'            => $order->items_count ?? 0,
                'last_added_to_cart'     => $lastAddedToCart,
                'payment_method'         => $order->payment_method ?? '-',
                'status'                 => $order->status ?? 'pending',
                'created_at'             => $order->created_at,
                'completed_order_exists' => $order->status === 'completed',
                'completed_at'           => in_array($order->status, ['completed', 'cancelled']) ? $order->updated_at : null,
            ];
        }

        usort($orderData, function ($a, $b) {
            return strtotime($b['completed_at'] ?? '1970-01-01') - strtotime($a['completed_at'] ?? '1970-01-01');
        });

        return view('theme.default.customer.my-orders', ['orders' => $orderData]);
    }

    /**
     * Membatalkan pesanan yang masih pending.
     */
    public function cancel($id)
    {
        $user = auth()->guard('customer')->user();

        $order = Order::where('id', $id)
            ->where('customer_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Tampilkan detail pesanan.
     */
    public function show($id)
    {
        $user = auth()->guard('customer')->user();

        $order = Order::with(['items.product', 'customer'])
            ->where('id', $id)
            ->where('customer_id', $user->id)
            ->firstOrFail();

        return view('theme.default.customer.order-details', compact('order'));
    }

    /**
     * Tampilkan halaman invoice (resi) untuk dicetak.
     */
    public function invoice($id)
    {
        $user = auth()->guard('customer')->user();

        $order = Order::with(['items.product', 'customer'])
            ->where('id', $id)
            ->where('customer_id', $user->id)
            ->firstOrFail();

        return view('theme.default.customer.order-invoice', compact('order'));
    }
}
