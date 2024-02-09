<form method="post"
      action="{{route('page.class.edit', ['class_name'=>$category_name, 'id'=>$id])}}"
      {{--      action="{{route('page.class.' . $route_type, ['class_name'=>$category_name, 'id'=>$id])}}"--}}
      id="form_edit"
      class="page-form-{{$id ? "edit" : "register" }}"
      enctype="multipart/form-data"
>
    <button type="submit">Submit</button>
    {{--    <button class="button">Submit</button>--}}
    @csrf
    @php
        $model_table = new $get['modeles'];
        $hasLogoColumn =  $model_table->getConnection()->getSchemaBuilder()->hasColumn($model_table->getTable(), 'logo');
        if ($hasLogoColumn){
            $class_table = 'table-auto_fool';
        }
    @endphp
    <section class="{{$class_table ?? ''}} edit ">
        @if($hasLogoColumn)
            {{ $slot }}
            {{--            <div class="big_img">--}}
            {{--                <div class="img"><img src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}" alt="">--}}
            {{--                </div>--}}
            {{--            </div>--}}
        @endif
        @foreach($table as $table_item)
            <div class="{{$table_item['class'] ?? ''}}">
                @foreach($table_item['data_block'] as $item_list)
                    @if(isset($item_list['title']))
                        <h3>
                            <p>{{$item_list['title']}}</p>
                            @if($item_list['button'] ?? null)
                            <div
                                class="button"
                                onclick="functionsArray['open_modal']('add-form-item', {'class_types': 1})"
                                {{--                                onclick="functionsArray['open_modal']('add-form-item', {'class_types': 1})"--}}
                            >
                                <span>+</span>
                                <span>Додати</span>
                            </div>
                            @endif
                        </h3>
                    @endif
                    <div class="table">
                        @foreach($item_list['data'] as $item)

                            @php
                                $class = '';
                                $class .=  $item['size'] ?? "";
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
                                        <input class="input" placeholder="" name="{{$item['name']}}"
                                               type="{{$type}}" value="{{$value}}">
                                    </label>
                                    @break
                                @case('no-active')
                                    <label class="label type__text   {{$item['class']}} no-active">
                                        <span class="unselectable">{{$item['placeholder']}}</span>
                                        <input class="" placeholder="" name="{{$item['name']}}"
                                               type="{{$type}}" value="">
                                    </label>
                                    @break
                                @case('custom-select')
                                    @include('components.forms.custom-select',
                                        [
                                            'class_name'=> $class,
                                            'placeholder'=>$item['placeholder'],
                                            'value'=>$value,
                                            'text'=>$item['text'] ?? '',
                                            'name'=>$item['name'],
                                            'option'=>$item['option']
                                        ])
                                    @break
                                @case('select-box')
                                    <div class="select-box   {{$item['class']??''}}">
                                        <label class="label type__text hovered  {{$class}}">
{{--                                            @foreach($item['option'] as $key_opt=>$item_opt)--}}
{{--                                                @if(($item['name'] ?? '') == 'rank')@dd($item['value'] ?? '') @endif--}}
{{--                                                <option @if($key_opt === ($item_opt['value'] ?? '')) selected @endif value="{{$key_opt}}">{{$item_opt}}</option>--}}
{{--                                            @endforeach--}}
                                            <span class="unselectable">{{$item['placeholder']}}</span>
                                            <select
                                                type="text"
                                                name="{{$item['name']??''}}"
                                                value="{{$value}}"
                                                class=" input">
                                                <option value="">Не обрано</option>
                                                @foreach($item['option'] as $key_opt=>$item_opt)
                                                    <option @if($key_opt == ($item['value'] ?? '')) selected @endif value="{{$key_opt}}">{{$item_opt}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    @break
                                @case('checkbox-list')
                                    <div class="checkbox-list fool">
                                        @foreach($item['data'] as $user_ids=>$item_data)
                                            <div class="label type__checkbox no_check inline-flex">
                                                <div class="text">
                                                    <span class="">{{$item_data['text']}}</span>
                                                    <span class="subtitle">{{$item_data['text']}}</span>
                                                </div>

                                                <label
                                                    onclick="functionsArray['toggle_parent_active'](this, 'label', 'delete', 'checkbox_toggle')">
                                                    <input type="checkbox" checked name="{{$item['name']}}[]"
                                                           value="{{$item_data['value']}}">
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @break
                                @case('history-work')
                                    <div class="history-work fool">
                                        <table class="no-wrap m-grid-3">
                                            <tbody>
                                            @foreach($item['data'] as $item_data)
                                                <tr class="label type__checkbox no_check ">
                                                    <td>{{$item_data->name}}</td>
                                                    <td class="m-span-1">{{$item_data->start_work}}</td>
                                                    <td class="no_size m-span-1">-</td>
                                                    <td class="m-span-1">{{$item_data->end_work}}</td>
                                                    <td class="m-span-1 pl-0 label_button"><label
                                                            class="pl-0 "
                                                            onclick="functionsArray['toggle_parent_active'](this, 'label', 'delete')"><input
                                                                type="checkbox"></label></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @break
                                @default
                            @endswitch
                        @endforeach
                    </div>
                @endforeach
            </div>
    @endforeach
</form>

