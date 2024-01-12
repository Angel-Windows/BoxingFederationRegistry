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
                <button class="button"><img src="{{asset('img/homeAbout/register.svg')}}" alt="register-icon">Зберегти
                </button>
            </div>
        @endif
    </section>
    <section class="table-auto_fool editц">
        <div class="big_img">
            <div class="img"><img src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}" alt=""></div>
        </div>
        <div>
            <div class="">
                <form action="">
                    <div class="table">

                        @foreach($temp__info_list as $key=>$item)
                            @php
                                $name = $item['placeholder'] ?? $item ?? "No text";
                                $class = '';
                                $class .=  $item['size'] ?? "";
                                $type =  $item['type'] ?? "text";
                            @endphp

                            <label class="label type__text  {{$class}}">
                                <span class="unselectable">{{$name}}</span>
                                <input oninput="active_write(this)" placeholder="" type="{{$type}}">
                            </label>
                        @endforeach



                    </div>
                    <h3>Мої спортсмени</h3>
                    <div class="checkbox-list">
                        @foreach($temp__checkboxes as $user_ids=>$item)
                            <div class="label type__checkbox no_check inline-flex">
                                <span class="">{{$item}}</span>
                                <label>
                                    <input type="checkbox">
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="history-work">
                        <h3>Історія місць роботи</h3>

                        <table class="no-wrap m-grid-3">
                            <tbody>
                            @for($i=0;$i<4;$i++)
                                @php
                                    $start_year = random_int(2016, 2022);
                                    $end_year = random_int($start_year, 2023);
                                        $start_date = $monthsUkrainian[array_rand($monthsUkrainian)] . ' ' .  $start_year;
                                        $end_date = $monthsUkrainian[array_rand($monthsUkrainian)] . ' ' .  $end_year;;
                                @endphp
                                <tr class="label type__checkbox no_check">
                                    <td>Назва закладу</td>
                                    <td class="m-span-1">{{$start_date}}</td>
                                    <td class="no_size m-span-1">-</td>
                                    <td class="m-span-1">{{$end_date}}</td>
                                    <td class="m-span-1 pl-0 label_button"><label class="pl-0" onclick="functionsArray['toggle_parent_active'](this, 'label', 'active')"><input type="checkbox"></label></td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <script>
                function active_write(elem) {
                    if (elem.value !== "") {
                        elem.parentNode.classList.add('active')
                    } else {
                        elem.parentNode.classList.remove('active')
                    }
                }

            </script>
        </div>
    </section>

@endsection
