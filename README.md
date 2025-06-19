# Assesment
This is Creative tech Park Assesment test
# Laravel 12.2 + Vue 3 + Inertia.js + Tailwind CSS Starter

This is a modern full-stack web application using **Laravel 12.2**, **Vue 3**, **Inertia.js**, and **Tailwind CSS**. It supports multi-category products, clean architecture, and a fully SPA-like experience.

---

## 🔧 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM or Yarn
- MySQL / PostgreSQL
- Laravel 12.2
- Git
- [Optional] Docker

---

## 🚀 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/your-laravel-inertia-vue-project.git
cd your-laravel-inertia-vue-project

composer install
cp .env.example .env

APP_NAME="My Laravel App"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password


php artisan key:generate

php artisan migrate --seed

npm install

npm run build

php artisan serve


