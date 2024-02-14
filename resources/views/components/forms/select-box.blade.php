@php
    $required = ($is_required ?? false) ? 'required' : '';
    $titleOpt_open = false;

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

            @if($titleOpt_open)
                <optgroup label="opens"> @endif
                    @foreach($option as $key_opt=>$item_opt)
                        @if($item_opt=== 'Title' && $titleOpt_open)  </optgroup>
            @endif

            @if($item_opt=== 'Title')
                @php
                    $titleOpt_open = true;
                @endphp
                <optgroup label="{{$key_opt}}">
                    @else
                        <option
                            @if($key_opt == ($value ?? '')) selected @endif
                        value="{{$key_opt}}"
                        >
                            {{$item_opt}}
                        </option>
                    @endif

                    @endforeach
                    @if($titleOpt_open)</optgroup>@endif
        </select>
    </label>
</div>
