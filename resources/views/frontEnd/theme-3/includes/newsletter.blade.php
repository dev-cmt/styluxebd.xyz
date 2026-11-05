<section id="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <div class="newsletter">
                <h5 class="title">
                    <i class="fa-regular fa-envelope"></i>
                    GET SPECIAL DISCOUNTS IN YOUR INBOX
                </h5>
                <form action="{{ $theme->is_active == 1 ? route('frontEnd.newsletter') : route('theme.frontEnd.newsletter', ['path' => $theme->path]) }}" method="post">
                    @csrf
                    <input type="text" name="email" class="newsletter-input" placeholder="Enter email to get offers, discounts and more." required>
                    <button type="submit" class="subscribe-button">Subscribe</button>
                </form>
            </div>
            <div class="company-info">
                <h5 class="title">
                    <i class="fa fa-phone"></i>
                    FOR ANY HELP YOU MAY CALL US AT
                </h5>
                <a href="tel:{{ $web_settings->phone }}">{{ $web_settings->phone }}</a>
                <p>Open 24 Hours a Day, 7 Days a week</p>
            </div>
        </div>
    </div>
</section>
