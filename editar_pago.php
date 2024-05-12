<?php
include('conexion.php');
include('pago.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editarPagoId'])) {
        $id = $_POST['editarPagoId'];
        $fecha = $_POST['editarFecha'];
        $trabajador = $_POST['editarTrabajador'];
        $categoria = $_POST['editarCategoria'];
        $horas = $_POST['editarHoras'];

        $pago = new Pago($id, $fecha, $trabajador, $categoria, $horas);
        $pago->actualizarEnBaseDatos($conn);

        header("Location: index.php");
        exit();
    }
}
?>
