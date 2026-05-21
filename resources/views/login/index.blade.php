<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Faculty Document Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --crimson: #8B1A1A;
            --crimson-dark: #6B1010;
            --warm-white: #FFFFFF;
            --text-dark: #1A1412;
            --text-mid: #4A3F3A;
            --text-muted: #8C7B74;
            --border: rgba(139,26,26,0.12);
            --shadow-sm: 0 2px 12px rgba(139,26,26,0.08);
            --shadow-lg: 0 24px 64px rgba(139,26,26,0.18);
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(139,26,26,0.06) 0%, transparent 50%),
                radial-gradient(circle at 85% 80%, rgba(139,26,26,0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .logo-banner {
            background: var(--crimson);
            padding: 20px 48px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 1;
        }
        .logo-banner img {
            width: 64px; height: 64px;
            object-fit: cover; border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.4);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .logo-banner .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 22px; font-weight: 900; color: white; line-height: 1.1;
        }
        .logo-banner .brand-sub {
            font-size: 11px; color: rgba(255,255,255,0.7);
            letter-spacing: 0.08em; text-transform: uppercase; margin-top: 2px;
        }

        .page-wrapper {
            position: relative; z-index: 1;
            min-height: calc(100vh - 104px);
            display: flex; align-items: center; justify-content: center;
            padding: 48px 24px;
        }

        .login-card {
            background: var(--warm-white);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
            width: 100%; max-width: 440px;
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }

        .card-header {
            background: var(--crimson);
            padding: 24px 28px;
            display: flex; align-items: center; gap: 14px;
        }
        .card-header .seal {
            width: 48px; height: 48px; border-radius: 50%;
            border: 2.5px solid rgba(255,255,255,0.35);
            overflow: hidden; flex-shrink: 0;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            color: white; font-family: 'Playfair Display', serif;
            font-weight: 900; font-size: 15px;
        }
        .card-header .ht-title {
            font-family: 'Playfair Display', serif;
            font-size: 17px; font-weight: 700; color: #fff; line-height: 1.1;
        }
        .card-header .ht-sub {
            font-size: 11px; color: rgba(255,255,255,0.65);
            letter-spacing: 0.07em; text-transform: uppercase; margin-top: 2px;
        }

        .card-body { padding: 28px 28px 24px; }

        .role-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(139,26,26,0.08);
            border: 1px solid rgba(139,26,26,0.2);
            padding: 5px 14px; border-radius: 100px; margin-bottom: 20px;
        }
        .role-badge .dot {
            width: 6px; height: 6px; background: var(--crimson);
            border-radius: 50%; animation: pulse 2s infinite;
        }
        .role-badge span {
            font-size: 11px; font-weight: 600; color: var(--crimson);
            letter-spacing: 0.06em; text-transform: uppercase;
        }

        .card-body h2 {
            font-family: 'Playfair Display', serif;
            font-size: 26px; font-weight: 900;
            color: var(--text-dark); line-height: 1.1; margin-bottom: 6px;
        }
        .card-body h2 em { font-style: italic; color: var(--crimson); }
        .card-body .subtitle {
            font-size: 13px; color: var(--text-muted);
            margin-bottom: 28px; line-height: 1.6;
        }

        /* ── FIELD ── */
        .field { margin-bottom: 16px; }
        .field label {
            display: block; font-size: 11px; font-weight: 600;
            color: var(--text-mid); letter-spacing: 0.05em;
            text-transform: uppercase; margin-bottom: 7px;
        }
        .field-wrap { position: relative; display: flex; align-items: center; }
        .field-icon {
            position: absolute; left: 12px;
            color: var(--text-muted); pointer-events: none; display: flex;
        }
        .field input[type="text"],
        .field input[type="password"] {
            width: 100%;
            padding: 11px 12px 11px 40px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; color: var(--text-dark);
            background: var(--cream);
            border: 1.5px solid rgba(139,26,26,0.18);
            border-radius: 8px; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field input:focus {
            border-color: var(--crimson);
            box-shadow: 0 0 0 3px rgba(139,26,26,0.1);
            background: var(--warm-white);
        }
        .field input::placeholder { color: #C4B5AE; }
        .field input.is-invalid {
            border-color: var(--crimson);
            background: rgba(139,26,26,0.03);
        }

        /* ── ERROR MESSAGE ── */
        .field-error {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: var(--crimson); margin-top: 6px;
        }
        .field-error svg { flex-shrink: 0; }

        .eye-btn {
            position: absolute; right: 10px;
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); padding: 4px; display: flex;
            transition: color 0.2s;
        }
        .eye-btn:hover { color: var(--crimson); }

        .field-meta { display: flex; justify-content: flex-end; margin-top: 7px; }
        .field-meta a {
            font-size: 12px; color: var(--crimson);
            text-decoration: none; font-weight: 500; transition: opacity 0.2s;
        }
        .field-meta a:hover { opacity: 0.7; }

        .remember-row {
            display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
        }
        .remember-row input[type="checkbox"] {
            width: 16px; height: 16px; accent-color: var(--crimson); cursor: pointer;
        }
        .remember-row label { font-size: 13px; color: var(--text-mid); cursor: pointer; }

        .divider { height: 1px; background: rgba(139,26,26,0.1); margin: 20px 0; }

        .btn-sign-in {
            width: 100%; padding: 13px; background: var(--crimson);
            color: white; border: none; border-radius: 8px;
            font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            gap: 10px;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(139,26,26,0.35);
        }
        .btn-sign-in:hover {
            background: var(--crimson-dark); transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(139,26,26,0.4);
        }
        .btn-sign-in:active { transform: scale(0.98); }
        .btn-sign-in svg { transition: transform 0.2s; }
        .btn-sign-in:hover svg { transform: translateX(3px); }

        .card-footer {
            border-top: 1px solid rgba(139,26,26,0.08);
            padding: 14px 28px;
            display: flex; align-items: center; justify-content: center; gap: 6px;
            background: rgba(250,247,242,0.6);
        }
        .card-footer svg { color: var(--crimson); flex-shrink: 0; }
        .card-footer span { font-size: 12px; color: var(--text-muted); }
        .card-footer strong { color: var(--text-mid); font-weight: 600; }

        footer {
            position: relative; z-index: 1;
            padding: 20px 48px;
            display: flex; align-items: center; justify-content: space-between;
            max-width: 1280px; margin: 0 auto; width: 100%;
        }
        footer p { font-size: 12px; color: var(--text-muted); }
        footer p strong { color: var(--crimson); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
        }
    </style>
</head>
<body>

    {{-- ── PAGE WRAPPER ── --}}
    <div class="page-wrapper">
        <div class="login-card">

            {{-- ── CARD HEADER ── --}}
            <div class="card-header">
                <div class="seal">LogTrack</div>
                <div>
                    <div class="ht-title">Faculty Document Manager</div>
                    <div class="ht-sub">Eastern Visayas State University</div>
                </div>
            </div>

            {{-- ── CARD BODY ── --}}
            <div class="card-body">

                <h2>Welcome <em>back</em></h2>
                <p class="subtitle">Log in to access your document submissions and records.</p>

                {{-- ── FORM ── --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- User ID --}}
                    <div class="field">
                        <label for="user_id">User ID</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <path d="M16 2v4M8 2v4M3 10h18"/>
                                    <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                id="user_id"
                                name="user_id"
                                value="{{ old('user_id') }}"
                                placeholder="e.g. XXXX-2026"
                                autocomplete="username"
                                autofocus
                                class="{{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                            >
                        </div>
                        @error('user_id')
                            <p class="field-error">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label for="password">Password</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            >
                            <button type="button" class="eye-btn" onclick="togglePassword()" aria-label="Toggle password visibility">
                                <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="field-error">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="field-meta">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="remember-row">
                        <input type="checkbox" id="remember_me" name="remember">
                        <label for="remember_me">Keep me signed in</label>
                    </div>

                    <div class="divider"></div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-sign-in">
                        Log In
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>

                </form>
            </div>

            {{-- ── CARD FOOTER ── --}}
            <div class="card-footer">
                <span>·</span>
                <span>AY 2025–2026</span>
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? `<line x1="1" y1="1" x2="23" y2="23"/>
                   <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                   <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                   <path d="M6.53 6.53A10 10 0 0 0 1 12s4 8 11 8a9.9 9.9 0 0 0 5.47-1.53"/>`
                : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                   <circle cx="12" cy="12" r="3"/>`;
        }
    </script>

</body>
</html>