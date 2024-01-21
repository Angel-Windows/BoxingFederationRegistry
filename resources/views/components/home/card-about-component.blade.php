<div class="card-about-list">
    @foreach($card_data as $item)
        <div class="card">
            <div class="card_content front">
                <div class="img carl_logo">
                    <img src="{{asset($item['logo'])}}" alt="">
                </div>
                <h2>{{$item['name']}}</h2>
                <p>{{$item['text']}}</p>
                <div class="button_open buttons-content"
                     onclick="functionsArray['toggle_parent_active'](this, 'card', 'active','remove_old_active', ['card-about-list'])">
                    <em>{{$item['count']}}</em>
                    <img src="{{asset('img/arrow.svg')}}" alt="arrow">
                </div>
            </div>
            <div class="card_content back">
                <div class="img carl_logo">
                    <img src="{{asset('img/homeAbout/box.svg')}}" alt="">
                </div>
                <h2>{{$item['name']}}</h2>
                <p>{{$item['text']}}</p>
                <div class="buttons buttons-content">
                    <button  class="button"
                             onclick="functionsArray['open_modal']('search')"
                    ><img src="{{asset('img/search.svg')}}" alt="search"><span>Пошук</span></button>
{{--                    <a href="{{route('page.trainer')}}" class="button"><img src="{{asset('img/search.svg')}}" alt="search"><span>Пошук</span></a>--}}
                    <button class="button"><img src="{{asset('img/homeAbout/register.svg')}}" alt="register"><span>Реєстрація</span></button>
                </div>
            </div>
        </div>
    @endforeach
</div>
<script>


</script>
