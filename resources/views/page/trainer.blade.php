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
    <h2>Кравчук Віталій Вікторович</h2>
    <div class="table-auto_fool">
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
                    @php
                        $temp__info_list = [
                                'Кваліфікація' => 'Lorem ipsum dolor sit amet consectetur. ',
                                'Моя федерація' => 'Назва федерації',
                                'Адреса проживання' => 'м. Львів, Київська 34, кв. 5',
                                'Державні, почесні звання, спортивні звання та розряди' => 'Lorem ipsum dolor sit amet consectetur. ',
                                'Державні заохочення' => 'Lorem ipsum dolor sit amet consectetur. ',
                                'Мої навчальні заклади' => 'Lorem ipsum dolor sit amet consectetur. ',
                                'Мої спортсмени' => 'Кравчук Віталій, Кравчук Віталій, Кравчук Віталій, Кравчук Віталій, Кравчук Віталій, Кравчук Віталій,Кравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук Віталій',
                                ];
                    @endphp
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
                        @php
                            $monthsUkrainian = [
                              'Січень',
                              'Лютий',
                              'Березень',
                              'Квітень',
                              'Травень',
                              'Червень',
                              'Липень',
                              'Серпень',
                              'Вересень',
                              'Жовтень',
                              'Листопад',
                              'Грудень'
                            ];
                        @endphp
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
    </div>

@endsection
