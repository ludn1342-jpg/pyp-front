<?php require_once __DIR__ . '/_guard.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pico y Placa Solidario - Movilidad Bogotá</title>
  <meta name="description" content="El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa">
  <link rel="icon" type="image/x-icon" href="https://picoyplacasolidario.movilidadbogota.gov.co/assets/icons/Favicon_MiMOVILIDAD.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --dark-green: #00271C;
      --deep-blue: #425287;
      --deep-green: #07241c;
      --light-green: #88F456;
      --gray: #606060;
      --light-gray: #ccc;
      --gris: #efefef;
      --color-error: #B34545;
      --color-disabled: #879691;
      --color-activo: #00271C;
      --color-primario: #88F456;
      --blanco: #FFF;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Roboto', sans-serif; }
    body { overflow-x: hidden; }
    img { max-width: 100%; display: block; }
    a { text-decoration: none; color: inherit; }

    nav {
      background-color: var(--dark-green);
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      width: 100%;
      position: relative;
      top: 0; left: 0;
      z-index: 50;
    }
    .navbar-container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 64px;
    }
    .logo-container a { display: flex; align-items: center; width: 12rem; padding-left: 1.25rem; }
    .logo-container img { width: 100%; height: auto; }
    .navbar-desktop { display: flex; align-items: center; gap: 2rem; }
    .navbar-desktop ul { list-style: none; display: flex; align-items: center; gap: 0.75rem; }
    .navbar-desktop ul li a { display: block; padding: 0.625rem 0; font-size: 0.875rem; font-weight: 600; color: white; text-transform: capitalize; }
    .navbar-desktop ul li.active a { border-bottom: 1px solid var(--light-green); }
    .navbar-desktop ul li a:hover { color: var(--light-green); }
    .nav-extras { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; }
    .nav-divider { height: 1.25rem; width: 1px; background: white; }
    .lang-btn { color: white; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; background: none; border: none; }
    .lang-btn svg { fill: var(--light-green); }
    .btn-support { background: white; color: var(--dark-green); font-weight: 600; border: 2px solid var(--dark-green); border-radius: 9999px; padding: 0.25rem 1.5rem; font-size: 0.875rem; cursor: pointer; transition: background 0.3s; }
    .btn-support:hover { background: #edfde5; }
    .hamburger-btn { display: none; background: none; border: none; cursor: pointer; color: white; font-size: 1.75rem; padding: 0.5rem; }
    .mobile-title { display: none; }

    .section-1 { position: relative; }
    .section-1 img.banner-img { width: 100%; height: auto; }
    .section-1-overlay { position: absolute; top: 50%; left: 15%; transform: translateY(-50%); margin-left: 1rem; width: 33%; padding: 0.75rem; }
    .section-1-text-block { margin-bottom: 0.75rem; }
    .section-1-text-block span { display: block; padding: 0.25rem 1.25rem; width: 100%; font-weight: 900; font-size: clamp(1rem, 3vw, 3rem); }
    .span-dark { background: var(--dark-green); color: white; }
    .span-green { background: var(--light-green); color: var(--dark-green); text-transform: uppercase; width: 27rem; max-width: 100%; }
    .btn-solicitud { background: white; color: var(--dark-green); font-weight: 700; border: 2px solid var(--dark-green); border-radius: 9999px; padding: 0.5rem 1.5rem; font-size: 1.25rem; cursor: pointer; width: 60%; margin-top: 1rem; transition: background 0.3s; }
    .btn-solicitud:hover { background: #edfde5; }
    .mobile-cta-wrap { display: none; }

    .section-2 { display: flex; flex-direction: row; margin: 5% 7rem; gap: 2rem; }
    .section-2-svg-block { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem; }
    .section-2-titulo h1 { color: var(--dark-green); font-size: 3rem; font-weight: 400; line-height: 1.2; }
    .section-2-titulo h1 span { display: block; }
    .green-divider { width: 4px; background: var(--light-green); align-self: stretch; flex-shrink: 0; }
    .section-2-info { display: flex; flex-direction: column; justify-content: center; text-align: justify; flex: 1; }
    .text-trimmer-container { margin-left: 17%; color: var(--dark-green); }
    .text-trimmer-container p { font-size: 1rem; line-height: 1.6; height: 250px; overflow: hidden; }
    .btn-more { background: white; color: var(--dark-green); font-weight: 700; border: 2px solid var(--dark-green); border-radius: 9999px; padding: 0.25rem 1.5rem; font-size: 0.875rem; cursor: pointer; margin-top: 0.75rem; display: block; text-align: center; width: fit-content; margin-left: auto; margin-right: auto; }
    .btn-more:hover { background: #edfde5; }

    .section-cards { background: #EDEDED; padding: 1.25rem; display: flex; justify-content: center; align-items: center; }
    .cards-inner { display: flex; flex-direction: row; justify-content: center; align-items: center; gap: 3rem; width: 65%; padding: 1.25rem; }
    .paso-paso-section { display: flex; gap: 50px; height: 100%; flex-grow: 1; }
    .paso-paso-card { background: white; width: 10rem; height: 25rem; border-radius: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: space-between; flex-grow: 1; }
    .card-top { background: var(--dark-green); width: 100%; height: 45%; border-radius: 1.5rem 1.5rem 0 0; position: relative; display: flex; justify-content: center; }
    .card-top img { width: 6rem; margin: auto; margin-top: 1.25rem; }
    .triangle-down { position: absolute; bottom: -19px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 20px solid transparent; border-right: 20px solid transparent; border-top: 20px solid var(--dark-green); }
    .card-text { text-align: center; padding: 0 12%; }
    .card-text h2 { font-size: 1.25rem; font-weight: 700; }
    .card-text p { font-size: 0.875rem; }
    .card-btn-wrap { margin-bottom: 15%; }
    .btn-card { background: white; color: var(--dark-green); font-weight: 700; border: 2px solid var(--dark-green); border-radius: 9999px; padding: 0.25rem 1.5rem; font-size: 0.875rem; cursor: pointer; }
    .btn-card:hover { background: #edfde5; }

    .section-registro { background-color: var(--dark-green); background-image: url('./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/Foto-fondo_secci%C3%B3n-llamado-a-la-acci%C3%B3n_2.jpg'); background-repeat: no-repeat; background-position: center; background-size: cover; display: flex; flex-direction: column; align-items: center; text-align: center; }
    .registro-header { margin-top: 5%; }
    .inicio-registro-header { display: flex; justify-content: center; align-items: center; gap: 1rem; }
    .registro-title { color: white; font-size: 2.25rem; }
    .registro-line { border-bottom: 1px solid var(--light-green); width: 70%; margin: auto; margin-top: 0.5rem; }
    .registro-desc { margin-top: 2rem; margin-bottom: 2rem; }
    .registro-desc p { color: white; font-size: 1rem; }
    .registro-form-wrap { background: white; width: 70%; border-radius: 0.5rem; margin-bottom: 5%; padding: 1.5rem; }
    .form-inner { display: flex; flex-direction: column; align-items: center; text-align: center; }
    .form-section { display: flex; flex-direction: column; justify-content: center; width: 90%; }
    .form-group { width: 100%; padding: 0.5rem; margin-bottom: 1rem; }
    .form-group label { display: flex; font-size: 1rem; font-weight: 500; color: var(--dark-green); margin-bottom: 0.25rem; }
    .form-group select, .form-group input[type="text"] { margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem 0.75rem; border: 2px solid var(--dark-green); background: white; border-radius: 0.375rem; font-size: 1rem; color: var(--dark-green); appearance: none; -webkit-appearance: none; }
    .form-group select:focus, .form-group input:focus { outline: none; }
    .btn-comenzar { border-radius: 9999px; padding: 0.5rem 1.5rem; margin-top: 1.25rem; margin-bottom: 1.25rem; margin-left: auto; font-weight: 700; background-color: var(--dark-green); border: 1px solid var(--dark-green); color: white; cursor: not-allowed; opacity: 0.5; font-size: 1rem; transition: opacity 0.2s, cursor 0.2s; }
    .btn-comenzar.activo { cursor: pointer; opacity: 1; }
    .btn-comenzar.loading { opacity: 0.7; cursor: wait; }

    /* ===== TOAST ===== */
    .toast { position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%) translateY(80px); background: var(--dark-green); color: white; padding: 0.75rem 1.5rem; border-radius: 9999px; font-size: 0.9rem; font-weight: 500; box-shadow: 0 4px 20px rgba(0,0,0,0.25); z-index: 9999; opacity: 0; transition: transform 0.3s ease, opacity 0.3s ease; max-width: 90vw; text-align: center; }
    .toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }
    .toast.success { background: var(--dark-green); border: 2px solid var(--light-green); }
    .toast.error { background: var(--color-error); }

    /* ===== MODAL ===== */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 9000; display: flex; align-items: center; justify-content: center; padding: 1rem; }
    .modal-box { background: #fff; border-radius: 0.5rem; width: 100%; max-width: 730px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 11px 38px rgba(0,0,0,0.25); overflow: hidden; }
    .modal-header { display: flex; align-items: center; justify-content: space-between; background: var(--dark-green); color: #fff; padding: 0.75rem 1.25rem; flex-shrink: 0; }
    .modal-header-title { font-size: 1rem; font-weight: 700; }
    .modal-close-btn { background: none; border: none; color: #fff; font-size: 1.2rem; cursor: pointer; line-height: 1; }

    /* ── Stepper ── */
    .modal-stepper { display: flex; align-items: center; justify-content: center; padding: 0.75rem 1rem 0.5rem; gap: 0; flex-shrink: 0; border-bottom: 1px solid #eee; flex-wrap: nowrap; overflow-x: auto; }
    .step { display: flex; flex-direction: column; align-items: center; gap: 0.25rem; min-width: 44px; }
    .step-circle { width: 26px; height: 26px; border-radius: 50%; background: #879691; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0; }
    .step-circle.active { background: var(--dark-green); }
    .step-circle.done { background: var(--light-green); color: var(--dark-green); }
    .step-label { font-size: 0.65rem; color: #aaa; text-align: center; white-space: nowrap; }
    .step-label.active { color: var(--dark-green); font-weight: 600; }
    .step-line { flex: 1; height: 3px; background: #ccc; min-width: 20px; margin-bottom: 14px; }
    .step-line.done { background: var(--light-green); }

    /* ── Form sections ── */
    .modal-form-section { overflow-y: auto; padding: 1rem 1.5rem; flex: 1; }
    .modal-form-title { font-size: 1.2rem; font-weight: 700; color: var(--dark-green); margin-bottom: 1rem; border-bottom: 1px solid #ccc; padding-bottom: 0.5rem; }
    .modal-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem 1.5rem; }
    .modal-field.full-width { grid-column: 1 / -1; }
    .modal-field { display: flex; flex-direction: column; gap: 0.25rem; }
    .modal-field label { font-size: 0.875rem; font-weight: 600; color: var(--dark-green); }
    .modal-field .req { color: #e53935; font-size: 1rem; }
    .modal-field input { border: 1px solid #aaa; border-radius: 0.375rem; padding: 0.45rem 0.75rem; font-size: 0.95rem; color: var(--dark-green); background: #f9f9f9; width: 100%; box-sizing: border-box; }
    .modal-field input:focus { outline: none; border-color: var(--dark-green); }
    .modal-field select { border: 1px solid #aaa; border-radius: 0.375rem; padding: 0.45rem 0.75rem; font-size: 0.95rem; color: var(--dark-green); background: #fff; width: 100%; box-sizing: border-box; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2300271C' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; padding-right: 2rem; cursor: pointer; }
    .modal-field select:focus { outline: none; border-color: var(--dark-green); }
    .modal-checkbox-wrap { margin-top: 0.25rem; }
    .modal-check-label { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: var(--dark-green); cursor: pointer; font-weight: 400 !important; }
    .modal-check-label input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--dark-green); cursor: pointer; flex-shrink: 0; }

    /* ── Footer ── */
    .modal-footer { display: flex; justify-content: center; padding: 0.75rem 1.5rem 1rem; border-top: 1px solid #eee; flex-shrink: 0; gap: 0.75rem; }
    .modal-btn-siguiente { background: var(--dark-green); color: var(--light-green); border: none; border-radius: 9999px; padding: 0.5rem 2.5rem; font-size: 1rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s; }
    .modal-btn-siguiente:hover { opacity: 0.85; }
    .modal-btn-atras { background: white; color: var(--dark-green); border: 2px solid var(--dark-green); border-radius: 9999px; padding: 0.5rem 2.5rem; font-size: 1rem; font-weight: 700; cursor: pointer; display: none; transition: background 0.2s; }
    .modal-btn-atras:hover { background: #edfde5; }

    /* ══════════════════════════════════════
       PASO 2 - PLACAS
    ══════════════════════════════════════ */
    #modal-step2 { display: none; }

    /* Sección individual activa */
    .placa-section-title {
      font-size: 1rem;
      font-weight: 700;
      color: var(--dark-green);
      text-align: center;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid var(--dark-green);
    }

    .placa-field { display: flex; flex-direction: column; gap: 0.3rem; margin-bottom: 1rem; }
    .placa-field label { font-size: 0.875rem; font-weight: 600; color: var(--dark-green); }
    .placa-field .req { color: #e53935; }
    .placa-field input {
      border: 1px solid #aaa;
      border-radius: 0.375rem;
      padding: 0.5rem 0.75rem;
      font-size: 0.95rem;
      color: var(--dark-green);
      background: #f9f9f9;
      width: 100%;
      text-transform: uppercase;
    }
    .placa-field input:focus { outline: none; border-color: var(--dark-green); }
    .placa-error { font-size: 0.78rem; color: var(--color-error); margin-top: 0.2rem; min-height: 1rem; }

    /* Sección archivo — DESHABILITADA */
    .archivo-section {
      margin-top: 1.5rem;
      padding: 1.25rem;
      background: #f5f5f5;
      border-radius: 0.5rem;
      border: 1px solid #ddd;
      opacity: 0.45;
      pointer-events: none;
      user-select: none;
    }
    .archivo-section-title {
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--dark-green);
      text-align: center;
      margin-bottom: 0.5rem;
    }
    .archivo-section-sub {
      font-size: 0.82rem;
      color: #555;
      text-align: center;
      margin-bottom: 0.85rem;
    }
    .archivo-btn-row { display: flex; gap: 0.75rem; justify-content: center; align-items: center; flex-wrap: wrap; }
    .btn-seleccionar-archivo {
      border: 1px solid #aaa;
      background: white;
      border-radius: 9999px;
      padding: 0.35rem 1.25rem;
      font-size: 0.85rem;
      font-weight: 500;
      cursor: default;
      color: #444;
    }
    .link-descargar {
      font-size: 0.85rem;
      color: var(--dark-green);
      text-decoration: underline;
      cursor: default;
    }

    /* Botón agregar placa */
    .btn-agregar-placa {
      display: block;
      margin: 1.5rem auto 0;
      background: var(--light-green);
      color: var(--dark-green);
      border: none;
      border-radius: 9999px;
      padding: 0.6rem 2.5rem;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: opacity 0.2s;
    }
    .btn-agregar-placa:hover { opacity: 0.85; }
    .btn-agregar-placa:disabled { opacity: 0.45; cursor: not-allowed; }

    /* Términos y condiciones */
    .terminos-wrap {
      margin-top: 1.25rem;
      display: flex;
      align-items: flex-start;
      gap: 0.6rem;
    }
    .terminos-wrap input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--dark-green);
      cursor: pointer;
      flex-shrink: 0;
      margin-top: 0.2rem;
    }
    .terminos-text {
      font-size: 0.82rem;
      color: var(--dark-green);
      line-height: 1.5;
      text-align: left;
    }
    .terminos-text b { font-weight: 700; }

    /* ══ TABLA DE PLACAS AGREGADAS ══ */
    .placas-table-wrap { margin-top: 1rem; }
    .placa-card {
      border: 1px solid #d0d0d0;
      border-radius: 0.375rem;
      overflow: hidden;
      margin-bottom: 0.5rem;
    }
    .placa-card-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.5rem 0.85rem;
      border-bottom: 1px solid #e8e8e8;
      min-height: 42px;
    }
    .placa-card-row:last-child { border-bottom: none; }
    .placa-card-label {
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--dark-green);
      flex-shrink: 0;
    }
    .placa-card-val {
      font-size: 0.875rem;
      color: var(--dark-green);
      text-align: right;
    }
    /* duración select */
    .dur-select {
      border: 1px solid #bbb;
      border-radius: 0.25rem;
      padding: 0.22rem 1.6rem 0.22rem 0.5rem;
      font-size: 0.875rem;
      color: var(--dark-green);
      appearance: none;
      -webkit-appearance: none;
      background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2300271C' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 0.5rem center;
      cursor: pointer;
    }
    .dur-select:focus { outline: none; border-color: var(--dark-green); }
    /* fecha cell */
    .fecha-cell {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      justify-content: flex-end;
    }
    .cal-icon-btn {
      background: none;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      color: #4a4a4a;
      padding: 0.1rem;
      border-radius: 0.2rem;
      transition: background 0.15s;
    }
    .cal-icon-btn:hover { background: #f0f0f0; }
    .cal-icon-btn.disabled {
      cursor: default;
      color: #c0c0c0;
      pointer-events: none;
    }
    .fecha-display {
      border: 1px solid #bbb;
      border-radius: 0.375rem;
      padding: 0.22rem 0.65rem;
      font-size: 0.875rem;
      color: var(--dark-green);
      min-width: 88px;
      text-align: center;
      background: white;
    }
    .fecha-display.disabled {
      color: #aaa;
      background: #f5f5f5;
      border-color: #ddd;
    }
    /* remover */
    .btn-remover {
      background: #e05252;
      color: white;
      border: none;
      border-radius: 0.3rem;
      padding: 0.28rem 1rem;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.15s;
    }
    .btn-remover:hover { background: #c43a3a; }

    /* ══ PAGINACIÓN ══ */
    .pagination-wrap {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 0.5rem;
      margin-top: 0.6rem;
      font-size: 0.875rem;
      color: var(--dark-green);
    }
    .pag-label { font-weight: 500; }
    .pag-select {
      border: 1px solid #bbb;
      border-radius: 0.25rem;
      padding: 0.2rem 0.4rem;
      font-size: 0.875rem;
      color: var(--dark-green);
    }
    .pag-btn {
      background: none;
      border: none;
      font-size: 1.1rem;
      cursor: pointer;
      color: var(--dark-green);
      padding: 0.1rem 0.3rem;
      line-height: 1;
    }
    .pag-btn:disabled { color: #ccc; cursor: default; }
    .pag-num { font-weight: 700; font-size: 0.875rem; }

    /* ══ CALENDARIO POPUP ══ */
    .cal-popup {
      position: fixed;
      z-index: 99999;
      background: white;
      border-radius: 0.5rem;
      box-shadow: 0 8px 36px rgba(0,0,0,0.18);
      padding: 0.85rem 1rem 1rem;
      width: 300px;
    }
    .cal-pop-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 0.6rem;
    }
    .cal-month-label {
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--dark-green);
      display: flex;
      align-items: center;
      gap: 0.3rem;
      cursor: default;
    }
    .cal-month-label svg { fill: var(--dark-green); }
    .cal-nav { display: flex; gap: 0.1rem; }
    .cal-nav-btn {
      background: none;
      border: none;
      font-size: 1rem;
      cursor: pointer;
      color: #555;
      padding: 0.15rem 0.45rem;
      border-radius: 0.25rem;
      line-height: 1;
    }
    .cal-nav-btn:hover { background: #f0f0f0; }
    .cal-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 1px;
    }
    .cal-dh {
      text-align: center;
      font-size: 0.72rem;
      font-weight: 600;
      color: #888;
      padding: 0.2rem 0;
    }
    .cal-cell { text-align: center; padding: 1px 0; }
    .cal-month-tag {
      font-size: 0.7rem;
      color: #aaa;
      font-weight: 500;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 34px;
    }
    .cal-day-btn {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      border: none;
      background: none;
      cursor: pointer;
      font-size: 0.82rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: auto;
      transition: background 0.12s;
      color: var(--dark-green);
    }
    .cal-day-btn.cal-past {
      background: #e05252;
      color: white;
      cursor: not-allowed;
      pointer-events: none;
    }
    .cal-day-btn.cal-habiles {
      background: white;
      color: var(--dark-green);
      font-weight: 500;
    }
    .cal-day-btn.cal-habiles:hover { background: #dff0cc; }
    .cal-day-btn.cal-selected {
      background: var(--dark-green);
      color: white;
      font-weight: 700;
    }
    .cal-day-btn.cal-empty { pointer-events: none; visibility: hidden; }


    /* ══ PASO 4 - QR PAGO ══ */
    .s4-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 0.5rem 0 0.75rem;
    }
    .s4-title {
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--dark-green);
      margin-bottom: 0.5rem;
      text-align: center;
    }
    .s4-desc {
      font-size: 0.875rem;
      color: #555;
      text-align: center;
      line-height: 1.55;
      margin-bottom: 1rem;
      max-width: 340px;
    }
    .s4-qr-box {
      background: #f9f9f9;
      border: 1px solid #e0e0e0;
      border-radius: 0.75rem;
      padding: 1rem;
      margin-bottom: 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.5rem;
    }
    .s4-qr-box img { border-radius: 0.5rem; }
    .s4-monto-badge {
      background: var(--dark-green);
      color: var(--light-green);
      font-size: 1.1rem;
      font-weight: 900;
      border-radius: 9999px;
      padding: 0.3rem 1.5rem;
      letter-spacing: 0.03em;
    }
    .s4-status {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.875rem;
      color: #555;
      margin: 0.5rem 0 1rem;
      min-height: 24px;
    }
    .s4-spinner {
      width: 18px; height: 18px;
      border: 2px solid #ccc;
      border-top-color: var(--dark-green);
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      flex-shrink: 0;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .s4-btn-row {
      display: flex;
      gap: 0.75rem;
      flex-wrap: wrap;
      justify-content: center;
    }
    .btn-confirmar-qr {
      background: var(--dark-green);
      color: var(--light-green);
      border: none;
      border-radius: 9999px;
      padding: 0.5rem 1.8rem;
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      transition: opacity 0.2s;
    }
    .btn-confirmar-qr:hover { opacity: 0.85; }
    .btn-confirmar-qr:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-no-pago {
      background: white;
      color: var(--dark-green);
      border: 2px solid var(--dark-green);
      border-radius: 9999px;
      padding: 0.5rem 1.8rem;
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-no-pago:hover { background: #edfde5; }

    /* ══ PASO 5 - COMPROBANTE ══ */
    .s5-wrap { padding: 0; }
    .s5-header {
      background: var(--dark-green);
      color: white;
      font-size: 1rem;
      font-weight: 700;
      text-align: center;
      padding: 0.75rem 1rem;
      border-radius: 0.375rem 0.375rem 0 0;
      margin: -1rem -1.5rem 0;
    }
    .s5-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 0.5rem;
      font-size: 0.875rem;
    }
    .s5-table tr { border-bottom: 1px solid #f0f0f0; }
    .s5-table tr:last-child { border-bottom: none; }
    .s5-table td {
      padding: 0.55rem 0.5rem;
      color: var(--dark-green);
      vertical-align: top;
    }
    .s5-table td:first-child { font-weight: 700; width: 52%; }
    .s5-table td:last-child  { text-align: right; }
    .s5-imprimir-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.6rem 0.5rem;
      border-top: 1px solid #eee;
      margin-top: 0.5rem;
    }
    .s5-imprimir-label {
      font-size: 0.875rem;
      font-weight: 700;
      color: var(--dark-green);
    }
    .btn-imprimir {
      background: var(--dark-green);
      color: white;
      border: none;
      border-radius: 0.375rem;
      padding: 0.4rem 1.2rem;
      font-size: 0.875rem;
      font-weight: 700;
      cursor: pointer;
      transition: opacity 0.2s;
    }
    .btn-imprimir:hover { opacity: 0.85; }
    .btn-regresar-inicio {
      display: block;
      width: 100%;
      background: white;
      color: var(--dark-green);
      border: 2px solid var(--dark-green);
      border-radius: 9999px;
      padding: 0.55rem 1rem;
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      text-align: center;
      margin-top: 1rem;
      transition: background 0.2s;
    }
    .btn-regresar-inicio:hover { background: #edfde5; }
    .s5-footer-text {
      font-size: 0.76rem;
      color: #666;
      text-align: center;
      line-height: 1.5;
      margin-top: 0.85rem;
      padding-top: 0.85rem;
      border-top: 1px solid #eee;
    }

    /* Print styles */
    @media print {
      body > *:not(#modalSolicitud) { display: none !important; }
      #modalSolicitud { position: static !important; background: none !important; padding: 0 !important; }
      .modal-box { box-shadow: none !important; max-height: none !important; }
      .modal-header, .modal-stepper, .modal-footer,
      #modal-step1, #modal-step2, #modal-step3, #modal-step4,
      .btn-regresar-inicio, .s5-imprimir-row button,
      #calPopup { display: none !important; }
      #modal-step5 { display: block !important; }
    }
    /* ══ PASO 3 - CONFIRMACIÓN ══ */
    .s3-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.875rem;
    }
    .s3-table th {
      color: var(--dark-green);
      font-weight: 700;
      padding: 0.5rem 0.75rem;
      border-bottom: 2px solid #ddd;
      text-align: left;
    }
    .s3-table td {
      padding: 0.55rem 0.75rem;
      border-bottom: 1px solid #eee;
      color: var(--dark-green);
      vertical-align: middle;
    }
    .s3-check {
      width: 18px; height: 18px;
      accent-color: var(--dark-green);
      cursor: pointer;
    }
    .s3-check-done {
      appearance: none;
      -webkit-appearance: none;
      width: 18px; height: 18px;
      background: var(--light-green);
      border: none;
      border-radius: 3px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: default;
    }
    .s3-check-done::after {
      content: '✓';
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--dark-green);
    }
    .s3-eye-btn {
      background: none;
      border: none;
      cursor: pointer;
      color: #555;
      padding: 0.1rem;
      vertical-align: middle;
    }
    .s3-eye-btn:hover { color: var(--dark-green); }
    /* compensación */
    .s3-comp-box {
      border: 1px solid #ddd;
      border-radius: 0.5rem;
      padding: 1rem 1.25rem;
      margin: 1rem 0;
      text-align: center;
    }
    .s3-comp-question {
      font-size: 0.95rem;
      color: var(--dark-green);
      margin-bottom: 0.85rem;
      font-weight: 500;
      line-height: 1.4;
    }
    .s3-sinno {
      display: inline-flex;
      border-radius: 9999px;
      overflow: hidden;
      border: 1px solid #ccc;
    }
    .s3-sinno-btn {
      padding: 0.3rem 1.4rem;
      font-size: 0.9rem;
      font-weight: 600;
      border: none;
      cursor: pointer;
      background: white;
      color: var(--dark-green);
      transition: background 0.15s, color 0.15s;
    }
    .s3-sinno-btn.active-si {
      background: var(--dark-green);
      color: white;
    }
    .s3-sinno-btn.active-no {
      background: var(--dark-green);
      color: white;
    }
    /* slider compensación */
    .s3-slider-wrap {
      margin-top: 0.85rem;
      display: none;
    }
    .s3-slider-label {
      font-size: 0.8rem;
      color: #888;
      margin-bottom: 0.3rem;
      text-align: left;
    }
    .s3-slider {
      -webkit-appearance: none;
      appearance: none;
      width: 100%;
      height: 4px;
      border-radius: 2px;
      background: linear-gradient(to right, #9c59b6 0%, #9c59b6 var(--pct,20%), #ddd var(--pct,20%), #ddd 100%);
      outline: none;
      cursor: pointer;
    }
    .s3-slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      width: 16px; height: 16px;
      border-radius: 50%;
      background: #9c59b6;
      cursor: pointer;
    }
    .s3-slider::-moz-range-thumb {
      width: 16px; height: 16px;
      border-radius: 50%;
      background: #9c59b6;
      border: none;
      cursor: pointer;
    }
    .s3-slider-title {
      font-size: 0.9rem;
      font-weight: 700;
      color: var(--dark-green);
      margin: 0.75rem 0 0.4rem;
      text-align: center;
    }
    .s3-monto-label {
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--dark-green);
      text-align: left;
      margin-top: 0.6rem;
    }
    .s3-monto-input {
      width: 100%;
      border: 1px solid #bbb;
      border-radius: 0.375rem;
      padding: 0.4rem 0.65rem;
      font-size: 0.95rem;
      color: #888;
      background: #f9f9f9;
      margin-top: 0.25rem;
      box-sizing: border-box;
    }
    /* total */
    .s3-total-box {
      border: 1px solid #ddd;
      border-radius: 0.5rem;
      padding: 0.75rem 1.25rem;
      text-align: center;
      margin-top: 0.5rem;
    }
    .s3-total-label {
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--dark-green);
    }
    .s3-total-amount {
      font-size: 1.3rem;
      font-weight: 900;
      color: var(--dark-green);
      margin-top: 0.1rem;
    }
    /* PSE / Pagar */
    .s3-pse-wrap {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0.75rem 0 0.25rem;
    }
    .s3-pse-logo {
      height: 38px;
      cursor: pointer;
      border-radius: 6px;
    }
    .btn-pagar {
      background: var(--dark-green);
      color: var(--light-green);
      border: none;
      border-radius: 9999px;
      padding: 0.5rem 2.5rem;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: opacity 0.2s;
    }
    .btn-pagar:hover { opacity: 0.85; }

    /* ── Mobile ── */
    @media (max-width: 600px) {
      .modal-form-grid { grid-template-columns: 1fr; }
      .modal-box { max-height: 95vh; }
    }

    .section-visual img { width: 100%; height: auto; }

    .section-3 { display: flex; flex-direction: row; margin: 5% 8rem; gap: 2rem; }
    .section-3-svg { display: flex; flex-direction: column; justify-content: center; align-items: center; width: 75%; gap: 1rem; }
    .section-3-titulo p { font-size: 3rem; color: var(--dark-green); }
    .section-3-titulo span { display: block; font-weight: 700; font-size: 3rem; }

    .footer-outer { width: 100%; height: 45rem; position: relative; display: flex; flex-direction: column; justify-content: center; align-items: center; }
    .footer-bg-gray { position: absolute; bottom: 0; left: 0; right: 0; height: 50%; background: #EDEDED; }
    .footer-bg-dark { position: absolute; bottom: 0; left: 0; right: 0; height: 50%; background: var(--dark-green); top: 50%; }
    .footer-card { position: relative; z-index: 10; background: white; border-radius: 1rem; padding: 2.5rem; width: 80%; max-width: 900px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
    .footer-card h2 { color: var(--dark-green); font-weight: 700; font-size: 1.2rem; margin-bottom: 0.25rem; }
    .footer-card p { color: var(--dark-green); font-weight: 700; font-size: 0.875rem; }
    .footer-card h4 { color: var(--dark-green); font-weight: 700; margin-top: 1rem; font-size: 0.875rem; }
    .footer-card span { font-weight: 100; border-bottom: 2px solid var(--light-green); margin-left: 2px; font-size: 0.875rem; }
    .footer-top { display: flex; gap: 2rem; flex-wrap: wrap; }
    .footer-left { margin-right: 2.5rem; flex: 1; min-width: 200px; }
    .footer-logo-img { width: 18rem; max-width: 100%; }
    .footer-enlaces { display: flex; justify-content: space-between; margin-top: 1.8rem; flex-wrap: wrap; gap: 1rem; }
    .footer-enlaces a { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; color: var(--dark-green); }
    .footer-enlaces a img { width: 1.5rem; }
    .footer-enlaces span { font-size: 0.875rem; border-bottom: none; margin: 0; }
    .footer-links { display: flex; justify-content: space-between; margin-top: 1rem; flex-wrap: wrap; gap: 0.5rem; }
    .footer-links a { font-size: 0.85rem; color: var(--dark-green); cursor: pointer; }
    .footer-links a:hover { text-decoration: underline; }
    .footer-secretaria { background: #3B82F6; height: 4rem; width: 100%; display: flex; align-items: center; padding: 0.5rem 5rem; gap: 1.5rem; }
    .footer-secretaria img { max-height: 2.5rem; }

    @media (max-width: 768px) {
      .navbar-container {
        flex-wrap: nowrap;
        justify-content: space-between;
        padding: 0 0.8rem;
      }
      .logo-container {
        flex: 1;
        display: flex;
        justify-content: center;
      }
      .logo-container a {
        width: 8rem;
        padding-left: 0;
      }
      .navbar-desktop {
        display: none !important;
      }
      .mobile-title {
        display: none !important;
      }
      .hamburger-btn {
        display: block;
        order: 3;
        font-size: 1.5rem;
        padding: 0.3rem 0.5rem;
      }
      .nav-extras-mobile {
        display: flex !important;
        align-items: center;
        gap: 0.5rem;
        order: 2;
      }
      .nav-extras-mobile .lang-btn {
        color: white;
        font-weight: 600;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0.3rem 0.5rem;
      }
      .nav-extras-mobile .lang-btn svg {
        fill: var(--light-green);
        width: 10px;
        height: 10px;
      }
      .nav-extras-mobile .btn-support-mobile {
        background: white;
        color: var(--dark-green);
        font-weight: 600;
        border: 2px solid var(--dark-green);
        border-radius: 9999px;
        padding: 0.15rem 0.8rem;
        font-size: 0.65rem;
        cursor: pointer;
        transition: background 0.3s;
        white-space: nowrap;
      }
      .nav-extras-mobile .btn-support-mobile:hover {
        background: #edfde5;
      }
      .nav-extras-mobile .btn-support-mobile a {
        color: inherit;
        text-decoration: none;
      }
      .section-1-overlay {
        top: 50%;
        transform: translateY(-50%);
        left: 4%;
        width: 58%;
        padding: 0;
        margin-top: 0;
      }
      .section-1-text-block span {
        font-size: clamp(0.65rem, 2.2vw, 1.2rem);
      }
      .section-1-overlay .btn-solicitud {
        display: none;
      }
      .mobile-cta-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: #fff;
      }
      .mobile-cta-wrap .btn-solicitud {
        display: block;
        width: 85%;
        font-size: 1rem;
        padding: 0.75rem 1.5rem;
        margin-top: 0;
        text-align: center;
      }
      .section-2 {
        margin: 2rem 1rem 2rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
      }
      .section-2-svg-block {
        width: 100%;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
      }
      .section-2-svg-block svg {
        width: 180px !important;
        height: 180px !important;
      }
      .section-2-titulo h1 {
        font-size: 2rem;
        text-align: center;
      }
      .section-2 > .green-divider {
        width: 100%;
        height: 4px;
        align-self: auto;
      }
      .section-2-info {
        display: flex;
        width: 100%;
      }
      .text-trimmer-container {
        margin-left: 0;
        padding: 0 0.5rem;
      }
      .text-trimmer-container p {
        font-size: 0.95rem;
        line-height: 1.65;
        height: auto;
        overflow: visible;
      }
      .btn-more {
        margin-left: auto;
        margin-right: auto;
      }
      .cards-inner {
        width: 100%;
        flex-direction: column;
        align-items: center;
      }
      .paso-paso-section {
        height: auto;
        flex-direction: column;
        align-items: center;
        gap: 1.25rem;
      }
      .paso-paso-card {
        height: auto;
        min-height: 20rem;
        width: 90%;
        max-width: 360px;
      }
      .card-top {
        height: 10rem;
      }
      .section-registro {
        padding: 0;
      }
      .registro-form-wrap {
        width: 90%;
      }
      .section-3 {
        display: flex;
        flex-direction: column;
        margin: 2rem 1rem;
        gap: 1.25rem;
      }
      .section-3-svg {
        width: 100%;
      }
      .section-3-titulo p,
      .section-3-titulo span {
        font-size: 2rem;
      }
      .section-3 > .green-divider {
        width: 100%;
        height: 4px;
        align-self: auto;
      }
      .section-3 .text-trimmer-container {
        margin-left: 0;
        padding: 0 0.5rem;
      }
      .section-3 .text-trimmer-container p {
        font-size: 0.95rem;
        line-height: 1.65;
        height: auto;
        overflow: visible;
      }
      .footer-outer {
        height: auto;
        padding: 2rem 0;
      }
      .footer-card {
        width: 90%;
        padding: 1.5rem;
      }
      .footer-top {
        flex-direction: column;
      }
      .footer-enlaces {
        flex-direction: column;
      }
      .footer-links {
        flex-direction: column;
        text-align: center;
      }
      .footer-secretaria {
        padding: 0.5rem 1rem;
      }
    }

    @media (max-width: 480px) {
      .logo-container a {
        width: 6rem;
      }
      .nav-extras-mobile .lang-btn {
        font-size: 0.65rem;
      }
      .nav-extras-mobile .btn-support-mobile {
        font-size: 0.55rem;
        padding: 0.1rem 0.6rem;
      }
      .hamburger-btn {
        font-size: 1.3rem;
        padding: 0.2rem 0.4rem;
      }
      .section-2 {
        margin: 1.5rem 0.75rem;
      }
      .section-3 {
        margin: 1.5rem 0.75rem;
      }
      .section-3-titulo p,
      .section-3-titulo span {
        font-size: 1.5rem;
      }
      .registro-form-wrap {
        width: 95%;
      }
      .btn-comenzar {
        font-size: 1rem;
      }
      .section-1-overlay {
        width: 62%;
      }
    }
  </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav>
  <div class="navbar-container">
    <div class="logo-container">
      <a href="index.php">
        <img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/Logo_Pico_y_Placa_Solidario.png" alt="Logo Pico y Placa Solidario">
      </a>
    </div>

    <!-- Desktop -->
    <div class="navbar-desktop">
      <ul>
        <li class="active"><a href="index.php">Inicio</a></li>
        <li><a href="#">Simulador</a></li>
        <li><a href="#">Registro</a></li>
        <li><a href="#">Solicitudes</a></li>
        <li><a href="#">Preguntas frecuentes</a></li>
      </ul>
      <div class="nav-extras">
        <div class="nav-divider"></div>
        <button class="lang-btn">Esp <svg xmlns="http://www.w3.org/2000/svg" fill="#88F456" height="1em" viewBox="0 0 512 512" width="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg></button>
        <button class="btn-support"><a rel="noopener noreferrer" href="https://www.movilidadbogota.gov.co/web/content/reporte_de_fallas_pico_y_placa_solidario" target="_blank">Soporte técnico</a></button>
      </div>
    </div>

    <!-- Mobile extras: Esp + Soporte técnico -->
    <div class="nav-extras-mobile" style="display:none;">
      <button class="lang-btn">Esp <svg xmlns="http://www.w3.org/2000/svg" fill="#88F456" height="1em" viewBox="0 0 512 512" width="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg></button>
      <button class="btn-support-mobile"><a rel="noopener noreferrer" href="https://www.movilidadbogota.gov.co/web/content/reporte_de_fallas_pico_y_placa_solidario" target="_blank">Soporte técnico</a></button>
    </div>

    <div class="mobile-title"><span>Inicio</span></div>
    <button class="hamburger-btn" aria-label="Menú">&#9776;</button>
  </div>
</nav>

<!-- ===== HERO ===== -->
<section class="section-1">
  <img class="banner-img" src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/Foto-fondo_banner-principal_3%20(1).jpg" alt="Banner principal">
  <div class="section-1-overlay">
    <div class="section-1-text-block">
      <span class="span-dark">Movilízate con</span>
      <span class="span-dark">el permiso de</span>
      <span class="span-green">PICO Y PLACA</span>
      <span class="span-green">SOLIDARIO</span>
    </div>
    <div><button class="btn-solicitud">Inicia tu solicitud</button></div>
  </div>
</section>
<div class="mobile-cta-wrap">
  <button class="btn-solicitud">Inicia tu solicitud</button>
</div>

<!-- ===== SECTION 2 ===== -->
<section class="section-2">
  <div class="section-2-svg-block">
    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="250px" height="250px" viewBox="0 0 205.000000 175.000000" preserveAspectRatio="xMidYMid meet">
      <g transform="translate(0.000000,175.000000) scale(0.100000,-0.100000)" fill="#00271C" stroke="none">
        <path d="M830 1476 c-6 -6 -10 -15 -10 -21 0 -8 -39 -10 -135 -7 -147 5 -189 -4 -199 -41 -3 -12 -6 -273 -6 -580 l0 -558 25 -24 24 -25 433 5 c238 3 447 8 463 11 105 22 193 119 211 232 9 60 -21 154 -67 206 l-39 44 0 346 c0 427 19 389 -187 384 -137 -3 -143 -2 -158 19 -15 21 -22 22 -180 20 -94 -1 -169 -5 -175 -11z m326 -93 l1 -63 -153 0 -153 0 3 63 c2 34 4 63 5 65 0 1 67 1 149 0 l147 -3 1 -62z m-336 2 c0 -14 -6 -25 -12 -26 -7 0 -56 0 -108 1 -53 1 -103 -2 -113 -6 -16 -6 -17 -43 -17 -513 0 -381 3 -510 12 -519 9 -9 90 -12 302 -12 290 -1 326 -5 326 -36 0 -9 -652 -8 -677 1 -10 3 -13 125 -13 563 0 307 3 562 7 565 3 4 71 7 150 7 l143 0 0 -25z m665 15 c11 -18 7 -655 -4 -654 -43 4 -41 -12 -41 303 0 273 -1 299 -17 305 -10 4 -60 7 -113 6 -52 -1 -101 -1 -107 -1 -7 1 -13 12 -13 26 l0 25 144 0 c86 0 147 -4 151 -10z m-657 -100 c11 -19 23 -20 181 -20 161 0 170 1 176 20 6 18 15 20 116 20 l109 0 0 -275 0 -275 -47 0 c-195 -1 -332 -212 -245 -378 l22 -42 -270 0 -270 0 0 485 0 485 108 0 c96 0 108 -2 120 -20z m665 -609 c69 -47 99 -104 99 -191 0 -58 -5 -78 -26 -114 -48 -81 -112 -116 -215 -116 -61 0 -70 3 -116 38 -65 49 -105 120 -105 187 0 85 56 179 125 210 54 24 59 25 126 21 55 -3 74 -9 112 -35z"/>
        <path d="M854 1163 c-13 -16 -39 -48 -57 -73 -27 -36 -39 -45 -64 -45 -50 -1 -63 -19 -63 -87 0 -78 11 -98 55 -98 25 0 35 -5 40 -20 7 -21 53 -50 79 -50 9 0 31 16 50 35 35 35 36 35 121 35 67 0 85 -3 85 -14 0 -19 52 -56 79 -56 11 0 35 16 54 35 22 22 43 35 60 35 35 0 47 25 47 99 0 71 -17 96 -62 87 -26 -5 -33 1 -78 63 -28 38 -57 72 -66 75 -9 3 -70 6 -136 6 -119 0 -121 0 -144 -27z m131 -63 l0 -54 -82 -2 c-46 0 -83 3 -83 8 0 4 14 27 31 51 25 35 37 43 72 48 23 3 47 5 52 4 6 -1 10 -26 10 -55z m108 49 c26 0 38 -9 65 -45 17 -24 32 -48 32 -52 0 -4 -37 -7 -82 -7 l-83 2 -3 42 c-4 54 3 75 24 67 9 -3 30 -6 47 -7z m209 -185 c2 -26 -2 -53 -8 -62 -15 -20 -42 -9 -53 21 -18 46 -105 45 -133 -1 -16 -26 -19 -26 -100 -23 -76 2 -85 5 -104 29 -17 21 -30 27 -64 27 -35 0 -46 -6 -69 -33 -39 -48 -61 -36 -61 34 l0 54 294 0 294 0 4 -46z m-434 -56 c32 -32 0 -83 -45 -72 -25 7 -36 40 -22 66 11 20 49 24 67 6z m342 -3 c30 -36 -18 -87 -62 -64 -20 11 -24 49 -6 67 17 17 53 15 68 -3z"/>
        <path d="M673 675 c-3 -9 -3 -18 0 -21 3 -3 82 -6 176 -7 135 -2 172 1 176 11 3 8 3 18 -1 23 -3 5 -82 9 -175 9 -144 0 -171 -2 -176 -15z"/>
        <path d="M673 573 c-3 -7 -2 -16 1 -22 8 -12 343 -14 350 -2 3 5 4 15 1 23 -7 18 -345 19 -352 1z"/>
        <path d="M674 471 c-2 -2 -4 -10 -4 -18 0 -10 37 -13 181 -13 164 0 180 2 177 17 -3 15 -22 17 -176 17 -96 1 -176 -1 -178 -3z"/>
        <path d="M1423 540 c-32 -49 -62 -90 -66 -90 -5 0 -28 16 -51 35 -48 39 -66 44 -66 17 0 -15 63 -71 117 -105 8 -5 27 15 57 60 25 38 57 85 72 105 25 35 27 68 5 68 -6 0 -36 -40 -68 -90z" fill="#88F456"/>
      </g>
    </svg>
    <div class="section-2-titulo">
      <h1>¿ Qué es el <span>Pico y Placa Solidario?</span></h1>
    </div>
  </div>
  <div class="green-divider"></div>
  <div class="section-2-info">
    <div class="text-trimmer-container">
      <p>El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa. El 100% de este recaudo está destinado a la financiación, el fortalecimiento y el mejoramiento de la calidad del Sistema Integrado de Transporte Público de la ciudad. Adicionalmente, el Pico y Placa Solidario busca promover la conciencia de los propietarios de vehículos particulares sobre los impactos negativos que podrían generar su uso individual en la ciudad, incentivando así el uso de modos alternativos de transporte.</p>
      <button class="btn-more">Conocer más</button>
    </div>
  </div>
</section>

<!-- ===== CARDS ===== -->
<section class="section-cards">
  <div class="cards-inner">
    <div class="paso-paso-section">
      <div class="paso-paso-card">
        <div class="card-top">
          <img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/icono_paso_a_paso.svg" alt="Paso a paso natural">
          <div class="triangle-down"></div>
        </div>
        <div class="card-text"><h2>Paso a paso</h2><p>Inscripción personas naturales</p></div>
        <div class="card-btn-wrap"><a class="btn-card" target="_blank" rel="noopener noreferrer" href="https://storagearchivopypsprd.blob.core.windows.net/documentspyp/configLanding/vistaMedia/Mialing_Pico-Placa-Solidario-NATURAL.pdf">Comenzar</a></div>
      </div>
      <div class="paso-paso-card">
        <div class="card-top">
          <img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/icono_paso_a%20_paso_juridico.svg" alt="Paso a paso jurídico">
          <div class="triangle-down"></div>
        </div>
        <div class="card-text"><h2>Paso a paso</h2><p>Inscripción personas jurídicas</p></div>
        <div class="card-btn-wrap"><a class="btn-card" target="_blank" rel="noopener noreferrer" href="https://storagearchivopypsprd.blob.core.windows.net/documentspyp/configLanding/vistaMedia/Mialing_Pico-Placa-Solidario-JURIDICA.pdf">Comenzar</a></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== REGISTRO ===== -->
<section class="section-registro" id="registroSection">
  <div class="registro-header">
    <div class="inicio-registro-header">
      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 626 778" xml:space="preserve" width="70px" height="70px">
        <style>.st0{fill:#88f456;stroke:light-green;stroke-miterlimit:10;}</style>
        <g><g>
          <path d="M426.3,762c-6.4-1.4-12.7-2.7-19.1-4.1c-24-5.4-45.3-16.2-64.3-31.9c-2.6-2.1-6.7-3.4-10.2-3.4c-90.4-0.2-180.9-0.1-271.3-0.1c-13.4,0-17.4-3.8-17.4-17.4c0-186.8,0-373.6,0-560.3c0-12.4,4-16.4,16.3-16.4c30.7,0,61.5-0.1,92.2,0.1c4.8,0,6.7-1.2,6.4-6.3c-0.4-8.1-0.2-16.3-0.1-24.4c0.2-10.5,5-15.1,15.5-15.2c13.3,0,26.6,0,39.9,0c2.1,0,4.2,0,6.8,0c0.4-12.3,3.3-23.3,9.3-33.4c10.1-17.1,25.2-26.9,44.4-31.1c1.3-0.3,2.6-0.8,3.9-1.2c4.8,0,9.5,0,14.3,0c12.6,2.9,24.8,6.7,34.9,15.4c13.9,12,21.5,27.1,23.2,45.3c0.1,1,0.2,2,0.3,3c0,0.4,0.2,0.7,0.6,1.9c7,0,14.3,0,21.5,0c7.5,0,15.1,0,22.6,0c13.2,0,17.1,3.9,17.1,16.9c0,7.7,0.2,15.5-0.1,23.2c-0.2,4.5,1.4,5.7,5.8,5.7c30.5-0.2,61.1-0.1,91.6-0.1c14.1,0,18,3.9,18,18c0,110,0,220-0.1,330.1c0,5.1,1.4,8.1,5.6,11.2c63.4,47.9,79,137.2,35.7,203.7c-24.8,38.1-59.8,60.8-104.6,68.6C432.4,760.4,429.4,761.3,426.3,762z" class="st0"/>
          <path d="M433.7,629.5c14.3-13.7,28.1-27,42-40.2c10.2-9.7,20.3-19.5,30.5-29.2c4.2-4,9-6.8,15-4.4c8.1,3.3,10.2,12.9,3.8,19.7c-7.3,7.8-15.3,15-23,22.4c-19.2,18.4-38.3,36.7-57.5,55c-6.7,6.4-12.3,6.6-19.5,0.9c-17.8-14.2-35.7-28.3-53.4-42.6c-2.8-2.3-5.8-5.2-7-8.5c-2-5.2-0.6-10.1,4.4-13.6c4.9-3.4,9.8-3,14.3,0.5c9.4,7.2,18.6,14.7,27.9,22.1C418.5,617.4,425.8,623.2,433.7,629.5z" class="st0"/>
        </g></g>
      </svg>
      <p class="registro-title">Iniciar <b>Solicitud</b></p>
    </div>
    <div class="registro-line"></div>
    <div class="registro-desc">
      <p>Inicia tu registro para obtener el permiso o</p>
      <p>consulta el estado de tus solicitudes en trámite</p>
    </div>
  </div>
  <div class="registro-form-wrap">
    <div class="form-inner">
      <div class="form-section">
        <div class="form-group">
          <label for="tipoDocumento"><b>Tipo de Documento</b>:</label>
          <select id="tipoDocumento">
            <option value="">--- Seleccionar ---</option>
            <option value="1">Cédula de ciudadanía</option>
            <option value="2">Cédula de Extranjería</option>
            <option value="3">Tarjeta de Identidad</option>
            <option value="4">Pasaporte</option>
            <option value="5">Carnet Diplomático</option>
            <option value="6">Registro Civil</option>
            <option value="7">Permiso por Protección Temporal</option>
            <option value="8">NIT</option>
          </select>
        </div>
        <div class="form-group">
          <label for="numeroDocumento"><b>Número de Documento</b>:</label>
          <input type="text" id="numeroDocumento" placeholder="" autocomplete="off">
        </div>
      </div>
      <button class="btn-comenzar" id="btnComenzar" disabled>Comenzar registro</button>
    </div>
  </div>
</section>

<!-- ===== VISUAL ===== -->
<section class="section-visual">
  <img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/fondo_descanso%20visual.jpg" alt="Descanso visual">
</section>

<!-- ===== SECTION 3 ===== -->
<section class="section-3">
  <div class="section-3-svg">
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 879 800" xml:space="preserve" width="160px" height="145px">
      <style>.st1{fill:#88f456;}</style>
      <g><g>
        <path d="M837.2,686.1c-4.7,7.5-11.6,9.6-20,9.3c-11.5-0.4-23-0.1-34.8-0.1c-3.2,17-9.2,32.1-19.8,45.2c-15,18.4-34.2,29.7-57.5,34c-1.7,0.3-3.4,1-5.1,1.5c-6.8,0-13.7,0-20.5,0c-13-4.7-26.8-7.8-38.8-14.4c-23.3-12.7-37.2-33.5-43-59.3c-1.1-4.7-2.3-7.2-7.9-7.1c-78.1,0.2-156.2,0.1-234.3,0.2c-1,0-2.1,0.2-3.5,0.3c-2,6.7-3.4,13.7-6,20.1c-13.5,32.6-37.7,52.3-72.4,58.9c-1.5,0.3-2.9,1-4.3,1.4c-6.8,0-13.7,0-20.5,0c-0.7-0.3-1.4-0.8-2.2-0.9c-42.9-7.8-70.1-32.2-80.5-75c-0.5-2-4.1-4.5-6.4-4.6c-10.5-0.5-21-0.2-31.5-0.2c-13.2-0.1-18.1-4.9-18.1-18.2c-0.1-18.9-0.3-37.9,0.1-56.8c0.2-6.9-1.9-11.4-7.1-16.1C41.9,549.8,18,481.9,34.5,402C48.9,332.9,90.6,284.1,155,254.9c28.3-12.8,58.1-17.5,89-17.5c104.7,0.1,209.3,0,314,0c3.4,0,6.8,0,10.3,0c0.7-2.1,1.5-3.8,1.9-5.6c10.5-45.1,46-74.2,92.7-75.3c25.5-0.6,51-0.2,76.5-0.1c12.2,0.1,17.1,5.2,17.2,17.4c0.1,7.5,0,15,0,23c27.6,0,54.1,0,80.7,0c0,8.9,0,17.9,0,26.8c-26.5,0-53,0-80.1,0c0,18,0,35.4,0,53.6c26.7,0,53.4,0,80.1,0c0,8.9,0,17.9,0,26.8c-26.7,0-53.4,0-80.7,0c0,9.3,0.2,17.2,0,25c-0.3,10.5-5.3,15.7-15.6,15.8c-27.6,0.2-55.2,0.7-82.8-0.2c-42-1.4-78.7-32.5-87.6-73.5c-1.2-5.4-3.1-7.1-8.7-7.1c-107.3,0.2-214.5,0.2-321.8,0.1c-33,0-64.2,7.2-92.6,24.2C68.1,335.8,36.6,425.7,69,512.2c8.6,23,21.9,43.3,40.4,61.4c0.3-2.1,0.7-3.1,0.5-3.9c-4.2-21.7,5.5-37.4,22-50c0.2-0.2,0.4-0.4,0.6-0.6C238.4,416.5,364,379.6,508.2,409c68.2,13.9,128,46.3,180.3,92.3c4.7,4.2,10.8,7.4,16.8,9.3c20.7,6.7,41.7,12.7,62.5,19c25,7.5,45,21.9,57.1,45.2c5.7,11,8.3,23.6,12.3,35.4C837.2,635.6,837.2,660.8,837.2,686.1z" fill="#00271c"/>
        <path d="M783.4,102.6c5.3,0,8.9,0.8,11.9-0.2c4.6-1.6,9.9-3.6,12.9-7.1c4-4.6,2-10.5-1.5-15.2c-8.4-11.4-17-22.7-25.5-34c-3.9-5.2-7.8-10.5-11.8-15.7c-6.7-8.7-13.9-10.6-20.8-5.7c-7,5-7.2,13-0.5,22.1c6.8,9.2,13.7,18.3,21.6,28.9c-5.3,0-8.9-0.2-12.4,0c-12.4,0.9-18.5,11.7-11.4,21.7c12.9,18.2,26.5,35.9,40.1,53.5c4.9,6.3,13.3,7,19,2.5c5.6-4.4,6.9-11.8,2.3-18.3C800.1,124.7,792.3,114.5,783.4,102.6z" class="st1"/>
      </g></g>
    </svg>
    <div class="section-3-titulo"><p>Vehículos <span>Eléctricos</span><span>o Híbridos</span></p></div>
  </div>
  <div class="green-divider"></div>
  <div class="section-2-info">
    <div class="text-trimmer-container">
      <p>Otra forma de contribuir a la calidad del aire y el medio ambiente de Bogotá es movilizarse en un vehículo eléctrico o híbrido. Para la circulación de estos vehículos no se requieren contribuciones económicas por Pico y Placa Solidario, ya que no tienen restricción de circulación después de realizado el trámite de excepción. Si posees un vehículo híbrido, estás contribuyendo a la meta de bajas emisiones fijada por la ciudad para el 2040, donde cada vehículo nuevo matriculado en Bogotá debe ser eléctrico o de cero emisiones.</p>
      <button class="btn-more">Ver Exceptuados</button>
    </div>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer>
  <div class="footer-outer">
    <div class="footer-bg-gray"></div>
    <div class="footer-bg-dark"></div>
    <div class="footer-card">
      <div class="footer-top">
        <div class="footer-left">
          <h2>Secretaría distrital de movilidad</h2>
          <p>Nit. 899.999.061-9</p>
          <div>
            <h4>Sede principal</h4>
            <p>Dirección: <span>Calle 13 # 37 - 35, Bogotá D.C</span></p>
            <p>Línea gratuita: <span>018000 127 425</span></p>
            <p>Centro de Contacto de Movilidad: <span>+57 (601) 364 9400 Opción 2</span></p>
            <p>Correo Institucional: <span>https://bogota.gov.co/sdqs/</span></p>
            <h4>E-mail exclusivo para notificaciones judiciales:</h4>
            <span>judicial@movilidadbogota.gov.co</span>
            <h4>Radicación exclusiva para entes de control y entidades públicas:</h4>
            <span>radicacionentidades@movilidad.gov.co</span>
          </div>
        </div>
        <div>
          <img class="footer-logo-img" src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/Screenshot%202024-04-24%20151308.png" alt="Logos institucionales">
        </div>
      </div>
      <div class="footer-enlaces">
        <a href="https://www.facebook.com/secretariamovilidadbogota"><img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/icono_facebook.svg" alt="Facebook"><span>secretariamovilidadbogota</span></a>
        <a href="#"><img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/Icono_X.svg" alt="X"><span>@SectorMovilidad</span></a>
        <a href="https://www.youtube.com/@secretariamovilidad"><img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/icono_youtube.svg" alt="YouTube"><span>secretariamovilidad</span></a>
        <a href="https://www.instagram.com/sectormovilidad/"><img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/icono_instagram.svg" alt="Instagram"><span>secretariamovilidad</span></a>
      </div>
      <div class="footer-links">
        <a href="#" target="_blank">Acerca de nosotros</a>
        <a href="#" target="_blank">Mapa del sitio</a>
        <a href="#" target="_blank">Política de privacidad</a>
        <a href="#" target="_blank">Aplicativo de la SDM</a>
        <a href="#" target="_blank">Denuncias por actos de corrupción</a>
      </div>
    </div>
  </div>
  <div class="footer-secretaria">
    <img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/channels-956_marca_colombia.png" alt="Marca Colombia">
    <img src="./El Pico y Placa Solidario permite adquirir voluntariamente un permiso diario, mensual o semestral para circular en Bogotá sin la restricción del pico y placa_files/channels-956_header_govco.png" alt="Gobierno Colombia">
  </div>
</footer>

<!-- ===== TOAST ===== -->
<div class="toast" id="toast"></div>

<!-- ===== MODAL ===== -->
<div id="modalSolicitud" class="modal-overlay" style="display:none;" aria-modal="true" role="dialog">
  <div class="modal-box">

    <!-- Header -->
    <div class="modal-header">
      <span class="modal-header-title">Iniciar Solicitud</span>
      <button class="modal-close-btn" id="modalCloseBtn" aria-label="Cerrar">&#10005;</button>
    </div>

    <!-- Stepper -->
    <div class="modal-stepper" id="modalStepper">
      <div class="step">
        <div class="step-circle active" id="sc1">1</div>
        <div class="step-label active" id="sl1">Re...</div>
      </div>
      <div class="step-line" id="line1"></div>
      <div class="step">
        <div class="step-circle" id="sc2">2</div>
        <div class="step-label" id="sl2">Soli...</div>
      </div>
      <div class="step-line" id="line2"></div>
      <div class="step">
        <div class="step-circle" id="sc3">3</div>
        <div class="step-label" id="sl3">Confir...</div>
      </div>
      <div class="step-line" id="line3"></div>
      <div class="step">
        <div class="step-circle" id="sc4">4</div>
        <div class="step-label" id="sl4">C...</div>
      </div>
      <div class="step-line" id="line4"></div>
      <div class="step">
        <div class="step-circle" id="sc5">5</div>
        <div class="step-label" id="sl5">Apro...</div>
      </div>
    </div>

    <!-- ══ PASO 1: Datos básicos ══ -->
    <div class="modal-form-section" id="modal-step1">
      <div class="modal-form-title">Datos básicos de la persona</div>
      <div class="modal-form-grid">
        <div class="modal-field">
          <label>Primer nombre<span class="req">*</span>:</label>
          <input type="text" id="mf-primerNombre">
        </div>
        <div class="modal-field">
          <label>Segundo nombre:</label>
          <input type="text" id="mf-segundoNombre">
        </div>
        <div class="modal-field">
          <label>Primer apellido<span class="req">*</span>:</label>
          <input type="text" id="mf-primerApellido">
        </div>
        <div class="modal-field">
          <label>Segundo apellido:</label>
          <input type="text" id="mf-segundoApellido">
        </div>
        <div class="modal-field full-width">
          <label>Correo electrónico primario<span class="req">*</span>:</label>
          <input type="text" id="mf-emailPrimario">
        </div>
        <div class="modal-field full-width">
          <label>Correo electrónico secundario:</label>
          <input type="text" id="mf-emailSecundario">
        </div>
        <div class="modal-field">
          <label>Departamento de residencia<span class="req">*</span>:</label>
          <select id="mf-departamento"><option value="">Cargando departamentos...</option></select>
        </div>
        <div class="modal-field">
          <label>Municipio de residencia<span class="req">*</span>:</label>
          <select id="mf-municipio"><option value="">Seleccione departamento primero</option></select>
        </div>
        <div class="modal-field full-width" id="mf-localidad-wrap">
          <label>Localidad de residencia<span class="req">*</span>:</label>
          <select id="mf-localidad">
            <option value="0">No Aplica</option>
            <option value="1">Usaquén</option>
            <option value="2">Chapinero</option>
            <option value="3">Santa Fe</option>
            <option value="4">San Cristóbal</option>
            <option value="5">Usme</option>
            <option value="6">Tunjuelito</option>
            <option value="7">Bosa</option>
            <option value="8">Kennedy</option>
            <option value="9">Fontibón</option>
            <option value="10">Engativá</option>
            <option value="11">Suba</option>
            <option value="12">Barrios Unidos</option>
            <option value="13">Teusaquillo</option>
            <option value="14">Los Mártires</option>
            <option value="15">Antonio Nariño</option>
            <option value="16">Puente Aranda</option>
            <option value="17">La Candelaria</option>
            <option value="18">Rafael Uribe Uribe</option>
            <option value="19">Ciudad Bolívar</option>
            <option value="20">Sumapaz</option>
          </select>
        </div>
        <div class="modal-field full-width">
          <label>Dirección de correspondencia<span class="req">*</span>:</label>
          <input type="text" id="mf-dirCorrespondencia">
        </div>
        <div class="modal-field full-width">
          <label>Teléfono o celular:</label>
          <input type="text" id="mf-telefono">
        </div>
        <div class="modal-field full-width">
          <label>Dirección de origen<span class="req">*</span>:</label>
          <input type="text" id="mf-dirOrigen">
        </div>
        <div class="modal-field full-width modal-checkbox-wrap">
          <label class="modal-check-label">
            <input type="checkbox" id="mf-copiarDir"> Copiar dirección de correspondencia
          </label>
        </div>
        <div class="modal-field full-width">
          <label>Dirección de destino<span class="req">*</span>:</label>
          <input type="text" id="mf-dirDestino">
        </div>
        <div class="modal-field">
          <label>Estrato<span class="req">*</span>:</label>
          <select id="mf-estrato">
            <option value="">Seleccionar</option>
            <option value="1">1</option><option value="2">2</option><option value="3">3</option>
            <option value="4">4</option><option value="5">5</option><option value="6">6</option>
          </select>
        </div>
        <div class="modal-field">
          <label>Tipo de propiedad<span class="req">*</span>:</label>
          <select id="mf-tipoPropiedad">
            <option value="">Seleccionar</option>
            <option value="1">Propietario</option>
            <option value="2">Locatario</option>
            <option value="3">Poseedor</option>
          </select>
        </div>
        <div class="modal-field">
          <label>Soy propietario de<span class="req">*</span>:</label>
          <select id="mf-cantVehiculos">
            <option value="">Seleccionar</option>
            <option value="1">1 Vehículo</option><option value="2">2 Vehículos</option>
            <option value="3">3 Vehículos</option><option value="4">4 Vehículos</option>
            <option value="5">5 o más Vehículos</option>
          </select>
        </div>
        <div class="modal-field">
          <label>Motivo de viaje:</label>
          <select id="mf-motivoViaje">
            <option value="">Seleccionar</option>
            <option value="1">Trabajo</option><option value="2">Estudio</option>
            <option value="3">Salud</option><option value="4">Otro</option>
          </select>
        </div>
      </div>
    </div>

    <!-- ══ PASO 2: Placas ══ -->
    <div class="modal-form-section" id="modal-step2">

      <!-- Sección individual ACTIVA -->
      <div class="placa-section-title">Agregar placa individual</div>

      <div class="placa-field">
        <label>Placa <span class="req">*</span> :</label>
        <input type="text" id="mf-placa" maxlength="7" placeholder="" autocomplete="off">
        <div class="placa-error" id="err-placa"></div>
      </div>

      <div class="placa-field">
        <label>Confirmar placa <span class="req">*</span> :</label>
        <input type="text" id="mf-placaConfirm" maxlength="7" placeholder="" autocomplete="off">
        <div class="placa-error" id="err-placa-confirm"></div>
      </div>

      <!-- Sección archivo DESHABILITADA -->
      <div class="archivo-section">
        <div class="archivo-section-title">Agrega placas mediante archivo<br>(Formatos: CSV, XLS, XLSX)</div>
        <div class="archivo-section-sub">Información de las placas</div>
        <div class="archivo-btn-row">
          <button class="btn-seleccionar-archivo" disabled>Seleccionar archivo</button>
          <span class="link-descargar">Descargar plantilla</span>
        </div>
      </div>

      <!-- Botón agregar placa -->
      <button class="btn-agregar-placa" id="btnAgregarPlaca" disabled>Agregar placa</button>

      <!-- Tabla de placas agregadas -->
      <div class="placas-table-wrap" id="placas-table-wrap" style="display:none;">
        <div id="placas-table-rows"></div>
        <!-- Paginación -->
        <div class="pagination-wrap">
          <span class="pag-label">Mostrar:</span>
          <select class="pag-select" id="pagSize">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
          </select>
          <button class="pag-btn" id="pagPrev">&#10094;</button>
          <span class="pag-num" id="pagNum">1</span>
          <button class="pag-btn" id="pagNext">&#10095;</button>
        </div>
      </div>

      <!-- Términos -->
      <div class="terminos-wrap" id="terminos-wrap">
        <input type="checkbox" id="mf-terminos">
        <span class="terminos-text">
          Al marcar esta casilla te comprometes a cumplir con los Términos y Condiciones de la presente medida, declarando el entendimiento y deberes que esto implica.
          <b>Ver Términos y condiciones de uso de la plataforma de Pico y Placa Solidario</b>
        </span>
      </div>

    </div>

    <!-- ══ PASO 3: Confirmación y pago ══ -->
    <div class="modal-form-section" id="modal-step3">

      <!-- Tabla de vehículos con checkboxes -->
      <div style="overflow-x:auto;">
        <table class="s3-table">
          <thead>
            <tr>
              <th></th>
              <th>Placa</th>
              <th>Valor</th>
              <th>Detalle</th>
            </tr>
          </thead>
          <tbody id="s3-vehiculos-body"></tbody>
        </table>
      </div>

      <!-- Compensación social voluntaria -->
      <div class="s3-comp-box">
        <div class="s3-comp-question">¿Desea realizar el aporte de compensación social voluntaria?</div>
        <div class="s3-sinno">
          <button class="s3-sinno-btn" id="s3-btn-si">Si</button>
          <button class="s3-sinno-btn active-no" id="s3-btn-no">No</button>
        </div>

        <!-- Slider (visible solo si Si) -->
        <div class="s3-slider-wrap" id="s3-slider-wrap">
          <div class="s3-slider-label" id="s3-slider-pct-label">20 %</div>
          <input type="range" class="s3-slider" id="s3-slider" min="20" max="100" step="1" value="20">
          <div class="s3-slider-title">Seleccione el porcentaje que desea donar</div>
          <div class="s3-monto-label">Monto a Donar:</div>
          <input type="text" class="s3-monto-input" id="s3-monto-input" readonly>
        </div>
      </div>

      <!-- Total a pagar -->
      <div class="s3-total-box">
        <div class="s3-total-label">Total a pagar:</div>
        <div class="s3-total-amount" id="s3-total-amount">$0</div>
      </div>

      <!-- PSE logo o botón Pagar -->
      <div class="s3-pse-wrap" id="s3-pse-wrap">
        <img class="s3-pse-logo" src="https://www.pse.com.co/images/pse.svg"
             onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/PSE_logo.svg/200px-PSE_logo.svg.png'"
             alt="PSE">
      </div>

    </div>

    <!-- ══ PASO 4: QR pago ══ -->
    <div class="modal-form-section" id="modal-step4">
      <div class="s4-wrap">
        <div class="s4-title">Pago por QR</div>
        <div class="s4-desc">
          Escanea el código QR con tu aplicación bancaria, envía el monto exacto
          indicado y luego presiona <b>Confirmar pago</b> para notificar al sistema.
        </div>
        <div class="s4-qr-box">
          <img id="s4-qr-img" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="QR de pago" width="200" height="200" style="border-radius:0.5rem;">
          <div class="s4-monto-badge" id="s4-monto-badge">$0</div>
        </div>
        <div class="s4-status" id="s4-status" style="display:none;">
          <div class="s4-spinner"></div>
          <span id="s4-status-text">Esperando confirmación del administrador...</span>
        </div>
        <div class="s4-btn-row">
          <button class="btn-confirmar-qr" id="btnConfirmarQr">Confirmar pago</button>
          <button class="btn-no-pago"      id="btnNoPago">Pago no realizado</button>
        </div>
      </div>
    </div>

    <!-- ══ PASO 5: Comprobante de pago ══ -->
    <div class="modal-form-section" id="modal-step5">
      <div class="s5-wrap">
        <div class="s5-header">Comprobante de pago PSE</div>
        <table class="s5-table" id="s5-tabla"></table>
        <div class="s5-imprimir-row">
          <span class="s5-imprimir-label">Imprimir comprobante de pago</span>
          <button class="btn-imprimir" onclick="window.print()">Imprimir</button>
        </div>
        <button class="btn-regresar-inicio" id="btnRegresarInicio">Regresar al inicio</button>
        <div class="s5-footer-text">
          Si requiere más información sobre su transacción, por favor comuníquese a nuestras
          líneas de atención al cliente al teléfono (601) 364 94 00 / Línea única nacional
          018000127425 o al correo electrónico contactociudadano@movilidadbogota.gov.co
        </div>
      </div>
    </div>

    <!-- ══ CALENDARIO POPUP (fuera del modal) ══ -->
    <div class="cal-popup" id="calPopup" style="display:none;"></div>

    <!-- Footer -->
    <div class="modal-footer">
      <button class="modal-btn-atras" id="modalBtnAtras">&#8592; Atrás</button>
      <button class="modal-btn-siguiente" id="modalBtnSiguiente">Siguiente</button>
    </div>

  </div>
</div>

<script>
// ══════════════════════════════════════════
//  SCROLL AL FORMULARIO DE REGISTRO
// ══════════════════════════════════════════

function scrollAlRegistro() {
  const formSection = document.getElementById('registroSection');
  if (formSection) {
    const topOffset = formSection.getBoundingClientRect().top + window.pageYOffset - 80;
    window.scrollTo({
      top: topOffset,
      behavior: 'smooth'
    });
    setTimeout(() => {
      const primerCampo = document.getElementById('tipoDocumento');
      if (primerCampo) primerCampo.focus();
    }, 600);
  }
}

document.querySelectorAll('.btn-solicitud').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    scrollAlRegistro();
  });
});

// ══════════════════════════════════════════
//  TOAST
// ══════════════════════════════════════════
function showToast(msg, type = 'success', duration = 3500) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'toast ' + type;
  void t.offsetWidth;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), duration);
}

// ══════════════════════════════════════════
//  CALENDARIO PERSONALIZADO
// ══════════════════════════════════════════
const MESES = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];
const DIAS  = ['D','L','M','X','J','V','S'];

let calState = {
  open: false, year: 0, month: 0,
  selectedDate: null, minDate: null,
  onSelect: null, anchorEl: null,
  placa: '',
  diasHabiles: null,
  loading: false,
};

const _diasHabilesCache = {};

function isoToLocalTs(iso) {
  const d = new Date(iso);
  const local = new Date(d.getUTCFullYear(), d.getUTCMonth(), d.getUTCDate());
  local.setHours(0,0,0,0);
  return local.getTime();
}

async function fetchDiasHabiles(placa) {
  if (_diasHabilesCache[placa] !== undefined) return _diasHabilesCache[placa];
  try {
    const res  = await fetch('api3.html?placa=' + encodeURIComponent(placa));
    const json = await res.json();
    if (json.data && !json.data.isError && json.data.data) {
      const set = new Set(Object.values(json.data.data).map(isoToLocalTs));
      _diasHabilesCache[placa] = set;
      return set;
    }
  } catch(e) { console.error('[PYP] api3 error:', e); }
  _diasHabilesCache[placa] = null;
  return null;
}

function formatDateDisplay(d) {
  return d.getDate() + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
}

function calcFechaFin(inicio, duracion) {
  const fin = new Date(inicio);
  fin.setHours(0,0,0,0);
  if (duracion === 'diario') {
    return fin;
  } else if (duracion === 'mensual') {
    fin.setMonth(fin.getMonth() + 1);
    fin.setDate(fin.getDate() - 1);
    return fin;
  } else if (duracion === 'semestral') {
    fin.setMonth(fin.getMonth() + 6);
    fin.setDate(fin.getDate() - 1);
    return fin;
  }
  return fin;
}

function renderCalendar() {
  const popup = document.getElementById('calPopup');
  if (!calState.open) { popup.style.display = 'none'; return; }

  if (calState.loading) {
    positionPopup(popup);
    popup.innerHTML = `<div style="padding:2rem;text-align:center;color:#888;font-size:0.9rem;">Cargando fechas disponibles...</div>`;
    popup.style.display = 'block';
    return;
  }

  const today = new Date(); today.setHours(0,0,0,0);
  const y = calState.year, m = calState.month;
  const firstDay = new Date(y, m, 1).getDay();
  const daysInMonth = new Date(y, m+1, 0).getDate();
  const habiles = calState.diasHabiles;

  let html = `
    <div class="cal-pop-header">
      <div class="cal-month-label">
        ${MESES[m]} ${y}
        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="7" viewBox="0 0 10 7">
          <path d="M1 1l4 4 4-4" stroke="#00271C" stroke-width="1.5" fill="none" stroke-linecap="round"/>
        </svg>
      </div>
      <div class="cal-nav">
        <button class="cal-nav-btn" id="calPrev">&#10094;</button>
        <button class="cal-nav-btn" id="calNext">&#10095;</button>
      </div>
    </div>
    <div class="cal-grid">`;

  DIAS.forEach(d => { html += `<div class="cal-dh">${d}</div>`; });

  let monthTagPlaced = false;
  for (let i = 0; i < firstDay; i++) {
    if (!monthTagPlaced) {
      html += `<div class="cal-cell"><div class="cal-month-tag">${MESES[m]}</div></div>`;
      monthTagPlaced = true;
    } else {
      html += `<div class="cal-cell"></div>`;
    }
  }

  for (let d = 1; d <= daysInMonth; d++) {
    const thisDate = new Date(y, m, d); thisDate.setHours(0,0,0,0);
    const ts = thisDate.getTime();
    const isPast = thisDate < today;
    const isHabil = !habiles ? !isPast : habiles.has(ts);
    const isSel   = calState.selectedDate && ts === calState.selectedDate.getTime();

    let cls = 'cal-day-btn ';
    if (!isHabil)     cls += 'cal-past';
    else if (isSel)   cls += 'cal-selected';
    else              cls += 'cal-habiles';

    html += `<div class="cal-cell"><button class="${cls}" data-ts="${ts}" ${!isHabil?'disabled':''}>${d}</button></div>`;
  }

  const totalCells = firstDay + daysInMonth;
  const rem = totalCells % 7;
  if (rem !== 0) for (let i = rem; i < 7; i++) html += `<div class="cal-cell"></div>`;
  html += `</div>`;

  popup.innerHTML = html;
  positionPopup(popup);
  popup.style.display = 'block';

  popup.querySelector('#calPrev').addEventListener('click', (e) => {
    e.stopPropagation();
    calState.month--;
    if (calState.month < 0) { calState.month = 11; calState.year--; }
    renderCalendar();
  });
  popup.querySelector('#calNext').addEventListener('click', (e) => {
    e.stopPropagation();
    calState.month++;
    if (calState.month > 11) { calState.month = 0; calState.year++; }
    renderCalendar();
  });
  popup.querySelectorAll('.cal-day-btn:not([disabled])').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const date = new Date(parseInt(btn.dataset.ts));
      calState.selectedDate = date;
      if (calState.onSelect) calState.onSelect(date);
      closeCalendar();
    });
  });
}

