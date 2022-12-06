<template>
    <div class="flex flex-col items-center">
        <h1 class="text-3xl text-center mb-10">Recipe List</h1>
        <div class="w-10/12 flex flex-col items-center md:grid md:grid-cols-3 gap-y-5 place-items-center">
            
            <RecipeCardSmall v-for="recipe in recipes" :key="recipe.id" :recipe="recipe" />         
        </div>
    </div>
        
    
    
</template>

<script setup>
    import RecipeCardSmall from '../components/RecipeCardSmall.vue'
    import { onMounted, ref } from 'vue'

    const recipes = ref([])

    const fetchRecipes = async () => {
        let data = await fetch('/api/recipe')
        .catch(err => console.error(err))

        return await data.json()
    }

    onMounted(async () => {
        recipes.value = await fetchRecipes()
        console.log(recipes.value)
    })
</script>
