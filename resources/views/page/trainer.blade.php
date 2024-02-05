@extends('app.my-layout')
@section('title', 'Trainer')
@section('class_body', 'trainer')
@section('styles')
    @vite('resources/scss/page/trainer.scss')
@endsection

@section('scripts')@endsection
@section('content')
    <section class="nav">
        <h2>{{$data_info['name']}}</h2>
        @if(Auth::check())
            <div class="buttons">
                <a href="{{route(Route::current()->getName(), ['edit'])}}" class="button"><img
                        src="{{asset('img/homeAbout/register.svg')}}" alt="register-icon">Редагувати</a>
            </div>
        @endif
    </section>
    <section class="table-auto_fool">
        @if(isset($data_info['right_panel']))

            <div class="{{$data_info['img']['class']}}">
                <div class="img"><img
                        src="{{ route('config.show-img', ['filename' => $data_info['img']['link'] ?? 'undefined']) }}"
                        alt=""></div>
            </div>

            <div>
                @foreach($data_info['right_panel'] as $item_wrapper)
                    @include('components.info.info')
                @endforeach
            </div>
        @endif
        @if(isset($data_info['bottom_panel']))
            <div class="grid-sp-2">
                @foreach($data_info['bottom_panel'] as $item_wrapper)
                    @include('components.info.info')
                @endforeach
            </div>
        @endif
    </section>
@endsection
