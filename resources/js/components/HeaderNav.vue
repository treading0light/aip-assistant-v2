<template>
	<div class="navbar bg-primary mb-10">

    <div class="flex-1 px-2 lg:flex-none">
      <a class="text-2xl font-bold text-secondary">AIP <span class="text-primary-content">Assistant</span></a>
    </div> 

    <div class="flex justify-end flex-1 px-2">
      <div class="flex items-stretch">

        <button @click="toggleLogin" class="btn btn-ghost rounded-btn text-primary-content">LOGIN</button>

        <router-link to="/" class="btn btn-ghost rounded-btn text-primary-content">HOME</router-link>

        <div id="dropdown" class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost rounded-btn text-primary-content"
          >Recipes</label>
          <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4 text-base">
            <li><router-link to="/recipe/all">All Recipes</router-link></li>
            <li><router-link to="/recipe/create">Create New</router-link></li>
          </ul>
        </div>

      </div>
    </div>

    <LoginModal v-if="showLogin" />
  </div>
	
</template>

<script setup>
  import { ref } from 'vue'
  import LoginModal from './LoginModal.vue'

  const showLogin = ref(false)

  const toggleLogin = () => {
    if (showLogin.value == false) showLogin.value = true
    else showLogin.value = false
  }

</script>