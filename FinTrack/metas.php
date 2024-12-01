<?php
session_start();
$metasArchivo = "metas.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevaMeta = [
        "nombre" => $_POST["nombre_meta"],
        "monto" => $_POST["monto_meta"],
        "progreso" => $_POST["progreso_meta"],
        "plazo" => $_POST["plazo_meta"]
    ];

    $metas = file_exists($metasArchivo) ? json_decode(file_get_contents($metasArchivo), true) : [];
    $metas[] = $nuevaMeta;
    file_put_contents($metasArchivo, json_encode($metas));
}

$metas = file_exists($metasArchivo) ? json_decode(file_get_contents($metasArchivo), true) : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Metas de Ahorro</title>
</head>
<body>
    <h1>Gestión de Metas</h1>
    <form method="post">
        <label for="nombre_meta">Nombre de la Meta:</label>
        <input type="text" name="nombre_meta" required>
        <label for="monto_meta">Monto Objetivo:</label>
        <input type="number" name="monto_meta" required>
        <label for="progreso_meta">Progreso Actual:</label>
        <input type="number" name="progreso_meta" required>
        <label for="plazo_meta">Plazo (YYYY-MM-DD):</label>
        <input type="date" name="plazo_meta" required>
        <button type="submit">Guardar Meta</button>
    </form>

    <h2>Metas Actuales</h2>
    <ul>
        <?php foreach ($metas as $meta): ?>
            <li>
                <strong><?= htmlspecialchars($meta["nombre"]) ?></strong><br>
                Monto: <?= $meta["monto"] ?> | Progreso: <?= $meta["progreso"] ?><br>
                Plazo: <?= $meta["plazo"] ?>
                <?php if ($meta["progreso"] >= $meta["monto"]): ?>
                    <span style="color: green;">¡Meta alcanzada!</span>
                <?php elseif (strtotime($meta["plazo"]) < time()): ?>
                    <span style="color: red;">Plazo vencido</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
