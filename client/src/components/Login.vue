<template>
	<v-card>
		<v-toolbar dark color="#5c67c6">
			<v-btn icon dark @click.native="close">
				<v-icon>mdi-close</v-icon>
			</v-btn>
			<v-toolbar-title>Login and Start Shopping!</v-toolbar-title>
		</v-toolbar>
		<v-divider></v-divider>

		<v-container fluid>
			<v-form ref="form" v-model="valid" lazy-validation>
				<v-text-field
					v-model="email"
					:rules="emailRules"
					label="E-mail"
					required
					append-icon="mdi-email"
				></v-text-field>
				<v-text-field
					v-model="password"
					:rules="passwordRules"
					label="Password"
					:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
					:type="showPassword ? 'text' : 'password'"
					hint="At least 6 characters"
					counter
					@click:append="showPassword = !showPassword"
				></v-text-field>
				<div class="text-xs-center">
					<v-btn color="accent lighten-1" :disabled="!valid" @click="submit">
						Login
						<v-icon right dark>mdi-lock-open</v-icon>
					</v-btn>
				</div>
			</v-form>
		</v-container>
	</v-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
	name: 'login',
	data() {
		return {
			valid: true,
			email: 'rezabaru@gmail.com',
			emailRules: [
				v => !!v || 'E-mail is required.',
				v => /([a-zA-Z0-9_]{1,})(@)([a-zA-Z0-9_]{2,}).([a-zA-Z0-9_]{2,})+/.test(v) || 'E-mail must be vaild'
			],
			showPassword: false,
			password: '123456789',
			passwordRules: [
				v => !!v || 'Password required.',
				v => (v && v.length >= 6) || 'Min 6 characters',
			],
		}
	},
	computed: {
		...mapGetters({
			user: 'auth/user',
			prevUrl: 'prevUrl',
		}),
	},
	methods: {
		...mapActions({
			setAlert: 'alert/set',
			setAuth: 'auth/set',
		}),
		submit() {
			if (this.$refs.form.validate()) {
				let formData = {
					'email': this.email,
					'password': this.password
				}
				this.axios.post('/login', formData)
					.then((response) => {
						let data_user = response.data.data
						this.setAuth(data_user)
						if (this.user.id > 0) {
							this.setAlert({
								status: true,
								type: 'success',
								text: 'Login success',
							})
							if (this.prevUrl.length > 0) this.$router.push(this.prevUrl)
							this.close()
						}
						else {
							this.setAlert({
								status: true,
								color: 'error',
								text: 'Login failed',
							})
						}
					})
					.catch((error) => {
						let responses = error.response
						this.setAlert({
							status: true,
							text: responses.data.message,
							color: 'error',
						})
					})
			}
		},
		close() {
			this.$emit('closed', false)
		}
	},
}
</script>

<style>
</style>