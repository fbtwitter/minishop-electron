<template>
	<v-app>
		<v-app-bar
			app
			color="#5c67c6"
			dark
			v-if="isHome || isProfile || isMyOrder || isAbout"
			:hide-on-scroll="true"
		>
			<v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
			<v-toolbar-title to="/">{{appName}}</v-toolbar-title>
			<v-spacer></v-spacer>

			<v-btn icon @click="setDialogComponent('search')">
				<v-icon>mdi-magnify</v-icon>
			</v-btn>
			<v-btn icon @click="setDialogComponent('cart')">
				<v-badge color="#4248a1" overlap :content="countCart" :value="countCart>0">
					<v-icon>mdi-cart</v-icon>
				</v-badge>
			</v-btn>
		</v-app-bar>

		<v-app-bar app color="#5c67c6" dark v-else :hide-on-scroll="true">
			<v-btn icon @click.stop="$router.go(-1)">
				<v-icon>mdi-arrow-left-circle</v-icon>
			</v-btn>
			<v-spacer></v-spacer>
			<v-btn icon @click="setDialogComponent('cart')">
				<v-badge color="#4248a1" overlap :content="countCart" :value="countCart>0">
					<v-icon>mdi-cart</v-icon>
				</v-badge>
			</v-btn>
		</v-app-bar>

		<v-card>
			<v-navigation-drawer app v-model="drawer" temporary>
				<v-list>
					<v-list-item v-if="!guest">
						<v-list-item-avatar>
							<v-img :src="getImage('/users/'+user.avatar)"></v-img>
						</v-list-item-avatar>
						<v-list-item-content>
							<v-list-item-title>{{user.name}}</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
					<div class="pa-2 mb-1" v-if="guest">
						<v-btn
							block
							color="#5c67c6"
							:outlined="true"
							class="mb-2"
							@click="setDialogComponent('login')"
						>Login</v-btn>
						<v-btn block color="#5c67c6" dark @click="setDialogComponent('register')">Register</v-btn>
					</div>
					<v-divider></v-divider>
					<template v-for="(item, index) in menus">
						<v-list-item
							:key="`menu-`+index"
							:to="item.route"
							v-if="!item.auth || (item.auth && !guest)"
							color="#5c67c6"
						>
							<v-list-item-icon>
								<v-icon left>{{ item.icon }}</v-icon>
							</v-list-item-icon>
							<v-list-item-content>
								<v-list-item-title>{{item.title}}</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
					</template>
				</v-list>
				<template v-slot:append v-if="!guest">
					<div class="pa-2">
						<v-btn block color="#f14130" dark @click="logout">Logout</v-btn>
					</div>
				</template>
			</v-navigation-drawer>
		</v-card>

		<Alert />
		<keep-alive>
			<v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
				<component :is="currentComponent" @closed="setDialogStatus"></component>
			</v-dialog>
		</keep-alive>

		<v-content>
			<v-container flat>
				<v-slide-y-transition>
					<router-view></router-view>
				</v-slide-y-transition>
			</v-container>
		</v-content>

		<v-footer dark padless>
			<v-card flat tile class="indigo lighten-1 white--text text-center flex">
				<v-card-title>
					<strong class="subheading">Get connected with me on social networks!</strong>
					<v-spacer></v-spacer>
					<v-btn v-for="icon in icons" :key="icon" class="mx-4" dark icon>
						<v-icon size="24px">{{ icon }}</v-icon>
					</v-btn>
				</v-card-title>
				<v-divider></v-divider>
				<v-card-text class="white--text">
					{{ new Date().getFullYear() }} —
					<strong>Reza Augusdi</strong>
				</v-card-text>
			</v-card>
		</v-footer>
	</v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
	name: 'App',
	components: {
		Alert: () => import('@/components/Alert.vue'),
		Search: () => import('@/components/Search.vue'),
		Login: () => import('@/components/Login.vue'),
		Register: () => import('@/components/Register.vue'),
		Cart: () => import('@/components/Cart.vue')
	},

	data: () => ({
		drawer: false,
		menus: [
			{ title: 'Home', icon: 'mdi-home', route: '/', },
			{ title: 'Profile', icon: 'mdi-account', route: '/profile', auth: true },
			{ title: 'My Order', icon: 'mdi-shopping', route: '/my-order', auth: true },
			{ title: 'About', icon: 'mdi-account', route: '/about' },
		],
		icons: [
			'mdi-facebook',
			'mdi-twitter',
			'mdi-linkedin',
			'mdi-instagram',
		],
	}),
	methods: {
		...mapActions({
			setDialogStatus: 'dialog/setStatus',
			setDialogComponent: 'dialog/setComponent',
			setAuth: 'auth/set',
			setAlert: 'alert/set',
		}),
		logout() {
			let config = {
				headers: {
					'Authorization': 'Bearer ' + this.user.api_token,
				},
			}
			this.axios.post('/logout', {}, config)
				.then(() => {
					this.setAuth({})
					this.setAlert({
						status: true,
						color: '#5ecd64',
						text: 'Logout successfully',
					})
				})
				.catch((error) => {
					let { data } = error.response
					this.setAlert({
						status: true,
						color: 'error',
						text: data.message,
					})
				})
		}
	},
	computed: {
		isHome() {
			return (this.$route.path === '/')
		},
		isProfile() {
			return (this.$route.path === '/profile')
		},
		isMyOrder() {
			return (this.$route.path === '/my-order')
		},
		isAbout() {
			return (this.$route.path === '/about')
		},
		...mapGetters({
			countCart: 'cart/count',
			guest: 'auth/guest',
			user: 'auth/user',
			dialogStatus: 'dialog/status',
			currentComponent: 'dialog/component'
		}),
		dialog: {
			get() {
				return this.dialogStatus
			},
			set(value) {
				this.setDialogStatus(value)
			}
		}
	},
};
</script>

<style lang="scss">
@import "@/assets/scss/settings.scss";
@import "@/assets/scss/base.scss";
</style>
