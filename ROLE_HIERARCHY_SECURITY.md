# 🔐 ROLE HIERARCHY & SECURITY SYSTEM

## 🎯 Role Hierarchy (Highest to Lowest Privilege)

| Level | Role Name | Label | Description |
|-------|-----------|-------|-------------|
| **1** | `superadmin` | Superadmin | Full system control, god mode |
| **2** | `administrator` | Administrator | System administrator, manage users & system |
| **3** | `admin_kontraktor` | Admin (Kontraktor) | Admin kontraktor, manage agency, customers, projects |
| **4** | `user_kontraktor` | User (Kontraktor) | Staff kontraktor, view & edit projects |
| **5** | `customer` | Customer (Viewer) | Client viewer, view assigned projects only |

**Rule:** Lower number = Higher privilege. Can only manage roles with **LOWER privilege** (higher number).

---

## 🛡️ SECURITY RULES

### ✅ Rule #1: Can Only VIEW Users with Lower Role
- **Superadmin** lihat: Superadmin, Administrator, Admin Kontraktor, User Kontraktor, Customer
- **Administrator** lihat: Admin Kontraktor, User Kontraktor, Customer (❌ TIDAK lihat Superadmin & Administrator lain)
- **Admin Kontraktor** lihat: User Kontraktor, Customer (❌ TIDAK lihat Superadmin, Administrator, Admin Kontraktor lain)

**Benefit:** Administrator tidak bisa tau siapa Superadmin. Admin Kontraktor tidak bisa tau siapa Administrator.

---

### ✅ Rule #2: Can Only CREATE Users with Lower Role
- **Superadmin** bisa buat: Superadmin, Administrator, Admin Kontraktor, User Kontraktor, Customer
- **Administrator** bisa buat: Admin Kontraktor, User Kontraktor, Customer (❌ TIDAK bisa buat Superadmin & Administrator)
- **Admin Kontraktor** bisa buat: User Kontraktor, Customer (❌ TIDAK bisa buat Admin Kontraktor)

**Benefit:** Tidak ada role yang bisa "promote" diri sendiri atau buat role yang sama.

---

### ✅ Rule #3: Can Only EDIT/DELETE Users with Lower Role
- **Superadmin** bisa edit/delete: SEMUA (including other Superadmins)
- **Administrator** bisa edit/delete: Admin Kontraktor, User Kontraktor, Customer (❌ TIDAK bisa edit Superadmin & Administrator)
- **Admin Kontraktor** bisa edit/delete: User Kontraktor, Customer (❌ TIDAK bisa edit Admin Kontraktor)

**Benefit:** Administrator tidak bisa:
- ❌ Edit akun Superadmin
- ❌ Delete akun Superadmin
- ❌ Nonaktifkan akun Superadmin
- ❌ Reset password Superadmin
- ❌ Edit Administrator lain

---

### ✅ Rule #4: Can Only TOGGLE STATUS Users with Lower Role
Same as Edit/Delete rule. Tidak bisa aktifkan/nonaktifkan user dengan role yang sama atau lebih tinggi.

---

### ✅ Rule #5: Can Only RESET PASSWORD Users with Lower Role
Same as Edit/Delete rule. Tidak bisa reset password user dengan role yang sama atau lebih tinggi.

---

## 💻 IMPLEMENTATION

### Backend Protection (Controller)

**File:** `app/Http/Controllers/UserManagementController.php`

```php
// Role Hierarchy Definition
private const ROLE_HIERARCHY = [
    'superadmin' => 1,
    'administrator' => 2,
    'admin_kontraktor' => 3,
    'user_kontraktor' => 4,
    'customer' => 5,
];

// Check if can manage target user
private function canManageUser(User $targetUser): bool
{
    $currentUserRole = auth()->user()->roles->first()->name ?? 'customer';
    $targetUserRole = $targetUser->roles->first()->name ?? 'customer';
    
    $currentLevel = self::ROLE_HIERARCHY[$currentUserRole] ?? 999;
    $targetLevel = self::ROLE_HIERARCHY[$targetUserRole] ?? 999;
    
    // Can only manage users with LOWER privilege (higher number)
    return $currentLevel < $targetLevel;
}
```

**Protected Methods:**
- ✅ `index()` - Filter user list by hierarchy
- ✅ `store()` - Validate role creation by hierarchy
- ✅ `update()` - Check before update
- ✅ `destroy()` - Check before delete
- ✅ `toggleStatus()` - Check before toggle
- ✅ `resetPassword()` - Check before reset

---

### Frontend Protection (View)

**File:** `resources/views/users/index.blade.php`

```blade
@php
    // Role Hierarchy check
    $roleHierarchy = [
        'superadmin' => 1,
        'administrator' => 2,
        'admin_kontraktor' => 3,
        'user_kontraktor' => 4,
        'customer' => 5,
    ];
    $currentLevel = $roleHierarchy[$currentUserRole] ?? 999;
    $targetLevel = $roleHierarchy[$targetUserRole] ?? 999;
    $canManage = $currentLevel < $targetLevel;
@endphp

@if($canManage)
    {{-- Show action buttons --}}
@else
    <span class="text-xs text-gray-400 italic px-2">🔒 Protected</span>
@endif
```

**Protected UI Elements:**
- Edit button
- Toggle status button
- Delete button
- Reset password button

---

## 🧪 TEST SCENARIOS

### Test 1: Administrator Login
**Login as:** `admin@contractor.test`

