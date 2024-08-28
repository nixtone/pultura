<div class="grid @if($displayName) displayName @endif">
    @if($productList->where('category_id', $category->id)->isEmpty())
        <div class="err" style="grid-column: 5 span; text-align: center">Нет наименований</div>
    @else
        @foreach($productList->where('category_id', $category->id) as $product)
            <div class="item" data-price="{{ $product->price }}"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-cat="{{ $category->id }}"
                @if(!empty($product->files[0])) data-negative="/{{ $product->files[0] }}" @endif >
                @if(!empty($product->files[1]))
                    <img src="{{ asset($product->files[1]) }}" alt="" class="preview">
                @elseif(!empty($product->files[0]))
                    <img src="{{ asset($product->files[0]) }}" alt="" class="preview">
                @endif
                @if($displayName)
                <div class="name">
                    <span>{{ $product->name }}</span>
                    <span class="price"><span class="digit">{{ $product->price }}</span> ₽</span>
                </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
