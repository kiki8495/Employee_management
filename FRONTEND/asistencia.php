<?php
session_start();

// Verificar si la sesión tiene el nombre del usuario, de lo contrario, redirigir al login
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html");
    exit();
}

$nombre = $_SESSION['nombre']; // Obtener el nombre del usuario desde la sesión
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Asistencia</title>
    <link rel="stylesheet" href="CSS/asistencia.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
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
          <a href="asistencia.php" class="selected"><i class="bi bi-list-task"></i> Asistencia</a>
        </li>
        <li>
          <a href="informes.php" class="informes"><i class="bi bi-people-fill"></i> Informes</a>
        </li>
        <li>
          <a href="ajustes.php" class="ajustes"><i class="bi bi-gear-fill"></i> Ajustes</a>
        </li>
      </ul>
    </aside>

    <main>
      <div class="calendar">
        <div class="month">
            <h2>Noviembre 2022</h2>
        </div>
        <div class="weekdays">
            <div>Lun</div>
            <div>Mar</div>
            <div>Mié</div>
            <div>Jue</div>
            <div>Vie</div>
            <div>Sáb</div>
            <div>Dom</div>
        </div>
        <div class="days">
            <!-- Aquí puedes agregar los días del mes -->
            <div class="day">1</div>
            <div class="day">2</div>
            <div class="day">3</div>
            <!-- Continúa con los demás días -->

          </div>
          <h2>Detalles del Turno</h2>
          <p id="turno-info">Selecciona un día para ver los detalles.</p>
        </div>
    </main>
  </body>
</html>
