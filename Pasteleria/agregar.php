<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Pastel - Rosy's Cake</title>
    <!-- Sección en donde se encuentran mis scripts para distintas funcionalidades del apartado agregar-->
    <script>
        //Funcion para limpiar campos de texto
        function limpiarCampos() {
            var campos = document.querySelectorAll('input[type=text], textarea, input[type=number]');
            campos.forEach(function(elemento) {
                elemento.value = '';
            });
        }
        //Función para limitar campos de texto a ciertos caracteres
        function validarLongitud(input) {
            if (input.value.length > 8) {
                input.value = input.value.slice(0, 8);
            }
        }
        //Función para solamente permitir numeros en un campo de texto del 0-9
        function soloNumeros(event) {
            var char = String.fromCharCode(event.which);
            if (!(/[0-9]/.test(char))) {
                event.preventDefault();
            }
        }
    </script>
    <!--Importo mi CSS para el diseño de mi pgina web (programa)-->
    <link rel="stylesheet" href="agregar.css">
    <link rel="stylesheet" href="phtyle.css">
</head>
<body>
    <!--Menú en la parte superior de la aguna web-->
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="nosotros.html">Nosotros</a></li>
            </ul>
        </nav>
    </header>

    <h1 style="color: black;" class="banner">Agregar Nuevo Pastel</h1>

    <!--Sección en donde se encuentran los campos de textos y selector requeridos para agregar un pastel a la base de datos-->
    <section class="form-section">
        <form action="agregar.php" method="post">
            <div class="form-group">
                <label for="pastel">Nombre del Pastel:</label>
                <input type="text" id="pastel" name="pastel" required>
            </div>
            <div class="form-group">
                <label for="codigo">Codigo del Pastel:</label>
                <input type="text" id="codigo" name="codigo" required oninput="validarLongitud(this)" maxlength="8" onkeypress="soloNumeros(event)">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required oninput="validarLongitud(this)" maxlength="8" onkeypress="soloNumeros(event)">
            </div>
            <div class="form-group">
                <label for="existencias">Existencias:</label>
                <input type="number" id="existencias" name="existencias" required oninput="validarLongitud(this)" maxlength="8" onkeypress="soloNumeros(event)">
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria" required>
                    <option value="cupcakes">Cupcakes</option>
                    <option value="caseros">Pasteles caseros</option>
                    <option value="temporada">Pasteles de temporada</option>
                    <option value="clasicos">Clasicos</option>
                    <option value="nuevos">Nuevos Productos</option>
                </select>
            </div>
            <!--Botón para agregar un pastel, al darle clic se mandaran los datos registrados a la base de datos-->
            <div class="form-group">
                <button type="submit" class="btn" name="agregar" value="agregar">Agregar</button>
            </div>
            <!--Botón para limpiar campos de texto-->
            <div class="form-group">
                <button type="button" class="btn" onclick="limpiarCampos()">Limpiar</button>
            </div>
        </form>
    </section>
</body>
</html>

<?php
$servername = "localhost"; // Dirección de mi servidor MySQL
$username = "root"; // Nombre de usuario de MySQL
$password = "090103"; // Contraseña de MySQL
$dbname = "pasteleria"; // Nombre de mi base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    
}

//Condicional para recibir los valores de los campos de texto
if (isset($_POST['agregar'])) {
    $pastel = $_POST['pastel'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $existencias = $_POST['existencias'];
    $categoria = $_POST['categoria'];
    
    // Verificar si el código ya existe
    $sql_verificar = "SELECT * FROM pasteles WHERE codigo = '$codigo'";
    $result_verificar = $conn->query($sql_verificar);
    
    //Condicional para verificar si el codigo de un pastel ya esta ocupado
    if ($result_verificar->num_rows > 0) {
        echo "<p class='error'>El código del pastel ya está ocupado. Por favor, elija otro código.</p>";
    } else {
        // Guardar datos en la base de datos
        $sql = "INSERT INTO pasteles (pastel, codigo, descripcion, precio, existencias, categoria) VALUES ('$pastel','$codigo','$descripcion', '$precio', '$existencias', '$categoria')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>Datos guardados correctamente</p>";
        } else {
            echo "<p class='error'>Error al guardar los datos: " . $conn->error . "</p>";
        }
    }
}

//Consulta SQL para seleccionar todos los valores de la tabla pasteles de la base de datos
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
