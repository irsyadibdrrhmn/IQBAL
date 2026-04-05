<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    //bundle
    public function addBundleToCart(Request $request)
    {
        $request->validate([
            'bundle_id' => 'required|exists:bundles,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user_id = Auth::id(); // ambil ID user yang sedang login

        // Cek apakah bundling ini sudah ada di cart user
        $cartItem = Cart::where('user_id', $user_id)
            ->where('bundle_id', $request->bundle_id)
            ->first();

        if ($cartItem) {
            // Jika sudah ada, update jumlahnya
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Jika belum, buat item baru di cart
            Cart::create([
                'user_id' => $user_id,
                'bundle_id' => $request->bundle_id,
                'quantity' => $request->quantity,
                'product_id' => null, // Karena ini item bundling
            ]);
        }

        return redirect()->back()->with('success', 'Bundling berhasil ditambahkan ke keranjang.');
    }
    //endbundle

    public function index()
    {
         if (!Auth::check()) {
        return redirect()->route('login.form');
    }
        $user = Auth::user();
        $biggestDiscount = Discount::where('status', 'active')
            ->with('product')
            ->get()
            ->sortByDesc(function ($discount) {
                return $discount->calculated_final_price;
            })
            ->first();
        // Ambil wishlist milik user (jika login)
        $wishlistItems = [];
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::with('product')
                ->where('user_id', $user->id)
                ->get();
        }
        $userId = Auth::id(); // Mendapatkan user ID dari pengguna yang login menggunakan Auth Facade
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        $categories = Category::all();
        $recommendedProducts = Product::inRandomOrder()->limit(4)->get();
        $cartItemsCount = $cartItems->count();
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });
        $products = Product::all();

        return view('cart.index', compact(
            'cartItems',
            'categories',
            'recommendedProducts',
            'cartItemsCount',
            'totalPrice',
            'products',
            'wishlistItems',
            'biggestDiscount'
        ));
    }
    public function store(Request $request)
    {
        // Cek apakah user sudah login menggunakan Auth Facade
        if (!Auth::check()) {
            return redirect()->route('home.index')->with('error', 'Anda harus login terlebih dahulu untuk menambahkan produk ke keranjang.');
        }

        $userId = Auth::id(); // Mendapatkan user ID dari pengguna yang login menggunakan Auth Facade
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Periksa apakah produk sudah ada di keranjang
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Jika produk sudah ada di keranjang, tambahkan kuantitasnya
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Jika produk belum ada di keranjang, tambahkan sebagai item baru
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|integer|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = \App\Models\Cart::findOrFail($request->cart_id);
        $product = $cart->product; // Pastikan relasi ke Product sudah ada di model Cart

        // Cek stok produk
        if ($request->quantity > $product->stock) {
            return back()->with('error_cart', 'Jumlah yang dimasukkan melebihi stok yang tersedia (' . $product->stock . ').');
        }

        // Update quantity
        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('success_cart', 'Keranjang berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cartItem = Cart::find($request->cart_id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
