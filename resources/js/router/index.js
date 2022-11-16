import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/Home.vue'
import NewRecipeForm from '../components/NewRecipeForm.vue'
import RecipeList from '../components/RecipeList.vue'
import RecipeCardLarge from '../components/RecipeCardLarge.vue'


const routes = [
	{
		path: '/',
		name: 'home',
		component: Home
	},
	{
		path: '/recipe/create',
		name: 'recipe.create',
		component: NewRecipeForm
	},
	{
		path: '/recipe/all',
		name: 'recipe.all',
		component: RecipeList
	},
	{
		path: '/recipe/:id',
		name: 'recipe.view',
		component: RecipeCardLarge
	},
]

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes
})

export default router