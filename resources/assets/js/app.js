require('./bootstrap');

import VeeValidate from 'vee-validate';
import Vue2Filters from 'vue2-filters';
import VueSweetAlert from 'vue-sweetalert';
import {vueImgPreview} from 'vue-img-preview';

window.Vue = require('vue');

Vue.use(Vue2Filters);
Vue.use(VeeValidate);
Vue.use(VueSweetAlert);

Vue.prototype.$http = axios;
Vue.component('users', require('./components/users.vue'));
Vue.component('sermon', require('./components/sermon.vue'));
Vue.component('slider', require('./components/slider.vue'));
Vue.component('admins', require('./components/admins.vue'));
Vue.component('service', require('./components/service.vue'));
Vue.component('category', require('./components/category.vue'));
Vue.component('newupload', require('./components/newupload.vue'));
Vue.component('dashboard', require('./components/dashboard.vue'));
Vue.component('admin', require('./components/settings/admin.vue'));
Vue.component('fav-button', require('./components/fav-button.vue'));


const app = new Vue({

    el: '#app',

    components: {

        vueImgPreview

    },

    data: function() {
        return {

        	filterParams: false,
        	services: false

        };
    },

    methods: {
    	turnFilter: function () {
    		var keep = this.filterParams;
            if (keep) {
                this.filterParams = false;
            }
            else if (!keep) {
                this.filterParams = true;
            }
    	},

    	toggleServices: function () {
    		var keep = this.services;
            if(keep) {

    			this.services = false;
            }
            else if (!keep) {
    			this.services = true;

            }
    	}

    }

});
