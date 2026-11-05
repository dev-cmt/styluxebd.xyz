<ul class="search-suggest-list">
    @foreach ($products as $product)
        <li>
            <a href="{{ $theme->is_active == 1
                ? route('search', ['search_product' => $product->name])
                : route('theme.search', ['path' => $theme->path, 'search_product' => $product->name]) }}"
                class="search-item">

                <img src="{{ asset($product->get_feature_image ? $product->get_feature_image->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                    alt="{{ $product->name }}">
                <div>
                    <div class="product-name" style="font-size:14px; font-weight:600">
                        {{ $product->name }}
                    </div>
                    @if ($product->sale_price > 0)
                        <div class="prices">
                            <span class="new-price" style="font-size: 0.85rem; font-weight: 600; color: #222;">
                                {{ number_format($product->sale_price, 2) }}
                                {{ $web_settings->currency_sign }}
                            </span>
                            <span class="old-price"
                                style="text-decoration: line-through; font-size: 0.85rem;; color: #888;">
                                {{ number_format($product->regular_price, 2) }}
                                {{ $web_settings->currency_sign }}
                            </span>
                        </div>
                        {{-- <p class="old-price" style="text-decoration: line-through; font-size: 0.85rem;; color: #888;">
                            {{ number_format($product->regular_price, 2) }}
                            {{ $web_settings->currency_sign }}
                        </p> --}}
                    @else
                        <p class="new-price">
                            {{ number_format($product->regular_price, 2) }}
                            {{ $web_settings->currency_sign }}
                        </p>
                    @endif
                </div>
            </a>
        </li>
    @endforeach
</ul>

<style>
    /* list container */
    .search-suggest-list {
        list-style: none;
        margin: 0;
        padding: 0;
        max-height: 500px;
        overflow-y: auto;
    }

    /* each item */
    .search-suggest-list li {
        border-bottom: 1px solid #f2f2f2;
    }

    /* clickable row */
    .search-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        text-decoration: none;
        color: #222;
        transition: background .2s ease;
    }

    /* hover effect */
    .search-item:hover {
        background: #f7f7f7;
    }

    /* product image */
    .search-item img {
        width: 40px;
        height: 40px;
        border-radius: 100%;
        object-fit: cover;
        flex-shrink: 0;
    }

    /* product name */
    .product-name {
        font-size: 14px;
        line-height: 1.3;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* mobile */
    @media (max-width: 768px) {
        .search-item img {
            width: 34px;
            height: 34px;
        }

        .product-name {
            font-size: 13px;
        }
    }
</style>
