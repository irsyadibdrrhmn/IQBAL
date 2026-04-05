<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('banners.index', compact('banners'));
    }

    public function create()
    {
        return view('banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'image'           => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'     => 'nullable|string',
            'discount_amount' => 'nullable|numeric',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'name'            => $request->name,
            'image'           => $imagePath,
            'description'     => $request->description,
            'discount_amount' => $request->discount_amount,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'     => 'nullable|string',
            'discount_amount' => 'nullable|numeric',
        ]);

        $data = $request->only('name', 'description', 'discount_amount');

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner berhasil dihapus.');
    }
}
