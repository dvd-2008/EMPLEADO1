<?php
$servername = "localhost:3315"; // Cambia a tu servidor MySQL
$username = "root"; // Cambia a tu nombre de usuario MySQL
$password = ""; // Cambia a tu contraseña de MySQL
$database = "emple"; // Cambia al nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
