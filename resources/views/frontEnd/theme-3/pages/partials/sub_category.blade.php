@foreach ($children as $child)
    <li>
        <div class="form-check">
            <input class="form-check-input category_checkbox" name="category_id[]" type="checkbox" value="{{ $child->id }}" id="category-{{ $child->id }}"  {{ $child->id == $category_id ? 'checked' : '' }}>
            <label class="form-check-label {{ count($child->children) > 0 ?  'sub-parent' : '' }}" for="category-{{ $child->id }}">
                {{ $child->category_name ?? '' }}
            </label>
        </div>
        <span class="product-count-badge">{{ $child->get_products->where('theme_id',$theme->id)->count() }}</span>
    </li>
    @if (count($child->children) > 0)
        <div style="padding-left: 18px">
            @include('frontEnd.'.$theme->path.'.pages.partials.sub_category', ['children' => $child->children, 'currentTheme' => $theme, 'category_id' => $category_id])
        </div>
    @endif
@endforeach
