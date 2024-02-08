@foreach($data as $item)
    @switch($tag_name)
        @case('a')
            <li>
                <a href="{{route('page.class', ['class_name'=>$class_type, 'id'=>$item->id])}}">{{$item->id}}
                    . {{$item->name}}</a>
            </li>
            @break
        @case('li')
            <li data-value='{{$item->id}}'>{{$item->name}}</li>
            @break
    @endswitch
@endforeach
