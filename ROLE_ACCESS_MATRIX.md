# 📋 MATRIX HAK AKSES PER ROLE - ContractorApp

## 🎯 5 Level Role System

| # | Role Name | Label Display | Fungsi Utama |
|---|-----------|---------------|--------------|
| 1 | `superadmin` | **Superadmin** | Full system control, manage semua user dan role |
| 2 | `administrator` | **Administrator** | System admin, manage user (kecuali superadmin) |
| 3 | `admin_kontraktor` | **Admin (Kontraktor)** | Admin kontraktor, manage agency, customer, user kontraktor, project |
| 4 | `user_kontraktor` | **User (Kontraktor)** | Staff kontraktor, view & edit project terbatas |
| 5 | `customer` | **Customer (Viewer)** | Client viewer, lihat project yang di-assign saja |

---

## 🔐 PERMISSIONS PER ROLE

### 1️⃣ SUPERADMIN
**Permissions:** ALL (29 permissions)
- ✅ view/create/edit/delete users
- ✅ view/create/edit/delete roles
- ✅ view/create/edit/delete customers
- ✅ view/create/edit/delete projects
- ✅ view/create/edit/delete agencies
- ✅ view dashboard + admin dashboard

**Dapat Membuat User:**
- ✅ Superadmin
- ✅ Administrator
- ✅ Admin Kontraktor
- ✅ User Kontraktor
- ✅ Customer

---

### 2️⃣ ADMINISTRATOR
**Permissions:**
- ✅ view/create/edit/delete users
- ✅ view roles (tidak bisa edit/delete)
- ✅ view dashboard + admin dashboard
- ❌ TIDAK bisa: manage customers, projects, agencies

**Dapat Membuat User:**
- ⚠️ **MASALAH:** Saat ini bisa buat SEMUA role (salah!)
- ✅ **SEHARUSNYA:** Hanya bisa buat:
  - Administrator
  - Admin Kontraktor
  - User Kontraktor
  - Customer
- ❌ **TIDAK BOLEH** buat: Superadmin

---

### 3️⃣ ADMIN KONTRAKTOR
**Permissions:**
- ✅ view/create/edit users (terbatas)
- ✅ view/create/edit/delete customers
- ✅ view/create/edit/delete projects
- ✅ view/create/edit/delete agencies
- ✅ view dashboard + contractor dashboard
- ❌ TIDAK bisa: manage roles, manage admin-level users

**Dapat Membuat User:**
- ✅ User Kontraktor
- ✅ Customer
- ❌ TIDAK bisa buat: Superadmin, Administrator, Admin Kontraktor lain

---

### 4️⃣ USER KONTRAKTOR
**Permissions:**
- ✅ view customers (read only)
- ✅ view projects
- ✅ edit projects (terbatas, diatur di controller)
- ✅ view dashboard + contractor dashboard
- ❌ TIDAK bisa: create/delete apapun, manage users

**Dapat Membuat User:**
- ❌ Tidak bisa membuat user apapun

**⚠️ MASALAH:** Di seeder ada permission 'edit users' tapi tidak ada route/halaman untuk ini!

---

### 5️⃣ CUSTOMER
**Permissions:**
- ✅ view projects (hanya yang assigned ke mereka - diatur di controller)
- ✅ view dashboard + customer dashboard
- ❌ TIDAK bisa: create/edit/delete apapun

**Dapat Membuat User:**
- ❌ Tidak bisa membuat user apapun

---

## 🌐 HALAMAN YANG BISA DIAKSES PER ROLE

### SUPERADMIN (/superadmin)
| Route | URL | Akses |
|-------|-----|-------|
| Dashboard | `/dashboard` | ✅ Full admin dashboard |
| User Management | `/users` | ✅ View, Create, Edit, Delete SEMUA user |
| Role Management | (belum ada) | ✅ Manage roles & permissions |
| Customer Management | `/customers` | ✅ Full CRUD |
| Project Management | `/projects` | ✅ Full CRUD |
| Agency Management | `/agencies` | ✅ Full CRUD |

---

### ADMINISTRATOR (/admin)
| Route | URL | Akses |
|-------|-----|-------|
| Dashboard | `/dashboard` | ✅ Admin dashboard |
| User Management | `/users` | ✅ View, Create, Edit, Delete (⚠️ harus dibatasi) |
| Customer Management | `/customers` | ❌ TIDAK ADA AKSES |
| Project Management | `/projects` | ❌ TIDAK ADA AKSES |
| Agency Management | `/agencies` | ❌ TIDAK ADA AKSES |

**⚠️ MASALAH:** Tidak ada menu sidebar untuk Administrator!

---

### ADMIN KONTRAKTOR (/admin-kontraktor)
| Route | URL | Akses |
|-------|-----|-------|
| Dashboard | `/dashboard` | ✅ Contractor dashboard |
| My Users | `/contractor-users` | ✅ Manage user_kontraktor & customer |
| Customer Management | `/customers` | ✅ Full CRUD |
| Project Management | `/projects` | ✅ Full CRUD |
| Agency Management | `/agencies` | ✅ Full CRUD (manage kontraktor) |

---

### USER KONTRAKTOR (/staff)
| Route | URL | Akses |
|-------|-----|-------|
| Dashboard | `/dashboard` | ✅ Contractor dashboard (limited) |
| Customer List | `/customers` | ✅ View only |
| Project Management | `/projects` | ✅ View & Edit (terbatas) |

**⚠️ MASALAH:** Route `/customers` izinkan user_kontraktor tapi controller check permission belum ada!

---

### CUSTOMER (VIEWER) (/client)
| Route | URL | Akses |
|-------|-----|-------|
| Dashboard | `/dashboard` | ✅ Customer dashboard |
| My Projects | `/projects` | ✅ View assigned projects only |

