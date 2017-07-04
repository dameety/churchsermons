<nav id="navbarx" class="navbar navbar-default">
    <div class="container navbar-container">

        <div class="navbar-header">

            <button type="button" class="btn btn-link navbar-toggle collapsed" data-toggle="modal" data-target="#menuModal">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand churchBrand" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="{{ isActiveURL('login') }}">
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="{{ isActiveURL('/register') }}">
                        <a href="{{ route('register') }}">Register</a>
                    </li>
                @elseif (Auth::check())
                    @if( Auth::user()->subscriptionStatus === null )

                        <li class="{{ isActiveURL('/user/upgrade') }}">
                            <a href="{{ route('upgradeAccount') }}">Upgrade</a>
                        </li>

                    @endif
                    @if( Auth::user()->subscriptionStatus === "active" )

                    @endif
                    @if( Auth::user()->subscriptionStatus === "cancelled" )

                        <li class="{{ isActiveURL('/user/premium/renew') }}">
                            <a href="{{ route('reactivateSubscription') }}" onclick="event.preventDefault();
                                document.getElementById('reactivate-form').submit();"> Reactivate
                            </a>
                            <form id="reactivate-form" action="{{ route('reactivateSubscription') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>

                    @endif
                    <li class="{{ isActiveURL('/sermons') }}">
                        <a href="#">Sermons</a>
                    </li>
                    <li class="{{ isActiveURL('/sermons/favourites') }}">
                        <a href="#">My Favourites</a>
                    </li>
                    <li class="{{ isActiveURL('/user/profile') }}">
                        <a href="#">My Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                    </li>
                @endif
            </ul>

        </div>


        {{-- start --}}
        <div class="modal fade fullscreen" id="menuModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                            <button type="button" class="close btn btn-link" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close fa-lg" style="color:#999;"></i></button>
                            <h4 class="modal-title text-center"><span class="sr-only">main navigation</span></h4>
                    </div>
                    <div class="modal-body text-center">
                        <ul class="uk-list">
                            @if (Auth::guest())
                                <li class="{{ isActiveURL('/login') }}">
                                    <a href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="{{ isActiveURL('/register') }}">
                                    <a href="{{ route('register') }}">Register</a>
                                </li>
                            @elseif (Auth::check())
                                <li class="{{ isActiveURL('/sermons') }}">
                                    <a href="#">Sermons</a>
                                </li>
                                <li class="{{ isActiveURL('/sermons/myfavourites') }}">
                                    <a href="#">My Favourites</a>
                                </li>
                                <li class="{{ isActiveURL('/user/profile') }}">
                                    <a href="#">My Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}">Logout</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.fullscreen -->

    </div>
</nav>

