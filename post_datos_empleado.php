<?php
include ("./db.php");
session_start();

// Verificar si la sesión tiene el nombre del usuario, de lo contrario, redirigir al login
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}
$id = $_SESSION['id']; // Obtener el nombre del usuario desde la sesión


// Crear conexión
$conn = connect_database();

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos enviados desde el formulario (puedes validar los campos antes de procesarlos)
$nombre = $_POST['nombre'];
$cargo = $_POST['cargo'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$direccion = $_POST['direccion'];
$empleado_id = $id; // Esto debe venir de la sesión o la lógica de tu aplicación

// Actualizar la base de datos
$sql = "UPDATE empleados SET nombre = ?, cargo = ?, fecha_nacimiento = ?, direccion = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nombre,  $cargo, $fecha_nacimiento, $direccion, $empleado_id);
$result = $stmt->execute();

if ($result) {
    header("Location: ./ajustes.php");
} else {
    header("Location: ./ajustes.php?error=1");

}
    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
    exit();
?>
