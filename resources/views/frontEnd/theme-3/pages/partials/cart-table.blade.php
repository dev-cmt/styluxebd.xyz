<table class="cart-table table table-condensed">
    <tbody>
        @foreach ($cartItems as $key => $item)
            <tr>
                <td>
                    <div class="product-info">
                        <div class="product-name">
                            <a href="{{ route('product.detail', $item['product']->slug) }}">{{ $item['name'] }}</a>
                        </div>
                        <div class="product-image">
                            <img src="{{ $item['product']->get_feature_image ? asset($item['product']->get_feature_image->file_url) : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg' }}"
                                alt="{{ $item['name'] }}">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="product-price">
                        <p>Price</p>
                        @if ($item['attributes'])
                            <p>
                                @if ($item['product']->sale_price > 0)
                                    <span
                                        class="old_price text-decoration-line-through">{{ $general_settings->currency_sign }}{{ number_format($item['product']->regular_price, 2) }}</span>
                                    <span
                                        class="new_price">{{ $general_settings->currency_sign }}{{ number_format($item['price'], 2) }}</span>
                                @else
                                    <span
                                        class="new_price">{{ $general_settings->currency_sign }}{{ number_format($item['price'], 2) }}</span>
                                @endif
                            </p>
                        @else
                            <p>
                                @if ($item['product']->sale_price > 0)
                                    <span
                                        class="old_price text-decoration-line-through">{{ $general_settings->currency_sign }}{{ $item['product']->regular_price }}</span>
                                    <span
                                        class="new_price">{{ $general_settings->currency_sign }}{{ number_format($item['product']->sale_price, 2) }}</span>
                                @else
                                    <span
                                        class="new_price">{{ $general_settings->currency_sign }}{{ number_format($item['product']->regular_price, 2) }}</span>
                                @endif
                            </p>
                        @endif
                    </div>
                </td>
                @foreach (json_decode($item['attributes'], true) as $attribute_name => $attribute_item_name)
                    @php
                        $attribute = DB::table('attributes')->where('name', $attribute_name)->first();
                    @endphp
                    <td>
                        <div class="product-attribute">
                            <p>{{ ucfirst($attribute_name) }}</p>
                            <p>
                                <select class="form-select form-select-sm update_attribute"
                                    name="attribute[{{ strtolower($attribute_name) }}][]">
                                    @foreach ($item['product']->get_product_choice_attributes->where('attribute_id', $attribute->id)->first()->get_choice_attribute_items as $attribute_item)
                                        <option data-id="{{ $key }}"
                                            value="{{ $attribute_item->get_attribute_item->name }}"
                                            {{ $attribute_item_name == $attribute_item->get_attribute_item->name ? 'selected' : '' }}>
                                            {{ $attribute_item->get_attribute_item->name }}</option>
                                    @endforeach
                                </select>
                            </p>
                        </div>
                    </td>
                @endforeach
                <td>
                    <div class="quantity">
                        <p>Quantity</p>
                        <p>
                            <select class="form-select form-select-sm update_quantity" name="quantity">
                                <option data-id="{{ $key }}" value="1"
                                    {{ $item['quantity'] == 1 ? 'selected' : '' }}>1
                                </option>
                                <option data-id="{{ $key }}" value="2"
                                    {{ $item['quantity'] == 2 ? 'selected' : '' }}>2
                                </option>
                                <option data-id="{{ $key }}" value="3"
                                    {{ $item['quantity'] == 3 ? 'selected' : '' }}>3
                                </option>
                                <option data-id="{{ $key }}" value="4"
                                    {{ $item['quantity'] == 4 ? 'selected' : '' }}>4
                                </option>
                                <option data-id="{{ $key }}" value="5"
                                    {{ $item['quantity'] == 5 ? 'selected' : '' }}>5
                                </option>
                                <option data-id="{{ $key }}" value="6"
                                    {{ $item['quantity'] == 6 ? 'selected' : '' }}>6
                                </option>
                                <option data-id="{{ $key }}" value="7"
                                    {{ $item['quantity'] == 7 ? 'selected' : '' }}>7
                                </option>
                                <option data-id="{{ $key }}" value="8"
                                    {{ $item['quantity'] == 8 ? 'selected' : '' }}>8
                                </option>
                                <option data-id="{{ $key }}" value="9"
                                    {{ $item['quantity'] == 9 ? 'selected' : '' }}>9
                                </option>
                                <option data-id="{{ $key }}" value="10"
                                    {{ $item['quantity'] == 10 ? 'selected' : '' }}>
                                    10</option>
                            </select>
                        </p>
                    </div>
                </td>
                <td>
                    <div class="subtotal">
                        <p>Subtotal</p>
                        <p>{{ $general_settings->currency_sign }}{{ number_format(\App\PDCart::getSubtotal($key), 2) }}
                        </p>
                    </div>
                </td>
                <td>
                    <div class="action">
                        <a href="javascript:void(0);" class="add-to-cart-button add-another-cart addToCart"
                            data-id="{{ $item['product']->id }}"><i class="fa fa-plus"></i> Add another
                            size</a>
                        <a href="javascript:void(0);" data-href="{{ route('cart.item.remove', $key) }}"
                            class="remove-cart-button remove-cart-item"><i class="fa fa-trash-can"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
