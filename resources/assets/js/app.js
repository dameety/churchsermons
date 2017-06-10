require('./bootstrap');

import Vue2Filters from 'vue2-filters';
import VueSweetAlert from 'vue-sweetalert';
import {vueImgPreview} from 'vue-img-preview';

window.Vue = require('vue');

Vue.use(Vue2Filters);
Vue.use(VueSweetAlert);

Vue.prototype.$http = axios;
Vue.component('service', require('./components/Service.vue'));
Vue.component('category', require('./components/category.vue'));
Vue.component('sermon', require('./components/sermon.vue'));
Vue.component('users', require('./components/users.vue'));
Vue.component('admins', require('./components/admins.vue'));
Vue.component('newupload', require('./components/newupload.vue'));
Vue.component('dashboard', require('./components/dashboard.vue'));
Vue.component('slider', require('./components/slider.vue'));
Vue.component('admin', require('./components/settings/admin.vue'));


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
