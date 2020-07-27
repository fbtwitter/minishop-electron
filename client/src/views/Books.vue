<template>
	<div>
		<v-container class="ma-0 pa-0" grid-list-sm>
			<v-subheader>All Books</v-subheader>
			<v-layout wrap>
				<v-flex v-for="(book) in books" :key="`book-`+book.id" xs6>
					<BookItem :book="book" />
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
	components: {
		BookItem: () => import('@/components/BookItem.vue'),
	},
	data: () => ({
		books: [],
		page: 0,
		lengthPage: 0
	}),
	created() {
		this.go()
	},
	methods: {
		...mapActions({
			setAlert: 'alert/set'
		}),
		go() {
			let url = '/books?page=' + this.page
			this.axios.get(url)
				.then((response) => {
					let { data } = response.data
					let { meta } = response.data
					this.books = data
					this.lengthPage = meta.last_page
					this.page = meta.current_page
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

<style>
</style>