<div class="card-about-list">
    @for($i = 0; $i < 10; $i++)
        <div class="card">
            <div class="card_content front">
                <div class="img carl_logo">
                    <img src="{{asset('img/homeAbout/box.svg')}}" alt="">
                </div>
                <h2>Федерації боксу</h2>
                <p>Тут ви знайдете інформацію по всіх існуючих в Україні федераціях боксу та їх працівниках</p>
                <div class="button_open buttons-content"
                     onclick="functionsArray['toggle_parent_active'](this, 'card', 'active','remove_old_active', ['card-about-list'])">
                    <em>375 спортсменів</em>
                    <img src="{{asset('img/arrow.svg')}}" alt="arrow">
                </div>
            </div>
            <div class="card_content back">
                <div class="img carl_logo">
                    <img src="{{asset('img/homeAbout/box.svg')}}" alt="">
                </div>
                <h2>Федерації боксу</h2>
                <p>Тут ви знайдете інформацію щодо всіх існуючих в Україні федерацій боксу та їх працівників</p>
                <div class="buttons buttons-content">
                    <button  class="button"
                             onclick="functionsArray['open_modal']('search')"
                    ><img src="{{asset('img/search.svg')}}" alt="search"><span>Пошук</span></button>
{{--                    <a href="{{route('page.trainer')}}" class="button"><img src="{{asset('img/search.svg')}}" alt="search"><span>Пошук</span></a>--}}
                    <button class="button"><img src="{{asset('img/homeAbout/register.svg')}}" alt="register"><span>Реєстрація</span></button>
                </div>
            </div>
        </div>
    @endfor
</div>
<script>


</script>
