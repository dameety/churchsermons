<div class="col-sm-2 filter-box">
    
    <p><strong>Browse by: </strong></p>
    <hr>
    <h4 class="filters" data-toggle="collapse" data-target="#topics" @click.prevent="turnFilter">
        Categories
        <a uk-icon="icon: triangle-right; ratio: 1.2" class="pull-right" v-show="!filterParams"></a>
        <a uk-icon="icon: triangle-down; ratio: 1.2" class="pull-right" v-show="filterParams"></a>
    </h4>
    <div id="topics" class="collapse uk-list">
        @foreach ($categories as $category)
            <li class="filter-lists">
                <a href="{{ route('category', [ $category->slug]) }}">{{$category->name}}</a>
            </li>
        @endforeach
    </div>

    <hr>

    <h4 class="filters" data-toggle="collapse" data-target="#services" @click.prevent="toggleServices">
        Services
        <a uk-icon="icon: triangle-right; ratio: 1.2" class="pull-right" v-show="!services"></a>
        <a uk-icon="icon: triangle-down; ratio: 1.2" class="pull-right" v-show="services"></a>
    </h4>
    <div id="services" class="collapse uk-list">
        @foreach ($services as $service)
            <li class="filter-lists">
                <a href="{{ route('service', [ $service->slug]) }}">{{$service->name}}</a>
            </li>
        @endforeach
    </div>

</div>