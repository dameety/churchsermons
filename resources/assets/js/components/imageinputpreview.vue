<template>
	
    <div class="image-container">

        <img 
        	:src=getSetImage
        	class="image"
    	>

        <!-- <div class="vue-image-input-wrapper">
            Choose Image
       	</div> -->


       	<button id="vue-image-preview-button" :style="[colorSettings]">
	        <input type="file" accept="image/*" :name=inputName @change="chooseImage">
		    <span>Choose Image</span>
		</button>


    </div>

</template>
    
<script>
	export default {

		props: {
			defaultImage: {
		  		type: String,
		    	default: "",
		  	},
		  	inputName: {
		  		type: String,
		  		default: "file",
		  	},
		  	bgColor: {
		  		default: "#EAFF2E"
		  	},
		  	textColor: {
		  		default: "#ff0000"
		  	}
		},

		data () {
			return {
				setImage: null,
				imageToShowa: "",
				imagePreview: null,
				files: [],
				eventData: {},
				//
				colorSettings: {
					backgroundColor: this.bgColor,
					color: this.textColor,
				}
				

			}   
		},
		
		mounted () {
			console.log(this.inputNameString);
		},

		computed: {
			imageToShow () {
				return this.imagePreviewPath;
			},
			
			getSetImage () {
				return this.setImage !== null ? this.setImage : this.defaultImage
			},

		},


	    methods: {
	    	
	        changeImagePreview (e) {
	        	// var reader, files = e.target.files;
	        	// if(files.length === 0) {
	        	// 	this.imagePreview = null
	        	// 	return
	        	// }
	        	// var reader = new FileReader();

	        	// reader.onload = (e) => {
          //           this.imagePreview = e.target.result;
          //       }

          //       reader.readAsDataURL(files[0]);
	        },

	        chooseImage (e) {
	        	//get the files
	        	// let files = e.target.files;
	        	this.eventData = e
	        	let data = this.eventData
	        	let files = this.eventData.target.files;

	        	//if not files, reset the picture to null or default
	        	if(files.length === 0) {
	        		this.setImage = null
	        		return
	        	}

	        	let reader = new FileReader();
	        	reader.onload = (data) => {
                    this.setImage = data.target.result;
                }

                reader.readAsDataURL(files[0]);

	        },

	        removeImage (e) {
				this.eventData = e
				alert("hello");
	        }

	    },

	}
</script>

<style>
	.image-container {
		height: 100%;
		width: 100%;
	}

	.image {
		height: 100%;
		width: 100%;
	}

	#vue-image-preview-button {
	    margin-top: 5px;
	    position: relative;
	    overflow: hidden;
	    cursor: pointer;
		border: none;

	}

	#vue-image-preview-button input {

	    cursor: pointer;
	    position: absolute;
	    top: 0;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    opacity: 0.001
	}

</style>