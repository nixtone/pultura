<div class="grid @if($displayName) displayName @endif">

    @foreach($productList->where('category_id', $category->id) as $product)
        @if(empty($product->files))
            @continue
        @else
        <div class="item" data-price="{{ $product->price }}"
            data-id="{{ $product->id }}"
            data-name="{{ $product->name }}"
            data-cat="{{ $category->id }}"
            @isset($product->files['negative']) data-negative="{{ $product->files['negative'] }}" @endisset >
            <img src="{{ asset($product->files['preview']) }}" alt="" class="preview">
            @if($displayName)<div class="name">{{ $product->name }}</div>@endif
        </div>
        @endif
    @endforeach

</div>
