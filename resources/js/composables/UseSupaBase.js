import { createClient } from '@supabase/supabase-js'

const supabaseUrl = import.meta.env.VITE_SUPABASE_URL
// const supabaseAnonKey = import.meta.env.VITE_SUPABASE_ANON_KEY
const supabaseAnonKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im11aXZxYWdsd3B5eWNpb2hpa2txIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzIyNDk1MzQsImV4cCI6MTk4NzgyNTUzNH0.0dgXgsoCnq8UItsPeXuTjRpR5eoW3jVaIVOU8uY5XY8'
const supabase = createClient(supabaseUrl, supabaseAnonKey)
console.log('from the compos ', supabase)

export default function useSupaBase() {
	return supabase
}