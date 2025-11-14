# 🏗️ Contractor Management System

Modern web application untuk manajemen kontraktor dengan dual database support dan deployment-ready architecture.

## ✨ Features

- **🔐 Multi-Role Authentication** - Super Admin, Admin, User management
- **📊 Dual Database Support** - Local MySQL dan Aiven Cloud production database  
- **🎨 Modern UI** - Laravel 11 + Tailwind CSS + Alpine.js
- **☁️ Cloud Ready** - Optimized untuk Vercel serverless deployment
- **🚀 High Performance** - Optimized untuk production environment
- **🔒 Security First** - Environment-based configuration dan secure defaults

## 🛠️ Tech Stack

- **Backend**: Laravel 11.x (PHP 8.3+)
- **Frontend**: Tailwind CSS 4.x, Alpine.js, Vite
- **Database**: MySQL (Local) / Aiven MySQL (Production)
- **Authentication**: Laravel Sanctum + Spatie Permissions
- **Deployment**: Vercel (Serverless Functions)
- **Package Manager**: Composer + NPM

---

## 📋 Prerequisites

Pastikan sistem Anda memiliki:

- **PHP 8.3+** dengan extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Composer 2.x**
- **Node.js 18+ dan NPM**
- **MySQL 8.0+** (untuk development)
- **Git**

---

## 🚀 Local Development Setup

### 1. Clone Repository

```bash
git clone https://github.com/YourUsername/contractor.git
cd contractor
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies  
npm install
```

### 3. Environment Configuration

```bash
# Copy environment template
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

Edit `.env` file dengan konfigurasi database local:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contractor
DB_USERNAME=root
DB_PASSWORD=your_password
```

**Buat database di MySQL:**
```sql
CREATE DATABASE contractor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Run Migrations & Seeders

```bash
# Run database migrations
php artisan migrate

# Create roles and permissions
php artisan db:seed --class=RolePermissionSeeder

# Create super admin user
php artisan db:seed --class=SuperAdminSeeder
```

### 6. Build Frontend Assets

```bash
# Development build
npm run dev

# Or production build
npm run build
```

### 7. Start Development Server

```bash
# Start Laravel server
php artisan serve

# In separate terminal, start Vite dev server
npm run dev
```

Akses aplikasi di `http://localhost:8000`

---

## 🌐 Production Deployment (Vercel)

### 1. Prepare Environment

Buat file `.env.vercel` dengan konfigurasi production (tanpa credentials sensitif):

```env
APP_NAME="Contractor Management"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.vercel.app

# Database akan di-set via Vercel Dashboard
DB_CONNECTION=aiven

# Cache & Session
CACHE_DRIVER=array
SESSION_DRIVER=cookie
SESSION_LIFETIME=120

# Logs
LOG_CHANNEL=stderr

# Queue & Mail
QUEUE_CONNECTION=sync
MAIL_MAILER=log
```

### 2. Vercel Configuration

File `vercel.json` sudah dikonfigurasi dengan:
- PHP 8.3 runtime via `vercel-php@0.7.4`
- Build command untuk compile assets
- Environment variables untuk serverless optimization
- Proper routing untuk static assets dan API

### 3. Deploy ke Vercel

```bash
# Install Vercel CLI
npm install -g vercel

# Login ke Vercel
vercel login

# Deploy
vercel --prod
```

### 4. Configure Environment Variables

Di Vercel Dashboard, set environment variables:

```env
APP_KEY=base64:your-generated-app-key
DB_CONNECTION=aiven
AIVEN_DB_HOST=your-aiven-host
AIVEN_DB_PORT=16722
AIVEN_DB_DATABASE=contractor
AIVEN_DB_USERNAME=your-username
AIVEN_DB_PASSWORD=your-password
```

### 5. Run Production Setup

Setelah deployment berhasil:

```bash
# Akses migration endpoint (setup otomatis)
curl https://your-app.vercel.app/migrate
```

---

## 🔧 Development Commands

### Database Operations

```bash
# Fresh migration (reset database)
php artisan migrate:fresh --seed

# Check database status
php artisan db:info

# Create new migration
php artisan make:migration create_table_name
```

### Code Quality

```bash
# Run tests
php artisan test

# Clear caches
php artisan optimize:clear
```

### Asset Management

```bash
# Development mode (watch files)
npm run dev

# Production build
npm run build

# Preview production build
npm run preview
```

---

## 📂 Project Structure

```
contractor/
├── api/                    # Vercel serverless functions
├── app/
│   ├── Console/Commands/   # Artisan commands
│   ├── Http/Controllers/   # Application controllers
│   ├── Models/            # Eloquent models
│   ├── Providers/         # Service providers
│   └── Services/          # Business logic services
├── bootstrap/             # Laravel bootstrap files
├── config/                # Configuration files
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/          # Database seeders
├── public/               # Public assets
├── resources/
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript
│   └── views/            # Blade templates
├── routes/               # Route definitions
├── storage/              # File storage
└── tests/               # Test files
```

## 🔒 Security Notes

### Production Security
- Ganti semua default passwords setelah deployment
- Set `APP_DEBUG=false` di production
- Gunakan strong `APP_KEY`
- Konfigurasi database credentials via environment variables
- Enable HTTPS (Vercel provides automatic HTTPS)

### Environment Variables
- Jangan commit file `.env` atau `.env.production`
- Gunakan Vercel Dashboard untuk set sensitive data
- File `.env.vercel` hanya untuk non-sensitive defaults

---

## 😨 Troubleshooting

### Common Issues

**Build Errors:**
```bash
# Clear all caches
php artisan optimize:clear
npm run build
```

**Database Connection:**
```bash
# Test database connection
php artisan db:monitor
php artisan migrate:status
```

**Permission Issues:**
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

### Vercel Specific Issues

**Vite Manifest Error:**
- Ensure `npm run build` runs in `vercel.json`
- Check `public/build/manifest.json` exists

**Database Connection Error:**
- Verify environment variables in Vercel Dashboard
- Test connection dengan debug endpoint

---

## 📚 Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Vercel PHP Runtime](https://vercel.com/docs/functions/serverless-functions/runtimes/php)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)

---

## 🤝 Contributing

1. Fork the repository
2. Create feature branch: `git checkout -b feature/new-feature`
3. Commit changes: `git commit -m 'Add new feature'`
4. Push to branch: `git push origin feature/new-feature`
5. Submit pull request

---

## 📄 License

This project is licensed under the MIT License.

---

## 🆘 Support

Untuk pertanyaan atau bantuan:
- Create issue di GitHub repository
- Contact team development

**Happy Coding! 🚀**
