@php
    $route_class = $id ? "edit" : "register";
@endphp
<form method="post"
      action="{{route('page.class.' . $route_class, ['class_name'=>$category_name, 'id'=>$id])}}"
      {{--      action="{{route('page.class.' . $route_type, ['class_name'=>$category_name, 'id'=>$id])}}"--}}
      id="form_edit"
      class="page-form-{{$route_class}} form-tag-class"
      enctype="multipart/form-data"
      @if(!$id) onsubmit="return validateForm(this)" @endif

>
{{--        <button type="submit">Submit</button>--}}
{{--        <button class="button">Submit</button>--}}
    @csrf

    @php
        $model_table = new $get['modeles'];
        $is_register_add = true;
        $hasLogoColumn =  $more_data['logo'] ?? null;
//        $hasLogoColumn =  $model_table->getConnection()->getSchemaBuilder()->hasColumn($model_table->getTable(), 'logo');
        if ($hasLogoColumn){
            $class_table = 'table-auto_fool';
        }
    @endphp
    <section class="{{$class_table ?? ''}} edit ">
        {{--    <section class="{{$class_table ?? ''}} edit ">--}}
        @if($hasLogoColumn)
            {{ $slot }}
            {{--            <div class="big_img">--}}
            {{--                <div class="img"><img src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}" alt="">--}}
            {{--                </div>--}}
            {{--            </div>--}}
        @endif
        @foreach($table as $table_item)
            {{--            <div >--}}
            <div class="{{$table_item['class'] ?? ''}}">
                @foreach($table_item['data_block'] ?? [] as $item_list)
                    @if(isset($item_list['title']))
                        <h3>
                            <p>{{$item_list['title']}}</p>
                            @if($item_list['button'] ?? null)
                                <div
                                    class="button"
                                    onclick="functionsArray['open_modal']('add-form-item', {'class_types': '{{$category_name}}', 'type_action': '{{$item_list['button']}}', 'id' : '{{$id}}'})"
                                    {{--                                onclick="functionsArray['open_modal']('add-form-item', {'class_types': 1})"--}}
                                >
                                    <span>+</span>
                                    <span>Додати</span>
                                </div>
                            @endif
                        </h3>
                    @endif
                    @switch($item_list['type'] ?? '')
                        @case('checkbox-list')

                            {{--                            @dd(2)--}}
                            <div class="checkbox-list fool">
                                @foreach($item_list['data'] ?? [] as $user_ids=>$item_data)
                                    @php
                                        $class = '';
                                        $checkbox_type  = false;
                                         if (($item_data['checkbox_type'] ?? '') == 'revert' || ($item_list['checkbox_type'] ?? '')  == 'revert' ){
                                                $class .=  ' revert';
                                                $checkbox_type  = true;
                                             }
                                    @endphp
                                    <div class="label type__checkbox no_check inline-flex">
                                        <div class="text">
                                            <span class="">{{$item_data['text'] ?? ''}}</span>
                                            @if(isset($item_data['subtitle']))
                                                <span class="subtitle">{{$item_data['subtitle'] ?? ''}}</span>
                                            @endif
                                        </div>
                                        <label
                                            onclick="functionsArray['toggle_parent_active'](this, 'label', 'delete', 'checkbox_toggle')">
                                            <input type="checkbox"
                                                   @if(!$checkbox_type) checked @endif
                                                   name="{{$item_list['name'] ?? ''}}[]"
                                                   value="{{$item_data['value'] ?? ''}}"
                                                   class="{{$class}}"

                                            >
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @break
                        @case('history_works')
                            <div class="history-work fool ">
                                <table class="no-wrap m-grid-3">
                                    <tbody>
{{--                                    <tr class="label type__checkbox no_check ">--}}
                                    <tr class="label type__checkbox no_check  d-none">
                                        <td class="item_name"></td>
                                        <td class="m-span-1 start_work"></td>
                                        <td class="no_size m-span-1">-</td>
                                        <td class="m-span-1 end_work"></td>
                                        <td class="m-span-1 pl-0 label_button"><label
                                                class="pl-0 "
                                                onclick="functionsArray['remove_parent'](this)">
                                                <input
                                                    type="checkbox"
                                                    name="history_work_new[]"
                                                    value=""
                                                ></label></td>
                                    </tr>
                                    {{--                                    @dd($item_list['data'])--}}
                                    @foreach($item_list['data'] ?? [] as $item_data)
                                        <tr class="label type__checkbox no_check ">
                                            <td>{{$item_data['name']}}</td>
                                            <td class="m-span-1">{{$item_data['start_work']}}</td>
                                            <td class="no_size m-span-1">-</td>
                                            <td class="m-span-1">{{$item_data['end_work']}}</td>
                                            <td class="m-span-1 pl-0 label_button"><label
                                                    class="pl-0 "
                                                    onclick="functionsArray['toggle_parent_active'](this, 'label', 'delete')">
                                                    <input
                                                        type="checkbox"
                                                        name="{{$item_list['name']}}"
                                                        value="{{$item_data['value']}}"
                                                    ></label></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @break
                        @case('family')
                            @php
                                $class = '';
                                 if (($item_data['checkbox_type'] ?? '') == 'revert' || ($item_list['checkbox_type'] ?? '')  == 'revert' ){
                                        $class .=  ' revert';
                                     }
                            @endphp
                            <div class="history-work fool">
                                <table class="no-wrap m-grid-3">
                                    <tbody>
                                    <tr class="label type__checkbox no_check d-none">
                                        <td></td>
                                        <td class="m-span-1"></td>
                                        <td class="no_size m-span-1"></td>
                                        <td class="m-span-1"></td>
                                        <td class="m-span-1 pl-0 label_button"><label
                                                class="pl-0 "
                                                onclick="functionsArray['toggle_parent_active'](this, 'label', 'delete')">
                                                <input
                                                    type="checkbox"
                                                    name="{{$item_list['name']}}"
                                                    value=""
                                                    class="{{$class}}"
                                                ></label></td>
                                    </tr>
                                    {{--                                    @dd($item_list['data'])--}}
                                    @foreach($item_list['data'] ?? [] as $item_data)
                                        <tr class="label type__checkbox no_check ">
                                            <td>{{$item_data['name']}}</td>
                                            <td class="m-span-1">{{$item_data['status']}}</td>
                                            <td class="no_size m-span-1"></td>
                                            <td class="m-span-1">{{$item_data['phone']}}</td>
                                            <td class="m-span-1 pl-0 label_button"><label
                                                    class="pl-0 "
                                                    onclick="functionsArray['toggle_parent_active'](this, 'label', 'delete')">
                                                    <input
                                                        @if(!($item_data['checkbox_type'] ?? false)) checked @endif
                                                    type="checkbox"
                                                        name="{{$item_list['name']}}"
                                                        value="{{$item_data['value']}}"
                                                        class="{{$class}}"
                                                    ></label></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @break
                        @case('table-list')
                            <div class="fool todo_table">
                                <table class="no-wrap m-grid-3">
                                    {{--                                        @if(isset($item_right['data']['thead']))--}}
                                    {{--                                            <thead>--}}
                                    {{--                                            <tr>--}}
                                    {{--                                                @foreach($item_right['data']['thead'] as $thead_item)--}}
                                    {{--                                                    <th>{{$thead_item}}</th>--}}
                                    {{--                                                @endforeach--}}
                                    {{--                                            </tr>--}}
                                    {{--                                            </thead>--}}
                                    {{--                                        @endif--}}
                                    <tbody>
                                    @foreach($item_list['data'] ?? [] as $item_body)

                                        <tr class="label type__checkbox no_check ">
                                            @foreach($item_body as $key=>$item_td)

                                                @switch($key)
                                                    @case('logo')
                                                        <td>
                                                            <div
                                                                style="white-space: nowrap; display: flex; align-items: center">
                                                                <div class="img"><img
                                                                        src="{{ MyAsset($item_td['img']) }}"
                                                                        alt="">
                                                                </div>
                                                                <span>{{$item_td['name']}}</span>
                                                            </div>
                                                        </td>
                                                        @break
                                                    @case('value')

                                                        <td class="m-span-1 pl-0 label_button"><label
                                                                class="pl-0 "
                                                                onclick="functionsArray['toggle_parent_active'](this, 'label', 'delete')">
                                                                <input
                                                                    type="checkbox"
                                                                    name="{{$item_list['name']}}"
                                                                    value="{{$item_td}}"
                                                                ></label></td>
                                                        @break
                                                    @default
                                                        <td>
                                                            <span>{{$item_td}}</span>
                                                        </td>
                                        @endswitch
                                    @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @break
                        @case('passport')
                            {{--                            @dd($item_list['data'])--}}
                            <div class="passport_edit">
                                <label
                                    class="label hovered type__text @if($item_list['data']['name_seria']) active @endif">
                                    <span class="unselectable">Серія</span>
                                    <input class="input" placeholder="" name="{{$item_list['data']['name']}}_seria"
                                           type="text" value="{{$item_list['data']['name_seria']}}">
                                </label>
                                <label
                                    class="label hovered type__text  @if($item_list['data']['name_number']) active @endif">
                                    <span class="unselectable">Номер</span>
                                    <input class="input" placeholder="" name="{{$item_list['data']['name']}}_number"
                                           type="number" value="{{$item_list['data']['name_number']}}">
                                </label>
                            </div>
                            <style>

                            </style>
                            @break
                        @case('table')
                            <div class="table">
                                @foreach($item_list['data'] ?? [] as $item)
                                    @php
                                        $class = '';
                                        $class .= $item['class'] ?? "";
                                        $class .= " ";
                                        $class .=  $item['size'] ?? "";
                                        $class .= " ";

                                        $value = "";

                                        if (isset($item['value']) &&  ($item['value'] || $item['value'] == 0) ){
                                            $class .= ' active';
                                            $value = $item['value'];
                                        }
                                    @endphp

                                    @switch($item['tag'] ?? '')
                                        @case('input')

                                            @php
                                                $name = $item['placeholder'] ?? $item ?? "No text";
                                                $type =  $item['type'] ?? "text";
                                            @endphp
                                            <label class="label hovered type__text  {{$class}}">
                                                <span class="unselectable">{{$item['placeholder']}}</span>
                                                <input class="input" @if($item['required']??null) required
                                                       @endif placeholder="" name="{{$item['name']}}"
                                                       type="{{$type}}" value="{{$value}}">
                                            </label>
                                            @break
                                        @case('no-active')
                                            <label class="label fool type__text no-active">
                                                <span class="unselectable">{{$item['placeholder']}}</span>
                                                <input class="" placeholder=""
                                                       value="">
                                            </label>
                                            @break
                                        @case('select-box')
                                            @include('components.forms.select-box',
                                                [
                                                    'class_name'=> $class,
                                                    'placeholder'=>$item['placeholder'],
                                                    'value'=>$value,
                                                    'text'=>$item['text'] ?? '',
                                                    'name'=>$item['name'],
                                                    'option'=>$item['option'] ?? [],
                                                    'is_required'=> $item['required'] ?? null
                                                ])

                                            @break
                                        @case('custom-select')
                                            @include('components.forms.custom-select',
                                                [
                                                    'class_name'=> $class,
                                                    'placeholder'=>$item['placeholder'],
                                                    'value'=>$value,
                                                    'text'=>$item['text'] ?? '',
                                                    'name'=>$item['name'],
                                                    'option'=>$item['option'] ?? [],
                                                    'is_required'=> $item['required'] ?? null,
                                                    'first_data'=>$item['first_data'] ?? null,
                                                ])
                                            @break

                                    @endswitch
                                @endforeach
                            </div>
                        @default
                    @endswitch
                @endforeach
                @if(!($id ?? 0) && $is_register_add)
                    @php
                        $is_register_add = false;
                    @endphp
                    <div class="right">
                        <button class="button" onclick="functionsArray['button_temp_input'](this)">Перейти до оплати
                        </button>
                        <label style="display: block">
                            <input required style="display: inline-block" type="checkbox">
                            <span style="font-size: 14px">Приймаю всі <a href="">умови користування</a> і також <a href="">політику конфіденційності</a></span>
                        </label>
                    </div>
                @endif
            </div>
    @endforeach
</form>

