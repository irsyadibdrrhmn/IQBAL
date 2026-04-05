<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WilayahController;
use Illuminate\Http\Request;

// ======================== AUTH ========================
Route::get('/register/customer', [AuthController::class, 'register_customer'])->name('register.customer');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.action');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.action');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::resource('users', AuthController::class);
Route::get('/admin/users', [AuthController::class, 'index'])->name('admin.users.index');

// ======================== HOME ========================
Route::get('/', [CustomerController::class, 'index'])->name('home.index');
Route::get('/store', [HomeController::class, 'store'])->name('user.store');
Route::get('/category/{id}', [HomeController::class, 'show'])->name('home.category');
Route::get('detail/{product}', [HomeController::class, 'detail'])->name('detail');
Route::get('/order/user', [HomeController::class, 'order'])->name('home.order');

// ======================== DASHBOARD ========================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
});

// ======================== ADMIN PROFILE ========================
Route::get('/profil/admin', [AdminController::class, 'profil'])->name('profil.admin');
Route::get('/profil/edit/admin', [AdminController::class, 'edit'])->name('profil.edit.admin');
Route::post('/profil/update/admin', [AdminController::class, 'update'])->name('profil.update.admin');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

// ======================== USER PROFILE ========================
Route::get('/profil', [UserController::class, 'profil'])->name('profil');
Route::get('/profil/edit', [UserController::class, 'edit'])->name('profil.edit');
Route::post('/profil/update', [UserController::class, 'update'])->name('profil.update');

// ======================== PRODUCTS ========================
Route::resource('products', ProductController::class);
Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
Route::get('/products/send-email/{id}', [ProductController::class, 'emailForm'])->name('products.send.email');
Route::post('product/store-email', [ProductController::class, 'storeEmail'])->name('product.storeEmail');
Route::get('/product/data', [ProductController::class, 'showProductData'])->name('product.data');

// ======================== CATEGORIES ========================
Route::resource('categories', CategoryController::class);
Route::get('/categories.index', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// ======================== DISCOUNTS ========================
Route::resource('discounts', DiscountController::class);
Route::patch('discounts/{id}/toggle', [DiscountController::class, 'toggle'])->name('discounts.toggle');

// ======================== VOUCHERS ========================
Route::resource('vouchers', VoucherController::class);
Route::patch('/admin/vouchers/{voucher}/toggle', [VoucherController::class, 'toggleStatus'])->name('vouchers.toggle');


// ======================== BANNERS ========================
Route::resource('banners', BannerController::class);

// ======================== ORDERS ========================
Route::resource('orders', OrderController::class);
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::put('/orders/update-resi/{order}', [OrderController::class, 'updateResi'])->name('orders.updateResi');
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::put('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
Route::delete('/order/{order}/home', [OrderController::class, 'cancel'])->name('orders.destroy.home');
Route::get('/order/{id}/details', [OrderController::class, 'paymentDetails'])->name('orders.details');
Route::get('/order', [AdminController::class, 'order'])->name('order');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/user-orders', [OrderController::class, 'showUserOrders'])->name('admin.userorders');
});
Route::post('/order/apply-voucher', [OrderController::class, 'applyVoucher'])->name('order.applyVoucher');

// ======================== CHECKOUT ========================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/selected', [CheckoutController::class, 'selected'])->name('checkout.selected');
Route::get('/chekout', [CheckoutController::class, 'index'])->name('chekout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/ongkir', [CheckoutController::class, 'ongkir_index'])->name('ongkir.index');
Route::post('/cek-ongkir', [CheckoutController::class, 'cekOngkir'])->name('cek-ongkir');
Route::post('save-ongkir', [CheckoutController::class, 'saveOngkir'])->name('save-ongkir');
Route::post('/ongkir/set-session', [CheckoutController::class, 'setSession'])->name('ongkir.setSession');

// ======================== CART ========================

    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/delete', [CartController::class, 'destroy'])->name('cart.delete');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');

// ======================== WISHLIST ========================
// Tanpa middleware auth
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/{productId}/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

// ======================== CHAT ========================
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::get('/chat/messages/{user}', [ChatController::class, 'fetchMessages'])->name('chat.fetchMessages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('send.message');
    Route::post('/chat/read-messages/{userId}', [ChatController::class, 'markAsRead'])->name('chat.markAsRead');
});

// ======================== REVIEW ========================
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// ======================== MIDTRANS PAYMENT ========================
Route::post('payment/{id}/pay', [MidtransController::class, 'pay'])->name('payment.proses');
Route::get('/orders/finish/{id}', [MidtransController::class, 'finish'])->name('orders.finish');

// ======================== SALES REPORT ========================
Route::get('/sales-report', [AdminController::class, 'salesReport'])->name('sales.report');
Route::get('/admin/sales-report/print', [AdminController::class, 'print'])->name('sales.print');
Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('riwayat.index');


//wilayah 
Route::prefix('wilayah')->group(function () {
    Route::get('/provinsi', [WilayahController::class, 'provinsi']);
    Route::get('/kabupaten/{provinsiId}', [WilayahController::class, 'kabupaten']);
    Route::get('/kecamatan/{kabupatenId}', [WilayahController::class, 'kecamatan']);
    Route::get('/desa/{kecamatanId}', [WilayahController::class, 'desa']);
});

//ongkir
Route::post('/set-ongkir', function (Request $request) {
    $cost = (int) $request->input('cost', 0);

    // Simpan ke session Laravel
    session(['ongkir.cost' => $cost]);

    return response()->json([
        'success' => true,
        'message' => 'Ongkir disimpan ke session.',
        'cost' => $cost,
    ]);
})->name('setOngkir');


Route::get('/get-ongkir', function () {
    return response()->json([
        'cost' => session('ongkir.cost', 0),
    ]);
})->name('getOngkir');


//notifikasi order
Route::get('/admin/check-new-orders', function () {
    $count = \App\Models\Order::where('status', 'pending')->count();

    return response()->json([
        "count" => $count
    ]);
});


