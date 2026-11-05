<style>
    .variant-group {
        margin-bottom: 15px;
    }

    .variant-label {
        font-weight: 600;
        display: block;
        margin-bottom: 5px;
    }

    .variant-items {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .variant-items input {
        display: none;
    }

    .variant-item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 8px;
        border: 1px solid #ddd;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .variant-item.active,
    .variant-item:hover {
        border-color: #000;
        box-shadow: 0 2px 6px rgba(127, 173, 57, 0.3);
    }

    .variant-item img {
        max-width: 50px;
        max-height: 50px;
        border-radius: 5px;
    }
</style>
<div class="row">
    <div class="col-md-4 col-6">
        <div class="product-image">
            <img src="{{ asset($product->get_feature_image ? $product->get_feature_image->file_url : 'frontEnd/assets/images/no_image.png') }}"
                alt="{{ $product->name }}">
        </div>
    </div>
    <div class="col-md-8 col-6">
        <form
            action="{{ $theme->is_active != 1 ? route('theme.add.cart', ['path' => $theme->path]) : route('add.cart') }}"
            id="addToCartForm" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="product-details">
                <h4 class="product-name">{{ substr($product->name, 0, 100) . '...' }}</h4>
                <div class="price">
                    <p>{{ $web_settings ? $web_settings->currency_sign : 'TK' }}<span id="old-price"
                            class="old-price">{{ number_format($product->regular_price, 2) }}</span>
                    </p>
                    <p>{{ $web_settings ? $web_settings->currency_sign : 'TK' }}<span id="new-price"
                            class="new-price">{{ number_format($product->sale_price, 2) }}</span></p>
                </div>
            </div>
            <div class="product-variant">
                @if ($product->has_variant && $product->get_variants && count($product->get_variants) > 0)
                    @foreach ($product->get_attribute_with_items() as $attributeBlock)
                        @php
                            $attribute = $attributeBlock['attribute'];
                            $items = $attributeBlock['items'];
                        @endphp

                        <div class="variant-group mb-3">
                            {{-- Attribute Name --}}
                            <label class="variant-label fw-bold d-block mb-2">
                                {{ ucfirst($attribute->name) }}: <span class="variant-name"></span>
                            </label>

                            {{-- Items --}}
                            <div class="variant-items d-flex flex-wrap gap-2">
                                @foreach ($items as $key => $item)
                                    @php
                                        $isImageType = $attribute->is_image ?? false;
                                        $itemImage =
                                            $isImageType && $item->item_image ? asset($item->item_image->file_url) : '';
                                    @endphp

                                    @if ($isImageType && $itemImage)
                                        <label class="variant-item variant-item-image {{ $key == 0 ? 'active' : '' }}">
                                            <input type="radio" class="attr_checkbox attr_image_checkbox d-none"
                                                name="attribute_item_id[{{ $attribute->id }}]"
                                                data-image="{{ $itemImage }}"
                                                value="{{ $item->attribute_item_id }}" {{-- ✅ AttributeItem এর মূল id --}}
                                                {{ $key == 0 ? 'checked' : '' }}>
                                            <img class="img-fluid" src="{{ $itemImage }}"
                                                alt="{{ $item->name }}">
                                        </label>
                                    @else
                                        <label class="variant-item text-btn {{ $key == 0 ? 'active' : '' }}">
                                            <input type="radio" class="attr_checkbox d-none"
                                                name="attribute_item_id[{{ $attribute->id }}]"
                                                value="{{ $item->attribute_item_id }}" {{-- ✅ AttributeItem এর মূল id --}}
                                                {{ $key == 0 ? 'checked' : '' }}>
                                            {{ ucfirst($item->name) }}
                                        </label>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="cart-container">
                <div class="product-quantity my-lg-0 my-2">
                    <span class="quantity-minus-button"><i class="fa fa-minus"></i></span>
                    <input type="number" name="quantity" class="quantity-input" min="1" value="1" readonly>
                    <span class="quantity-plus-button"><i class="fa fa-plus"></i></span>
                </div>
                @if ($type == 'addToCart')
                    <button type="submit" value="addToCart" class="add-to-cart-button">
                        <i class="fa fa-plus"></i> Add To Cart
                    </button>
                    <input type="hidden" name="add_cart" value="add_cart">
                @else
                    <button type="submit" value="buy_now" class="add-to-cart-button">
                        <i class="fa fa-bolt"></i> Buy Now
                    </button>
                    <input type="hidden" name="buy_now" value="buy_now">
                @endif
            </div>
        </form>
    </div>
</div>

<script>
    $(document).on('click', '.product-slider-item', function() {
        let imgUrl = $(this).find('img').attr('src');
        $('.product-slider-image').find('img').attr('src', imgUrl);
    });

    function getAttributes() {
        const attribute_item_id = [];
        $('.variant-item input:checked').each(function() {
            attribute_item_id.push($(this).val());
        });

        $.ajax({
            url: "{{ $theme->is_active != 1 ? route('theme.ajax.get.attributes', ['path' => $theme->path]) : route('ajax.get.attributes') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                product_id: {{ $product->id }},
                attribute_item_id: attribute_item_id
            },
            success: function(res) {
                if (res.success == 200) {
                    $('.loaderr').show();
                    const data = res.data;

                    // Update price
                    const salePrice = parseFloat(data.sale_price) || 0;
                    const regularPrice = parseFloat(data.regular_price) || 0;
                    $('#new-price').text(salePrice.toFixed(2));
                    $('#old-price').text(regularPrice.toFixed(2));
                    $('.product-details-content .save-money').removeClass('d-none').text(
                        'Save:  {{ $web_settings->currency_sign }} ' + (
                            regularPrice - salePrice).toFixed(2));

                    // Update stock
                    if (data.stock <= 0) {
                        $('.product-cart').addClass('d-none');
                        $('.product-cart-out').removeClass('d-none');
                        $('.product-quantity .in-stock').text('Out of Stock').removeClass('text-success')
                            .addClass('text-danger');
                    } else {
                        $('.product-cart').removeClass('d-none');
                        $('.product-cart-out').addClass('d-none');
                        $('.product-quantity .in-stock').text(data.stock + ' in stock').removeClass(
                            'text-danger').addClass('text-success');
                    }

                    // Update SKU
                    $('.choice_attribute_sku').text('SKU: ' + data.sku);
                    $('input[name="sku"]').val(data.sku);

                    // Update variant names
                    $.each(data.variant_items, function(key, value) {
                        $('.variant-name').eq(key).text(value.attribute_item);
                    });

                    // Update main slider image if variant image exists
                    if (data.image) {
                        let targetIndex = -1;

                        mainSlider.slides.forEach((slideEl, index) => {
                            // Only check **real slides** if loop enabled
                            const img = slideEl.querySelector("img");
                            if (!img) return;

                            const slideFile = img.src.split('/').pop();
                            const dataFile = data.image.split('/').pop();

                            if (slideFile === dataFile) targetIndex = index;
                        });

                        if (targetIndex !== -1) {
                            // slideToRealIndex ensures correct slide even with loop
                            mainSlider.slideTo(mainSlider.getSlideIndex(mainSlider.slides[targetIndex]));
                        }
                    }

                    $('.loaderr').hide();

                } else {
                    console.warn(res.message);
                }
            },
            error: function(err) {
                console.error('AJAX Error:', err);
            }
        });
    }

    getAttributes();


    $(document).on("change", ".variant-item input", function() {
        $('.variant-item input').each(function() {
            if ($(this).is(':checked')) {
                $(this).closest('.variant-item').addClass('active').siblings().removeClass('active');
            }
        });

        getAttributes(); // your existing AJAX function
    });
</script>
