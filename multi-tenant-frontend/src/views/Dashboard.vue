<template>
    <div>
        <!-- Summary Info -->
        <div class="container mt-3">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    <strong>Active Company:</strong> {{ activeCompanyName || 'None Selected' }}
                </div>
                <div>
                    <strong>Total Companies:</strong> {{ totalCompanies }}
                </div>
            </div>
        </div>

        <!-- Projects Table -->
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>📋 Projects List</h2>
                <router-link to="/project/create" class="btn btn-success">
                    ➕ Add Project
                </router-link>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="projects.length === 0">
                            <td colspan="4" class="text-center">No projects found</td>
                        </tr>
                        <tr v-for="(project, index) in projects" :key="project.id">
                            <td>{{ index + 1 + (pagination.current_page - 1) * pagination.per_page }}</td>
                            <td>{{ project.name }}</td>
                            <td>
                                <router-link :to="{ name: 'EditProject', params: { id: project.id } }"
                                    class="btn btn-sm btn-primary me-1">
                                    Edit
                                </router-link>
                                <button class="btn btn-sm btn-danger" @click="deleteProject(project.id)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav v-if="pagination.total > pagination.per_page" class="mt-3">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ disabled: !pagination.prev_page_url }">
                        <a class="page-link" href="#"
                            @click.prevent="fetchSummary(pagination.current_page - 1)">Previous</a>
                    </li>
                    <li class="page-item" :class="{ disabled: !pagination.next_page_url }">
                        <a class="page-link" href="#"
                            @click.prevent="fetchSummary(pagination.current_page + 1)">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            activeCompanyName: '',
            totalCompanies: 0,
            projects: [],
            pagination: {
                current_page: 1,
                per_page: 5,
                total: 0,
                next_page_url: null,
                prev_page_url: null
            }
        };
    },
    async mounted() {
        await this.fetchSummary(1);
    },
    methods: {
        async fetchSummary(page = 1) {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`http://127.0.0.1:8000/api/projects-details?page=${page}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                this.activeCompanyName = response.data.active_company_name;
                this.totalCompanies = response.data.total_companies;

                const projectData = response.data.projects;
                this.projects = projectData.data;
                this.pagination = {
                    current_page: projectData.current_page,
                    per_page: projectData.per_page,
                    total: projectData.total,
                    next_page_url: projectData.next_page_url,
                    prev_page_url: projectData.prev_page_url
                };
            } catch (error) {
                console.error('Failed to fetch summary:', error);
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString();
        },
        editProject(projectId) {
            alert(`Edit Project ID: ${projectId}`);
            // You can redirect or open a modal here
        },
        async deleteProject(projectId) {
            if (!confirm("Are you sure you want to delete this project?")) return;

            try {
                const token = localStorage.getItem('token');
                await axios.delete(`http://127.0.0.1:8000/api/projects/${projectId}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                alert("Project deleted successfully!");
                this.fetchSummary(this.pagination.current_page); // Refresh current page
            } catch (error) {
                console.error("Delete failed:", error);
                alert("Failed to delete project.");
            }
        }
    }
};
</script>
