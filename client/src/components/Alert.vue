<template>
	<v-snackbar v-model="alert" :color="color" multi-line top>
		{{text}}
		<template v-slot:action="{ attrs }">
			<v-btn text v-bind="attrs" @click="close">
				<v-icon>mdi-close-circle</v-icon>
			</v-btn>
		</template>
		<!-- <v-btn dark text @click="close">
			<v-icon>mdi-close-circle</v-icon>
		</v-btn>-->
	</v-snackbar>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
	name: 'alert',
	computed: {
		...mapGetters({
			status: 'alert/status',
			color: 'alert/color',
			text: 'alert/text',
		}),
		alert: {
			get() {
				return this.status
			},
			set(value) {
				this.setAlert({
					status: value,
					type: '',
					text: '',
				})
			}
		}
	},
	methods: {
		...mapActions({
			setAlert: 'alert/set',
		}),
		close() {
			this.setAlert({
				status: false
			})
		}
	},
}
</script>

<style>
</style>