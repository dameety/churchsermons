<div class="panel sermon-box">
        
        <div class="col-xs-2 sermon-box-art">
            {{-- <img class="img-fluid sermon-art" src="/img/otherimage.jpg" alt="sermon art"> --}}
            <img class="img-fluid sermon-art" src="{{ ($sermon->imageurl) }}" alt="sermon art">
        </div> 

        {{--  this one is for mobile view --}}
        <div class="col-xs-9 sermon-right-box-mobile">

            <div class="col-xs-12 sermon-box-data">
                <p>{{$sermon->title}}
                <br>
                <strong class="blue-text"> on: &nbsp; </strong>
                {{ $sermon->datepreached}}
                </p>

                <form method="POST" action="{{ route('download', [ $sermon->slug]) }}">
                {{ csrf_field() }}
                    <button id="download-button" class="btn btn-sm btn-black">Download</button>
                </form>

                <form method="POST" action="{{ route('favourite', [ $sermon->slug]) }}">
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

                <form method="POST" action="{{ route('download', [ $sermon->slug]) }}">
                {{ csrf_field() }}
                    <button id="download-button" class="btn btn-sm btn-black">Download</button>
                </form>

                <form method="POST" action="{{ route('favourite', [ $sermon->slug]) }}">
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
        
                <form method="POST" action="{{ route('download', [ $sermon->slug]) }}">
                {{ csrf_field() }}
                    <button id="download-button" class="btn btn-black btn-sm">Download</button>
                </form>

                <form method="POST" action="{{ route('favourite', [ $sermon->slug]) }}">
                {{ csrf_field() }}
                    <button id="favourite-button" class="btn btn-primary-new btn-sm">Favourite</button>
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
                <form method="POST" action="{{ route('download', [ $sermon->slug]) }}">
                {{ csrf_field() }}
                    <button id="download-button" class="btn btn-black pull-right">Download Sermon</button>
                </form>

                <br>
                
                <form method="POST" action="{{ route('favourite', [ $sermon->slug]) }}">
                {{ csrf_field() }}
                    <button id="favourite-button" class="btn btn-primary-new pull-right">Add To &nbsp;Favourites</button>
                </form>
            </div>

        </div>

</div>