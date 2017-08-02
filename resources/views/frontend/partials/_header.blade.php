<div class="hero-head is-10" uk-sticky="show-on-up: true; animation: uk-animation-slide-top; bottom: #bottom">
    <div class="topmost-bar-design"></div>
    <header class="nav">
        <div id="nav" class="container">
            <div class="nav-left">
                <a class="nav-item" href="{{url('/')}}">
                    <img src="/img/logo.png" alt="Logo">
                </a>
            </div>
            <span class="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <div class="nav-right nav-menu">
                @if (Auth::guest())
                    <a class="nav-item is-active" href="{{ route('register') }}">
                        Create account
                    </a>

                    <span class="nav-item">
                        <a class="button is-primary is-outlined" href="{{ route('login') }}">Access account</a>
                    </span>
                @elseif (!Auth::guest())
                    <a class="nav-item" href="{{ route('allSermons') }}">
                        Sermons
                    </a>

                    <a class="nav-item" href="{{ route('viewFavourite') }}">
                        My Favourites
                    </a>

                    <a class="nav-item" href="{{ route('profile') }}">
                        My Account
                    </a>

                    <span class="nav-item">
                        <a class="button is-danger is-outlined" href="{{ route('logout') }}">Logout</a>
                    </span>
                @endif
            </div>
        </div>
    </header>
</div>
