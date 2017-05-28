<template>
	<main class="main">

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
        </div>

        <div class="container-fluid">

            <div class="animated fadeIn">

                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-inverse card-primary">
                            <div class="card-block pb-0">
                                <h4 class="mb-0">{{ sermonsCount }}</h4>
                                <p>Sermons</p>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->

                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-inverse card-info">
                            <div class="card-block pb-0">
                                <h4 class="mb-0">{{ servicesCount }}</h4>
                                <p>Services</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-inverse card-danger">
                            <div class="card-block pb-0">
                                <h4 class="mb-0">{{ categoriesCount }}</h4>
                                <p>Categories</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-inverse card-danger">
                            <div class="card-block pb-0">
                                <h4 class="mb-0">{{ usersCount }}</h4>
                                <p>Users</p>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->
                </div>
                <!--/.row-->
                
            </div>
        </div>
        
    </main>
</template>

<script>
	export default {

		data () {

            return {

            	sermonsCount: "",
            	servicesCount: "",
            	categoriesCount: "",
            	usersCount: "",

            }

        },

        mounted () {
            this.fetchUsersCount();
            this.fetchSermonsCount();
            this.fetchCategoriesCount();
            this.fetchServicesCount();
        },

        methods: {
        	
        	fetchUsersCount () {
                this.$http.get('/admin/user/api/count').then((response) => {
                    this.usersCount = response.data;
                }).catch( error => { console.log(error); });
            },

            fetchSermonsCount () {
                this.$http.get('/admin/sermon/api/count').then((response) => {
                    this.sermonsCount = response.data;
                }).catch( error => { console.log(error); });
            },

            fetchCategoriesCount () {
                this.$http.get('/admin/category/api/count').then((response) => {
                    this.categoriesCount = response.data;
                }).catch( error => { console.log(error); });
            },

            fetchServicesCount () {
                this.$http.get('/admin/service/api/count').then((response) => {
                    this.servicesCount = response.data;
                }).catch( error => { console.log(error); });
            },

        },


	}
</script>

<style>
	
</style>