<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $cartItems = Cart::where('user_id', auth()->id())->get();
        // $cartItemsCount = $cartItems->count();
        // $totalPrice = $cartItems->sum(function ($cartItem) {
        //     return $cartItem->quantity * $cartItem->product->price;
        // });
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $cartItems = Cart::where('user_id', auth()->id())->get();
        // $cartItemsCount = $cartItems->count();
        // $totalPrice = $cartItems->sum(function ($cartItem) {
        //     return $cartItem->quantity * $cartItem->product->price;
        // });
        $categories = Category::all();
        return view('categories.create',compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // $cartItems = Cart::where('user_id', auth()->id())->get();
        // $cartItemsCount = $cartItems->count();
        // $totalPrice = $cartItems->sum(function ($cartItem) {
        //     return $cartItem->quantity * $cartItem->product->price;
        // });
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('categories.edit', compact('category','categories'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category->update($request->all());

        return redirect()->route('categories')
                         ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
