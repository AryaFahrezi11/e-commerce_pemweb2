<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use \Binafy\LaravelCart\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->guard('customer')->user();

        if (!$user) {
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cart = Cart::where('user_id', $user->id)->with('items.itemable')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        return view('theme.default.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $user = auth()->guard('customer')->user();

        if (!$user) {
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'name'            => 'required|string|max:100',
            'phone'           => 'required|string|max:20',
            'address'         => 'required|string|max:255',
            'city'            => 'required|string|max:100',
            'province'        => 'required|string|max:100',
            'postal_code'     => 'required|string|max:20',
            'note'            => 'nullable|string',
            'payment_method'  => 'required|in:COD,Transfer',
            'bank_name'       => 'nullable|string|max:100',
            'account_number'  => 'nullable|string|max:100',
        ]);

        $cart = Cart::where('user_id', $user->id)->with('items.itemable')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        DB::beginTransaction();

        try {
            $subtotal = $cart->calculatedPriceByQuantity();
            $shippingCost = $subtotal >= 50000 ? 0 : 5000;
            $total = $subtotal + $shippingCost;

            $order = Order::create([
                'customer_id'    => $user->id,
                'name'           => $request->name,
                'phone'          => $request->phone,
                'address'        => $request->address . ', ' . $request->city . ', ' . $request->province . ', ' . $request->postal_code,
                'notes'          => $request->note ?? null,
                'payment_method' => $request->payment_method,
                'bank_name'      => $request->bank_name ?? null,
                'account_number' => $request->account_number ?? null,
                'subtotal'       => $subtotal,
                'shipping_cost'  => $shippingCost,
                'total'          => $total,
                'status'         => 'pending'
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->itemable->id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->itemable->price,
                    'total'      => $item->itemable->price * $item->quantity
                ]);
            }

            // Kosongkan keranjang
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
