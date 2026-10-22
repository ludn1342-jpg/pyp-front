<?php
// api/heartbeat.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 🔥 Cargar ban_manager y bloquear IPs baneadas
require_once __DIR__ . '/../panel/config/ban_manager.php';
ban_init('json403');

$dataDir = __DIR__ . '/../data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

$file = $dataDir . '/online.json';

// Leer estado actual
$online = [];
if (file_exists($file)) {
    $online = json_decode(file_get_contents($file), true) ?: [];
}

// 🔥 Limpiar sesiones inactivas (> 5 segundos)
$ahora = time();
foreach ($online as $sid => $info) {
    if ($ahora - $info['ultimo_ping'] > 5) {
        unset($online[$sid]);
    }
}

// === REGISTRAR PING ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $solicitudId = $input['solicitudId'] ?? null;
    
    if ($solicitudId) {
        $online[$solicitudId] = [
            'solicitudId' => $solicitudId,
            'ultimo_ping' => $ahora,
            'usuario' => $input['usuario'] ?? '',
            'estado' => $input['estado'] ?? 'activo'
        ];
        file_put_contents($file, json_encode($online, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true, 'online' => true]);
        exit;
    }
}

// === CONSULTAR ESTADO ===
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Si piden un ID específico
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $isOnline = isset($online[$id]) && ($ahora - $online[$id]['ultimo_ping'] <= 5);
        echo json_encode([
            'success' => true,
            'online' => $isOnline,
            'ultimo_ping' => $online[$id]['ultimo_ping'] ?? 0
        ]);
        exit;
    }
    
    // Si piden todos
    $resultado = [];
    foreach ($online as $sid => $info) {
        $resultado[$sid] = [
            'online' => ($ahora - $info['ultimo_ping'] <= 5),
            'segundos_inactivo' => $ahora - $info['ultimo_ping']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'online' => $resultado,
        'total_online' => count($resultado)
    ]);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Método no permitido']);