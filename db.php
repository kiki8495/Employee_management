<?php
// Declaración de variables globales
$host = "empresa.cdymoi04qjie.us-east-2.rds.amazonaws.com"; // Variable global para el host
$port = "3306"; // Puerto por defecto de MySQL
$username = "admin";
$password = "123456789"; // Si tienes contraseña, ponla aquí
$dbname = "empresa";

function connect_database() {
    // Declaración de las variables globales dentro de la función
    global $host, $port, $username, $password, $dbname;

    // Crear conexión usando host y puerto
    $conn = new mysqli($host, $username, $password, $dbname, $port);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}
?>
