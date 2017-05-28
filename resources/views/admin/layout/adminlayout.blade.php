<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ChurchAudioUpload">
    <meta name="author" content="Dameety">
    <meta name="keyword" content="Church,Laravel,Media,Mp3,Audio,Upload,Download">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ChurchAudiox - @yield('title')</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('/img/favicon/png') }}">
    <!-- Icons -->
    <link href="{{ URL::asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Main styles for this application form template-->
    <link href="{{ URL::asset('/css/imagehover.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/uikit.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
    </script>

</head>

<!-- app body -->
<body class="app header-fixed sidebar-fixed footer-fixed">

    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler hidden-lg-up" type="button">☰</button>
        {{-- <a class="navbar-brand" style="background:url('../img/logo.png');" href="{{ '/admin/home' }}"></a> --}}
        <a class="navbar-brand" href="{{ '/admin/home' }}"></a>

        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="{{ '/admin/sermons' }}">Sermons</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="{{ '/admin/services' }}">Services</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="{{ '/admin/categories' }}">Categories</a>
            </li>
        </ul>
        
        <ul class="nav navbar-nav ml-auto">
            
            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="hidden-md-down">{{ Auth::user()->name }}</span>
                </a>
            
                <div class="dropdown-menu dropdown-menu-right">

                    <a class="dropdown-item" href="{{ url('/admin/settings') }}"><i class="fa fa-wrench"></i> Configuration </a>
                    <div class="divider"></div>
                    <a class="dropdown-item" href="{{ url('/admin/logout') }}"><i class="fa fa-lock"></i> Logout </a>
                        
                </div>

            </li>
            
            <li class="nav-item hidden-md-down">
            </li>

        </ul>
    </header>


    <div id="app" class="app-body">
        
        {{-- the side bar --}}
        @include('admin.partials._sidebar');


        <!-- Main content -->
        @yield('content')

    </div>

    {{-- edit this path with your coy website link --}}
    <footer class="app-footer">
        <a href="http://pointlogix.io">ChurchAudiox</a> © 2017.
        </span>
    </footer>



    <script src="{{ URL::asset('/js/app.js') }}"></script>
    {{-- former auth bladee. php, includes boostrap and jquery --}}
    <script src="{{ URL::asset('/js/tether.min.js') }}"></script>
    {{-- from the template used for progress bar running when loading page ajax --}}
    <script src="{{ URL::asset('/js/pace.js') }}"></script>
    <!-- GenesisUI main scripts -->
    <script src="{{ URL::asset('/js/genesismain/app.js') }}"></script>   

    <!-- Plugins and scripts required by this views -->
    <script src="{{ URL::asset('/js/validate.js') }}"></script>
    <script src="{{ URL::asset('/js/uikit.min.js') }}"></script>

    <!-- Custom scripts required by this view from template i-->
    {{-- i chnged it form app.js to auth because the js form laravel is alrady named app.js --}}
    {{-- i can change the name form auth to whatever i like --}}
    <script src="{{ URL::asset('/js/auth.js') }}"></script>
    @yield('scripts')
    

    </script>


</body>

</html>