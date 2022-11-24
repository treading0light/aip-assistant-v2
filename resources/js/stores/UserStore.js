import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useUserStore = defineStore('UserStore', () => {
	const name = ref('')
	const userId = ref(null)
	const permission = ref('')
	const loggedIn = ref(false)

	return { name, userId, permission, loggedIn }
})