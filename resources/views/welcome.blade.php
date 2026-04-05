<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - E-Commerce</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS for styling -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
            }
            .welcome-container {
                background: white;
                border-radius: 10px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                padding: 60px 40px;
            }
            .welcome-header {
                text-align: center;
                margin-bottom: 40px;
            }
            .welcome-header h1 {
                color: #333;
                font-weight: 700;
                margin-bottom: 10px;
            }
            .welcome-header p {
                color: #666;
                font-size: 18px;
            }
            .feature-box {
                text-align: center;
                padding: 30px;
                margin-bottom: 20px;
            }
            .feature-icon {
                font-size: 48px;
                margin-bottom: 15px;
            }
            .btn-custom {
                padding: 12px 30px;
                font-size: 16px;
                margin: 10px;
                border-radius: 5px;
            }
            .btn-login {
                background-color: #667eea;
                color: white;
            }
            .btn-login:hover {
                background-color: #5568d3;
                color: white;
            }
            .btn-register {
                background-color: #764ba2;
                color: white;
            }
            .btn-register:hover {
                background-color: #62398f;
                color: white;
            }
            .auth-links {
                text-align: right;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            @if (Route::has('login'))
                <div class="auth-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-custom btn-login">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-custom btn-login">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-sm btn-custom btn-register">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="welcome-container">
                <div class="welcome-header">
                    <h1>🛍️ {{ config('app.name', 'IQBAL') }} E-Commerce</h1>
                    <p>Welcome to your shopping destination</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-box">
                            <div class="feature-icon">⚡</div>
                            <h3>Fast & Reliable</h3>
                            <p>Shop with confidence on our fast and secure platform</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-box">
                            <div class="feature-icon">🔒</div>
                            <h3>Secure Checkout</h3>
                            <p>Your data is encrypted and protected at all times</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-box">
                            <div class="feature-icon">📦</div>
                            <h3>Fast Shipping</h3>
                            <p>Get your orders delivered quickly to your doorstep</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-box">
                            <div class="feature-icon">💬</div>
                            <h3>Support</h3>
                            <p>Our customer service team is here to help you</p>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 40px;">
                    @auth
                        <p>Ready to shop? <a href="{{ url('/dashboard') }}" class="btn btn-custom btn-login">Go to Dashboard</a></p>
                    @else
                        <p>
                            <a href="{{ route('register') }}" class="btn btn-custom btn-register">Create Account</a>
                            <a href="{{ route('login') }}" class="btn btn-custom btn-login">Sign In</a>
                        </p>
                    @endauth
                </div>

                <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <p style="color: #999; font-size: 14px;">
                        {{ config('app.name', 'IQBAL') }} © {{ date('Y') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
