@php
    $orders = activeThemeData()->orders()->where('status', 1)->count();
    $abandoned_carts = activeThemeData()->ab_orders()->count();
@endphp
<style>
    .navbar .navbar-nav .nav-link {
        padding: 0.5rem 1rem;
        justify-content: flex-start ! important;
    }

    .nav-header {
        font-size: 0.72rem !important;
        letter-spacing: .08em;
        color: #0064e9 !important;
    }
</style>

<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark sidebar" id="sidebar" data-scroll-save="true">
    <div class="container-fluid px-2">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M4 6h16"></path>
                <path d="M4 12h16"></path>
                <path d="M4 18h16"></path>
            </svg>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('admin.home') }}">
                {{ env('APP_NAME') }}
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <div class="d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="javascript:void(0);" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon ti ti-logout"></i> &nbsp;Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <!-- OFFCANVAS SIDEBAR -->
        <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="adminSidebar" style="height: 100vh;">
            <div class="offcanvas-header" style="background-color: slategrey">
                <h5 class="offcanvas-title">
                    <a href="{{ route('admin.home') }}" class="text-white text-decoration-none">
                        {{ env('APP_NAME') }}
                    </a>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body p-0" style="height: 100vh;">
                <ul class="navbar-nav float-left" style="padding-bottom: 50px">

                    @canany(['dashboard.view', 'orders.list', 'customers.list', 'abandoned.cart.list'])
                        <!-- SECTION 1: CORE & OPERATIONS -->
                        <li class="nav-header text-uppercase  fw-bold fs-6 px-3 pt-3 pb-1 opacity-75">
                            Order Management
                        </li>
                    @endcanany

                    @can('dashboard.view')
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center w-100 {{ request()->is('admin') ? 'active' : '' }}"
                                href="{{ route('admin.home') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="currentColor"
                                        class="icon icon-tabler icons-tabler-filled icon-tabler-layout-dashboard">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 3a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 12a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2zm10 -4a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 -8a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2z" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>
                    @endcan

                    @can('orders.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders') || request()->routeIs('admin.orders.create') || request()->routeIs('admin.orders.edit') ? 'active' : '' }} position-relative"
                                href="{{ route('admin.orders') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17h-11v-14h-2" />
                                        <path d="M6 5l14 1l-1 7h-13" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Orders</span>
                                @if ($orders > 0)
                                    <span class="badge bg-orange">{{ $orders }}</span>
                                @endif
                            </a>
                        </li>
                    @endcan
                    {{-- DUPLICATE ORDERS MENU --}}
                    @can('abandoned.cart.list')
                        <li class="nav-item">
                            <a class="nav-link position-relative {{ request()->is('admin/abandoned-cart') ? 'active' : '' }}"
                                href="{{ route('admin.abandoned.cart') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart-x">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17h-11v-14h-2" />
                                        <path d="M6 5l7.999 4.999m4.001 -2.999l2 -1l-1 7h-13" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Incomplete Orders</span>
                                @if ($abandoned_carts > 0)
                                    <span class="badge bg-orange">{{ $abandoned_carts }}</span>
                                @endif
                            </a>
                        </li>
                    @endcan

                    @can('customers.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-customers*') ? 'active' : '' }}"
                                href="{{ route('admin.customers') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Customers</span>
                            </a>
                        </li>
                    @endcan

                    @canany(['products.list', 'products.combo.list', 'categories.list'])
                        <!-- SECTION 2: PRODUCTS & CATEGORIES -->
                        <li class="nav-header text-uppercase fw-bold fs-6 px-3 pt-3 pb-1 opacity-75">
                            Products & Categories
                        </li>
                    @endcan

                    @can('products.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-product*') ? 'active' : '' }}"
                                href="{{ route('admin.product') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-package">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                        <path d="M12 12l8 -4.5" />
                                        <path d="M12 12l0 9" />
                                        <path d="M12 12l-8 -4.5" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Products</span>
                            </a>
                        </li>
                    @endcan

                    @can('products.combo.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/combo-product*') ? 'active' : '' }}"
                                href="{{ route('admin.combo-products.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-producthunt">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 16v-8h2.5a2.5 2.5 0 1 1 0 5h-2.5" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Combo Products</span>
                            </a>
                        </li>
                    @endcan

                    @can('categories.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-category*') ? 'active' : '' }}"
                                href="{{ route('admin.category') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-sitemap">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path
                                            d="M15 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path
                                            d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path d="M6 15v-1a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v1" />
                                        <path d="M12 9l0 3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Categories</span>
                            </a>
                        </li>
                    @endcan



                    @if ($web_settings->stock_management == 1)
                        <!-- SECTION 3: MARKETING & SALES -->
                        @canany(['purchases.list', 'suppliers.list', 'stock.control', 'stock.adjustment'])
                            <li class="nav-header text-uppercase fw-bold fs-6 px-3 pt-3 pb-1 opacity-75">
                                Stock Management
                            </li>
                        @endcanany
                        @canany(['purchases.list', 'suppliers.list'])
                            @can('suppliers.list')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin-supplier*') ? 'active' : '' }}"
                                        href="{{ route('admin.supplier') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-users-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                <path d="M16 19h6" />
                                                <path d="M19 16v6" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">Suppliers</span>
                                    </a>
                                </li>
                            @endcan
                            @can('purchases.list')
                                <li class="nav-item">
                                    <a class="nav-link d-flex justify-content-between align-items-center"
                                        data-bs-toggle="collapse" href="#stockMenu" role="button"
                                        aria-expanded="{{ request()->is('admin-purchase-recieve*') || request()->is('admin-purchase*') ? 'true' : 'false' }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                    <path
                                                        d="M15 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                    <path
                                                        d="M9 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                    <path d="M4 20h14" />
                                                </svg>
                                            </span>
                                            <span class="nav-link-title">Purchases</span>
                                        </div>
                                        <span class="ms-auto"><i class="ti ti-chevron-down toggle-icon"></i></span>
                                    </a>
                                    <div class="collapse {{ request()->is('admin-purchase*') || request()->is('admin/purchase-recieve*') ? 'show' : '' }}"
                                        id="stockMenu">
                                        <ul class="nav flex-column ms-3 mt-2">
                                            @can('purchases.list')
                                                <li class="nav-item">
                                                    <a class="nav-link {{ request()->is('admin-purchase*') ? 'active' : '' }}"
                                                        href="{{ route('admin.purchase') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-point" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="4"></circle>
                                                        </svg>&nbsp;Purchase List
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('purchases.list')
                                                <li class="nav-item">
                                                    <a class="nav-link {{ request()->is('admin/purchase-recieve*') ? 'active' : '' }}"
                                                        href="{{ route('admin.purchase.recieve') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-point" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="4"></circle>
                                                        </svg>&nbsp;Purchase Receive
                                                    </a>
                                                </li>
                                            @endcan


                                        </ul>
                                    </div>
                                </li>
                            @endcan
                            @can('stock.control')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/stock-control*') ? 'active' : '' }}"
                                        href="{{ route('admin.stock.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-horizontal">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 6a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M4 6l8 0" />
                                                <path d="M16 6l4 0" />
                                                <path d="M6 12a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M4 12l2 0" />
                                                <path d="M10 12l10 0" />
                                                <path d="M15 18a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M4 18l11 0" />
                                                <path d="M19 18l1 0" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">Stock Control</span>
                                    </a>
                                </li>
                            @endcan

                            {{-- stock adjustment --}}
                            @can('stock.adjustment')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/stock-adjustment*') ? 'active' : '' }}"
                                        href="{{ route('admin.stock.adjustment') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 10a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M6 4v4" />
                                                <path d="M6 12v8" />
                                                <path d="M10 16a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M12 4v10" />
                                                <path d="M12 18v2" />
                                                <path d="M16 7a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M18 4v1" />
                                                <path d="M18 9v11" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">Stock Adjustment</span>
                                    </a>
                                </li>
                            @endcan
                        @endcanany
                    @endif


                    @canany(['landing.page.list', 'coupons.list', 'flash.deal.list', 'promotion_banner.list',
                        'marketing.list', 'newsletter.list'])
                        <!-- SECTION 3: MARKETING & SALES -->
                        <li class="nav-header text-uppercase fw-bold fs-6 px-3 pt-3 pb-1 opacity-75">
                            Marketing & Promotions
                        </li>
                    @endcanany

                    @can('landing.page.list')
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#landingMenu" role="button"
                                aria-expanded="{{ request()->is('admin/landing*') ? 'true' : 'false' }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-browser">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M4 4m0 1a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1z" />
                                            <path d="M4 8l16 0" />
                                            <path d="M8 4l0 4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Landing Pages</span>
                                </div>
                                <span class="ms-auto"><i class="ti ti-chevron-down toggle-icon"></i></span>
                            </a>
                            <div class="collapse {{ request()->is('admin/landing*') ? 'show' : '' }}" id="landingMenu">
                                <ul class="nav flex-column ms-3 mt-2">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/landing/pages') ? 'active' : '' }}"
                                            href="{{ route('admin.landing.pages.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="4"></circle>
                                            </svg>&nbsp;Landing Page
                                        </a>
                                    </li>
                                    @if (Auth::guard('admin')->user()->role_id == 1)
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/landing/theme') ? 'active' : '' }}"
                                                href="{{ route('admin.landing.theme.index') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Manage Theme
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/landing/category') ? 'active' : '' }}"
                                                href="{{ route('admin.landing.category.index') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Manage Category
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('coupons.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}"
                                href="{{ route('admin.coupons.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 5h14v14h-14z" />
                                        <path d="M5 12h14" />
                                        <path d="M12 5v14" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Coupons</span>
                            </a>
                        </li>
                    @endcan

                    @can('flash.deal.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/flash-deal*') ? 'active' : '' }}"
                                href="{{ route('admin.flash.deals.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-flame"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3c0 3 -4 4 -4 9a4 4 0 0 0 8 0c0 -5 -4 -6 -4 -9z" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Flash Deals</span>
                            </a>
                        </li>
                    @endcan

                    @can('promotion_banner.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-promotional-banner*') ? 'active' : '' }}"
                                href="{{ route('admin.promotional.banner.edit') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-photo-spark">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M15 8h.01" />
                                        <path d="M11.5 21h-5.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5" />
                                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3 3" />
                                        <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Promotional Banner</span>
                            </a>
                        </li>
                    @endcan

                    @can('marketing.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.marketing.api') ? 'active' : '' }}"
                                href="{{ route('admin.marketing.api') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-target"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="12" cy="12" r="9" />
                                        <circle cx="12" cy="12" r="5" />
                                        <circle cx="12" cy="12" r="1" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Marketing</span>
                            </a>
                        </li>
                    @endcan

                    @can('newsletter.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-newsletter*') ? 'active' : '' }}"
                                href="{{ route('admin.newsletter') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="3" y="5" width="18" height="14" rx="2" />
                                        <polyline points="3 7 12 13 21 7" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Newsletter</span>
                            </a>
                        </li>
                    @endcan

                    @canany(['sliders.list', 'media.list', 'review.list', 'testimonial.list'])
                        <!-- SECTION 4: CONTENT & STOREFRONT -->
                        <li class="nav-header text-uppercase  fw-bold fs-6 px-3 pt-3 pb-1 opacity-75">
                            Content Management
                        </li>
                    @endcan

                    @can('sliders.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-slider*') ? 'active' : '' }}"
                                href="{{ route('admin.sliders') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-slideshow">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M15 6l.01 0" />
                                        <path
                                            d="M3 3m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                        <path d="M3 13l4 -4a3 5 0 0 1 3 0l4 4" />
                                        <path d="M13 12l2 -2a3 5 0 0 1 3 0l3 3" />
                                        <path d="M8 21l.01 0" />
                                        <path d="M12 21l.01 0" />
                                        <path d="M16 21l.01 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Sliders</span>
                            </a>
                        </li>
                    @endcan

                    @can('media.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-media*') ? 'active' : '' }}"
                                href="{{ route('admin.media') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-folders">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 3h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <path d="M17 16v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Media</span>
                            </a>
                        </li>
                    @endcan

                    @can('review.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/review*') ? 'active' : '' }}"
                                href="{{ route('admin.reviews') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-star">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 17.25l-4.69 2.76l1.09 -6.32l-3.59 -3.5l6.29 -.91l2.81 -5.69l2.81 5.69l6.29 .91l-3.59 3.5l1.09 6.32l-4.69 -2.76">
                                        </path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">Reviews</span>
                            </a>
                        </li>
                    @endcan

                    @can('testimonial.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/testimonial*') ? 'active' : '' }}"
                                href="{{ route('admin.testimonials.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-message-2-share">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 21l-4 -4h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6" />
                                        <path d="M16 22l5 -5" />
                                        <path d="M21 21.5v-4.5h-4.5" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Testimonial</span>
                            </a>
                        </li>
                    @endcan

                    {{-- @if (Auth::guard('admin')->user()->role_id == 1)
                        @can('theme.list')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/themes') ? 'active' : '' }}"
                                    href="{{ route('admin.themes.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-screen-share">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <rect x="3" y="4" width="18" height="14" rx="2" />
                                            <path d="M7 20h10M12 16v4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Themes</span>
                                </a>
                            </li>
                        @endcan
                    @endif --}}

                    @canany(['accounts.list', 'expenses.category.list', 'accounts.transaction.list', 'reports.sales',
                        'reports.sales.products', 'reports.stock.products'])
                        <!-- SECTION 5: FINANCE & REPORTS -->
                        <li class="nav-header text-uppercase fw-bold fs-6 px-3 pt-3 pb-1 opacity-75">
                            Accounts & Reports
                        </li>
                    @endcanany

                    @canany(['accounts.list', 'expenses.category.list', 'accounts.transaction.list'])
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center collapsed"
                                data-bs-toggle="collapse" href="#financeMenu">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-coins">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z" />
                                            <path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" />
                                            <path
                                                d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z" />
                                            <path d="M3 6v10c0 .888 .772 1.45 2 2" />
                                            <path d="M3 11c0 .888 .772 1.45 2 2" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Finance</span>
                                </div>
                                <i class="ti ti-chevron-down toggle-icon"></i>
                            </a>
                            <div class="collapse {{ request()->is('admin/accounts') || request()->is('admin/account-transactions') || request()->is('admin/expense*') || request()->is('admin/services') ? 'show' : '' }}"
                                id="financeMenu">
                                <ul class="nav flex-column ms-3 mt-2">
                                    @can('accounts.list')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/accounts') ? 'active' : '' }}"
                                                href="{{ route('admin.account.index') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Accounts
                                            </a>
                                        </li>
                                    @endcan
                                    @can('accounts.transaction.list')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/account-transactions') ? 'active' : '' }}"
                                                href="{{ route('admin.account.transaction.index') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Transactions
                                            </a>
                                        </li>
                                    @endcan
                                    <!-- Service Payment Submenu Added Here -->
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}"
                                            href="{{ route('admin.services.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="4"></circle>
                                            </svg>&nbsp;Service
                                        </a>
                                    </li>
                                    @canany(['expenses.list', 'expenses.category.list'])
                                        <li class="nav-item">
                                            <a class="nav-link d-flex justify-content-between align-items-center collapsed"
                                                data-bs-toggle="collapse" href="#expenseMenu">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-point" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="4"></circle>
                                                    </svg>&nbsp;Expenses
                                                </span>
                                                <i class="ti ti-chevron-down toggle-icon"></i>
                                            </a>
                                            <div class="collapse {{ request()->is('admin/expense*') ? 'show' : '' }}"
                                                id="expenseMenu">
                                                <ul class="nav flex-column ms-3 mt-1">
                                                    @can('expenses.category.list')
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ request()->is('admin/expense-categories') ? 'active' : '' }}"
                                                                href="{{ route('admin.expense.category.index') }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-point" width="24"
                                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <circle cx="12" cy="12" r="4"></circle>
                                                                </svg>&nbsp;Categories
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    @can('expenses.list')
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ request()->is('admin/expenses') ? 'active' : '' }}"
                                                                href="{{ route('admin.expense.index') }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-point" width="24"
                                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <circle cx="12" cy="12" r="4"></circle>
                                                                </svg>&nbsp;Expense List
                                                            </a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany

                    @canany(['reports.sales', 'reports.sales.products', 'reports.stock.products',
                        'reports.balance.sheet'])
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center collapsed"
                                data-bs-toggle="collapse" href="#reportMenu">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-analytics">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M9 17l0 -5" />
                                            <path d="M12 17l0 -1" />
                                            <path d="M15 17l0 -3" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Reports</span>
                                </div>
                                <i class="ti ti-chevron-down toggle-icon"></i>
                            </a>
                            <div class="collapse {{ request()->is('admin/report*') ? 'show' : '' }}" id="reportMenu">
                                <ul class="nav flex-column ms-3 mt-2">
                                    @can('reports.sales')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-sales-orders') ? 'active' : '' }}"
                                                href="{{ route('admin.report.sales.order') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Sales
                                            </a>
                                        </li>
                                    @endcan
                                    @can('reports.sales.products')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-sales-products') ? 'active' : '' }}"
                                                href="{{ route('admin.report.sales.product') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Sales Product
                                            </a>
                                        </li>
                                    @endcan
                                    @can('reports.stock.products')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-product-stock') ? 'active' : '' }}"
                                                href="{{ route('admin.report.product.stock') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Stock Report
                                            </a>
                                        </li>
                                    @endcan

                                    @can('reports.balance.sheet')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-balance') ? 'active' : '' }}"
                                                href="{{ route('admin.report.balance') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Balance Sheet
                                            </a>
                                        </li>
                                    @endcan

                                    {{-- @endcan --}}
                                    {{-- @can('reports.profit.loss')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-profit-loss') ? 'active' : '' }}"
                                                href="{{ route('admin.report.profit.loss') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Profit/Loss
                                            </a>
                                        </li>
                                    @endcan --}}
                                    {{-- @can('reports.account.transaction')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-account-trans') ? 'active' : '' }}"
                                                href="{{ route('admin.report.account.trans') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;ACC Trans.
                                            </a>
                                        </li>
                                    @endcan
                                    @can('reports.product.stock')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-product-stock') ? 'active' : '' }}"
                                                href="{{ route('admin.report.product.stock') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Product Stocks
                                            </a>
                                        </li>
                                    @endcan
                                    @can('reports.courier')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-courier') ? 'active' : '' }}"
                                                href="{{ route('admin.report.courier') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Couriers
                                            </a>
                                        </li>
                                    @endcan
                                    @can('reports.products')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/report-product') ? 'active' : '' }}"
                                                href="{{ route('admin.report.product') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Products
                                            </a>
                                        </li>
                                    @endcan --}}
                                </ul>
                            </div>
                        </li>
                    @endcan

                    @canany(['shipping_method.list', 'couriers.list', 'visitors.list', 'ip_address.list',
                        'device.list'])
                        <!-- SECTION 6: LOGISTICS & ANALYTICS -->
                        <li class="nav-header text-uppercase  fw-bold fs-6 px-3 pt-3 pb-1 opacity-75">
                            Logistics & Analytics
                        </li>
                    @endcanany

                    @can('shipping_method.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-shipping_methods*') ? 'active' : '' }}"
                                href="{{ route('admin.shipping_methods') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                        <path d="M3 9l4 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Shipping Methods</span>
                            </a>
                        </li>
                    @endcan

                    @can('couriers.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-courier*') ? 'active' : '' }}"
                                href="{{ route('admin.courier') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-bike">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M19 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M12 19l0 -4l-3 -3l5 -4l2 3l3 0" />
                                        <path d="M17 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Couriers</span>
                            </a>
                        </li>
                    @endcan

                    @can('visitors.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-visitor*') ? 'active' : '' }}"
                                href="{{ route('admin.visitor.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-message-user">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M13 18l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                                        <path d="M19 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M22 22a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Visitors</span>
                            </a>
                        </li>
                    @endcan

                    @can('ip_address.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-ip-address*') ? 'active' : '' }}"
                                href="{{ route('admin.ip.address') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-pins">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10.828 9.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" />
                                        <path d="M8 7l0 .01" />
                                        <path d="M18.828 17.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" />
                                        <path d="M16 15l0 .01" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">IP Address</span>
                            </a>
                        </li>
                    @endcan

                    @can('device.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/device*') ? 'active' : '' }}"
                                href="{{ route('admin.device') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-chrome">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M12 9h8.4" />
                                        <path d="M14.598 13.5l-4.2 7.275" />
                                        <path d="M9.402 13.5l-4.2 -7.275" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Devices</span>
                            </a>
                        </li>
                    @endcan

                    @canany(['settings.courier_api', 'staffs.list', 'roles.list', 'settings.general', 'settings.page',
                        'settings.print', 'settings.home.page'])

                        <!-- SECTION 7: ADMINISTRATION & SETTINGS -->
                        <li class="nav-header text-uppercase  fw-bold fs-6 px-3 pt-3 pb-1 opacity-75">
                            Administration & Settings
                        </li>
                    @endcanany

                    @can('settings.courier_api')
                        <li class="nav-item {{ request()->is('admin/api-courier*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.api.courier.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-truck-delivery" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                        <path d="M3 9l4 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Courier API</span>
                            </a>
                        </li>
                    @endcan

                    @can('staffs.list')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/staff*') ? 'active' : '' }} {{ Auth::guard('admin')->user()->role_id != 1 ? 'is-demo' : '' }}"
                                href="{{ route('admin.staff.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-square-rounded">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                        <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                        <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Staffs</span>
                            </a>
                        </li>
                    @endcan

                    @if ($web_settings->is_demo == 0 || Auth::guard('admin')->user()->role_id == 1)
                        @can('roles.list')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/role*') ? 'active' : '' }} {{ Auth::guard('admin')->user()->role_id != 1 ? 'is-demo' : '' }}"
                                    href="{{ route('admin.role.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-shield-lock">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                                            <path d="M12 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M12 12l0 2.5" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Roles & Permissions</span>
                                </a>
                            </li>
                        @endcan
                    @endif

                    @canany(['settings.general', 'settings.page', 'settings.print', 'settings.home.page'])
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center collapsed"
                                data-bs-toggle="collapse" href="#settingsMenu">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-settings" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                            </path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Settings</span>
                                </div>
                                <i class="ti ti-chevron-down toggle-icon"></i>
                            </a>
                            <div class="collapse {{ request()->is('admin-settings*') || request()->is('admin-api*') ? 'show' : '' }}"
                                id="settingsMenu">
                                <ul class="nav flex-column ms-3 mt-2">
                                    @can('settings.general')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin-settings-web') ? 'active' : '' }}"
                                                href="{{ route('admin.settings.web') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Web
                                            </a>
                                        </li>
                                    @endcan
                                    @can('settings.page')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin-settings-page') ? 'active' : '' }}"
                                                href="{{ route('admin.settings.page') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Page
                                            </a>
                                        </li>
                                    @endcan
                                    @can('settings.print')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin-settings-print') ? 'active' : '' }}"
                                                href="{{ route('admin.settings.print') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Print
                                            </a>
                                        </li>
                                    @endcan
                                    @can('settings.home.page')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin-settings-home-page') ? 'active' : '' }}"
                                                href="{{ route('admin.settings.home.page') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Home Page
                                            </a>
                                        </li>
                                    @endcan
                                    @can('settings.attribute')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin-settings-attribute') ? 'active' : '' }}"
                                                href="{{ route('admin.settings.attribute') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-point" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                </svg>&nbsp;Attribute
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        </li>
                    @endcan

                </ul>
            </div>
        </div>
    </div>
</aside>
