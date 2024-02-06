<form method="post"
      action="{{route('page.class.' . $route_type, ['class_name'=>'category_trainers', 'id'=>1])}}"
      id="form_edit"
      enctype="multipart/form-data"
>
    @csrf
    {{ $slot }}
    @foreach($table as $item_list)

        @if(isset($item_list['title']))
            <h3>{{$item_list['title']}}</h3>
        @endif
        <div class="table">
            @foreach($item_list['data'] as $item)
                @php
                    $class = '';
                    $class .=  $item['size'] ?? "";
                    $value = "";
                    if (isset($item['value']) &&  $item['value']){
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
                        <label class="label type__text  {{$class}} act">
                            <span class="unselectable">{{$item['placeholder']}}</span>
                            <input class="input" placeholder="" name="{{$item['name']}}"
                                   type="{{$type}}" value="{{$value}}">
                        </label>
                        @break
                    @case('custom-select')
                        <div class="custom-select  {{$class}}">
                            <label class="label type__text  {{$class}}">
                                <span class="unselectable">{{$item['placeholder']}}</span>
                                <input type="text"
                                       name="{{$item['name']??''}}"
                                       value="{{$value}}"
                                       class="custom-select-input input">
                            </label>
                            <ul class="custom-select-options">
                                @foreach($item['option'] as $item)
                                    <li>{{$item}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @break
                    @case('select-box')
                        <div class="select-box  {{$class}}">
                            <label class="label type__text  {{$class}}">
                                <span class="unselectable">{{$item['placeholder']}}</span>
                                <select
                                       type="text"
                                       name="{{$item['name']??''}}"
                                       value="{{$value}}"
                                       class=" input">
                                    <option value="">Не обрано</option>
                                    @foreach($item['option'] as $key=>$item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        @break
                    @case('checkbox-list')
                        <div class="checkbox-list fool">
                            @foreach($item['data'] as $user_ids=>$item_data)
                                <div class="label type__checkbox no_check inline-flex">
                                    <span class="">{{$item_data['text']}}</span>
                                    <label>
                                        <input type="checkbox" name="{{$item['name']}}"
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
</form>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        const all_inputs = document.querySelectorAll('.input')
        all_inputs.forEach((item) => {
            item.addEventListener('focus', () => {
                functionsArray['add_parent_active'](item, 'label', 'active')
            })
            item.addEventListener('blur', () => {
                setTimeout(() => {
                    if (item.value !== "") {
                        functionsArray['add_parent_active'](item, 'label', 'active')
                    } else {
                        functionsArray['remove_parent_active'](item, 'label', 'active')
                    }
                }, 100)
            })
        })
        const custom_select = document.querySelectorAll('.custom-select')
        custom_select.forEach((item) => {
            let selectInput = item.querySelector('.custom-select-input');
            let selectOptions = item.querySelector('.custom-select-options');
            let optionItems = selectOptions.querySelectorAll('li');

            selectInput.addEventListener('focus', function () {
                filterOptions(selectInput, selectOptions, optionItems);
                selectOptions.style.display = 'block';
            });

            selectInput.addEventListener('input', function () {
                filterOptions(selectInput, selectOptions, optionItems);
                selectOptions.style.display = 'block';
            });

            selectOptions.addEventListener('click', function (e) {
                if (e.target.tagName === 'LI') {
                    selectInput.value = e.target.textContent;
                    selectOptions.style.display = 'none';
                }
            });

            document.addEventListener('click', function (e) {
                if (!selectInput.contains(e.target) && !selectOptions.contains(e.target)) {
                    selectOptions.style.display = 'none';
                }
            });
        })

        function filterOptions(selectInput, selectOptions, optionItems) {
            let inputValue = selectInput.value.toLowerCase();
            optionItems.forEach(function (item) {
                if (inputValue === '') {
                    selectOptions.classList.add('show-all');
                } else {
                    selectOptions.classList.remove('show-all');
                }
                if (item.textContent.toLowerCase().indexOf(inputValue) > -1) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    });
</script>
