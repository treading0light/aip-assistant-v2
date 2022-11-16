<template>
	<!-- <div class="flex flex-col items-center bg-gray-200 gap-1">
		<h1 class="text-2xl">{{ recipe.title }}</h1>
		<img :src="recipe.image">
		<button>{{ buttonText }}</button>

	</div> -->

	<div class="card w-4/5 bg-base-100 shadow-xl">
	  <figure class="px-10 pt-10">
	    <img :src="recipe.image" alt="" class="rounded-xl" />
	  </figure>
	  <div class="card-body items-center text-center">
	    <h2 class="card-title text-3xl">{{ recipe.title }}</h2>
	    <div class="card-actions">
	      <button class="btn btn-primary"><router-link :to="'/recipe/' + recipe.id"> View </router-link></button>
	    </div>
	  </div>
	</div>
	<!-- <h1>Goodbye World</h1> -->

</template>

<script>

	export default {
		name: 'RecipeCardSmall',
		props: {
			recipe: Object,
		},
		data() {
			return {
				buttonText: 'view',
			}
		},
		components: {
		},

		created() {
			console.log(this.recipe)
		}



	} 
	
</script>