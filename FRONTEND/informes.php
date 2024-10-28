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
    <title>Informes</title>
    <link rel="stylesheet" href="CSS/informes.css" />
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
          <a href="empleados.html" class="empleados"><i class="bi bi-app"></i> Empleados</a>
        </li>
        <li>
          <a href="asistencia.html" class="asistencia"><i class="bi bi-list-task"></i> Asistencia</a>
        </li>
        <li>
          <a href="informes.html" class="selected"><i class="bi bi-people-fill"></i> Informes</a>
        </li>
        <li>
          <a href="ajustes.php" class="ajustes"><i class="bi bi-gear-fill"></i> Ajustes</a>
        </li>
      </ul>
    </aside>

    <main>
      <div class="form-container">
        <h2>Formulario de Informes</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="tipo-informe">Tipo de Informe:</label>
                <select id="tipo-informe" name="tipo-informe" required>
                    <option value="comprobante-nomina">Comprobante de Nómina</option>
                    <option value="vacaciones">Vacaciones</option>
                    <option value="ventas-establecidas">Ventas Establecidas</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>
            <div class="form-group">
                <label for="anio">Año:</label>
                <input type="number" id="anio" name="anio" min="2000" max="2100" required>
            </div>
            <div class="form-group">
                <label for="mes">Mes:</label>
                <input type="month" id="mes" name="mes" required>
            </div>
            <button type="submit">Enviar Informe</button>
        </form>
    </div>
    </main>
  </body>
</html>
