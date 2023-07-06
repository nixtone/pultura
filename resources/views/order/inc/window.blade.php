<div class="window {{ $field }}" style="display: none;" data-field="{{ $field }}">
    <h2>{{ $title }}</h2>
    <div class="tab-area {{ $field }}" data-name="{{ $field }}">
        <div class="tab label">
            @foreach($categoryList->where('parent_id', $parent_cat) as $category)
                <div class="tab-item c{{ $category->id }}" data-count="{{ $category->id }}">{{ $category->name }}</div>
            @endforeach
        </div>
        <div class="tab page">
            @foreach($categoryList->where('parent_id', $parent_cat) as $category)
                <div class="tab-item c{{ $category->id }}">
                    <div class="grid @if($displayName) displayName @endif">
                        @foreach($productList->where('category_id', $category->id) as $product)
                            <div class="item" data-price="{{ $product->price }}" data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                <img src="{{ asset('/storage/images/'.$product->category->translit.'/'.$product->id.'.'.$product->image) }}" alt="">
                                @if($displayName)<div class="name">{{ $product->name }}</div>@endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
