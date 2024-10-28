<?php
header('Content-Type: application/json');

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

// Consulta a la base de datos
$sql = "SELECT id, imagen, nombre, departamento, cargo, fecha_contrato, salario, cedula, fecha_nacimiento, correo FROM empleados";
$result = $conn->query($sql);

$empleados = [];

if ($result->num_rows > 0) {
    // Guardar cada fila en el array $empleados
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
}

// Cerrar la conexión
$conn->close();

// Devolver los datos en formato JSON
echo json_encode($empleados);
?>
