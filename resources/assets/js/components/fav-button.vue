<template>

    <a @click.prevent="favouriteSermon">
        <i class="fa fa-heart fa-2x uk-align-center uk-margin-small-bottom uk-margin-small-top" aria-hidden="true"></i>
    </a>
    
</template>

<script>
    
    export default {

        props: {
            sermon: {
                type: String,
                default: ''
            }
        },

        data () {
            return {
                slug: this.sermon,
                authStatus: ""
            }
        },


        mounted () {
            this.getAuthStatus();
        },

        methods: {

            getAuthStatus () {
                this.$http.get('/auth-check').then((response) => {
                    this.authStatus = response.data;
                })
            },

            favouriteSermon () {

                if(this.authStatus === true) {
                    
                    let url = this.slug;
                    this.$http.post(`/favourite/${url}`).then((response) => {

                        this.$swal({
                            title: 'Great!',
                            text: 'Successful operation',
                            type: 'success',
                            timer: 1900,
                        })

                    }).catch( errors => {
                        console.log(errors.response.data);
                    })
                } else {
                    this.$swal({
                        title: 'Oops...',
                        text: 'You need to be logged in to favourite',
                        type: 'error'
                    })
                }

            }
        }
    }

</script>