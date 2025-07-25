<template>
    <div>
        <!-- Info below navbar -->
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
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            activeCompanyName: '',
            totalCompanies: 0
        };
    },
    async mounted() {
        await this.fetchSummary();
    },
    methods: {
        async fetchSummary() {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('http://127.0.0.1:8000/api/active-company-summary', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                this.activeCompanyName = response.data.active_company_name;
                this.totalCompanies = response.data.total_companies;
            } catch (error) {
                console.error('Failed to fetch summary:', error);
            }
        }
    }
}
</script>
