<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Review;
use App\Models\Discount;
use App\Models\Bundle;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Http\Response
     */

   

    public function checkout()
    {
        $data['title'] = 'Register';
        $categories = Category::all();
        $user = Auth::user();

        $products = Product::all();
        return view('home.checkout', compact('categories', 'data', 'products', 'user')); // Pastikan Anda memiliki view home.index
    }

    public function show($id)
    {
        $wishlistItems = [];
    
        if (Auth::check()) {
            $wishlistItems = \App\Models\Wishlist::with('product')
                ->where('user_id', Auth::id())
                ->get();
        }
    
        $biggestDiscount = Discount::where('status', 'active')
            ->with('product')
            ->get()
            ->sortByDesc(fn($discount) => $discount->calculated_final_price)
            ->first();
    
        $category = Category::findOrFail($id);
        $categories = Category::all();
        $products = Product::where('category_id', $id)->get();
    
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $cartItemsCount = $cartItems->count();
    
        $totalPrice = $cartItems->sum(function ($cartItem) {
            if ($cartItem->product) {
                return $cartItem->quantity * $cartItem->product->price;
            } elseif ($cartItem->bundle) {
                return $cartItem->quantity * $cartItem->bundle->price;
            }
            return 0;
        });
    
        return view('home.category', compact(
            'category',
            'products',
            'categories',
            'cartItems',
            'cartItemsCount',
            'totalPrice',
            'biggestDiscount',
            'wishlistItems'
        ));
    }


    public function store()
    {
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
        
        // Ambil semua kategori dengan jumlah produk masing-masing
        $categories = Category::withCount('products')->get();
    
        // Ambil item keranjang user
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $cartItemsCount = $cartItems->count();
        $totalPrice = $cartItems->sum(function ($cartItem) {
            if ($cartItem->product) {
                return $cartItem->quantity * $cartItem->product->price;
            } elseif ($cartItem->bundle) {
                return $cartItem->quantity * $cartItem->bundle->price;
            }
            return 0;
        });
    
        // Ambil semua produk beserta relasi category dan orderItems
        $allProducts = Product::with('category', 'orderItems')->get();
    
        // Hitung produk terlaris berdasarkan jumlah orderItems
        $topSellingProducts = $allProducts->sortByDesc(function ($product) {
            return $product->orderItems->sum('quantity');
        })->take(5);
    
        return view('home.store', compact(
            'categories',
            'user',
            'cartItems',
            'cartItemsCount',
            'totalPrice',
            'allProducts', // gunakan variabel ini di view sebagai $allProducts
            'topSellingProducts',
            'wishlistItems',
            'biggestDiscount'
            
        ));
    }
    

    public function detail(Product $product): View
    {
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

        // Initialize products variable
        $products = Product::query();
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $cartItemsCount = $cartItems->count();
        $categories = Category::all();
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });
        $reviews = Review::where('product_id', $product->id)->paginate(5);
        $averageRating = $reviews->avg('rating');
        $totalReviews = $reviews->count();
        // Ambil produk terkait berdasarkan kategori
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4) // Batasi jumlah produk terkait
            ->get();


        return view(
            'home.detail',
            compact(
                'categories',
                'product',
                'products',
                'cartItemsCount',
                'cartItems',
                'totalPrice',
                'reviews',
                'averageRating',
                'totalReviews',
                'relatedProducts',
                'wishlistItems',
                'biggestDiscount'
            )
        );
    }

public function order()
{
    $user = Auth::user();

    // Jika belum login, redirect ke halaman login
    if (!$user) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melihat pesanan Anda.');
    }

    // Ambil diskon aktif dengan harga akhir terbesar
    $biggestDiscount = Discount::where('status', 'active')
        ->with('product')
        ->get()
        ->sortByDesc(function ($discount) {
            return $discount->calculated_final_price;
        })
        ->first();

    // Ambil wishlist milik user
    $wishlistItems = Wishlist::with('product')
        ->where('user_id', $user->id)
        ->get();

    // Ambil cart milik user
    $cartItems = Cart::where('user_id', $user->id)
        ->with('product')
        ->get();

    $cartItemsCount = $cartItems->count();

    $totalPrice = $cartItems->sum(function ($cartItem) {
        return $cartItem->quantity * $cartItem->product->price;
    });

    // Ambil semua produk & kategori
    $products = Product::all();
    $categories = Category::all();

    // Ambil hanya order milik user yang login
    $orders = Order::where('user_id', $user->id)
        ->with(['orderItems.product']) // jika ada relasi
        ->latest()
        ->get();

    return view('home.order', compact(
        'orders',
        'categories',
        'user',
        'biggestDiscount',
        'cartItems',
        'cartItemsCount',
        'totalPrice',
        'products',
        'wishlistItems'
    ));
}


    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('home.order')
            ->with('success', 'Product deleted successfully');
    }
}
