<?php
$transaccionesArchivo = "transacciones.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filtro = $_POST["filtro"];
    $transacciones = file_exists($transaccionesArchivo) ? json_decode(file_get_contents($transaccionesArchivo), true) : [];

    $filtradas = array_filter($transacciones, function($transaccion) use ($filtro) {
        return stripos($transaccion["categoria"], $filtro) !== false;
    });

    $csv = fopen("exportacion.csv", "w");
    fputcsv($csv, ["Fecha", "Monto", "Categoría", "Descripción"]);
    foreach ($filtradas as $transaccion) {
        fputcsv($csv, $transaccion);
    }
    fclose($csv);

    header("Content-Type: application/csv");
    header("Content-Disposition: attachment; filename=exportacion.csv");
    readfile("exportacion.csv");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exportar Transacciones</title>
</head>
<body>
    <h1>Exportar Transacciones</h1>
    <form method="post">
        <label for="filtro">Filtrar por Categoría:</label>
        <input type="text" name="filtro" required>
        <button type="submit">Exportar</button>
    </form>
</body>
</html>
