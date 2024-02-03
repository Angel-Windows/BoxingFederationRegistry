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
        <div class="buttons">
            <button onclick="functionsArray['ajax_postFormFind']('form_edit', 'form_edit_category')" class="button"><img
                    src="{{asset('img/homeAbout/register.svg')}}" alt="register-icon">Зберегти
            </button>
        </div>
    </section>
    <section class="table-auto_fool edit">
        <div class="big_img">
            <div class="img"><img src="{{asset('img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png')}}" alt=""></div>
        </div>
        <div>
            <div class="">
                <x-forms.category-register-form-component :class="$class_name" :id="$id" />
            </div>
        </div>
    </section>
@endsection
