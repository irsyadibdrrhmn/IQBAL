<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Multi User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="flex w-full max-w-5xl shadow-2xl rounded-lg overflow-hidden">
    <!-- Left Panel - Orange Gradient -->
    <div class="w-2/5 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 p-8 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2 text-white mb-4">
                <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                </div>
                <span class="font-semibold">Home</span>
            </div>
            <div class="flex items-center gap-2 text-white">
                <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                        <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
                    </svg>
                </div>
                <span class="font-semibold">Dashboard</span>
            </div>
        </div>
        
        <div class="mt-auto">
            <div class="bg-white rounded-lg p-4 shadow-lg inline-block">
                <h3 class="text-2xl font-bold text-orange-500 mb-1">Register</h3>
                <button class="text-orange-500 text-sm hover:text-orange-600 transition">
                    Sign In <span class="ml-1">→</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Right Panel - White -->
    <div class="w-3/5 bg-white p-12 flex flex-col justify-center">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="relative w-24 h-24">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-12 h-12 border-4 border-orange-400 rounded-full"></div>
                    <div class="w-12 h-12 border-4 border-orange-500 rounded-full absolute top-3 left-4"></div>
                    <div class="w-12 h-12 border-4 border-orange-600 rounded-full absolute top-6 left-2"></div>
                </div>
            </div>
        </div>

        <form id="registerForm" method="POST" action="{{ route('register.action') }}">
            @csrf

            <!-- Hidden Role Field (Default: customer) -->
            <input type="hidden" name="role" value="customer">

            <!-- Name Input -->
            <div class="mb-4">
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    <input type="text" id="name" name="name" placeholder="Nama Lengkap" 
                           class="flex-1 outline-none text-gray-700 placeholder-gray-400">
                </div>
                <p id="nameError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <!-- Email Input -->
            <div class="mb-4">
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <input type="email" id="email" name="email" placeholder="Email" 
                           class="flex-1 outline-none text-gray-700 placeholder-gray-400">
                </div>
                <p id="emailError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <input type="password" id="password" name="password" placeholder="Password" 
                           class="flex-1 outline-none text-gray-700 placeholder-gray-400">
                </div>
                <p id="passwordError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <!-- Password Confirmation Input -->
            <div class="mb-6">
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" 
                           class="flex-1 outline-none text-gray-700 placeholder-gray-400">
                </div>
                <p id="confirmError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-full transition duration-300 shadow-lg">
                Create Account
            </button>

            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-4 text-gray-400 text-sm">OR</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>
        </form>

        <div class="text-center mt-6 text-gray-600">
            Sudah punya akun? <a href="{{ route('login.form') }}" class="text-orange-500 hover:text-orange-600 font-semibold">Login</a>
        </div>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset semua error
        document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('input').forEach(input => {
            input.parentElement.classList.remove('border-red-500');
            input.parentElement.classList.add('border-gray-300');
        });
        
        let isValid = true;
        
        // Validasi Nama
        const name = document.getElementById('name');
        if (name.value.trim() === '') {
            showError('nameError', 'Nama lengkap harus diisi');
            highlightError(name);
            isValid = false;
        }
        
        // Validasi Email
        const email = document.getElementById('email');
        if (email.value.trim() === '') {
            showError('emailError', 'Email harus diisi');
            highlightError(email);
            isValid = false;
        } else if (!isValidEmail(email.value)) {
            showError('emailError', 'Format email tidak valid');
            highlightError(email);
            isValid = false;
        }
        
        // Validasi Password
        const password = document.getElementById('password');
        if (password.value === '') {
            showError('passwordError', 'Password harus diisi');
            highlightError(password);
            isValid = false;
        } else if (password.value.length < 6) {
            showError('passwordError', 'Password minimal 6 karakter');
            highlightError(password);
            isValid = false;
        }
        
        // Validasi Konfirmasi Password
        const confirmPassword = document.getElementById('password_confirmation');
        if (confirmPassword.value === '') {
            showError('confirmError', 'Konfirmasi password harus diisi');
            highlightError(confirmPassword);
            isValid = false;
        } else if (password.value !== confirmPassword.value) {
            showError('confirmError', 'Password tidak cocok');
            highlightError(confirmPassword);
            isValid = false;
        }
        
        // Submit form jika valid
        if (isValid) {
            this.submit();
        }
    });
    
    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    }
    
    function highlightError(input) {
        input.parentElement.classList.remove('border-gray-300');
        input.parentElement.classList.add('border-red-500');
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Real-time validation untuk menghilangkan error saat user mengetik
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            const errorId = this.id + 'Error';
            const errorElement = document.getElementById(errorId);
            if (errorElement && !errorElement.classList.contains('hidden')) {
                errorElement.classList.add('hidden');
                this.parentElement.classList.remove('border-red-500');
                this.parentElement.classList.add('border-gray-300');
            }
        });
    });
</script>

</body>
</html>