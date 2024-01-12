@extends('app.my-layout')
@section('title', 'Trainer')
@section('class_body', 'trainer')
@section('styles')
    @vite('resources/scss/page/trainer.scss')
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // functionsArray['hideOverflowingElements_start']()
        });
    </script>
@endsection
@section('content')

    <section class="nav">
        <h2>Кравчук Віталій Вікторович</h2>
        @if(Auth::check())
            <div class="buttons">
                <a href="{{route(Route::current()->getName(), ['edit'])}}" class="button"><img src="{{asset('img/homeAbout/register.svg')}}" alt="register-icon">Редагувати</a>
            </div>
{{--            <button class="button"><img src="{{asset('img/homeAbout/register.svg')}}" alt="register-icon">Зберегти</button>--}}
        @endif
    </section>
    <section class="table-auto_fool">
        <div class="big_img">
            <div class="img"><img src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}" alt=""></div>
        </div>
        <div>
            <div class="info-wrapper">
                <ul class="buttons">
                    <li class="button white"><img src="{{asset('img/phone.svg')}}"
                                                  alt="phone-icon"><span>097 777-77-77</span></li>
                    <li><a class="button white" href="#"><img src="{{asset('img/mail.svg')}}" alt="mail-icon"><span>email@gmail.com</span></a>
                    </li>
                </ul>
                <table>
                    <tbody>
                    @foreach($temp__info_list as $key=>$item)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$item}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="history-work">
                <h3>Історія місць роботи</h3>
                <div class="info-wrapper mini">

                    <table class="no-wrap m-grid-3">
                        <thead>
                        <tr>
                            <th>Назва закладу</th>
                            <th class="m-span-1">Початок</th>
                            <th  class="no_size m-span-1"></th>
                            <th class="m-span-1">Кінець</th>
                        </tr>
                        </thead>
                        <tbody>

                        @for($i=0;$i<4;$i++)
                            @php
                                $start_year = random_int(2016, 2022);
                                $end_year = random_int($start_year, 2023);
                                    $start_date = $monthsUkrainian[array_rand($monthsUkrainian)] . ' ' .  $start_year;
                                    $end_date = $monthsUkrainian[array_rand($monthsUkrainian)] . ' ' .  $end_year;;
                            @endphp
                            <tr>
                                <td>Назва закладу</td>
                                <td class="m-span-1">{{$start_date}}</td>
                                <td class="no_size m-span-1">+</td>
                                <td class="m-span-1">{{$end_date}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <div class="fool todo_table">
            <div class="info-wrapper">
                <table class="no-wrap m-grid-2">
                    <thead>
                    <tr>
                        <th>ПІП</th>
                        <th class="m-span-1">Посада</th>
                        <th class="m-span-1">Телефон</th>
                        <th class="m-span-1">Пошта</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0;$i<4;$i++)
                        <tr>
                            <td class="m-span-1 img_wrapper">
                                <div class="img"><img src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}" alt=""></div>
                                <span>Кравчук Віталій</span>
                            </td>
                            <td class="m-span-1">Назва посади</td>
                            <td class="m-span-1">097 777-77-77</td>
                            <td class="m-span-1">email@gmail.com</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>

    </section>

@endsection
