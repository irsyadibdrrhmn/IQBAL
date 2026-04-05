  <!-- top-area Start -->
        <div class="top-area">
            <div class="header-area">
                <!-- Start Navigation -->
                <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy"
                    data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">

                    <!-- Start Top Search -->
                    <div class="top-search">
                        <div class="container">
                            <form id="search-form" action="{{ route('home.index') }}" method="get"
                                class="input-group">
                                <span class="input-group-addon">
                                    <button type="submit" class="border-0 bg-transparent">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>

                                <input type="text" name="search_query" class="form-control"
                                    placeholder="Cari produk..." value="{{ request('search_query') }}">

                                <span class="input-group-addon close-search">
                                    <i class="fa fa-times"></i>
                                </span>
                            </form>
                        </div>
                    </div>
                    <!-- End Top Search -->


                    <div class="container">
                        <!-- Start Atribute Navigation -->
                        <div class="attr-nav">
                            <ul>
                                <li class="search">
                                    <a href="#"><span class="lnr lnr-magnifier"></span></a>
                                </li><!--/.search-->

                                <!-- Tambahkan icon love di sini -->
                                <li class="wishlist">
                                    <a href="{{ route('wishlist.index') }}">
                                        <span class="lnr lnr-heart"></span>
                                    </a>
                                </li><!--/.wishlist-->

                                <li class="nav-user">
                                    @if (Auth::check())
                                        <!-- Jika user sudah login -->
                                        <a href="{{ route('profil') }}" data-bs-toggle="modal"
                                            data-bs-target="#modalProfile" class="border-0">
                                            <span class="lnr lnr-user"></span>
                                        </a>
                                    @else
                                        <!-- Jika user belum login -->
                                        <a href="/login" data-bs-toggle="modal" data-bs-target="#modallogin"
                                            class="border-0">
                                            <span class="lnr lnr-user"></span>
                                        </a>
                                    @endif
                                </li>

                                <li class="dropdown">
                                    <a href="{{ route('cart.index') }}" class="dropdown-toggle"
                                        data-toggle="dropdown">
                                        <span class="lnr lnr-cart"></span>
                                        <span class="badge badge-bg-1">{{ $cartItemsCount }}</span>
                                    </a>
                                </li><!--/.dropdown-->

                            </ul>
                        </div><!--/.attr-nav-->
                        <!-- End Atribute Navigation -->

                        <!-- Start Header Navigation -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#navbar-menu">
                                <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand" href="index.html">Mabel aden safira</a>

                        </div><!--/.navbar-header-->
                        <!-- End Header Navigation -->

                        <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
                            <ul class="nav navbar-nav navbar-center" data-in="fadeInDown" data-out="fadeOutUp">
                                <li class="{{ request()->routeIs('home.index') ? 'active' : '' }}">
                                    <a href="{{ route('home.index') }}">Home</a>
                                </li>



                                <li class="{{ request()->routeIs('home.order') ? 'active' : '' }}">
                                    @if (auth()->check())
                                        <a href="{{ route('home.order') }}">Pesanan Saya</a>
                                    @else
                                        <a href="{{ route('login.form') }}">Pesanan Saya</a>
                                    @endif
                                </li>


                                <!-- Dropdown Kategori -->
                                <li
                                    class="nav-item dropdown {{ request()->routeIs('home.category') ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Kategori
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="{{ route('home.category', $category->id) }}"
                                                    class="dropdown-item {{ request()->routeIs('home.category') && request()->route('id') == $category->id ? 'active' : '' }}">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div><!--/.container-->
                </nav><!--/nav-->
                <!-- End Navigation -->
            </div><!--/.header-area-->
            <div class="clearfix"></div>

        </div><!-- /.top-area-->
        <!-- top-area End -->