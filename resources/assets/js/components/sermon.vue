<template>
    <main class="main">

        <div class="breadcrumb">
            <li><span class="breadcrumb-item uk-badge"> &nbsp; Total Sermons: {{sermonsCount}} &nbsp;</span></li>

            <!-- Breadcrumb Menu-->
            <li id="pagination" class="breadcrumb-menu" v-if="sermons != '' ">   
                  <button class="btn btn-default btn-sm" @click="fetchSermons(pagination.prev_page_url)"
                          :disabled="!pagination.prev_page_url">
                      Previous
                  </button> &nbsp; 
                  <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp; 
                  <button class="btn btn-default btn-sm" @click="fetchSermons(pagination.next_page_url)"
                          :disabled="!pagination.next_page_url">Next
                  </button>
            </li>
        </div>


        <div class="container-fluid">
            <div class="animated fadeIn">

                    <!-- filter and search inputs -->
                    <div class="card-block">
                        <div id="searchForm" class="col-lg-12 uk-animation-slide-top-medium">
                            <div class="card">    
                                <div class="row card-header">
                                    <div class="col-sm-3">
                                        <label for="Service">Filter by Service</label> 
                                        <select class="form-control input-sm" v-model="serviceSelected" @change="serviceSermonsFilter(serviceSelected)">
                                            <option v-for="service in services">
                                                {{ service.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="Category">Filter by Category</label> 
                                        <select class="form-control input-sm" v-model="categorySelected" @change="categorySermonsFilter(categorySelected)">
                                            <option v-for="category in categories">
                                                {{ category.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="Search">Search</label> 
                                        <input type="text" class="form-control input-sm" v-model="searchWord">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- filter and search inputs -->



                    <!-- search result notification -->
                    <div class="card-block">
                        <div class="col-lg-12 uk-alert-success uk-animation-slide-top-medium" uk-alert v-show="filterWord != '' ">
                            <a class="uk-alert-close" uk-close @click.prevent="closefilterResult"></a>
                            Showing Results for: &nbsp; <strong> {{ filterWord }} </strong>
                        </div>
                    </div>
                    <!-- search result notification end -->



                    <!-- all sermons -->
                    <div class="card-block" v-show="sermons != ''">
                        <div class="card">
                            <table class="table table-hover table-outline mb-0">
                                <thead class="thead-default">
                                    <tr>
                                        <th> </th>
                                        <th>Date Preached</th>
                                        <th>Preacher</th>
                                        <th>Title</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody v-for="sermon in filterBy(sermons, searchWord)">
                                    <tr>
                                        <td>
                                            <div class="avatar">
                                                <img src="/img/audioImage.png" class="img-avatar" alt="sermon audio logo">
                                            </div>
                                        </td>
                                        <td>{{ sermon.datepreached }}</td>
                                        <td> {{ sermon.preacher }}</td>
                                        <td> {{ sermon.title }}</td>
                                        <td>
                                            <div class="pull-right">
                                                <a uk-icon="icon: pencil; ratio: 1.2" :href="editSermon(sermon)"></a>

                                                <a id="info" uk-icon="icon: info; ratio: 1.2" title="View Sermon Details" uk-tooltip href="#sermonDetailsModal" uk-toggle @click.prevent="sermonDetails(sermon)"></a>

                                                <a id="downloadloadload" uk-icon="icon: download; ratio: 1.2" title="Download Sermon" uk-tooltip @click.prevent="downloadSermon(sermon.slug)"></a>

                                                <a style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" title="Delete Sermon" uk-tooltip @click.prevent="deleteSermon(sermon)"></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- all sermons end -->



                    <!-- bottom pagination -->
                    <div class="card-block" v-show="sermons != ''">
                        <div class="col-lg-12 uk-animation-slide-top-medium">
                            <div class="card">    
                                <div class="card-header">
                                    <div class="paginationn float-right">
                                        <button class="btn btn-default btn-sm" @click="fetchSermons(pagination.prev_page_url)"
                                                  :disabled="!pagination.prev_page_url">
                                              Previous
                                          </button> &nbsp; 
                                          <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp; 
                                          <button class="btn btn-default btn-sm" @click="fetchSermons(pagination.next_page_url)"
                                                  :disabled="!pagination.next_page_url">Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- bottom pagination end -->


                    <!-- sermon details modal -->
                    <div id="sermonDetailsModal" uk-modal>
                        <div class="uk-modal-dialog">
                            <button class="uk-modal-close-outside" type="button" uk-close></button>
                            <div class="uk-modal-header">
                                <h2 class="uk-modal-title">Sermon Details</h2>
                            </div>
                            <div class="uk-modal-body" uk-overflow-auto>
                                
                                <div class="row modalRowTop">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Title:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.title }}
                                    </div>
                                </div>
                                <div class="row modalRowColored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Date Preached:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.datepreached }}
                                    </div>
                                </div>
                                <div class="row modalRowUncolored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Preacher:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.preacher }}
                                    </div>
                                </div>

                                <div class="row modalRowColored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Category:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ sermonCategory.name }}
                                    </div>
                                </div>
                                <div class="row modalRowUncolored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Service:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ sermonService.name }}
                                    </div>
                                </div>
                                <div class="row modalRowColored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Upload Date:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.created_at }}
                                    </div>
                                </div>
                                <div class="row modalRowUncolored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">File Size / Type:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.size }} / {{ oneSermonDetail.type }}
                                    </div>
                                </div>
                                <div class="row modalRowColored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Status:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.status }}
                                    </div>
                                </div>
                                 <div class="row modalRowUncolored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Download Count:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.downloadCount }}
                                    </div>
                                </div>
                                <div class="row modalRowColored">
                                    <div class="col-md-4">
                                        <strong class="pull-right"> Last Download at:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.lastDownloadTime }}
                                    </div>
                                </div>
                                <div class="row modalRowColored">
                                    <div class="col-md-4">
                                        <strong class="pull-right">Last Download by:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ oneSermonDetail.lastDownloadBy}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

            </div>
        </div>


    </main>
