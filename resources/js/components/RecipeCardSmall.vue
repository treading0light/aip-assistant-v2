<template>	

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