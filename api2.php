<?php
// ===== CORS & Content-Type =====
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit();
}

// ===== Leer body JSON del frontend =====
$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (
    !$data ||
    !isset($data['IdDatosUsuario']) ||
    !isset($data['IdSolicitud'])    ||
    !isset($data['Vehiculos'])      ||
    !is_array($data['Vehiculos'])   ||
    count($data['Vehiculos']) === 0
) {
    http_response_code(400);
    echo json_encode(["error" => "Payload inválido. Se requieren IdDatosUsuario, IdSolicitud y Vehiculos[]"]);
    exit();
}

// ===== Construir payload hacia la API real =====
$payload = json_encode([
    "IdDatosUsuario" => $data['IdDatosUsuario'],
    "IdSolicitud"    => $data['IdSolicitud'],
    "Vehiculos"      => $data['Vehiculos'],
], JSON_UNESCAPED_UNICODE);

// ===== URL destino =====
$url = "https://apipypsolidarioprd.movilidadbogota.gov.co/fx-pyps-tarifa-sdm-prd/registro-vehiculo-solicitud";

// ===== Headers exactos de la request capturada =====
$headers = [
    "Accept: application/json, text/plain, */*",
    "Accept-Encoding: gzip, deflate, br, zstd",
    "Accept-Language: es-US,es-419;q=0.9,es;q=0.8,en;q=0.7",
    "Content-Type: application/json",
    "Content-Length: " . strlen($payload),
    "mail: ",
    "Ocp-Apim-Subscription-Key: c26d1c30ccab42b2b45d4a514bbb938c",
    "Origin: https://picoyplacasolidario.movilidadbogota.gov.co",
    "Priority: u=1, i",
    "Referer: https://picoyplacasolidario.movilidadbogota.gov.co/Inicio",
    "Sec-Ch-Ua: \"Google Chrome\";v=\"147\", \"Not.A/Brand\";v=\"8\", \"Chromium\";v=\"147\"",
    "Sec-Ch-Ua-Mobile: ?0",
    "Sec-Ch-Ua-Platform: \"Windows\"",
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-site",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36",
];

// ===== cURL request =====
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL            => $url,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => $headers,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT        => 20,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
]);

$response  = curl_exec($ch);
$httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    http_response_code(502);
    echo json_encode([
        "error"   => "Error de conexión con la API externa",
        "detalle" => $curlError
    ]);
    exit();
}

http_response_code($httpCode);

$decoded = json_decode($response, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo json_encode([
        "status" => $httpCode,
        "data"   => $decoded,
    ]);
} else {
    echo json_encode([
        "status" => $httpCode,
        "data"   => null,
        "raw"    => $response,
    ]);
}