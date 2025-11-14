# 🎨 UI Components & Design System

Dokumentasi lengkap komponen UI yang tersedia di ContractorApp.

## 🎨 Color Palette

### Brand Colors

```css
/* Defined in resources/css/app.css */
--color-brand-50: #FFE6D4   /* Lightest - backgrounds */
--color-brand-100: #FFD9C0
--color-brand-200: #FFC69D  /* Accent color */
--color-brand-300: #FFB389
--color-brand-400: #E06B80  /* Secondary */
--color-brand-500: #CD2C58  /* Primary - main brand color */
--color-brand-600: #B02449
--color-brand-700: #931C3A
--color-brand-800: #76152C
--color-brand-900: #590E1D  /* Darkest */
```

### Usage in Tailwind

```html
<button class="bg-brand-500 hover:bg-brand-600 text-white">
    Primary Button
</button>

<div class="bg-brand-50 border border-brand-200">
    Light card background
</div>
```

## 🔘 Buttons

### Primary Button
```html
<button class="btn-primary">
    Primary Action
</button>
```
**Style:** Brand-500 background, white text, hover effect, rounded-lg

### Secondary Button
```html
<button class="btn-secondary">
    Secondary Action
</button>
```
**Style:** Gray-200 background, gray-800 text, hover effect

### Ghost Button
```html
<button class="btn-ghost">
    Tertiary Action
</button>
```
**Style:** Transparent background, gray text, hover gray-100

### Icon Button
```html
<button class="p-2 rounded-lg hover:bg-gray-100 transition">
    <svg class="h-5 w-5">...</svg>
</button>
```

## 📝 Form Elements

### Text Input
```html
<input type="text" class="input-field" placeholder="Enter text...">
```
**Style:** Rounded-lg, border-gray-300, focus:brand-500

### With Label
```html
<div>
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
        Full Name <span class="text-red-500">*</span>
    </label>
    <input 
        type="text" 
        id="name" 
        name="name" 
        class="input-field" 
        required
    >
</div>
```

### Select Dropdown
```html
<select class="input-field">
    <option value="">Choose option</option>
    <option value="1">Option 1</option>
</select>
```

### Textarea
```html
<textarea 
    class="input-field" 
    rows="3" 
    placeholder="Enter notes..."
></textarea>
```

### Checkbox
```html
<label class="flex items-center">
    <input 
        type="checkbox" 
        class="h-4 w-4 text-brand-500 focus:ring-brand-500 border-gray-300 rounded"
    >
    <span class="ml-2 text-sm text-gray-700">Remember me</span>
</label>
```

## 🃏 Cards

### Basic Card
```html
<div class="card">
    <h3 class="text-lg font-semibold mb-4">Card Title</h3>
    <p class="text-gray-600">Card content goes here...</p>
</div>
```
**Style:** White background, rounded-xl, shadow-sm, padding

### Hover Card
```html
<div class="card hover:shadow-lg transition duration-300">
    Content with hover effect
</div>
```

### Stat Card
```html
<div class="card hover:shadow-lg transition duration-300">
    <div class="flex items-center">
        <div class="flex-shrink-0 bg-brand-100 rounded-lg p-3">
            <svg class="h-8 w-8 text-brand-600">...</svg>
        </div>
        <div class="ml-5">
            <h3 class="text-sm font-medium text-gray-500">Label</h3>
            <p class="text-2xl font-bold text-gray-900">123</p>
        </div>
    </div>
</div>
```

## 📊 Tables

### Responsive Table
```html
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Column 1
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">Data</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

## 🏷️ Badges

### Success Badge
```html
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
    Active
</span>
```

### Danger Badge
```html
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
    Inactive
</span>
```

### Brand Badge
```html
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-800">
    Role Name
</span>
```

## 💬 Alerts & Toasts

### Success Alert
```html
<div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-500">...</svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-green-800">
                Success message here
            </p>
        </div>
    </div>
</div>
```

### Error Alert
```html
<div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-500">...</svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-red-800">
                Error message here
            </p>
        </div>
    </div>
</div>
```

## 🪟 Modals

### Full Modal Example
```html
<div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Modal Title</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6">...</svg>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-6">
            Modal content here
        </div>
        
        <!-- Footer -->
        <div class="flex justify-end space-x-3 p-6 border-t border-gray-200">
            <button class="btn-secondary">Cancel</button>
            <button class="btn-primary">Save</button>
        </div>
    </div>
</div>
```

## 🍞 Breadcrumbs

```html
<nav class="flex" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm">
        <li>
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                Dashboard
            </a>
        </li>
        <li>
            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </li>
        <li>
            <span class="text-gray-900 font-medium">Current Page</span>
        </li>
    </ol>
</nav>
```

## 🎭 Avatars

### User Avatar
```html
<img 
    src="{{ $user->avatar_url }}" 
    alt="{{ $user->name }}"
    class="h-10 w-10 rounded-full object-cover"
>
```

### Avatar with Status
```html
<div class="relative">
    <img src="..." class="h-10 w-10 rounded-full">
    <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full bg-green-400 ring-2 ring-white"></span>
</div>
```

## 📱 Mobile Menu Toggle

```javascript
// Vanilla JS implementation
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');

mobileMenuBtn.addEventListener('click', function() {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
});

overlay.addEventListener('click', function() {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
});
```

## 🎨 Utility Classes (Custom)

Defined in `resources/css/app.css`:

```css
.btn-primary      /* Primary button style */
.btn-secondary    /* Secondary button style */
.btn-ghost        /* Ghost/transparent button */
.input-field      /* Form input style */
.card             /* Card container */
```

## 📐 Responsive Breakpoints

```css
sm: 640px   /* Small devices */
md: 768px   /* Medium devices */
lg: 1024px  /* Large devices (desktop) */
xl: 1280px  /* Extra large */
2xl: 1536px /* 2X Extra large */
```

### Usage
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Responsive grid -->
</div>
```

## 🎬 Animations & Transitions

### Hover Effects
```html
<button class="transform hover:scale-105 transition duration-300">
    Scale on Hover
</button>

<div class="hover:shadow-xl transition duration-300">
    Shadow on Hover
</div>
```

### Loading Skeleton
```html
<div class="animate-pulse">
    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
    <div class="space-y-3 mt-3">
        <div class="h-3 bg-gray-200 rounded"></div>
        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
    </div>
</div>
```

## 🔍 Empty States

```html
<div class="text-center py-12">
    <svg class="mx-auto h-12 w-12 text-gray-400">...</svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">No data</h3>
    <p class="mt-1 text-sm text-gray-500">Get started by creating a new item.</p>
    <div class="mt-6">
        <button class="btn-primary">Create New</button>
    </div>
</div>
```

## 🎯 Focus States

All interactive elements have proper focus states for accessibility:

```html
<button class="focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
    Accessible Button
</button>
```

## 📚 Icon Library

Using **Heroicons** (https://heroicons.com)

Example icons already used:
- Home icon (Dashboard)
- Users icon (User Management)
- Settings icon
- Search icon
- Menu icon (Hamburger)
- Check icon (Success)
- X icon (Close/Error)
- Plus icon (Add)
- Pencil icon (Edit)
- Trash icon (Delete)

---

**Tips:**
1. Always use semantic HTML
2. Maintain color contrast for accessibility
3. Use transitions for smooth UX
4. Test on multiple screen sizes
5. Keep consistency across the app
