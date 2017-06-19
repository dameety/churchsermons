<template>
    <main class="main">

        <div class="breadcrumb">

            <li class="breadcrumb-item"><span class="uk-badge"> &nbsp; Total Services: {{servicesCount}} &nbsp; </span></li>
            <li> &nbsp; <button class="newButton breadcrumb-item uk-button uk-button-primary uk-button-small" href="#newServiceForm" uk-scroll @click="newServiceForm = true">Add New Service</button></li>

            <li id="pagination" class="breadcrumb-menu hidden-md-down">
                  <button class="btn btn-default btn-sm" @click="fetchServices(pagination.prev_page_url)"
                          :disabled="!pagination.prev_page_url">
                      Previous
                  </button> &nbsp;
                  <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp;
                  <button class="btn btn-default btn-sm" @click="fetchServices(pagination.next_page_url)"
                          :disabled="!pagination.next_page_url">Next
                  </button>
            </li>
        </div>


        <div class="container-fluid">
            <div class="animated fadeIn">

                <!-- <div class="row"> -->

                    <!-- start of new service form -->
                    <div id="newServiceForm" class="col-lg-12 uk-animation-slide-top-medium" v-show="newServiceForm">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-edit"></i>  Fill in the new service details
                                <div class="card-actions">
                                    <a style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" @click="newServiceForm = false"></a>
                                </div>
                            </div>
                            <div class="card-block">
                                <form @submit.prevent="addNewService">
                                    <div class="form-group">
                                        <label for="Name">Name</label>
                                        <input type="text" v-model="newService.name" name="name" required="required" maxlength="30" class="form-control">
                                        <span v-if="formErrors['name']" class="inputError">{{ formErrors.name }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea type="text" v-model="newService.description" name="description" maxlength="300" class="form-control" rows="5"> </textarea>
                                        <span v-if="formErrors['description']" class="inputError">{{ formErrors.description }}</span>
                                    </div>
                                    <br>
                                    <div class="uk-modal-footer uk-text-right">
                                        <button type="submit" class="btn btn-block btn-primary">Create Service</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end of new service form -->


                    <!-- search input -->
                    <div class="card-block" v-show="!newServiceForm">
                        <div id="searchForm" class="col-lg-12 uk-animation-slide-top-medium">
                            <div class="card">
                                <div class="card-header">
                                   <input type="text" v-model="searchWord" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- search input -->


                    <!-- ALL THE SERVICES -->
                    <div class="row">

                        <!-- all services cards -->
                        <div class="col-sm-6 col-md-4 uk-animation-slide-bottom-medium" v-for="service in filterBy(services, searchWord)" v-show="!newServiceForm">
                            <div class="card uk-card uk-card-default uk-card-hover">
                                <div class="card-block">
                                    <strong class="serviceName"> Name:</strong> &nbsp;{{ service.name }}
                                    <span class="badge badge-pill badge-danger float-right" title="This is the total number of sermons in this service" uk-tooltip>{{ service.sermonCount }}</span>
                                    <hr>
                                    <p> <strong class="serviceDescription">Description:</strong> &nbsp;{{ service.description }}</p>
                                </div>
                                <div class="uk-container card-header">
                                    <a uk-icon="icon: pencil; ratio: 1.2" href="#editServiceModal" uk-toggle @click.prevent="editService(service)"></a>
                                    &nbsp; &nbsp;
                                    <a style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" @click.prevent="deleteService(service)"></a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- All SERVICES CARDS -->


                    <!-- bottom pagination -->
                    <div class="card-block uk-animation-slide-top-medium" v-show="!newServiceForm">
                        <div class="card">
                            <div class="card-header">
                                <div class="paginationn float-right">
                                    <button class="btn btn-default btn-sm" @click="fetchServices(pagination.prev_page_url)"
                                          :disabled="!pagination.prev_page_url">
                                      Previous
                                    </button> &nbsp;
                                    <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp;
                                    <button class="btn btn-default btn-sm" @click="fetchServices(pagination.next_page_url)"
                                          :disabled="!pagination.next_page_url">Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- bottom pagination -->


                    <!-- the edit modal -->
                    <div id="editServiceModal" uk-modal>
                        <div class="uk-modal-dialog">
                            <button class="uk-modal-close-outside" type="button" uk-close></button>
                            <div class="uk-modal-header">
                                <h2 class="uk-modal-title">Edit Service</h2>
                            </div>
                            <div class="uk-modal-body">
                                <div class="card-block">
                                    <form method="post" @submit.prevent="updateService(serviceToBeUpdated.slug)">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" v-model="serviceToBeUpdated.name" required="required" maxlength="15" name="name" class="form-control">
                                            <span v-if="formErrors['name']" class="inputError">{{ formErrors['name'] }}</span>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea type="text" v-model="serviceToBeUpdated.description" maxlength="200" name="description" class="form-control" rows="5"> </textarea>
                                            <span v-if="formErrors['description']" class="inputError">{{ formErrors['description'] }}</span>
                                        </div>
                                        <br>
                                        <div class="uk-modal-footer uk-text-right">
                                            <button type="submit" class="btn btn-block btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- edit modal ends here -->

                <!-- </div> -->

            </div>
        </div>

    </main>
</template>

<script>

    export default {

        data: function() {

            return {
                services: [],
                pagination: {},
                searchWord: "",
                servicesCount: "",
                newService: {
                    name: "",
                    description: ""
                },
                formErrors: {},
                serviceToBeUpdated: {},
                newServiceForm: false,

            };
        },

        mounted() {
            this.fetchServices();
            this.fetchServicesCount();
        },

        methods: {

            fetchServicesCount: function () {
                this.$http.get('/admin/service/api/count').then((response) => {
                    this.servicesCount = response.data;
                });
            },


            fetchServices: function (page_url) {

                let vm = this;
                page_url = page_url || '/admin/service/api'
                this.$http.get(page_url)
                  .then(function (response) {
                    vm.makePagination(response.data)
                    vm.services = response.data.data;
                  });

            },

            makePagination: function(data) {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    total: data.total
                }
                this.pagination = pagination;
            },


            addNewService: function () {

                var service = this.newService
                this.newService = { name: "", description: "" }
                this.$http.post('/admin/service/api/new', service)
                    .then((response) => {

                        this.fetchServices();
                        this.fetchServicesCount();
                        this.$swal({
                            title: 'Great!',
                            text: 'New Service Creation Successful',
                            type: 'success',
                            timer: 1500,
                        })

                    }).catch( errors => {
                        this.formErrors = errors.response.data;
                    });

            },

            editService: function(service) {
                this.serviceToBeUpdated = service;
            },

            updateService: function (slug) {

                var services = this.serviceToBeUpdated
                this.$http.patch('/admin/service/api/update/' + slug, services).then((response) => {
                    this.fetchServices();
                    this.$swal({
                        title: 'Great!',
                        text: 'Service Update Successful',
                        type: 'success',
                        timer: 1500,
                    })
                }).catch( errors => {
                    this.formErrors = errors.response.data;
                });

            },

            deleteService: function(service) {
                var vm = this;
                this.$swal({
                    title: 'Are you sure?',
                    text: 'This service will be deleted if you continue',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, don't!",

                }).then(function() {
                    vm.$http.delete('/admin/service/api/delete/' + service.name).then((response) => {
                        vm.fetchServices();
                        vm.fetchServicesCount();
                    });
                });

            },

        }


    }
</script>

<style>
    /*  style the add new service and category button
        this will work for the components even thought its only here
    */
    .newButton {
        border-radius: 20px;
        margin-left: 10px;
    }

    .serviceName {
        color: #263238;
    }

    .serviceDescription {
        color: #20A8D8;
    }

</style>