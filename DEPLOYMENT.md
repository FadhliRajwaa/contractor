# 🚀 Deployment Guide - ContractorApp

## Status Deployment
- ✅ Code pushed to GitHub: `cc45586`
- ⏳ Vercel auto-deploy triggered
- 🔄 Waiting for build to complete

## ⚙️ Setup Environment Variables di Vercel

### Langkah 1: Buka Vercel Dashboard
1. Go to: https://vercel.com/dashboard
2. Pilih project: **contractor** atau **contractor-test**
3. Klik tab **Settings**
4. Klik **Environment Variables** di sidebar

### Langkah 2: Tambahkan Variables Berikut

**PENTING:** Copy-paste values ini **PERSIS** seperti yang tertulis:

```env
# Application
APP_NAME=ContractorApp
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:o509+WorA8qMiWmLsF+0pK/7v2iSCGJ31H3aTpHqU/8=
APP_URL=https://contractor-test.vercel.app

# Logging
LOG_CHANNEL=stderr
LOG_LEVEL=info

# Database - Aiven Cloud MySQL
DB_CONNECTION=aiven
AIVEN_DB_HOST=companyinterior-fadhlirajwaarahmana-9486.i.aivencloud.com
AIVEN_DB_PORT=16722
AIVEN_DB_DATABASE=contractor
AIVEN_DB_USERNAME=avnadmin
AIVEN_DB_PASSWORD=your-aiven-password-here

# Session Configuration
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_EXPIRE_ON_CLOSE=false
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Cache & Queue
CACHE_DRIVER=array
QUEUE_CONNECTION=sync

# File Storage
FILESYSTEM_DISK=local
VIEW_COMPILED_PATH=/tmp

# Mail
MAIL_MAILER=log

# Security
BCRYPT_ROUNDS=12
```

### Langkah 3: Set Untuk Semua Environments
Untuk setiap variable:
1. Klik **Add New**
2. Masukkan **Name** (contoh: `APP_NAME`)
3. Masukkan **Value** (contoh: `ContractorApp`)
4. Pilih **All** environments (Production, Preview, Development)
5. Klik **Save**

### Langkah 4: Trigger Redeploy
Setelah semua environment variables di-set:

**Opsi A - Auto Deploy (Sudah Berjalan)**
- Vercel akan otomatis detect push ke GitHub
- Build akan berjalan otomatis
- Tunggu 2-3 menit

**Opsi B - Manual Redeploy (Jika Perlu)**
1. Go to **Deployments** tab
2. Klik **...** (three dots) pada deployment terakhir
3. Klik **Redeploy**
4. Pilih **Use existing Build Cache** (optional)
5. Klik **Redeploy**

## 🔍 Verify Deployment

### Check Build Status
1. Go to: https://vercel.com/dashboard
2. Pilih project Anda
3. Tab **Deployments**
4. Lihat status build terakhir:
   - 🟡 **Building** - Sedang proses
   - 🟢 **Ready** - Berhasil!
   - 🔴 **Error** - Ada masalah

### Check Website
Setelah build selesai (status **Ready**):
1. Buka: https://contractor-test.vercel.app/login
2. Cek apakah halaman login muncul
3. Try login dengan credentials:
   - Email: `superadmin@contractor.test`
   - Password: `password` (atau password yang sudah di-set)

### Verify Database Connection
Login ke dashboard dan pastikan:
- ✅ Data user muncul
- ✅ Data agencies muncul
- ✅ Toggle status agency bekerja
- ✅ Tidak ada error database

## 🐛 Troubleshooting

### Build Gagal
1. Check build logs di Vercel
2. Pastikan semua environment variables sudah di-set
3. Pastikan `npm install` berhasil
4. Check error message di logs

### Database Connection Error
1. Verify credentials Aiven di environment variables
2. Check apakah Aiven database online
3. Test connection manual:
```bash
mysql -h companyinterior-fadhlirajwaarahmana-9486.i.aivencloud.com \
      -P 16722 \
      -u avnadmin \
      -p contractor
```

### 419 CSRF Error
- Clear browser cookies
- Hard refresh (Ctrl+Shift+R)
- Check `SESSION_SECURE_COOKIE=true` di environment variables

### Assets Not Loading
1. Check `/public/build` folder exists
2. Run `npm run build` locally untuk test
3. Commit hasil build jika perlu

## 📝 Notes

### File `.env.vercel`
- ⚠️ File ini **TIDAK di-commit** ke GitHub (ada di .gitignore)
- 🔐 Credentials hanya ada di Vercel Environment Variables
- 📄 Gunakan `.env.vercel.example` sebagai template

### Security Best Practices
- ✅ Credentials tidak di-commit ke repository
- ✅ Environment variables di-set di Vercel Dashboard
- ✅ APP_DEBUG=false di production
- ✅ SESSION_SECURE_COOKIE=true untuk HTTPS

### Local vs Production
| Feature | Local | Production |
|---------|-------|------------|
| Database | MySQL (127.0.0.1) | Aiven Cloud |
| Session | database | cookie |
| Cache | database | array |
| Debug | true | false |
| Environment | .env | Vercel Env Vars |

## 📚 Resources
- Vercel Docs: https://vercel.com/docs
- Laravel Deployment: https://laravel.com/docs/11.x/deployment
- Aiven Console: https://console.aiven.io

## ✅ Checklist Deployment

- [x] Code pushed to GitHub
- [x] Migration dijalankan di Aiven database
- [x] `.env.vercel` di-exclude dari git
- [ ] Environment variables di-set di Vercel Dashboard
- [ ] Manual trigger redeploy (jika diperlukan)
- [ ] Verify website bisa diakses
- [ ] Verify database connection working
- [ ] Test login functionality
- [ ] Test agency status toggle
- [ ] Check for any console errors

---

**Last Updated:** 2025-11-16 19:35 WIB
**Deployment URL:** https://contractor-test.vercel.app
**GitHub Repo:** https://github.com/FadhliRajwaa/contractor
