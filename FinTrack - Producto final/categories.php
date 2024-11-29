<?php
// Archivo de datos JSON simulado para almacenar categorías
$dataFile = 'categories.json';

// Verificar si el archivo JSON existe, si no, crearlo
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

// Cargar categorías existentes
$categories = json_decode(file_get_contents($dataFile), true);

// Procesar envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCategory = htmlspecialchars($_POST['category_name']);
    if (!empty($newCategory) && !in_array($newCategory, $categories)) {
        $categories[] = $newCategory;
        file_put_contents($dataFile, json_encode($categories));
        $message = "Categoría añadida con éxito.";
    } else {
        $message = "La categoría ya existe o está vacía.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
        .button {
            width: 100%;
            padding: 10px;
            color: #fff;
            background: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            padding: 8px;
            background: #f8f9fa;
            margin-bottom: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Categorías</h1>
        <?php if (isset($message)): ?>
            <p style="color: green;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="category_name" placeholder="Nueva Categoría" required>
            </div>
            <button type="submit" class="button">Añadir Categoría</button>
        </form>
        <h2>Categorías Existentes</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><?php echo $category; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
