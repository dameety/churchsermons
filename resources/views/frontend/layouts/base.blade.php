<!doctype html>
    
<html lang="{{ config('app.locale') }}">

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - @yield('title')</title>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.3/css/bulma.min.css" />

        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.27/css/uikit.min.css" /> -->

        <link rel="stylesheet" href="{{ asset('/css/uikit.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('/css/frontend/base.css') }}">
        
        @yield('styles')

    </head>

    <body>

        <div id="app">
            
            <section class="hero is-medium">

                @include('frontend.partials._header')
            
            </section>


            @yield('content')    


            @include('frontend.partials._footer')
        
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.27/js/uikit.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.27/js/uikit-icons.min.js"></script>
        

        <script src="{{ asset('/js/frontend/base.js') }}"></script>

        @yield('scripts')
        
    </body>

</html>