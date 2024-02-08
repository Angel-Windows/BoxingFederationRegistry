<div class="custom-select  {{$class_name}}">
    <label class="label type__text  {{$class_name}}">
        <span class="unselectable">{{$placeholder}}</span>

        <input type="text"
               autocomplete="off"
               value="{{$value}}"
               class="custom-select-input input">
    </label>
    <input name="{{$name}}" type="hidden" class="input-value" value="{{$value}}">
    <input type="hidden" class="old-value" value="{{$value}}">
    <ul class="custom-select-options">
        @foreach($option as $key=>$item)
            <li data-value="{{$key}}">{{$item}}</li>
        @endforeach
    </ul>
</div>
