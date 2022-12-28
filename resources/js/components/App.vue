<template>
	<main class="bg-base-200 min-h-screen pt-20">
		<HeaderNav />
		<router-view />
	</main>
	
</template>

<script setup>
	import HeaderNav from './HeaderNav.vue'
	import { useUserStore } from '../stores/UserStore'
	import { ref, provide, onMounted } from 'vue'

	provide('userStore', useUserStore())

	const updateUser = (data) => {
		store.$reset
		console.log('updating userStore')
		store.$patch({
			name: data.name,
			userId: data.userId,
			permission: data.permission,
			loggedIn: true
		})

		console.log(store.name)
	}

	const fetchUser = async () => {
		const settings = {
			method: 'GET',

			headers: {
				credentials: 'include',
				'origin': 'same-origin',
				'Content-Type': 'application/json',
				'Accept': 'application/json',
			}
		}

		const res = await fetch('/api/user/get', settings)
		console.log('fetchUser res ', res)
		const data = await res.json()
		console.log('fetchUser data ', data)
	}

	onMounted(() => {
		fetchUser()

	})
</script>

<style>
	@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;500&display=swap');

	body {
		font-family: 'Quicksand', sans-serif;
	}
	
</style>