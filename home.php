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
    <title>Página Principal</title>
    <link rel="stylesheet" href="./CSS/home.css" />
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
            <!-- Aquí se muestra el nombre del usuario desde la sesión -->
            <span><i class="bi bi-person-circle"></i> <?php echo $nombre; ?></span>
          </div>
          <button class="logout-btn" onclick="window.location.href='./logout.php'">Cerrar Sesión</button>
        </div>
      </nav>
    </header>
    <div class="content-container">
      <aside class="sidebar">
        <ul class="nav-links">
          <li>
            <a href="home.php" class="selected"
              ><i class="bi bi-house-door"></i> Inicio</a
            >
          </li>
          <li>
            <a href="empleados.php" class="empleados"
              ><i class="bi bi-app"></i> Empleados</a
            >
          </li>
          <li>
            <a href="asistencia.php" class="asistencia"
              ><i class="bi bi-list-task"></i> Asistencia</a
            >
          </li>
          <li>
            <a href="informes.php" class="informes"
              ><i class="bi bi-people-fill"></i> Informes</a
            >
          </li>
          <li>
            <a href="ajustes.php" class="ajustes"
              ><i class="bi bi-gear-fill"></i> Ajustes</a
            >
          </li>
        </ul>
      </aside>
    </div>
    <main>
      <div class="saludo">
        <!-- Aquí también se muestra el nombre del usuario -->
        <h1>Hola <span><?php echo $nombre; ?>!</span>👋</h1>
        <p class="news">
          Excepteur ea laborum enim cillum ipsum ea aliquip consectetur esse
          exercitation in sit. Dolore fugiat pariatur cillum sint. Ipsum enim
          esse veniam reprehenderit enim non. Quis ut id qui esse elit. Magna id
          anim sint commodo. Aliquip exercitation eiusmod cillum et consequat
          qui ullamco. Ullamco do consequat elit amet laboris id incididunt
          reprehenderit dolore. Veniam esse reprehenderit veniam occaecat.
          Cupidatat anim in sit pariatur adipisicing sit exercitation ipsum
          adipisicing sint nisi aliquip. Non sunt deserunt ad veniam in nostrud
          Lorem fugiat non nostrud commodo aute. Nisi ad et in in ea veniam
          laboris incididunt excepteur fugiat dolor. Cillum nulla consequat
          mollit adipisicing aliquip dolor in. Nisi ullamco ipsum ea ex
          adipisicing mollit labore exercitation.
        </p>
      </div>
      <div class="activity">
        <h2>Esta es tu lista de actividades</h2>
        <img class="img-chart" src="img/chart-example(remove-later).png" alt="chart-logo"/>
      </div>
    </main>
  </body>
</html>
