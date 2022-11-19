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

		<p>{{ recipe.directions }}</p>
		

	</div>
</template>

<script setup>
	import { useRoute } from 'vue-router'
	import { ref, onMounted, onBeforeMount } from 'vue'

	const recipe = ref(null)
	const ingredients = ref(null)

	const getRecipe = async (id) => {
		const res = await fetch('/api/recipe/' + id)
		.catch(err => console.error(err))

		const data = await res.json()

		console.log(data)
		return data
	}

	

	onBeforeMount(async () => {
		const route = useRoute()
		const id = route.params.id
		console.log('id in route ', id)

		recipe.value = await getRecipe(id)
		
		// console.log(recipe.value)
	})
</script>