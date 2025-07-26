<template>
    <div class="container mt-5">
        <h2>{{ isEdit ? '✏️ Edit Company' : '➕ Add New Company' }}</h2>
        <form @submit.prevent="submitForm">
            <!-- Company Name -->
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" v-model="form.name" class="form-control" :class="{ 'is-invalid': errors.name }" />
                <div v-if="errors.name" class="invalid-feedback">
                    {{ errors.name[0] }}
                </div>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" v-model="form.address" class="form-control"
                    :class="{ 'is-invalid': errors.address }" />
                <div v-if="errors.address" class="invalid-feedback">
                    {{ errors.address[0] }}
                </div>
            </div>

            <!-- Industry -->
            <div class="mb-3">
                <label class="form-label">Industry</label>
                <input type="text" v-model="form.industry" class="form-control"
                    :class="{ 'is-invalid': errors.industry }" />
                <div v-if="errors.industry" class="invalid-feedback">
                    {{ errors.industry[0] }}
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ isEdit ? 'Update' : 'Save' }}</button>
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
            },
            isEdit: false,
            errors: {},
        };
    },
    mounted() {
        const companyId = this.$route.params.id;
        if (companyId) {
            this.isEdit = true;
            this.fetchCompany(companyId);
        }
    },
    methods: {
        async fetchCompany(id) {
            const token = localStorage.getItem('token');
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/companies/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.form = response.data;
            } catch (error) {
                console.error('Error fetching company:', error);
            }
        },

        async submitForm() {
            const token = localStorage.getItem('token');
            const headers = {
                Authorization: `Bearer ${token}`
            };

            try {
                if (this.isEdit) {
                    // Update company
                    await axios.put(`http://127.0.0.1:8000/api/companies/${this.$route.params.id}`, this.form, { headers });
                } else {
                    // Create new company
                    await axios.post('http://127.0.0.1:8000/api/companies', this.form, { headers });
                }
                this.errors = {};
                this.$router.push('/companies');
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error("Unexpected error", error);
                }
            }
        }
    }
};
</script>
