<?php
/**
 * guardar_sesion.php
 * Guarda los datos del formulario en sesión
 */

// Iniciar sesión
session_start();

// Validar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Guardar todos los datos del formulario en la sesión
    $_SESSION['formulario_registro'] = [
        'primerNombre' => isset($_POST['primerNombre']) ? trim($_POST['primerNombre']) : '',
        'segundoNombre' => isset($_POST['segundoNombre']) ? trim($_POST['segundoNombre']) : '',
        'primerApellido' => isset($_POST['primerApellido']) ? trim($_POST['primerApellido']) : '',
        'segundoApellido' => isset($_POST['segundoApellido']) ? trim($_POST['segundoApellido']) : '',
        'emailPrimario' => isset($_POST['emailPrimario']) ? trim($_POST['emailPrimario']) : '',
        'emailSecundario' => isset($_POST['emailSecundario']) ? trim($_POST['emailSecundario']) : '',
        'departamento' => isset($_POST['departamento']) ? trim($_POST['departamento']) : '',
        'municipio' => isset($_POST['municipio']) ? trim($_POST['municipio']) : '',
        'localidad' => isset($_POST['localidad']) ? trim($_POST['localidad']) : '',
        'dirCorrespondencia' => isset($_POST['dirCorrespondencia']) ? trim($_POST['dirCorrespondencia']) : '',
        'telefono' => isset($_POST['telefono']) ? trim($_POST['telefono']) : '',
        'dirOrigen' => isset($_POST['dirOrigen']) ? trim($_POST['dirOrigen']) : '',
        'dirDestino' => isset($_POST['dirDestino']) ? trim($_POST['dirDestino']) : '',
        'estrato' => isset($_POST['estrato']) ? trim($_POST['estrato']) : '',
        'tipoPropiedad' => isset($_POST['tipoPropiedad']) ? trim($_POST['tipoPropiedad']) : '',
        'cantVehiculos' => isset($_POST['cantVehiculos']) ? trim($_POST['cantVehiculos']) : '',
        'motivoViaje' => isset($_POST['motivoViaje']) ? trim($_POST['motivoViaje']) : '',
        'copiarDir' => isset($_POST['copiarDir']) ? 1 : 0
    ];

    // Marcar que el usuario completó el paso 1
    $_SESSION['paso_completado'] = 1;

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Datos guardados correctamente',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar: ' . $e->getMessage()
    ]);
    exit;
}
?>