<!-- Modal Overlay -->
<div 
    id="userModal" 
    class="modal-backdrop z-50 flex items-center justify-center p-4 opacity-0"
    style="display: none;"
>
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-500 scale-95 opacity-0 mx-2 sm:mx-0" id="modalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200">
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-900">Tambah User Baru</h3>
            <button 
                onclick="closeModal()"
                class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="userForm" method="POST" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" id="userId" name="user_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required
                        class="input-field text-base py-2 sm:py-3"
                        placeholder="John Doe"
                    >
                    <p id="nameError" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        class="input-field text-base py-2 sm:py-3"
                        placeholder="john@example.com"
                    >
                    <p id="emailError" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password <span id="passwordRequired" class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="input-field text-base py-2 sm:py-3 pr-32 sm:pr-36"
                        placeholder="Minimal 8 karakter"
                    >
                    <!-- Show/Hide Password Toggle -->
                    <button 
                        type="button" 
                        class="absolute inset-y-0 right-20 sm:right-24 flex items-center pr-2 z-10"
                        onclick="toggleUserPassword('password')"
                        title="Show/Hide Password"
                        tabindex="-1"
                    >
                        <svg id="password-eye-open" class="w-4 h-4 text-gray-400 hover:text-gray-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="password-eye-closed" class="w-4 h-4 text-gray-400 hover:text-gray-600 transition-colors duration-200 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                    <!-- Generate Password Button -->
                    <button 
                        type="button"
                        onclick="generatePassword()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs bg-brand-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-brand-600 transition z-10"
                        title="Generate Password"
                    >
                        Generate
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password (saat edit)</p>
                <p id="passwordError" class="mt-1 text-sm text-red-600 hidden"></p>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                    Role <span class="text-red-500">*</span>
                </label>
                <select 
                    id="role" 
                    name="role" 
                    required
                    class="input-field"
                >
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
                <p id="roleError" class="mt-1 text-sm text-red-600 hidden"></p>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    Catatan
                </label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="3"
                    class="input-field"
                    placeholder="Catatan tambahan tentang user..."
                ></textarea>
            </div>

            <!-- Is Active -->
            <div>
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        checked
                        class="h-4 w-4 text-brand-500 focus:ring-brand-500 border-gray-300 rounded"
                    >
                    <span class="ml-2 text-sm text-gray-700">User Aktif</span>
                </label>
                <p class="mt-1 text-xs text-gray-500">User yang tidak aktif tidak dapat login ke sistem</p>
            </div>

            <!-- Generated Password Display -->
            <div id="generatedPasswordDisplay" class="bg-green-50 border-l-4 border-green-500 p-4 rounded transition-all duration-300" style="display: none;">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">Password yang di-generate:</p>
                        <p id="generatedPasswordText" class="mt-1 text-sm text-green-700 font-mono"></p>
                        <p class="mt-1 text-xs text-green-600">Salin password ini dan berikan kepada user!</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <button 
                    type="button"
                    onclick="closeModal()"
                    class="btn-secondary"
                >
                    Batal
                </button>
                <button 
                    type="submit"
                    class="btn-primary"
                >
                    <span id="submitButtonText">Simpan User</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // User data for editing
    const usersData = @json($users->items());

    // Password toggle function for user form
    function toggleUserPassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const eyeOpen = document.getElementById(inputId + '-eye-open');
        const eyeClosed = document.getElementById(inputId + '-eye-closed');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
        
        // Maintain focus on input after toggle (important for mobile)
        passwordInput.focus();
    }

    function openCreateModal() {
        const modal = document.getElementById('userModal');
        const modalContent = document.getElementById('modalContent');
        
        // Reset form
        document.getElementById('userForm').reset();
        document.getElementById('userId').value = '';
        
        // Check if elements exist before setting properties
        const modalTitle = document.getElementById('modalTitle');
        const passwordRequired = document.getElementById('passwordRequired');
        const generatedPasswordField = document.getElementById('generatedPasswordField');
        
        if (modalTitle) modalTitle.textContent = 'Tambah User Baru';
        if (passwordRequired) passwordRequired.style.display = 'inline';
        if (generatedPasswordField) generatedPasswordField.style.display = 'none';
        
        // Show modal with smooth animation
        modal.style.display = 'flex';
        
        // Trigger reflow to ensure display change is applied
        modal.offsetHeight;
        
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        showInfo('Create User', 'Modal siap untuk menambah user baru');
    }

    function openEditModal(userId) {
        const user = usersData.find(u => u.id === userId);
        if (!user) return;

        document.getElementById('modalTitle').textContent = 'Edit User';
        document.getElementById('submitButtonText').textContent = 'Update User';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('userForm').action = `/users/${userId}`;
        document.getElementById('passwordRequired').style.display = 'none';
        document.getElementById('password').required = false;

        // Fill form
        document.getElementById('userId').value = user.id;
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('password').value = '';
        document.getElementById('role').value = user.roles[0]?.name || '';
        document.getElementById('notes').value = user.notes || '';
        document.getElementById('is_active').checked = user.is_active;
        
        document.getElementById('generatedPasswordDisplay').style.display = 'none';

        // Show modal with animation
        const modal = document.getElementById('userModal');
        const modalContent = document.getElementById('modalContent');
        modal.style.display = 'flex';
        modal.offsetHeight; // Trigger reflow
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('userModal');
        const modalContent = document.getElementById('modalContent');
        
        // Animate out
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        setTimeout(() => {
            modal.style.display = 'none';
            document.getElementById('userForm').reset();
        }, 300);
    }

    function generatePassword() {
        const length = 12;
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        let password = "";
        for (let i = 0, n = charset.length; i < length; ++i) {
            password += charset.charAt(Math.floor(Math.random() * n));
        }
        
        const passwordInput = document.getElementById('password');
        passwordInput.value = password;
        
        // Show the generated password display
        const generatedDisplay = document.getElementById('generatedPasswordDisplay');
        const generatedText = document.getElementById('generatedPasswordText');
        if (generatedDisplay && generatedText) {
            generatedDisplay.style.display = 'block';
            generatedDisplay.classList.add('animate-fadeInUp');
            generatedText.textContent = password;
        }
        
        // Temporarily show password as text for better UX
        passwordInput.type = 'text';
        const eyeOpen = document.getElementById('password-eye-open');
        const eyeClosed = document.getElementById('password-eye-closed');
        if (eyeOpen && eyeClosed) {
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        }
        
        // Focus on password field
        passwordInput.focus();
        
        showSuccess('Password Generated', 'Password baru telah dibuat secara otomatis!');
    }

    // Delete user with confirmation
    function deleteUser(userId, userName) {
        confirmDelete(userName, () => {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/users/${userId}`;
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Add method override
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            
            showInfo('Deleting User', 'Menghapus user...');
            form.submit();
        });
    }

    // Toggle user status with confirmation
    function toggleUserStatus(userId, userName, currentStatus) {
        const action = currentStatus ? 'menonaktifkan' : 'mengaktifkan';
        const confirmFunction = currentStatus ? confirmDisable : confirmEnable;
        
        confirmFunction(userName, () => {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/users/${userId}/toggle-status`;
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Add method override
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PATCH';
            
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            
            showInfo('Updating Status', `${action} user...`);
            form.submit();
        });
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    // Close modal on overlay click
    document.getElementById('userModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeModal();
        }
    });

    // Prevent eye button from submitting form and add event listeners when DOM loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Prevent password toggle button from submitting form
        const eyeButton = document.querySelector('button[onclick*="toggleUserPassword"]');
        if (eyeButton) {
            eyeButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        }

        // Prevent generate password button from submitting form
        const generateButton = document.querySelector('button[onclick*="generatePassword"]');
        if (generateButton) {
            generateButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        }
    });
</script>
