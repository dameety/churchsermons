<template>
	<main class="main">

	    <div class="breadcrumb">
	        <li class="breadcrumb-item">Configuration</li>
	    </div>

		<div class="col-sm-7 uk-margin-auto">
	   		<div class="animated fadeIn">

        		<!-- Church Name -->
	            <div class="card">
                    <div class="card-header">
                        <strong> Church Name </strong>
                    </div>
                    <div class="card-block">

                        <form class="form-horizontal" @submit.prevent="saveChurchName(settings.slug)">

                            <div class="form-group">
                                <input type="text" v-model="settings.churchName" name="churchName" required="required" maxlength="20" class="form-control input-sm">
                                <span v-if="formErrors['churchName']" class="inputError">{{ formErrors['churchName'] }}</span>
                            </div>

                            <div class="form-actions">
	                            <button type="submit" class="btn btn-primary">Save</button>
	                        </div>

                        </form>

                    </div>
                    <div class="card-footer">
                    </div>
                </div>
        		<!-- Church Name -->


        		<!-- Contact Email -->
	            <div class="card">
                    <div class="card-header">
                        <strong> Contact Email </strong>
                    </div>
                    <div class="card-block">

                        <form class="form-horizontal" @submit.prevent="saveContactEmail(settings.slug)">

                            <div class="form-group">
                                <input type="text" v-model="settings.contactEmail" name="contactEmail" required="required" maxlength="30" class="form-control input-sm">
                                <span v-if="formErrors['contactEmail']" class="inputError">{{ formErrors['contactEmail'] }}</span>
                            </div>

                            <div class="form-actions">
	                            <button type="submit" class="btn btn-primary">Save</button>
	                        </div>

                        </form>

                    </div>
                    <div class="card-footer">
                    </div>
                </div>
        		<!-- Contact Email -->


        		<!-- stripe api key -->
	            <div class="card">
                    <div class="card-header">
                        <strong> Stripe Api Key <small>Get it from your stripe dashboard</small> </strong>
                    </div>
                    <div class="card-block">

                        <form class="form-horizontal" @submit.prevent="saveStripeKey(settings.slug)">

                            <div class="form-group">
                                <input type="text" v-model="settings.api_key" name="api_key" required="required" minlength="32" maxlength="32" class="form-control input-sm">
                                <span v-if="formErrors['api_key']" class="inputError">{{ formErrors['api_key'] }}</span>
                            </div>

                            <div class="form-actions">
	                            <button type="submit" class="btn btn-primary">Save</button>
	                        </div>

                        </form>

                    </div>
                    <div class="card-footer">
                    </div>
                </div>
        		<!-- stripe api key -->


        		<!-- stripe plan -->
	            <div class="card">
                    <div class="card-header">
                        <strong> Stripe plan <small>Please note that only the amount is changeable later.</small> </strong>
                    </div>
                    <div class="card-block">

                        <form class="form-horizontal" @submit.prevent="saveStripePlan(settings.slug)">

		            		<div class="form-group">

					            <label for="Plan id">Plan id</label>
                                <input type="text" v-model="settings.plan_id" name="plan_id" required="required" maxlength="20" class="form-control input-sm">
                                <span v-if="formErrors['plan_id']" class="inputError">{{ formErrors['plan_id'] }}</span>

                            </div>

		            		<div class="form-group">

					            <label for="Plan Name">Plan Name</label>
                                <input type="text" v-model="settings.plan_name" name="plan_name" required="required" maxlength="20" class="form-control input-sm">
                                <span v-if="formErrors['plan_name']" class="inputError">{{ formErrors['plan_name'] }}</span>

                            </div>

		            		<div class="form-group">

					            <label for="Plan Amount">Plan Amount</label>
                                <input type="text" v-model="settings.plan_amount" name="plan_amount" required="required" maxlength="20" class="form-control input-sm">
                                <span v-if="formErrors['plan_amount']" class="inputError">{{ formErrors['plan_amount'] }}</span>

                            </div>

		            		<div class="form-group">

					            <label for="Plan Currency">Plan Currency</label>
                                <input type="text" v-model="settings.plan_currency" name="plan_currency" required="required" placeholder="3-letter ISO code for currency." maxlength="20" class="form-control input-sm">
                                <span v-if="formErrors['plan-currency']" class="inputError">{{ formErrors['plan_currency'] }}</span>

                            </div>

		            		<div class="form-group">

					            <label for="Plan Interval">Plan Interval</label>
					            <select v-model="settings.plan_interval" class="form-control" name="plan_interval" required="required">
                                    <option value="year"> Yearly </option>
                                    <option value="month"> MonthLy </option>
                                    <option value="week"> Weekly </option>
                                </select>

                            </div>

		            		<div class="form-group">

					            <label for="Plan Description">Plan Description</label>
                                <input type="text" v-model="settings.plan_description" name="plan_description" required="required" maxlength="22" class="form-control input-sm">
                                <span v-if="formErrors['plan_description']" class="inputError">{{ formErrors['plan_description'] }}</span>

                            </div>


                            <div class="form-actions">
	                            <button type="submit" class="btn btn-primary">Save </button>
	                        </div>

                        </form>

                    </div>
                    <div class="card-footer">
                    </div>
                </div>
        		<!-- </div> -->


        		<!-- email details -->
	            <div class="card">
                    <div class="card-header">
                        <strong> Welcome Email </strong>
                    </div>
                    <div class="card-block">

                        <form class="form-horizontal" @submit.prevent="updateWelcomeEmail(settings.slug)">

		            		<div class="form-group">

					            <label for="Welcome Email Heading">Welcome Email Heading</label>
                                <input type="text" v-model="settings.welcomeEmailHeading" name="welcomeEmailHeading" required="required" maxlength="40" class="form-control input-sm">
                                <span v-if="formErrors['welcomeEmailHeading']" class="inputError">{{ formErrors['welcomeEmailHeading'] }}</span>

                            </div>

                            <div class="form-group">

					            <label for="Welcome Email Body">Welcome Email Body</label>
                            	<textarea type="text" v-model="settings.welcomeEmailBody" name="welcomeEmailBody" required="required" class="form-control" rows="7"> </textarea>
                                <span v-if="formErrors['welcomeEmailBody']" class="inputError">{{ formErrors['welcomeEmailBody'] }}</span>

                            </div>

                            <div class="form-actions">
	                            <button type="submit" class="btn btn-primary">Save </button>
	                        </div>

                        </form>

                    </div>
                    <div class="card-footer">
                    </div>
                </div>

	    	</div>
	    </div>

	</main>
