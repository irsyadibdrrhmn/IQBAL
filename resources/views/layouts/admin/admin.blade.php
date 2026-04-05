<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body class="bg-cover bg-center min-h-screen" style="background-image: url('{{ asset('images/bg.jpeg') }}')">


    <div class="flex h-screen bg-amber-100 bg-opacity-80 ">
        <!-- Sidebar -->
          @include('layouts.admin.sidebar')

        <!-- Content -->
        <div class="flex flex-col flex-1 md:pl-50">
            <header class="sticky top-0 z-20 flex items-center justify-between gap-4 bg-white p-4 shadow-md md:hidden">
                <button id="sidebarOpenBtn" aria-label="Open sidebar"
                    class="text-gray-700 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 rounded">
                    ☰
                </button>
                <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')

            </main>
        </div>

        <script>
            const sidebar = document.getElementById('sidebar');
            const sidebarOpenBtn = document.getElementById('sidebarOpenBtn');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

            sidebarOpenBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
            });

            sidebarCloseBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
            });

            // Initially hide sidebar on mobile
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
            }

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        </script>
    </div>



</body>

</html>
