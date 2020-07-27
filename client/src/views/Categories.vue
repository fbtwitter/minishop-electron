<template>
	<div>
		<v-container class="ma-0 pa-0" grid-list-sm>
			<v-subheader>All Category</v-subheader>
			<v-layout wrap>
				<v-flex v-for="(category) in categories" :key="`category-`+category.id" xs4>
					<v-card :to="`/category/`+category.slug">
						<v-img :src="getImage('/categories/'+category.image)" class="white--text">
							<v-card-title class="fill-height align-end" v-text="category.name"></v-card-title>
						</v-img>
					</v-card>
				</v-flex>
			</v-layout>
		</v-container>
		<template>
			<div class="text-center pt-2">
				<v-pagination
					color="#4248a1"
					v-model="page"
					@input="go"
					:length="lengthPage"
					:total-visible="5"
					circle
				></v-pagination>
			</div>
		</template>
	</div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
	data() {
		return {
			categories: [],
			page: 0,
			lengthPage: 0,
		}
	},
	created() {
		this.go()
	},
	methods: {
		...mapActions({
			setAlert: 'alert/set'
		}),
		go() {
			let url = '/categories?page=' + this.page
			this.axios.get(url)
				.then((response) => {
					let { data } = response.data
					let { meta } = response.data
					this.categories = data
					this.page = meta.current_page
					this.lengthPage = meta.last_page
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
}
</script>