<template>
    <div>
        <h1 class="text-3xl">Recipe List</h1>
        <div class="w-10/12 flex flex-col items-center md:grid md:grid-cols-3 gap-y-5 place-items-center">
            
            <RecipeCardSmall v-for="recipe in recipes" :key="recipe.id" :recipe="recipe" />         
        </div>
    </div>
        
    
    
</template>

<script>
    import RecipeCardSmall from '../components/RecipeCardSmall.vue'

    export default {

        components: {
            RecipeCardSmall,
        },
        props: {
            
        },

        data() {
            return {
                recipes: [],

            }
            
        },

        created() {
            this.fetchRecipes()
        },

        methods: {
            async fetchRecipes() {
                let url = '/api/recipe'
                let recipes = await fetch(url)
                .then(res => res.json())
                .then(res => this.recipes = res)
                .catch(err => console.log(err))
                
                // console.log(this.recipes)
            }
        }



        // setup() {

        //     // initialize reactive ref objects
        //     const id = ref(1)
        //     const recipe = ref(null)
        //     const loading = ref(true)
        //     const error = ref(null)
        //     const publicPath = process.env.BASE_URL

        //     // fetch a single recipe in json format
        //     const fetchData = async () => {

        //         const info = await fetch('./api/recipe/'+ id.value, {
        //                 method: 'get',
        //                 headers: {
        //                     'content-type': 'application/json'
        //                 }
        //             })
        //         .then(res => res.json())
        //         .catch((error) => {
        //             console.error('Error: ', error)
        //         })
        //         return info

        //         // console.log(recipe.value)

        //     }

        //     const changeData = () => {
        //         id.value++
        //         fetchData(id)
        //         .then(data => recipe.value = data)
        //         console.log(id.value)
        //     }

        //     const logRecipe = () => {
        //         console.log(recipe.value)
        //     }

        //     fetchData(id)
        //     .then(data => recipe.value = data)
        //     .catch((error) => {
        //         console.error(error)
        //     })

        //     return {
        //         recipe,
        //         loading,
        //         error,
        //         fetchData,
        //         changeData,
        //         publicPath,
        //         logRecipe
        //     }

        //     // let recipe = async() => { await fetch('./api/recipe/first')
        //     // .then(res => res.json())
        //     // .then(data => return)
                
        //     // }


        // }
    }
</script>
