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
                            <router-link :to="{ name: 'EditCompany', params: { id: company.id } }"
                                class="btn btn-sm btn-primary me-1">
                                Edit
                            </router-link>

                            <!-- Delete Button -->
                            <button class="btn btn-sm btn-danger" @click="deleteCompany(company.id)">
                                Delete
                            </button>

                            <!-- switch button -->
                            <button class="btn btn-sm ms-1"
                                :class="company.id === active_company_id ? 'btn-success' : 'btn-info'"
                                @click="switchCompany(company.id)">
                                {{ company.id === active_company_id ? 'Active' : 'Switch' }}
                            </button>
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
            },
            active_company_id: null
        };
    },
    methods: {
        async fetchCompanies(page = 1) {
            try {
                const token = localStorage.getItem('token');
                const res = await axios.get(`http://127.0.0.1:8000/api/companies?page=${page}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.companies = res.data.companies;
                this.active_company_id = res.data.active_company_id;
            } catch (error) {
                console.error('Error fetching companies:', error);
            }
        },

        async deleteCompany(id) {
            if (!confirm("Are you sure you want to delete this company?")) return;

            try {
                const token = localStorage.getItem("token");

                await axios.delete(`http://127.0.0.1:8000/api/companies/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                this.fetchCompanies(this.companies.current_page);
            } catch (error) {
                console.error("Failed to delete company:", error);
            }
        },
        async switchCompany(id) {
            if (!confirm("Are you sure you want to switch to this company?")) return;

            try {
                const token = localStorage.getItem("token");

                const response = await axios.post(
                    `http://127.0.0.1:8000/api/companies/${id}/set-active`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );

                localStorage.setItem("company_id", id);
                localStorage.setItem("company_name", response.data.company_name ?? '');

                this.active_company_id = id;

                this.$router.push({ name: 'Companies' });
            } catch (error) {
                console.error("Failed to switch company:", error);
            }
        }

    },
    mounted() {
        this.fetchCompanies(1);
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
