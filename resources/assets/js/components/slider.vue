<template>
    <main class="main">

        <div class="breadcrumb">
            <li> &nbsp;
                <button class="newButton breadcrumb-item uk-button uk-button-primary uk-button-small" uk-scroll v-if="!imageUploadForm" @click="imageUploadForm = true">Upload Image
                </button>
            </li>
        </div>


        <div class="container uk-margin-auto">
            <div class="animated fadeIn">

                <!-- upload form -->
                <div id="imageUploadForm" class="container uk-animation-slide-top-medium" v-show="imageUploadForm">
                    <div class="card">
                        <div class="card-header">
                            A maximum of 5 image is allowed
                            <div class="card-actions">
                                <a style="color:#FC0000;" uk-icon="icon: close; ratio: 1.2" @click="editSermonForm = false"></a>
                            </div>
                        </div>
                        <div class="card-block">
                            <dropzone

                                ref="dropzone"
                                id= "dropzoneId"
                                :useCustomDropzoneOptions=true
                                :dropzoneOptions="uploadOptions"
                                url="/admin/setting/api/slider/upload"
                                v-on:vdropzone-success="showSuccess">

                            </dropzone>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="col-sm-12 uk-margin-auto">
            <div class="animated fadeIn">
                <div class="gallery uk-flex-center uk-animation-slide-top-medium" uk-grid>
                    <div class="imageContainer" v-for="image in images">

                        <img v-bind:src="image" @click.prevent="deleteImage(image)">

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
            Dropzone
        },

        data: function() {
            return {

                uploadOptions: {
                    dictDefaultMessage: "Click or drop images here to upload",
                    maxFilesize: 30,
                    uploadMultiple: true,
                    parallelUploads: true,
                    addRemoveLinks: true,
                    acceptedFiles: 'image/*',
                    headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
                },

                images: [],
                imageUploadForm: true,

            };
        },

        mounted: function () {
            this.fetchImages();
        },

        methods: {

            fetchImages () {
                this.$http.get('/admin/setting/api/slider').then((response) => {
                    this.images = response.data;
                });
            },

            showSuccess: function (file) {
                this.fetchImages();
            },

            deleteImage (image) {
                let vm = this;
                this.$swal({
                    title: 'Are you sure?',
                    text: 'Check medialibrary doc to finish the server side',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, don't!",
                }).then(function() {
                    let file = image;
                    vm.$http.post('/admin/setting/api/slider/remove', {url:file})
                        .then(function (response) {
                            vm.fetchImages();
                        });
                });

            },

        }

    }
</script>

<style>

    .gallery {
        margin-bottom: 30px;
    }

    div.imageContainer {
        position: relative;
        height: 150px;
        width: 250px;

    }

    div.imageContainer img {
        position: relative;
        height: 100%;
        width: 100%;
        cursor: pointer;
    }


</style>