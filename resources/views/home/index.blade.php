@extends('layouts.app')
@section('content')
    @auth

  









        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- shop -->
                    @if ($featuredProduct->count() > 0)
                        @foreach ($featuredProduct as $featuredProduct)
                            <div class="col-md-4 col-xs-6">
                                <div class="shop">
                                    <div class="shop-img">
                                        <img src="/images/{{ $featuredProduct->image }}" alt="" height="241px">
                                    </div>
                                    <div class="shop-body">
                                        <h3>{{ $featuredProduct->name }}</h3>
                                        <p>
                                            @if ($featuredProduct->discount && $featuredProduct->discount->status == 'active')
                                                <del>Rp {{ number_format($featuredProduct->price) }}</del><br>
                                                <strong>Rp {{ number_format($featuredProduct->discount->final_price) }}</strong>
                                            @else
                                                <strong>Rp {{ number_format($featuredProduct->price) }}</strong>
                                            @endif
                                        </p>
                                        <a href="{{ route('products.show', $featuredProduct->id) }}" class="cta-btn">
                                            Shop now <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No discounted products available.</p>
                    @endif







                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->


        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="section-title">
                        <h3 class="title">New Products </h3>
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">
                                @foreach ($categories as $category)
                                    <li
                                        class="{{ request()->routeIs('home.category') && request()->route('id') == $category->id ? 'active' : '' }}">
                                        <a href="{{ route('home.category', $category->id) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>



                    <!-- Products tab & slick -->
                    <div class="col-md-15">
                        <div class="row">
                            <div class="products-tabs">
                                <!-- tab -->
                                <div id="tab1" class="tab-pane active">
                                    <div class="products-slick" data-nav="#slick-nav-1">
                                        @foreach ($products as $product)
                                            <div class="product">
                                                <div class="product-img">
                                                    <img src="/images/{{ $product->image }}" width="100px">
                                                    @if ($product->discount && $product->discount->status === 'active')
                                                        @php
                                                            $original = $product->price;
                                                            $discounted = $product->discount->final_price;
                                                            $percentage = round(
                                                                (($original - $discounted) / $original) * 100,
                                                            );
                                                        @endphp
                                                        <div class="product-label">
                                                            <span class="sale">-{{ $percentage }}%</span>
                                                            <span class="new">NEW</span>
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="product-body">
                                                    <p class="product-category">{{ $product->category->name }}</p>
                                                    <h3 class="product-name"><a href="#">{{ $product->name }}</a></h3>
                                                    <h4 class="product-price">
                                                        @if ($product->discount && $product->discount->status === 'active')
                                                            <del
                                                                class="text-muted">Rp{{ number_format($product->price, 0, ',', '.') }}</del><br>
                                                            <span
                                                                class="text-danger fw-bold">Rp{{ number_format($product->discount->final_price, 0, ',', '.') }}</span>
                                                        @else
                                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                                        @endif
                                                    </h4>

                                                    <div class="product-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div class="product-btns">
                                                        {{-- <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button> --}}
                                                        <button class="quick-view"><i class="fa fa-eye"></i><span
                                                                class="tooltipp"><a href="{{ route('detail', $product->id) }}"
                                                                    style="color: aliceblue; transition: color 0.3s;"
                                                                    onmouseover="this.style.color='red'"
                                                                    onmouseout="this.style.color='aliceblue'">quick
                                                                    view</a></span></button>
                                                    </div>
                                                </div>
                                              
                                                <div class="add-to-cart">
                                                    <form action="{{ route('cart.store') }}" method="POST"
                                                        onsubmit="addToCartSuccess()">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="add-to-cart-btn"><i
                                                                class="fa fa-shopping-cart"></i> Add to cart</button>
                                                    </form>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="slick-nav-1" class="products-slick-nav"></div>
                                </div>
                                <!-- /tab -->
                            </div>
                        </div>
                    </div>
                    <!-- Products tab & slick -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>



        {{-- <p>Welcome <b>{{ Auth::user()->name }}</b></p>
<a class="btn btn-primary" href="{{ route('password') }}">Change Password</a>
<a class="btn btn-danger" href="{{ route('logout') }}">Logout</a> --}}
        <style>
            .product-img img {
                object-fit: cover;
                width: 200px;
                /* Sesuaikan dengan ukuran yang Anda inginkan */
                height: 300px;
                /* Sesuaikan dengan ukuran yang Anda inginkan */
            }
        </style>

    @endauth
    @guest
        <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
        <a class="btn btn-info" href="{{ route('register') }}">Register</a>
    @endguest
@endsection
