@php
    $categories = \App\Category::where('status', 1)
        ->where('theme_id', $theme->id)
        ->whereNull('parent_id')
        ->limit(5)
        ->get();
    $footer = \App\HomePageSetting::where('section', 'footer')->where('theme_id', $theme->id)->first();
@endphp
<section id="footer-section">
    <div class="container">
        <div class="footer-content">
            <div class="important-link">
                <div class="">
                    <a href="{{ $theme->is_active == 1 ? route('home') : route('theme.home', ['path' => $theme->path]) }}"
                        class="d-inline-block mb-3">
                        <img width="150px" style="object-fit: contain;"
                            src="{{ isset($web_settings->get_footer) ? asset($web_settings->get_footer->file_url) : ' ' }}"
                            alt="Footer Logo">
                    </a>
                </div>
                <ul>
                    <li><a
                            href="{{ $theme->is_active == 1 ? route('about_us') : route('theme.about_us', ['path' => $theme->path]) }}">About
                            Us</a></li>
                    <li><a
                            href="{{ $theme->is_active == 1 ? route('contact_us') : route('theme.contact_us', ['path' => $theme->path]) }}">Contact
                            Us</a></li>
                    <li><a
                            href="{{ $theme->is_active == 1 ? route('terms_condition') : route('theme.terms_condition', ['path' => $theme->path]) }}">Terms
                            & Conditions</a></li>
                    <li><a
                            href="{{ $theme->is_active == 1 ? route('privacy_policy') : route('theme.privacy_policy', ['path' => $theme->path]) }}">Privacy
                            Policy</a></li>
                    <li><a
                            href="{{ $theme->is_active == 1 ? route('return_policy') : route('theme.return_policy', ['path' => $theme->path]) }}">Return
                            & Refund Policy</a></li>
                    <li><a
                            href="{{ $theme->is_active == 1 ? route('how_to_order') : route('theme.how_to_order', ['path' => $theme->path]) }}">How
                            to Order</a></li>
                    <li><a
                            href="{{ $theme->is_active == 1 ? route('why_us') : route('theme.why_us', ['path' => $theme->path]) }}">Why
                            Us</a></li>
                </ul>
            </div>
            @foreach ($categories as $category)
                <div class="important-link">
                    <h5 class="title">
                        <a class="title"
                            href="{{ $theme->is_active == 1 ? route('single.category', $category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $category->slug]) }}">{{ $category->category_name }}</a>
                    </h5>
                    @if (count($category->children) > 0)
                        <ul>
                            @foreach ($category->children->take(7) as $sub_category)
                                <li>
                                    <a
                                        href="{{ $theme->is_active == 1 ? route('single.category', $sub_category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $sub_category->slug]) }}">{{ $sub_category->category_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
            <div class="important-link footer-contact text-white">

                <h5 class="title">Stay Connected</h5>

                <!-- Contact Info -->
                <ul class="contact-info list-unstyled">

                    <li>
                        <i class="fa fa-map-marker-alt me-2 text-white"></i>
                        <span class="text-white">{{ $web_settings->website_address }}</span>
                    </li>

                    <li>
                        <i class="fa fa-phone me-2 text-white"></i>
                        <span class="text-white"><a
                                href="tel:+{{ $web_settings->website_phone }}">{{ $web_settings->website_phone }}</a></span>
                    </li>

                    <li>
                        <i class="fa fa-envelope me-2 text-white"></i>
                        <span class="text-white text-lowercase">
                            <a class="text-lowercase"
                                href="mailto:{{ $web_settings->website_email }}">{{ $web_settings->website_email }}</a>
                        </span>
                    </li>

                </ul>
                <div class="footer-social mt-3">
                    @if ($web_settings->website_facebook)
                        <a href="{{ $web_settings->website_facebook }}" target="_blank"
                            class="social-btn text-white p-2"><i class="fa fa-facebook-f"></i></a>
                    @endif
                    @if ($web_settings->website_twitter)
                        <a href="{{ $web_settings->website_twitter }}" target="_blank"
                            class="social-btn text-white p-2"><i class="fa fa-twitter"></i></a>
                    @endif
                    @if ($web_settings->website_instagram)
                        <a href="{{ $web_settings->website_instagram }}" target="_blank"
                            class="social-btn text-white p-2"><i class="fa fa-instagram"></i></a>
                    @endif
                    @if ($web_settings->website_youtube)
                        <a href="{{ $web_settings->website_youtube }}" target="_blank"
                            class="social-btn text-white p-2"><i class="fa fa-youtube"></i></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="ssl-section text-center mt-4">
            <p class="secure-title mb-2">100% Secure Payment & Trusted Checkout</p>
            <div class="ssl-badge">
                <img src="{{ asset($footer->content['payment_url']) }}" alt="Secure Payment">
            </div>
        </div>
    </div>
</section>
<style>
    .footer-contact .title {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .newsletter-form input {
        height: 42px;
        border-radius: 6px;
    }

    .newsletter-form button {
        height: 42px;
        border-radius: 6px;
        padding: 0 18px;
    }

    .contact-info li {
        margin-bottom: 10px;
        font-size: 14px;
        color: #555;
        display: flex;
        align-items: center;
    }

    .contact-info i {
        color: #000;
        width: 20px;
    }

    .ssl-section {
        padding: 20px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .secure-title {
        font-size: 14px;
        color: #ccc;
        letter-spacing: 0.5px;
    }

    .ssl-badge {
        display: inline-block;
        background: #fff;
        padding: 10px 18px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    }

    .ssl-badge img {
        /*height: 40px;*/
        object-fit: fill;
    }
</style>
