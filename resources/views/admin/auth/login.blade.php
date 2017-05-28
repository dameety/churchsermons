@extends('admin.layout.auth')

@section('title', 'Admin Login')

@section('content')
        
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-2">
                
                <div class="card-block p-2">
                    <h1>Login</h1>
                    <p class="text-muted">Provide your details to access account.</p>

                    <form role="form" method="POST" action="{{ url('/admin/login') }}">
                    {{ csrf_field() }}

                        @if (count($errors) > 0)
                            <div class="card-block p-2">
                                <div class="uk-alert-danger" uk-alert>
                                    @foreach ($errors -> all() as $error)
                                        <strong> <li> {{$error}} </li> </strong>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="input-group mb-1">
                            <span class="input-group-addon">@</span>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus>
                        </div>

                        <div class="input-group mb-1">
                            <span class="input-group-addon"><i class="icon-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>

                        <div class="input-group mb-1">
                             <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> &nbsp; Remember Me
                                </label>
                            </div>
                        </div>
                        <hr>

                        <div class="card-footer p-2">
                            <div class="row">
                                <button type="submit" class="btn btn-block btn-primary">Login</button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="card-footer p-2">
                    <div class="row">
                        <a class="btn btn-block btn-default" href="{{ url('/admin/password/reset') }}">Forgot Your Password?</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
