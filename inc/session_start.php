<?php
session_name("INV");
session_start();

// Tiempo de inactividad en segundos (ejemplo: 15 minutos)
$tiempo_inactividad = 900;

// Verificar si existe la variable de tiempo de última actividad
if (isset($_SESSION['ultimo_acceso'])) {
    $inactividad = time() - $_SESSION['ultimo_acceso'];
    if ($inactividad > $tiempo_inactividad) {
        // Si ha excedido el tiempo de inactividad, cerrar la sesión
        session_unset();
        session_destroy();
        header("Location: index.php?vista=tienda&timeout=1");
        exit();
    }
}

// Actualizar el tiempo de último acceso
$_SESSION['ultimo_acceso'] = time();

// Verificar si se intenta acceder a una vista protegida
$vista_protegida = ['home', 'otra_vista_protegida']; // Agrega aquí más vistas si es necesario

if (isset($_GET['vista']) && in_array($_GET['vista'], $vista_protegida) && !isset($_SESSION['usuario'])) {
    header("Location: index.php?vista=tienda&timeout=1");
    exit();
}
?>




