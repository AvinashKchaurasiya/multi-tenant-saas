import { createRouter, createWebHistory } from "vue-router";

import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Dashboard from "../views/Dashboard.vue";
import Company from "../views/Company.vue";
import CreateCompany from "../views/CreateCompany.vue";

const routes = [
  { path: "/", redirect: "/login" },
  { path: "/login", name: "Login", component: Login },
  { path: "/register", name: "Register", component: Register },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true },
  },
  {
    path: "/companies",
    name: "Company",
    component: Company,
    meta: { requiresAuth: true },
  },
  {
    path: "/companies/create",
    name: "CreateCompany",
    component: CreateCompany,
    meta: { requiresAuth: true },
  },
  {
    path: "/companies/:id/edit",
    name: "EditCompany",
    component: CreateCompany,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Route guard for auth
router.beforeEach((to, from, next) => {
  const isLoggedIn = !!localStorage.getItem("token");
  if (to.meta.requiresAuth && !isLoggedIn) {
    next("/login");
  } else {
    next();
  }
});

export default router;
