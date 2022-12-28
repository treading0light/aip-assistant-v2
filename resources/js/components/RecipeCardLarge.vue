<template>
	<div class="flex flex-col items-center">
		<h1 class="text-6xl">{{ recipe.title }}</h1>
		<p class="text-3xl">{{ recipe.description }}</p>
		<img class="w-1/4" :src="recipe.image">
		<hr>

		<div class="w-full flex">
			<ul id="ingredients" class="">
				<li v-for="ingredient in recipe.ingredients">{{ ingredient.name }} {{ ingredient.qty }} {{ ingredient.unit }}</li>
			</ul>
		</div>

		<div>
			<p v-for="line in recipe.directions">{{ line }}</p>
		</div>
		
		

	</div>
</template>

<script setup>
	import { useRoute } from 'vue-router'
	import { ref, onMounted, onBeforeMount } from 'vue'

	const recipe = ref({})
	const ingredients = ref({})

	const getRecipe = async (id) => {
		const res = await fetch('/api/recipe/' + id)
		.catch(err => console.error(err))

		const data = await res.json()
		return data
	}

	const devideIngredients = (array) => {

	}

	const splitDirections = () => {
		const string = recipe.value.directions

		const splitDir = string.split(/\r?\n/).filter(el => el)
		recipe.value.directions = splitDir
		console.log(recipe.value.directions)
	}

	

	onBeforeMount(async () => {
		const route = useRoute()
		const id = route.params.id

		recipe.value = await getRecipe(id)
		// console.log(recipe.value.directions)
		splitDirections()
	})

	onMounted(() => {
		// console.log(recipe.value)
		
	})
</script>