<?php
// Incluir archivo de conexión y sesión
require_once './main.php';

// Iniciar sesión
session_name("INV");
session_start();

// Depuración: Mostrar contenido de la sesión
echo "<pre>";
echo "Sesión actual: ";
print_r($_SESSION);
echo "</pre>";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo '<div class="message_error">No se ha iniciado sesión correctamente.</div>';
    header("Location: ../index.php?vista=login");
    exit();
}

// Obtener datos del formulario
$producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
$usuario_id = $_SESSION['id'];

// Verificar que los datos son válidos
if ($producto_id <= 0 || $cantidad <= 0) {
    echo '<div class="message_error">Datos inválidos para agregar al carrito.</div>';
    exit();
}

// Obtener la conexión PDO desde la función conexion()
$conn = conexion();

// Primero, verificar si el producto ya está en el carrito del usuario
$sql = "SELECT cantidad FROM carrito WHERE usuario_id = ? AND producto_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$usuario_id, $producto_id]);
$producto_en_carrito = $stmt->fetch(PDO::FETCH_ASSOC);

if ($producto_en_carrito) {
    // Si el producto ya está en el carrito, actualizar la cantidad
    $nueva_cantidad = $producto_en_carrito['cantidad'] + $cantidad;
    $sql_actualizar = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
    $stmt_actualizar = $conn->prepare($sql_actualizar);
    $stmt_actualizar->execute([$nueva_cantidad, $usuario_id, $producto_id]);
} else {
    // Si el producto no está en el carrito, insertarlo
    $sql_insertar = "INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)";
    $stmt_insertar = $conn->prepare($sql_insertar);
    $stmt_insertar->execute([$usuario_id, $producto_id, $cantidad]);
}

// Redirigir al carrito después de agregar el producto
header("Location: ../index.php?vista=carrito");
exit();
?>



