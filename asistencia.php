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

// Establecer la zona horaria para asegurarnos de que la hora sea correcta
date_default_timezone_set('America/Bogota'); // Ajusta esto según tu zona horaria



// Crear conexión
$conn =connect_database();

// Verificar la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables para los mensajes
$shiftDetails = 'Haz clic en un día para ver la información del turno.';
$errorMsg = '';
$successMsg = '';

// Verificar si se ha enviado la fecha
if (isset($_POST['fecha'])) {
  $fecha = $_POST['fecha'];

  // Consulta para obtener la asistencia del empleado en la fecha seleccionada
  $sql = "SELECT * FROM asistencias WHERE empleado_id = ? AND fecha = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $id, $fecha);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $asistencia = $result->fetch_assoc();
    // Mostrar la información del turno
    $shiftDetails = "Hora: " . $asistencia['hora'] . ", Estado: " . $asistencia['estado'];
  } else {
    $shiftDetails = 'No se encontró información para esta fecha.';
  }

  $stmt->close();
}

// Verificar si se ha marcado el turno
if (isset($_POST['marcar_turno'])) {
  $fechaActual = date('Y-m-d'); // Obtener la fecha actual del servidor
  $horaActual = date('H:i:s');  // Obtener la hora actual del servidor
  $diaSemana = date('N', strtotime($fechaActual)); // Obtener el día de la semana (1=Lunes, 7=Domingo)

  // Comprobar si ya existe un registro para la fecha actual
  $sqlCheck = "SELECT * FROM asistencias WHERE empleado_id = ? AND fecha = ?";
  $stmtCheck = $conn->prepare($sqlCheck);
  $stmtCheck->bind_param("is", $id, $fechaActual);
  $stmtCheck->execute();
  $resultCheck = $stmtCheck->get_result();

  if ($resultCheck->num_rows > 0) {
    $errorMsg = "Ya has marcado turno en esta fecha.";
  } else {
    // Verificar si el empleado está marcando tarde
    $estado = "Marcó a tiempo";
    if (($diaSemana >= 1 && $diaSemana <= 5 && $horaActual > "09:00:00") ||
      (($diaSemana == 6 || $diaSemana == 7) && $horaActual > "10:00:00")
    ) {
      $estado = "Marcó con retraso";
    }

    // Insertar el registro del turno
    $sqlInsert = "INSERT INTO asistencias (empleado_id, fecha, hora, estado) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isss", $id, $fechaActual, $horaActual, $estado);

    if ($stmtInsert->execute()) {
      $successMsg = "Turno marcado con éxito para la fecha $fechaActual a las $horaActual con estado: $estado.";

      // Verificar si el día anterior no tiene un turno marcado
      $fechaAnterior = date('Y-m-d', strtotime('-1 day', strtotime($fechaActual)));
      $sqlPrevDay = "SELECT * FROM asistencias WHERE empleado_id = ? AND fecha = ?";
      $stmtPrevDay = $conn->prepare($sqlPrevDay);
      $stmtPrevDay->bind_param("is", $id, $fechaAnterior);
      $stmtPrevDay->execute();
      $resultPrevDay = $stmtPrevDay->get_result();

      if ($resultPrevDay->num_rows == 0) {
        // No se encontró turno en el día anterior, marcar como "No marcó turno"
        $sqlUpdatePrevDay = "INSERT INTO asistencias (empleado_id, fecha, estado) VALUES (?, ?, 'No marcó turno')";
        $stmtUpdatePrevDay = $conn->prepare($sqlUpdatePrevDay);
        $stmtUpdatePrevDay->bind_param("is", $id, $fechaAnterior);
        $stmtUpdatePrevDay->execute();
        $stmtUpdatePrevDay->close();
      }
      $stmtPrevDay->close();
    } else {
      $errorMsg = "Error al marcar el turno. Inténtalo de nuevo.";
    }

    $stmtInsert->close();
  }

  $stmtCheck->close();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asistencia</title>
  <link rel="stylesheet" href="CSS/asistencias.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="home.php">
          <img class="img_logo" src="img/logo_company.png" alt="logo">
        </a>
      </div>
      <div class="right-section">
        <div class="search-bar">
          <input type="text" placeholder="Buscar...">
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
      <li><a href="home.php" class="inicio"><i class="bi bi-house-door"></i> Inicio</a></li>
      <li><a href="empleados.php" class="empleados"><i class="bi bi-app"></i> Empleados</a></li>
      <li><a href="asistencia.php" class="selected"><i class="bi bi-list-task"></i> Asistencia</a></li>
      <li><a href="informes.php" class="informes"><i class="bi bi-people-fill"></i> Informes</a></li>
      <li><a href="ajustes.php" class="ajustes"><i class="bi bi-gear-fill"></i> Ajustes</a></li>
    </ul>
  </aside>

  <main>
    <div class="calendar">
      <div class="month">
        <button id="prev">Anterior</button>
        <h2 id="monthYear"></h2>
        <button id="next">Siguiente</button>
      </div>
      <div class="weekdays">
        <div>Mo</div>
        <div>Tu</div>
        <div>We</div>
        <div>Th</div>
        <div>Fr</div>
        <div>Sa</div>
        <div>Su</div>
      </div>
      <div class="days">
        <!-- Aquí se generarán los días -->
      </div>
    </div>
    <div id="shiftDetails">
      <?php echo $shiftDetails; ?>
    </div>

    <!-- Formulario para marcar el turno -->
    <form method="POST" action="asistencia.php">
      <input type="hidden" name="marcar_turno" value="1">
      <button class="mark-turn-btn" type="submit">Marcar Turno</button>
    </form>

    <div class="message">
      <?php if ($errorMsg) {
        echo "<p class='error'>$errorMsg</p>";
      } ?>
      <?php if ($successMsg) {
        echo "<p class='success'>$successMsg</p>";
      } ?>
    </div>
  </main>

  <script>
    // Pasar el valor de shiftDetails a JavaScript
    const shiftDetails = <?php echo json_encode($shiftDetails); ?>;
  </script>
  <script src="./JS/asistencia.js"></script>
</body>

</html>