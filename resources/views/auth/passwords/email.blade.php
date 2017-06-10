@extends('frontend.layouts.master')

@section('title', 'Reset Password')

@section('content')

    <div  class="container-fluid reset-container-body">
        
        <div class="container">
                
            <div class="reset-body">
            
                <div class="row page-heeding-row">
                    <h1 class="reset-heading"> Reset Password </h1>     
                </div>           


                <div class="row">
                    <div class="col-md-6 col-md-offset-3">


                        @include('frontend.partials._errors')


                        <div class="panel panel-default">
                            <div class="panel-heading">Enter your email address</div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}
                        
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <input id="email" type="text" class="form-control" name="email"  value="{{ old('email') }}" required autofocus>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-block btn-primary"> Send Password Reset Link </button>

                                </form>
                                    
                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div>


    </div>



@endsection