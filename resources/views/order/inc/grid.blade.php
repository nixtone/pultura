<div class="grid @if($displayName) displayName @endif">
    @foreach($productList->where('category_id', $category->id) as $product)
        <div class="item" data-price="{{ $product->price }}"
            data-id="{{ $product->id }}"
            data-name="{{ $product->name }}"
            data-cat="{{ $category->id }}"
            @isset($product->image[1]) data-negative="{{ $product->image[1] }}" @endisset >
            <img src="{{ $imagePath }}/{{ $product->image[0] }}" alt="" class="preview">
            @if($displayName)<div class="name">{{ $product->name }}</div>@endif
        </div>
    @endforeach
</div>
