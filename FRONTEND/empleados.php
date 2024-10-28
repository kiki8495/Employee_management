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
    <title>Empleados</title>
    <link rel="stylesheet" href="CSS/empleados.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
  </head>
  <body>
    <header class="header-navbar">
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
          <a href="home.php" class="inicio"
            ><i class="bi bi-house-door"></i> Inicio</a
          >
        </li>
        <li>
          <a href="empleados.php" class="selected"
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

    <main>
      <div class="container">
        <header class="table-header">
          <h1>Empleados</h1>
          <div class="table-controls">
            <button>Filtrar</button>
          </div>
        </header>
        <table>
          <thead>
            <tr>
              <th>Imagen</th>
              <th>Empleado</th>
              <th>ID</th>
              <th>Departamento</th>
              <th>Cargo</th>
              <th>Email</th>
              <th>Fecha de Contratación</th>
              <th>Promedio Salario</th>
            </tr>
          </thead>
          <tbody id="empleadosBody">
            <!-- Aquí se cargarán los datos dinámicamente -->
          </tbody>
        </table>
      </div>
    </main>

    <script>
      // Función para obtener los empleados desde el archivo PHP y actualizar la tabla
      function cargarEmpleados() {
        fetch("../BACKEND/get_empleados.php")
          .then((response) => response.json())
          .then((data) => {
            const empleadosBody = document.getElementById("empleadosBody");
            empleadosBody.innerHTML = ""; // Limpiar la tabla antes de agregar datos

            data.forEach((empleado) => {
              const row = document.createElement("tr");

              row.innerHTML = `
    <td><img class='img-avatar' src='${
      empleado.imagen
    }' alt='Imagen Empleado'></td>
    <td>${empleado.nombre}</td>
    <td>${empleado.id}</td>
    <td>${empleado.departamento}</td>
    <td>${empleado.cargo}</td>
    <td>${empleado.correo}</td>
    <td>${new Date(empleado.fecha_contrato).toLocaleDateString()}</td>
    <td>$${empleado.salario.toLocaleString()}</td>
`;

              empleadosBody.appendChild(row);
            });
          })
          .catch((error) =>
            console.error("Error al obtener los empleados:", error)
          );
      }

      // Cargar empleados cuando la página termine de cargar
      window.onload = cargarEmpleados;
    </script>
  </body>
</html>
