<?php
$current = \Route::currentRouteName() ?? 'home';
$title = isset($title)
    ? (__($title) . ' | ' . __('Site'))
    : __('Site');
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ $title }}</title>

    <link rel="preload" href="{{ asset('css/bootstrap/bootstrap.min.css') }}" as="style" type="text/css">
    <link rel="preload" href="{{ asset('css/all.min.css') }}" as="style" type="text/css">
    <link rel="preload" href="{{ asset('css/brands.min.css') }}" as="style" type="text/css">
    <link rel="preload" href="{{ asset('css/fontawesome.min.css') }}" as="style" type="text/css">
    <link rel="preload" href="{{ asset('css/regular.min.css') }}" as="style" type="text/css">
    <link rel="preload" href="{{ asset('css/solid.min.css') }}" as="style" type="text/css">
    <link rel="preload" href="{{ asset('css/style.css') }}" as="style" type="text/css">

    <link rel="stylesheet" href="{{  asset('css/bootstrap/bootstrap.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/brands.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/regular.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/solid.min.css') }}">
    <link rel="stylesheet" href="{{  asset('css/style.css')  }}">

</head>
<body>

@include('layouts.header')

<div class="container mt-4">
    @yield('content')
</div>

@include('layouts.footer')

<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
@yield('scripts')
@stack('scripts')
</body>
</html>
