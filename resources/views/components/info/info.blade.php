@foreach($data_info as $key=>$item_infos)
<div class="@if($key>0) fool @endif  {{$more_data['class']??''}}">
    @foreach($item_infos as $item_info)
    <div class="{{$item_info['class'] ?? ''}}">
        @if(isset($item_info['title']))
            <h3>{{$item_info['title']}}</h3>
        @endif
        @if($item_info)
        <div class="info-wrapper {{$data_info['data-wrapper']['class'] ?? ""}}">
            @foreach($item_info['data_wrapper'] ?? [] as $item_right)
                @switch($item_right['type'] ?? '')
                    @case('buttons')

                        <ul class="buttons">
                            @foreach($item_right['data'] as $item_data)
                                @php
                                    $link_button = '';
                                    if (($item_data['name'] ?? '') === 'phone'){
                                         $link_button = "tel:" . ($item_data['value'] ?? '');
                                    }else{
                                         $link_button = "mailto:" . ($item_data['value'] ?? '');
                                    }
                                @endphp
                                <a href="{{$link_button}}" class="button white">
                                    <img src="{{asset($item_data['logo'] ?? '')}}"
                                                              alt="phone-icon">
                                    <span>{{$item_data['value'] ?? ''}}</span>
                                </a>
                            @endforeach
                        </ul>
                        @break
                    @case('table')
                        <table class="{{$item_right['class'] ?? ""}}">
                            @if(isset($item_right['data']['thead']))
                                <thead>
                                <tr>
                                    @foreach($item_right['data']['thead'] as $thead_item)
                                        <th>{{$thead_item}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                            @endif
                            <tbody>
                            @foreach($item_right['data']['body'] as $item_body)
                                <tr>
                                    @foreach($item_body as $item)
                                        <td>{{$item}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @break
                    @case('todo_table')
                        <div class="fool todo_table">
                            <table class="no-wrap m-grid-3">
                                @if(isset($item_right['data']['thead']))
                                    <thead>
                                    <tr>
                                        @foreach($item_right['data']['thead'] as $thead_item)
                                            <th>{{$thead_item}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                @endif
                                <tbody>
                                @foreach($item_right['data']['body'] ?? [] as $item_body)
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
                                                            onclick="functionsArray['toggle_parent_active'](this, 'label', 'delete')"><input
                                                                type="checkbox"></label></td>
                                                    @break
                                                @default
                                                    <td>
                                                        <span>{{$item_td}}</span>
                                                    </td>
                                    @endswitch
                                @endforeach
                                @endforeach
                                {{--                            @foreach($item_right['data']['body'] as $item_body)--}}
                                {{--                                <tr>--}}
                                {{--                                    @foreach($item_body as $key=>$item_td)--}}
                                {{--                                        <td>--}}
                                {{--                                            @if(!$key)--}}
                                {{--                                                <div class="img"><img--}}
                                {{--                                                        src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}"--}}
                                {{--                                                        alt="">--}}
                                {{--                                                </div>--}}
                                {{--                                            @else--}}
                                {{--                                                <span>{{$item_td}}</span>--}}
                                {{--                                            @endif--}}
                                {{--                                        </td>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </tr>--}}
                                {{--                            @endforeach--}}
                                </tbody>
                            </table>
                        </div>
                        @break
                @endswitch
            @endforeach

        </div>
            @endif
    </div>
    @endforeach
    </div>
@endforeach
