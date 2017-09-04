import Vue from 'vue'
import VueRouter from 'vue-router'
import Register from '../views/Auth/Register.vue'
import Login from '../views/Auth/Login.vue'
import RecipeIndex from '../views/Recipe/Index.vue'
import RecipeShow from '../views/Recipe/Show.vue'
import RecipeForm from '../views/Recipe/Form.vue'

Vue.use(VueRouter)

const router = new VueRouter({
	routes: [
		{ path: '/register', component: Register },
		{ path: '/login', component: Login },
		{ path: '/', component: RecipeIndex },
		{ path: '/recipes', component: RecipeIndex },
		{ path: '/recipes/create', component: RecipeForm, meta:{ mode: 'create' }},
		{ path: '/recipes/:id', component: RecipeShow },
		{ path: '/recipes/:id/edit', component: RecipeForm, meta:{ mode: 'edit'} },
	]
});


export default router;