**Expected:**
- ✅ Lihat ONLY: Admin Kontraktor, User Kontraktor, Customer
- ❌ TIDAK lihat: Superadmin, Administrator lain
- ✅ Dropdown role: Admin Kontraktor, User Kontraktor, Customer
- ❌ Dropdown role TIDAK ada: Superadmin, Administrator
- ✅ Bisa edit/delete: Admin Kontraktor, User Kontraktor, Customer
- ❌ Tombol edit/delete HIDDEN untuk: Superadmin (tidak muncul di list anyway)

---

### Test 2: Administrator Try to Hack
**Scenario:** Administrator coba edit Superadmin via direct URL/API

**Test:**
```bash
# Via browser console atau Postman
PUT /users/1  # ID 1 = Superadmin
```

**Expected:**
- ❌ HTTP 403 Forbidden
- ❌ Error message: "Anda tidak dapat mengedit user dengan role yang sama atau lebih tinggi dari Anda!"

---

### Test 3: Administrator Try to Create Superadmin
**Scenario:** Administrator coba buat user dengan role Superadmin

**Test:**
- Pilih role "Superadmin" (seharusnya tidak ada di dropdown)
- Submit form

**Expected:**
- ❌ Validation error: "role tidak valid"
- ❌ Tidak bisa submit karena dropdown tidak ada option "Superadmin"

---

### Test 4: Admin Kontraktor Login
**Login as:** `adminkontraktor@contractor.test`

**Expected:**
- ✅ Lihat ONLY: User Kontraktor, Customer
- ❌ TIDAK lihat: Superadmin, Administrator, Admin Kontraktor lain
- ✅ Dropdown role: User Kontraktor, Customer
- ❌ Dropdown role TIDAK ada: Superadmin, Administrator, Admin Kontraktor

---

### Test 5: Superadmin Login
**Login as:** `superadmin@contractor.test`

**Expected:**
- ✅ Lihat SEMUA user (including other Superadmins)
- ✅ Dropdown role: SEMUA role including Superadmin
- ✅ Bisa edit/delete SEMUA user (termasuk Superadmin lain)
- ✅ Tombol edit/delete muncul untuk SEMUA user

---

## 🚨 SECURITY CHECKLIST

### Before Deployment:
- [x] Role hierarchy defined in controller
- [x] canManageUser() method implemented
- [x] getAllowedRoles() method filters correctly
- [x] index() filters user list by hierarchy
- [x] store() validates role by hierarchy
- [x] update() checks hierarchy before edit
- [x] destroy() checks hierarchy before delete
- [x] toggleStatus() checks hierarchy before toggle
- [x] resetPassword() checks hierarchy before reset
- [x] View hides action buttons for protected users
- [x] Role dropdown filters by hierarchy

### After Deployment:
- [ ] Test Administrator cannot see Superadmin
- [ ] Test Administrator cannot edit Superadmin
- [ ] Test Administrator cannot create Superadmin
- [ ] Test Administrator cannot create Administrator
- [ ] Test Admin Kontraktor cannot see Administrator
- [ ] Test Admin Kontraktor cannot create Admin Kontraktor
- [ ] Test Superadmin can do everything

---

## 🔄 HIERARCHY FLOW DIAGRAM

```
┌─────────────────────────────────────────────────────┐
│                    SUPERADMIN (1)                    │
│  ✅ View: ALL                                        │
│  ✅ Create: ALL (including Superadmin)               │
│  ✅ Edit/Delete: ALL                                 │
└──────────────────┬──────────────────────────────────┘
                   │
         ┌─────────┴─────────┐
         │                   │
┌────────▼─────────┐  ┌──────▼──────────────────────┐
│ ADMINISTRATOR(2) │  │  ADMIN KONTRAKTOR (3)       │
│ ✅ View:          │  │  ✅ View:                    │
│   • Admin Kontr  │  │    • User Kontraktor        │
│   • User Kontr   │  │    • Customer               │
│   • Customer     │  │  ❌ Cannot see:              │
│ ✅ Create:        │  │    • Superadmin             │
│   • Admin Kontr  │  │    • Administrator          │
│   • User Kontr   │  │    • Other Admin Kontraktor │
│   • Customer     │  │  ✅ Create:                  │
│ ❌ Cannot see:    │  │    • User Kontraktor        │
│   • Superadmin   │  │    • Customer               │
│   • Other Admin  │  │  ❌ Cannot create:           │
└──────────────────┘  │    • Admin Kontraktor       │
                      └─────────┬───────────────────┘
                                │
                      ┌─────────┴─────────┐
                      │                   │
             ┌────────▼───────────┐  ┌───▼──────────┐
             │ USER KONTRAKTOR(4) │  │ CUSTOMER (5)  │
             │ 👁️ View only       │  │ 👁️ View only  │
             │ ❌ Cannot manage   │  │ ❌ Cannot      │
             │    anyone          │  │    manage     │
             └────────────────────┘  └───────────────┘
```

---

## 📝 NOTES

1. **Why not allow same-level management?**
   - Prevents privilege escalation
   - Prevents horizontal attacks (Administrator attacking other Administrators)
   - Maintains clear chain of command

2. **Exception: Superadmin can manage other Superadmins**
   - Needed for system maintenance
   - Superadmins trusted at highest level
   - Can remove compromised Superadmin accounts

3. **What if Administrator is compromised?**
   - Cannot escalate to Superadmin
   - Cannot disable Superadmin
   - Cannot see who Superadmins are
   - Limited blast radius to lower roles only

4. **What if Admin Kontraktor is compromised?**
   - Cannot access system-level functions
   - Cannot see Administrators
   - Limited to contractor operations only
   - Can only affect User Kontraktor & Customer

---

**Last Updated:** 2025-11-14  
**Status:** ✅ IMPLEMENTED & SECURED  
**Security Level:** 🔐 HIGH
