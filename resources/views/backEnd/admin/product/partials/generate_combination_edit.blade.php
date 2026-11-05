@if (count($combinations[0]) > 0)
    <div class="card border-0 shadow-sm rounded-3  overflow-hidden">
        <!-- Section Header -->
        <div
            class="card-header bg-white py-3 px-3 border-bottom border-light d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0 fw-bold text-dark">Existing Variations</h4>
            </div>
            <span class="badge bg-indigo-subtle text-indigo px-3 py-2 rounded-pill fw-semibold fs-7">
                {{ count($combinations) }} Variants
            </span>
        </div>

        <!-- Table Container -->
        <div class="table-responsive">
            <table class="table align-middle text-nowrap mb-0">
                <thead class="bg-slate-50 border-bottom border-light">
                    <tr>
                        <th class="ps-4 text-secondary text-uppercase fs-8 font-monospace tracking-wider">Variant</th>
                        <th class="text-secondary text-uppercase fs-8 font-monospace tracking-wider"
                            style="width: 220px;">SKU</th>
                        @if ($web_settings->stock_management == 0)
                            <th class="text-secondary text-uppercase fs-8 font-monospace tracking-wider"
                                style="width: 150px;">Purchase Price</th>
                        @endif
                        <th class="text-secondary text-uppercase fs-8 font-monospace tracking-wider"
                            style="width: 150px;">Regular Price</th>
                        <th class="text-secondary text-uppercase fs-8 font-monospace tracking-wider"
                            style="width: 150px;">Sale Price</th>
                        @if ($web_settings->stock_management == 0)
                            <th class="pe-4 text-secondary text-uppercase fs-8 font-monospace tracking-wider text-end"
                                style="width: 130px;">Stock</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($combinations as $combination)
                        @php
                            $skuSuffix = '';
                            $str = '';

                            foreach ($combination as $attr => $item) {
                                $keySlug = strtolower(str_replace(' ', '-', $item));
                                $str .= ($str ? ' / ' : '') . "$attr: $item";
                                $skuSuffix .= ($skuSuffix ? '-' : '') . $keySlug;
                            }

                            $fullSku = strtolower($product_sku ? $product_sku . '-' . $skuSuffix : $skuSuffix);
                            $existingVariant = $product->get_variants->where('sku', $fullSku)->first();
                        @endphp

                        <tr class="variant hover-bg-slate">
                            <td class="ps-4 py-3">
                                <span
                                    class="badge bg-light text-dark border px-2.5 py-1.5 rounded-2 font-monospace fs-7">
                                    <i class="ti ti-layers-subtract text-indigo me-1"></i>
                                    {{ $str }}
                                </span>
                                <input type="hidden" name="variant_name[]" value="{{ $str }}">
                            </td>

                            <td class="py-3">
                                <div class="input-group input-group-flat border rounded-2 bg-light-subtle">
                                    <span class="input-group-text border-0 text-muted px-2"><i
                                            class="ti ti-barcode fs-6"></i></span>
                                    <input type="text" name="variant_sku[]" value="{{ $fullSku }}"
                                        class="form-control border-0 bg-transparent ps-0 fs-7 font-monospace fw-medium text-dark"
                                        readonly>
                                </div>
                            </td>
                            @if ($web_settings->stock_management == 0)
                                <td class="py-3">
                                    <div
                                        class="input-group border rounded-2 overflow-hidden shadow-none focus-within-ring">
                                        <span
                                            class="input-group-text bg-light border-0 text-secondary fs-7">{{ $web_settings->currency_sign }}</span>
                                        <input type="number" name="variant_purchase_price[]"
                                            value="{{ $existingVariant ? formatNumber($existingVariant->purchase_price) : $v_purchase_price }}"
                                            min="0" step="0.01"
                                            class="form-control border-0 px-2 fs-7 fw-semibold auto-select-number"
                                            required>
                                    </div>
                                </td>
                            @endif

                            <td class="py-3">
                                <div class="input-group border rounded-2 overflow-hidden shadow-none focus-within-ring">
                                    <span
                                        class="input-group-text bg-light border-0 text-secondary fs-7">{{ $web_settings->currency_sign }}</span>
                                    <input type="number" name="variant_regular_price[]"
                                        value="{{ $existingVariant ? formatNumber($existingVariant->regular_price) : $v_regular_price }}"
                                        min="0" step="0.01"
                                        class="form-control border-0 px-2 fs-7 fw-semibold auto-select-number" required>
                                </div>
                            </td>

                            <td class="py-3">
                                <div class="input-group border rounded-2 overflow-hidden shadow-none focus-within-ring">
                                    <span
                                        class="input-group-text bg-light border-0 text-secondary fs-7">{{ $web_settings->currency_sign }}</span>
                                    <input type="number" name="variant_sale_price[]"
                                        value="{{ $existingVariant ? formatNumber($existingVariant->sale_price) : $v_sale_price }}"
                                        min="0" step="0.01"
                                        class="form-control border-0 px-2 fs-7 fw-semibold text-success auto-select-number"
                                        required>
                                </div>
                            </td>
                            @if ($web_settings->stock_management == 0)
                                <td class="pe-4 py-3 text-end">
                                    <div
                                        class="input-group border rounded-2 overflow-hidden shadow-none focus-within-ring">
                                        <input type="number" name="variant_stock[]"
                                            value="{{ $existingVariant ? $existingVariant->stock : 10 }}"
                                            min="0" step="1"
                                            class="form-control border-0 text-center px-2 fs-7 fw-bold text-indigo auto-select-number"
                                            required>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
