<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Pastel - Rosy's Cake</title>
    <!--Importo mi CSS para el diseño de mi pgina web (programa)-->
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
    
    <h1 class="banner">Eliminar Pastel</h1>

    <!--Sección en donde se encuentran el campo de textos requerido para agregar un pastel a la base de datos-->
    <section class="form-section">
        <form method="post" action="">
            <div class="form-group">
                <label for="codigo">Código del pastel a eliminar:</label>
                <input type="text" id="codigo" name="codigo" step="0.01" required oninput="validarLongitud(this)" maxlength="8" onkeypress="soloNumeros(event)">
            </div>
            <!--Botón para eliminar un pastel-->
            <div class="form-group">
            <input type="submit" name="eliminar" value="Verificar y Eliminar" class="btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este pastel?');">
                <input type="button" value="Limpiar" onclick="limpiarCampo('codigo')" class="btn">
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
    } else {
        //echo "Base de datos conectada //";
    }

    // Verificar si se ha enviado el formulario de eliminar
    if (isset($_POST['eliminar'])) {
        $codigo = $_POST['codigo'];

        // Verificar si el pastel existe antes de eliminarlo
        $check_sql = "SELECT * FROM pasteles WHERE codigo='$codigo'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows == 0) {
            echo "<p class='error'>El pastel con el código $codigo no existe. No se puede borrar.</p>";
        } else {
            $sql = "DELETE FROM pasteles WHERE codigo='$codigo'";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>Datos eliminados correctamente</p>";
            } else {
                echo "<p class='error'>Error al eliminar los datos: " . $conn->error . "</p>";
            }
        }
    }
    ?>

    <section class="table-section">
        <?php
        // Mostrar la tabla de pasteles después del formulario
        $sql = "SELECT * FROM pasteles";
        $result = $conn->query($sql);
/*
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Codigo</th><th>Pastel</th><th>Descripción</th><th>Precio</th><th>Existencias</th><th>Categoria</th></tr>";
            while ($row = $result->fetch_assoc()) {
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
    </section>

    <!--Funcion para limpiar campos de texto-->
    <script>
        function limpiarCampo(idCampo) {
            document.getElementById(idCampo).value = "";
        }
    </script>
</body>
</html>