<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Voucher;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function applyVoucher(Request $request)
{
    $request->validate([
        'voucher_code' => 'required|string'
    ]);

    $user = Auth::user();
    $voucher = Voucher::where('code', $request->voucher_code)->first();

    // Validasi voucher aktif dan belum kadaluarsa
    if (!$voucher || !$voucher->is_active || ($voucher->expires_at && $voucher->expires_at < now())) {
        return redirect()->route('checkout.index')->withErrors(['Voucher tidak valid atau sudah kadaluarsa.']);
    }

    // Validasi penggunaan user (max per user)
    $userVoucher = DB::table('user_voucher')
        ->where('user_id', $user->id)
        ->where('voucher_id', $voucher->id)
        ->first();

    if ($userVoucher) {
        if ($userVoucher->usage_count >= $voucher->max_usage_per_user) {
            return redirect()->route('checkout.index')->withErrors([
                'Voucher sudah digunakan maksimal ' . $voucher->max_usage_per_user . ' kali.'
            ]);
        }

        DB::table('user_voucher')
            ->where('user_id', $user->id)
            ->where('voucher_id', $voucher->id)
            ->update([
                'usage_count' => $userVoucher->usage_count + 1,
                'updated_at' => now(),
            ]);
    } else {
        DB::table('user_voucher')->insert([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'usage_count' => 1,
            'assigned_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Simpan voucher ke session agar bisa dipakai di checkout
    session([
        'applied_voucher' => [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'discount_type' => $voucher->discount_type,
            'discount_value' => $voucher->discount_value,
        ]
    ]);

    // Simpan juga code voucher terakhir digunakan untuk menjaga pilihan tetap tersimpan di <select>
    session(['last_applied_voucher_code' => $voucher->code]);

    return redirect()->route('checkout.index')->with('success', 'Voucher berhasil digunakan.');
}




    public function showUserOrders()
    {
        $users = \App\Models\User::withCount(['orders' => function ($query) {
            $query->where('payment_status', 'paid');
        }])->get();
    
        return view('admin.userorder', compact('users'));
    }
    
    




    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'resi' => 'nullable|string|max:255',
        ]);
    
        $order = Order::findOrFail($id);
        $order->resi = $request->resi;
        $order->save();
    
        return redirect()->back()->with('success', 'Resi updated successfully.');
    }
    public function index()
    {
        // Ambil semua pesanan dengan relasi ke orderItems, produk, dan user
        $orders = Order::with('orderItems.product', 'user')->paginate(10); // Menampilkan 10 pesanan per halaman
        
        // Ambil semua kategori untuk menampilkan pada sidebar atau filter (jika ada)
        $categories = Category::all(); 
    
        // Mengembalikan tampilan 'orders.index' dengan data orders dan categories
        return view('orders.index', compact('orders', 'categories'));
    }
    
 // Fungsi untuk memperbarui status order
 public function updateStatus(Request $request, Order $order)
 {
     // Validasi input status
     $validated = $request->validate([
         'status' => 'required|in:pending,accepted,processing,shipped,completed',
     ]);

     // Update status order
     $order->status = $request->status;
     $order->save();

     // Redirect kembali ke halaman daftar order dengan pesan sukses
     return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
 }

 public function cancel($id)
 {
     $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
 
     // Kembalikan stok produk
     foreach ($order->orderItems as $item) {
         $product = $item->product;
         if ($product) {
             $product->stock += $item->quantity;
             $product->save();
         }
     }
 
     // Hapus order items dan order
     $order->orderItems()->delete();
     $order->delete();
 
     return redirect()->route('home.order')->with('success', 'Order berhasil dibatalkan.');
 }


    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
         
        return redirect()->route('orders.index')
                         ->with('success', 'Product deleted successfully');
    }
    


    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id); // Pastikan relasi user dimuat
        return view('orders.show', compact('order'));
    }
    public function paymentDetails($id)
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
    $order = Order::findOrFail($id);

 $categories = Category::all(); 
 $userId = Auth::id(); // Menggunakan Auth Facade untuk mendapatkan user ID
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        $cartItemsCount = $cartItems->count();
    // Pastikan status pembayaran adalah 'paid'
    if ($order->payment_status != 'paid') {
        return redirect()->route('orders.index')->with('error', 'Pembayaran belum berhasil.');
    }

    // Tampilkan halaman detail pembayaran
    return view('orders.payment_details', compact('order','categories','cartItemsCount','userId','cartItems','wishlistItems','biggestDiscount'));
}
    
}