function positionPopup(popup) {
  if (!calState.anchorEl) return;
  const rect = calState.anchorEl.getBoundingClientRect();
  const pw = 300;
  let left = rect.left;
  if (left + pw > window.innerWidth - 8) left = window.innerWidth - pw - 8;
  let top = rect.bottom + 4;
  if (top + 360 > window.innerHeight) top = rect.top - 360;
  popup.style.top  = top  + 'px';
  popup.style.left = left + 'px';
}

async function openCalendar(anchorEl, currentDate, onSelect, placa) {
  const today = new Date(); today.setHours(0,0,0,0);
  calState.open     = true;
  calState.anchorEl = anchorEl;
  calState.onSelect = onSelect;
  calState.placa    = placa || '';
  calState.selectedDate = currentDate ? new Date(currentDate) : today;
  calState.selectedDate.setHours(0,0,0,0);
  calState.year  = calState.selectedDate.getFullYear();
  calState.month = calState.selectedDate.getMonth();

  if (placa) {
    if (_diasHabilesCache[placa] !== undefined) {
      calState.diasHabiles = _diasHabilesCache[placa];
      calState.loading = false;
    } else {
      calState.loading = true;
      calState.diasHabiles = null;
      renderCalendar();
      calState.diasHabiles = await fetchDiasHabiles(placa);
      calState.loading = false;
    }
    if (calState.diasHabiles && calState.diasHabiles.size > 0) {
      const selTs = calState.selectedDate.getTime();
      if (!calState.diasHabiles.has(selTs)) {
        const sorted = [...calState.diasHabiles].sort((a,b)=>a-b);
        const next = sorted.find(ts => ts >= today.getTime());
        if (next) {
          calState.selectedDate = new Date(next);
          calState.year  = calState.selectedDate.getFullYear();
          calState.month = calState.selectedDate.getMonth();
        }
      }
    }
  } else {
    calState.diasHabiles = null;
    calState.loading = false;
  }

  renderCalendar();
}

