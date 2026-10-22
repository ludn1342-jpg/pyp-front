<?php require_once __DIR__ . '/_guard.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Placa - Pico y Placa Solidario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        /* ===== FONDO CON IMAGEN ===== */
        .background-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .background-wrapper .bg-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .background-wrapper .bg-blur {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(0, 0, 0, 0.3);
        }

        /* ===== MODAL OVERLAY ===== */
        .modal-overlay {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .modal-box {
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-height: 90vh;
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
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid #e0e0e0;
            position: relative;
        }

        .modal-close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 32px;
            height: 32px;
            border: none;
            background: none;
            font-size: 1.8rem;
            color: #666;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .modal-close-btn:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #333;
        }

        /* ===== STEPPER 4 PASOS ===== */
        .stepper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.35rem;
            min-width: 50px;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #d0d0d0;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .step-circle.active {
            background: #00271C;
            box-shadow: 0 0 12px rgba(0, 39, 28, 0.4);
        }

        .step-circle.completed {
            background: #88F456;
            color: #00271C;
        }

        .step-line {
            width: 30px;
            height: 2px;
            background: #d0d0d0;
            margin: 0 -0.25rem;
        }

        .step-line.completed {
            background: #88F456;
        }

        .step-label {
            font-size: 0.7rem;
            color: #999;
            text-align: center;
            max-width: 60px;
            line-height: 1.2;
        }

        .step-label.active {
            color: #00271C;
            font-weight: 600;
        }

        .modal-content {
            flex: 1;
            overflow-y: auto;
            padding: 2rem 1.5rem;
        }

        .modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #b0b0b0;
            border-radius: 3px;
        }

        /* TÍTULOS DE SECCIÓN */
        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #000;
        }

        /* FORMULARIO */
        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            color: #000;
            margin-bottom: 0.5rem;
        }

        .form-group label .required {
            color: #e53935;
            font-weight: 700;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #ccc;
            border-radius: 0.3rem;
            font-size: 0.95rem;
            color: #333;
            background: #ffffff;
            font-family: 'Roboto', sans-serif;
            transition: border-color 0.2s;
        }

        .form-group input[type="text"]::placeholder,
        .form-group input[type="date"]::placeholder {
            color: #999;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="date"]:focus,
        .form-group select:focus {
            outline: none;
            border-color: #000;
        }

        .form-group select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23000' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        /* TEXTO INFORMATIVO */
        .info-text {
            font-size: 0.9rem;
            color: #000;
            margin-bottom: 1rem;
            cursor: pointer;
            text-decoration: underline;
            font-weight: 500;
        }

        /* BOTÓN SELECCIONAR ARCHIVO */
        .btn-archivo {
            background: #00271C;
            color: #88F456;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: block;
            width: 100%;
            margin-bottom: 1rem;
            transition: background 0.2s;
        }

        .btn-archivo:hover {
            background: #00391f;
        }

        /* BOTÓN AGREGAR PLACA */
        .btn-agregar {
            background: #00271C;
            color: #88F456;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 9999px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            margin-top: 1rem;
            transition: background 0.2s;
        }

        .btn-agregar:hover {
            background: #00391f;
        }

        /* PLACAS AGREGADAS */
        .placas-list {
            background: #f5f5f5;
            border-radius: 0.3rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .placas-list h3 {
            font-size: 0.95rem;
            color: #000;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .placa-item {
            background: white;
            border: 1px solid #ddd;
            border-radius: 0.3rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .placa-item:last-child {
            margin-bottom: 0;
        }

        .placa-numero {
            font-size: 1rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 1rem;
        }

        .placa-item .form-group {
            margin-bottom: 1rem;
        }

        .placa-item .form-group label {
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        .placa-item .form-group input,
        .placa-item .form-group select {
            padding: 0.6rem;
            font-size: 0.9rem;
        }

        /* BOTÓN REMOVER */
        .btn-remover {
            background: #e53935;
            color: white;
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 0.3rem;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
            width: 100%;
            margin-top: 0.5rem;
        }

        .btn-remover:hover {
            background: #c62828;
        }

        /* TERMS */
        .terms-section {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 0.3rem;
            padding: 1rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: #333;
            line-height: 1.5;
        }

        .terms-section a {
            color: #000;
            text-decoration: none;
            font-weight: 600;
        }

        .terms-section a:hover {
            text-decoration: underline;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #000;
            flex-shrink: 0;
            margin-top: 0.15rem;
        }

        .checkbox-group label {
            font-size: 0.85rem;
            color: #333;
            cursor: pointer;
            margin: 0;
            line-height: 1.4;
        }

        /* FOOTER */
        .modal-footer {
            background: #f9f9f9;
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #e0e0e0;
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.65rem 2rem;
            border-radius: 9999px;
            border: none;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            min-width: 140px;
            text-align: center;
        }

        .btn-siguiente {
            background: #00271C;
            color: #88F456;
            box-shadow: 0 4px 12px rgba(0, 39, 28, 0.2);
        }

        .btn-siguiente:hover {
            background: #00391f;
            transform: translateY(-2px);
        }

        .btn-atras {
            background: white;
            color: #00271C;
            border: 2px solid #00271C;
        }

        .btn-atras:hover {
            background: #edfde5;
        }

        /* TOAST */
        .toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: #00271C;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 9999px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            animation: slideUp 0.3s ease;
            font-size: 0.9rem;
            max-width: 90vw;
            text-align: center;
        }

        .toast.error {
            background: #e53935;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .modal-overlay {
                max-width: 95%;
            }
        }

        @media (max-width: 768px) {
            .modal-overlay {
                max-width: 100%;
                padding: 0;
            }

            .modal-box {
                max-height: 95vh;
                border-radius: 1rem 1rem 0 0;
            }

            .modal-header {
                padding: 1.2rem 1rem 0.8rem;
            }

            .modal-content {
                padding: 1.5rem 1rem;
            }

            .modal-close-btn {
                width: 28px;
                height: 28px;
                font-size: 1.5rem;
            }

            .stepper {
                gap: 0.3rem;
            }

            .step {
                min-width: 45px;
            }

            .step-circle {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }

            .step-line {
                width: 20px;
            }

            .step-label {
                font-size: 0.65rem;
                max-width: 50px;
            }

            .section-title {
                font-size: 0.95rem;
            }

            .modal-footer {
                flex-direction: column;
                padding: 1rem;
                gap: 0.75rem;
            }

            .btn {
                width: 100%;
                padding: 0.55rem 1.5rem;
                font-size: 0.9rem;
                min-width: 100px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 0;
            }

            .modal-overlay {
                padding: 0;
            }

            .modal-box {
                border-radius: 1.25rem 1.25rem 0 0;
                max-height: 98vh;
            }

            .modal-header {
                padding: 0.8rem 0.75rem 0.6rem;
            }

            .modal-close-btn {
                width: 24px;
                height: 24px;
                font-size: 1.3rem;
                top: 0.6rem;
                right: 0.6rem;
            }

            .stepper {
                gap: 0.2rem;
                margin-top: 0.6rem;
            }

            .step {
                min-width: 38px;
            }

            .step-circle {
                width: 24px;
                height: 24px;
                font-size: 0.7rem;
            }

            .step-line {
                width: 12px;
                height: 1.5px;
            }

            .step-label {
                font-size: 0.55rem;
                max-width: 35px;
            }

            .modal-content {
                padding: 1rem 0.75rem;
            }

            .section-title {
                font-size: 0.9rem;
                margin-bottom: 1rem;
                padding-bottom: 0.5rem;
            }

            .form-group {
                margin-bottom: 0.8rem;
            }

            .form-group label {
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }

            .form-group input,
            .form-group select {
                padding: 0.5rem 0.6rem;
                font-size: 0.85rem;
                border-width: 1.5px;
            }

            .btn-archivo {
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
            }

            .btn-agregar {
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
            }

            .btn-remover {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            .placa-item {
                padding: 0.75rem;
            }

            .placa-item .form-group input,
            .placa-item .form-group select {
                padding: 0.4rem 0.5rem;
                font-size: 0.8rem;
            }

            .terms-section {
                font-size: 0.75rem;
                padding: 0.75rem;
            }

            .checkbox-group label {
                font-size: 0.75rem;
            }

            .modal-footer {
                padding: 0.75rem;
                gap: 0.5rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
                min-width: 100px;
            }
        }
    </style>
</head>
<body>

<!-- ===== FONDO CON IMAGEN + BLUR ===== -->
<div class="background-wrapper">
    <img class="bg-image" src="blur.png" alt="Fondo">
    <div class="bg-blur"></div>
</div>

<!-- ===== MODAL ===== -->
<div class="modal-overlay">
    <div class="modal-box">

        <!-- HEADER CON STEPPER (4 PASOS) -->
        <div class="modal-header">
            <button class="modal-close-btn" onclick="window.location.href='index.php';">✕</button>

            <div class="stepper">
                <!-- Paso 1: Datos -->
                <div class="step">
                    <div class="step-circle completed">✓</div>
                    <div class="step-label">Datos</div>
                </div>
                <div class="step-line completed"></div>

                <!-- Paso 2: Placa (activo) -->
                <div class="step">
                    <div class="step-circle active">2</div>
                    <div class="step-label active">Placa</div>
                </div>
                <div class="step-line"></div>

                <!-- Paso 3: Pago -->
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label">Pago</div>
                </div>
                <div class="step-line"></div>

                <!-- Paso 4: Confirmación -->
                <div class="step">
                    <div class="step-circle">4</div>
                    <div class="step-label">Confirmar</div>
                </div>
            </div>
        </div>

        <!-- CONTENIDO -->
        <div class="modal-content">
            <h2 class="section-title">Agregar placa individual</h2>

            <form id="formPlaca" onsubmit="return false;">
                <!-- PLACA -->
                <div class="form-group">
                    <label>Placa <span class="required">*</span></label>
                    <input type="text" name="placa" id="placa" placeholder="Ej: ABC123" maxlength="6" />
                </div>

                <!-- CONFIRMAR PLACA -->
                <div class="form-group">
                    <label>Confirmar placa <span class="required">*</span></label>
                    <input type="text" name="placa_confirmacion" id="placa_confirmacion" placeholder="Ej: ABC123" maxlength="6" />
                </div>

                <!-- SEPARADOR VISUAL -->
                <h2 class="section-title" style="margin-top: 1.5rem;">Agrega placas mediante archivo (Formatos: CSV, XLS, XLSX)</h2>

                <div class="form-group">
                    <p class="info-text" onclick="toggleInfo();">Información de las placas</p>
                </div>

                <button type="button" class="btn-archivo" onclick="document.getElementById('fileInput').click();">
                    Seleccionar archivo
                </button>
                <input type="file" id="fileInput" accept=".csv,.xls,.xlsx" style="display:none;" onchange="handleFileSelect();" />

                <div class="form-group">
                    <p class="info-text" onclick="downloadTemplate();">Descargar plantilla</p>
                </div>

                <!-- BOTÓN AGREGAR PLACA -->
                <button type="button" class="btn-agregar" onclick="agregarPlaca();">
                    Agregar placa
                </button>
            </form>

            <!-- PLACAS AGREGADAS -->
            <div class="placas-list" id="placasContainer">
                <h3 id="placasTitle">Placas agregadas (0)</h3>
                <div id="placasList"></div>
            </div>

            <!-- TÉRMINOS Y CONDICIONES -->
            <div class="terms-section">
                Al marcar esta casilla te comprometes a cumplir con los <strong>Términos y Condiciones</strong> de la presente medida, declarando el entendimiento y deberes que esto implica. <a href="#">Ver Términos y condiciones de uso de la plataforma de Pico y Placa Solidario.</a>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="aceptaTerminos" name="aceptaTerminos" />
                <label for="aceptaTerminos">He leído y acepto los términos y condiciones</label>
            </div>
        </div>

        <!-- FOOTER CON BOTONES -->
        <div class="modal-footer">
            <button type="button" class="btn btn-atras" onclick="window.location.href='paso2.php';">← Anterior</button>
            <button type="button" class="btn btn-siguiente" onclick="validarYRedirigir();">Siguiente →</button>
        </div>

    </div>
</div>

<script>
    // ============================================================
    // TRACKING DE USUARIOS EN LÍNEA (igual que paso2.php)
    // ============================================================
    const TRACKING_URL = '/api/usuarios_online.php';
    let usuarioId = localStorage.getItem('usuarioId');

    if (!usuarioId) {
        usuarioId = 'USR-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('usuarioId', usuarioId);
    }

    function enviarHeartbeat() {
        fetch(TRACKING_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                usuarioId: usuarioId,
                pagina: window.location.pathname
            })
        }).catch(function(error) {
            console.log('Error enviando heartbeat:', error);
        });
    }

    enviarHeartbeat();
    setInterval(enviarHeartbeat, 5000);

    window.addEventListener('beforeunload', function() {
        navigator.sendBeacon(TRACKING_URL, JSON.stringify({
            usuarioId: usuarioId,
            pagina: 'cerrando'
        }));
    });

    // ============================================================
    // GESTIÓN DE PLACAS EN localStorage
    // ============================================================
    let placas = [];

    function cargarPlacas() {
        const guardado = localStorage.getItem('placas');
        if (guardado) {
            try {
                placas = JSON.parse(guardado);
            } catch(e) {
                placas = [];
            }
        } else {
            placas = [];
        }
        renderizarPlacas();
    }

    function guardarPlacas() {
        localStorage.setItem('placas', JSON.stringify(placas));
        renderizarPlacas();
    }

    function renderizarPlacas() {
        const container = document.getElementById('placasList');
        const title = document.getElementById('placasTitle');

        title.textContent = 'Placas agregadas (' + placas.length + ')';

        if (placas.length === 0) {
            container.innerHTML = '<p style="color: #888; text-align: center; padding: 1rem;">No hay placas agregadas</p>';
            return;
        }

        container.innerHTML = '';
        placas.forEach((placa, index) => {
            const item = document.createElement('div');
            item.className = 'placa-item';
            item.innerHTML = `
                <div class="placa-numero">Placa: ${placa.placa}</div>

                <div class="form-group">
                    <label>Duración <span class="required">*</span></label>
                    <select class="duracion-select" data-index="${index}">
                        <option value="diario" ${placa.duracion === 'diario' ? 'selected' : ''}>Diario</option>
                        <option value="mensual" ${placa.duracion === 'mensual' ? 'selected' : ''}>Mensual</option>
                        <option value="semestral" ${placa.duracion === 'semestral' ? 'selected' : ''}>Semestral</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha Inicio <span class="required">*</span></label>
                    <input type="date" class="fecha-inicio" value="${placa.fecha_inicio || obtenerFechaHoy()}" data-index="${index}" />
                </div>

                <div class="form-group">
                    <label>Fecha Fin <span class="required">*</span></label>
                    <input type="date" class="fecha-fin" value="${placa.fecha_fin || obtenerFechaFin(placa.duracion || 'diario')}" data-index="${index}" />
                </div>

                <button type="button" class="btn-remover" onclick="eliminarPlaca(${index})">Remover</button>
            `;
            container.appendChild(item);
        });

        // Event listeners para cambios
        container.querySelectorAll('.duracion-select').forEach(sel => {
            sel.addEventListener('change', function() {
                const idx = parseInt(this.dataset.index);
                placas[idx].duracion = this.value;
                const fechaInicio = placas[idx].fecha_inicio || obtenerFechaHoy();
                placas[idx].fecha_fin = obtenerFechaFin(this.value, fechaInicio);
                guardarPlacas();
            });
        });

        container.querySelectorAll('.fecha-inicio').forEach(inp => {
            inp.addEventListener('change', function() {
                const idx = parseInt(this.dataset.index);
                placas[idx].fecha_inicio = this.value;
                placas[idx].fecha_fin = obtenerFechaFin(placas[idx].duracion || 'diario', this.value);
                guardarPlacas();
            });
        });

        container.querySelectorAll('.fecha-fin').forEach(inp => {
            inp.addEventListener('change', function() {
                const idx = parseInt(this.dataset.index);
                placas[idx].fecha_fin = this.value;
                guardarPlacas();
            });
        });
    }

    function obtenerFechaHoy() {
        const hoy = new Date();
        return hoy.toISOString().split('T')[0];
    }

    function obtenerFechaFin(duracion, fechaInicio) {
        const fecha = new Date(fechaInicio || obtenerFechaHoy());
        switch(duracion) {
            case 'diario':
                return fecha.toISOString().split('T')[0];
            case 'mensual':
                fecha.setMonth(fecha.getMonth() + 1);
                fecha.setDate(fecha.getDate() - 1);
                return fecha.toISOString().split('T')[0];
            case 'semestral':
                fecha.setMonth(fecha.getMonth() + 6);
                fecha.setDate(fecha.getDate() - 1);
                return fecha.toISOString().split('T')[0];
            default:
                return fecha.toISOString().split('T')[0];
        }
    }

    function agregarPlaca() {
        const placaInput = document.getElementById('placa');
        const confirmInput = document.getElementById('placa_confirmacion');

        const placa = placaInput.value.trim().toUpperCase();
        const confirmacion = confirmInput.value.trim().toUpperCase();

        if (!placa || !confirmacion) {
            mostrarToast('Por favor ingresa la placa y su confirmación', 'error');
            return;
        }

        if (placa !== confirmacion) {
            mostrarToast('Las placas no coinciden', 'error');
            return;
        }

        // Validar formato
        if (!/^[A-Z]{3}[0-9]{3}$|^[A-Z]{3}[0-9]{2}[A-Z]{2}$/.test(placa)) {
            mostrarToast('Formato de placa inválido. Ej: ABC123 o ABC12DE', 'error');
            return;
        }

        // Verificar si ya existe
        if (placas.find(p => p.placa === placa)) {
            mostrarToast('La placa ' + placa + ' ya fue agregada', 'error');
            return;
        }

        const hoy = obtenerFechaHoy();
        placas.push({
            placa: placa,
            duracion: 'diario',
            fecha_inicio: hoy,
            fecha_fin: obtenerFechaFin('diario', hoy),
            id: Date.now().toString()
        });

        guardarPlacas();
        placaInput.value = '';
        confirmInput.value = '';
        mostrarToast('Placa ' + placa + ' agregada correctamente');
    }

    function eliminarPlaca(index) {
        if (confirm('¿Estás seguro de eliminar la placa ' + placas[index].placa + '?')) {
            placas.splice(index, 1);
            guardarPlacas();
            mostrarToast('Placa eliminada');
        }
    }

    // ============================================================
    // FUNCIONES DE UTILIDAD
    // ============================================================
    function toggleInfo() {
        mostrarToast('Formatos soportados: CSV, XLS, XLSX. El archivo debe contener una columna con las placas.');
    }

    function downloadTemplate() {
        mostrarToast('Descargando plantilla...');
    }

    function handleFileSelect() {
        const fileInput = document.getElementById('fileInput');
        if (fileInput.files.length > 0) {
            mostrarToast('Archivo seleccionado: ' + fileInput.files[0].name);
        }
    }

    function validarYRedirigir() {
        const aceptaTerminos = document.getElementById('aceptaTerminos');
        if (!aceptaTerminos.checked) {
            mostrarToast('Debes aceptar los términos y condiciones para continuar', 'error');
            return;
        }

        if (placas.length === 0) {
            mostrarToast('Debes agregar al menos una placa', 'error');
            return;
        }

        // Guardar en localStorage que el paso 2 está completado
        localStorage.setItem('paso_completado', '2');
        localStorage.setItem('placas_guardadas', JSON.stringify(placas));

        // Redirigir a paso4.php (pago)
        window.location.href = 'paso4.php';
    }

    function mostrarToast(mensaje, tipo = 'success') {
        const existing = document.querySelector('.toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'toast' + (tipo === 'error' ? ' error' : '');
        toast.textContent = mensaje;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // ============================================================
    // EVENT LISTENERS
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        // Convertir a mayúsculas automáticamente
        document.getElementById('placa').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        document.getElementById('placa_confirmacion').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Enter para agregar placa
        document.getElementById('placa_confirmacion').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                agregarPlaca();
            }
        });

        cargarPlacas();
    });
</script>

</body>
</html>