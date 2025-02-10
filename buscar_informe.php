<?php
include ("./db.php");
session_start();

// Verificar si la sesión tiene el nombre del usuario
if (!isset($_SESSION['nombre']) || !isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

$nombre = $_SESSION['nombre']; // Nombre del usuario
$id_empleado = $_SESSION['id']; // ID del empleado (asumimos que viene de la sesión)

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar a la base de datos (ajusta estos datos según tu configuración)
    $conexion = connect_database();

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Capturar los datos del formulario
    $mes_anio = $_POST['mes-anio'];  // Formato: YYYY-MM
    $tipo_informe = $_POST['tipo-informe'];

    // Separar el mes y año
    list($anio, $mes) = explode('-', $mes_anio);

    // Preparar la consulta SQL según el tipo de informe
    if ($tipo_informe == "comprobante-nomina") {
        $sql = "SELECT archivo FROM nomina WHERE id_empleado = ? AND mes = ? AND anio = ?";
    }
    // Puedes añadir otras consultas para otros tipos de informes aquí

    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iii", $id_empleado, $mes, $anio);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si se encontró el archivo
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $archivo = $fila['archivo']; // Ruta del archivo

        echo "<p>Informe encontrado: <a href='$archivo' download>Descargar Archivo</a></p>";
    } else {
        echo "<p>No se encontró ningún informe para el mes y año seleccionados.</p>";
    }

    // Cerrar conexión
    $stmt->close();
    $conexion->close();
}
?>
