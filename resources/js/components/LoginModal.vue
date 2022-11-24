<template>
	<div class="w-1/2 fixed top-1/2 left-1/2 flex flex-col gap-2 bg-base-200">

		<div v-if="message" class="text-red-400">
			<p>{{ message }}</p>
		</div>

		<div v-if="action === 'login'" class="flex flex-col gap-2">
			<h1>Login</h1>
			<input type="text" name="email" placeholder="email" v-model="credentials.email">
			<input type="password" name="password" placeholder="password" v-model="credentials.password">
			<div>
				<button class="btn btn-primary" @click="checkSubmit">Submit</button>
				<button class="btn btn-primary" @click="action = 'register'">New Account</button>
			</div>
		</div>

		<div v-if="action === 'register'" class="flex flex-col gap-2">
			<h1>Register</h1>
			<input type="text" name="name" placeholder="name" v-model="credentials.name">
			<input type="text" name="email" placeholder="email" v-model="credentials.email">
			<input type="password" name="password" placeholder="password" v-model="credentials.password">
			<input type="password" name="passwordConfirm" placeholder="confirm password"
			v-model="passwordConfirm" >
			<div>
				<button class="btn btn-primary" @click="checkSubmit">Submit</button>
				<button class="btn btn-primary" @click="action = 'login'">Existing User</button>
			</div>
			
		</div>

	</div>
	
</template>

<script setup>
	import { useUserStore } from '../stores/UserStore'
	import { ref, watch, onMounted } from 'vue'

	const store = useUserStore()

	const confirmedPassword = ref(false)
	const passwordConfirm = ref('')
	const message = ref(null)
	const action = ref('login')
	const csrf = ref(null)

	const credentials = {
		email: '',
		password: '',
		name: ''
	}

	watch(passwordConfirm, (newVal, oldVal) => {
		if (newVal === credentials.password) {
			console.log('password match!')
			confirmedPassword.value = true
		} else {
			confirmedPassword.value = false
		}
	})

	// const compare = () => {
	// 	console.log('comparing')
	// 	if (passwordConfirm === credentials.password) {
	// 		confirmedPassword.value = true
	// 	} else {
	// 		confirmedPassword.value = false
	// 	}
	// } 

	const updateUser = (data) => {
		store.$patch({
			name: data.name,
			userId: data.userId,
			permission: data.permission,
			loggedIn: true
		})
	}

	const updateMessage = (msg) => message.value = msg

	const checkSubmit = async () => {
		const settings = {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
	            'X-CSRF-Token': csrf.value
			},
			body: JSON.stringify(credentials)
		}

		console.log('action', action.value)

		if (action.value === 'login') {
			console.log('login')
			submit('login', settings)

		} else {
			console.log('register')
			console.log('password', confirmedPassword.value)
			if (confirmedPassword.value === true) {
				submit('register', settings)
			} else {
				console.log('confirm', false)
				// updateMessage('Passwords do not match')
				message.value = 'Passwords do not match'
			}
		}
	}

	const submit = async (string, settings) => {
		console.log('submitting')
		let url = `/api/${string}/`
		const res = await fetch(url, settings)
		console.log(res)
		// const data = await res.json()
		// .then((data.message === 'success') ? updateUser(data) : updateMessage(data.message))

		// (data.message === 'success') ? updateUser(data) : updateMessage(data.message)
	}

	onMounted(() => {
		csrf.value = document.querySelector("meta[name='csrf-token']").getAttribute('content')
		console.log(csrf.value)
		updateMessage('test')
	})
</script>