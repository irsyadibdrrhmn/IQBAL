<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Cart;

use App\Models\Banner;




class CustomerController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        if (Auth::user()->role !== 'customer') {
            abort(403, 'Kamu tidak punya akses ke halaman admin.');
        }
        return view('customer.dashboard');
    }


    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            abort(403, 'Admin tidak punya akses ke halaman ini.');
        }
        // Ambil data banner
        $banners = Banner::all();

        // Initialize products variable
        $products = Product::query();

        // Filter berdasarkan pencarian
        if ($request->has('search_query') && !empty($request->search_query)) {
            $searchQuery = $request->search_query;
            $products = $products->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->has('category_id') && !empty($request->category_id)) {
            $products = $products->where('category_id', $request->category_id);
        }

        // Pagination
        $products = $products->paginate(12);

        // Ambil kategori & user
        $categories = Category::take(4)->get();
        $user = Auth::user();

        // Ambil wishlist milik user (jika login)
        $wishlistItems = [];
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::with('product')
                ->where('user_id', $user->id)
                ->get();
        }

        // Ambil 3 produk diskon untuk ditampilkan
        $featuredProduct = Product::whereHas('discount', function ($query) {
            $query->where('status', 'active');
        })
            ->with('discount')
            ->take(3)
            ->get();

        // Ambil diskon terbesar
        $biggestDiscount = Discount::where('status', 'active')
            ->with('product')
            ->get()
            ->sortByDesc(function ($discount) {
                return $discount->calculated_final_price;
            })
            ->first();

        // Ambil cart
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $cartItemsCount = $cartItems->count();

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product ? $cartItem->quantity * $cartItem->product->price : 0;
        });

        return view('customer.home', compact(
            'categories',
            'products',
            'featuredProduct',
            'user',
            'biggestDiscount',
            'cartItems',
            'cartItemsCount',
            'totalPrice',
            'wishlistItems', // <-- ini ditambahkan
            'banners'
        ));
    }




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
        $user = Auth::user();
        $wishlistItems = [];
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::with('product')
                ->where('user_id', $user->id)
                ->get();
        }
        $biggestDiscount = Discount::where('status', 'active')
            ->with('product')
            ->get()
            ->sortByDesc(function ($discount) {
                return $discount->calculated_final_price;
            })
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



        return view('home.category', compact('category', 'products', 'categories', 'cartItems', 'cartItemsCount', 'totalPrice', 'biggestDiscount', 'wishlistItems'));
    }
}
