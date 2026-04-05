@extends('layouts.app')

@section('content')

{{-- Hero Kategori --}}
<section class="category-hero py-4" style="background-color: #f7f7f7; border-radius: 1rem; margin-bottom: 2rem;">
    <div class="container text-center">
        <h2 class="fw-bold mb-2" style="color: #333; font-size: 28px;">
            Kategori: {{ $category->name }}
        </h2>
        <p class="text-muted mb-0" style="font-size: 14px;">
            Temukan berbagai pilihan produk terbaik dalam kategori <strong>{{ $category->name }}</strong>.
        </p>
    </div>
</section>

{{-- Produk --}}
<section id="new-arrivals" class="new-arrivals py-4" style="background-color: #fff;">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2 style="color:#222; font-weight:700;">Produk Kategori: {{ $category->name }}</h2>
        </div>

        <div class="new-arrivals-content">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-3 col-sm-4 mb-4">
                        <div class="single-new-arrival shadow-sm border" style="border-radius:10px; overflow:hidden; background:#fff;">
                            <div class="single-new-arrival-bg position-relative">
                                <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                                     class="img-fluid"
                                     style="width:100%; height:240px; object-fit:cover;">

                                <div class="single-new-arrival-bg-overlay"></div>

                                {{-- Label kategori / diskon --}}
                                @if ($product->discount && $product->discount->status === 'active')
                                    <div class="sale bg-1" style="background:#222; color:white; position:absolute; top:10px; left:10px; padding:3px 8px; border-radius:4px;">
                                        <p class="m-0" style="font-size:13px;">Promo</p>
                                    </div>
                                @else
                                    <div class="sale bg-2" style="background:#999; color:white; position:absolute; top:10px; left:10px; padding:3px 8px; border-radius:4px;">
                                        <p class="m-0" style="font-size:13px;">Regular</p>
                                    </div>
                                @endif

                                {{-- Tombol Aksi --}}
                                <div class="new-arrival-cart d-flex justify-content-between align-items-center p-2 position-absolute w-100 bottom-0" style="background:rgba(0,0,0,0.6);">
                                    <div>
                                        <form action="{{ route('cart.store') }}" method="POST" onsubmit="addToCartSuccess()" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="price"
                                                value="{{ $product->discount && $product->discount->status === 'active'
                                                    ? $product->discount->final_price
                                                    : $product->price }}">
                                            <button type="submit" style="background:none; border:none; cursor:pointer;">
                                                <span class="lnr lnr-cart" style="font-size:18px; color:#fff;"></span>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" style="background:none; border:none; cursor:pointer;">
                                                <span class="lnr lnr-heart" style="font-size:18px; color:#fff;"></span>
                                            </button>
                                        </form>
                                        <a href="{{ route('detail', $product->id) }}">
                                            <span class="lnr lnr-frame-expand" style="font-size:18px; color:#fff;"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Nama dan Harga --}}
                            <div class="p-3 text-center">
                                <h4 class="fw-bold mb-2" style="font-size:16px;">
                                    <a href="{{ route('detail', $product->id) }}" style="color:#222; text-decoration:none;">
                                        {{ $product->name }}
                                    </a>
                                </h4>
                                @if ($product->discount && $product->discount->status === 'active')
                                    <p class="m-0" style="color:#111; font-weight:600;">
                                        <del class="text-muted" style="font-size:13px;">Rp{{ number_format($product->price, 0, ',', '.') }}</del><br>
                                        Rp{{ number_format($product->discount->final_price, 0, ',', '.') }}
                                    </p>
                                @else
                                    <p class="m-0" style="color:#111; font-weight:600;">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
