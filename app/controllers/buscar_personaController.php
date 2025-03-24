<?php
header("Content-Type: application/json; charset=UTF-8");

// Verifica si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "titulo" => "Error",
        "mensaje" => "Método no permitido. Usa POST.",
        "icono" => "error"
    ]);
    exit();
}

// Captura los datos enviados en el cuerpo de la solicitud
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['num_identificacion']) || empty($input['num_identificacion'])) {
    echo json_encode([
        "titulo" => "Error",
        "mensaje" => "El número de cédula es obligatorio.",
        "icono" => "error"
    ]);
    exit();
}