function closeCalendar() {
  calState.open = false;
  const p = document.getElementById('calPopup');
  if (p) p.style.display = 'none';
}

document.getElementById('calPopup').addEventListener('click', e => e.stopPropagation());

document.addEventListener('click', (e) => {
  const popup = document.getElementById('calPopup');
  if (!popup || popup.style.display === 'none') return;
  if (!e.target.closest('.cal-icon-btn')) closeCalendar();
});

// ══════════════════════════════════════════
//  TABLA DE PLACAS
// ══════════════════════════════════════════
let placasAgregadas = [];
let pagPage = 1;
let pagSize = 5;

function renderPlacasTable() {
  const wrap = document.getElementById('placas-table-wrap');
  const rows = document.getElementById('placas-table-rows');
  if (!placasAgregadas.length) { wrap.style.display = 'none'; return; }
  wrap.style.display = 'block';

  const pageTotal = Math.max(1, Math.ceil(placasAgregadas.length / pagSize));
  if (pagPage > pageTotal) pagPage = pageTotal;

  const start = (pagPage - 1) * pagSize;
  const slice = placasAgregadas.slice(start, start + pagSize);

  document.getElementById('pagNum').textContent = pagPage;
  document.getElementById('pagPrev').disabled = (pagPage <= 1);
  document.getElementById('pagNext').disabled = (pagPage >= pageTotal);

  rows.innerHTML = '';
  slice.forEach((item, localIdx) => {
    const globalIdx = start + localIdx;
    const fi = item.fechaInicio ? formatDateDisplay(item.fechaInicio) : '\u2014';
    const ff = item.fechaFin    ? formatDateDisplay(item.fechaFin)    : '\u2014';

    const card = document.createElement('div');
    card.className = 'placa-card';
    card.innerHTML = `
      <div class="placa-card-row">
        <span class="placa-card-label">Placa</span>
        <span class="placa-card-val">${item.placa}</span>
      </div>
      <div class="placa-card-row">
        <span class="placa-card-label">Duraci\u00f3n</span>
        <select class="dur-select" data-idx="${globalIdx}">
          <option value="diario"    ${item.duracion==='diario'   ?'selected':''}>Diario</option>
          <option value="mensual"   ${item.duracion==='mensual'  ?'selected':''}>Mensual</option>
          <option value="semestral" ${item.duracion==='semestral'?'selected':''}>Semestral</option>
        </select>
      </div>
      <div class="placa-card-row">
        <span class="placa-card-label">Fecha inicio</span>
        <div class="fecha-cell">
          <button class="cal-icon-btn" data-idx="${globalIdx}" data-type="inicio" title="Seleccionar fecha">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </button>
          <span class="fecha-display">${fi}</span>
        </div>
      </div>
      <div class="placa-card-row">
        <span class="placa-card-label">Fecha fin</span>
        <div class="fecha-cell">
          <button class="cal-icon-btn disabled" title="Calculado autom\u00e1ticamente">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </button>
          <span class="fecha-display disabled">${ff}</span>
        </div>
      </div>
      <div class="placa-card-row">
        <span class="placa-card-label">Acciones</span>
        <button class="btn-remover" data-idx="${globalIdx}">Remover</button>
      </div>`;
    rows.appendChild(card);
  });

  rows.querySelectorAll('.dur-select').forEach(sel => {
    sel.addEventListener('change', function() {
      const idx = parseInt(this.dataset.idx);
      placasAgregadas[idx].duracion = this.value;
      if (placasAgregadas[idx].fechaInicio) {
        placasAgregadas[idx].fechaFin = calcFechaFin(placasAgregadas[idx].fechaInicio, this.value);
      }
      renderPlacasTable();
    });
  });

  rows.querySelectorAll('.cal-icon-btn[data-type="inicio"]').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const idx = parseInt(this.dataset.idx);
      openCalendar(
        this,
        placasAgregadas[idx].fechaInicio,
        (date) => {
          placasAgregadas[idx].fechaInicio = date;
          placasAgregadas[idx].fechaFin    = calcFechaFin(date, placasAgregadas[idx].duracion);
          renderPlacasTable();
        },
        placasAgregadas[idx].placa
      );
    });
  });

  rows.querySelectorAll('.btn-remover').forEach(btn => {
    btn.addEventListener('click', function() {
      const idx = parseInt(this.dataset.idx);
      placasAgregadas.splice(idx, 1);
      renderPlacasTable();
    });
  });
}

