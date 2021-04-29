<head>
    @production
        <!-- Google Tag Manager -->
    @endproduction

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{!! config('app.name') !!}" />
    <meta property="og:locale" content="en_US" />
{{--    <meta name="geo.region" content="US-IN" />--}}
{{--    <meta name="geo.placename" content="Evansville" />--}}
{{--    <meta name="geo.position" content="37.947659589652915, -87.55002292621695" />--}}
{{--    <meta name="ICBM" content="37.947659589652915, -87.55002292621695" />--}}
    <meta name="keywords" content="@yield('meta_keywords')"/>

    <meta name="title" content="@yield('meta_title', config('app.name'))"/>
    <meta property="og:title" content="@yield('og_title') | {!! config('app.name') !!}" />
    <meta name="twitter:title" content="@yield('og_title') | {!! config('app.name') !!}" />
    <meta property="description" content="@yield('meta_description')" />
    <meta name="description" content="@yield('meta_description')" />
    <meta property="og:description" content="@yield('og_description')" />
    <meta name="twitter:description" content="@yield('og_description')" />
    <meta property="og:image" content="@yield('og_image')" />
    <meta name="twitter:image" content="@yield('og_image')" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.svg') }} ">
    @stack('additional-meta')

    <link rel="stylesheet" type="text/css" href="{{ mix('dist/css/app.css') }}">

    @stack('styles')

    <title>@yield('title', 'Home') | {!! config('app.name') !!}</title>
</head>
