<div class="footer_nav d-block d-md-none">
    <ul class="list-unstyled">
        <li>
            <a class="toggle menubar text-dark menu-bar-show">
                    <span>
                        <i class="fa fa-solid fa-bars"></i>
                    </span>
                <span>Category</span>
            </a>
        </li>

        <li>
            <a target="_blank" href="https://wa.me/{{ preg_replace('/\D/', '', $web_settings->website_phone) }}" class="text-dark">
                    <span>
                        <i class="fa fa-brands fa-whatsapp"></i>
                    </span>
                <span>Whatsapp</span>
            </a>
        </li>

        <li class="mobile_home">
            <a href="{{ $theme->is_active == 1 ? route('home') : route('theme.home', ['path' => $theme->path]) }}" class="text-white">
                <span><i class="fa fa-solid fa-home"></i></span> <span>Home</span>
            </a>
        </li>

        <li>
            <a class="text-dark cart-icon-open" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <span>
                    <i class="fa fa-shopping-bag"></i>
                </span>
                <span>Cart (<b class="mobilecart-qty">{{ Cart::getContent()->count() ?? 0 }}</b>)</span>
            </a>
        </li>
        <li>
            <a href="" class="text-dark">
                    <span>
                        <i class="fa fa-solid fa-user"></i>
                    </span>
                <span>Login</span>
            </a>
        </li>
    </ul>
</div>
{{-- product cart  --}}


<style>
    .footer_nav {
        /*display: none;*/
        text-align: center;
        padding: 2px 0;
        position: fixed;
        bottom: -5px;
        width: 100%;
        background: #fff;
        z-index: 99999999;
        border-top: 1px solid #ddd;
    }

    .footer_nav ul {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
    }

    .footer_nav ul li a span {
        display: block;
    }

    .footer_nav ul li {
        position: relative;
    }

    .footer_nav ul li i {
        font-size: 16px;
    }

    .item_count {
        position: absolute;
        top: -5px;
        right: 25px;
        background: #19874D;
        width: 15px;
        height: 15px;
        font-size: 12px;
        color: #fff;
        line-height: 15px;
        border-radius: 50px;
    }

    @media only screen and (min-width: 320px) and (max-width: 767px) {
        .footer_nav {
            display: block;
        }
    }

    @media only screen and (min-width: 320px) and (max-width: 767px) {
        li.mobile_home {
            border: 2px solid #ddd;
            margin-top: -35px;
            background: #19874D;
            padding-top: 15px;
            border-radius: 50%;
            width: 75px;
            height: 75px;
        }
    }

    /*==== FOOTER FIXED MENU END ====  */
</style>
<style>
    .checkout-button svg {
        transition: transform 0.3s ease;
    }

    .checkout-button:hover svg {
        transform: translateX(4px);
    }

    .shipping-cart-offcanvas{
        height: 100vh;                 /* default */
    }

    /* Desktop / Laptop */
    @media (min-width: 992px){
        .shipping-cart-offcanvas{
            height: 100vh;
            top: 3vh;                  /* center look */
        }
    }

    /* Tablet */
    @media (max-width: 991px){
        .shipping-cart-offcanvas{
            height: 100vh;
        }
    }

    /* Mobile */
    @media (max-width: 575px){
        .shipping-cart-offcanvas{
            height: 94vh;
            border-radius: 0;
        }
    }
</style>

