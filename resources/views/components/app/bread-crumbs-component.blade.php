<ul class="bread-crumbs">
    @foreach($arr_bread as $item_bread)
        <li><a href="{{route($item_bread['route'])}}">{{$item_bread['text']}}</a></li>
    @endforeach
</ul>

