<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Multi User</title>
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
                <h3 class="text-2xl font-bold text-orange-500 mb-1">Login</h3>
                <button class="text-orange-500 text-sm hover:text-orange-600 transition">
                    Sign Up <span class="ml-1">→</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Right Panel - White -->
    <div class="w-3/5 bg-white p-12 flex flex-col justify-center">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <div class="relative w-32 h-32">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-16 h-16 border-4 border-orange-400 rounded-full"></div>
                    <div class="w-16 h-16 border-4 border-orange-500 rounded-full absolute top-4 left-6"></div>
                    <div class="w-16 h-16 border-4 border-orange-600 rounded-full absolute top-8 left-3"></div>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Alert (for backend errors) -->
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Client-side Error Alert -->
        <div id="clientErrorAlert" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded items-center hidden">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="font-semibold mb-1">Terjadi Kesalahan:</p>
                    <ul id="errorList" class="list-disc list-inside text-sm"></ul>
                </div>
            </div>
        </div>

        <form id="loginForm" method="POST" action="{{ route('login.action') }}">
            @csrf

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
            <div class="mb-6">
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <input type="password" id="password" name="password" placeholder="Password" 
                           class="flex-1 outline-none text-gray-700 placeholder-gray-400">
                </div>
                <p id="passwordError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-full transition duration-300 shadow-lg">
                Get Started
            </button>

            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-4 text-gray-400 text-sm">OR</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>
        </form>

        <div class="text-center mt-6 text-gray-600">
            Belum punya akun? <a href="{{ route('register.customer') }}" class="text-orange-500 hover:text-orange-600 font-semibold">Register</a>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset semua error
        document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('input').forEach(input => {
            input.parentElement.classList.remove('border-red-500');
            input.parentElement.classList.add('border-gray-300');
        });
        document.getElementById('clientErrorAlert').classList.add('hidden');
        
        let errors = [];
        
        // Validasi Email
        const email = document.getElementById('email');
        if (email.value.trim() === '') {
            errors.push('Email harus diisi');
            showFieldError('emailError', 'Email harus diisi');
            highlightError(email);
        } else if (!isValidEmail(email.value)) {
            errors.push('Format email tidak valid');
            showFieldError('emailError', 'Format email tidak valid');
            highlightError(email);
        }
        
        // Validasi Password
        const password = document.getElementById('password');
        if (password.value === '') {
            errors.push('Password harus diisi');
            showFieldError('passwordError', 'Password harus diisi');
            highlightError(password);
        } else if (password.value.length < 6) {
            errors.push('Password minimal 6 karakter');
            showFieldError('passwordError', 'Password minimal 6 karakter');
            highlightError(password);
        }
        
        // Tampilkan alert jika ada error
        if (errors.length > 0) {
            showErrorAlert(errors);
            return false;
        }
        
        // Submit form jika valid
        this.submit();
    });
    
    function showFieldError(elementId, message) {
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
    
    function showErrorAlert(errors) {
        const alert = document.getElementById('clientErrorAlert');
        const errorList = document.getElementById('errorList');
        
        // Clear previous errors
        errorList.innerHTML = '';
        
        // Add new errors
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        
        // Show alert
        alert.classList.remove('hidden');
        alert.classList.add('flex');
        
        // Scroll to alert
        alert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
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
            
            // Hide alert if all inputs are being corrected
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            if (email.value.trim() !== '' && password.value !== '') {
                document.getElementById('clientErrorAlert').classList.add('hidden');
            }
        });
    });
</script>

</body>
</html>