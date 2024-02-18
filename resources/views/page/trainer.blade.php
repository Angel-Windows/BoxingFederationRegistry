<?php use \App\Services\MyAuthService?>
@extends('app.my-layout')
@php
    $page_name = Route::current()->parameters()['class_name'] ?? "";
@endphp
@section('title',(( \App\Models\Class\ClassType::getFind('link', $page_name)->name)?? ''))
@section('class_body', 'trainer')
@section('styles')
    @vite('resources/scss/page/trainer.scss')
@endsection

@section('scripts')@endsection
@section('content')
    <section class="nav">
        <h2>{{$more_data['name'] ?? ''}}</h2>
        @if(MyAuthService::CheckMiddlewareRoute($more_data))
            <div class="buttons">
                <a href="{{request()->url() . '/edit'}}" class="button"><img
                        src="{{asset('img/homeAbout/register.svg')}}" alt="register-icon"><span>Редагувати</span></a>
            </div>
        @endif
    </section>
    <section class="table-auto_fool">
{{--            @if(true)--}}
            @if($more_data['logo'] ?? null)
                <div class="{{$more_data['logo']['class'] ?? ''}} persone_img">
                    <div class="img"><img
                            src="{{ MyAsset($more_data['logo']['link'] ?? '') }}"
                            alt=""></div>
                </div>
            @endif
            @include('components.info.info')
            {{--                @foreach($data_info as $item_wrapper)--}}
            {{--                   --}}
            {{--                @endforeach--}}
        {{--        @endif--}}
        {{--        @if(isset($data_info['bottom_panel']))--}}
        {{--            <div class="grid-sp-2">--}}
        {{--                @foreach($data_info['bottom_panel'] as $item_wrapper)--}}
        {{--                    @include('components.info.info')--}}
        {{--                @endforeach--}}
        {{--            </div>--}}
        {{--        @endif--}}
    </section>
@endsection
