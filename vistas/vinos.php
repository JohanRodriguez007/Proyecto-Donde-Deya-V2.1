<?php
require './php/main.php'; // Incluir archivo de conexión

// Obtener la conexión PDO desde la función conexion()
$conn = conexion();

// Preparar y ejecutar la consulta SQL utilizando PDO
$sql = "SELECT producto_codigo, producto_nombre, producto_precio, producto_stock, producto_foto FROM producto where categoria_id = 2";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<a href="index.php?vista=login" class="btn btn-primary position-fixed top-0 end-0 m-3">Iniciar Sesión</a>

<main>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            if (count($resultado) > 0) {
                foreach($resultado as $row) {
        
                    $nombre = $row['producto_nombre'];
                    $precio = $row['producto_precio'];
                    $stock = $row['producto_stock'];
                    $foto = $row['producto_foto'];

                    // Construir la ruta completa de la imagen
                    $imagen = "./img/producto/" . $foto;

                    // Verificar si la imagen existe
                    if (!file_exists($imagen)) {
                        $imagen = "./img/no-photo.png"; // Imagen predeterminada
                    }
            ?>
            <div class="col">
                <div class="card shadow-sm">
                    <img src="<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $nombre; ?></h5>
                        <p class="card-text">$<?php echo $precio; ?></p>
                        <p class="card-text">Unidades Disponibles: <?php echo $stock; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="descripción-producto.php?id=<?php echo $codigo; ?>" class="btn btn-primary">Detalles</a>
                            </div>
                            <a href="#" class="btn btn-success">Agregar</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }
            ?>
        </div>
    </div>
</main>

<?php

require './inc/footer.php'; // Incluir archivo de conexión

?>

<script src="comprar-productos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>