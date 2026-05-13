<?php
/**
 * Punto de entrada legado / ESP32: redirige la lógica a recibir_datos.php
 * Prueba: curl -X POST -d "ppm=450" http://localhost/detector_gases/datos.php
 */
require __DIR__ . "/recibir_datos.php";
