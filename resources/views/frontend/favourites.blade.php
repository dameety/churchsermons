@extends('frontend.layouts.master')

@section('title', 'Favourites')

@section('content')
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/home.css') }}">

    <div class="container page-heading-container">

        <div class="row page-heading-box">

            <h2 class="page-heading">
                My Favourites
            </h2>

        </div>

    </div>

    <div id="container" class="container container-mobile">
        

        <div class="row content-block">
            
            {{-- filter part --}}
            @include('frontend.partials.filters-desktop')
            
            
            {{-- right part --}}
            <div class="col-sm-10 sermon-col">

                <div class="form-group">

                    {{-- flash messages --}}
                    @include('flash::message')

                    {{-- the filter for responsive view --}}
                    @include('frontend.partials.filters')
                

                </div>

                @if($favCount === 0)

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <span uk-icon="icon: info; ratio: 5"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            
                            <p class="no-sermon">
                                You have no sermon favourites yet.
                            </p>

                        </div>
                    </div>
                            
                @endif

                @foreach ($sermons as $sermon)

                    <div class="panel sermon-box">
                            
                            <div class="col-xs-2 sermon-box-art">
                                <img class="img-fluid sermon-art" src="/img/otherimage.jpg" alt="sermon art">
                            </div> 

                            {{--  this one is for mobile view --}}
                            <div class="col-xs-9 sermon-right-box-mobile">

                                <div class="col-xs-12 sermon-box-data">
                                    <p>{{$sermon->title}}
                                    <br>
                                    <strong class="blue-text"> on: &nbsp; </strong>
                                    {{ $sermon->datepreached}}
                                    </p>

                                    <form method="POST" action="{{ route('favouriteDownload', [ $sermon->slug]) }}">
                                    {{ csrf_field() }}
                                        <button id="download-button" class="btn btn-sm btn-black">Download</button>
                                    </form>

                                    <form method="POST" action="{{ route('favouriteRemove', [ $sermon->slug]) }}">
                                        {{ csrf_field() }}
                                        <button id="favourite-button" class="btn btn-sm btn-primary-new">Favourite</button>
                                    </form>

                                </div>

                            </div>

                            <div class="col-xs-8 sermon-right-box-mobile2">

                                <div class="col-xs-12 sermon-box-data">
                                    <p>{{$sermon->title}}
                                    <br>
                                    <strong class="blue-text"> on: &nbsp; </strong>
                                    {{ $sermon->datepreached}}
                                    </p>
                                    
                                    <form method="POST" action="{{ route('favouriteDownload', [ $sermon->slug]) }}">
                                    {{ csrf_field() }}
                                        <button id="download-button" class="btn btn-sm btn-black">Download</button>
                                    </form>

                                    <form method="POST" action="{{ route('favouriteRemove', [ $sermon->slug]) }}">
                                        {{ csrf_field() }}
                                        <button id="favourite-button" class="btn btn-sm btn-primary-new">Favourite</button>
                                    </form>

                                </div>
                                
                            </div>

                            {{-- for 320px screens --}}
                            <div class="col-xs-7 sermon-right-box-mobile3">

                                <div class="col-xs-12 sermon-box-data">
                                    
                                    <p>{{$sermon->title}}
                                    <br>
                                    <strong class="blue-text"> on: &nbsp; </strong>
                                    {{ $sermon->datepreached}}
                                    </p>
                                    
                                    <form method="POST" action="{{ route('favouriteDownload', [ $sermon->slug]) }}">
                                    {{ csrf_field() }}
                                        <button id="download-button" class="btn btn-sm btn-black">Download</button>
                                    </form>

                                    {{-- <button id="favourite-button" class="btn btn-sm btn-primary-new">Favourite</button> --}}

                                    <form method="POST" action="{{ route('favouriteRemove', [ $sermon->slug]) }}">
                                        {{ csrf_field() }}
                                        <button id="favourite-button" class="btn btn-sm btn-primary-new">Favourite</button>
                                    </form>

                                </div>
                                
                            </div>
                            {{--  end --}}

                            <div class="col-xs-10 sermon-right-box">

                                <div class="col-xs-6 sermon-box-data">
                                    
                                    <p>{{$sermon->title}}
                                    <br>
                                    <strong class="blue-text"> by: &nbsp; </strong> {{$sermon->preacher}}
                                    <br>
                                    <strong class="blue-text"> on: &nbsp; </strong> {{ $sermon->datepreached}}
                                    </p>
                                </div>

                                <div class="col-xs-3 sermon-box-status">
                                    <p class="blue-text"><strong> {{$sermon->status}}</strong> </p>
                                </div>

                                <div class="col-xs-3 sermon-btns">
                                    
                                    <form method="POST" action="{{ route('favouriteDownload', [ $sermon->slug]) }}">
                                    {{ csrf_field() }}
                                        <button id="download-button" class="btn btn-black pull-right">Download Sermon</button>
                                    </form>

                                    {{-- <a href="{{ route('favouriteDownload', [ $sermon->slug]) }}"> --}}
                                    {{-- </a> --}}

                                    <br>
                                    
                                    <form method="POST" action="{{ route('favouriteRemove', [ $sermon->slug]) }}">
                                    {{ csrf_field() }}
                                        <button id="favourite-button" class="btn btn-primary-new pull-right">Remove Favourite</button>
                                    </form>

                                </div>

                            </div>

                    </div>

                @endforeach

                <div class="pagination">
                    {{-- {{ $sermons->links() }} --}}
                </div>
                
            </div>


        </div>
            

    </div>




@endsection