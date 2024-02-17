@php
    use App\Services\MyAuthService;
        $phone = null;
            $class_header_color = 'white';

            if(trim($__env->yieldContent('class_body')) !== 'home'){
                $class_header_color = 'black';
    //            $phone = ;
    //            dd($more_data);
            }

            if ($more_data){
//                dd($more_data);
                $phone = $more_data['phone'] ?? 'err';
            }

@endphp
<header class="header content-wrapper">
    <a href="{{route('page.home')}}">
        <div class="logo img">
            <img src="{{ asset('img/logo.svg') }}" alt="FBU Logo">
        </div>
        <h1>Інформаційний портал федерації боксу України</h1>
    </a>
    <div>
        @if(\App\Services\MyAuthService::CheckMiddleware($phone))
            <a class="auth-button {{$class_header_color}}" href="{{route('auth.logout')}}">Вийти</a>
        @else
            <div class="auth-button {{$class_header_color}}" onclick="functionsArray['open_modal']('auth', {})">Увійти
            </div>
        @endif

        <p>Технічна підтримка: <a href="mailto:www@gmail.com">www@gmail.com</a></p>
        <div class="burger" onclick="functionsArray['add_class'](this, 'modal_wrapper_two', 'open')">
            <svg width="25" height="25" viewBox="0 0 42 26" fill="{{$class_header_color}}"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10.5 2.19844C10.5 1.20436 11.4402 0.398438 12.6 0.398438H39.9C41.0598 0.398438 42 1.20436 42 2.19844C42 3.19252 41.0598 3.99844 39.9 3.99844H12.6C11.4402 3.99844 10.5 3.19245 10.5 2.19844ZM39.9 11.1984H2.1C0.940242 11.1984 0 12.0044 0 12.9984C0 13.9925 0.940242 14.7984 2.1 14.7984H39.9C41.0598 14.7984 42 13.9925 42 12.9984C42 12.0044 41.0598 11.1984 39.9 11.1984ZM39.9 21.9984H21C19.8403 21.9984 18.9 22.8044 18.9 23.7984C18.9 24.7924 19.8403 25.5984 21 25.5984H39.9C41.0598 25.5984 42 24.7924 42 23.7984C42 22.8044 41.0598 21.9984 39.9 21.9984Z"
                    class="svg-object"/>
            </svg>

        </div>

        <div class="modal_wrapper_two ">
            <div class="bg" onclick="functionsArray['toggle_parent_active'](this, 'modal_wrapper_two', 'open')"></div>
            <div class="burger_menu">
                <div class="burger_content unselectable">
                    <div class="modal_header">
                        @if(\App\Services\MyAuthService::CheckMiddleware($phone))
                            <a class="auth-button" href="{{route('auth.logout')}}">Вийти</a>
                        @else
                            <div class="auth-button" onclick="functionsArray['open_modal']('auth', {})">Увійти</div>
                        @endif
                        <div class="close_modal" onclick="functionsArray['remove_class']('modal_wrapper_two', 'open')">
                            <img src="{{asset('img/close.svg')}}" alt=""></div>
                    </div>
                    <div class="accordion">
                        @foreach($card_data as $key=>$item)
                            <div class="{{$key == 4 ? 'active' : ''}} accordion-item">
                                <div class="accordion-header">{{$item->name}}</div>
                                <div class="button_wrapper accordion-content">
                                    <button class="button"
                                            onclick="functionsArray['open_modal']('search', {'class_types': {{$item['id']}}})"
                                    ><img src="{{asset('img/search.svg')}}" alt="search"><span>Пошук</span></button>
                                    <button
                                        class="button"
                                        onclick="functionsArray['open_modal']('register-box', {'category': '{{$item['link']}}'})"
                                    ><img src="{{asset('img/homeAbout/register.svg')}}"
                                          alt="register"><span>Реєстрація</span></button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>

<style>

</style>
<script>

    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
        const header = item.querySelector('.accordion-header');

        header.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            closeAllItems();
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });

    function closeAllItems() {
        accordionItems.forEach(item => {
            item.classList.remove('active');
        });
    }

</script>
