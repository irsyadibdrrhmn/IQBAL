<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }
    
      
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalOrder = Order::sum('total');
      
       
      
        $totalUsers = User::count();
        $orders = Order::with('orderItems.product', 'user')->paginate(10);
        $topCustomers = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.payment_status', 'paid')
        ->select('users.name', DB::raw('COUNT(orders.id) as total_orders'), DB::raw('SUM(orders.total) as total_spent'))
        ->groupBy('users.name')
        ->orderByDesc('total_orders')
        ->limit(5)
        ->get();
    
        return view('admin.dashboard',compact('orders','topCustomers','totalProducts',
        'totalOrders',
       'totalOrder',
        'totalUsers'));
    }

    
    public function print(Request $request)
    {
        $period = $request->input('period', 'daily');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $productQuery = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name as item_name')
            ->selectRaw('SUM(order_items.quantity) as total_quantity_sold')
            ->selectRaw('SUM(order_items.quantity * order_items.price) as total_revenue');
    
        if ($period == 'daily') {
            $productQuery->selectRaw('DATE(orders.created_at) as period')
                         ->groupByRaw('DATE(orders.created_at), products.name');
        } elseif ($period == 'monthly') {
            $productQuery->selectRaw('DATE_FORMAT(orders.created_at, "%Y-%m") as period')
                         ->groupByRaw('DATE_FORMAT(orders.created_at, "%Y-%m"), products.name');
        } elseif ($period == 'yearly') {
            $productQuery->selectRaw('YEAR(orders.created_at) as period')
                         ->groupByRaw('YEAR(orders.created_at), products.name');
        }
    
        if ($startDate && $endDate) {
            $productQuery->whereBetween('orders.created_at', [$startDate, $endDate]);
        }
    
        $sales = $productQuery->orderByDesc('period')->get();
    
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalOrder = Order::sum('total');
    
        $topProducts = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    
        $topCustomers = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('COUNT(orders.id) as total_orders'), DB::raw('SUM(orders.total) as total_spent'))
            ->groupBy('users.name')
            ->orderByDesc('total_orders')
            ->limit(5)
            ->get();
    
        return view('admin.sales_report_print', compact(
            'sales', 'totalProducts', 'totalOrders', 'totalOrder',
            'period', 'startDate', 'endDate',
            'topProducts', 'topCustomers'
        ));
    }
    public function salesReport(Request $request)
{
    $orders = Order::with('orderItems.product', 'user')->paginate(10);
    $totalProducts = Product::count();
    $totalOrders = Order::where('payment_status', 'paid')->count();
    $totalOrder = Order::where('payment_status', 'paid')->sum('total');

    $period = $request->input('period', 'daily');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $productQuery = Order::where('payment_status', 'paid')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('products.name as item_name')
        ->selectRaw('SUM(order_items.quantity) as total_quantity_sold')
        ->selectRaw('SUM(order_items.quantity * order_items.price) as total_revenue');

    if ($period == 'daily') {
        $productQuery->selectRaw('DATE(orders.created_at) as period')
                     ->groupByRaw('DATE(orders.created_at), products.name');
    } elseif ($period == 'monthly') {
        $productQuery->selectRaw('DATE_FORMAT(orders.created_at, "%Y-%m") as period')
                     ->groupByRaw('DATE_FORMAT(orders.created_at, "%Y-%m"), products.name');
    } elseif ($period == 'yearly') {
        $productQuery->selectRaw('YEAR(orders.created_at) as period')
                     ->groupByRaw('YEAR(orders.created_at), products.name');
    }

    if ($startDate && $endDate) {
        $productQuery->whereBetween('orders.created_at', [$startDate, $endDate]);
    }

    $sales = $productQuery->orderByDesc('period')->get();

    $topProducts = DB::table('order_items')
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->join('products', 'products.id', '=', 'order_items.product_id')
        ->where('orders.payment_status', 'paid')
        ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
        ->groupBy('products.name')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();

    $topCustomers = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.payment_status', 'paid')
        ->select('users.name', DB::raw('COUNT(orders.id) as total_orders'), DB::raw('SUM(orders.total) as total_spent'))
        ->groupBy('users.name')
        ->orderByDesc('total_orders')
        ->limit(5)
        ->get();

    return view('admin.sales_report', compact(
        'sales', 'totalProducts', 'totalOrders',
        'totalOrder', 'period', 'startDate', 'endDate',
        'topProducts', 'topCustomers', 'orders'
    ));
}


public function riwayat()
{
    // Ambil semua pesanan dengan relasi ke orderItems, produk, dan user
    $orders = Order::with('orderItems.product', 'user')->paginate(10); // Menampilkan 10 pesanan per halaman

    // Ambil semua kategori untuk menampilkan pada sidebar atau filter (jika ada)
    $categories = Category::all(); 

    // Mengembalikan tampilan 'riwayat.index' dengan data orders dan categories saja
    return view('riwayat.index', compact('orders', 'categories'));
}




// profil


public function profil()
    {
        // hanya ambil user yang sedang login
        $user = Auth::user();
       
    
        // Ambil wishlist milik user (jika login)
        $wishlistItems = [];
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::with('product')
                ->where('user_id', $user->id)
                ->get();
        }


        $categories = Category::all();
    
    

        $products = Product::query()->get();

        return view('admin.profil.index', compact(
            'user',
            'categories',
            'products',
           
            'wishlistItems'
        ));
    }

    public function edit()
    {

        $user = Auth::user();
       
    
        // Ambil wishlist milik user (jika login)
        $wishlistItems = [];
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::with('product')
                ->where('user_id', $user->id)
                ->get();
        }




        $categories = Category::all();
       

        $products = Product::query()->get();
        return view('admin.profil.edit', compact('user',
        'categories',
        'products'
        ,'wishlistItems'));
    }

    public function update(Request $request)
{
    // Ambil user yang sedang login
    $user = Auth::user();

    // Validasi input dari request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'nomor_telpon' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
    ]);

    // Update data dasar user
    $user->name = $request->name;
    $user->email = $request->email;
    $user->nomor_telpon = $request->nomor_telpon;
    $user->alamat = $request->alamat;

    // Cek apakah ada gambar yang diupload
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }

        // Simpan gambar baru
        $imageName = time() . '.' . $request->image->extension();  // Membuat nama unik untuk gambar
        $request->image->move(public_path('images'), $imageName);  // Pindahkan gambar ke folder 'images'
        
        // Simpan path gambar ke database
        $user->image = 'images/' . $imageName;
    }
 /** @var \App\Models\User $user */
    // Simpan perubahan data user
    $user->save();

    // Redirect ke halaman profil dengan pesan sukses
    return redirect()->route('profil.admin')->with('success', 'Profil berhasil diperbarui!');
}

  

    
}
