@extends('app.my-layout')
@section('title', 'Home')
@section('class_body', 'home')
@section('styles')
    @vite('resources/scss/page/home.scss')

@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            functionsArray['hideOverflowingElements_start']()
            functionsArray['inputs_input']();
        });
    </script>
@endsection
@section('content')
    <x-home-card-about-component :data="$card_data"/>
    <x-home.sponsor-list-component/>
    <style>
        /*.your-slider .slick-slide{*/
        /*        padding: 20px;*/
        /*        margin: 0 20px;*/
        /*        background: red;*/
        /*}*/
    </style>
@endsection
