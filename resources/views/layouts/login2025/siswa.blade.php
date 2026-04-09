<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Ujian Online</title>
    <!-- Modern Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            /* Color Palette - Blue & White Minimalist */
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-color: #eff6ff;
            /* Soft blue background */
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --input-focus-ring: #bfdbfe;
            --error-bg: #fef2f2;
            --error-text: #ef4444;
            --error-border: #fecaca;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #eff6ff !important;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-main);
            position: relative;
            overflow: hidden;
            background-image: radial-gradient(circle at top right, #dbeafe 0%, transparent 40%),
                radial-gradient(circle at bottom left, #dbeafe 0%, transparent 40%);
        }

        body::before,
        body::after {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            animation: float 20s infinite ease-in-out alternate;
        }

        body::before {
            background: rgba(59, 130, 246, 0.3);
            /* Soft Blue */
            top: -10vh;
            left: -10vw;
        }

        body::after {
            background: rgba(37, 99, 235, 0.2);
            /* Deep Blue */
            bottom: -10vh;
            right: -10vw;
            animation-duration: 25s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(100px, 100px) scale(1.2);
            }
        }

        .login-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            border-radius: 28px;
            box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-out;
            border: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header .icon-wrapper {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 64px;
            height: 64px;
            background-color: #eff6ff;
            border-radius: 16px;
            color: var(--primary-color);
            font-size: 2.2rem;
            margin-bottom: 1rem;
            border: 1px solid #dbeafe;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.4rem;
            letter-spacing: -0.02em;
        }

        .login-header p {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .error-message {
            background-color: var(--error-bg);
            color: var(--error-text);
            padding: 0.875rem;
            border-radius: 10px;
            font-size: 0.875rem;
            text-align: center;
            margin-bottom: 1.5rem;
            border: 1px solid var(--error-border);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .input-group {
            margin-bottom: 1.25rem;
        }

        .input-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .input-field {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-field i {
            position: absolute;
            left: 1rem;
            color: var(--text-muted);
            font-size: 1.25rem;
            transition: color 0.2s ease;
        }

        .input-field input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: all 0.2s ease;
            outline: none;
            background-color: #f8fafc;
        }

        .input-field input::placeholder {
            color: #94a3b8;
        }

        .input-field input:focus {
            background-color: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px var(--input-focus-ring);
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%) !important;
            /* Soft to Deep Blue! */
            color: #ffffff;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            padding: 12px 24px;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4) !important;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .footer-note {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-wrapper {
                margin: 1rem;
                padding: 2rem 1.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-header">
            <img style="height:68px" src="{{ asset('logo-tutwurihandayani.png') }}" alt="">

            <h1>Portal Ujian</h1>
            <p>Silakan login untuk memulai sesi ujian Anda.</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <i class='bx bx-error-circle'></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('auth.siswa') }}" method="post">
            @csrf
            <div class="input-group">
                <label for="nis">Nomor Induk Siswa (NIS)</label>
                <div class="input-field">
                    <i class='bx bx-user'></i>
                    <input type="text" id="nis" name="nis" value="{{ old('nis') }}"
                        placeholder="Masukkan NIS" required autocomplete="off">
                </div>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-field">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Masuk Ujian <i class='bx bx-right-arrow-alt'></i>
            </button>
        </form>

        <div class="footer-note">
            Sistem Ujian Berbasis Komputer (CAT)<br>
            Tingkat SD / SMP / SMA &copy; {{ date('Y') }}
        </div>
    </div>

</body>

</html>
