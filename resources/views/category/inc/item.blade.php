<tr>
    <td>@if($child) — @endif <a href="{{ route('catalog.category.item', $category->id) }}">{{ $category->name }}</a></td>
    <td class="tac"><a href="{{ route('catalog.category.edit', $category->id) }}" class="edit ico"></a></td>
    <td class="tac">
        <form action="{{ route('catalog.category.delete', $category->id) }}" method="post">
            @csrf
            @method('delete')
            <input type="submit" value="" class="delete ico">
        </form>
    </td>
</tr>
