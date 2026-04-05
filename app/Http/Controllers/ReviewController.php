<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        try {
            Review::create($request->all());

            // Redirect ke route home.order dengan session success
            return redirect()->route('home.order')->with('success_review', 'Review berhasil dikirim.');
        } catch (\Exception $e) {
            // Jika terjadi error, kirim session error
            return redirect()->route('home.order')->with('error_review', 'Gagal mengirim review. Silakan coba lagi.');
        }
    }
}
