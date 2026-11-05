@php
    $categories = \App\Category::where('status', 1)
        ->where('parent_id', null)
        ->where('theme_id', $theme->id)
        ->with('children', 'childrenRecursive')
        ->get();
@endphp
<style>
    /* ... previous styles ... */

    /* Logo adjustment styles */
    .bottom-nav.custom-nav .logo img {
        max-height: 85px;
        /* Adjust this value based on your preferred logo height */
        width: auto;
        object-fit: contain;
    }
</style>
<header>
    <nav class="top-nav">
        <div class="left-content">
            <a href="#" class="flash-on">
                {{-- <img src="assets/images/flash-on.png" alt="">
                <span>
                    EXCLUSIVE T-SHIRTS ON SALE |
                    <span>Limited time only</span>
                </span>
                <i class="fa fa-arrow-circle-right"></i> --}}
            </a>
        </div>
        <div class="right-content">
            <div class="corporate-sale">
                <a
                    href="{{ $theme->is_active == 1 ? route('track.order') : route('theme.track.order', ['path' => $theme->path]) }}">
                    <i class="fa fa-truck"></i>
                    Track Order
                </a>
            </div>
            {{-- <div class="login">
                <a href=" --}}{{-- {{ route('user.login.form') }} --}}{{-- ">
                    <i class="fa fa-sign-in"></i>
                    Login
                </a>
                <ul class="login-content">
                    <li><a href=" --}}{{-- {{ route('user.login.form') }} --}}{{-- ">Login</a></li>
                    <li><a href=" --}}{{-- {{ route('user.register.form') }} --}}{{-- ">Register</a></li>
                     <li><a href="">Order Tracking</a></li>
                </ul>
            </div> --}}
        </div>
    </nav>
    <nav class="bottom-nav custom-nav">
        <div class="menu-bar menu-bar-show px-2"
            data-page="{{ request()->is('category-products*') ? 'category_page' : '' }}">
            <i class="fa fa-bars"></i>
            {{--            <img src="{{ asset('frontEnd/'.$theme->path.'/assets/images/menu_icon.png') }}" alt=""> --}}
        </div>
        {{-- @dd($web_settings->get_header); --}}
        <a class="logo"
            href="{{ $theme->is_active == 1 ? route('home') : route('theme.home', ['path' => $theme->path]) }}">
            <img class="ms-lg-5"
                src="{{ isset($web_settings->get_header) ? asset($web_settings->get_header->file_url) : ' ' }}"
                alt="Logo" />
        </a>

        <div class="category">
            <a href="javascript:void(0);" class="category-dropdown">
                Shop
                <svg focusable="false" viewBox="0 0 16 14" width="10" height="10"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M.116 4.884l1.768-1.768L8 9.232l6.116-6.116 1.768 1.768L8 12.768.116 4.884z"></path>
                </svg>
            </a>

            <div class="category-menu" style="overflow-y: scroll;">
                <div class="w-100 mb-3 d-lg-none d-block">
                    <a class="w-100 btn btn-sm border  form-control"
                        href="{{ $theme->is_active == 1 ? route('track.order') : route('theme.track.order', ['path' => $theme->path]) }}">
                        <i class="fa fa-truck"></i>
                        Track Order
                    </a>
                </div>

                @foreach ($categories as $key => $category)
                    <div class="parent-menu">
                        <a href="{{ $theme->is_active == 1 ? route('single.category', $category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $category->slug]) }}"
                            class="submenu-dropdown">
                            {{ $category->category_name }}
                            @if ($category->children->count() > 0)
                                <i class="fa-solid fa-plus toggle-btn"></i>
                            @endif
                        </a>
                        @if ($category->children->count() > 0)
                            <ul class="submenu-content">
                                @foreach ($category->children as $sub_category)
                                    <li>
                                        <a
                                            href="{{ $theme->is_active == 1 ? route('single.category', $sub_category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $sub_category->slug]) }}">
                                            {{ $sub_category->category_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>


        <div class="search">
            <form
                action="{{ $theme->is_active == 1 ? route('search') : route('theme.search', ['path' => $theme->path]) }}"
                id="search-form" method="GET">
                <div class="search">
                    <input type="text" name="search_product" class="form-control search-input search_product"
                        placeholder="Search Products by Titles or Tags" autocomplete="off"
                        value="{{ request()->query('search_product') }}">
                </div>
                <button class="search-button" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <div class="put_search_product">

            </div>
        </div>
        <div id="track-order-link" class="d-none my-2">
            <a class="text-dark btn d-none d-lg-block btn-sm border border-1"
                href="{{ $theme->is_active == 1 ? route('track.order') : route('theme.track.order', ['path' => $theme->path]) }}">
                <i class="fa fa-truck"></i>
                Track Order
            </a>
        </div>
        <div class="cart">
            <a href="{{ $theme->is_active == 1 ? route('cart.page') : route('theme.cart.page', ['path' => $theme->path]) }}"
                class="">
                <i class="fa fa-shopping-cart"></i>
                <span class="badge bg-primary shopping-cart-badge cart-count"
                    style="font-size: .6rem; font-weight: bold; margin-left: 0; margin-right: -26px;">
                    {{ count(\Cart::getContent()) }}
                </span>

            </a>
        </div>

    </nav>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.querySelectorAll(".toggle-btn").forEach(function(btn) {
            btn.addEventListener("click", function(e) {
                e.preventDefault(); // prevent the link click
                e.stopPropagation(); // prevent event bubbling

                const parent = this.closest(".parent-menu");
                const submenu = parent.querySelector(".submenu-content");

                // Toggle the submenu visibility
                submenu.classList.toggle("show");
                this.classList.toggle("fa-plus");
                this.classList.toggle("fa-minus");
            });
        });

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const trackOrder = document.getElementById('track-order-link');
        const header = document.querySelector('header'); // replace with your header selector

        window.addEventListener('scroll', function() {
            // Check if header has sticky class OR scroll position
            if (header.classList.contains('sticky') || window.scrollY > 100) {
                trackOrder.classList.remove('d-none');
                trackOrder.classList.add('d-block');
            } else {
                trackOrder.classList.remove('d-block');
                trackOrder.classList.add('d-none');
            }
        });
    });
</script>
