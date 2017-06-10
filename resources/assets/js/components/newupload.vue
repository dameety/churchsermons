<template>
	<main class="main">

		<!-- Breadcrumb -->
        <div uk-sticky="offset: 54; show-on-up: true; animation: uk-animation-slide-top; bottom: #bottom" class="breadcrumb">
            <li><span class="breadcrumb-item uk-badge"> &nbsp; Total Sermons: {{sermonsCount}} &nbsp;</span></li>
        </div>
		
		<div class="col-sm-7 uk-margin-auto">
	   		<div class="animated fadeIn">


                <!-- the dropzone area -->
	    		<div class="row">


	    			<div id="uploadForm" class="col-lg-12" v-show="!newSermonForm">
	                    <div class="card">    
	                        <div class="card-header">

								<!-- visit this link for docs -->
								<dropzone

									ref="dropzone"	
									id= "dropzoneId"
									:useCustomDropzoneOptions=true 
									:dropzoneOptions="uploadOptions"
									url="/admin/sermon/api/upload"
									v-on:vdropzone-success="showSuccess">
										
								</dropzone>

	                        </div>
	                    </div>
	                </div>

	        	</div>


                <!-- list of all staged sermons -->
	        	<div class="row">
	        		<div class="col-lg-12" v-show="!newSermonForm">
	                	
	                	<!-- all the staged sermons -->
                        <div class="card">
                            <table class="table table-hover table-outline mb-0">
                                <thead class="thead-default">
                                    <tr>
                                        <th> </th>
                                        <th>Step 2: Click a sermon to add it's details.</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody v-for="sermon in stagedSermons">

                                    <tr>
                                        <td>
                                            <div class="avatar">
                                                <img src="/img/audioImage.png" class="img-avatar" alt="sermon audio logo">
                                            </div>
                                        </td>
                                        
                                        <a :href="sermonUrl(sermon)" class="sermontitle">
                                            <td id="stagedSermonTitle">{{ sermon.title }}</td>
                                        </a>

                                        <td>
                                            <div class="pull-right">
                                                <button
                                                class="newButton breadcrumb-item uk-button uk-button-danger uk-button-small"
                                                @click.prevent="deleteStagedSermon(sermon)">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <!-- pagination -->
	                	<div class="card card-header" v-show="!sermonsCount">
                            <div class="paginationn float-right">
                                <button class="btn btn-default btn-sm" @click="fetchStagedSermons(pagination.prev_page_url)"
                                          :disabled="!pagination.prev_page_url">
                                      Previous
                                  </button> &nbsp; 
                                  <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span> &nbsp; 
                                  <button class="btn btn-default btn-sm" @click="fetchStagedSermons(pagination.next_page_url)"
                                          :disabled="!pagination.next_page_url">Next
                                </button>
                            </div>
                        </div>

                    </div>
	        	</div>



	    	</div>
	    </div>
	    
	</main>
</template>

<script>

