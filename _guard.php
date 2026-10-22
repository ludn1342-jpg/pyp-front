<?php
/**
 * _guard.php
 * Bloquea el acceso al front si la IP está baneada.
 * Devuelve 404 para que parezca página no encontrada.
 */

require_once __DIR__ . '/panel/config/ban_manager.php';

// Bloquea la IP actual si está baneada (modo 404)
ban_init('404');