<template>

	<div class="flex flex-col items-center gap-10">

		<input type="text" v-model="title" placeholder="title" class="input input-bordered input-primary w-full max-w-xs text-2xl">

		<input type="text" v-model="description" placeholder="description" class="input input-bordered input-primary w-full max-w-xs text-2xl">

		<input type="text" v-model="srcURL" placeholder="Source URL" class="input input-bordered input-primary w-full max-w-xs text-2xl">

		<picture-input
		  ref="pictureInput"
	      width="300" 
	      height="300" 
	      margin="16" 
	      accept="image/jpeg,image/png" 
	      size="10" 
	      button-class="btn"
	      :custom-strings="{
	        upload: '<h1>Bummer!</h1>',
	        drag: 'Click or drag photo here'
	      }"
	      @change="onChange">
	    </picture-input>

		<div class="w-full flex justify-around mb-10">

			<div class="flex flex-col">
				<h2 class="underline font-bold mb-5">Ingredients:</h2>

				<ingredient-tray 
				v-for="group in chosenIngredients"
				@makeTarget="makeTarget" 
				@ingredient-to-pantry="ingredientToPantry" 
				:ingredients="group.ingredients"
				:subRecipe="group.name"
				:isActive="group.isActive"></ingredient-tray>

				<input type="text" name="subRecipe" placeholder="Add sub-recipe" class="w-fit" 
				v-if="subRecipeInput !== null" v-model="subRecipeInput" @keyup.enter="addSubRecipe">

				<button @click="subRecipeInput = ''" v-if="subRecipeInput === null" class="btn btn-primary w-fit">ADD SUB-RECIPE</button>
			</div>

			<pantry @ingredient-to-recipe="ingredientToRecipe"
			@create-ingredient-modal="createIngredientModal"
			:ingredients="pantryIngredients"
			></pantry>

		</div>

		<div class="w-1/2">
			<textarea 
			class="textarea textarea-primary w-full text-2xl" rows="10" 
			placeholder="Directions"
			v-model="directions"></textarea>
		</div>

		<button @click="postRecipe" class="btn btn-primary">Submit Recipe</button>

		<button @click="testRequest" class="btn btn-primary">Test</button>

		<ingredient-modal
		v-if="ingredientModal"
		@ingredient-created="ingredientCreated"
		@cancel-ingredient="cancelIngredient"
		:searchText="searchText">	
		</ingredient-modal>

		<div v-if="message" class="alert alert-success shadow-lg">
		  <div>
		    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
		    <span>{{ message }}</span>
		  </div>
		</div>
	</div>
	
</template>

