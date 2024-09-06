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
        // Redirigir a la vista de tienda en caso de caducidad de sesión
        if (basename($_SERVER['PHP_SELF']) !== 'index.php' || (isset($_GET['vista']) && $_GET['vista'] !== 'tienda')) {
            header("Location: index.php?vista=tienda&timeout=1");
            exit();
        }
    }
}

// Actualizar el tiempo de último acceso
$_SESSION['ultimo_acceso'] = time();

// Verificar si se intenta acceder a una vista protegida
$vista_protegida = ["tienda", "cerveza", "vinos", "whiskey", "aguardiente", "mecato", "login", "home", "404", 
"category_list", "category_new", "category_search", "category_update", "logout", 
"product_category", "product_img", "product_list", "product_new", "product_search", 
"product_update", "user_list", "user_new", "user_search", "user_update", "customer_new", "activate_customer"];

// Obtener la vista actual desde el parámetro URL
$vista_actual = isset($_GET['vista']) ? $_GET['vista'] : '';

// Verificar si se intenta acceder a una vista protegida y la vista actual no es la página de redirección
if (in_array($vista_actual, $vista_protegida) && !isset($_SESSION['usuario']) && $vista_actual !== 'login' && $vista_actual !== 'tienda') {
    header("Location: index.php?vista=tienda&timeout=1");
    exit();
}
?>







