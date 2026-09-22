<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Feedback Hub — TI ITS</title>

    {{-- Google Fonts: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
            --sf-blue-50: #F0F9FF;
            --sf-blue-100: #E0F2FE;
            --sf-blue-200: #BAE6FD;
            --sf-blue-300: #7DD3FC;
            --sf-blue-400: #38BDF8;
            --sf-blue-500: #0EA5E9;
            --sf-blue-600: #0284C7;
            --sf-blue-700: #0369A1;
            --sf-blue-900: #0C4A6E;
            --sf-slate-900: #0F172A;
            --sf-slate-600: #475569;
            --sf-slate-500: #64748B;
            --sf-slate-400: #94A3B8;
            --sf-slate-200: #E2E8F0;
            --sf-white: #FFFFFF;
            --sf-success: #14B8A6;
            --sf-danger: #F43F5E;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(180deg, var(--sf-blue-50) 0%, var(--sf-blue-100) 100%);
            color: var(--sf-slate-600);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-minimal {
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .navbar-brand {
            color: var(--sf-slate-900) !important;
        }

        .navbar-brand i {
            color: var(--sf-blue-500);
        }

        .site-hero {
            background: linear-gradient(180deg, var(--sf-blue-100) 0%, var(--sf-blue-50) 100%);
            padding: 3rem 1rem 2.5rem;
        }

        .site-hero h1 {
            color: var(--sf-blue-900);
            font-weight: 800;
            font-size: clamp(2rem, 5vw, 2.5rem);
            letter-spacing: 0.02em;
            line-height: 1.2;
        }

        .site-hero p {
            color: var(--sf-slate-600);
        }

        .hero-badge {
            background-color: var(--sf-blue-100);
            color: var(--sf-blue-700);
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 50rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            border: 1px solid var(--sf-blue-200);
        }

        main.container {
            max-width: 72rem;
            flex: 1;
        }

        .card-feedback {
            background-color: var(--sf-white);
            border-radius: 1.25rem;
            border: 1px solid rgba(125, 211, 252, 0.4);
            box-shadow: 0 10px 40px -12px rgba(2, 132, 199, 0.12);
        }
        
        .card-title-sf {
            color: var(--sf-blue-700);
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.02em;
        }

        .form-label {
            color: var(--sf-slate-900);
            font-weight: 600;
            font-size: 0.875rem;
        }

        .form-control, .form-select {
            border-color: var(--sf-slate-200);
            border-radius: 0.625rem;
            padding: 0.75rem 1rem;
            color: var(--sf-slate-900);
        }
        
        .form-control::placeholder {
            color: var(--sf-slate-400);
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--sf-blue-50);
            border-color: var(--sf-blue-500);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
            outline: none;
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--sf-danger);
            background-image: none;
        }

        .form-control.is-invalid:focus, .form-select.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.15);
            border-color: var(--sf-danger);
        }

        .invalid-feedback {
            color: var(--sf-danger);
            font-size: 0.875rem;
            font-weight: 500;
            display: block;
        }

        .captcha-box {
            background-color: var(--sf-blue-50);
            border: 2px dashed var(--sf-blue-300);
            border-radius: 0.75rem;
            padding: 1.25rem;
        }

        .captcha-box i {
            color: var(--sf-blue-500);
        }

        .btn-primary-sf {
            background: linear-gradient(to right, var(--sf-blue-500), var(--sf-blue-600));
            color: var(--sf-white);
            border: none;
            border-radius: 50rem;
            font-weight: 600;
            padding: 0.75rem 2rem;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
            transition: all 0.2s;
        }

        .btn-primary-sf:hover, .btn-primary-sf:focus {
            background: linear-gradient(to right, var(--sf-blue-400), var(--sf-blue-500));
            color: var(--sf-white);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(14, 165, 233, 0.3);
        }
        
        .success-icon-bg {
            background-color: var(--sf-blue-100);
            width: 84px;
            height: 84px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .success-icon {
            color: var(--sf-success);
            font-size: 3.5rem;
        }

        footer {
            color: var(--sf-slate-500);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-minimal navbar-expand-lg sticky-top">
        <div class="container">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-shield-check me-2"></i>Secure Feedback Hub
            </span>
        </div>
    </nav>

    {{-- Header --}}
    <header class="site-hero text-center">
        <div class="container">
            <div class="mb-3">
                <span class="hero-badge">
                    <i class="bi bi-shield-fill-check"></i> Aman & Terverifikasi
                </span>
            </div>
            <h1>SECURE FEEDBACK HUB</h1>
            <p class="mt-2 mb-0">Portal Aspirasi Mahasiswa Teknik Informatika ITS</p>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="container py-5">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center py-4 mt-auto">
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
