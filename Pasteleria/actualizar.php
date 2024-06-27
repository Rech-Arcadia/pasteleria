<link rel="stylesheet" type="text/css" href="phtyle.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Pastel - Sweet Bakery</title>
    <link rel="stylesheet" href="agregar.css">
    <link rel="stylesheet" type="text/css" href="phtyle.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="nosotros.html">Nosotros</a></li>
                <li><a href="productos.html">Productos</a></li>
                <li><a href="contacto.html">Contacto</a></li>
            </ul>
        </nav>
    </header>
    
    <!--
    <section class="banner">
        <img src="banner.jpg" alt="Banner de pastelería">
        <div class="banner-text">
            <h1>Agregar Nuevo Pastel</h1>
        </div>
    </section>
    -->

    <h1 style="color: black;" class="banner">Actualizar Pastel</h1>

    <section class="form-section">
        <form action="actualizar.php" method="post">
            <div class="form-group">
                <label for="codigo">Codigo del Pastel a editar:</label>
                <input type="text" id="codigo" name="codigo" required>
            </div>
            <div class="form-group">
                <label for="pastel">Nuevo Nombre del Pastel:</label>
                <input type="text" id="pastel" name="pastel" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Nueva Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Nuevo Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="existencias">Nueva Existencias:</label>
                <input type="number" id="existencias" name="existencias" required>
            </div>
            <div class="form-group">
                <label for="categoria">Nueva Categoría:</label>
                <select id="categoria" name="categoria" required>
                    <option value="cupcakes">Cupcakes</option>
                    <option value="chocolate">Pasteles de Chocolate</option>
                    <option value="boda">Pasteles de Boda</option>
                    <option value="nuevos">Nuevos Productos</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Actualizar</button>
            </div>
        </form>
    </section>
</body>
</html>

<?php
$servername = "localhost"; // Cambia esto por la dirección de tu servidor MySQL
$username = "root"; // Cambia esto por tu nombre de usuario de MySQL
$password = "090103"; // Cambia esto por tu contraseña de MySQL
$dbname = "pasteleria"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['actualizar'])) {
    $codigo = $_POST['codigo'];
    $pastel = $_POST['pastel'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $existencias = $_POST['existencias'];
    $categoria = $_POST['categoria'];
    
    $sql = "UPDATE pasteles SET pastel='$pastel', descripcion='$descripcion', precio='$precio', existencias='$existencias', categoria='$categoria' WHERE codigo='$codigo'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Datos actualizados correctamente</p>";
    } else {
        echo "<p class='error'>Error al actualizar los datos: " . $conn->error . "</p>";
    }
}

/////////////////////////////////////////////////
    $codigo = $_POST['codigo'];
    $pastel = $_POST['pastel'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $existencias = $_POST['existencias'];
    $categoria = $_POST['categoria'];


    $sql = "UPDATE pasteles SET pastel='$pastel', descripcion='$descripcion', precio='$precio', existencias='$existencias', categoria='$categoria' WHERE codigo='$codigo'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Datos actualizados correctamente";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

$sql = "SELECT * FROM pasteles";
$result = $conn->query($sql);

/*if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Codigo</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Existencias</th><th>Categoria</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["codigo"] . "</td>";
        echo "<td>" . $row["pastel"] . "</td>";
        echo "<td>" . $row["descripcion"] . "</td>";
        echo "<td>" . $row["precio"] . "</td>";
        echo "<td>" . $row["existencias"] . "</td>";
        echo "<td>" . $row["categoria"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay productos disponibles.</p>";
}*/

// Cerrar la conexión
$conn->close();
?>