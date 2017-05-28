@extends('frontend.layouts.master')

@section('title', 'Home')

@section('content')
        
     <link rel="stylesheet" href="{{ URL::asset('/css/frontend/home.css') }}">


    <div class="container page-heading-container">

        <div class="row page-heading-box">
            <h2 class="page-heading">

            All Sermons

            </h2>
        </div>

    </div>


    <div id="container" class="container container-mobile">
        

        <div class="row content-block">
            
            {{-- left part --}}
            @include('frontend.partials.filters-desktop')
            

            {{-- right part --}}
            <div class="col-sm-10 sermon-col">

                <div class="form-group">

                    {{-- flash messages --}}
                    @include('flash::message')
                    {{-- the filter for responsive view --}}
                    @include('frontend.partials.filters')
                

                </div>


                @foreach ($sermons as $sermon)

                    @include('frontend.partials.sermonbox')


                @endforeach

                <div class="pagination">
                    {{ $sermons->links() }}
                </div>
                
            </div>


        </div>
            

    </div>

@stop


@section('scripts');


@stop