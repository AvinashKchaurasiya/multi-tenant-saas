<template>
    <div class="container mt-5">
        <h2>➕ Add New Company</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" v-model="form.name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" v-model="form.address" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Industry</label>
                <input type="text" v-model="form.industry" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <router-link to="/companies" class="btn btn-secondary ms-2">Back</router-link>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            form: {
                name: '',
                address: '',
                industry: ''
            }
        };
    },
    methods: {
        async submitForm() {
            try {
                const token = localStorage.getItem('token');

                await axios.post('http://127.0.0.1:8000/api/companies', this.form, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                this.$router.push('/dashboard');
            } catch (err) {
                console.error('Error saving company:', err);
            }
        }
    }
};
</script>
