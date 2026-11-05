@include('backEnd.admin.includes.top-paginate', ['items' => $products])
<table class="table table-vcenter card-table order-table">
    <thead>
        <?php
        $flags = $item->extra_fields ?? [];
        $targetKeys = ['is_new_arrival', 'is_hot_sale', 'is_best_seller', 'is_trending', 'is_feature'];
        
        // check if any of these keys exist in array
        $hasRequiredKey = collect($targetKeys)->contains(function ($key) use ($flags) {
            return array_key_exists($key, $flags);
        });
        // dd($hasRequiredKey);
        ?>
        <tr class="align-middle">
            <th class="w-1">
                <span>SL.</span>
                <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"
                    id="master">
            </th>
            <th>Image</th>
            <th>Product Name</th>
            <th>Category Name</th>
            {{-- <th>SKU</th> --}}
            <th>Stock</th>
            <th>Prices</th>
            {{-- <th>Product Compaign</th>
            <th>Position</th> --}}
            <th>Status</th>
            <th>Free Shipping</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="product_table_body">
        @php($i = $products->firstItem() ?? 1)
        @if ($products->count() > 0)
            @foreach ($products as $item)
                <tr class="custom-tr product-item{{ $item->id }}"
                    @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                    <td class="sl-cell">
                        {{ $i++ }}.
                        <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                            data-id="{{ $item->id }}">
                    </td>
                    <td>

                        @if ($item->get_thumb)
                            <img src="{{ asset($item->get_thumb->file_url) }}"
                                class="image-modal-trigger rounded object-fit-cover shadow-sm cursor-pointer"
                                style="width: 75px; height: 75px;" data-src="{{ asset($item->get_thumb->file_url) }}"
                                data-bs-toggle="modal" data-bs-target="#imageModal">
                        @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center text-muted"
                                style="width: 75px; height: 75px;" title="No image available">
                                <i class="ti ti-photo-off fs-6"></i>
                            </div>
                        @endif
                    </td>
                    <td class="text-truncate" style="max-width: 300px">
                        <a href="{{ route('single.product', $item->slug) }}"
                            style="font-size: 14px;color: #000;font-weight: 600;">
                            {{ $item->name }} </a> <br>
                        @if ($item->get_variants->count() > 0)
                            <strong style="font-size:12px">Variants:</strong> <br>
                            @foreach ($item->get_variants as $variant)
                                <?php
                                $variantInfo = $variant->items
                                    ->map(function ($item) {
                                        $attrName = $item->attribute->name ?? '';
                                        $itemName = $item->name ?? '';
                                        return $attrName . ': ' . $itemName;
                                    })
                                    ->implode(', ');
                                ?>
                                <small>
                                    {{-- <strong>{{ $variant->sku }}</strong> --}}
                                    ({{ $variantInfo }})
                                    - Stock: {{ $variant->stock }}
                                </small><br>
                            @endforeach
                        @endif
                    </td>
                    <td style="width:20%">
                        @foreach ($item->get_categories as $key => $cat)
                            {{ $key != 0 ? ', ' : '' }}{{ $cat->category_name }}
                        @endforeach
                    </td>
                    {{-- <td>{{ $item->sku }}</td> --}}
                    <td>{{ $item->stock }}</td>
                    {{-- <td>{{ $web_settings->currency_sign }} {{ $item->price }}</td> --}}
                    <td>

                        <strong>Regular: </strong>
                        {{ formatNumber($item->regular_price) }}
                        <br>
                        <strong>Sale: </strong>
                        {{ formatNumber($item->sale_price) }}
                        <br>
                        {{-- <strong>Purchase: </strong>
                        {{ formatNumber($item->purchase_price) }}
                        <br> --}}


                    </td>
                    {{-- <td class="text-nowrap">
                        <?php
                        $flags = $item->extra_fields ?? [];
                        $targetKeys = ['is_new_arrival', 'is_hot_sale', 'is_best_seller', 'is_trending', 'is_feature'];
                        ?>

                        @foreach ($flags as $k => $val)
                            @if (in_array($k, $targetKeys))
                                <div class="form-check form-switch">
                                    <input class="form-check-input flagSwitch" type="checkbox"
                                        data-id="{{ $item->id }}" data-key="{{ $k }}"
                                        {{ ($flags[$k] ?? null) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ ucwords(str_replace('_', ' ', str_replace('is_', '', $k))) . '?' }}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </td> --}}



                    {{-- <td class="w-1">
                            <?php
                            $flags = $item->extra_fields ?? [];
                            $targetKeys = ['position'];
                            ?>

                            @foreach ($flags as $k => $val)
                                @if (in_array($k, $targetKeys))
                                    <input type="text" class="form-control form-control-sm positionInput"
                                        data-id="{{ $item->id }}" data-key="{{ $k }}"
                                        value="{{ $val }}">
                                @endif
                            @endforeach
                        </td> --}}


                    <td>
                        @if ($item->status == 1)
                            <a href="{{ route('admin.product.status', $item->id) }}" class="badge bg-success"
                                onclick="return confirm('Are You Sure To Change This?')">
                                Published
                            </a>
                        @else
                            <a href="{{ route('admin.product.status', $item->id) }}" class="badge bg-danger"
                                onclick="return confirm('Are You Sure To Change This?')">
                                Unpublished
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="checkbox" hidden="hidden" data-id="{{ $item->id }}"
                            id="username-{{ $item->id }}" class="free_shiiping"
                            {{ $item->free_shipping == 1 ? 'checked' : '' }}>
                        <label class="switch" for="username-{{ $item->id }}"></label>
                    </td>
                    <td class="w-1">
                        @can('products.edit')
                            <a href="{{ route('admin.product.edit', $item->id) }}"
                                class="btn-gradient-info padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                <i class="ti ti-edit"></i> Edit
                            </a>
                        @endcan
                        @can('products.delete')
                            <a href="{{ route('admin.product.delete', $item->id) }}"
                                onclick="return confirm('Are You Sure To Delete This?')"
                                class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                <i class="ti ti-trash"></i>
                                Delete
                            </a>
                        @endcan

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11" class="text-center text-danger font-weight-bold">No
                    products Found!</td>
            </tr>
        @endif
    </tbody>
</table>
@include('backEnd.admin.includes.bottom-paginate', ['items' => $products])