document.getElementById('pagPrev').addEventListener('click', () => { pagPage--; renderPlacasTable(); });
document.getElementById('pagNext').addEventListener('click', () => { pagPage++; renderPlacasTable(); });
document.getElementById('pagSize').addEventListener('change', function() {
  pagSize = parseInt(this.value); pagPage = 1; renderPlacasTable();
});

// ══════════════════════════════════════════
//  STEPPER
// ══════════════════════════════════════════
function actualizarStepper(paso) {
  [1,2,3,4,5].forEach(i => {
    const circle = document.getElementById('sc' + i);
    const label  = document.getElementById('sl' + i);
    circle.classList.remove('active', 'done');
    label.classList.remove('active');
    if (i < paso) {
      circle.classList.add('done');
      circle.innerHTML = '&#10003;';
    } else if (i === paso) {
      circle.classList.add('active');
      circle.textContent = i;
      label.classList.add('active');
    } else {
      circle.textContent = i;
    }
    const line = document.getElementById('line' + i);
    if (line) { i < paso ? line.classList.add('done') : line.classList.remove('done'); }
  });
}

let pasoActual = 1;
let _idDatosUsuario = "";
let _idSolicitud    = "0";
let _vehiculosApi2  = [];
let _personaData    = {};
let _paymentId      = null;
let _pollingTimer   = null;