<script setup>
	import IngredientTray from './IngredientTray.vue'
	import Pantry from './Pantry.vue'
	import IngredientModal from './IngredientModal.vue'
	import PictureInput from './PictureInput.vue'

	import { ref, onMounted } from 'vue'

	let title = ref('')
	let description = ref('')
	const subRecipes = ref({})
	let image = ref(null)
	let directions = ref('')
	let srcURL = ref('')
	const searchText = ref(null)
	const ingredientModal = ref(false)
	let message = null
	const target = ref('main')
	const pictureInput = ref(null)

	const subRecipeInput = ref(null)

	const csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content')

	const pantryIngredients = ref([
		{
			'id': 1,
			'name': 'ground beef'
		},
		{
			'id': 2,
			'name': 'bread'
		},
		{
			'id': 3,
			'name': 'cheese'
		},
	])
	const chosenIngredients = ref([
		{
			name: 'main',
			ingredients: [],
			isActive: true
		},
	])

	const makeTarget = (subRecipe) => {	
		for (let obj of chosenIngredients.value) obj.isActive = false
		let group = chosenIngredients.value.find(obj => obj.name === subRecipe)
		group.isActive = true
		target.value = subRecipe
		console.log(target.value)
	}

	const addSubRecipe = () => {
		let sr = {
			name: subRecipeInput.value,
			ingredients: [],
			isActive: false
		}

		chosenIngredients.value.push(sr)
		subRecipeInput.value = null
	}

	const ingredientToRecipe = (id) => {
		console.log('ing to pantry id ', id)

		let ingredient = pantryIngredients.value.find(obj => obj.id == id)

		removeIngredient(id, pantryIngredients.value)

		ingredient.subRecipe = target.value

		let chosenGroup = chosenIngredients.value.find(obj => obj.name == target.value)

		chosenGroup.ingredients.push(ingredient)

		// chosenIngredients.value[target.value].ingredients.push(ingredient[0])

		// if (!ingredient[0].subRecipe) {
		// 	console.log('not')
		// }

		// console.log('ing subRecipe: ', ingredient.subRecipe)

		// console.log('choose ingredient: ' + ingredient.subRecipe)
	}

	const ingredientToPantry = (id) => {
		// remove ingredient from the recipe and return to pantry array

		const ingredient = chosenIngredients.value.flatMap(group => group.ingredients).find(obj => obj.id == id)
		let group = chosenIngredients.value.find(obj => obj.ingredients.includes(ingredient))

		removeIngredient(ingredient, group.ingredients)
		pantryIngredients.value.push(ingredient)
	}

	const removeIngredient = (id, arr) => {

		let index = arr.indexOf(arr.find(obj => obj.id === id))

		arr.splice(index, 1)
	}

	const fetchIngredients = async () => {
		// populate pantry with ingredients from DB

		let response = await fetch('/api/ingredients')
		let data = await response.json()

		pantryIngredients.value = data
	}

	const createIngredientModal = (search) => {
		// render modal for new ingredients

		searchText.value = search
		ingredientModal.value = true
	}

	const ingredientCreated = (ingredient) => {
		// add created ingredient to pantry and remove modal

		pantryIngredients.value.unshift(ingredient)
		ingredientModal.value = false
	}

	const cancelIngredient = () => {
		ingredientModal.value = false
	}

	const onChange = (img) => {
		// runs when picture-input value changes

    	console.log('New picture selected!')
        if (img) {

        console.log('Picture loaded.')

        image.value = pictureInput.value.file

        } else {
        console.log('FileReader API not supported: use the <form>, Luke!')
      }
    }

    const postRecipe = async () => {
	// including 'Content-Type' breaks the POST request

	const data = await buildForm()

	console.log(data)

	const response = await fetch('/api/recipe/create', {

		method: 'POST',

		headers: {
		    'Accept': 'application/json',
			'X-CSRF-Token': csrf
		},

		body: data

		})
		.then(res => res.json())
		.catch(error => console.error('error: ' + error))
		
		console.log(response)
    }

    const buildForm = () => {

    	const data = new FormData()

    	data.append('title', title.value)
    	console.log('title ', title.value)
    	data.append('description', description.value)
    	data.append('directions', directions.value)

    	const ingredients = getReqIngredients()

    	console.log('ingredients: ' + JSON.stringify(ingredients))

    	for (var i = ingredients.length - 1; i >= 0; i--) {
    		console.log('adding ' + JSON.stringify(ingredients[i]))
    		
    		data.append('ingredients[]', JSON.stringify(ingredients[i]))
    	}

    	if (image.value) {
    		data.append('image', image.value)
    	}

    	return data
    }

    const getReqIngredients = () => {
    	// map ingredient ids with pivot table attributes

    	return chosenIngredients.value.flatMap(obj => obj.ingredients).map(i => {

    		// set some default values
    		if (!i.qty) {
    			i.qty = 0
    		}

    		if (!i.unit) {
    			i.unit = 'N/A'
    		}

    		if (!i.subRecipe) {
    			i.subRecipe = 'main'
    		}

    		return {
    			id: i.id,
    			qty: i.qty,
    			unit: i.unit,
    			subRecipe: i.subRecipe
    		}
		})
    }

    onMounted(() => {
    	fetchIngredients()
    })

</script>