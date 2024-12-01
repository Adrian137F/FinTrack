<?php
// Exportar datos financieros a CSV o PDF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formato = $_POST['formato'];
    $datos = json_decode(file_get_contents('transacciones.json'), true);

    if ($formato === 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="datos_financieros.csv"');
        
        $salida = fopen('php://output', 'w');
        fputcsv($salida, array('Fecha', 'Descripción', 'Categoría', 'Monto'));
        foreach ($datos as $transaccion) {
            fputcsv($salida, $transaccion);
        }
        fclose($salida);
    } elseif ($formato === 'pdf') {
        require_once('fpdf/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'Datos Financieros');
        $pdf->Ln();
        foreach ($datos as $transaccion) {
            $pdf->Cell(40, 10, implode(' | ', $transaccion));
            $pdf->Ln();
        }
        $pdf->Output('D', 'datos_financieros.pdf');
    }
    exit;
}
?>

<form action="exportar_datos.php" method="POST">
    <label for="formato">Selecciona el formato:</label>
    <select id="formato" name="formato">
        <option value="csv">CSV</option>
        <option value="pdf">PDF</option>
    </select>
    <button type="submit">Exportar</button>
</form>
