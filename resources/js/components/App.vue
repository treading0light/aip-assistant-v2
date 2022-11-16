<template>
	<main class="bg-red-100 min-h-screen">
		<HeaderNav />
		<router-view />
	</main>
	
</template>

<script setup>
	import HeaderNav from './HeaderNav.vue'
</script>