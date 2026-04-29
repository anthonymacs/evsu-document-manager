<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Document Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --crimson: #8B1A1A;
            --crimson-dark: #6B1010;
            --cream: #FAF7F2;
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
            background: var(--cream);
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

        .page-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── HEADER ── */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            height: 72px;
            background: var(--warm-white);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo-group { display: flex; align-items: center; gap: 14px; }

        .logo-seal {
            width: 44px; height: 44px;
            background: var(--crimson);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-family: 'Playfair Display', serif;
            font-weight: 900; font-size: 16px; letter-spacing: -1px;
            box-shadow: 0 2px 8px rgba(139,26,26,0.3);
        }

        .logo-text { display: flex; flex-direction: column; }

        .logo-text .brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 17px;
            color: var(--crimson); line-height: 1.1;
        }

        .logo-text .tagline {
            font-size: 11px; color: var(--text-muted);
            font-weight: 400; letter-spacing: 0.08em; text-transform: uppercase;
        }

        nav { display: flex; align-items: center; gap: 32px; }

        nav a {
            text-decoration: none; font-size: 14px; font-weight: 500;
            color: var(--text-mid); transition: color 0.2s;
        }
        nav a:hover { color: var(--crimson); }

        .btn-login {
            padding: 8px 20px;
            border: 1.5px solid var(--crimson);
            background: transparent; color: var(--crimson);
            border-radius: 6px; font-family: 'DM Sans', sans-serif;
            font-size: 13px; font-weight: 600; cursor: pointer;
            transition: all 0.2s; text-decoration: none; display: inline-block;
        }
        .btn-login:hover { background: rgba(139,26,26,0.06); }

        /* ── HERO ── */
        .hero {
            flex: 1;
            display: grid; grid-template-columns: 1fr 1fr;
            max-width: 1280px; margin: 0 auto;
            padding: 80px 48px 60px;
            align-items: center; width: 100%; gap: 48px;
        }

        .hero-left { padding-right: 32px; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(139,26,26,0.08);
            border: 1px solid rgba(139,26,26,0.2);
            padding: 6px 14px; border-radius: 100px;
            margin-bottom: 28px;
            animation: fadeUp 0.6s ease both;
        }

        .hero-badge .dot {
            width: 6px; height: 6px;
            background: var(--crimson); border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .hero-badge span {
            font-size: 12px; font-weight: 600; color: var(--crimson);
            letter-spacing: 0.06em; text-transform: uppercase;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 4vw, 58px); font-weight: 900;
            line-height: 1.08; color: var(--text-dark);
            margin-bottom: 24px;
            animation: fadeUp 0.6s 0.1s ease both;
        }
        h1 em { font-style: italic; color: var(--crimson); }

        .hero-desc {
            font-size: 16px; line-height: 1.7; color: var(--text-mid);
            max-width: 480px; margin-bottom: 40px;
            animation: fadeUp 0.6s 0.2s ease both;
        }

        .cta-group {
            display: flex; align-items: center; gap: 16px;
            animation: fadeUp 0.6s 0.3s ease both;
        }

        .btn-launch {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 14px 32px; background: var(--crimson); color: white;
            border: none; border-radius: 8px;
            font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600;
            cursor: pointer; transition: all 0.25s;
            box-shadow: 0 4px 20px rgba(139,26,26,0.35); text-decoration: none;
        }
        .btn-launch:hover {
            background: var(--crimson-dark); color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(139,26,26,0.4);
        }
        .btn-launch svg { transition: transform 0.2s; }
        .btn-launch:hover svg { transform: translateX(3px); }

        .btn-learn {
            font-size: 14px; font-weight: 500; color: var(--text-mid);
            background: none; border: none; cursor: pointer;
            display: flex; align-items: center; gap: 6px;
            transition: color 0.2s; text-decoration: none;
        }
        .btn-learn:hover { color: var(--crimson); }

        /* ── PREVIEW CARD ── */
        .hero-right { animation: fadeIn 0.8s 0.3s ease both; }

        .preview-card {
            background: white; border-radius: 16px;
            box-shadow: var(--shadow-lg); overflow: hidden;
            border: 1px solid var(--border);
        }

        .preview-header {
            background: var(--crimson); padding: 16px 20px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .preview-header .ph-title {
            font-family: 'Playfair Display', serif;
            font-size: 15px; font-weight: 700; color: white;
        }
        .preview-header .ph-dots { display: flex; gap: 5px; }
        .preview-header .ph-dots span {
            width: 8px; height: 8px; border-radius: 50%;
            background: rgba(255,255,255,0.35);
        }

        .preview-body { padding: 24px; }

        .preview-desc {
            font-size: 13px; color: var(--text-muted);
            line-height: 1.6; margin-bottom: 20px;
        }

        .doc-types {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;
        }

        .doc-type-item {
            display: flex; align-items: center; gap: 10px;
            background: var(--cream); border: 1px solid var(--border);
            border-radius: 10px; padding: 12px 14px;
        }

        .doc-type-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

        .doc-type-item .dt-label { font-size: 13px; font-weight: 600; color: var(--text-dark); }
        .doc-type-item .dt-sub   { font-size: 11px; color: var(--text-muted); margin-top: 1px; }

        /* ── FEATURES STRIP ── */
        .features-strip {
            background: white;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 40px 48px;
        }

        .features-inner {
            max-width: 1280px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr);
        }

        .feature-item {
            padding: 0 32px; border-right: 1px solid var(--border);
            display: flex; align-items: flex-start; gap: 14px;
        }
        .feature-item:first-child { padding-left: 0; }
        .feature-item:last-child  { border-right: none; }

        .feature-icon {
            width: 40px; height: 40px;
            background: rgba(139,26,26,0.08); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; color: var(--crimson);
        }

        .feature-text .ft-title {
            font-size: 14px; font-weight: 600;
            color: var(--text-dark); margin-bottom: 4px;
        }
        .feature-text .ft-desc {
            font-size: 12px; color: var(--text-muted); line-height: 1.5;
        }

        /* ── FOOTER ── */
        footer {
            padding: 24px 48px;
            display: flex; align-items: center; justify-content: space-between;
            max-width: 1280px; margin: 0 auto; width: 100%;
        }
        footer p { font-size: 12px; color: var(--text-muted); }
        footer p strong { color: var(--crimson); }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    {{-- ── HEADER ── --}}
    <header>
        <div class="logo-group">
            <div class="logo-seal">FD</div>
            <div class="logo-text">
                <span class="brand">Faculty DocManager</span>
                <span class="tagline">Document Submission Portal</span>
            </div>
        </div>

        <nav>
            <a href="#features">Features</a>
            <a href="#">Help</a>
            <a href="#">Contact</a>
        </nav>

    </header>

    {{-- ── HERO ── --}}
    <section class="hero">
        <div class="hero-left">

            <div class="hero-badge">
                <span class="dot"></span>
                <span>Academic Year 2025–2026</span>
            </div>

            <h1>Faculty <em>Document</em><br>Manager</h1>

            <p class="hero-desc">
                A centralized hub for submitting, tracking, and managing faculty documents —
                from syllabi and clearances to teaching loads and performance reviews.
                Streamlined. Secure. Reliable.
            </p>

            <div class="cta-group">
                <a href="{{ route('dashboard.index') }}" class="btn-launch">
                    Launch System
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#features" class="btn-learn">
                    Learn more
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 8v4M12 16h.01"/>
                    </svg>
                </a>
            </div>

        </div>

        {{-- ── PREVIEW CARD (fully static) ── --}}
        <div class="hero-right">
            <div class="preview-card">
                <div class="preview-header">
                    <span class="ph-title">Supported Document Types</span>
                    <div class="ph-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <div class="preview-body">
                    <p class="preview-desc">
                        Manage all required faculty document submissions in one place.
                        Each category is tracked independently with its own approval workflow.
                    </p>
                    <div class="doc-types">
                        <div class="doc-type-item">
                            <div class="doc-type-dot" style="background:#3B82F6;"></div>
                            <div>
                                <div class="dt-label">CSR</div>
                                <div class="dt-sub">Community Service Record</div>
                            </div>
                        </div>
                        <div class="doc-type-item">
                            <div class="doc-type-dot" style="background:#22C55E;"></div>
                            <div>
                                <div class="dt-label">Teaching Load</div>
                                <div class="dt-sub">Subject & schedule assignment</div>
                            </div>
                        </div>
                        <div class="doc-type-item">
                            <div class="doc-type-dot" style="background:#EAB308;"></div>
                            <div>
                                <div class="dt-label">Clearance</div>
                                <div class="dt-sub">End-of-term clearance letter</div>
                            </div>
                        </div>
                        <div class="doc-type-item">
                            <div class="doc-type-dot" style="background:#8B1A1A;"></div>
                            <div>
                                <div class="dt-label">Syllabus</div>
                                <div class="dt-sub">Course outline & objectives</div>
                            </div>
                        </div>
                        <div class="doc-type-item">
                            <div class="doc-type-dot" style="background:#A855F7;"></div>
                            <div>
                                <div class="dt-label">PR</div>
                                <div class="dt-sub">Performance Review</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── FEATURES STRIP ── --}}
    <div class="features-strip" id="features">
        <div class="features-inner">
            <div class="feature-item">
                <div class="feature-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <div class="ft-title">Easy Submission</div>
                    <div class="ft-desc">Upload and submit faculty documents in just a few clicks.</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <div class="ft-title">Real-time Tracking</div>
                    <div class="ft-desc">Monitor submission status from submitted to approved instantly.</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <div class="ft-title">Secure & Audited</div>
                    <div class="ft-desc">Every action is logged with full audit trail visibility.</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <line x1="3" y1="9" x2="21" y2="9"/>
                        <line x1="9" y1="21" x2="9" y2="9"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <div class="ft-title">Organized Categories</div>
                    <div class="ft-desc">CSR, Syllabus, Clearance, Teaching Load, PR — all in one place.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <footer>
        <p>© {{ date('Y') }} <strong>Faculty Document Manager</strong>. All rights reserved.</p>
        <p>For support, contact your system administrator.</p>
    </footer>

</div>
</body>
</html>