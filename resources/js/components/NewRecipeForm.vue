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
				<ingredient-tray 
				v-for="group in chosenIngredients"
				@makeTarget="makeTarget" 
				@ingredient-to-pantry="ingredientToPantry" 
				:ingredients="group"></ingredient-tray>
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
	const chosenIngredients = ref({})
	const subRecipes = ref({})
	let image = ref(null)
	let directions = ref('')
	let srcURL = ref('')
	const searchText = ref(null)
	const ingredientModal = ref(false)
	let message = null
	const target = ref('main')
	const pictureInput = ref(null)

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

	const makeTarget = (target) => {	
		target.value = target
		console.log(target)
	}

	const ingredientToRecipe = (id) => {

		let ingredient = pantryIngredients.value.filter(obj => obj.id == id)

		removeIngredient(id, pantryIngredients.value)

		ingredient.subRecipe = target.value

		chosenIngredients.value.push(ingredient[0])

		// if (!ingredient[0].subRecipe) {
		// 	console.log('not')
		// }

		console.log('ing subRecipe: ', ingredient.subRecipe)

		console.log('choose ingredient: ' + ingredient[0].subRecipe)
	}

	const ingredientToPantry = (id) => {
		const ingredient = chosenIngredients.value.filter(obj => obj.id == id)

		removeIngredient(id, chosenIngredients.value)

		pantryIngredients.value.push(ingredient[0])
		
		console.log('removeIngredient ' + ingredient)
	}

	const removeIngredient = (id, arr) => {
		let index = arr.findIndex(object => 
			object.id === id
		)

		arr.splice(index, 1)
	}

	const fetchIngredients = async () => {
		// populate pantry with ingredients from DB

		await fetch('/api/ingredients')
		.then(res => res.json())
		.then(json => pantryIngredients.value = json)

		// console.log(this.pantryIngredients)
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

    	return chosenIngredients.value.map(i => {

    		// set some default values
    		if (!i.qty) {
    			i.qty = 0
    		}

    		if (!i.unit) {
    			i.unit = 'N/A'
    		}

    		return {
    			id: i.id,
    			qty: i.qty,
    			unit: i.unit
    		}
		})
    }

    onMounted(() => {
    	fetchIngredients()
    })

</script>