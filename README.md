# ContractorApp 🏗️

Aplikasi web modern untuk manajemen perusahaan contractor menggunakan Laravel 12, MySQL, dan TailwindCSS.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-v4-38bdf8)

## 📋 Fitur

- ✅ **Autentikasi Login** - Sistem login yang aman dengan rate limiting
- ✅ **Role-based Access Control** - Menggunakan Spatie Laravel Permission
- ✅ **User Management** - CRUD lengkap untuk manajemen user (khusus superadministrator)
- ✅ **Modern UI** - Desain responsif dengan TailwindCSS v4 dan palet warna khusus
- ✅ **Dashboard** - Dashboard informatif dengan statistik real-time
- ✅ **Mobile Friendly** - Sidebar collapsible untuk pengalaman mobile yang optimal

## 🎨 Palet Warna

Aplikasi ini menggunakan palet warna brand custom:
- **Primary**: `#CD2C58` (brand-500)
- **Secondary**: `#E06B80` (brand-400)
- **Accent**: `#FFC69D` (brand-200)
- **Light**: `#FFE6D4` (brand-50)

## 🚀 Quick Start

### Prerequisites

- PHP 8.2 atau lebih tinggi
- Composer
- MySQL 5.7+ atau MariaDB 10.3+
- Node.js & NPM (untuk build assets)

### Instalasi

1. **Clone repository** (atau sudah ada di folder ini)
```bash
cd e:/Xampp/htdocs/contractor
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Setup environment**
```bash
copy .env.example .env
```

5. **Generate application key**
```bash
php artisan key:generate
```

6. **Konfigurasi database** di file `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contractor
DB_USERNAME=root
DB_PASSWORD=
```

7. **Buat database MySQL**
```sql
CREATE DATABASE contractor;
```

8. **Run migrations & seeders**
```bash
php artisan migrate:fresh --seed
```

9. **Publish Spatie Permission config**
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

10. **Build assets**
```bash
npm run dev
```

11. **Start development server**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👤 Default Superadministrator

Setelah menjalankan seeder, login dengan kredensial berikut:

- **Email**: `superadmin@contractor.test`
- **Password**: `password123`

> ⚠️ **PENTING**: Segera ganti password setelah login pertama kali!

## 📁 Struktur Proyek

```
contractor/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   └── LoginController.php
│   │       ├── DashboardController.php
│   │       └── UserManagementController.php
│   └── Models/
│       └── User.php (dengan HasRoles trait)
├── database/
│   ├── migrations/
│   │   └── 0001_01_01_000000_create_users_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolePermissionSeeder.php
│       └── SuperAdminSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css (TailwindCSS config)
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       └── users/
│           ├── index.blade.php
│           └── _form.blade.php
├── routes/
│   └── web.php
├── tests/
│   └── Feature/
│       └── LoginTest.php
└── tailwind.config.js
```

## 🔐 Roles & Permissions

Aplikasi ini memiliki 4 role bawaan:

1. **superadministrator** - Akses penuh ke semua fitur
2. **admin** - Dapat melihat dan mengelola user (terbatas)
3. **contractor** - Akses ke dashboard dan modul contractor (future)
4. **viewer** - Hanya dapat melihat data (read-only)

Permissions yang tersedia:
- `view users`, `create users`, `edit users`, `delete users`
- `view roles`, `create roles`, `edit roles`, `delete roles`
- `view dashboard`

## 🧪 Testing

Jalankan test dengan perintah:

```bash
php artisan test
```

Atau test spesifik:

```bash
php artisan test --filter LoginTest
```

## 📱 Mobile Responsiveness

Aplikasi ini sepenuhnya responsif dengan fitur:
- Sidebar yang dapat di-collapse di mobile
- Tabel dengan horizontal scroll
- Tombol aksi yang menjadi dropdown di layar kecil
- Touch-friendly button sizes

## 🎯 Roadmap

Modul yang akan datang:
- [ ] Projects Management
- [ ] Finance & Invoicing
- [ ] Document Management
- [ ] Client Portal
- [ ] Reporting & Analytics

## 🔧 Troubleshooting

### Error: Class 'Spatie\Permission\...' not found

```bash
composer require spatie/laravel-permission
php artisan config:clear
```

### Assets tidak ter-compile

```bash
npm install
npm run build
```

### Migration error

```bash
php artisan migrate:fresh --seed
```

## 📝 License

Proyek ini adalah starter template untuk aplikasi contractor management.

## 👨‍💻 Development

Built with ❤️ using:
- [Laravel 12](https://laravel.com)
- [TailwindCSS v4](https://tailwindcss.com)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Heroicons](https://heroicons.com)
- [Google Fonts - Inter](https://fonts.google.com/specimen/Inter)

---

**Note**: Ini adalah starter implementation. Anda dapat mengembangkannya lebih lanjut sesuai kebutuhan bisnis Anda.
