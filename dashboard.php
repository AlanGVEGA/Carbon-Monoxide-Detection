<?php
include __DIR__ . "/conexion.php";

$resultado = mysqli_query(
    $conexion,
    "SELECT id, valor_gas, estado, fecha_hora FROM lecturas ORDER BY fecha_hora DESC LIMIT 10"
);

if ($resultado === false) {
    $error_consulta = mysqli_error($conexion);
}

function clase_por_estado($estado)
{
    switch ($estado) {
        case "Seguro":
            return "seguro";
        case "Precaución":
            return "precaucion";
        case "Peligro":
            return "peligro";
        default:
            return "precaucion";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitor de Gases</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="contenedor">
        <h1>Monitor IoT de Gases</h1>
        <p>Sistema con ESP32 para monitoreo de humo y monóxido de carbono.</p>

        <?php if (isset($error_consulta)) : ?>
            <p class="peligro">Error al cargar lecturas: <?php echo htmlspecialchars($error_consulta, ENT_QUOTES, "UTF-8"); ?></p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>PPM</th>
                        <th>Estado</th>
                        <th>Fecha y hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars((string) $fila["id"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars((string) $fila["valor_gas"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td class="<?php echo htmlspecialchars(clase_por_estado($fila["estado"]), ENT_QUOTES, "UTF-8"); ?>">
                                <?php echo htmlspecialchars($fila["estado"], ENT_QUOTES, "UTF-8"); ?>
                            </td>
                            <td><?php echo htmlspecialchars((string) $fila["fecha_hora"], ENT_QUOTES, "UTF-8"); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <script>
        setInterval(function () {
            location.reload();
        }, 10000);
    </script>
</body>
</html>
<?php
mysqli_close($conexion);
?>
