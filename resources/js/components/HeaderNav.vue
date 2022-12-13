<template>
	<div style="z-index: 10;" class="fixed top-0 navbar bg-base-200 mb-10 border-b border-b-2">

    <div class="flex-1 px-2 lg:flex-none">
      <router-link to="/" class="text-2xl font-bold text-secondary">AIP <span class="text-base-content">Assistant</span></router-link>
    </div> 

    <div class="flex justify-end w-full flex-1 px-2">
      
      <router-link to="/" class="btn btn-ghost rounded-btn">HOME</router-link>

      <DropdownNav />

      <DropdownUser v-if="user.name" :name="user.name" />

      <button v-else @click="toggleLogin" class="btn btn-ghost rounded-btn justify-self-end">LOGIN/SIGN UP</button>

      
    </div>

    <Teleport to="body">
      <Suspense>
        <LoginModal v-if="showLogin" @closeModal="toggleLogin" />
      </Suspense>
  </Teleport>
  </div>
	
</template>

<script setup>
  import { ref, inject, onMounted } from 'vue'
  import LoginModal from './LoginModal.vue'
  import DropdownNav from './DropdownNav.vue'
  import DropdownUser from './DropdownUser.vue'

  const showLogin = ref(false)
  const user = inject('userStore')
  console.log(user.name)

  const log = () => console.log('close')

  const toggleLogin = () => {
    if (showLogin.value == false) showLogin.value = true
    else showLogin.value = false
  }

  onMounted(() => {
    // console.log(user)
  })

</script>