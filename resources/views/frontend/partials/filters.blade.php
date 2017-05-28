<button id="mobile-filter" type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#filterModal">F i l t e r</button>

<div class="modal filter" id="filterModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            
            <div class="modal-header">
                <button type="button" class="close btn btn-link" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close fa-lg" style="color:#999;"></i></button> 
                <h4 class="modal-title text-center"><span class="sr-only">main navigation</span></h4>
            </div>
            <div class="modal-body">

                {{-- main filter content --}}
                <div class="container">
                        
                    <p><strong>Browse by: </strong></p>
                    <hr>
                    
                    <a href="#" class="filters">
                        <h4> All </h4> 
                    </a>

                    <hr>

                    <h4 class="filters" data-toggle="collapse" data-target="#topicss" @click.prevent="turnFilter">
                        Categories
                        <a uk-icon="icon: triangle-right; ratio: 1.2" class="pull-right" v-show="!filterParams"></a>
                        <a uk-icon="icon: triangle-down; ratio: 1.2" class="pull-right" v-show="filterParams"></a>
                    </h4>
                    <div id="topicss" class="collapse uk-list">
                        @foreach ($categories as $category)
                            <li class="filter-lists">
                                <a href="{{ route('category', [ $category->slug]) }}">{{$category->name}}</a>
                            </li>
                        @endforeach
                    </div>

                    <hr>

                    <h4 class="filters" data-toggle="collapse" data-target="#servicess" @click.prevent="toggleServices">
                        Services
                        <a uk-icon="icon: triangle-right; ratio: 1.2" class="pull-right" v-show="!services"></a>
                        <a uk-icon="icon: triangle-down; ratio: 1.2" class="pull-right" v-show="services"></a>
                    </h4>
                    <div id="servicess" class="collapse uk-list">
                        @foreach ($services as $service)
                            <li class="filter-lists">
                                <a href="{{ route('service', [ $service->slug]) }}">{{$service->name}}</a>
                            </li>
                        @endforeach
                    </div>


                </div>

                
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.fullscreen -->