<?php
session_start();

// Verificar si la sesión tiene el nombre del usuario, de lo contrario, redirigir al login
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}
$nombre = $_SESSION['nombre'];
$id = $_SESSION['id']; // Obtener el nombre del usuario desde la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";  // Cambia según tus credenciales
$password = "";      // Cambia según tus credenciales
$dbname = "empresa";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos
$sql = "SELECT * from empleados where id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    throw new Exception("Error enrollment: " . $mysqli->error);
}
$result = $stmt->get_result();
$row = $result->fetch_assoc();
// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajustes</title>
    <link rel="stylesheet" href="CSS/ajustes.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="home.php">
                    <img class="img_logo" src="img/logo_company.png" alt="logo" />
                </a>
            </div>
            <div class="right-section">
                <div class="search-bar">
                    <input type="text" placeholder="Buscar..." />
                </div>
                <div class="user-profile">
                <span><i class="bi bi-person-circle"></i> <?php echo $nombre; ?></span>
          </div>
          <button class="logout-btn" onclick="window.location.href='../BACKEND/logout.php'">Cerrar Sesión</button>
            </div>
        </nav>
    </header>
    <aside class="sidebar">
        <ul class="nav-links">
            <li>
                <a href="home.php" class="inicio"><i class="bi bi-house-door"></i> Inicio</a>
            </li>
            <li>
                <a href="empleados.php" class="empleados"><i class="bi bi-app"></i> Empleados</a>
            </li>
            <li>
                <a href="asistencia.php" class="asistencia"><i class="bi bi-list-task"></i> Asistencia</a>
            </li>
            <li>
                <a href="informes.php" class="informes"><i class="bi bi-people-fill"></i> Informes</a>
            </li>
            <li>
                <a href="ajustes.php" class="selected"><i class="bi bi-gear-fill"></i> Ajustes</a>
            </li>
        </ul>
    </aside>

    <main>
        <main class="container mt-5">
            <form id="formEmpleado" method="post" action="../BACKEND/post_datos_empleado.php">
            <div id="error-message" style="color: red"></div>
                <div class="form-group">
                    <label for="nombre">Nombres</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nombre"
                        name="nombre"
                        required
                        value="<?php echo ($row['nombre']); ?>" />
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input
                        type="email"
                        class="form-control"
                        id="correo"
                        name="correo"
                        readonly
                        value="<?php echo ($row['correo']); ?>" />
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <select class="form-control" id="cargo" name="cargo" required>
                        <option value="Contador" <?php echo ($row['cargo'] === 'Contador') ? 'selected' : ''; ?>>Contador</option>
                        <option value="Vendedor" <?php echo ($row['cargo'] === 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                        <option value="Auxiliar" <?php echo ($row['cargo'] === 'Auxiliar') ? 'selected' : ''; ?>>Auxiliar</option>
                        <option value="Jefe de Punto" <?php echo ($row['cargo'] === 'Jefe de Punto') ? 'selected' : ''; ?>>Jefe de Punto</option>
                    </select>

                </div>
                <div class="form-group">
                    <label for="fecha-nacimiento">Fecha de Nacimiento</label>
                    <input
                        type="date"
                        class="form-control"
                        id="fecha-nacimiento"
                        name="fecha_nacimiento"
                        required
                        value="<?php echo htmlspecialchars($row['fecha_nacimiento']); ?>" />
                </div>
                <div class="form-group">
                    <label for="fecha-contrato">Fecha de Ingreso</label>
                    <input
                        type="date"
                        class="form-control"
                        id="fecha-contrato"
                        name="fecha_contrato"
                        readonly 
                        value="<?php echo htmlspecialchars($row['fecha_contrato']); ?>" />
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input
                        type="text"
                        class="form-control"
                        id="direccion"
                        name="direccion"
                        value="<?php echo htmlspecialchars($row['direccion']); ?>" />
                </div>
                <div class="form-group">
                    <label for="cedula">Cédula</label>
                    <input
                        type="text"
                        class="form-control"
                        id="cedula"
                        name="cedula"
                        readonly 
                        value="<?php echo htmlspecialchars($row['cedula']); ?>" />
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </main>
    </main>
    <script>
      // Verificar si existe el parámetro 'error' en la URL
      const urlParams = new URLSearchParams(window.location.search);
      const error = urlParams.get("error");

      // Si el parámetro 'error' está presente, mostrar el mensaje de error
      if (error) {
        document.getElementById("error-message").innerText =
          "Error en los datos";
      }
      </script>
</body>

</html>