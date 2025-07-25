<template>
    <div class="container mt-5">
        <h2>{{ isEdit ? '✏️ Edit Project' : '➕ Add New Project' }}</h2>

        <form @submit.prevent="submitForm">
            <!-- Project Name -->
            <div class="mb-3">
                <label class="form-label">Project Name</label>
                <input type="text" v-model="form.name" class="form-control" :class="{ 'is-invalid': errors.name }" />
                <div v-if="errors.name" class="invalid-feedback">
                    {{ errors.name[0] }}
                </div>
            </div>

            <!-- Submit & Back Buttons -->
            <button type="submit" class="btn btn-primary" :disabled="loading">
                {{ isEdit ? 'Update' : 'Save' }}
            </button>
            <router-link to="/projects" class="btn btn-secondary ms-2">Back</router-link>
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
            },
            isEdit: false,
            errors: {},
            loading: false
        };
    },
    mounted() {
        const projectId = this.$route.params.id;
        if (projectId) {
            this.isEdit = true;
            this.fetchProject(projectId);
        }
    },
    methods: {
        async fetchProject(id) {
            const token = localStorage.getItem('token');
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/edit-projects/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.form = {
                    name: response.data.name,
                };
            } catch (error) {
                console.error('Error fetching project:', error);
                this.$router.push('/dashboard');
            }
        },

        async submitForm() {
            this.loading = true;
            const token = localStorage.getItem('token');
            const headers = {
                Authorization: `Bearer ${token}`
            };

            try {
                if (this.isEdit) {
                    await axios.put(`http://127.0.0.1:8000/api/projects/${this.$route.params.id}`, this.form, { headers });
                } else {
                    await axios.post('http://127.0.0.1:8000/api/projects', this.form, { headers });
                }

                this.errors = {};
                this.$router.push('/dashboard');
            } catch (error) {
                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error("Unexpected error", error);
                }
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
