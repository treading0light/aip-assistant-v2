<template>
	<div class="relative rounded overflow-x-auto max-h-80">
		<h2 class="font-bold pb-3">Pantry:</h2>

		<input type="text" v-model="ingredientSearch" placeholder="Search">
		<ul>
			
			<li v-for="ingredient in shownIngredients" :key="ingredient.id" class="relative flex">

				<p class="hover:cursor-pointer" @click="choose(ingredient.id)">{{ ingredient.name }}
				</p>
 
				<info-modal v-if="ingredient.description" :title="ingredient.name" :info="ingredient.description" ></info-modal>
				
			</li>

			<li>
				<button @click="triggerIngredientModal" class="btn btn-secondary btn-primary-focus">CREATE NEW</button>
			</li>
		</ul>

		
	</div>
</template>

<script>
	import InfoModal from './InfoModal.vue'

	export default {
		props: {
			ingredients: Array,
		},

		data() {
			return {
				addNew: false,

				ingredientSearch: '',

				originalIngredients: [],
			}
		},

		computed: {
			shownIngredients() {
				if (this.ingredientSearch == '') {
					return this.ingredients
				} else {
					return this.ingredients.filter(obj => 
						obj.name.includes(this.ingredientSearch)
					)
				}
			},

		},

		methods: {
			choose: function (id) {
				this.$emit('ingredient-to-recipe', id)
				console.log('Pantry choose by id: ' + id)
				this.ingredientSearch = ''
			},

			searchPantry: function () {
				console.log('searching')
				if (this.ingredientSearch == '') {
					this.ingredients = this.originalIngredients
				} else {
					const ingredients = this.ingredients.filter(obj => 
						obj.name.includes(this.ingredientSearch)
					)

					this.ingredients = ingredients
				}
				
			},

			triggerIngredientModal: function () {
				const search = this.ingredientSearch

				this.ingredientSearch = ''
				
				this.$emit('create-ingredient-modal', search)
			}
		},

		mounted() {
			this.originalIngredients = this.ingredients
		},

		components: {
			InfoModal,
		},

		mounted() {
			// console.log('pantry array: ' + this.ingredients)
		},
	}
</script>