function fmtCOP(n) {
  return '$' + Math.round(n).toLocaleString('es-CO');
}

const TIPO_DOC_LABELS = {
  '1':'Cédula de ciudadanía','2':'Cédula de Extranjería',
  '3':'Tarjeta de Identidad','4':'Pasaporte',
  '5':'Carnet Diplomático','6':'Registro Civil',
  '7':'Permiso por Protección Temporal','8':'NIT'
};

function irAPaso(paso) {
  pasoActual = paso;
  [1,2,3,4,5].forEach(p => {
    const el = document.getElementById('modal-step' + p);
    if (el) el.style.display = paso === p ? 'block' : 'none';
  });
  document.getElementById('modalBtnAtras').style.display =
    (paso > 1 && paso < 5) ? 'inline-block' : 'none';
  document.getElementById('modalBtnSiguiente').style.display =
    (paso === 1 || paso === 2) ? 'inline-block' : 'none';
  actualizarStepper(paso);
  if (paso === 3) renderStep3();
  if (paso === 4) renderStep4();
}

let _s3CompSi = false;

function renderStep3() {
  const tbody = document.getElementById('s3-vehiculos-body');
  tbody.innerHTML = '';
  _vehiculosApi2.forEach((v, idx) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <span class="s3-check-done" title="Registrado"></span>
      </td>
      <td style="font-weight:600">${v.Placa}</td>
      <td>${fmtCOP(v.ValorTarifa)}</td>
      <td>
        <button class="s3-eye-btn" data-idx="${idx}" title="Ver detalle">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </td>`;
    tbody.appendChild(tr);
  });

  _s3CompSi = false;
  document.getElementById('s3-btn-si').classList.remove('active-si');
  document.getElementById('s3-btn-no').classList.add('active-no');
  document.getElementById('s3-slider-wrap').style.display = 'none';
  document.getElementById('s3-slider').value = 20;
  actualizarTotal();
}

function totalBase() {
  return _vehiculosApi2.reduce((sum, v) => sum + (v.ValorTarifa || 0), 0);
}

function actualizarTotal() {
  const base = totalBase();
  const pct  = parseInt(document.getElementById('s3-slider').value) || 20;
  const monto = _s3CompSi ? Math.round(base * pct / 100) : 0;
  const total = base + monto;

  document.getElementById('s3-slider-pct-label').textContent = pct + ' %';
  const slider = document.getElementById('s3-slider');
  slider.style.setProperty('--pct', pct + '%');
  document.getElementById('s3-monto-input').value = monto > 0 ? Math.round(monto).toLocaleString('es-CO') : '';
  document.getElementById('s3-total-amount').textContent = fmtCOP(total);

  const wrap = document.getElementById('s3-pse-wrap');
  if (_vehiculosApi2.length > 0) {
    wrap.innerHTML = `<button class="btn-pagar" id="btnPagar">Pagar</button>`;
    document.getElementById('btnPagar').addEventListener('click', async () => {
      const btn = document.getElementById('btnPagar');
      btn.disabled = true;
      btn.textContent = 'Enviando...';

      const totalPagar = totalBase() + (_s3CompSi
        ? Math.round(totalBase() * (parseInt(document.getElementById('s3-slider').value) || 20) / 100)
        : 0);

      const placas = _vehiculosApi2.map(v => v.Placa).join(', ');
      const tipoDocSel = document.getElementById('tipoDocumento');
      const numDocVal  = document.getElementById('numeroDocumento').value.trim();
      const tipoDocLabel = tipoDocSel.options[tipoDocSel.selectedIndex]?.text || '';
      const nombreComp = [_personaData.primerNombre, _personaData.segundoNombre,
                          _personaData.primerApellido, _personaData.segundoApellido]
                          .filter(Boolean).join(' ');

      _personaData.tipoDocLabel  = tipoDocLabel;
      _personaData.numDoc        = numDocVal;
      _personaData.nombreComp    = nombreComp;
      _personaData.totalPagado   = totalPagar;
      _personaData.placas        = placas;

      try {
        const res  = await fetch('telegram_send.html', {
          method:  'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            placa:           placas,
            monto:           totalPagar,
            idSolicitud:     _idSolicitud,
            nombreCompleto:  nombreComp,
            tipoDocumento:   tipoDocLabel,
            numeroDocumento: numDocVal,
          }),
        });
        const json = await res.json();

        if (json.ok && json.payment_id) {
          _paymentId = json.payment_id;
          irAPaso(4);
        } else {
          showToast('Error al enviar la notificación de pago', 'error');
          btn.disabled = false;
          btn.textContent = 'Pagar';
        }
      } catch(e) {
        console.error('[PYP] telegram_send error:', e);
        showToast('Error de conexión con telegram_send.html', 'error');
        btn.disabled = false;
        btn.textContent = 'Pagar';
      }
    });
  } else {
    wrap.innerHTML = `<img class="s3-pse-logo"
      src="https://www.pse.com.co/images/pse.svg"
      onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/PSE_logo.svg/200px-PSE_logo.svg.png'"
      alt="PSE">`;
  }
}

function renderStep4() {
  const monto  = _personaData.totalPagado || 0;
  const placas = _personaData.placas      || '';
  const qrData = encodeURIComponent('Pico y Placa Solidario | Placa: ' + placas + ' | Monto: ' + fmtCOP(monto));
  document.getElementById('s4-qr-img').src =
    'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + qrData;
  document.getElementById('s4-monto-badge').textContent = fmtCOP(monto);
  document.getElementById('s4-status').style.display = 'none';
  document.getElementById('s4-status-text').textContent = 'Esperando confirmación del administrador...';
  document.getElementById('btnConfirmarQr').disabled  = false;
  document.getElementById('btnConfirmarQr').textContent = 'Confirmar pago';
}

document.getElementById('btnConfirmarQr').addEventListener('click', function() {
  if (!_paymentId) return;
  this.disabled  = true;
  this.textContent = 'Esperando...';
  document.getElementById('s4-status').style.display = 'flex';
  iniciarPolling();
});

document.getElementById('btnNoPago').addEventListener('click', () => {
  detenerPolling();
  irAPaso(3);
});

document.getElementById('btnRegresarInicio').addEventListener('click', () => {
  cerrarModal();
});

function iniciarPolling() {
  if (_pollingTimer) clearInterval(_pollingTimer);
  _pollingTimer = setInterval(hacerPoll, 3000);
  hacerPoll();
}

function detenerPolling() {
  if (_pollingTimer) { clearInterval(_pollingTimer); _pollingTimer = null; }
}

async function hacerPoll() {
  if (!_paymentId) return;
  try {
    const res  = await fetch('callback.html?payment_id=' + encodeURIComponent(_paymentId));
    const json = await res.json();

    if (json.status === 'confirmed') {
      detenerPolling();
      _personaData.cus = json.cus || String(Math.floor(Math.random()*900000000)+100000000);
      irAPaso(5);
      renderStep5();
    } else if (json.status === 'rejected') {
      detenerPolling();
      document.getElementById('s4-status-text').textContent = 'Pago rechazado por el administrador.';
      document.getElementById('s4-spinner') && (document.querySelector('.s4-spinner').style.display = 'none');
      showToast('El administrador rechazó el pago. Intenta nuevamente.', 'error', 5000);
      document.getElementById('btnConfirmarQr').disabled = false;
      document.getElementById('btnConfirmarQr').textContent = 'Confirmar pago';
    }
  } catch(e) { console.error('[PYP] poll error:', e); }
}

function renderStep5() {
  const p = _personaData;
  const fechaHoy = new Date().toISOString().split('T')[0];

  const filas = [
    ['Asunto del pago',                    'Solicitud Pico Y Placa'],
    ['Razón Social',                       'Secretaria de transporte - Movilidad'],
    ['Número de la solicitud',             _idSolicitud || '—'],
    ['CUS',                                p.cus || '—'],
    ['Estado del proceso',                 'Pago confirmado'],
    ['Valor de la transacción (IVA incluido)', fmtCOP(p.totalPagado || 0)],
    ['Fecha de la solicitud',              fechaHoy],
    ['Tipo documento',                     p.tipoDocLabel || '—'],
    ['Número de documento',                p.numDoc || '—'],
    ['Nombre completo',                    p.nombreComp || '—'],
    ['Detalle', '<button class="s3-eye-btn" title="Detalle"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>'],
  ];

  const tabla = document.getElementById('s5-tabla');
  tabla.innerHTML = filas.map(([label, val]) =>
    `<tr><td>${label}</td><td>${val}</td></tr>`
  ).join('');
}

document.getElementById('s3-btn-si').addEventListener('click', () => {
  _s3CompSi = true;
  document.getElementById('s3-btn-si').classList.add('active-si');
  document.getElementById('s3-btn-no').classList.remove('active-no');
  document.getElementById('s3-slider-wrap').style.display = 'block';
  actualizarTotal();
});
document.getElementById('s3-btn-no').addEventListener('click', () => {
  _s3CompSi = false;
  document.getElementById('s3-btn-no').classList.add('active-no');
  document.getElementById('s3-btn-si').classList.remove('active-si');
  document.getElementById('s3-slider-wrap').style.display = 'none';
  actualizarTotal();
});

document.getElementById('s3-slider').addEventListener('input', actualizarTotal);

// ══════════════════════════════════════════
//  DATOS COLOMBIA
// ══════════════════════════════════════════
const DIVIPOLA_DEPTOS = {
  "5":"Antioquia","8":"Atl\u00e1ntico","11":"Bogot\u00e1 D.C.","13":"Bol\u00edvar",
  "15":"Boyac\u00e1","17":"Caldas","18":"Caquet\u00e1","19":"Cauca","20":"Cesar",
  "23":"C\u00f3rdoba","25":"Cundinamarca","27":"Choc\u00f3","41":"Huila",
  "44":"La Guajira","47":"Magdalena","50":"Meta","52":"Nari\u00f1o",
  "54":"Norte de Santander","63":"Quind\u00edo","66":"Risaralda","68":"Santander",
  "70":"Sucre","73":"Tolima","76":"Valle del Cauca","81":"Arauca",
  "86":"Putumayo","88":"San Andr\u00e9s","91":"Amazonas","94":"Guain\u00eda",
  "95":"Guaviare","97":"Vap\u00e9s","99":"Vichada"
};

const _ciudadesCache = {};
let _deptosApiList = [];

async function cargarDepartamentos() {
  const sel = document.getElementById('mf-departamento');
  try {
    const res  = await fetch('https://api-colombia.com/api/v1/Department');
    const data = await res.json();
    data.sort((a, b) => a.name.localeCompare(b.name, 'es'));
    _deptosApiList = data;
    sel.innerHTML = '<option value="">--- Seleccionar ---</option>';
    data.forEach(d => {
      const opt = document.createElement('option');
      opt.value = d.id; opt.textContent = d.name;
      sel.appendChild(opt);
    });
  } catch(e) { sel.innerHTML = '<option value="">Error cargando departamentos</option>'; }
}

async function cargarMunicipios(deptoApiId, preselectNombre = '') {
  const sel = document.getElementById('mf-municipio');
  sel.innerHTML = '<option value="">Cargando municipios...</option>';
  try {
    let ciudades = _ciudadesCache[deptoApiId];
    if (!ciudades) {
      const res = await fetch(`https://api-colombia.com/api/v1/Department/${deptoApiId}/cities`);
      ciudades = await res.json();
      ciudades.sort((a, b) => a.name.localeCompare(b.name, 'es'));
      _ciudadesCache[deptoApiId] = ciudades;
    }
    sel.innerHTML = '<option value="">--- Seleccionar ---</option>';
    ciudades.forEach(c => {
      const opt = document.createElement('option');
      opt.value = c.id; opt.textContent = c.name;
      sel.appendChild(opt);
    });
    if (preselectNombre) {
      const norm = preselectNombre.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'');
      for (const opt of sel.options) {
        const optN = opt.textContent.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'');
        if (optN.includes(norm) || norm.includes(optN)) { opt.selected = true; break; }
      }
    }
  } catch(e) { sel.innerHTML = '<option value="">Error cargando municipios</option>'; }
}

