@if (count($product->get_variants) > 0)
    <tr class="product-group-row">
        <td colspan="4" class="p-2 bg-light text-dark">
            <strong>{{ $product->name }}</strong> <span class="text-dark font-12">(Variants)</span>
        </td>
        <td style="text-align: center; vertical-align: middle;" class="bg-light">
            <a href="javascript:void(0);" class="remove_product_group text-danger fs-5"
                data-product-id="{{ $product->id }}">
                <i class='ti ti-trash'></i>
            </a>
        </td>
    </tr>
    @foreach ($product->get_variants as $attribute)
        @php
            $variant_name = $attribute->items
                ->map(function ($item) {
                    return ($item->attribute->name ?? '') . ': ' . ($item->name ?? '');
                })
                ->implode(' / ');
        @endphp
        <tr class="variant-row-{{ $product->id }}">
            <td class="ps-4">
                <span class="text-primary">{{ $variant_name }}</span> ({{ $attribute->sku }})
                <input type="hidden" name="sku[]" value="{{ $attribute->sku }}">
                <input type="hidden" name="product_id[]" value="{{ $product->id }}">
            </td>
            <td>
                <input type="text" class="form-control" value="{{ $attribute->stock }}" readonly>
            </td>
            <td>
                <input type="number" name="adjusted_quantity[]" class="form-control" value="1" min="1"
                    required>
            </td>
            <td>
                <select name="type[]" class="form-select">
                    <option value="addition">Addition (+)</option>
                    <option value="subtraction">Subtraction (-)</option>
                </select>
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <a href="javascript:void(0);" class="remove_product_attribute text-danger fs-5"><i
                        class='ti ti-trash'></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td>
            <span class="text-primary">#{{ $product->sku }}</span><br>
            {{ $product->name }}
            <input type="hidden" name="sku[]" value="{{ $product->sku }}">
            <input type="hidden" name="product_id[]" value="{{ $product->id }}">
        </td>
        <td>
            <input type="text" class="form-control" value="{{ $product->stock }}" readonly>
        </td>
        <td>
            <input type="number" name="adjusted_quantity[]" class="form-control" value="1" min="1"
                required>
        </td>
        <td>
            <select name="type[]" class="form-select">
                <option value="addition">Addition (+)</option>
                <option value="subtraction">Subtraction (-)</option>
            </select>
        </td>
        <td style="text-align: center; vertical-align: middle;">
            <a href="javascript:void(0);" class="remove_product_btn text-danger fs-5"><i class='ti ti-trash'></i></a>
        </td>
    </tr>
@endif
