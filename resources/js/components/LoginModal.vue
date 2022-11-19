<template>
	<div class="w-1/2 fixed top-1/2 left-1/2 flex flex-col gap-2 bg-base-200">
		<h1>Login here</h1>
		<input type="text" name="email" placeholder="email" v-model="loginCred.email">
		<input type="password" name="password" placeholder="password" v-model="loginCred.password">
		<button class="btn btn-primary" @click="submitLogin">Submit</button>
	</div>
</template>

<script setup>
	const loginCred = {
		email: '',
		password: ''
	}

	const submitLogin = async () => {
		const settings = {
			method: 'POST',
			headers: {
				Accept: 'application/json',
	            'Content-Type': 'application/json',
			},
			body: JSON.stringify(loginCred)
		}
		let res = await fetch('/api/login', settings)

		const message = await res.json()
		console.log(message)
	}
</script>