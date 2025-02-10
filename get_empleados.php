<?php
include ("./db.php");
header('Content-Type: application/json');


// Crear conexión
$conn =connect_database();
// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el valor del filtro de búsqueda (si existe)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta a la base de datos con filtro si se proporciona un término de búsqueda
if ($search) {
    $sql = "SELECT id, imagen, nombre, departamento, cargo, fecha_contrato, salario, cedula, fecha_nacimiento, correo 
            FROM empleados 
            WHERE nombre LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchParam = '%' . $search . '%';
    $stmt->bind_param('s', $searchParam);
} else {
    // Si no hay búsqueda, selecciona todos los empleados
    $sql = "SELECT id, imagen, nombre, departamento, cargo, fecha_contrato, salario, cedula, fecha_nacimiento, correo FROM empleados";
    $stmt = $conn->prepare($sql);
}

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

$empleados = [];

if ($result->num_rows > 0) {
    // Guardar cada fila en el array $empleados
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
}

// Cerrar la conexión
$stmt->close();
$conn->close();

// Devolver los datos en formato JSON
echo json_encode($empleados);
?>
