@extends('app.my-layout')
@php
    $page_name = Route::current()->parameters()['class_name'] ?? "";
@endphp
@section('title',(( \App\Models\Class\ClassType::getFind('link', $page_name)->name)?? '') . ' Редагування')
@section('class_body', 'trainer')
@section('styles')
    @vite('resources/scss/page/trainer.scss')
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            functionsArray['inputs_input']();
        });
    </script>
@endsection
@section('content')

    <section class="nav">
        <h2>{{$get['more_data']['name']}}</h2>
{{--@dd($class_name)--}}
        <div class="buttons">
            <a href="{{ route('page.class', [
            'class_name' => $class_name,
            'id' => $id
        ]) }}" class="button">
                <img
                    src="{{asset('img/homeAbout/register.svg')}}"
                    alt="register-icon"
                ><span>Повернутись</span>
            </a>
            <button
                onclick="functionsArray['ajax_postFormFind']('form_edit', 'form_edit_category')"
                class="button"
            ><img
                    src="{{asset('img/icon/save.svg')}}" alt="register-icon"><span>Зберегти</span>
            </button>
        </div>
    </section>
    <section>
        <div class="">
            <x-forms-category-register-form-component :class="$class_name" :id="$id" :get="$get"
                                                      :type_submit="'register'">
                {{--                <div class="big_img">--}}
                {{--                    <div class="img"><img src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}" alt="">--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                @php
                    $class_img = '';
                    if ($get['more_data']['logo']){
                        $class_img .= $get['more_data']['logo']['class'];

                    }else{
                    $class_img = 'big_img';
                    }
                @endphp
                <div class="upload_img {{$class_img}}" id="imageButton">
                    <div class="drop">Відпустити тут</div>
                    <div class="img">
                        <input type="image" src="{{MyAsset($get['more_data']['logo']['link'] ?? '')}}" alt=""
                               name="image">
                    </div>
                    <div class="buttons">
                        {{--                        <button class="button one white">Зробити фото</button>--}}
                        <button type="button" class="button one button_open_file white"><img
                                src="{{asset('img/icon/edit.svg')}}" alt=""></button>
                        <input type="file" name="photo" style="display:none;">
                    </div>
                </div>
            </x-forms-category-register-form-component>
        </div>
    </section>
@endsection
