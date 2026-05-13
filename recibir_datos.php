<?php
require_once __DIR__ . "/conexion.php";

header("Content-Type: text/plain; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Método no permitido";
    mysqli_close($conexion);
    exit;
}

if (!isset($_POST["ppm"])) {
    echo "Error: falta el parámetro ppm en la solicitud POST.";
    mysqli_close($conexion);
    exit;
}

$ppm = floatval($_POST["ppm"]);

if ($ppm < 200) {
    $estado = "Seguro";
} elseif ($ppm >= 200 && $ppm <= 400) {
    $estado = "Precaución";
} else {
    $estado = "Peligro";
}

$sql = "INSERT INTO lecturas (valor_gas, estado) VALUES (?, ?)";
$stmt = mysqli_prepare($conexion, $sql);

if (!$stmt) {
    echo "Error al preparar la consulta: " . mysqli_error($conexion);
    mysqli_close($conexion);
    exit;
}

mysqli_stmt_bind_param($stmt, "ds", $ppm, $estado);

if (mysqli_stmt_execute($stmt)) {
    echo "Dato guardado correctamente: " . $ppm . " ppm - " . $estado;
} else {
    echo "Error al guardar el dato: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