</template>

<script>

    export default {
        
        data: function() {

            return {

                sermons: [],            /*using the fetchSermons()*/
                pagination: {},
                sermonsCount: "",

                categories: [],         /*usedin the edit and details function*/
                services: [],           /*used in the edit and details function*/
                // categorySelected: [],   using the sermons filter
                oneSermon: {},
                oneSermonCategory: {},
                oneSermonService: {},
                // formErrors: {},
                
                oneSermonDetail: {},         // gotten from the sermonDetails function
                sermonCategory: {},         //gotten from the sermonDetails function
                sermonService: {},          //gotten from the sermonDetails function 

                // data for the filter and search inputs
                serviceSelected: "",
                categorySelected: "",
                searchWord: "", 

                filterWord: "",


            }
        }, 
 

        mounted: function () {
            this.fetchSermons();        //saved in the sermons: []
            this.fetchCategories();     //saved in the  categories: []
            this.fetchServices();       //saved in the services: []
            this.fetchSermonsCount();
        },
  
        methods: {

            fetchSermonsCount: function () {
                this.$http.get('/admin/sermon/api/count').then((response) => {
                      this.sermonsCount = response.data;
                  });
            },

            fetchSermons: function (page_url) {

                let vm = this;
                page_url = page_url || '/admin/sermon/api'
                this.$http.get(page_url).then((response)=> {
                        vm.makePagination(response.data)
                        vm.sermons = response.data.data;
                    });

            },

            makePagination: function(data){

                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    total: data.total
                }
                this.pagination = pagination;

            },

            editSermon: function (sermon) {
                return `/admin/sermon/${sermon.slug}/edit`;
            }, 
            
            
            deleteSermon: function(sermon) {
                const vm = this;
                this.$swal({
                    title: 'Are you sure?',
                    text: 'This sermon will be deleted if you continue',
                    type: 'warning',
                    showCancelButton: true,
                }).then(function() {
                    vm.$http.delete('/admin/sermon/api/delete/' + sermon.slug).then((response) => {

                        let index = vm.sermons.indexOf(sermon); 
                        vm.$delete(vm.sermons, index);
                        vm.sermonCount = vm.semonCount - 1;
                        
                    });

                });

            },

            sermonDetails: function (sermon) {

                this.oneSermonDetail = sermon;
                this.$http.get('/admin/sermon/api/sermoncategory/' + sermon.slug)
                    .then(function (response) {                        
                        this.sermonCategory = response.body;
                    });
                this.$http.get('/admin/sermon/api/sermonservice/' + sermon.slug)
                    .then(function (response) {                        
                        this.sermonService = response.body;
                    }); 

            },

            fetchCategories: function () {
                this.$http.get('/admin/sermon/api/category').then((response) => {
                    this.categories = response.body;
                });
            },

            fetchServices: function () {
                this.$http.get('/admin/sermon/api/service').then((response) => {
                        this.services = response.body;
                    });
            },

            serviceSermonsFilter: function (serviceSelected) {
                this.$http.get('/admin/sermon/api/service/' + serviceSelected).then((response) => {
                    this.sermons = response.body;
                    this.filterWord = serviceSelected;
                });

            },

            categorySermonsFilter (categorySelected) {
                this.$http.get('/admin/sermon/api/category/' + categorySelected).then((response) => {
                    this.sermons = response.body;
                    this.filterWord = categorySelected;
                });
            },

            downloadSermon: function(slug) {
                window.location.href = '/admin/sermon/download/' + slug;
                this.fetchSermons();
            },

            closefilterResult: function () {
                location.reload(true)
            },


        } /*methods end here*/


    } /*compoent ends here */
</script>

<style>

    #info {
        padding-left: 2px;
        padding-right: 2px;
    }

    #download {
        padding-right: 2px;
    }

    .modalRowColored {
      background-color: #EEEEEF;
      padding-top: 20px;
      padding-bottom: 20px;
    }

    .modalRowUncolored {
      padding-top: 15px;
      padding-bottom: 15px;
    }

    .modalRowTop {
      padding-bottom: 15px;
    }


    .uk-modal-header {
        background-color: #20A8D8;
        color: white;
    }

    #filterResult {
        font-color: #20A8D8;
        background-color: #20A8D8;
    }


</style>