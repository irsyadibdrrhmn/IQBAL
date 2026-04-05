@extends('layouts.app')

@section('content')



    <!-- SECTION -->
    <div class="section" style="padding: 50px 0;">
        <div class="container">
            <div class="row">
<!-- SIDEBAR -->
<div class="col-md-3">


    <!-- Top Selling -->
    <div class="aside p-3" style="background-color: #fff0f5; border-radius: 12px;">
        <h3 class="fw-bold mb-4" style="font-size: 18px; color: #d81b60;">Produk Terlaris</h3>
        @foreach ($topSellingProducts as $product)
            <div class="product-widget d-flex mb-3 p-2" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                <div style="flex: 0 0 30%; margin-right: 10px;">
                    <a href="{{ route('detail', $product->id) }}">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                             style="width: 100%; height: auto; border-radius: 8px; object-fit: cover;">
                    </a>
                </div>
                <div style="flex: 1;">
                    <p class="mb-1" style="font-size: 13px; color: #888;">
                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                    </p>
                    <h3 class="mb-1" style="font-size: 15px;">
                        <a href="{{ route('detail', $product->id) }}" style="color: #333; text-decoration: none;">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <h4 style="font-size: 14px; color: #d81b60; font-weight: bold;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                        @if ($product->old_price)
                            <del class="ms-1" style="color: #aaa; font-size: 13px;">
                                Rp {{ number_format($product->old_price, 0, ',', '.') }}
                            </del>
                        @endif
                    </h4>
                </div>
            </div>
        @endforeach
    </div>
</div>

                <!-- /SIDEBAR -->

                <!-- STORE PRODUCTS -->
                <div class="col-md-9">
                 
                    

                    <div class="row">
                       
                        <section class="hero-small-section py-4" style="background-color: #fce4ec;">
                            <div class="container text-center">
                                <h1 class="fw-bold mb-2" style="font-size: 28px; color: #d81b60;">
                                    {{ $category->name ?? 'Produk Terbaru' }}
                                </h1>
                                <p class="mb-0" style="font-size: 16px; color: #6c757d;">
                                    Temukan pilihan terbaik dalam kategori ini yang cocok untuk gaya dan kebutuhanmu.
                                </p>
                            </div>
                        </section>

                        <section id="latest-products" class="product-store py-2 my-2 py-md-5 my-md-5 pt-0" style="background-color: #fff0f5;">
                            <div class="container-md">
                                <div class="display-header d-flex align-items-center justify-content-between">
                                    <h2 class="section-title text-uppercase fw-bold" style="color: #ec407a;">Produk Terbaru</h2>
                                </div>
                        
                                <div class="product-content padding-small">
                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
                                        @foreach ($allProducts as $product)
                                            <div class="col mb-4">
                                                <div class="product-card position-relative">
                                                    <div class="card-img">
                                                        <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                                                             class="img-fluid"
                                                             style="width: 200px; height: 200px; object-fit: cover; border-radius: 10px;">
                        
                                                        <div class="cart-concern position-absolute d-flex justify-content-center">
                                                            <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                        
                                                                <!-- Tambah ke Cart -->
                                                                <form action="{{ route('cart.store') }}" method="POST"
                                                                      onsubmit="addToCartSuccess()" style="display: inline;">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <input type="hidden" name="price"
                                                                           value="{{ $product->discount && $product->discount->status === 'active' ? $product->discount->final_price : $product->price }}">
                        
                                                                    <button type="submit" class="btn btn-light shadow-sm">
                                                                        <i class="fas fa-cart-shopping" style="color: #ec407a;"></i>
                                                                    </button>
                                                                </form>
                        
                                                                <!-- Wishlist -->
                                                                <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                                                      style="display: inline;">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-light shadow-sm">
                                                                        <i class="far fa-heart" style="color: #ec407a;"></i>
                                                                    </button>
                                                                </form>
                        
                                                                <!-- Quick View -->
                                                                <button type="button" class="btn btn-light shadow-sm"
                                                                        onclick="window.location.href='{{ route('detail', $product->id) }}'">
                                                                    <i class="fas fa-eye" style="color: #ec407a;"></i>
                                                                </button>
                        
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="card-detail d-flex justify-content-between align-items-center mt-3">
                                                        <h3 style="font-size: 16px; letter-spacing: 0.5px; margin-bottom: 0;">
                                                            <a href="{{ route('detail', $product->id) }}"
                                                               style="color: #333; text-decoration: none;">{{ $product->name }}</a>
                                                        </h3>
                                                    </div>
                        
                                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                                        @if ($product->discount && $product->discount->status === 'active')
                                                            <span class="card-price fw-bold text-muted" style="font-size: 14px;">
                                                                <del>Rp{{ number_format($product->price, 0, ',', '.') }}</del>
                                                            </span>
                                                            <span class="card-price fw-bold" style="color: #d81b60; font-size: 15px;">
                                                                Rp{{ number_format($product->discount->final_price, 0, ',', '.') }}
                                                            </span>
                                                        @else
                                                            <span class="card-price fw-bold text-dark" style="font-size: 15px;">
                                                                Rp{{ number_format($product->price, 0, ',', '.') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                        







                    </div>


                    <!-- Pagination (opsional) -->
                    {{-- <div class="store-filter clearfix text-center mt-4">
                    {{ $allProducts->links() }}
                </div> --}}
                </div>
                <!-- /STORE PRODUCTS -->
            </div>
        </div>
    </div>
    <!-- /SECTION -->

   

   
@endsection
