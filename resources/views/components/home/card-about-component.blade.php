<div class="card-about-list">
    @foreach($card_data as $item)
        <div class="card">
            <div class="card_content front">
                <div class="img carl_logo">
                    <img src="{{asset($item['logo'])}}" alt="">
                </div>
                <h2>{{$item['name']}}</h2>
                <p>{{$item['description']}}</p>
                <div class="button_open buttons-content"
                     onclick="functionsArray['toggle_parent_active'](this, 'card', 'active','remove_old_active', ['card-about-list'])">
                    <em>{{$item['count']}} {{$item['genitive']}}</em>
                    <img src="{{asset('img/arrow.svg')}}" alt="arrow">
                </div>
            </div>
            <div class="card_content back">
                <div class="img carl_logo">
                    <img src="{{asset($item['logo'])}}" alt="">
                </div>
                <h2>{{$item['name']}}</h2>
                <p>{{$item['description']}}</p>
                <div class="buttons buttons-content">
                    <button  class="button"
                             onclick="functionsArray['open_modal']('search', {'class_types': {{$item['id']}}})"
                    ><img src="{{asset('img/search.svg')}}" alt="search"><span>Пошук</span></button>
                    @switch($item['link'])
{{--                        @case('category_fun_zones')--}}
                        @case('category_stores')
                        @break
                        @default
                            <button
                                class="button"
                                onclick="functionsArray['open_modal']('register-box', {'category': '{{$item['link']}}'})"
                            ><img src="{{asset('img/homeAbout/register.svg')}}" alt="register"><span>Реєстрація</span></button>
                    @endswitch

                </div>
            </div>
        </div>
    @endforeach
</div>
<script>


</script>
