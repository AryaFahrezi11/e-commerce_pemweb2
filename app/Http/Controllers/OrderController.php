<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik customer yang sedang login.
     */
    public function index()
    {
        $user = auth()->guard('customer')->user();

        if (!$user) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil semua pesanan customer dengan relasi itemable
        $orders = Order::where('customer_id', $user->id)
            ->with(['items.itemable'])
            ->latest()
            ->get();

        // View: resources/views/orders/index.blade.php
        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail dari pesanan tertentu milik customer.
     */
    public function show($id)
    {
        $user = auth()->guard('customer')->user();

        if (!$user) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cari order berdasarkan ID dan milik user yang login
        $order = Order::where('customer_id', $user->id)
            ->with(['items.itemable'])
            ->findOrFail($id);

        // Pastikan file view ini tersedia
        return view('orders.show', compact('order'));
    }

    // Opsional: jika kamu ingin fitur batal pesanan & cetak invoice, tambahkan method cancel() dan invoice()
}
