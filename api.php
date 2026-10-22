<?php
// ===== CORS & Content-Type =====
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Pre-flight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit();
}

// ===== Leer body JSON del frontend =====
$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (!$data || !isset($data['NumeroIdentificacion']) || !isset($data['IdTipoDocumento'])) {
    http_response_code(400);
    echo json_encode(["error" => "Faltan campos requeridos: NumeroIdentificacion e IdTipoDocumento"]);
    exit();
}

$numeroIdentificacion = trim($data['NumeroIdentificacion']);
$idTipoDocumento      = trim($data['IdTipoDocumento']);

if (empty($numeroIdentificacion)) {
    http_response_code(400);
    echo json_encode(["error" => "NumeroIdentificacion no puede estar vacío"]);
    exit();
}

// ===== Payload hacia la API real =====
$payload = json_encode([
    "NumeroIdentificacion" => $numeroIdentificacion,
    "IdTipoDocumento"      => $idTipoDocumento
]);

// ===== URL destino =====
$url = "https://apipypsolidarioprd.movilidadbogota.gov.co/fx-pyps-datos-persona-sdm-prd/consulta-persona";

// ===== Headers exactos del script Python =====
// (se omiten pseudoheaders HTTP/2: :method, :path, :scheme, :authority)
$headers = [
    "Accept: application/json, text/plain, */*",
    "Accept-Encoding: gzip, deflate, br, zstd",
    "Accept-Language: es-US,es-419;q=0.9,es;q=0.8,en;q=0.7",
    "Content-Type: application/json",
    "Content-Length: " . strlen($payload),
    "Ocp-Apim-Subscription-Key: c26d1c30ccab42b2b45d4a514bbb938c",
    "Origin: https://picoyplacasolidario.movilidadbogota.gov.co",
    "Priority: u=1, i",
    "Referer: https://picoyplacasolidario.movilidadbogota.gov.co/Inicio",
    "Sec-Ch-Ua: \"Chromium\";v=\"146\", \"Not-A.Brand\";v=\"24\", \"Google Chrome\";v=\"146\"",
    "Sec-Ch-Ua-Mobile: ?1",
    "Sec-Ch-Ua-Platform: \"iOS\"",
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-site",
    "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1",
    "X-User-Token: zhadlqe8ga-mnewyx8r-l1j307eiz3"
];

// ===== cURL request =====
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL            => $url,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => $headers,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",          // acepta gzip/br automáticamente
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
]);

$response    = curl_exec($ch);
$httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError   = curl_error($ch);
curl_close($ch);

// ===== Manejo de errores cURL =====
if ($curlError) {
    http_response_code(502);
    echo json_encode([
        "error"   => "Error de conexión con la API externa",
        "detalle" => $curlError
    ]);
    exit();
}

// ===== Devolver respuesta de la API al frontend =====
http_response_code($httpCode);

// Si la respuesta ya es JSON válido, la devolvemos directo
$decoded = json_decode($response, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo json_encode([
        "status"   => $httpCode,
        "data"     => $decoded
    ]);
} else {
    // Respuesta no-JSON (texto plano, HTML de error, etc.)
    echo json_encode([
        "status"   => $httpCode,
        "data"     => null,
        "raw"      => $response
    ]);
}