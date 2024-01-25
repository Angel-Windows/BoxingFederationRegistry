@if($item_wrapper['title'])
    <h3>{{$item_wrapper['title']}}</h3>
@endif
<div class="info-wrapper {{$item_wrapper['data-wrapper']['class'] ?? ""}}">
    @foreach($item_wrapper['data-wrapper']['data'] as $item_right)
        @switch($item_right['type'])
            @case('buttons')
                <ul class="buttons">
                    @foreach($item_right['data'] as $item_data)
                        <li class="button white"><img src="{{asset($item_data['logo'])}}"
                                                      alt="phone-icon"><span>{{$item_data['text']}}</span>
                        </li>
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
                        @foreach($item_right['data']['body'] as $item_body)
                            <tr>
                                @foreach($item_body as $key=>$item_td)
                                    <td >
                                        @if(!$key)
                                            <div class="img"><img
                                                    src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}"
                                                    alt="">
                                            </div>
                                        @else
                                            <span>{{$item_td}}</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @break
        @endswitch
    @endforeach
</div>