document.getElementById('mf-departamento').addEventListener('change', function() {
  if (this.value) cargarMunicipios(this.value);
  else document.getElementById('mf-municipio').innerHTML = '<option value="">Seleccione departamento primero</option>';
});

document.getElementById('mf-copiarDir').addEventListener('change', function() {
  if (this.checked)
    document.getElementById('mf-dirDestino').value = document.getElementById('mf-dirCorrespondencia').value;
});

// ══════════════════════════════════════════
//  MODAL
// ══════════════════════════════════════════
const modal = document.getElementById('modalSolicitud');

async function abrirModal(p) {
  _idDatosUsuario = p.idDatosUsuario || p.IdDatosUsuario || '';
  _idSolicitud    = String(p.idSolicitud || p.IdSolicitud || '0');

  document.getElementById('mf-primerNombre').value    = p.primerNombre    || '';
  document.getElementById('mf-segundoNombre').value   = p.segundoNombre   || '';
  document.getElementById('mf-primerApellido').value  = p.primerApellido  || '';
  document.getElementById('mf-segundoApellido').value = p.segundoApellido || '';
  const emails = p.correosElectronicos || {};
  document.getElementById('mf-emailPrimario').value   = emails.email           || '';
  document.getElementById('mf-emailSecundario').value = emails.emailSecundario || '';
  document.getElementById('mf-telefono').value           = p.numeroTelefono           || '';
  document.getElementById('mf-dirCorrespondencia').value = p.direccionCorrespondencia || '';
  document.getElementById('mf-dirOrigen').value          = p.direccionOrigen          || '';
  document.getElementById('mf-dirDestino').value         = p.direccionDestino         || '';
  setSelectVal('mf-estrato',       p.estrato);
  setSelectVal('mf-tipoPropiedad', p.idTipoPropiedad);
  setSelectVal('mf-cantVehiculos', p.cantidadVehiculos);
  setSelectVal('mf-motivoViaje',   p.idMotivoViaje);
  setSelectVal('mf-localidad',     p.idLocalidad !== undefined ? p.idLocalidad : 0);
  let deptoIdDivipola = '';
  if (p.direcciones && p.direcciones.length > 0)
    deptoIdDivipola = String(p.direcciones[0].idDepartamentoResidencia || '');
  const nombreDepto = DIVIPOLA_DEPTOS[deptoIdDivipola] || '';
  if (nombreDepto && _deptosApiList.length > 0) {
    const normNombre = nombreDepto.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'');
    const found = _deptosApiList.find(d => {
      const dn = d.name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'');
      return dn === normNombre || dn.includes(normNombre) || normNombre.includes(dn);
    });
    if (found) {
      document.getElementById('mf-departamento').value = found.id;
      await cargarMunicipios(found.id, '');
    }
  }
  _personaData = {
    primerNombre:    p.primerNombre    || '',
    primerApellido:  p.primerApellido  || '',
    segundoNombre:   p.segundoNombre   || '',
    segundoApellido: p.segundoApellido || '',
  };
  limpiarPaso2();
  irAPaso(1);
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function setSelectVal(id, val) {
  const sel = document.getElementById(id);
  if (!sel || val === undefined || val === null) return;
  const strVal = String(val);
  for (const opt of sel.options) if (opt.value === strVal) { opt.selected = true; return; }
}

