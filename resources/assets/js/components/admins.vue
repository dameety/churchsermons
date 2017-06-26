<template>
	<main class="main">


        <div class="breadcrumb">

            <li><span class="breadcrumb-item uk-badge"> &nbsp; TOTAL ADMINS: {{admins.length}} &nbsp;</span></li>
            <li> <button class="newButton breadcrumb-item uk-button uk-button-primary uk-button-small" @click="newAdminForm = true">Add New Admin</button></li>

            <!-- right top pagination-->
            <li id="pagination" class="breadcrumb-menu hidden-md-down">
                <button class="btn btn-default btn-sm" @click="fetchAdmins(pagination.prev_page_url)"
                        :disabled="!pagination.prev_page_url">
                    Previous
                </button> &nbsp;
                <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp;
                <button class="btn btn-default btn-sm" @click="fetchAdmins(pagination.next_page_url)"
                        :disabled="!pagination.next_page_url">Next
                </button>
            </li>
        </div>


        <div class="container-fluid">
            <div class="animated fadeIn">

        		<!-- new admin form -->
                <div id="newAdminForm" class="col-lg-12 uk-animation-slide-top-medium" v-show="newAdminForm">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-edit"></i>  Please fill in the new admin details below

                            <div class="card-actions">
                                <a class="pull-right" style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" @click="newAdminForm = false"></a>
                            </div>
                        </div>
                        <div class="card-block">
                            <form @submit.prevent="saveNewAdmin">
                                <div class="form-group">
                                    <label for="Name">Name</label>
                                    <input type="text" v-model="newAdmin.name" name="name" required="required" maxlength="30" class="form-control">
                                    <span v-if="formErrors['name']" class="inputError">{{ formErrors['name'] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="email" v-model="newAdmin.email" name="email" required="required" maxlength="50" class="form-control">
                                    <span v-if="formErrors['email']" class="inputError">{{ formErrors.email }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="Permission">Permission</label>
                                    <select v-model="newAdmin.permission" name="permission" class="form-control">
                                        <option>Standard Admin</option>
                                        <option>Super Admin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Password">Password</label>
                                    <input type="password" v-model="newAdmin.password" name="password" required="required" minlength="8" class="form-control">
                                    <span v-if="formErrors['password']" class="inputError">{{ formErrors.password }}</span>
                                </div>
                                <br>
                                <div class="uk-modal-footer uk-text-right">
                                    <button type="submit" class="btn btn-block btn-primary">Create Admin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end of new admin form -->


                <!-- search inputs -->
                <div class="card-block" v-show="!newAdminForm">
                    <div id="searchForm" class="col-lg-12 uk-animation-slide-top-medium">
                        <div class="card">
                            <div class="row card-header">
                                <div class="col-sm-5">
                                    <label for="Filter by Admin Type">Filter by Admin Type</label>
                                    <select class="form-control input-sm" v-model="adminTypeSelected" @change="adminTypeFilter(adminTypeSelected)">
                                        <option>Standard Admin</option>
                                        <option>Super Admin</option>
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    <label for="Search">Search</label>
                                    <input type="text" class="form-control input-sm" v-model="searchWord">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- search inputs -->


                <!-- ALL THE ADMINS -->
                <div class="card" v-show="!newAdminForm">
                    <div class="card-header">
                    </div>
                	<div class="card-block">
                        <table class="table">
                            <thead>
                                <tr class="card-header uk-card uk-card-default uk-card-hover">
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Permission</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody v-for="admin in filterBy(admins, searchWord)">
                                <tr class="uk-card uk-card-hover">
                                    <td> {{ admin.name }} </td>
                                    <td> {{ admin.email }} </td>
                                    <td>
                                        {{ admin.permission }}
                                    </td>
                                    <td>
                                        <div class="pull-right">

                                            <a uk-icon="icon: info; ratio: 1.2" title="View Admin Details" uk-tooltip href="#adminDetailsModal" uk-toggle @click.prevent="adminDetails(admin)"></a>

                                            <a uk-icon="icon: refresh; ratio: 1.2" title="Change Admin Password" uk-tooltip href="#changePasswordModal" uk-toggle @click.prevent="showChangePasswordModal(admin)"></a>

                                            <a style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" title="Delete Admin" uk-tooltip @click.prevent="deleteAdmin(admin)"></a>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header">
                        <div class="pagination pull-right">
                            <button class="btn btn-default btn-sm" @click="fetchAdmins(pagination.prev_page_url)"
                                    :disabled="!pagination.prev_page_url">
                                Previous
                            </button> &nbsp;
                            <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp;
                            <button class="btn btn-default btn-sm" @click="fetchAdmins(pagination.next_page_url)"
                                    :disabled="!pagination.next_page_url">Next
                            </button>
                        </div>
                    </div>
                </div>
                <!-- END OF ALL SERMONS -->


                <!-- admin details modal -->
                <div id="adminDetailsModal" uk-modal>
                    <div class="uk-modal-dialog">
                        <button class="uk-modal-close-outside" type="button" uk-close></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">Admin Details</h2>
                        </div>
                        <div class="uk-modal-body" uk-overflow-auto>

                            <div class="row modalRowTop">
                                <div class="col-md-4">
                                    <strong class="pull-right">Name:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneAdmin.name }}
                                </div>
                            </div>
                            <div class="row modalRowColored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Email:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneAdmin.email }}
                                </div>
                            </div>
                            <div class="row modalRowUncolored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Joined:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneAdmin.created_at }}
                                </div>
                            </div>
                            <div class="row modalRowColored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Permission:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneAdmin.permission }}
                                    &nbsp;&nbsp;&nbsp;
                                    <label class="switch switch-default switch-pill switch-primary pull-right">
                                        <!-- <input type="checkbox" class="switch-input" checked=""> -->
                                        <input type="checkbox" class="switch-input" checked="">
                                        <span class="switch-label"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row modalRowUncolored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Last Login Date:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneAdmin.lastLoginDate }}
                                </div>
                            </div>
                            <div class="row modalRowColored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Download Count:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneAdmin.downloadCount }}
                                </div>
                            </div>
                            <div class="row modalRowUncolored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Last Downloaded:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneAdmin.lastSermonDownloaded }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- user details modal -->


                <!-- change password modal -->
                <div id="changePasswordModal" uk-modal>
                    <div class="uk-modal-dialog">
                        <button class="uk-modal-close-outside" type="button" uk-close></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">Change Admin Password</h2>
                        </div>
                        <div class="uk-modal-body">
                            <form method="post" @submit.prevent="changePassword(adminPasswordToChange.slug)">
                                <div class="form-group">
                                    <label for="Enter New Password">Enter New Password</label>
                                    <input type="password" v-model="adminPasswordToChange.password" name="password" required="required" minlength="8" class="form-control">
                                    <span v-if="formErrors['password']" class="inputError">{{ formErrors['password'] }}</span>
                                </div>
                                <br>
                                <div class="uk-modal-footer uk-text-right">
                                    <button type="submit" class="btn btn-block btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end of change password modal -->

            </div>
        </div>


    </main>
