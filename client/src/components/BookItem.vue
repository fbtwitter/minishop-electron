<template>
	<div>
		<v-hover v-slot:default="{ hover }">
			<v-card :to="`/book/`+book.slug">
				<v-img :src="getImage(`/books/`+book.cover)" class="white--text" height="400px">
					<v-expand-transition>
						<div
							v-if="hover"
							class="d-flex transition-fast-in-fast-out black darken-2 v-card--reveal display-3 white--text"
							style="height: 100%;"
						>{{book.title}}</div>
					</v-expand-transition>
					<!-- <v-card-title class="fill-height align-end" v-text="book.title"></v-card-title> -->
				</v-img>
				<v-card-actions>
					<v-icon>mdi-cash</v-icon>
					<span class="orange--text">Rp {{book.price.toLocaleString('id-ID')}}</span>
					<v-spacer></v-spacer>
					<v-icon>mdi-eye</v-icon>
					{{book.views}}
				</v-card-actions>
			</v-card>
		</v-hover>
	</div>
</template>

<script>
export default {
	name: 'book-item',
	props: ['book'],
	data() {
		return {

		}
	},
}
</script>

<style lang="scss">
.v-card--reveal {
	align-items: center;
	bottom: 0;
	justify-content: center;
	opacity: 0.5;
	position: absolute;
	width: 100%;
}

.v-responsive__content {
	text-align: center;
}
</style>