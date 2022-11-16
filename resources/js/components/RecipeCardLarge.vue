<template>
	<div>
		<img :src="recipe.image">
	</div>
</template>

<script setup>
	import { useRoute } from 'vue-router'
	import { ref, onMounted } from 'vue'

	const recipe = ref(null)

	

	onMounted(async () => {
		const route = useRoute()
		const id = route.params.id
		console.log('id in route ', id)

		recipe.value = await fetch('/api/recipe/' + id)
		.then(res => res.json() )
		
		console.log(recipe.value)
	})
</script>