<template>
	<form class="form" @submit.prevent="login">
		<h1 class="form__title">Welcome back!</h1>

		<div class="form__group">
			<label>Email</label>
			<input type="text" class="form__control" v-model="form.email">
			<small class="error__control" v-if="error.email"> {{error.email[0]}}</small>
		</div>

		<div class="form__group">
			<label>Password</label>
			<input type="password" class="form__control" v-model="form.password">
			<small class="error__control" v-if="error.password"> {{error.password[0]}}</small>
		</div>

		<div class="form__group">
			<button :disabled="isProcessing" class="btn btn__primary">
				Login
			</button>
		</div>
	</form>
</template>

<script type="text/javascript">

	import { post } from '../../helpers/api'
	import Flash from '../../helpers/flash'
	import	Auth from '../../store/auth'

	export default {
		data() {
			return {
				form: {
					email:'',
					password:'',
				},
				error: {},
				isProcessing: false,
			}
		},
		methods: {
			login() {
				this.isProcessing = true;
				this.error = {};

				post('/api/login',this.form)
					.then((response) => {
						if(response.data.authenticated) {
							Auth.set(response.data.api_token, response.data.user_id);
							Flash.setSuccess('Successfully logged in');
							this.$router.push('/');
						}
					})
					.catch((error) => {
						if(error.response.status === 422) {
							this.error = error.response.data.errors;
							Flash.setError(this.error.message);
						}
					});

					this.isProcessing = false;
			}
		}
	}
</script>