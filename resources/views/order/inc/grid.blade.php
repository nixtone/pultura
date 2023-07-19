<div class="grid @if($displayName) displayName @endif">

    @foreach($productList->where('category_id', $category->id) as $product)
        @if(empty($product->files))
            @continue
        @else
        <div class="item" data-price="{{ $product->price }}"
            data-id="{{ $product->id }}"
            data-name="{{ $product->name }}"
            data-cat="{{ $category->id }}"
            @if(!empty($product->files[0])) data-negative="{{ $product->files[0] }}" @endif >
            @if(!empty($product->files[1]))
                <img src="{{ asset($product->files[1]) }}" alt="" class="preview">
            @elseif(!empty($product->files[0]))
                <img src="{{ asset($product->files[0]) }}" alt="" class="preview">
            @endif
            @if($displayName)<div class="name">{{ $product->name }}</div>@endif
        </div>
        @endif
    @endforeach

</div>
