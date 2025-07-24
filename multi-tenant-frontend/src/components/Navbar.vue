<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <router-link class="navbar-brand" to="/dashboard">Dashboard</router-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <router-link class="nav-link" to="/companies">Companies</router-link>
        </li>
        <li class="nav-item">
          <button class="btn btn-outline-light ms-3" @click="logout">Logout</button>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import { useRouter } from 'vue-router'

export default {
  setup() {
    const router = useRouter()

    const logout = () => {
      localStorage.removeItem('token')
      router.push('/login')
    }

    return { logout }
  }
}
</script>
