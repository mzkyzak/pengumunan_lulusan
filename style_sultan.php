<style>
    /* --- KONFIGURASI WARNA SULTAN --- */
    :root {
        --primary: #06b6d4;   /* Cyan Neon */
        --secondary: #8b5cf6; /* Purple Neon */
        --accent: #d946ef;    /* Pink Neon */
        --dark: #020617;      /* Gelap Pekat */
        --glass: rgba(30, 41, 59, 0.4);
    }

    /* --- RESET & GLOBAL --- */
    body {
        background-color: var(--dark) !important;
        color: #f8fafc;
        font-family: 'Poppins', sans-serif;
        font-size: 13px; /* Ukuran font sedang profesional */
        margin: 0;
        overflow-x: hidden;
    }

    /* --- 1. ANIMASI GLOWING ORBS (Latar Belakang Bergerak) --- */
    .bg-orb {
        position: fixed;
        width: 45vw;
        height: 45vw;
        border-radius: 50%;
        filter: blur(120px);
        z-index: -10;
        opacity: 0.12;
        animation: floatOrb 15s infinite alternate ease-in-out;
        pointer-events: none;
    }
    .orb-1 { top: -10vh; left: -10vw; background: var(--primary); }
    .orb-2 { bottom: -10vh; right: -5vw; background: var(--secondary); animation-delay: -5s; }
    .orb-3 { top: 40vh; left: 30vw; background: var(--accent); width: 30vw; height: 30vw; animation-delay: -10s; }

    @keyframes floatOrb {
        0% { transform: translateY(0px) translateX(0px) scale(1); }
        100% { transform: translateY(80px) translateX(40px) scale(1.1); }
    }

    /* --- 2. MAGIC BORDER (Lampu RGB Berjalan di Border) --- */
    .magic-border {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.05);
        z-index: 1;
    }
    
    .magic-border::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(transparent, var(--primary), transparent, var(--accent), transparent);
        animation: rotateBorder 4s linear infinite;
        z-index: -1;
    }

    .magic-inner {
        background: #0f172a; /* Warna dalam kotak */
        margin: 2px; /* Ketebalan garis cahaya */
        border-radius: 0.9rem;
        height: calc(100% - 4px);
    }

    @keyframes rotateBorder {
        100% { transform: rotate(360deg); }
    }

    /* --- 3. GLASSMORPHISM PANEL --- */
    .glass-panel {
        background: var(--glass) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5) !important;
        border-radius: 1rem !important;
    }

    /* Hover Effect */
    .glass-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important; }
    .glass-hover:hover {
        transform: translateY(-4px);
        border-color: rgba(6, 182, 212, 0.5) !important;
        box-shadow: 0 0 25px rgba(6, 182, 212, 0.3) !important;
    }

    /* --- 4. GRAFIS STATISTIK (Progress Bar) --- */
    .stat-line {
        height: 6px;
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }
    .stat-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transition: width 1.5s ease-in-out;
        box-shadow: 0 0 10px var(--primary);
    }

    /* --- 5. LOGO & TYPEWRITER EFFECT (Slow & Smooth) --- */
    .fi-logo {
        font-weight: 800 !important; 
        letter-spacing: 2px;
        background: linear-gradient(90deg, var(--primary), var(--accent));
        -webkit-background-clip: text; 
        -webkit-text-fill-color: transparent;
        overflow: hidden; 
        white-space: nowrap; 
        display: inline-block;
        border-right: 2px solid var(--primary);
        /* Animasi melambat jadi 6 detik sesuai permintaan */
        animation: typingSultan 6s steps(30, end) infinite alternate, blinkSultan 0.75s step-end infinite;
    }

    @keyframes typingSultan { 0% { width: 0; } 100% { width: 100%; } }
    @keyframes blinkSultan { from, to { border-right-color: transparent; } 50% { border-right-color: var(--primary); } }

    /* --- 6. CUSTOM SCROLLBAR --- */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { 
        background: rgba(255, 255, 255, 0.1); 
        border-radius: 10px; 
    }
    ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

    /* --- 7. BUTTONS & INPUTS --- */
    input, select {
        transition: all 0.3s ease;
    }
    input:focus, select:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.2);
    }

    button {
        cursor: pointer;
        transition: all 0.3s active;
    }
    button:active {
        transform: scale(0.95);
    }

    /* Utility */
    .text-glow { text-shadow: 0 0 10px rgba(6, 182, 212, 0.5); }
</style>