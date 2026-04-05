<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }
    
        if (Auth::user()->role !== 'seller') {
            abort(403, 'Kamu tidak punya akses ke halaman admin.');
        }
        return view('seller.dashboard');
    }
}
