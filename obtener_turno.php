<?php
include ("./db.php");
session_start();
$id = $_SESSION['empleado_id']; // Obtener el id del empleado desde la sesión

if (!isset($_SESSION['empleado_id'])) {
    echo json_encode(['success' => false, 'message' => 'No se ha iniciado sesión']);
    exit();
}

// Mostrar el id del empleado
error_log("Empleado ID: " . $empleado_id);

$fecha = isset($_POST['day']) ? $_POST['day'] : '';
if (!$fecha) {
    echo json_encode(['success' => false, 'message' => 'Fecha no válida']);
    exit();
}

// Obtener el mes y el año actual para construir la fecha completa
$mes_actual = date('m');
$anio_actual = date('Y');
$fecha_completa = $anio_actual . '-' . $mes_actual . '-' . str_pad($fecha, 2, '0', STR_PAD_LEFT);

// Mostrar la fecha completa para depuración
error_log("Fecha completa: " . $fecha_completa);

// Crear conexión
$conn =connect_database();

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]);
    exit();
}

// Consulta para obtener la asistencia del empleado en la fecha seleccionada
$sql = "SELECT * FROM asistencias WHERE empleado_id = ? AND fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $empleado_id, $fecha_completa);
$stmt->execute();
$result = $stmt->get_result();

// Mostrar el número de filas obtenidas
error_log("Número de filas obtenidas: " . $result->num_rows);

if ($result->num_rows > 0) {
    $asistencia = $result->fetch_assoc();
    echo json_encode(['success' => true, 'shift_info' => "Hora: " . $asistencia['hora'] . ", Estado: " . $asistencia['estado']]);
} else {
    echo json_encode(['success' => true, 'shift_info' => 'No se encontró información para esta fecha.']);
}

$stmt->close();
$conn->close();
?>
