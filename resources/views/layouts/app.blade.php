<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Feedback Hub — TI ITS</title>

    {{-- Bootstrap 5 via CDN --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --its-blue: #003f7d;
            --its-blue-light: #0056a8;
            --its-accent: #e8f0fb;
        }

        body {
            background-color: #f4f6fb;
            min-height: 100vh;
        }

        .navbar-its {
            background-color: var(--its-blue);
        }

        .site-header {
            background: linear-gradient(135deg, var(--its-blue) 0%, var(--its-blue-light) 100%);
            color: #fff;
            padding: 2.5rem 1rem 2rem;
        }

        .site-header h1 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            line-height: 1.1;
        }

        .site-header p {
            font-size: 1rem;
            opacity: 0.88;
        }

        .card-feedback {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0, 63, 125, 0.10);
        }

        .btn-its {
            background-color: var(--its-blue);
            border-color: var(--its-blue);
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .btn-its:hover,
        .btn-its:focus {
            background-color: var(--its-blue-light);
            border-color: var(--its-blue-light);
            color: #fff;
        }

        .captcha-box {
            background-color: var(--its-accent);
            border: 2px dashed #a8c4e8;
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
        }

        footer {
            color: #6c757d;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-its navbar-expand-lg">
        <div class="container">
            <span class="navbar-brand text-white fw-bold">
                <i class="bi bi-shield-lock-fill me-2"></i>Secure Feedback Hub
            </span>
        </div>
    </nav>

    {{-- Header --}}
    <header class="site-header text-center">
        <div class="container">
            <h1>SECURE<br>FEEDBACK HUB</h1>
            <p class="mt-2 mb-0">Portal Aspirasi Mahasiswa Teknik Informatika ITS</p>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center py-4">
        <div class="container">
            &copy; {{ date('Y') }} Secure Feedback Hub — Teknik Informatika ITS
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmFE4SXv1oDg4iGSdL1oM0F6B0I5"
        crossorigin="anonymous"
    ></script>
</body>
</html>