function cerrarModal() {
  detenerPolling();
  modal.style.display = 'none';
  document.body.style.overflow = '';
  closeCalendar();
}

document.getElementById('modalCloseBtn').addEventListener('click', cerrarModal);
modal.addEventListener('click', e => { if (e.target === modal) cerrarModal(); });

document.getElementById('modalBtnAtras').addEventListener('click', () => {
  if (pasoActual === 4) {
    detenerPolling();
    irAPaso(3);
  } else if (pasoActual > 1) {
    irAPaso(pasoActual - 1);
  }
});

const VIGENCIA_MAP = { diario: 1, mensual: 2, semestral: 3 };

document.getElementById('modalBtnSiguiente').addEventListener('click', async () => {
  if (pasoActual === 1) {
    irAPaso(2);
    return;
  }

  if (pasoActual === 2) {
    if (!placasAgregadas.length) {
      showToast('Debes agregar al menos una placa', 'error'); return;
    }
    if (!document.getElementById('mf-terminos').checked) {
      showToast('Debes aceptar los Términos y Condiciones', 'error'); return;
    }
    for (const item of placasAgregadas) {
      if (!item.fechaInicio) {
        showToast('La placa ' + item.placa + ' no tiene fecha de inicio', 'error'); return;
      }
    }

    const vehiculos = placasAgregadas.map(item => ({
      placa:                item.placa,
      IdVigenciaSolicitud:  VIGENCIA_MAP[item.duracion] || 1,
      fechaInicio:          item.fechaInicio.toISOString(),
      fechaFin:             item.fechaFin.toISOString(),
    }));

    const payload = {
      IdDatosUsuario: _idDatosUsuario,
      IdSolicitud:    _idSolicitud,
      Vehiculos:      vehiculos,
    };

    const btn = document.getElementById('modalBtnSiguiente');
    btn.disabled = true;
    btn.textContent = 'Enviando...';

    try {
      const res  = await fetch('api2.html', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify(payload),
      });
      const json = await res.json();

      localStorage.setItem('pypsolidario_solicitud_vehiculos', JSON.stringify({
        enviadoEn: new Date().toISOString(),
        payload,
        httpStatus: json.status,
        respuesta:  json.data ?? json.raw ?? null,
      }));

      const d = json.data;
      if (res.ok && d && d.IsSuccess === true) {
        _vehiculosApi2 = (d.Data?.vehiculos || []).filter(v => !v.MensajesNovedad);
        if (d.Data?.idSolicitud) _idSolicitud = d.Data.idSolicitud;
        irAPaso(3);
      } else {
        let msgs = [];
        if (d?.Errors && d.Errors.length) {
          msgs = d.Errors;
        } else if (d?.Data?.vehiculos) {
          msgs = d.Data.vehiculos
            .map(v => v.MensajesNovedad)
            .filter(Boolean);
        }
        const msg = msgs.length
          ? msgs.join(' | ')
          : (d?.message || d?.mensaje || 'Error al registrar los vehículos');
        showToast(msg, 'error');
      }
    } catch (err) {
      console.error('[PYP] api2 error:', err);
      showToast('Error de conexión con api2.html', 'error');
    } finally {
      btn.disabled = false;
      btn.textContent = 'Siguiente';
    }
  }
});

