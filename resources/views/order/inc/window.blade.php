<div class="window {{ $field }}" data-field="{{ $field }}" data-construct="{{ $constructor }}" style="display: none;">

    <h2>{{ $title }}</h2>

    @if($categoryList->where('parent_id', $parent_cat)->isEmpty())
        @include('order.inc.grid', [
            'category' => $categoryList->where('id', $parent_cat)->first()
        ])
    @else
        <div class="tab-area {{ $field }}" data-name="{{ $field }}">
            <div class="tab label">
                @foreach($categoryList->where('parent_id', $parent_cat) as $category)
                    <div class="tab-item c{{ $category->id }}" data-count="{{ $category->id }}" data-cat="">{{ $category->name }}</div>
                @endforeach
            </div>
            <div class="tab page">
                @foreach($categoryList->where('parent_id', $parent_cat) as $category)
                    <div class="tab-item c{{ $category->id }}">
                        @include('order.inc.grid')
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