import Dropzone from 'vue2-dropzone'
// import vueImgPreview from 'vue-img-preview'

	export default {   

	    components: {
	    	Dropzone,
      //       vueImgPreview

	    },

		data: function() {
			return {
				
				// for dropzone
				uploadOptions: {
					maxFiles: 5,	
                    dictDefaultMessage: "Step 1: Drop sermon files here to begin upload",
					maxFilesize: 120,  
					uploadMultiple: true,
					parallelUploads: true,
					addRemoveLinks: true,
					acceptedFiles: 'audio/*',
					headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
					
				},

                sermonsCount: "",
				stagedSermons: [],
				pagination: {},
				sermonToComplete: "",				

                services: [],           /*used in the select input*/
				categories: [],         /*using the getAllCategories() and select input*/

	            newSermon: {
	            	title: "",
	            	preacher: "",
	            	service_id: "",
	            	category_id: "",
	            	datepreached: "",
	            	status: "",
	            	slug: "",
                    filename:"",
                    sermonImage: ""
	            },
                newSermonForm: false,
        
	            formErrors:[],
                
                galleryImages: [],
                imgeSrc: "",

			};
		},

		mounted: function () {
            this.fetchSermonsCount();
            this.fetchStagedSermons();
            this.fetchCategories();         //saved in the  categories: []
            this.fetchServices();           //saved in the services: []
        },

		methods: {

            sermonUrl (sermon) {
                return `/admin/sermon/${sermon.slug}/new`;
            },

            fetchSermonsCount: function () {
                this.$http.get('/admin/stagedsermon/api/count').then((response) => {
                    this.sermonsCount = response.data;
                });
            },

			fetchStagedSermons: function (page_url) {
                let vm = this;
                page_url = page_url || '/admin/stagedsermon/api'
                this.$http.get(page_url)
                    .then(function (response) {
                        vm.makePagination(response.data)
                        vm.stagedSermons = response.data.data;
                    });

			},

			// fill the form with the sermon title to 
			// be completed
			fillStagedSermon: function (sermon) {
				this.newSermonForm = true;
				var titleString = sermon.title;
                this.newSermon.filename = sermon.filename;
				this.newSermon.slug = sermon.slug;
				this.newSermon.title = titleString.replace("." + sermon.type, "");

			},

			makePagination: function(data){
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    total: data.total,
                }
                this.pagination = pagination;

            },

            completeSermonUpload: function () {
                var sermon = this.newSermon
                this.formErrors = '';
                                        

                this.$http.post('/admin/sermon/api/upload/fill', sermon).then((response) => {
                    this.newSermon = {
                    title: "", preacher: "", service_id: "", category_id: "", datepreached: "", status: "", slug: "", filename: "", image: ""
                };
                    this.fetchStagedSermons();
                    this.fetchSermonsCount();
                    this.newSermonForm = false;
                    this.$swal({
                        title: 'Great!',
                        text: 'New Sermon Creation Successful',
                        type: 'success',
                        timer: 1500,
                    })
                }).catch( errors => { 
                    this.formErrors = errors.response.data;
                    console.log(errors.response.data);
                });                    

            },

            deleteStagedSermon: function (sermon) {
            	var vm = this;
                this.$swal({
                    title: 'Are you sure?',
                    text: 'This sermon will be deleted if you continue',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, don't!",
                }).then(function() {
                    vm.$http.delete('/admin/stagedsermon/api/delete/' + sermon.slug).then((response) => {
                        vm.fetchStagedSermons();
                        vm.fetchSermonsCount();
                    });
                });

            },

			showSuccess: function (file) {
		        this.fetchStagedSermons();
		    },

			// get all categories
            fetchCategories: function () {
                this.$http.get('/admin/category/api/all').then((response) => {
                    this.categories = response.data;
                });
            },

            // get all services
            fetchServices: function () {
                this.$http.get('/admin/service/api/all').then((response) => {
                    this.services = response.data;
                });
            },

            // get all gallery images
            fetchGalleryImages () {
                this.$http.get('/admin/gallery/api').then((response) => {
                    this.galleryImages = response.data;
                });
            },

            //set the sermon image
            setSermonImage (galleryImage) {
                this.newSermon.sermonImage = galleryImage;
            },

                previewThumbnail: function(event) {
              var input = event.target;

              if (input.files && input.files[0]) {
                var reader = new FileReader();

                var vm = this;

                reader.onload = function(e) {
                  vm.imageSrc = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
              }
            }

		}

	}

</script>

<style>

    #stagedSermonTitle {
        cursor: pointer;
    }

    a.sermontitle {
        text-decoration: none;
    }

	.progress-indicator {
		
		height: 20px;  /* Can be anything */
		position: relative;
		background: green;
		padding: 10px;
	}

    .sermonImage {
        border: 1px solid #777;
        height: 120px;
        width: 100%;
    }

    div.sermonImage img {
        height: 100%;
        width: 100%;
    }


</style>