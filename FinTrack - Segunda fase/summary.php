<?php
// Simulación de datos financieros (usando JSON)
$dataFile = 'transactions.json';

// Verificar si el archivo JSON existe
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

// Cargar transacciones existentes
$transactions = json_decode(file_get_contents($dataFile), true);

// Calcular resumen
$totalIncome = 0;
$totalExpenses = 0;
foreach ($transactions as $transaction) {
    if ($transaction['type'] === 'Ingreso') {
        $totalIncome += $transaction['amount'];
    } elseif ($transaction['type'] === 'Gasto') {
        $totalExpenses += $transaction['amount'];
    }
}
$balance = $totalIncome - $totalExpenses;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Financiero</title>
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
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .summary {
            font-size: 18px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resumen Financiero</h1>
        <div class="summary">
            <p><strong>Ingresos Totales:</strong> $<?php echo number_format($totalIncome, 2); ?></p>
            <p><strong>Gastos Totales:</strong> $<?php echo number_format($totalExpenses, 2); ?></p>
            <p><strong>Saldo Actual:</strong> $<?php echo number_format($balance, 2); ?></p>
        </div>
    </div>
</body>
</html>
