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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                background-image: url('{{ asset('images/couple1.jpg') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .content-container {
                background: rgba(255, 255, 255, 0.95); /* Less transparent for better readability */
                padding: 2rem;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                width: 100%;
                max-width: 420px;
            }

            .content-container h1 {
                margin-bottom: 1.5rem;
                text-align: center;
                color: #333;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: bold;
                color: #555;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 0.5rem;
                border-radius: 6px;
                border: 1px solid #ccc;
            }

            .actions {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .btn-primary {
                background-color: #111827;
                color: white;
                border: none;
                padding: 0.6rem 1.2rem;
                border-radius: 6px;
                cursor: pointer;
            }

            .btn-primary:hover {
                background-color: #1f2937;
            }

            .link {
                font-size: 0.9rem;
                color: #3b82f6;
                text-decoration: none;
            }

            .link:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="content-container">
            {{ $slot }}
        </div>
    </body>
</html>
