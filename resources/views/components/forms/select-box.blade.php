@php
    $required = ($is_required ?? false) ? 'required' : '';
@endphp
<div class="select-box   {{$class_name}}">
    <label class="label type__text hovered  {{$class_name}}">
        {{--                                            @foreach($item['option'] as $key_opt=>$item_opt)--}}
        {{--                                                @if(($item['name'] ?? '') == 'rank')@dd($item['value'] ?? '') @endif--}}
        {{--                                                <option @if($key_opt === ($item_opt['value'] ?? '')) selected @endif value="{{$key_opt}}">{{$item_opt}}</option>--}}
        {{--                                            @endforeach--}}
        <span class="unselectable">{{$placeholder}}</span>
        <select
            {{$required}}
            type="text"
            name="{{$name}}"
            value="{{$value}}"
            class=" input">
            <option value="">Не обрано</option>
            @foreach($option as $key_opt=>$item_opt)
                <option @if($key_opt == ($value ?? '')) selected @endif value="{{$key_opt}}">{{$item_opt}}</option>
            @endforeach
        </select>
    </label>
</div>
