<option value="">Не обрано</option>
@foreach($data as $item)
    <option @if($active == $item['value']) selected @endif value="{{$item['value']}}">{{$item['text']}}</option>
@endforeach
