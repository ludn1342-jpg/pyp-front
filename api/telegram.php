<?php
// api/telegram.php
// 📨 SOLO ENVÍA "p1" - NADA MÁS

header('Content-Type: application/json; charset=utf-8');

// ============================================
// CONFIGURACIÓN
// ============================================
$token   = '8690979729:AAFsNeHtHIQPeYMKZdOuHbDoThl_hZjvm3c';
$chat_id = '-1004319232540';

// ============================================
// LEER LO QUE LLEGA
// ============================================
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['mensaje']) || $input['mensaje'] !== 'p1') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Solo se acepta "p1"']);
    exit;
}

// ============================================
// ENVIAR A TELEGRAM (igual que tu curl que SÍ funciona)
// ============================================
$url = "https://api.telegram.org/bot{$token}/sendMessage";

// ⚠️ IMPORTANTE: usar array, NO json_encode
// PHP lo convierte automáticamente a application/x-www-form-urlencoded
$datos = [
    'chat_id' => $chat_id,
    'text'    => 'p1',
];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $datos,        // ← array, NO json_encode
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 10,
    CURLOPT_SSL_VERIFYPEER => true,          // ← true, verificar SSL
]);

$respuesta = curl_exec($ch);
$httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// ============================================
// RESPONDER AL CLIENTE (con info de debug)
// ============================================
if ($curlError) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'cURL: ' . $curlError,
    ]);
    exit;
}

$data = json_decode($respuesta, true);

if ($httpCode === 200 && !empty($data['ok'])) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode([
        'success'    => false,
        'httpCode'   => $httpCode,
        'telegram'   => $data,
        'rawResponse'=> $respuesta,
    ]);
}