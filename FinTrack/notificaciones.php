<?php
// Archivo JSON de notificaciones
$file = 'notificaciones.json';

// Leer notificaciones
$notificaciones = json_decode(file_get_contents($file), true);

// Mostrar notificaciones pendientes
echo "<h1>Notificaciones</h1>";
if (count($notificaciones) > 0) {
    foreach ($notificaciones as $index => $notificacion) {
        echo "<div>";
        echo "<p><strong>{$notificacion['fecha']}:</strong> {$notificacion['mensaje']}</p>";
        echo "<form method='post'>";
        echo "<button name='marcar_leida' value='{$index}'>Marcar como leída</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p>No hay notificaciones pendientes.</p>";
}

// Marcar notificación como leída
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_leida'])) {
    $index = (int)$_POST['marcar_leida'];
    unset($notificaciones[$index]);
    file_put_contents($file, json_encode(array_values($notificaciones)));
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
