import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import store from '../store/index.js'


Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  {
    path: '/profile',
    name: 'Profile',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/Profile.vue'),
    meta: {auth:true}
  },
  {
    path: '/categories',
    name: 'categories',
     component: () => import(/* webpackChunkName: "categories" */ '../views/Categories.vue')
  },
  {
    path: '/books',
    name: 'books',
     component: () => import(/* webpackChunkName: "books" */ '../views/Books.vue')
  },
  {
    path: '/category/:slug',
    name: 'category',
    component: () => import(/* webpackChunkName: "about" */ '../views/Category.vue')
  },
  {
    path: '/book/:slug',
    name: 'book',
    component: () => import('../views/Book.vue'),
  },
  {
    path: '/checkout',
    name: 'checkout',
    component: () => import('../views/Checkout.vue'),
    meta: {auth:true}
  },
  {
    path: '/payment',
    name: 'payment',
    component: () => import('../views/Payment.vue'),
    meta: {auth:true}
  },
  {
    path: '/my-order',
    name: 'my-order',
    component: () => import('../views/MyOrder.vue'),
    meta: {auth:true}
  },

]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
      if (store.getters['auth/guest']) {
        store.dispatch('alert/set', {
          status: true,
          text: 'Login first',
          color: 'error',
        })
        store.dispatch('setPrevUrl', to.path)
        store.dispatch('dialog/setComponent', 'login')
        store.dispatch('dialog/setStatus', true)
      }
      else {
        next()
      }
    }
    else {
      next()
  }
})

export default router
