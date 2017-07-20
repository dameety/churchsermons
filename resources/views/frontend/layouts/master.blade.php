<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} - @yield('title')</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="{{ URL::asset('/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('/css/uikit.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('/css/frontend/responsive.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('/css/frontend/style.css') }}">

        @yield('styles')
    </head>

    <body>

        <div id="app">

            @include('frontend.partials._header')

            @yield('content')

            @include('frontend.partials._footer')

        </div>

        <script src="{{ URL::asset('/js/app.js') }}"></script>
        <script src="{{ URL::asset('/js/uikit.min.js') }}"></script>
        @yield('scripts')
    </body>

</html>
