# 📖 Panduan Instalasi ContractorApp

Dokumen ini berisi langkah-langkah detail untuk menginstall dan menjalankan ContractorApp.

## ✅ Checklist Prerequisites

Pastikan Anda sudah menginstall:
- [x] PHP 8.2+ (cek dengan `php -v`)
- [x] Composer (cek dengan `composer -V`)
- [x] MySQL 5.7+ atau MariaDB 10.3+ (cek dengan `mysql --version`)
- [x] Node.js 18+ dan NPM (cek dengan `node -v` dan `npm -v`)
- [x] XAMPP atau web server lainnya (optional)

## 🚀 Langkah Instalasi

### Step 1: Install Dependencies

Buka terminal di folder proyek (`e:/Xampp/htdocs/contractor`) dan jalankan:

```bash
# Install PHP packages
composer install

# Install Node packages
npm install
```

**Expected Output:**
- Composer akan menginstall Laravel dan dependencies termasuk `spatie/laravel-permission`
- NPM akan menginstall Vite, TailwindCSS v4, dan dependencies lainnya

### Step 2: Setup Environment File

```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

### Step 3: Generate Application Key

```bash
php artisan key:generate
```

Output: `Application key set successfully.`

### Step 4: Konfigurasi Database

Edit file `.env` dan sesuaikan dengan konfigurasi MySQL Anda:

```env
APP_NAME=ContractorApp
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contractor
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Buat Database

Buka MySQL Command Line atau phpMyAdmin dan jalankan:

```sql
CREATE DATABASE contractor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau via command line:

```bash
mysql -u root -p -e "CREATE DATABASE contractor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 6: Publish Spatie Permission

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Ini akan membuat:
- `config/permission.php`
- Migrations untuk roles dan permissions

### Step 7: Run Migrations & Seeders

```bash
php artisan migrate:fresh --seed
```

**Apa yang terjadi:**
1. Membuat tabel `users`, `sessions`, `password_reset_tokens`
2. Membuat tabel `roles`, `permissions`, `model_has_roles`, dll (dari Spatie)
3. Menjalankan `RolePermissionSeeder` - membuat roles dan permissions
4. Menjalankan `SuperAdminSeeder` - membuat superadmin user

**Expected Output:**
```
✅ Super Administrator berhasil dibuat!
📧 Email: superadmin@contractor.test
🔑 Password: password123
⚠️  PENTING: Ganti password ini setelah login pertama!
```

### Step 8: Build Frontend Assets

```bash
# Development mode (dengan file watching)
npm run dev

# Atau production build
npm run build
```

### Step 9: Start Development Server

Buka terminal baru dan jalankan:

```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

## 🔐 Login Pertama

Buka browser dan akses `http://localhost:8000`

**Kredensial Default:**
- Email: `superadmin@contractor.test`
- Password: `password123`

## ✅ Verifikasi Instalasi

### Test 1: Jalankan Unit Tests

```bash
php artisan test
```

Jika semua test pass (hijau), instalasi berhasil!

### Test 2: Cek Routes

```bash
php artisan route:list
```

Anda harus melihat routes:
- `GET /` → login page
- `POST /login` → login handler
- `GET /dashboard` → dashboard (auth required)
- `GET /users` → user management (role required)

### Test 3: Cek Permissions

```bash
php artisan permission:show
```

## 🔧 Troubleshooting

### Error: "Vite manifest not found"

**Solusi:**
```bash
npm install
npm run dev
```
Jangan tutup terminal yang menjalankan `npm run dev`.

### Error: "Class Spatie\Permission\... not found"

**Solusi:**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Error: "Access denied for user"

**Solusi:**
Periksa kredensial database di `.env`:
```env
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Error: "Base table or view not found"

**Solusi:**
```bash
php artisan migrate:fresh --seed
```

### Error: "SQLSTATE[HY000] [1045]"

**Solusi:**
Pastikan MySQL service berjalan:
- Windows: Buka XAMPP Control Panel → Start MySQL
- Linux: `sudo service mysql start`

### Error: Port 8000 already in use

**Solusi:**
```bash
# Gunakan port lain
php artisan serve --port=8080
```

## 🎨 Setelah Instalasi

### 1. Ganti Password Superadmin

Login → Klik avatar → Pengaturan → Ganti Password

### 2. Customize Brand

Edit `resources/css/app.css` untuk mengubah warna brand.

### 3. Tambah User Baru

Login sebagai superadmin → Manajemen User → Tambah User

### 4. Setup Email (Optional)

Jika ingin mengirim email, edit `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 📊 Database Schema

### Tables Created

1. **users** - Data user dengan avatar, notes, is_active
2. **roles** - Role definitions (superadministrator, admin, contractor, viewer)
3. **permissions** - Permission definitions
4. **model_has_roles** - Pivot table user-roles
5. **model_has_permissions** - Pivot table user-permissions
6. **role_has_permissions** - Pivot table role-permissions
7. **sessions** - Session data
8. **password_reset_tokens** - Password reset tokens
9. **cache** - Cache data

## 🔄 Development Workflow

### Daily Development

1. Start servers:
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite Dev Server
npm run dev
```

2. Edit files di `resources/views/`, `app/`, dll.
3. Browser auto-reload saat ada perubahan (hot reload dari Vite)

### Production Deployment

```bash
# Build assets
npm run build

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set environment
APP_ENV=production
APP_DEBUG=false
```

## 📞 Support

Jika mengalami masalah:
1. Cek file log: `storage/logs/laravel.log`
2. Baca dokumentasi Laravel: https://laravel.com/docs
3. Baca dokumentasi Spatie: https://spatie.be/docs/laravel-permission

---

**Selamat! Aplikasi ContractorApp siap digunakan! 🎉**
