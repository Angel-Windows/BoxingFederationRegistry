<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/scss/components.scss'])
    @yield('styles')
    <title>@yield('title' ?? 'Boxes')</title>
</head>
<body class="@yield('class_body')">
<x-app.header-component/>
<div class="content-wrapper">
    @if(trim($__env->yieldContent('class_body')) !== 'home')
    <x-app.bread-crumbs-component />
    @endif
    <div class="content">
        @yield('content')
    </div>

</div>
@if(trim($__env->yieldContent('class_body')) === 'home')
    <x-app.footer-component/>
@endif
@vite('resources/js/function_interface.js')
@yield('scripts')
</body>
</html>
