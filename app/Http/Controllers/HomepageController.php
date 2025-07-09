<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Theme;
use Binafy\LaravelCart\Models\Cart;

class HomepageController extends Controller
{
    private $themeFolder;

    public function __construct()
    {
        $theme = Theme::where('status', 'active')->first();
        $this->themeFolder = $theme ? $theme->folder : 'default';
    }

    // Beranda
    public function index()
    {
        $categories = Categories::latest()->take(4)->get();
        $products = Product::where('is_active', true)->latest()->take(20)->get();

        return view("theme.{$this->themeFolder}.homepage", [
            'title' => 'Homepage',
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    // Halaman daftar produk
    public function products(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(20);

        return view("theme.{$this->themeFolder}.products", [
            'title' => 'Produk',
            'products' => $products,
        ]);
    }

    // Halaman detail produk
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view("theme.{$this->themeFolder}.product", [
            'title' => $product->name,
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    // Halaman daftar kategori
    public function categories()
    {
        $categories = Categories::latest()->paginate(20);

        return view("theme.{$this->themeFolder}.categories", [
            'title' => 'Kategori',
            'categories' => $categories,
        ]);
    }

    // Halaman produk per kategori
    public function category($slug)
    {
        $category = Categories::where('slug', $slug)->firstOrFail();

        $products = Product::where('product_category_id', $category->id)
            ->where('is_active', true)
            ->paginate(20);

        return view("theme.{$this->themeFolder}.category_by_slug", [
            'title' => "Kategori: {$category->name}",
            'category' => $category,
            'products' => $products,
        ]);
    }

    // Halaman keranjang
    public function cart()
    {
        $user = auth()->guard('customer')->user();

        if (!$user) {
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu untuk melihat keranjang.');
        }

        $cart = Cart::with(['items', 'items.itemable'])
            ->where('user_id', $user->id)
            ->first();

        return view("theme.{$this->themeFolder}.cart", [
            'title' => 'Keranjang',
            'cart' => $cart,
        ]);
    }

    // Halaman checkout
    public function checkout()
    {
        return view("theme.{$this->themeFolder}.checkout", [
            'title' => 'Checkout'
        ]);
    }
}
