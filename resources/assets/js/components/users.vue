<template>
    <main class="main">


        <!-- bread crumb -->
        <div class="breadcrumb">

            <li><span class="breadcrumb-item uk-badge"> &nbsp; Total Users: {{usersCount}} &nbsp;</span></li>
            <li> <button class="newButton breadcrumb-item uk-button uk-button-primary uk-button-small" @click="newUserForm = true">Add New User</button></li>

            <!-- right top pagination-->
            <li id="pagination" class="breadcrumb-menu hidden-md-down">
                <button class="btn btn-default btn-sm" @click="fetchUsers(pagination.prev_page_url)"
                        :disabled="!pagination.prev_page_url">
                    Previous
                </button> &nbsp;
                <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp;
                <button class="btn btn-default btn-sm" @click="fetchUsers(pagination.next_page_url)"
                        :disabled="!pagination.next_page_url">Next
                </button>
            </li>
        </div>
        <!-- end of bread crumb -->


        <div class="container-fluid">
            <div class="animated fadeIn">


                <!-- new user form -->
                <div id="newUserForm" class="col-lg-12 uk-animation-slide-top-medium" v-show="newUserForm">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-edit"></i>  Please fill in the new user details below
                            <div class="card-actions">
                                <a class="pull-right" style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" @click="newUserForm = false"></a>
                            </div>
                        </div>
                        <div class="card-block">
                            <form @submit.prevent="saveNewUser">
                                <div class="form-group">
                                    <label for="Name">Name</label>
                                    <input type="text" v-model="newUser.name" name="name" required="required" maxlength="30" class="form-control">
                                    <span v-if="formErrors['name']" class="inputError">{{ formErrors['name'] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="email" v-model="newUser.email" name="email" required="required" maxlength="50" class="form-control">
                                    <span v-if="formErrors['email']" class="inputError">{{ formErrors['email'] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="Permission">Permission</label>
                                    <select v-model="newUser.permission" name="permission" class="form-control">
                                        <option>Standard</option>
                                        <option>Premium</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Password">Password</label>
                                    <input type="password" v-model="newUser.password" name="password" required="required" minlength="8" class="form-control">
                                    <span v-if="formErrors['password']" class="inputError">{{ formErrors['password'] }}</span>
                                </div>
                                <br>
                                <div class="uk-modal-footer uk-text-right">
                                    <button type="submit" class="btn btn-block btn-primary">Create User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end of new usDer form -->



                <!-- search inputs -->
                <div class="card-block" v-show="!newUserForm">
                    <div id="searchForm" class="col-lg-12 uk-animation-slide-top-medium">
                        <div class="card">
                            <div class="row card-header">
                                <div class="col-sm-5">
                                    <label for="Filter by User Type">Filter by User Type</label>
                                    <select class="form-control input-sm" v-model="userTypeSelected" @change="userTypeFilter(userTypeSelected)">
                                        <option>Standard</option>
                                        <option>Premium</option>
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



                <!-- search result notification -->
                <div class="card-block">
                    <div class="col-lg-12 uk-alert-success uk-animation-slide-top-medium" uk-alert v-show="filterWord != '' ">
                        <a class="uk-alert-close" uk-close @click.prevent="closefilterResult"></a>
                        Showing Results for: &nbsp; <strong> {{ filterWord }} </strong>
                    </div>
                </div>
                <!-- search result notification end -->



                <!-- ALL THE USERS -->
                <div class="col-sm-4 col-sm-12 uk-animation-slide-bottom-medium" v-show="!newUserForm">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-block">
                            <table class="table">
                                <thead>
                                    <tr class="card-header uk-card uk-card-default uk-card-hover">
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Plan</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody v-for="user in filterBy(users, searchWord)">
                                    <tr class="uk-card uk-card-hover">
                                        <td> {{ user.name }} </td>
                                        <td> {{ user.email }} </td>
                                        <td> {{ user.permission }} </td>
                                        <td>
                                            <div class="pull-right">

                                                <a uk-icon="icon: info; ratio: 1.2" href="#userDetailsModal" uk-toggle @click.prevent="userDetails(user)"></a>

                                                <a uk-icon="icon: refresh; ratio: 1.2" href="#changePasswordModal" uk-toggle @click.prevent="showChangePasswordModal(user)"></a>

                                                <a style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" @click.prevent="deleteUser(user)"></a>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <div class="pagination pull-right">
                                <button class="btn btn-default btn-sm" @click="fetchUsers(pagination.prev_page_url)"
                                        :disabled="!pagination.prev_page_url">
                                    Previous
                                </button> &nbsp;
                                <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp;
                                <button class="btn btn-default btn-sm" @click="fetchUsers(pagination.next_page_url)"
                                        :disabled="!pagination.next_page_url">Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- user details modal -->
                <div id="userDetailsModal" uk-modal>
                    <div class="uk-modal-dialog">
                        <button class="uk-modal-close-outside" type="button" uk-close></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">User Details</h2>
                        </div>
                        <div class="uk-modal-body" uk-overflow-auto>

                            <div class="row modalRowTop">
                                <div class="col-md-4">
                                    <strong class="pull-right">Name:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneUser.name }}
                                </div>
                            </div>
                            <div class="row modalRowColored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Email:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneUser.email }}
                                </div>
                            </div>
                            <div class="row modalRowUncolored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Joined:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneUser.created_at }}
                                </div>
                            </div>
                            <div class="row modalRowColored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Plan:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneUser.permission }}
                                </div>
                            </div>
                            <div class="row modalRowUncolored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Last Login Date:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneUser.lastLoginDate }}
                                </div>
                            </div>
                            <div class="row modalRowColored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Download Count:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneUser.downloadCount }}
                                </div>
                            </div>
                            <div class="row modalRowUncolored">
                                <div class="col-md-4">
                                    <strong class="pull-right">Last Downloaded:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ oneUser.lastSermonDownloaded }}
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
                            <h2 class="uk-modal-title">Change User Password</h2>
                        </div>
                        <div class="uk-modal-body">
                            <form method="post" @submit.prevent="changePassword(userPasswordToChange.slug)">
                                <div class="form-group">
                                    <label for="Enter New Password">Enter New Password</label>
                                    <input type="password" v-model="userPasswordToChange.password" name="password" required="required" minlength="8" class="form-control">
                                    <span v-if="formErrors['password']" class="inputError">{{ formErrors['password'] }}</span>
                                </div>
                                <br>
                                <div class="uk-modal-footer uk-text-right">
                                    <button type="submit" class="btn btn-sm btn-block btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end of change password modal -->

                <!-- </div> -->
            </div>
        </div>
    </main>
