<?php
  
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
  
class ProductController extends Controller
{


    public function emailForm($id)
{
    $product = Product::findOrFail($id);

    $users = User::all();
    

    return view('products.send_email', compact('product', 'users'));
}

public function storeEmail(Request $request)
{
    // Validasi email yang dipilih
    $request->validate([
        'emails' => 'required|array|min:1', // Pastikan ada email yang dipilih
        'emails.*' => 'email', // Pastikan format email valid
    ]);

    // Simpan data produk dan email yang dipilih ke session
    $selectedEmails = $request->input('emails');  // Ambil email yang dipilih
    $product = Product::findOrFail($request->input('product_id'));  // Ambil data produk

    // Simpan data ke session
    session([
        'product' => [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
            'image' => asset('images/' . $product->image),
            'category' => $product->category->name ?? '-',
        ],
        'emails' => $selectedEmails
    ]);
   
    return redirect()->route('product.data');
}
public function showProductData()
{
    $product = session('product');
    $emails = session('emails');

    if (!$product || !$emails) {
        return redirect()->route('product.index')->with('error', 'Data tidak ditemukan.');
    }

    return view('products.data', compact('product', 'emails'));
}



    /**
     * Display a listing of the resource.
     *
     * @return response()
     */
    public function index(): View
    {
        $products = Product::all();
        $categories = Category::all();
        
        return view('products.index', compact('products','categories'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    
  
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
{
    $categories = Category::all();
    
    return view('products.create',compact('categories'));
}
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_premium' => 'nullable|in:0,1', // Validasi tambahan
        ]);
    
        $input = $request->all();
    
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
        }
    
        // Pastikan is_premium memiliki default jika tidak dipilih
        $input['is_premium'] = $request->input('is_premium', 0);
    
        Product::create($input);
    
        return redirect()->route('products.index')
                         ->with('success', 'Product created successfully.');
    }
    
  
    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
       
    
        $categories = Category::all();
        return view('products.show',compact('categories','product'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('products.edit', compact('product','categories'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_premium' => 'nullable|in:0,1', // Validasi tambahan
        ]);
    
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);
        
        // Ambil data input
        $input = $request->all();
    
        // Jika ada gambar baru yang di-upload
        if ($image = $request->file('image')) {
            // Hapus gambar lama jika ada
            if (file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }
    
            // Upload gambar baru
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
        }
    
        // Pastikan is_premium memiliki default jika tidak dipilih
        $input['is_premium'] = $request->input('is_premium', 0);
    
        // Update produk dengan input yang telah diperbarui
        $product->update($input);
    
        return redirect()->route('products.index')
                         ->with('success', 'Product updated successfully.');
    }
    
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
         
        return redirect()->route('products.index')
                         ->with('success', 'Product deleted successfully');
    }
}