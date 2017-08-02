<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="ChurchAudioUpload">
        <meta name="author" content="Damilola Jolayemi">
        <meta name="keyword" content="Church,Laravel,Media,Mp3,Audio,Upload,Download">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ChurchAudiox - @yield('title')</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link href="{{ URL::asset('/css/simple-line-icons.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/css/uikit.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet">


    </head>

    <body class="app flex-row align-items-center">

        <div id="app" class="container">

            @yield('content')

        </div>

        <script src="{{ URL::asset('/js/app.js') }}"></script>
        <script src="{{ URL::asset('/js/tether.min.js') }}"></script>
        <script src="{{ URL::asset('/js/uikit.min.js') }}"></script>

    </body>

</html>