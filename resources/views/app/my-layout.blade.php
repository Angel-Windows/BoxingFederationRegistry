<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="ajax-link" content="{{route('ajax.link')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/scss/components.scss'])
    @yield('styles')
    <title>@yield('title' ?? 'Boxes')</title>
</head>
<body class="@yield('class_body')">
<x-app-header-component :data="$more_data??[]"/>

<div class="content-wrapper">
    @if(trim($__env->yieldContent('class_body')) !== 'home')
        <x-app-bread-crumbs-component/>

    @endif
    <main class="content">
        @yield('content')
    </main>
</div>
@if(trim($__env->yieldContent('class_body')) === 'home')
    <x-app.footer-component/>
@endif
<div class="modal_wrapper">
    <div class="bg" onclick="functionsArray['toggle_parent_active'](this, 'modal_wrapper', 'open')"></div>
    <div class="modal_content_wrapper">
        <div class="modal_content">

        </div>
    </div>
</div>
<div class="custom-alert"></div>
@vite('resources/js/function_interface.js')
@yield('scripts')
</body>
</html>
