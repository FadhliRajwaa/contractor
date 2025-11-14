# ⚡ Quick Start Guide

Panduan cepat untuk menjalankan ContractorApp dalam 5 menit!

## 🚀 Step-by-Step (Copy & Paste)

### 1️⃣ Install Dependencies

```bash
cd e:/Xampp/htdocs/contractor
composer install
npm install
```

### 2️⃣ Setup Environment

```bash
copy .env.example .env
php artisan key:generate
```

### 3️⃣ Configure Database

Edit `.env`:
```env
DB_DATABASE=contractor
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:
```bash
mysql -u root -p -e "CREATE DATABASE contractor;"
```

### 4️⃣ Setup Database & Roles

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate:fresh --seed
```

### 5️⃣ Start Application

Terminal 1:
```bash
php artisan serve
```

Terminal 2:
```bash
npm run dev
```

### 6️⃣ Login

Buka browser: **http://localhost:8000**

**Login dengan:**
- Email: `superadmin@contractor.test`
- Password: `password123`

## ✅ Selesai!

Anda sekarang sudah bisa:
- ✅ Login sebagai superadministrator
- ✅ Mengakses dashboard
- ✅ Mengelola user (create, edit, delete)
- ✅ Mengatur roles & permissions

## 🎯 Next Steps

1. **Ganti password** superadmin setelah login pertama
2. **Buat user baru** dengan role berbeda untuk testing
3. **Explore dashboard** dan fitur-fitur yang tersedia
4. **Baca dokumentasi** lengkap di `README.md`

## 🔧 Troubleshooting Cepat

**Error Spatie Permission:**
```bash
composer require spatie/laravel-permission
php artisan config:clear
```

**Error Vite:**
```bash
npm install
npm run dev
```

**Error Migration:**
```bash
php artisan migrate:fresh --seed
```

---

📚 **Dokumentasi Lengkap:** Lihat [README.md](README.md) dan [INSTALLATION.md](INSTALLATION.md)
