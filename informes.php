<?php
include ("./db.php");
session_start();

// Verificar si la sesión tiene el nombre del usuario, de lo contrario, redirigir al login
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
  exit();
}

$nombre = $_SESSION['nombre']; // Obtener el nombre del usuario desde la sesión
$id = $_SESSION['id']; // Obtener el id del usuario desde la sesión
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Informes</title>
  <link rel="stylesheet" href="CSS/informes.css" />
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
        <button class="logout-btn" onclick="window.location.href='./logout.php'">Cerrar Sesión</button>
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
        <a href="informes.php" class="selected"><i class="bi bi-people-fill"></i> Informes</a>
      </li>
      <li>
        <a href="ajustes.php" class="ajustes"><i class="bi bi-gear-fill"></i> Ajustes</a>
      </li>
    </ul>
  </aside>

  <main>
    <div class="form-container">
      <h2>Formulario de Informes</h2>
      <form action="informes.php" method="post"> <!-- Cambiado a informes.php -->
        <div class="form-group">
          <label for="mes-anio">Mes y Año:</label>
          <input type="month" id="mes-anio" name="mes-anio" required>
        </div>
        <div class="form-group">
          <label for="tipo-informe">Tipo de Informe:</label>
          <select id="tipo-informe" name="tipo-informe" required>
            <option value="comprobante-nomina">Comprobante de Nómina</option>
            <option value="ventas-establecidas">Ventas Establecidas</option>
            <!-- Agregar más opciones según sea necesario -->
          </select>
        </div>
        <button type="submit">Enviar Informe</button>
      </form>
    </div>

    <?php
    // Aquí agregamos la lógica de procesamiento para buscar el archivo


    $nombre = $_SESSION['nombre']; // Nombre del usuario
    $id_empleado = $_SESSION['id']; // ID del empleado (asumimos que viene de la sesión)

    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Conectar a la base de datos
      $conexion = connect_database();

      if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
      }

      // Capturar los datos del formulario
      $mes_anio = $_POST['mes-anio'];  // Formato: YYYY-MM
      $tipo_informe = $_POST['tipo-informe'];

      // Separar el mes y año
      list($anio, $mes) = explode('-', $mes_anio);

      // Preparar la consulta SQL según el tipo de informe
      if ($tipo_informe == "comprobante-nomina") {
        $sql = "SELECT archivo FROM nomina WHERE id_empleado = ? AND mes = ? AND anio = ?";
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iii", $id_empleado, $mes, $anio);
        $stmt->execute();
        $resultado = $stmt->get_result();
      } else if ($tipo_informe == "ventas-establecidas") {
        $sql = "SELECT archivo FROM ventas WHERE mes = ? AND anio = ?";
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii",  $mes, $anio);
        $stmt->execute();
        $resultado = $stmt->get_result();
      }
      // Verificar si se encontró el archivo
      if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $archivo = $fila['archivo']; // Ruta del archivo

        echo "<p>Informe encontrado: <a href='$archivo' download>Descargar Archivo</a></p>";
      } else {
        echo "<p>No se encontró ningún informe para el mes y año seleccionados.</p>";
      }

      // Cerrar conexión
      $stmt->close();
      $conexion->close();
    }
    ?>
  </main>
</body>

</html>