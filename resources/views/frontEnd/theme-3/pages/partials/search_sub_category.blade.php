@php
    $activePath = '';
    if ($currentTheme->type == 'active') {
        $activePath = 'active';
    } elseif ($currentTheme->type == 'preview') {
        $activePath = 'preview';
    }
    // dd($activePath);
@endphp
@foreach ($children as $key => $child)
    @php
        $rand = rand();
    @endphp

    <li>
        <div class="form-check">
            <input class="form-check-input category_checkbox" name="category_id[]" type="checkbox" value="{{ $child->id }}" id="sub-{{$rand}}-category-{{ $child->id }}">
            <label class="form-check-label {{ count($child->children) > 0 ?  'sub-parent' : '' }}" for="sub-{{$rand}}-category-{{ $child->id }}">
                {{ $child->category_name ?? '' }}
            </label>
        </div>
        <span class="product-count-badge">{{ $child->get_products->where('theme_id',$currentTheme->id)->count() }}</span>
    </li>
    @if (count($child->children) > 0)
        <div style="padding-left: 18px">
            @include('frontEnd.'.$currentTheme->path.'.pages.partials.search_sub_category', ['children' => $child->children,'currentTheme' => $currentTheme ])
        </div>
    @endif
@endforeach
