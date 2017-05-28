@extends('admin.layout.auth')


@section('title', 'Reset Email')

@section('content')
        
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-2">

                {{-- email sent status --}}
                @if (session('status'))
                    <div class="uk-alert-success" uk-alert>
                        {{ session('status') }}
                    </div>
                @endif
                
                <div class="card-block p-2">
                    <h1>Reset Password</h1>
                    <p class="text-muted"> Please provide the email associated with this account.</p>

                        
                    <form role="form" method="POST" action="{{ url('/admin/password/email') }}">
                    {{ csrf_field() }}

                        {{-- error input status --}}
                        @if ($errors->has('email'))
                            <div class="card-block p-2">
                                <div class="uk-alert-danger" uk-alert>
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            </div>
                        @endif

                        {{-- the email input --}}
                        <div class="input-group mb-1">
                            <span class="input-group-addon">@</span>
                            <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" autofocus>
                        </div>

                        <hr>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-block btn-primary"> Send Password Reset Link </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection
