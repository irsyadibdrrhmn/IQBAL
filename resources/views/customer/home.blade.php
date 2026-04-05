@extends('layouts.app')

@section('content')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <style>
        .banner-slide {
            position: relative;
            width: 100%;
            height: 450px;
            overflow: hidden;
            border-radius: 1rem;
        }

        .banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .banner-content {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            color: white;
            z-index: 2;
            max-width: 600px;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .banner-title {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .banner-description {
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }

        .banner-btn {
            display: inline-block;
            margin-top: 1.2rem;
            padding: 0.7rem 1.5rem;
            background-color: #ffffff;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 4px;
            text-decoration: none;
        }

        .swiper-pagination-bullet-active {
            background-color: #000 !important;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 22px;
            font-weight: bold;
        }

        /* Stock Badge Styles */
        .stock-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(220, 38, 38, 0.95);
            color: white;
            padding: 12px 30px;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            z-index: 3;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }

        .out-of-stock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 2;
        }

        .stock-info {
            margin-top: 8px;
            font-size: 0.9rem;
            color: #666;
        }

        .stock-info.in-stock {
            color: #16a34a;
            font-weight: 600;
        }

        .stock-info.low-stock {
            color: #ea580c;
            font-weight: 600;
        }

        .stock-info.out-of-stock {
            color: #dc2626;
            font-weight: 600;
        }

        /* Disabled state for out of stock products */
        .product-disabled {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Modal Styles */
        .cart-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        .cart-modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s;
        }

        .cart-modal-header {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-modal-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .cart-modal-close {
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            line-height: 1;
        }

        .cart-modal-close:hover {
            color: #000;
        }

        .cart-modal-body {
            padding: 30px;
        }

        .modal-product-info {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .modal-product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .modal-product-details h4 {
            margin: 0 0 8px 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .modal-product-price {
            font-size: 1.1rem;
            color: #333;
            font-weight: 600;
        }

        .modal-stock-info {
            margin-top: 8px;
            font-size: 0.9rem;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        .quantity-control label {
            font-weight: 600;
            font-size: 1rem;
        }

        .quantity-input-group {
            display: flex;
            align-items: center;
            border: 2px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
        }

        .quantity-btn {
            background-color: #f5f5f5;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .quantity-btn:hover {
            background-color: #e0e0e0;
        }

        .quantity-input {
            border: none;
            width: 60px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            padding: 10px 5px;
        }

        .quantity-input:focus {
            outline: none;
        }

        .cart-modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .modal-btn {
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .modal-btn-cancel {
            background-color: #f5f5f5;
            color: #333;
        }

        .modal-btn-cancel:hover {
            background-color: #e0e0e0;
        }

        .modal-btn-add {
            background-color: #000;
            color: #fff;
        }

        .modal-btn-add:hover {
            background-color: #333;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>

    <!-- Modal Cart -->
    <div id="cartModal" class="cart-modal">
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <h3>Tambah ke Keranjang</h3>
                <button class="cart-modal-close" onclick="closeCartModal()">&times;</button>
            </div>
            <form id="cartForm" action="{{ route('cart.store') }}" method="POST">
                @csrf
                <div class="cart-modal-body">
                    <div class="modal-product-info">
                        <img id="modalProductImage" src="" alt="" class="modal-product-image">
                        <div class="modal-product-details">
                            <h4 id="modalProductName"></h4>
                            <p class="modal-product-price" id="modalProductPrice"></p>
                            <p class="modal-stock-info" id="modalStockInfo"></p>
                        </div>
                    </div>
                    
                    <div class="quantity-control">
                        <label>Jumlah:</label>
                        <div class="quantity-input-group">
                            <button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
                            <input type="number" name="quantity" id="modalQuantity" class="quantity-input" value="1" min="1" max="999">
                            <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>

                    <input type="hidden" name="product_id" id="modalProductId">
                    <input type="hidden" name="price" id="modalProductPriceValue">
                    <input type="hidden" id="modalMaxStock" value="999">
                </div>
                <div class="cart-modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeCartModal()">Batal</button>
                    <button type="submit" class="modal-btn modal-btn-add">Tambah ke Keranjang</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.main-swiper', {
            loop: {{ count($banners) > 1 ? 'true' : 'false' }},
            grabCursor: true,
            autoplay: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            speed: 600,
        });

        // Modal Functions
        function openCartModal(productId, productName, productImage, productPrice, priceValue, stock) {
            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('modalProductImage').src = productImage;
            document.getElementById('modalProductPrice').textContent = productPrice;
            document.getElementById('modalProductPriceValue').value = priceValue;
            document.getElementById('modalMaxStock').value = stock;
            
            // Set stock info
            const stockInfo = document.getElementById('modalStockInfo');
            if (stock > 10) {
                stockInfo.textContent = `Stok: ${stock} tersedia`;
                stockInfo.className = 'modal-stock-info in-stock';
            } else if (stock > 0) {
                stockInfo.textContent = `Stok: ${stock} tersisa (segera habis!)`;
                stockInfo.className = 'modal-stock-info low-stock';
            } else {
                stockInfo.textContent = 'Stok habis';
                stockInfo.className = 'modal-stock-info out-of-stock';
            }
            
            // Reset quantity and set max
            const quantityInput = document.getElementById('modalQuantity');
            quantityInput.value = 1;
            quantityInput.max = stock;
            
            document.getElementById('cartModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeCartModal() {
            document.getElementById('cartModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function increaseQuantity() {
            const input = document.getElementById('modalQuantity');
            const maxStock = parseInt(document.getElementById('modalMaxStock').value);
            const currentValue = parseInt(input.value) || 1;
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('modalQuantity');
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('cartModal');
            if (event.target == modal) {
                closeCartModal();
            }
        }

        // Handle form submission
        document.getElementById('cartForm').addEventListener('submit', function(e) {
            closeCartModal();
        });
    </script>

    <section id="new-arrivals" class="new-arrivals">
        <div class="container">
            <div class="section-header">
                <h2>Produk Utama</h2>
            </div><!--/.section-header-->

            <div class="new-arrivals-content">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-sm-4">
                            <div class="single-new-arrival">
                                <div class="single-new-arrival-bg" style="position: relative;">
                                    @php
                                        $isOutOfStock = $product->stock <= 0;
                                    @endphp

                                    @if($isOutOfStock)
                                        <div class="out-of-stock-overlay"></div>
                                        <div class="stock-badge">STOK HABIS</div>
                                    @endif

                                    @auth
                                        <img src="/images/{{ $product->image }}" alt="{{ $product->name }}" 
                                            style="cursor: {{ $isOutOfStock ? 'default' : 'pointer' }};"
                                            @if(!$isOutOfStock)
                                            onclick="openCartModal(
                                                {{ $product->id }}, 
                                                '{{ addslashes($product->name) }}', 
                                                '/images/{{ $product->image }}',
                                                'Rp{{ number_format($product->discount && $product->discount->status === 'active' ? $product->discount->final_price : $product->price, 0, ',', '.') }}',
                                                {{ $product->discount && $product->discount->status === 'active' ? $product->discount->final_price : $product->price }},
                                                {{ $product->stock }}
                                            )"
                                            @endif>
                                    @else
                                        <img src="/images/{{ $product->image }}" alt="{{ $product->name }}">
                                    @endauth

                                    <div class="single-new-arrival-bg-overlay"></div>

                                    {{-- Label kategori / diskon --}}
                                    @if ($product->discount && $product->discount->status === 'active')
                                        <div class="sale bg-1">
                                            <p>Promo</p>
                                        </div>
                                    @else
                                        <div class="sale bg-2">
                                            <p>Regular</p>
                                        </div>
                                    @endif

                                    <div class="new-arrival-cart m-2 {{ $isOutOfStock ? 'product-disabled' : '' }}"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            {{-- Tambah ke cart --}}
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                @auth
                                                    @if(!$isOutOfStock)
                                                    <button type="button"
                                                        onclick="openCartModal(
                                                            {{ $product->id }}, 
                                                            '{{ addslashes($product->name) }}', 
                                                            '/images/{{ $product->image }}',
                                                            'Rp{{ number_format($product->discount && $product->discount->status === 'active' ? $product->discount->final_price : $product->price, 0, ',', '.') }}',
                                                            {{ $product->discount && $product->discount->status === 'active' ? $product->discount->final_price : $product->price }},
                                                            {{ $product->stock }}
                                                        )"
                                                        style="background:none; border:none; color:inherit; padding:0; margin:0; cursor:pointer;">
                                                        <span class="lnr lnr-cart"
                                                            style="font-size: 18px; color: #fafafa;"></span>
                                                    </button>
                                                    @else
                                                    <span class="lnr lnr-cart"
                                                        style="font-size: 18px; color: #999; cursor: not-allowed;"></span>
                                                    @endif
                                                @endauth

                                                @guest
                                                    <button type="button"
                                                        onclick="window.location.href='{{ route('login.form') }}'"
                                                        style="background:none; border:none; color:inherit; padding:0; margin:0; cursor:pointer;">
                                                        <span class="lnr lnr-cart"
                                                            style="font-size: 18px; color: #fafafa;"></span>
                                                    </button>
                                                @endguest
                                            </div>

                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                @auth
                                                    @if(!$isOutOfStock)
                                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        <button type="submit"
                                                            style="background:none; border:none; padding:0; margin:0; cursor:pointer;">
                                                            <span class="lnr lnr-heart"
                                                                style="font-size: 18px; color: #fafafa;"></span>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <span class="lnr lnr-heart"
                                                        style="font-size: 18px; color: #999; cursor: not-allowed;"></span>
                                                    @endif
                                                @endauth

                                                @guest
                                                    <button type="button"
                                                        onclick="window.location.href='{{ route('login.form') }}'"
                                                        style="background:none; border:none; padding:0; margin:0; cursor:pointer;">
                                                        <span class="lnr lnr-heart"
                                                            style="font-size: 18px; color: #fafafa;"></span>
                                                    </button>
                                                @endguest

                                                {{-- Quick View tetap bisa diakses --}}
                                                <a href="{{ route('detail', $product->id) }}" style="color: #fafafa;">
                                                    <span class="lnr lnr-frame-expand" style="font-size: 18px;"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h4>
                                    <a href="{{ route('detail', $product->id) }}">{{ $product->name }}</a>
                                </h4>

                                @if ($product->discount && $product->discount->status === 'active')
                                    <p class="arrival-product-price">
                                        <del>Rp{{ number_format($product->price, 0, ',', '.') }}</del><br>
                                        Rp{{ number_format($product->discount->final_price, 0, ',', '.') }}
                                    </p>
                                @else
                                    <p class="arrival-product-price">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                @endif

                                {{-- Stock Information --}}
                                @if($product->stock > 10)
                                    <p class="stock-info in-stock">Stok: {{ $product->stock }} tersedia</p>
                                @elseif($product->stock > 0)
                                    <p class="stock-info low-stock">Stok: {{ $product->stock }} tersisa</p>
                                @else
                                    <p class="stock-info out-of-stock">Stok habis</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div><!--/.container-->
    </section><!--/.new-arrivals-->

    <section class="discount-coupon py-5" style="background-color: #f9f9f9;">
        <div class="container">
            <div class="promo-banner position-relative overflow-hidden"
                style="background: linear-gradient(90deg, #111 0%, #333 100%);
                   color: #fff; padding: 4rem 3rem; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">

                <div
                    style="position: absolute; top: 10%; right: 5%; font-size: 8rem; 
                        font-weight: 900; color: rgba(255,255,255,0.05); z-index: 0; text-transform: uppercase;">
                    {{ $biggestDiscount ? $biggestDiscount->discount_value . ($biggestDiscount->discount_type === 'percent' ? '%' : ' Rp') . ' OFF' : 'PROMO' }}
                </div>

                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8 col-md-12 mb-4 mb-lg-0">
                        <h1 class="fw-bold mb-3" style="font-size: 2.5rem; line-height: 1.2;">
                            {{ $biggestDiscount ? $biggestDiscount->promo_name : 'Penawaran Spesial Hari Ini!' }}
                        </h1>
                        <p style="font-size: 1.1rem; color: #ddd; max-width: 600px;">
                            @if ($biggestDiscount)
                                Nikmati diskon hingga
                                <strong>{{ $biggestDiscount->discount_value }}{{ $biggestDiscount->discount_type === 'percent' ? '%' : ' Rp' }}</strong>
                                untuk <strong>{{ $biggestDiscount->product->name }}</strong>.
                                Sekarang hanya
                                <strong>Rp{{ number_format($biggestDiscount->calculated_final_price) }}</strong>!
                            @else
                                Daftar email sekarang dan dapatkan <strong>10% OFF</strong> untuk semua pembelian!
                            @endif
                        </p>
                    </div>

                    <div class="col-lg-4 col-md-12 text-lg-end text-md-start">
                        <a href="{{ $biggestDiscount ? route('detail', $biggestDiscount->product->id) : '#' }}"
                            class="btn-promo"
                            style="background-color: #fff; color: #111; padding: 1rem 2.5rem; 
                               font-weight: 700; font-size: 1rem; text-transform: uppercase; 
                               letter-spacing: 1px; text-decoration: none; transition: 0.3s;">
                            {{ $biggestDiscount ? 'Lihat Produk' : 'Daftar Sekarang' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .btn-promo:hover {
            background-color: #e5e5e5;
            color: #000;
        }

        @media (max-width: 768px) {
            .promo-banner {
                padding: 2.5rem 1.5rem !important;
                text-align: center;
            }

            .btn-promo {
                margin-top: 1.5rem;
                display: inline-block;
            }
        }
    </style>

    @if (request()->routeIs('home.index'))
        <section id="feature" class="feature">
            <div class="container">
                <div class="section-header">
                    <h2>featured products</h2>
                </div><!--/.section-header-->

                <div class="feature-content">
                    <div class="row">
                        @foreach ($featuredProduct->take(4) as $product)
                            <div class="col-sm-3">
                                <div class="single-feature">
                                    <img src="/images/{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid">
                                    <div class="single-feature-txt text-center">
                                        <p>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <span class="spacial-feature-icon"><i class="fa fa-star"></i></span>
                                            <span class="feature-review">(45 review)</span>
                                        </p>
                                        <h3>
                                            <a href="{{ route('detail', $product->id) }}">{{ $product->name }}</a>
                                        </h3>

                                        @if ($product->discount && $product->discount->status === 'active')
                                            <h5>
                                                <del class="text-muted small">
                                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                                </del>
                                                Rp{{ number_format($product->discount->final_price, 0, ',', '.') }}
                                            </h5>
                                        @else
                                            <h5>Rp{{ number_format($product->price, 0, ',', '.') }}</h5>
                                        @endif

                                        {{-- Stock info for featured products --}}
                                        @if($product->stock > 10)
                                            <p class="stock-info in-stock" style="margin-top: 8px;">Stok: {{ $product->stock }}</p>
                                        @elseif($product->stock > 0)
                                            <p class="stock-info low-stock" style="margin-top: 8px;">Stok: {{ $product->stock }} tersisa</p>
                                        @else
                                            <p class="stock-info out-of-stock" style="margin-top: 8px;">Stok habis</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div><!--/.row-->
                </div><!--/.feature-content-->
            </div><!--/.container-->
        </section><!--/.feature-->
    @endif

@endsection