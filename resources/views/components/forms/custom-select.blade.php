@php
    $required = $is_required ?? '';
    $first_data = $first_data ?? null;
@endphp

<div class="custom-select type__text hovered {{$class_name}}">
    <label class="label hovered type__text  {{$class_name}}">
        <span class="unselectable">{{$placeholder}}</span>
        <input type="text"
               autocomplete="off"
               value="{{$text??''}}"
               name="{{$name}}_text"
               class="custom-select-input input">
    </label>

    <input {{$required}} name="{{$name}}" type="hidden" class="input-value" value="{{$value}}">
    <input type="hidden" class="old-value" value="{{$text ?? ''}}">
    <ul class="custom-select-options">
        @if($first_data)
            <li data-value="{{$first_data['value']}}">{{$first_data['text']}}</li>
        @endif
        @foreach($option as $key=>$item)
            <li data-value="{{$key}}">{{$item}}</li>
        @endforeach
    </ul>
</div>
