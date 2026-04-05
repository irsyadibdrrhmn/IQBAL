<?php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Menambah produk ke wishlist
    public function add($id)
    {
        $user = Auth::user();

        // Cek apakah produk sudah ada di wishlist user
        $existing = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $id)
                            ->first();

        if ($existing) {
            return back()->with('info', 'Produk sudah ada di wishlist Anda.');
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $id,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke wishlist.');
    }
    // Menghapus produk dari wishlist
    public function removeFromWishlist($productId)
{
    // Pastikan pengguna terautentikasi
    if (!Auth::check()) {
        return redirect()->route('login')->withErrors('Anda harus login untuk menghapus produk dari wishlist.');
    }

    // Cek apakah produk ada di wishlist pengguna
    $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->first();

    if (!$wishlist) {
        return back()->withErrors('Produk tidak ditemukan di wishlist Anda.');
    }

    // Menghapus produk dari wishlist
    $wishlist->delete();

    return back()->with('success', 'Produk berhasil dihapus dari wishlist.');
}


    // Menampilkan wishlist pengguna
    public function index()
{
    $user = Auth::user();

    // Ambil data wishlist user
    $wishlists = \App\Models\Wishlist::with('product')
        ->where('user_id', Auth::id())
        ->paginate(10);

    // Ambil diskon terbesar
    $biggestDiscount = \App\Models\Discount::where('status', 'active')
        ->with('product')
        ->get()
        ->sortByDesc(function ($discount) {
            return $discount->calculated_final_price;
        })
        ->first();

    // Ambil wishlist user (untuk badge atau ikon love)
    $wishlistItems = [];
    if ($user) {
        $wishlistItems = \App\Models\Wishlist::with('product')
            ->where('user_id', $user->id)
            ->get();
    }

    // Ambil data keranjang
    $cartItems = \App\Models\Cart::where('user_id', Auth::id())->get();
    $cartItemsCount = $cartItems->count();
    $totalPrice = $cartItems->sum(function ($cartItem) {
        return $cartItem->quantity * $cartItem->product->price;
    });
      $categories = \App\Models\Category::all();
    

    // Kirim semua data ke view
    return view('wishlist.index', compact(
        'wishlists',
        'wishlistItems',
        'cartItemsCount',
        'cartItems',
        'totalPrice',
        'biggestDiscount',
        'categories',
        'user'
    ));
}

}
