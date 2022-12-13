<template>

	<div class="relative rounded flex flex-col">

		<ul>
			<h2 @click="makeTarget('main', $event)" class="font-bold mb-3 px-3 cursor-pointer border-l-secondary rounded-lg">Ingredients:</h2>

			<li v-for="ingredient in ingredients" :key="ingredient.id" class="flex gap-5">
				<p class="hover:cursor-pointer" @click="remove(ingredient.id)">{{ ingredient.name }}
				</p>

				<info-modal v-if="ingredient.description" :title="ingredient.name" :info="ingredient.description" ></info-modal>

				<input type="number" placeholder="Qty" v-model="ingredient.qty" class="input input-bordered w-1/6 text-2xl">

				<input type="text" placeholder="Unit" v-model="ingredient.unit" class="input input-bordered w-1/6 text-2xl">
			</li>
		</ul>


			<ul v-for="(subRecipe, name) in subRecipes" :key="name" :id="name">
				<h2 @click="makeTarget(name, $event)" class="font-bold mb-3 px-3 cursor-pointer border-l-secondary rounded-lg">{{ name }}:</h2>
				<li v-for="ingredient in subRecipe" :key="ingredient.id"></li>
			</ul>
			

		<input type="text" name="subRecipe" placeholder="Add sub-recipe" class="w-fit" v-if="subRecipeInput !== null" v-model="subRecipeInput" @keyup.enter="addSubRecipe">

		<button @click="subRecipeInput = ''" v-if="subRecipeInput === null" class="btn btn primary w-fit">ADD SUB-RECIPE</button>
	</div>

</template>


<script setup>
	import InfoModal from './InfoModal.vue'
	import { ref, watch, toRef, computed } from 'vue'

	const props = defineProps({
		ingredients: Array,
		target: String
	})

	const emit = defineEmits(['ingredient-to-pantry', 'makeTarget'])

	const subRecipeInput = ref(null)

	const subRecipes = ref({
		'for the soup': []
	})

	// const mainIngredients = computed(() => props.ingredients.map((item) => item.subRecipe === 'main'))
	const mainIngredients = props.ingredients.filter(item => item.subRecipe === 'main')
	const computedMain = computed(() => props.ingredients.filter(item => item.subRecipe === 'main'))

	const addIngredient = (ingredient, target) => {
		if (target === 'main') {
			mainIngredients.push(ingredient)
		} else {
			subRecipes[target].push(ingredient)
		}
	}

	const addSubRecipe = () => {
		subRecipes.value[subRecipeInput.value] = computed(() => props.ingredients.map( item => item.subRecipe === subRecipeInput.value))

		console.log(subRecipes.value)
		subRecipeInput.value = null
		
	}

	const makeTarget = (target, event) => {
		const targetList = document.querySelectorAll('ul > h2')
		targetList.forEach((node) => node.classList.remove('border-l-4'))
		event.target.classList.add('border-l-4')
		emit('makeTarget', target)
		console.log('mainIngredients ', computedMain.value)
	}



	

	const remove = (id) => emit('ingredient-to-pantry', id)
	
</script>