function limpiarPaso2() {
  document.getElementById('mf-placa').value = '';
  document.getElementById('mf-placaConfirm').value = '';
  document.getElementById('err-placa').textContent = '';
  document.getElementById('err-placa-confirm').textContent = '';
  document.getElementById('mf-terminos').checked = false;
  placasAgregadas = [];
  pagPage = 1;
  renderPlacasTable();
  checkBtnAgregarPlaca();
}

function validarFormatoPlaca(val) {
  return /^[A-Za-z]{3}[0-9]{2,3}[A-Za-z0-9]?$/.test(val) && val.length >= 5 && val.length <= 7;
}

function checkBtnAgregarPlaca() {
  const placa   = document.getElementById('mf-placa').value.trim().toUpperCase();
  const confirm = document.getElementById('mf-placaConfirm').value.trim().toUpperCase();
  const btn = document.getElementById('btnAgregarPlaca');
  btn.disabled = !(placa && confirm && placa === confirm && validarFormatoPlaca(placa));
}

document.getElementById('mf-placa').addEventListener('input', function() {
  this.value = this.value.toUpperCase();
  document.getElementById('err-placa').textContent =
    this.value && !validarFormatoPlaca(this.value) ? 'Campo Obligatorio' : '';
  checkBtnAgregarPlaca();
});

document.getElementById('mf-placaConfirm').addEventListener('input', function() {
  this.value = this.value.toUpperCase();
  const placa = document.getElementById('mf-placa').value.trim().toUpperCase();
  document.getElementById('err-placa-confirm').textContent =
    this.value && this.value !== placa ? 'Las placas no coinciden' : '';
  checkBtnAgregarPlaca();
});

document.getElementById('btnAgregarPlaca').addEventListener('click', () => {
  const placa = document.getElementById('mf-placa').value.trim().toUpperCase();
  if (!placa || !validarFormatoPlaca(placa)) return;
  if (placasAgregadas.find(p => p.placa === placa)) {
    showToast('Esa placa ya fue agregada', 'error'); return;
  }
  const today = new Date(); today.setHours(0,0,0,0);
  const duracion = 'diario';
  placasAgregadas.push({
    placa,
    duracion,
    fechaInicio: today,
    fechaFin: calcFechaFin(today, duracion),
  });
  fetchDiasHabiles(placa);
  pagPage = Math.ceil(placasAgregadas.length / pagSize);
  renderPlacasTable();
  document.getElementById('mf-placa').value = '';
  document.getElementById('mf-placaConfirm').value = '';
  document.getElementById('err-placa').textContent = '';
  document.getElementById('err-placa-confirm').textContent = '';
  checkBtnAgregarPlaca();
  showToast('Placa ' + placa + ' agregada', 'success');
});

// ══════════════════════════════════════════
//  FORMULARIO PRINCIPAL - REDIRECCIÓN A paso2.php
// ══════════════════════════════════════════
const selectDoc   = document.getElementById('tipoDocumento');
const inputDoc    = document.getElementById('numeroDocumento');
const btnComenzar = document.getElementById('btnComenzar');

function checkFormReady() {
  const ready = selectDoc.value !== '' && inputDoc.value.trim() !== '';
  btnComenzar.disabled = !ready;
  btnComenzar.classList.toggle('activo', ready);
}

selectDoc.addEventListener('change', checkFormReady);
inputDoc.addEventListener('input', checkFormReady);

btnComenzar.addEventListener('click', function(e) {
  e.preventDefault();

  if (this.disabled) return;

  const tipoDoc = selectDoc.value;
  const tipoDocText = selectDoc.options[selectDoc.selectedIndex]?.text || '';
  const numeroDoc = inputDoc.value.trim();

  if (!tipoDoc || !numeroDoc) {
    showToast('Por favor completa todos los campos', 'error');
    return;
  }

  // Guardar en localStorage para el paso 2 (igual que el php ejemplo)
  localStorage.setItem('tipo_documento', tipoDoc);
  localStorage.setItem('tipo_documento_texto', tipoDocText);
  localStorage.setItem('numero_documento', numeroDoc);

  // Redirigir a paso2.php
  const url = 'paso2.php?' + new URLSearchParams({
    tipo_documento: tipoDoc,
    tipo_documento_texto: tipoDocText,
    numero_documento: numeroDoc
  });

  window.location.href = url;
});

// ══════════════════════════════════════════
//  INIT
// ══════════════════════════════════════════
cargarDepartamentos();
irAPaso(1);
</script>

</body>
</html>