</template>

<script>

	export default {

		data: function() {
            return {

            	settings: {},
            	formErrors: {},
            };
        },

        mounted: function () {
            this.fetchSettings();
        },

        methods: {

        	fetchSettings: function () {
                this.$http.get('/admin/setting/api').then((response) => {
                    this.settings = response.data;
                    console.log(response.data);
                });
        	},

        	updateWelcomeEmail: function (slug) {
        		var setting = this.settings;
        		this.$http.patch('/admin/setting/api/mail/update/' + slug, setting).then((response) => {
                    this.$swal({
                        title: 'Great!',
                        text: 'Welcome email update successful',
                        type: 'success',
                        timer: 1500,
                    })
                }).catch(errors => {
                    this.formErrors = errors.response.data;
                });

        	},

        	saveStripeKey : function (slug) {
        		var setting = this.settings;
                this.$http.patch('/admin/setting/api/key/' + slug, setting).then((response) => {
                    this.$swal({
                        title: 'Great!',
                        text: 'Your stripe key has been saved',
                        type: 'success',
                        timer: 1500,
                    })
                }).catch(errors => {
                    this.formErrors = errors.response.data;
                });

        	},


        	saveStripePlan: function (slug) {
        		var setting = this.settings;
                this.$http.patch('/admin/setting/api/plan/' + slug,  setting).then((response) => {
                    this.$swal({
                        title: 'Great!',
                        text: 'Your stripe plan has been saved',
                        type: 'success',
                        timer: 1500,
                    })
                }).catch(errors => {
                    this.formErrors = errors.response.data;
                });

        	},

        	saveContactEmail: function (slug) {
        		var setting = this.settings;
                this.$http.patch('/admin/setting/api/email/' + slug,  setting).then((response) => {
                    this.$swal({
                        title: 'Great!',
                        text: 'Your contact email has been saved',
                        type: 'success',
                        timer: 1500,
                    })

                }).catch(errors => {
                    this.formErrors = errors.response.data;
                });

        	},

        	saveChurchName: function (slug) {
        		var setting = this.settings;
                this.$http.patch('/admin/setting/api/name/' + slug,  setting).then((response) => {
                        this.$swal({
                            title: 'Great!',
                            text: 'Your church name has been saved',
                            type: 'success',
                            timer: 1500,
                        })
                }).catch(errors => {
                    this.formErrors = errors.response.data;
                });

        	},


        }

    }
</script>

<style>


</style>