</template>

<script>
    export default {

        data: function() {

            return {

                currentAdminPermission: "",
                users: [],
                oneUser: {},
                pagination: {},
                searchWord: "",
                usersCount: "",
                userToBeUpdated: {},
                formErrors: {},
                userPasswordToChange: {},
                newUser: {
                    name: "",
                    email: "",
                    permission: "",
                    password: ""
                },
                newUserForm: false,
                userTypeSelected: "",
                filterWord: ""

            };
        },

        mounted: function () {
            this.fetchUsers();
            this.fetchUsersCount();
            this.fetchCurrentAdmin();
        },


        methods: {

            fetchCurrentAdmin: function () {
                this.$http.get('/admin/admin/api/current').then((response) => {
                    this.currentAdminPermission = response.data;
                });
            },

            fetchUsersCount: function () {
                this.$http.get('/admin/user/api/count').then((response) => {
                    this.usersCount = response.data;
                });
            },

            fetchUsers: function (page_url) {

                let vm = this;
                page_url = page_url || '/admin/user/api'
                this.$http.get(page_url).then((response) => {
                    vm.makePagination(response.data)
                    vm.users = response.data.data;
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


            userDetails: function(user) {
                this.oneUser = user;
            },

            userTypeFilter: function (userTypeSelected) {

                var type = userTypeSelected;
                this.$http.get('/admin/user/api/type/' + type)
                    .then((response) => {
                    this.users = response.body;
                    this.filterWord = userTypeSelected;
                });

            },

            // make new user
            saveNewUser: function () {

                if(this.currentAdminPermission !== "Super Admin") {

                    this.$swal({
                        title: 'Error',
                        text: 'Only the super admin can perform this action.',
                        type: 'error',
                        timer: 1500
                    })
                    return;

                } else {

                    var user = this.newUser
                    this.newUser = {name: "", email: "", plan: "", password: ""}
                    this.$http.post('/admin/user/api/new', user).then((response) => {
                            this.fetchUsers();
                            this.fetchUsersCount();
                            this.$swal({
                                title: 'Great!',
                                text: 'New user was created successfully.',
                                type: 'success',
                                timer: 1500,
                            })
                        }).catch( errors => {
                            this.formErrors = errors.response.body;
                        });
                }

            },

            // shows the change password modal and binds the user data to it
            showChangePasswordModal: function (user) {
                this.userPasswordToChange = user;
            },

            // this process the password change and saves it to db
            changePassword: function (slug) {
                if(this.currentAdminPermission !== "Super Admin") {
                    this.$swal({
                        title: 'Error',
                        text: 'Only the super admin can perform this action.',
                        type: 'error',
                        timer: 1500,
                    })
                    return;
                } else {
                    let user = this.userPasswordToChange
                    this.$http.patch('/admin/user/api/password/change/' + slug, user)
                        .then((response) => {
                            this.fetchUsers()
                            this.$swal({
                                title: 'Great!',
                                text: 'Password change was successful',
                                type: 'success',
                                timer: 1500,
                            })
                        }).catch(errors => {
                            this.formErrors = errors.response.data;
                        });

                }

            },

            deleteUser: function(user) {
                if (this.currentAdminPermission !== "Super Admin") {
                    this.$swal({
                        title: 'Error',
                        text: 'Only the super admin can perform this action.',
                        type: 'error',
                        timer: 1500,
                    })
                    return;
                } else {
                    const vm = this;
                    this.$swal({

                        title: 'Are you sure?',
                        text: 'This user will be deleted if you continue',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete user!",
                        cancelButtonText: "No, don't!",

                    }).then((response) => {
                        vm.$http.delete('/admin/user/api/delete/' + user.slug).then((response) => {
                            vm.fetchUsers();
                            vm.fetchUsersCount();
                        });

                    });

                }
            },

        } /*methods end here*/


    } /*compoent ends here */

</script>