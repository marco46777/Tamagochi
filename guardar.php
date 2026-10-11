<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'success' => false,
        'error' => 'Método no permitido'
    ]);

    exit;
}

$contenido = file_get_contents('php://input');
$datos = json_decode($contenido, true);

if (!is_array($datos)) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error' => 'Datos inválidos'
    ]);

    exit;
}

if (!isset($_SESSION['michi'])) {
    $_SESSION['michi'] = [
        'nombre' => 'Michi',
        'hambre' => 70,
        'higiene' => 70,
        'felicidad' => 70,
        'energia' => 70,
        'monedas' => 0
    ];
}

$mascota = $_SESSION['michi'];

// Guardar nombre
if (isset($datos['nombre'])) {
    $nombre = trim((string)$datos['nombre']);

    if ($nombre === '' || strlen($nombre) > 80) {
        http_response_code(422);

        echo json_encode([
            'success' => false,
            'error' => 'Nombre inválido'
        ]);

        exit;
    }

    $mascota['nombre'] = $nombre;
}

// Guardar estadísticas
$estados = [
    'hambre',
    'higiene',
    'felicidad',
    'energia'
];

foreach ($estados as $estado) {
    if (isset($datos[$estado]) && is_numeric($datos[$estado])) {
        $mascota[$estado] = max(
            0,
            min(100, (int)$datos[$estado])
        );
    }
}

// Guardar monedas
if (isset($datos['monedas']) && is_numeric($datos['monedas'])) {
    $mascota['monedas'] = max(0, (int)$datos['monedas']);
}

// Actualizar sesión
$_SESSION['michi'] = $mascota;

// Respuesta para JavaScript
echo json_encode([
    'success' => true,
    'mensaje' => 'Mascota guardada correctamente',
    'mascota' => $mascota
], JSON_UNESCAPED_UNICODE);

exit;