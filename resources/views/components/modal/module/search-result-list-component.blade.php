@foreach($data as $item)
    <li><a href="{{route('page.class', ['class_name'=>$class_type, 'id'=>$item->id])}}">{{$item->id}} . {{$item->fool_name}}</a></li>
@endforeach
