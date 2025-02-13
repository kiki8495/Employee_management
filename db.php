<?php
// Declaración de variables globales
$host = "empresa.mysql.database.azure.com";
$port = "3306";
$username = "mysqladmin";
$password = "Admin123";
$dbname = "empresa";

function connect_database()
{
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
