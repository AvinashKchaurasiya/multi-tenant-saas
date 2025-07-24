<template>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card p-4 shadow-lg" style="min-width: 400px;">
            <h3 class="text-center mb-4">Register</h3>
            <form @submit.prevent="register">
                <div class="mb-3">
                    <input v-model="name" type="text" class="form-control" placeholder="Name" required />
                </div>
                <div class="mb-3">
                    <input v-model="email" type="email" class="form-control" placeholder="Email" required />
                </div>
                <div class="mb-3">
                    <input v-model="password" type="password" class="form-control" placeholder="Password" required />
                </div>
                <div class="mb-3">
                    <input v-model="confirmPassword" type="password" class="form-control" placeholder="Confirm Password"
                        required />
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="text-center mt-3">
                Already registered? <router-link to="/login">Login</router-link>
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
        const name = ref('')
        const email = ref('')
        const password = ref('')
        const confirmPassword = ref('')

        const register = async () => {
            if (password.value !== confirmPassword.value) {
                alert("Passwords do not match")
                return
            }

            try {
                const res = await axios.post('http://127.0.0.1:8000/api/register', {
                    name: name.value,
                    email: email.value,
                    password: password.value
                })

                localStorage.setItem('token', res.data.token)
                router.push('/dashboard')
            } catch (err) {
                alert('Registration failed')
            }
        }

        return {
            name,
            email,
            password,
            confirmPassword,
            register
        }
    }
}
</script>
