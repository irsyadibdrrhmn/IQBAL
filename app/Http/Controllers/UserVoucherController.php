<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserVoucherController extends Controller
{
    public function index()
    {
        $vouchers = Auth::user()->vouchers()->withPivot('assigned_at', 'used_at')->get();

        return view('customer.vouchers.index', compact('vouchers'));
    }
}
