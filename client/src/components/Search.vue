<template>
	<v-card>
		<v-toolbar dark color="#5c67c6">
			<v-btn icon dark @click.native="close">
				<v-icon>mdi-close</v-icon>
			</v-btn>
			<v-text-field
				hide-details
				append-icon="mdi-microphone"
				flat
				autofocus="true"
				label="Search"
				prepend-inner-icon="mdi-magnify"
				v-model="keyword"
				@input="doSearch"
			></v-text-field>
		</v-toolbar>
		<v-card-text>
			<v-subheader v-if="keyword.length>0">Result search "{{keyword}}"</v-subheader>
			<v-alert
				:value="books.length==0 && keyword.length>0"
				color="#ffb84b"
			>Sorry, but no results were found.</v-alert>

			<v-container class="ma-0 pa-0" grid-list-sm>
				<v-layout wrap>
					<v-flex v-for="(book) in books" :key="`book-`+book.id" xs4>
						<BookItem :book="book" />
					</v-flex>
				</v-layout>
			</v-container>
		</v-card-text>
	</v-card>
</template>

<script>
import { mapActions } from "vuex";

export default {
	name: 'search',
	components: {
		BookItem: () => import('@/components/BookItem.vue'),
	},
	data() {
		return {
			keyword: '',
			books: []
		}
	},
	methods: {
		...mapActions({
			setAlert: 'alert/set',
		}),
		doSearch() {
			let keyword = this.keyword
			if (keyword.length > 0) {
				this.axios.get('/books/search/' + keyword)
					.then((response) => {
						let { data } = response.data
						this.books = data
					})
					.catch((error) => {
						let responses = error.response
						this.setAlert({
							status: true,
							text: responses.data.message,
							color: '#f14130',
						})
					})
			} else {
				this.books = []
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