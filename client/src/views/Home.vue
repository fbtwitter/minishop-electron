<template>
	<div class="home">
		<v-container class="ma-0 pa-0" grid-list-sm>
			<div class="text-right">
				<v-btn small text to="/categories" class="blue--text">
					All Categoires
					<v-icon>mdi-chevron-right</v-icon>
				</v-btn>
			</div>
			<v-layout wrap>
				<v-flex v-for="(category) in categories" :key="`category-`+category.id" xs6>
					<v-card :to="`/category/`+category.slug">
						<v-img :src="getImage(`/categories/`+category.image)" class="white--text" height="300px">
							<v-card-title class="fill-height align-end" v-text="category.name"></v-card-title>
						</v-img>
					</v-card>
				</v-flex>
			</v-layout>
		</v-container>
		<v-container class="ma-0 pa-0 mt-2" grid-list-sm>
			<div class="text-right">
				<v-btn small text to="/books" class="blue--text">
					All Books
					<v-icon>mdi-chevron-right</v-icon>
				</v-btn>
			</div>
			<v-layout wrap>
				<v-flex v-for="(book) in books" :key="`book-`+book.id" xs6>
					<BookItem :book="book" />
				</v-flex>
			</v-layout>
		</v-container>
	</div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'
import { mapActions } from 'vuex'

export default {
	name: 'Home',
	components: {
		BookItem: () => import('@/components/BookItem.vue')
	},
	data: () => ({
		categories: [],
		books: [],
	}),
	methods: {
		...mapActions({
			setAlert: 'alert/set',
		}),
	},
	created() {
		this.axios.get('/categories/random/2')
			.then((response) => {
				let { data } = response.data
				this.categories = data
			})
			.catch((error) => {
				let responses = error.response
				this.setAlert({
					status: true,
					text: responses.data.message,
					color: 'error',
				})
			}),
			this.axios.get('/books/top/4')
				.then((response) => {
					let { data } = response.data
					this.books = data
				})
				.catch((error) => {
					let responses = error.response
					this.setAlert({
						status: true,
						text: responses.data.message,
						color: 'error',
					})
				})
	},
}
</script>