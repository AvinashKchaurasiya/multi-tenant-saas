# Laravel + Vue Multi-Company (Multi-Tenant) Application

This is a full-stack web application built with **Laravel (API Backend)** and **Vue.js (Frontend)** that allows a user to create and manage multiple companies under a single account.

---

## 🚀 Features

- User Registration & Login
- JWT Authentication with Sanctum
- Create, Read, Update, Delete (CRUD) operations for Companies
- Each user can manage their own companies
- Pagination support
- Responsive table UI
- Vue Router based navigation

---

## 🛠️ Technologies Used

- **Laravel 12** (Backend API)
- **Sanctum** for authentication
- **MySQL** database
- **Vue 3** with Vue Router
- **Axios** for HTTP requests
- **Bootstrap 5** for styling

---

## 📦 Installation Instructions

Follow these steps after cloning the repository to set up the project on a new system.

---

### ✅ Prerequisites

- PHP >= 8.2
- Composer
- Vue
- MySQL
- Git

---

## 🧾 Clone the Repository

```bash
git clone https://github.com/your-username/your-project.git
cd your-project

cd multi-tenant-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve


cd ../multi-tenant-frontend
npm install
npm run dev
```
