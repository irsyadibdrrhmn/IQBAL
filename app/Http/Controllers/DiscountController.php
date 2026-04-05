<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    // Tampilkan semua diskon
    public function index()
    {
        $discounts = Discount::with('product')->get();
        return view('discounts.index', compact('discounts'));
    }

    // Form create
    public function create()
    {
        $products = Product::all();
        return view('discounts.create', compact('products'));
    }

    // Simpan diskon baru
    public function store(Request $request)
    {
        $request->validate([
            'promo_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $product = Product::findOrFail($request->product_id);
        $discountValue = $request->discount_value;

        // Hitung harga diskon
        if ($request->discount_type == 'percent') {
            $finalPrice = $product->price - ($product->price * ($discountValue / 100));
        } else {
            $finalPrice = $product->price - $discountValue;
        }

        // Pastikan harga tidak negatif
        $finalPrice = max($finalPrice, 0);

        // Simpan diskon
        $discount = Discount::create([
            'promo_name' => $request->promo_name,
            'product_id' => $product->id,
            'discount_type' => $request->discount_type,
            'discount_value' => $discountValue,
            'final_price' => $finalPrice,
            'status' => $request->status,
        ]);

        // Jika diskon aktif, update harga produk
        if ($request->status === 'active') {
            $product->update(['price' => $finalPrice]);
        } else {
            // Jika diskon tidak aktif, pastikan harga tetap (atau restore harga asli jika disimpan sebelumnya)
            // Optional: kamu bisa simpan harga asli di kolom `original_price` di table `products`
        }

        return redirect()->route('discounts.index')->with('success', 'Discount created successfully!');
    }
    public function edit($id)
{
    $discount = Discount::findOrFail($id);
    $products = Product::all(); // Untuk dropdown product (kalau mau diganti)

    return view('discounts.edit', compact('discount', 'products'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'promo_name' => 'required|string|max:255',
        'product_id' => 'required|exists:products,id',
        'discount_type' => 'required|in:percent,fixed',
        'discount_value' => 'required|numeric|min:0',
        'status' => 'required|in:active,inactive',
    ]);

    $discount = Discount::findOrFail($id);
    $product = Product::findOrFail($request->product_id);
    $discountValue = $request->discount_value;

    // Hitung harga akhir
    if ($request->discount_type == 'percent') {
        $finalPrice = $product->price - ($product->price * ($discountValue / 100));
    } else {
        $finalPrice = $product->price - $discountValue;
    }

    $finalPrice = max($finalPrice, 0);

    // Update diskon
    $discount->update([
        'promo_name' => $request->promo_name,
        'product_id' => $product->id,
        'discount_type' => $request->discount_type,
        'discount_value' => $discountValue,
        'final_price' => $finalPrice,
        'status' => $request->status,
    ]);

    return redirect()->route('discounts.index')->with('success', 'Discount updated successfully!');
}
public function destroy($id)
{
    $discount = Discount::findOrFail($id);
    $discount->delete();

    return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully!');
}



public function toggle($id)
{
    $discount = Discount::findOrFail($id);
    $product = $discount->product;

    if ($discount->status === 'active') {
        // Ubah ke nonaktif → kembalikan harga asli produk
        $discount->status = 'inactive';
        $discount->final_price = $product->price;
    } else {
        // Aktifkan diskon → hitung harga setelah diskon
        $discount->status = 'active';

        if ($discount->discount_type === 'percent') {
            $discountAmount = ($discount->discount_value / 100) * $product->price;
            $discount->final_price = $product->price - $discountAmount;
        } else {
            $discount->final_price = $product->price - $discount->discount_value;
        }
    }

    $discount->save();

    return back()->with('success', 'Status diskon diperbarui!');
}


    // Tambahan: update, delete dll bisa menyusul
}
