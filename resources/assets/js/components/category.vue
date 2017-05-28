<template>
    <main class="main">

	   <!-- main page starts here -->
        <div class="breadcrumb">

            <li class="breadcrumb-item"><span class="uk-badge"> &nbsp; Total Categories: {{categoriesCount}} &nbsp; </span></li>
            <li> &nbsp; <button class="newButton breadcrumb-item uk-button uk-button-primary uk-button-small" href="#newCategoryForm" uk-scroll @click="newCategoryForm = true">Add New Category</button></li>

            <!-- Breadcrumb Menu-->
            <li id="pagination" class="breadcrumb-menu hidden-md-down">
              <button class="btn btn-default btn-sm" @click="fetchCategories(pagination.prev_page_url)"
                      :disabled="!pagination.prev_page_url">
                  Previous
              </button> &nbsp; 
              <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp; 
              <button class="btn btn-default btn-sm" @click="fetchCategories(pagination.next_page_url)"
                      :disabled="!pagination.next_page_url">Next
              </button>
            </li>
        </div>
        
        <div class="container-fluid">
            <div class="animated fadeIn">

                <!-- new category form -->
                <div id="newCategoryForm" class="col-lg-12 uk-animation-slide-top-medium" v-show="newCategoryForm">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-edit"></i>  Fill in the new category details
                            <div class="card-actions">
                                <a class="pull-right" style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" @click="newCategoryForm = false"></a>
                            </div>
                        </div>
                        <div class="card-block">
                            <form @submit.prevent="addNewCategory">
                                <div class="form-group">
                                    <label for="Name">Name</label>
                                    <input type="text" v-model="newCategory.name" name="name" required="required" maxlength="30" class="form-control">
                                    <span v-if="formErrors['name']" class="inputError">{{ formErrors['name'] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea type="text" v-model="newCategory.description" name="description" maxlength="300" class="form-control" rows="5"> </textarea>
                                    <span v-if="formErrors['description']" class="inputError">{{ formErrors['description'] }}</span>
                                </div>
                                <br>
                                <div class="uk-modal-footer uk-text-right">
                                    <button type="submit" class="btn btn-block btn-primary">Create Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- new category form -->


                <!-- search input -->
                <div class="card-block" v-show="!newCategoryForm">
                    <div id="searchForm" class="col-lg-12 uk-animation-slide-top-medium">
                        <div class="card">    
                            <div class="card-header">
                                <input type="text" v-model="searchWord" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- search input -->


                <!-- ALL THE CATEGORIES-->
                <div class="row">

                    <!-- all categoris cards -->
                    <div class="col-sm-6 col-md-4 uk-animation-slide-bottom-medium" v-for="category in filterBy(categories, searchWord)" v-show="!newCategoryForm">
                        <div class="card uk-card uk-card-default uk-card-hover">
                            <div class="card-block">
                                <strong class="categoryName"> Name:</strong> &nbsp;{{ category.name }}
                                <span class="badge badge-pill badge-danger float-right" title="This is the total number of sermons in this Category" uk-tooltip>{{ category.sermonCount }}</span>
                                <hr>
                                <p> <strong class="categoryDescription">Description:</strong> &nbsp;{{ category.description }}</p> 
                            </div>

                            <div class="uk-container card-footer">
                                <a uk-icon="icon: pencil; ratio: 1.2" href="#editCategoryModal" uk-toggle @click.prevent="editCategory(category)"></a>
                              &nbsp; &nbsp; 
                                <a style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" @click.prevent="deleteCategory(category)"></a>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- bottom pagination -->
                <div class="card-block uk-animation-slide-top-medium" v-show="!newCategoryForm">
                    <div class="card">    
                        <div class="card-header">
                            <div class="paginationn float-right">
                                <button class="btn btn-default btn-sm" @click="fetchCategories(pagination.prev_page_url)"
                                          :disabled="!pagination.prev_page_url">
                                      Previous
                                  </button> &nbsp; 
                                  <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp; 
                                  <button class="btn btn-default btn-sm" @click="fetchCategories(pagination.next_page_url)"
                                          :disabled="!pagination.next_page_url">Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- patination -->


                <!-- the edit modal -->
                <div id="editCategoryModal" uk-modal>
                    <div class="uk-modal-dialog">
                        <button class="uk-modal-close-outside" type="button" uk-close></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">Edit Category</h2>
                        </div>
                        <div class="uk-modal-body">
                            <div class="card-block">
                                <form method="post" @submit.prevent="updateCategory(categoryToBeUpdated.slug)">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" v-model="categoryToBeUpdated.name" required="required" maxlength="15" name="name" class="form-control">
                                        <span v-if="formErrors['name']" class="inputError">{{ formErrors['name'] }}</span>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea type="text" v-model="categoryToBeUpdated.description" maxlength="200" name="description" class="form-control" rows="5"> </textarea>
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

            </div>
        </div>
        
    </main>
</template>

<script>
   	   
    export default {

        data: function() {
  			return {
                
                categories: [],     /*using the fetchCategories()*/
                pagination: {},
                searchWord:"",       /*used by the global filter*/
                categoriesCount: "",
  				newCategory: {
  					name: "",
  					description: ""
  				},
                formErrors: {},
                categoryToBeUpdated: {},
                newCategoryForm: false
              
  			};
		},

        mounted() {
            this.fetchCategories();
            this.fetchCategoriesCount();
        },

	    methods: {

            fetchCategoriesCount: function () {
                this.$http.get('/admin/category/api/count').then((response) => {
                    this.categoriesCount = response.data;
                });
            },

          	fetchCategories: function (page_url) {  
                let vm = this;
                page_url = page_url || '/admin/category/api'
                this.$http.get(page_url).then((response) => {
                    vm.makePagination(response.data)
                    vm.categories = response.data.data;
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

          	addNewCategory: function() {
	            var category = this.newCategory
  				this.newCategory = { name: "", description: ""}
  				this.$http.post('/admin/category/api/new', category).then((response) => {
      				    
                        this.fetchCategories()
                        this.fetchCategoriesCount()
                        this.$swal({
                            title: 'Great!',
                            text: 'New Category Creation Successful',
                            type: 'success',
                            timer: 1500,
                        })

    			    }).catch( errors => { 
                        this.formErrors = errors.response.data;
                    });

			},

			editCategory: function(category) {
                this.categoryToBeUpdated = category;
          	},

            updateCategory: function (slug) {

                var category = this.categoryToBeUpdated;
                this.$http.patch('/admin/category/api/update/' + slug, category).then((response) => {
                    this.fetchCategories();
                    this.$swal({
                        title: 'Great!',
                        text: 'Category Update Successful',
                        type: 'success',
                        timer: 1500,
                    })
                }).catch( errors => { 
                    this.formErrors = errors.response.data;
                });

            },

            deleteCategory: function(category) {
                var vm = this;                    
                this.$swal({
                    title: 'Are you sure?',
                    text: 'This service will be deleted if you continue',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, don't!",
                }).then((response) => {
                    vm.$http.delete('/admin/category/api/delete/' + category.name).then((response) => {
                        vm.fetchCategories();
                        vm.fetchCategoriesCount();
                    });

                });
            
	       },
   			
	    }

    }
</script>


<style>

    .categoryName {
        color: #263238;
    }

    .categoryDescription {
        color: #20A8D8;
    }

</style>
