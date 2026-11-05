<p class="text-muted small mb-2">Select the products you want to add back to stock for Order
    <strong>#{{ $order->invoice_id }}</strong>:
</p>
<div class="table-responsive">
    <table class="table table-sm align-middle">
        <thead>
            <tr>
                <th width="5%"><input type="checkbox" id="selectAllRestock" class="form-check-input" checked></th>
                <th>Product Name</th>
                <th class="text-center">Ordered Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderProducts as $item)
                @php
                    $isCombo = $item->get_product && $item->get_product->is_combo == 1 ? 1 : 0;
                @endphp
                {{-- Main Product Row --}}
                <tr>
                    <td>
                        <input type="checkbox" name="products[{{ $loop->index }}][product_id]"
                            value="{{ $item->product_id }}" class="form-check-input restock-checkbox" checked>
                        <input type="hidden" name="products[{{ $loop->index }}][sku]"
                            value="{{ $item->product_sku }}">
                        <input type="hidden" name="products[{{ $loop->index }}][qty]" value="{{ $item->qty }}">
                        <input type="hidden" name="products[{{ $loop->index }}][is_combo]"
                            value="{{ $isCombo }}">
                    </td>
                    <td>
                        {{ $item->get_product->name ?? 'N/A' }}
                        @if ($isCombo == 1)
                            <span class="badge bg-purple-lt">Combo Pack</span>
                        @endif
                        {{-- @if ($item->attributes)
                            <br><small class="text-muted">{{ $item->attributes }}</small>
                        @endif --}}
                        @if (!empty($item->formatted_attributes_list) && $item->formatted_attributes_list->count() > 0)
                            <div class="d-inline-flex gap-1 flex-wrap">
                                @foreach ($item->formatted_attributes_list as $v_item)
                                    <span class="badge bg-light text-dark border fw-normal px-1.5 py-0.5"
                                        style="font-size: 0.7rem;">
                                        <span class="text-muted">{{ $v_item->attribute->name ?? '' }}:</span>
                                        <strong class="text-dark">{{ $v_item->name }}</strong>
                                    </span>
                                    {{-- <br><small class="text-muted">{{ $v_item->name }}</small> --}}
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="text-center font-semibold">{{ $item->qty }}</td>
                </tr>

                {{-- Combo Child Products Row --}}
                @if ($isCombo == 1 && method_exists($item, 'orderComboItems'))
                    @foreach ($item->orderComboItems as $comboItem)
                        <tr class="text-muted small">
                            <td class="ps-4">
                                <input type="checkbox"
                                    name="products[{{ $loop->parent->index }}][combo_children][{{ $loop->index }}][selected]"
                                    value="1" class="form-check-input restock-checkbox" checked>
                                <input type="hidden"
                                    name="products[{{ $loop->parent->index }}][combo_children][{{ $loop->index }}][product_id]"
                                    value="{{ $comboItem->product_id }}">
                                <input type="hidden"
                                    name="products[{{ $loop->parent->index }}][combo_children][{{ $loop->index }}][sku]"
                                    value="{{ $comboItem->sku }}">
                                <input type="hidden"
                                    name="products[{{ $loop->parent->index }}][combo_children][{{ $loop->index }}][qty]"
                                    value="{{ $comboItem->qty * $item->qty }}">
                            </td>
                            <td>
                                <span class="text-dark">↳ </span> {{ $comboItem->product->name ?? 'N/A' }}
                                @if ($comboItem->variant_name)
                                    <br><small class="text-muted ps-3">Variant: {{ $comboItem->variant_name }}</small>
                                @endif
                            </td>
                            <td class="text-center font-semibold">{{ $comboItem->qty * $item->qty }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
</div>