---

## ⚠️ MASALAH YANG DITEMUKAN

### 🔴 CRITICAL - Harus Diperbaiki

1. **Administrator Bisa Buat Superadmin**
   - **File:** `UserManagementController::store()`
   - **Masalah:** Tidak ada validasi role yang boleh dibuat
   - **Fix:** Tambah validation untuk batasi role based on user role

2. **Tidak Ada Menu Sidebar untuk Administrator**
   - **File:** `layouts/app.blade.php`
   - **Masalah:** Menu hanya untuk superadmin & admin_kontraktor
   - **Fix:** Tambah menu untuk administrator

3. **User Kontraktor Punya Permission 'edit users' Tapi Tidak Ada Akses**
   - **File:** `RolePermissionSeeder.php` line 88
   - **Masalah:** Permission tidak terpakai
   - **Fix:** Hapus permission atau buat fitur "Edit Profile Sendiri"

### 🟡 MEDIUM - Perlu Perbaikan

4. **Customer Route `/customers` Belum Punya Permission Check**
   - **File:** `CustomerController.php`
   - **Masalah:** Controller masih stub, belum ada logic
   - **Fix:** Implement controller dengan permission check

5. **Project Route Belum Punya Permission Check Detail**
   - **File:** `ProjectController.php`
   - **Masalah:** Controller masih stub
   - **Fix:** Implement dengan filter berdasarkan role

6. **Tidak Ada Halaman untuk Role Management**
   - **Masalah:** Superadmin punya permission tapi tidak ada halaman
   - **Fix:** Buat RoleController & view (optional, nanti expand)

### 🟢 LOW - Enhancement

7. **Dashboard Belum Role-Specific**
   - **File:** `DashboardController.php`
   - **Masalah:** Dashboard sama untuk semua role
   - **Fix:** Buat dashboard yang berbeda per role level

8. **Tidak Ada Audit Log**
   - **Masalah:** Tidak track siapa buat/edit/delete apa
   - **Fix:** Implement activity log (nanti expansion)

---

## ✅ REKOMENDASI FIX PRIORITAS TINGGI

### 1. Update UserManagementController - Batasi Role Creation

```php
// Di store() method, tambah validasi:
$allowedRoles = [];
if (auth()->user()->hasRole('superadmin')) {
    $allowedRoles = ['superadmin', 'administrator', 'admin_kontraktor', 'user_kontraktor', 'customer'];
} elseif (auth()->user()->hasRole('administrator')) {
    $allowedRoles = ['administrator', 'admin_kontraktor', 'user_kontraktor', 'customer'];
}

$validated = $request->validate([
    'role' => ['required', Rule::in($allowedRoles)],
    // ...
]);
```

### 2. Update Sidebar untuk Administrator

```blade
@role('administrator')
<a href="{{ route('users.index') }}">
    User Management
</a>
@endrole
```

### 3. Hapus Permission 'edit users' dari User Kontraktor

```php
// Di RolePermissionSeeder line 88, hapus:
'edit users', // ❌ HAPUS INI
```

### 4. Update roles dropdown di form

Filter role yang tampil berdasarkan user role:
```php
@php
    $visibleRoles = [];
    if (auth()->user()->hasRole('superadmin')) {
        $visibleRoles = $roles;
    } elseif (auth()->user()->hasRole('administrator')) {
        $visibleRoles = $roles->whereNotIn('name', ['superadmin']);
    }
@endphp
```

---

## 📊 SUMMARY MATRIX

| Fitur | Superadmin | Administrator | Admin Kontraktor | User Kontraktor | Customer |
|-------|------------|---------------|------------------|-----------------|----------|
| **User Management** |
| View All Users | ✅ | ✅ | ❌ | ❌ | ❌ |
| Create Superadmin | ✅ | ❌ | ❌ | ❌ | ❌ |
| Create Admin | ✅ | ✅ | ❌ | ❌ | ❌ |
| Create Kontraktor Users | ✅ | ✅ | ✅ | ❌ | ❌ |
| Edit Any User | ✅ | ✅ | ❌ | ❌ | ❌ |
| Delete Any User | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Agency Management** |
| View Agencies | ✅ | ❌ | ✅ | ❌ | ❌ |
| Create Agency | ✅ | ❌ | ✅ | ❌ | ❌ |
| Edit Agency | ✅ | ❌ | ✅ | ❌ | ❌ |
| Delete Agency | ✅ | ❌ | ✅ | ❌ | ❌ |
| **Customer Management** |
| View Customers | ✅ | ❌ | ✅ | ✅ | ❌ |
| Create Customer | ✅ | ❌ | ✅ | ❌ | ❌ |
| Edit Customer | ✅ | ❌ | ✅ | ❌ | ❌ |
| Delete Customer | ✅ | ❌ | ✅ | ❌ | ❌ |
| **Project Management** |
| View All Projects | ✅ | ❌ | ✅ | ✅ | ❌ |
| View My Projects | - | - | - | - | ✅ |
| Create Project | ✅ | ❌ | ✅ | ❌ | ❌ |
| Edit Project | ✅ | ❌ | ✅ | ✅ (limited) | ❌ |
| Delete Project | ✅ | ❌ | ✅ | ❌ | ❌ |
| **Dashboard** |
| Admin Dashboard | ✅ | ✅ | ❌ | ❌ | ❌ |
| Contractor Dashboard | ✅ | ❌ | ✅ | ✅ | ❌ |
| Customer Dashboard | ✅ | ❌ | ❌ | ❌ | ✅ |

---

**Generated:** 2025-11-14  
**Status:** 🔴 NEEDS FIX - Ada 3 critical issues yang harus diperbaiki
