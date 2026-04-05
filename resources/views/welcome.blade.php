<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Figtree', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 underline">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 underline">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 underline">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <h1 class="text-6xl font-bold text-gray-800 text-center mb-4">
                        {{ config('app.name', 'IQBAL') }} E-Commerce
                    </h1>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div class="flex items-start gap-4 rounded-lg p-6 bg-white shadow">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Welcome to IQBAL</h3>
                                <p class="mt-2 text-gray-500">Your e-commerce platform is ready to use. Browse our products and enjoy shopping!</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 rounded-lg p-6 bg-white shadow">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Get Started</h3>
                                <p class="mt-2 text-gray-500">
                                    @auth
                                        Visit your <a href="{{ url('/dashboard') }}" class="text-blue-600 hover:text-blue-800">dashboard</a> to manage your account.
                                    @else
                                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Log in</a> or <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">register</a> to get started.
                                    @endauth
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <p class="text-gray-600">
                        {{ config('app.name', 'IQBAL') }} © {{ date('Y') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
