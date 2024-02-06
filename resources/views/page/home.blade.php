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
        });
    </script>
@endsection
@section('content')
{{--    <video id="video" autoplay></video>--}}
    <x-home-card-about-component :data="$card_data"/>
    <x-home.sponsor-list-component/>
@endsection
