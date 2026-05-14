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
            return "estado-seguro";
        case "Precaución":
            return "estado-precaucion";
        case "Peligro":
            return "estado-peligro";
        default:
            return "estado-precaucion";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SafeHome IoT</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="site-header">
    <nav class="navbar">
        <a href="index.html" class="logo">SafeHome IoT</a>

        <div class="nav-links">
            <a href="index.html">Inicio</a>
            <a href="index.html#caracteristicas">Características</a>
            <a href="index.html#registro">Formulario</a>
            <a href="index.html#ayuda">Impacto</a>
        </div>

        <a href="index.html" class="btn btn-outline nav-dashboard">Volver al inicio</a>
    </nav>
</header>

<main class="dashboard-page">

    <section class="dashboard-hero">
        <div>
            <p class="dashboard-label">Panel de monitoreo</p>
            <h1>Dashboard de lecturas del sensor</h1>
            <p>
                Visualización de las últimas lecturas registradas por el sistema IoT con ESP32,
                sensor de gas, PHP y MySQL.
            </p>
        </div>

        <div class="dashboard-status-card">
            <p>Estado del sistema</p>
            <h2>Activo</h2>
            <span>Actualización automática cada 10 segundos</span>
        </div>
    </section>

    <section class="dashboard-summary">
        <article class="summary-card">
            <span>📡</span>
            <h3>ESP32</h3>
            <p>Dispositivo conectado al sistema de monitoreo.</p>
        </article>

        <article class="summary-card">
            <span>🌫️</span>
            <h3>Sensor de gas</h3>
            <p>Lecturas expresadas en partes por millón.</p>
        </article>

        <article class="summary-card">
            <span>🗄️</span>
            <h3>MySQL</h3>
            <p>Datos almacenados con fecha y hora.</p>
        </article>
    </section>

    <section class="dashboard-table-section">
        <div class="table-header">
            <div>
                <h2>Últimas 10 lecturas</h2>
                <p>Registros más recientes guardados en la base de datos.</p>
            </div>
        </div>

        <?php if (isset($error_consulta)) : ?>
            <div class="dashboard-error">
                Error al cargar lecturas:
                <?php echo htmlspecialchars($error_consulta, ENT_QUOTES, "UTF-8"); ?>
            </div>
        <?php else : ?>

            <div class="table-wrapper">
                <table class="dashboard-table">
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

                                <td>
                                    <strong>
                                        <?php echo htmlspecialchars((string) $fila["valor_gas"], ENT_QUOTES, "UTF-8"); ?>
                                    </strong>
                                    ppm
                                </td>

                                <td>
                                    <span class="estado-badge <?php echo htmlspecialchars(clase_por_estado($fila["estado"]), ENT_QUOTES, "UTF-8"); ?>">
                                        <?php echo htmlspecialchars($fila["estado"], ENT_QUOTES, "UTF-8"); ?>
                                    </span>
                                </td>

                                <td><?php echo htmlspecialchars((string) $fila["fecha_hora"], ENT_QUOTES, "UTF-8"); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </section>

</main>

<footer class="footer">
    <div class="footer-content">
        <p>© 2025 SafeHome IoT. Dashboard académico con ESP32, PHP y MySQL.</p>
    </div>
</footer>

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