@if (count($errors) > 0)

    <div id="alert" class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        @foreach ($errors -> all() as $error)
            <strong> <li class="error"> {{$error}} </li> </strong>
        @endforeach
    </div>
        
@endif


@if(Session::has('cardError'))

    <div id="alert" class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p><strong>{!! Session::get('cardError') !!} </strong></p>
    </div>

@endif

@if(Session::has('invalidRequest'))

    <div id="alert" class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p><strong>{!! Session::get('invalidRequest') !!} </strong></p>
    </div>

@endif


@if(Session::has('serverError'))

    <div id="alert" class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p><strong>{!! Session::get('serverError') !!} </strong></p>
    </div>

@endif


@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
