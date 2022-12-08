<template>
	<!-- component intended for two uses, one to display
	all available ingredients, and one to display chosen ingredients
	for newly created recipe -->

	<div class="relative rounded">

		<h2 class="font-bold pb-3">Ingredients:</h2>

		<ul>
			<li v-for="ingredient in ingredients" :key="ingredient.id" class="flex gap-5">
				<p class="hover:cursor-pointer" @click="remove(ingredient.id)">{{ ingredient.name }}
				</p>

				<info-modal v-if="ingredient.description" :title="ingredient.name" :info="ingredient.description" ></info-modal>

				<input type="number" placeholder="Qty" v-model="ingredient.qty" class="input input-bordered w-1/6 text-2xl">

				<input type="text" placeholder="Unit" v-model="ingredient.unit" class="input input-bordered w-1/6 text-2xl">
			</li>
		</ul>

		<div v-if="subRecipes === true">
			<ul v-for="subRecipe in subRecipes" :key="subRecipe.name">
				<li v-for="ingredient in subRecipe.ingredients" :key="ingredient.id"></li>
			</ul>
			
		</div>
	</div>

</template>

<script>
	import InfoModal from './InfoModal.vue'

	export default {
		props: {
			ingredients: Array,
			subRecipes: Object,
		},

		data() {
			return {
				
			}
		},
		
		methods: {
			remove: function (id) {
				this.$emit('ingredient-to-pantry', id)
				console.log('tray: ' + id)
			}
		},

		components: {
			InfoModal
		},

		mounted() {
			// console.log('tray array: ' + this.ingredients)
		},
	}
</script>

<style scoped>
</style>