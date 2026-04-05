<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Category;
use App\Models\Voucher;
use App\Models\Address;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{


    //percobaan
    public function selected(Request $request)
    {
        $selectedIds = $request->input('selected_items', []);

        // Ambil data cart + produk terkait
        $selectedItems = Cart::with(['product'])
            ->whereIn('id', $selectedIds)
            ->get();

        // ✅ Cek stok setiap item
        foreach ($selectedItems as $item) {
            if (!$item->product) {
                return back()->with('error_cart', "Produk dengan ID {$item->id} tidak ditemukan.");
            }

            if ($item->quantity > $item->product->stock) {
                return back()->with('error_cart', "Stok untuk produk '{$item->product->name}' tidak mencukupi. (Stok: {$item->product->stock}, diminta: {$item->quantity})");
            }
        }

        // ✅ Jika semua valid, simpan ke session
        session(['selected_checkout_items' => $selectedItems]);

        return redirect()->route('checkout.index');
    }




    public function index()
    {
        $biggestDiscount = Discount::where('status', 'active')
            ->with('product')
            ->get()
            ->sortByDesc(function ($discount) {
                return $discount->calculated_final_price;
            })
            ->first();

        $userId = Auth::id();
        $categories = Category::all();
        $user = Auth::user();

        // Ambil cart + relasi produk + discount
        $cartItems = Cart::where('user_id', $userId)
            ->with(['product.discount'])
            ->get();
        $cartItemsCount = $cartItems->count();

        // Wishlist
        $wishlistItems = [];
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::with('product')
                ->where('user_id', $user->id)
                ->get();
        }

        // Ambil item checkout yang dipilih
        $selectedItems = session('selected_checkout_items', collect());

        // Voucher aktif (maks 2x pemakaian / user)
        $availableVouchers = Voucher::where('is_active', true)
            ->where(function ($query) use ($user) {
                $query->whereDoesntHave('users', function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->where('usage_count', '>=', 2);
                });
            })
            ->get();
            $address = Address::where('user_id', $userId)->first();


        return view('checkout.index', compact(
            'cartItems',
            'categories',
            'selectedItems',
            'cartItemsCount',
            'wishlistItems',
            'biggestDiscount',
            'availableVouchers',
            'address'
        ));
    }


    
    public function setOngkir(Request $request)
    {
        $cost = (int) $request->input('cost', 0);

        // Simpan ke session
        session(['ongkir.cost' => $cost]);

        return response()->json([
            'success' => true,
            'message' => 'Ongkir berhasil disimpan ke session.',
            'cost' => $cost,
        ]);
    }


    public function process(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();

        // Ambil item yang dipilih dari session
        $selectedItems = session('selected_checkout_items', collect())->pluck('id');
        $cartItems = Cart::where('user_id', $userId)
            ->with(['product'])
            ->get()
            ->filter(fn($item) => $selectedItems->contains($item->id));

        // Validasi input form
        $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string|max:50',
            'note' => 'nullable|string|max:500',
            'provinsi_id' => 'required|string',
            'provinsi_name' => 'required|string',
            'kabupaten_id' => 'required|string',
            'kabupaten_name' => 'required|string',
            'kecamatan_id' => 'required|string',
            'kecamatan_name' => 'required|string',
            'desa_id' => 'required|string',
            'desa_name' => 'required|string',
        ]);

        // Handle upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Ambil poin dari request
        $poinDipakai = (int) $request->input('points_used');
        $shippingCost = session('ongkir.cost', 0);

        // Hitung total cart (pakai harga produk + cek diskon)
        $totalDariCart = $cartItems->sum(function ($item) {
            if ($item->product) {
                if ($item->product->discount && $item->product->discount->status === 'active') {
                    return $item->product->discount->final_price * $item->quantity;
                }
                return $item->product->price * $item->quantity;
            }
            return 0;
        });

        // Hitung voucher dari session (validasi ulang di DB)
        $voucher = null;
        $voucherDiscount = 0;
        $voucherCode = null;

        if (session()->has('applied_voucher')) {
            $voucherSession = session('applied_voucher');

            $voucher = \App\Models\Voucher::where('code', $voucherSession['code'])->first();

            if ($voucher && $voucher->is_active && (!$voucher->expires_at || $voucher->expires_at >= now())) {
                $voucherCode = $voucher->code;

                if ($voucher->discount_type === 'percent') {
                    $voucherDiscount = ($totalDariCart + $shippingCost) * ($voucher->discount_value / 100);
                } else {
                    $voucherDiscount = $voucher->discount_value;
                }

                // Hindari diskon lebih besar dari subtotal
                $voucherDiscount = min($voucherDiscount, $totalDariCart + $shippingCost);
            }
        }

        // Hitung total akhir (server-side only)
        $totalHarusnya = $totalDariCart + $shippingCost - $poinDipakai - $voucherDiscount;
        if ($totalHarusnya < 0) $totalHarusnya = 0;

        // Validasi poin cukup
        if ($poinDipakai > $user->points) {
            return redirect()->back()->withErrors('Poin tidak mencukupi.');
        }

        // Buat order
        $order = Order::create([
            'user_id' => $userId,
            'address' => $request->input('address'),
            'provinsi_id' => $request->input('provinsi_id'),
            'provinsi_name' => $request->input('provinsi_name'),
            'kabupaten_id' => $request->input('kabupaten_id'),
            'kabupaten_name' => $request->input('kabupaten_name'),
            'kecamatan_id' => $request->input('kecamatan_id'),
            'kecamatan_name' => $request->input('kecamatan_name'),
            'desa_id' => $request->input('desa_id'),
            'desa_name' => $request->input('desa_name'),
            'payment_method' => $request->input('payment_method'),
            'total' => $totalHarusnya,
            'shipping_cost' => $shippingCost,
            'image' => $imagePath,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'note' => $request->input('note'),
            'voucher_code' => $voucherCode,
            'voucher_discount_amount' => $voucherDiscount,
        ]);
        // Simpan item ke order_items
        foreach ($cartItems as $item) {
            if ($item->product) {
                // decode JSON attributes kalau masih string
                $attributes = $item->attributes
                    ? (is_string($item->attributes) ? json_decode($item->attributes, true) : $item->attributes)
                    : [];

                // hitung tambahan harga atribut
                $extraPrice = 0;
                foreach ($attributes as $attr) {
                    $extraPrice += $attr['price'] ?? 0;
                }

                // harga final per unit (produk + atribut)
                $finalPrice = $item->product->price + $extraPrice;

                // simpan ke order_items
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $finalPrice,
                    'attributes' => $attributes,
                ]);

                // update stok produk
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }
        }
        // 1️⃣ SIMPAN ALAMAT KE TABEL addresses
        $address = Address::updateOrCreate(
            ['user_id' => $userId], // cek apakah user ini sudah punya alamat
            [
                'address' => $request->address,
                'provinsi_id' => $request->provinsi_id,
                'provinsi_name' => $request->provinsi_name,
                'kabupaten_id' => $request->kabupaten_id,
                'kabupaten_name' => $request->kabupaten_name,
                'kecamatan_id' => $request->kecamatan_id,
                'kecamatan_name' => $request->kecamatan_name,
                'desa_id' => $request->desa_id,
                'desa_name' => $request->desa_name,
            ]
        );




        // Kurangi poin user
        if ($poinDipakai > 0) {
            $user->points -= $poinDipakai;

            /** @var \App\Models\User $user */
            $user->save();
        }

        // Kosongkan cart
        Cart::where('user_id', $userId)
            ->whereIn('id', $selectedItems)
            ->delete();

        // Bersihkan session
        session()->forget('ongkir');
        session()->forget('applied_voucher');
        session()->forget('selected_checkout_items');

        return redirect()->route('home.order')->with('success', 'Order berhasil dibuat!');
    }



    // public function ongkir_index()
    // {
    //     $selectedItems = session('selected_checkout_items', collect());

    //     // Hitung total berat: setiap quantity × 1000 gram
    //     $totalWeight = $selectedItems->sum(function ($item) {
    //         return $item->quantity * 1000;
    //     });

    //     $categories = Category::all();
    //     $cities = $this->getCities();

    //     return view('checkout.ongkir', compact('cities', 'categories', 'selectedItems', 'totalWeight'));
    // }


    //end percobaan

    public function ongkir_index(Request $request)
    {
        $input = $request->get('input'); // ambil input dari form (bisa kosong saat pertama kali)

        $areas = []; // default kosong

        if ($input) {
            // Jika user sudah isi form, kirim request ke Biteship API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoib25na2lyIiwidXNlcklkIjoiNjhlMWVkMTExYmRlNDMwMDEyYzdlNGU2IiwiaWF0IjoxNzU5NjM2OTI0fQ.hcBgTI6seaw2eAgGj4KieahdHs090YG22oVbQ5y99kU',
                'Content-Type' => 'application/json',
            ])->get('https://api.biteship.com/v1/maps/areas', [
                'input' => $input
            ]);

            $areas = $response->json('areas') ?? [];
        }

        // --- Bagian dari projectmu ---
        $biggestDiscount = Discount::where('status', 'active')
            ->with('product')
            ->get()
            ->sortByDesc(function ($discount) {
                return $discount->calculated_final_price;
            })
            ->first();

        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        $cartItemsCount = $cartItems->count();
        $user = Auth::user();

        $wishlistItems = [];
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::with('product')
                ->where('user_id', $user->id)
                ->get();
        }

        $categories = Category::all();

        $selectedItems = session('selected_checkout_items', collect());
        $totalWeight = $selectedItems->sum(function ($item) {
            return $item->quantity * 1000;
        });

        return view('checkout.ongkir', compact(
            'areas',
            'categories',
            'userId',
            'cartItemsCount',
            'cartItems',
            'wishlistItems',
            'biggestDiscount',
            'totalWeight',
            'input'
        ));
    }

    public function setSession(Request $request)
    {
        // Simpan area terpilih ke session
        $data = [
            'id' => $request->area_id,
            'name' => $request->area_name,
            'postal_code' => $request->postal_code,
        ];

        session(['ongkir_area' => $data]);

        // Dummy origin (lokasi toko)
        $origin = 'IDNP9IDNC22IDND2071';
        $destination = $request->area_id;

        // --- Coba request ke API ---
        try {
            $response = Http::withToken(env('BITESHIP_API_KEY'))
                ->post('https://api.biteship.com/v1/rates/couriers', [
                    'origin_area_id' => $origin,
                    'destination_area_id' => $destination,
                    'couriers' => 'jne:regular,pos:express',
                    'items' => [[
                        'name' => 'Sample Item',
                        'weight' => 1000,
                        'quantity' => 1
                    ]]
                ]);

            $ongkirData = $response->json('pricing');
        } catch (\Exception $e) {
            $ongkirData = null;
        }

        // --- Kalau gagal ambil dari API (misal: saldo habis) ---
        if (empty($ongkirData)) {
            // buat harga random tapi logis (Rp10.000 - Rp40.000)
            $fakeCost = rand(10000, 40000);
            $fakeCourier = collect([
                [
                    'courier_name' => 'JNE Regular',
                    'courier_code' => 'jne',
                    'service' => 'REG',
                    'cost' => $fakeCost,
                    'etd' => rand(2, 5) . ' hari',
                ],
                [
                    'courier_name' => 'POS Express',
                    'courier_code' => 'pos',
                    'service' => 'EXPRESS',
                    'cost' => $fakeCost + rand(2000, 5000),
                    'etd' => rand(1, 3) . ' hari',
                ],
            ]);
            $ongkirData = $fakeCourier->toArray();
        }

        // Simpan ongkir ke session (pakai format yang sama dengan checkout.show)
        session(['ongkir' => [
            'cost' => $ongkirData[0]['cost'], // pilih salah satu (misal JNE)
            'courier' => $ongkirData[0]['courier_name'],
            'service' => $ongkirData[0]['service'],
            'etd' => $ongkirData[0]['etd'],
        ]]);

        return redirect()->route('checkout.index')->with('success', 'Area berhasil dipilih dan ongkir dihitung.');
    }

    // public function show()
    // {
    //     $selectedArea = session('ongkir_area');
    //     $ongkir = session('ongkir');
    //     $cartItems = session('cart', []);

    //     // Debug dulu
    //     dd($ongkir);

    //     return view('checkout.show', compact('selectedArea', 'ongkir', 'cartItems'));
    // }






    // public function ongkir_index()
    // {
    //     $biggestDiscount = Discount::where('status', 'active')
    //     ->with('product')
    //     ->get()
    //     ->sortByDesc(function ($discount) {
    //         return $discount->calculated_final_price;
    //     })
    //     ->first();
    //     $userId = Auth::id(); // Menggunakan Auth Facade untuk mendapatkan user ID
    //     $cartItems = Cart::where('user_id', $userId)->with('product')->get();
    //     $user = Auth::user();

    //     // Ambil wishlist milik user (jika login)
    //     $wishlistItems = [];
    //     if ($user) {
    //         $wishlistItems = \App\Models\Wishlist::with('product')
    //             ->where('user_id', $user->id)
    //             ->get();
    //     }
    //     // Ambil daftar kota untuk ditampilkan di form
    //     $categories = Category::all();
    //     $cities = $this->getCities();
    //      // Hitung total berat: setiap quantity × 1000 gram
    //      $selectedItems = session('selected_checkout_items', collect());
    //      $totalWeight = $selectedItems->sum(function ($item) {
    //         return $item->quantity * 1000;
    //     });
    //     return view('checkout.ongkir', compact('cities','categories','userId','cartItems','wishlistItems','biggestDiscount','totalWeight'));
    // }

    public function cekOngkir(Request $request)
    {
        return ("hallo");
        // $user = Auth::user();
        // $biggestDiscount = Discount::where('status', 'active')
        // ->with('product')
        // ->get()
        // ->sortByDesc(function ($discount) {
        //     return $discount->calculated_final_price;
        // })
        // ->first();
        // // Ambil wishlist milik user (jika login)
        // $wishlistItems = [];
        // if ($user) {
        //     $wishlistItems = \App\Models\Wishlist::with('product')
        //         ->where('user_id', $user->id)
        //         ->get();
        // }


        // $userId = Auth::id(); // Menggunakan Auth Facade untuk mendapatkan user ID
        // $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        // $categories = Category::all();
        // $rajaongkirKey = '8f22875183c8c65879ef1ed0615d3371';
        // $origin = 211; // ID Kota asal
        // $destination = $request->input('destination');
        // $weight = $request->input('weight');
        // $courier = $request->input('courier');

        // $client = new Client();

        // $response = $client->request('POST', 'https://api.rajaongkir.com/starter/cost', [
        //     'headers' => [
        //         'key' => $rajaongkirKey,
        //         'content-type' => 'application/x-www-form-urlencoded',
        //     ],
        //     'form_params' => [
        //         'origin' => $origin,
        //         'destination' => $destination,
        //         'weight' => $weight,
        //         'courier' => $courier,
        //     ],
        // ]);

        // if ($response->getStatusCode() == 200) {
        //     $result = json_decode($response->getBody()->getContents(), true);
        //     return view('checkout.result', compact('result','categories','userId','cartItems','wishlistItems','biggestDiscount'));
        // } else {
        //     return redirect()->back()->with('error', 'Gagal mengambil ongkir!');
        // }
    }

    public function saveOngkir(Request $request)
    {
        // Menyimpan pilihan ongkir ke session
        session([
            'ongkir' => [
                'courier' => $request->input('courier'),
                'service' => $request->input('service'),
                'cost' => $request->input('cost'),
                'etd' => $request->input('etd'),
            ]
        ]);



        // Redirect ke halaman checkout.index setelah berhasil disimpan
        return redirect()->route('checkout.index')->with('success', 'Ongkir berhasil disimpan.');
    }



    public function getCities()
    {
        $rajaongkirKey = '8f22875183c8c65879ef1ed0615d3371';
        $client = new Client();

        $response = $client->request('GET', 'https://api.rajaongkir.com/starter/city', [
            'headers' => [
                'key' => $rajaongkirKey,
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents(), true);
            return $result['rajaongkir']['results'];
        } else {
            return [];
        }
    }
}
