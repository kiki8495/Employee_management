<?php
include ("./db.php");
session_start(); // Iniciar la sesión


// Crear conexión
$conn = connect_database();
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta SQL
    $stmt = $conn->prepare("SELECT id, nombre FROM empleados WHERE correo = ? AND contrasena = ?");
    $stmt->bind_param("ss", $email, $password);

    // Ejecutar la consulta
    $stmt->execute();
    $stmt->store_result();

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nombre);
        $stmt->fetch();
        
        $_SESSION['nombre'] = $nombre;
        $_SESSION['id'] = $id;

        // Redirigir al home
        header("Location: ./home.php");
    } else {
        // Si las credenciales son incorrectas, redirigir al login.html con un parámetro de error
        header("Location: ./login.html?error=1");
        
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
    exit();
}
?>
