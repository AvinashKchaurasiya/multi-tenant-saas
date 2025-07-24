<template>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Login</h3>
            <form @submit.prevent="login">
                <div class="mb-3">
                    <input v-model="email" class="form-control" placeholder="Email" type="email" required />
                </div>
                <div class="mb-3">
                    <input v-model="password" class="form-control" placeholder="Password" type="password" required />
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="mt-3 text-center">
                New user?
                <router-link to="/register">Register</router-link>
            </p>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { useRouter } from 'vue-router'
import { ref } from 'vue'

export default {
    setup() {
        const router = useRouter()
        const email = ref('')
        const password = ref('')

        const login = async () => {
            try {
                const res = await axios.post('http://127.0.0.1:8000/api/login', {
                    email: email.value,
                    password: password.value
                })

                localStorage.setItem('token', res.data.token)
                router.push('/dashboard')
            } catch (err) {
                alert('Login failed')
            }
        }

        return { email, password, login }
    }
}
</script>