</template>

<script>
	export default {

		data: function() {
            return {

                // toggleButton:
                currentAdminPermission: "",
                admins: [],
                oneAdmin: {},
                pagination: {},
                searchWord: "",
                adminsCount: "",
                formErrors: {},
                adminPasswordToChange: {},
                newAdmin: {
                    name: "",
                    email: "",
                    permission: "",
                    password: ""
                },
                newAdminForm: false,
                adminTypeSelected: "",
                filterWord: ""
            };
        },

        mounted: function () {
            this.fetchAdmins();         // saves to admins:[]
            this.fetchAdminsCount();
            this.fetchCurrentAdmin();
        },

        computed: {
            adminPermission () {
                if( oneAdmin.permission === "Standard Admin") {
                    return null;
                } else {
                    return "check=''";
                }
            }
        },

        methods: {

            fetchCurrentAdmin: function () {
                this.$http.get('/admin/admin/api/current').then((response) => {
                    this.currentAdminPermission = response.data;
                });

            },

            fetchAdminsCount: function () {
                this.$http.get('/admin/admin/api/count').then((response) => {
                    this.adminsCount = response.data;
                });
            },

        	fetchAdmins: function (page_url) {
                let vm = this;
                page_url = page_url || '/admin/admin/api'
                this.$http.get(page_url).then((response) => {
                    vm.makePagination(response.data)
                    vm.admins = response.data.data;
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

            saveNewAdmin: function () {
                if(this.currentAdminPermission === "Standard Admin") {
                    this.$swal({
                        title: 'Error',
                        text: 'Only the super admin can perform this action.',
                        type: 'error',
                        timer: 1500,
                    })
                    return;

                } else {

                    var admin = this.newAdmin
                    this.newAdmin = {name: "", email: "", permission: "", password: ""}
                    this.$http.post('/admin/admin/api/new', admin).then((response) => {

                        this.fetchAdmins()
                        this.fetchAdminsCount()
                        this.$swal({
                            title: 'Great!',
                            text: 'New admin creation successful.',
                            type: 'success',
                            timer: 1500,
                        })

                    }).catch(errors => {
                        this.formErrors = errors.response.body;
                    });
                }

            },

            adminDetails: function(admin) {
                this.oneAdmin = admin;
            },

            adminTypeFilter: function (adminTypeSelected) {
                var type = adminTypeSelected;
                this.$http.get('/admin/admin/api/type/' + type).then((response) => {
                    this.admins = response.body;
                    this.filterWord = userTypeSelected;
                });
            },

            showChangePasswordModal: function (admin) {
                this.adminPasswordToChange = admin;
            },

            changePassword: function (slug) {
                if(this.currentAdminPermission !== "Super Admin") {
                    this.$swal({
                        title: 'Error',
                        text: 'Only the super admin can perform this action.',
                        type: 'error',
                        timer: 1500
                    })
                    return;

                } else {
                    var newPassword = this.adminPasswordToChange
                    this.$http.patch('/admin/admin/api/password/change/' + slug, newPassword).then((response) => {
                            this.fetchAdmins()
                            this.$swal({
                                title: 'Great!',
                                text: 'Password change was successful',
                                type: 'success',
                                timer: 1500,
                            })
                    }).catch (errors => {
                        this.formErrors = errors.response.data;
                    });
                }

            },

            deleteAdmin: function(admin) {
                if(this.currentAdminPermission !== "Super Admin") {
                    this.$swal({
                        title: 'Error',
                        text: 'Only the super admin can perform this action.',
                        type: 'error',
                        timer: 1500
                    })
                    return;

                } else {
                    var vm = this;
                    this.$swal({

                        title: 'Are you sure?',
                        text: 'This admin will be deleted if you continue',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete admin!",
                        cancelButtonText: "No, don't!",

                    }).then((response) => {
                        vm.$http.delete('/admin/admin/api/delete/' + admin.slug).then((response) => {
                            vm.fetchAdmins();
                            vm.fetchAdminsCount();
                        });

                    });

                }

            },

        }

	}
</script>

<style>
    .inputError {
        color: red;
    }
</style>