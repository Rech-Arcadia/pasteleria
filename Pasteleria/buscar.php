<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Importo mi CSS para el diseño de mi pgina web (programa)-->
    <title>Buscar y Actualizar Pastel - Rosy's Cake</title>
    <link rel="stylesheet" href="phtyle.css">
    <link rel="stylesheet" href="agregar.css">
    <!-- Sección en donde se encuentran mis scripts para distintas funcionalidades del apartado agregar-->
    <script>
        function limpiarCampos() {
            // Seleccionar todos los elementos de entrada y de texto en el formulario
            var campos = document.querySelectorAll('input[type=text], textarea, input[type=number]');
            
            // Iterar sobre cada elemento y establecer su valor como cadena vacía
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
    
    <h1 class="banner">Buscar y Actualizar Pastel</h1>

    <!--Sección en donde se encuentran el campo de textos requerido para agregar un pastel a la base de datos-->
    <section class="form-section">
        <form method="post" action="">
            <div class="form-group">
                <label for="codigo">Código del pastel:</label>
                <input type="text" id="codigo" name="codigo" step="0.01" required oninput="validarLongitud(this)" maxlength="8" onkeypress="soloNumeros(event)">
            </div>
            <!--Botón para buscar un pastel-->
            <div class="form-group">
                <input type="submit" name="buscar" value="Buscar" class="btn">
            </div>
        </form>
    </section>

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
    }

    // Verificar si se ha enviado el formulario de buscar
    if (isset($_POST['buscar'])) {
        $codigo = $_POST['codigo'];
        // Verificar si el pastel existe
        $sql = "SELECT * FROM pasteles WHERE codigo = '$codigo'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <!--Sección en donde se encuentran los campos de textos requeridos para actalizar un pastel a la base de datos-->
            <section class="form-section">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="codigo">Código:</label>
                        <input type="text" id="codigo" name="codigo" value="<?php echo $row['codigo']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pastel">Nombre:</label>
                        <input type="text" id="pastel" name="pastel" value="<?php echo $row['pastel']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" value="<?php echo $row['descripcion']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio:</label>
                        <input type="text" id="precio" name="precio" value="<?php echo $row['precio']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="existencias">Existencias:</label>
                        <input type="text" id="existencias" name="existencias" value="<?php echo $row['existencias']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría:</label>
                        <input type="text" id="categoria" name="categoria" value="<?php echo $row['categoria']; ?>" required>
                    </div>
                    <!--Botón para actuaizar un pastel-->
                    <div class="form-group">
                        <input type="submit" name="actualizar" value="Actualizar" class="btn" onclick="return confirm('¿Estás seguro de que deseas actualizar este pastel?');">
                    </div>
                </form>
            </section>
            <?php
        } else {
            echo "<p class='error'>No se encontró ningún pastel con ese código.</p>";
        }
    }

    // Verificar si se ha enviado el formulario de actualizar
    if (isset($_POST['actualizar'])) {
        $codigo = $_POST['codigo'];
        $pastel = $_POST['pastel'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $existencias = $_POST['existencias'];
        $categoria = $_POST['categoria'];
        
        // Sentencia SQL para actualizar el pastel
        $sql = "UPDATE pasteles SET pastel='$pastel', descripcion='$descripcion', precio='$precio', existencias='$existencias', categoria='$categoria' WHERE codigo='$codigo'";
        
        // Validación de que los datos se actualizarron correctaente
        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>Datos actualizados correctamente</p>";
        } else {
            echo "<p class='error'>Error al actualizar los datos: " . $conn->error . "</p>";
        }
    }

    // Cerrar la conexión
    $conn->close();
    ?>

    <!--Funcion para limpiar campos de texto-->
    <script>
        function limpiarCampo(idCampo) {
            document.getElementById(idCampo).value = "";
        }
    </script>
</body>
</html>
