<template>
	<div>
		<v-card v-if="category.slug" :to="'/category/'+category.slug">
			<v-img :src="getImage('/categories/'+category.image)" class="white--text">
				<v-card-title class="fill-height align-end" v-text="category.name"></v-card-title>
			</v-img>
		</v-card>

		<v-container class="ma-0 pa-0" grid-list-sm v-if="books">
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
	data() {
		return {
			category: {},
			books: [],
			page: 0,
			lengthPage: 0
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
			let { slug } = this.$route.params
			let url = '/categories/slug/' + slug
			url = url + '?page=' + this.page
			url = encodeURI(url)
			this.axios.get(url)
				.then((response) => {
					let { data } = response.data
					let category = data
					this.category = category
					this.books = category.books.data
					this.page = category.books.current_page
					this.lengthPage = category.books.last_page
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