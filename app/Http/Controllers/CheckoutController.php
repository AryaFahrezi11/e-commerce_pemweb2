<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use \Binafy\LaravelCart\Models\Cart;
use Carbon\Carbon;

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

        // Validasi input form
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:COD,Transfer',
            'bank_name' => 'required_if:payment_method,Transfer|nullable|string|max:100',
            'account_number' => 'required_if:payment_method,Transfer|nullable|string|max:100',
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
                'customer_id' => $user->id,
                'order_date' => Carbon::now(),
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => "{$validated['address']}, {$validated['city']}, {$validated['province']}, {$validated['postal_code']}",
                'note' => $validated['note'] ?? null,
                'payment_method' => $validated['payment_method'],
                'bank_name' => $validated['payment_method'] === 'Transfer' ? $validated['bank_name'] : null,
                'account_number' => $validated['payment_method'] === 'Transfer' ? $validated['account_number'] : null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total, // ganti ke 'total' jika di database field-nya seperti itu
                'status' => 'pending',
            ]);

            // Simpan item pesanan
            foreach ($cart->items as $item) {
                if (!$item->itemable || !isset($item->product->id)) {
                    throw new \Exception("Produk tidak ditemukan atau tidak valid di keranjang.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->itemable->id,
                    'quantity' => $item->quantity,
                    'price' => $item->itemable->price,
                    'total' => $item->itemable->price * $item->quantity
                ]);
            }


            // Hapus isi keranjang
            $cart->items()->delete();

            DB::commit();

            return redirect('/my-orders')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}