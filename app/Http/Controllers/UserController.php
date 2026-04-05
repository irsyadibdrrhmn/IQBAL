<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cart;


class UserController extends Controller
{


    public function index()
    {
        // Ambil semua data user
        $users = User::all();

        // Kirim data user ke view
        return view('user.index', compact('users'));
    }


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
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $cartItemsCount = $cartItems->count();
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        $products = Product::query()->get();

        return view('home.profil.index', compact(
            'user',
            'categories',
            'products',
            'cartItems',
            'cartItemsCount',
            'totalPrice',
            'wishlistItems'
        ));
    }

    public function edit()
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




        $categories = Category::all();
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $cartItemsCount = $cartItems->count();
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        $products = Product::query()->get();
        return view('home.profil.edit', compact('user',
        'categories',
        'products',
        'cartItems',
        'cartItemsCount',
        'totalPrice','wishlistItems','biggestDiscount'));
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
    return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
}

    
    



























    // Menampilkan detail pengguna berdasarkan user_id
    public function show(User $user)
    {
        return view('user.show', compact('user'));  // Kirim data pengguna ke view
    }

    // Menghapus pengguna berdasarkan user_id
    public function destroy(User $user)
    {
        // Hapus data user
        $user->delete();

        // Redirect kembali ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
    public function register()
    {
        $data['title'] = 'Register';
        return view('user.register.customer', $data);
    }


    public function registerAdmin()
    {
        $data['title'] = 'Register';
        return view('user.register.admin', $data);
    }
    public function registerOwner()
    {
        $data['title'] = 'Register';
        return view('user.register.owner', $data);
    }

    public function register_action(Request $request)
    {
        $request->validate([
            // 'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:customer,owner,admin',
            'username' => 'required|unique:tb_user',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
        ]);

        // // Handle image upload, storing it in the public directory
        // $imageName = time() . '.' . $request->image->extension();
        // $request->image->move(public_path('images'), $imageName); // Save to public/images

        // Create a new user with image path
        $user = new User([
            // 'name' => $request->name,
            'email' => $request->email,      // <--- tambahkan ini
            'role' => $request->role,        // <--- dan ini
            'username' => $request->username,
            'password' => Hash::make($request->password),
            // 'image' => 'images/' . $imageName,
        ]);
// dd($user);
        $user->save();

        return redirect()->route('home.index')->with('success', 'Registration successful. Please login!');
    }


    public function login()
    {
        $data['title'] = 'Login';
        return view('user/login', $data);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();
    
            // Get the authenticated user
            $user = Auth::user();
    
            // Flash success message
            session()->flash('success', 'Login berhasil! Selamat datang, ' . $user->name);
    
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.index');
                case 'owner':
                    return redirect()->route('transaksi.laporan');
                case 'customer':
                    return redirect()->route('home.index');
                default:
                    return redirect()->route('home');
            }
        }
    
        // Jika gagal login, kembalikan dengan flash error
        return back()->with('error', 'Email atau password salah.');
    }
    

    public function password()
    {
        $data['title'] = 'Change Password';
        return view('user/password', $data);
    }

    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return back()->with('success', 'Password changed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
