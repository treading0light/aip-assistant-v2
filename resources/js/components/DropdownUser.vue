<template>
	<div id="dropdown" class="dropdown dropdown-end">
	    <label tabindex="0" class="btn btn-ghost rounded-btn"
	    >{{ name }}</label>
	    <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4 text-base">
	      <li @click="logout">Logout</li>
	    </ul>
	  </div>
</template>

<script setup>
	// import { defineProps } from 'vue'
	const props = defineProps({
			name: String
		})

	const logout = async () => {
		let response = await fetch('/api/user/logout')
		.catch(error => console.error('error: ' + error))

		console.log(response)
	}
</script>