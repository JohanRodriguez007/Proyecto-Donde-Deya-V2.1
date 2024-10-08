<?php
require './php/main.php'; // Incluir archivo de conexión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: index.php?vista=login");
    exit();
}

$usuario_id = $_SESSION['id'];

// Obtener la conexión PDO desde la función conexion()
$conn = conexion();

// Preparar y ejecutar la consulta SQL para obtener los productos del carrito
$sql = "SELECT carrito.carrito_id, producto.producto_nombre, producto.producto_precio, carrito.cantidad, producto.producto_foto, producto.producto_stock
        FROM carrito
        JOIN producto ON carrito.producto_id = producto.producto_id
        WHERE carrito.usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$usuario_id]);
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-end position-fixed top-0 end-0 m-3">
    <a href="index.php?vista=login" class="btn btn-primary me-2">Iniciar Sesión</a>
    <a href="index.php?vista=customer_new" class="btn btn-primary">Registrarse</a>
</div>

<main>
    <div class="container">
        <h1>Carrito de Compras</h1>
        <?php if (count($resultado) > 0) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_carrito = 0;
                    foreach($resultado as $row) {
                        $nombre = $row['producto_nombre'];
                        $precio = $row['producto_precio'];
                        $cantidad = $row['cantidad'];
                        $foto = $row['producto_foto'];
                        $carrito_id = $row['carrito_id'];
                        $stock = $row['producto_stock']; // Stock del producto
                        $total_producto = $precio * $cantidad;

                        // Construir la ruta completa de la imagen
                        $imagen = "./img/producto/" . $foto;

                        // Verificar si la imagen existe
                        if (!file_exists($imagen)) {
                            $imagen = "./img/no-photo.png"; // Imagen predeterminada
                        }

                        // Mostrar mensaje si la cantidad en el carrito excede el stock
                        if ($cantidad > $stock) {
                            echo '<tr class="table-danger">';
                            echo '<td><img src="' . $imagen . '" alt="' . htmlspecialchars($nombre) . '" style="width: 50px; height: 50px;"></td>';
                            echo '<td>' . htmlspecialchars($nombre) . '</td>';
                            echo '<td>$' . number_format($precio, 2) . '</td>';
                            echo '<td>' . htmlspecialchars($cantidad) . ' (Excede el stock)</td>';
                            echo '<td>$' . number_format($total_producto, 3) . '</td>';
                            echo '<td>
                                    <form method="post" action="./php/eliminar_carrito.php">
                                        <input type="hidden" name="carrito_id" value="' . htmlspecialchars($carrito_id) . '">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                  </td>';
                            echo '</tr>';
                        } else {
                            echo '<tr>';
                            echo '<td><img src="' . $imagen . '" alt="' . htmlspecialchars($nombre) . '" style="width: 50px; height: 50px;"></td>';
                            echo '<td>' . htmlspecialchars($nombre) . '</td>';
                            echo '<td>$' . number_format($precio, 3) . '</td>';
                            echo '<td>' . htmlspecialchars($cantidad) . '</td>';
                            echo '<td>$' . number_format($total_producto, 3) . '</td>';
                            echo '<td>
                                    <form method="post" action="./php/eliminar_carrito.php">
                                        <input type="hidden" name="carrito_id" value="' . htmlspecialchars($carrito_id) . '">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                  </td>';
                            echo '</tr>';
                        }

                        $total_carrito += $total_producto;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total del Carrito:</strong></td>
                        <td colspan="2">$<?php echo number_format($total_carrito, 3); ?></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end mt-3">
                <form method="post" action="./index.php?vista=pedidos">
                    <button type="submit" class="btn btn-success">Realizar Pedido</button>
                </form>
            </div>
        <?php } else { ?>
            <p>Tu carrito está vacío.</p>
        <?php } ?>
    </div>
</main>

<?php
require './inc/footer.php'; // Incluir archivo de pie de página
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>




