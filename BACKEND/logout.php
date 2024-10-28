<?php
session_start();
session_destroy(); // Destruir la sesión
header("Location: ../FRONTEND/login.html"); // Redirigir al login
exit();
?>