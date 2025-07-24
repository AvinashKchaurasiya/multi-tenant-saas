<template>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>📋 Companies List</h2>
            <router-link to="/companies/create" class="btn btn-success">
                ➕ Add Company
            </router-link>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Industry</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(company, index) in companies.data" :key="company.id">
                        <td>{{ index + 1 + (companies.current_page - 1) * companies.per_page }}</td>
                        <td>{{ company.name }}</td>
                        <td>{{ company.address }}</td>
                        <td>{{ company.industry }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary me-1">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav v-if="companies.last_page > 1">
            <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: companies.current_page === 1 }">
                    <a class="page-link" href="#"
                        @click.prevent="fetchCompanies(companies.current_page - 1)">Previous</a>
                </li>

                <li class="page-item" v-for="page in companies.last_page" :key="page"
                    :class="{ active: page === companies.current_page }">
                    <a class="page-link" href="#" @click.prevent="fetchCompanies(page)">{{ page }}</a>
                </li>

                <li class="page-item" :class="{ disabled: companies.current_page === companies.last_page }">
                    <a class="page-link" href="#" @click.prevent="fetchCompanies(companies.current_page + 1)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            companies: {
                data: [],
                current_page: 1,
                last_page: 1,
                per_page: 10
            }
        }
    },
    mounted() {
        this.fetchCompanies(1)
    },
    methods: {
        async fetchCompanies(page = 1) {
            try {
                const token = localStorage.getItem('token')
                const res = await axios.get(`http://127.0.0.1:8000/api/companies?page=${page}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                })
                this.companies = res.data
            } catch (error) {
                console.error('Error fetching companies:', error)
            }
        }
    }
}
</script>

<style scoped>
.table-responsive {
    border-radius: 10px;
    overflow: hidden;
}

.table th,
.table td {
    vertical-align: middle;
}
</style>
