@php
    $rowIndex = isset($index) ? $index : '__INDEX__';
@endphp
<tr class="align-middle combo-parent-row border-bottom" data-product-id="{{ $product->id }}">
    <input type="hidden" name="products[{{ $rowIndex }}][product_id]" value="{{ $product->id }}">
    <input type="hidden" name="products[{{ $rowIndex }}][is_combo]" value="1">

    <!-- SKU -->
    <td class="sku fw-medium text-muted align-top pt-3">
        <span class="badge bg-purple-lt px-2 py-1">{{ $product->sku ?? 'COMBO' }}</span>
    </td>

    <!-- Product Details & Combo Children -->
    <td class="py-3">
        <div class="d-flex align-items-start gap-3">
            <div class="w-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div>
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            {{ $product->name }}
                            <span class="badge bg-azure text-white fs-10 px-2 py-0.5">Combo Pack</span>
                        </h5>
                        {{-- <span class="text-muted small">Stock: <strong
                                class="text-dark">{{ $product->total_stock }}</strong></span> --}}
                    </div>
                </div>

                <!-- Modern Combo Child Items Container -->
                <div class="combo-children-wrapper p-3 rounded-3 bg-white border mt-2 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                        <span
                            class="fw-bold text-uppercase fs-11 text-secondary tracking-wide d-flex align-items-center gap-1">
                            Included Combo Items & Variants
                        </span>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @foreach ($product->comboItems as $comboItem)
                            @php
                                $child = $comboItem->product;
                                $defaultChildQty = $comboItem->quantity ?? 1;
                                $savedComboItem = null;
                                $savedVariantId = null;
                                $showItem = true;

                                // Edit mode-e check korchi item-ti order-e save ache kina
                                if (isset($orderProduct)) {
                                    $savedComboItem = $orderProduct
                                        ->orderComboItems()
                                        ->where('product_id', $child->id)
                                        ->first();

                                    if (!$savedComboItem) {
                                        $showItem = false; // Jodi remove kora hoye thake tahole dekhabe na
                                    } else {
                                        $savedVariantId = $savedComboItem->variant_id;
                                        $defaultChildQty = $savedComboItem->qty ?? $defaultChildQty;
                                    }
                                }
                            @endphp

                            @if ($child && $showItem)
                                <div
                                    class="combo-child-item p-2 bg-light rounded-2 border d-flex flex-column gap-2 position-relative">

                                    <!-- Top Row: Child Name, Qty & Delete -->
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-semibold text-dark fs-13"> {{ $child->name }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                <span class="input-group-text bg-white px-2 fs-10 text-muted">Qty</span>
                                                <input type="number"
                                                    name="products[{{ $rowIndex }}][combo_items][{{ $child->id }}][qty]"
                                                    class="form-control text-center px-1 child-qty text-dark fw-bold"
                                                    readonly value="{{ $defaultChildQty }}" min="1">
                                            </div>
                                            <button type="button"
                                                class="btn btn-icon btn-sm btn-ghost-danger remove-combo-child"
                                                title="Remove Item">
                                                <i class="ti ti-x fs-14"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Variants Radio Buttons -->
                                    @if ($child->has_variant == 1 && $child->get_variants->count() > 0)
                                        <div class="pt-2 border-top bg-white p-2 rounded border">
                                            <div class="text-muted fs-11 fw-bold mb-1">Select Variant:</div>
                                            <div class="flex-wrap gap-2 d-flex">
                                                @foreach ($child->get_variants as $vIndex => $variant)
                                                    @php
                                                        $variantName = $variant->items
                                                            ->map(fn($it) => $it->name)
                                                            ->implode(', ');

                                                        $isChecked = isset($orderProduct)
                                                            ? $variant->id == $savedVariantId
                                                            : $vIndex === 0;
                                                    @endphp
                                                    <label
                                                        class="mb-0 bg-light rounded border cursor-pointer d-inline-flex align-items-center gap-2"
                                                        style="padding-left: 12px; padding-right: 14px; padding-top: 6px; padding-bottom: 6px;">
                                                        <input class="m-0 form-check-input" type="radio"
                                                            name="products[{{ $rowIndex }}][combo_items][{{ $child->id }}][variant_id]"
                                                            value="{{ $variant->id }}"
                                                            {{ $isChecked ? 'checked' : '' }} required>
                                                        <span
                                                            class="text-dark fs-11 fw-medium">{{ $variantName }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden"
                                            name="products[{{ $rowIndex }}][combo_items][{{ $child->id }}][variant_id]"
                                            value="">
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </td>

    <!-- Main Qty -->
    <td class="align-top pt-3">
        <div class="input-group">
            <input type="number" name="products[{{ $rowIndex }}][qty]" class="form-control qty fw-bold"
                value="1" min="1">
        </div>
    </td>

    <!-- Unit Price -->
    <td class="align-top pt-3">
        @php
            $comboPrice = $product->sale_price > 0 ? $product->sale_price : $product->regular_price;
        @endphp
        <div class="input-group">
            <input type="number" name="products[{{ $rowIndex }}][price]"
                class="form-control price fw-bold text-success"
                value="{{ number_format((float) $comboPrice, 2, '.', '') }}" step="any">
        </div>
    </td>

    <!-- Action Delete Parent -->
    <td class="text-center align-top pt-3">
        <button type="button" class="btn btn-danger btn-icon btn-sm remove_btn shadow-sm rounded-pill"
            title="Remove Combo Product">
            <i class="ti ti-trash fs-16"></i>
        </button>
    </td>
    <td style="display:none" class="total_price">{{ number_format((float) $comboPrice, 2, '.', '') }}</td>
</tr>
