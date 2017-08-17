<template>
	<main class="main">

        <div uk-sticky="offset: 54; show-on-up: true; animation: uk-animation-slide-top; bottom: #bottom" class="breadcrumb">
            <li><span class="breadcrumb-item uk-badge"> &nbsp; Total Sermons: {{sermonsCount}} &nbsp;</span></li>
        </div>

		<div class="col-sm-7 uk-margin-auto">
	   		<div class="animated fadeIn">

	    		<div class="row">
	    			<div id="uploadForm" class="col-lg-12" v-show="!newSermonForm">
	                    <div class="card">
	                        <div class="card-header">

								<dropzone

									ref="dropzone"
									id= "dropzoneId"
									:useCustomDropzoneOptions=true
									:dropzone-options="uploadOptions"
									url="/admin/sermon/api/upload"
									v-on:vdropzone-success="showSuccess">

								</dropzone>

	                        </div>
	                    </div>
	                </div>
	        	</div>

	        	<div class="row">
	        		<div class="col-lg-12" v-show="!newSermonForm">
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

	export default {

	    components: {

	    	Dropzone,

	    },

		data () {
			return {

				uploadOptions: {
					maxFiles: 5,
                    dictDefaultMessage: "Step 1: Drop sermon files here to begin upload",
					maxFileSizeInMB: 5000,
					uploadMultiple: true,
					parallelUploads: true,
					acceptedFileTypes: 'audio/*',
					headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
				},
				pagination: {},
                sermonsCount: "",
                stagedSermons: [],
				sermonToComplete: "",
                newSermonForm: false,
			};
		},

		mounted () {
            this.fetchSermonsCount();
            this.fetchStagedSermons();
        },

		methods: {

            sermonUrl (sermon) {
                return `/admin/sermon/${sermon.slug}/new`;
            },

            fetchSermonsCount () {
                this.$http.get('/admin/stagedsermon/api/count').then((response) => {
                    this.sermonsCount = response.data;
                });
            },

			fetchStagedSermons (page_url) {
                let vm = this;
                page_url = page_url || '/admin/stagedsermon/api'
                this.$http.get(page_url)
                    .then((response) => {
                        vm.makePagination(response.data)
                        vm.stagedSermons = response.data.data;
                    });

			},

			// fill the form with the sermon title to
			// be completed
			fillStagedSermon (sermon) {
				this.newSermonForm = true;
				let titleString = sermon.title;
                this.newSermon.filename = sermon.filename;
				this.newSermon.slug = sermon.slug;
				this.newSermon.title = titleString.replace("." + sermon.type, "");

			},

			makePagination (data){
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    total: data.total,
                }
                this.pagination = pagination;

            },

            deleteStagedSermon (sermon) {
            	const vm = this;
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

			showSuccess (file) {
		        this.fetchStagedSermons();
		    },
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