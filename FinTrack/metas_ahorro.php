<?php
// Leer y guardar metas en metas.json
$archivoMetas = 'metas.json';
$metas = [];

// Leer metas existentes
if (file_exists($archivoMetas)) {
    $contenido = file_get_contents($archivoMetas);
    $metas = json_decode($contenido, true);
}

// Agregar una nueva meta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metaNueva = [
        "nombre" => $_POST['nombre_meta'],
        "monto" => floatval($_POST['monto_meta']),
        "progreso" => floatval($_POST['progreso_meta'])
    ];
    $metas[] = $metaNueva;
    file_put_contents($archivoMetas, json_encode($metas, JSON_PRETTY_PRINT));
    echo "Meta guardada exitosamente.";
}

// Mostrar metas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode($metas, JSON_PRETTY_PRINT);
}
?>
