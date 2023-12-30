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
        });``
    </script>
@endsection
@section('content')
    <x-home.card-about-component/>
    <x-home.sponsor-list-component/>
@endsection
