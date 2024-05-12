<?php
include('conexion.php');
include('pago.php');
include('modal_edit_pago.php');

function obtenerTodosLosPagos($conn) {
    return Pago::obtenerTodosDesdeBaseDatos($conn);
}

function procesarFormulario($conn) {
    if (isset($_POST['btnProcesar'])) {
        $fecha = date('Y-m-d');
        $trabajador = $_POST['txtTrabajador'];
        $categoria = $_POST['selCategoria'];
        $horas = $_POST['txtHoras'];

        $objPago = new Pago(null, $fecha, $trabajador, $categoria, $horas);
        $objPago->guardarEnBaseDatos($conn);
    }
}

function eliminarPago($conn) {
    if (isset($_GET['eliminar'])) {
        $id_pago = $_GET['eliminar'];
        $pago = new Pago($id_pago, '', '', '', 0);
        $pago->eliminarDeBaseDatos($conn);
    }
}

procesarFormulario($conn);
eliminarPago($conn);

$pagos = obtenerTodosLosPagos($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>PAGO DE TRABAJADORES</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="miEstilo.css" rel="stylesheet">
    <script>
        $(document).ready(function() {
            // Ocultar la tabla de pagos al cargar la página
            $("#tablaPagos").hide();

            // Manejar clic en el botón "Mostrar Pagos"
            $("#btnMostrarPago").click(function() {
                // Alternar la visibilidad de la tabla de pagos
                $("#tablaPagos").toggle();
            });
        });
    </script>
</head>

<body>
    <header>
        <div class="container">
            <h1 class="text-center">PAGO DE TRABAJADORES</h1>
            <h5 class="text-center">MANEJO DE MÉTODO CONSTRUCTOR</h5>
        </div>
    </header>
    <section>
        <div class="container">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtTrabajador">Trabajador</label>
                            <input type="text" class="form-control" id="txtTrabajador" name="txtTrabajador" placeholder="Nombre del trabajador">
                        </div>
                        <div class="form-group">
                            <label for="selCategoria">Categoría</label>
                            <select class="form-control" id="selCategoria" name="selCategoria">
                                <option value="Operario">Operario</option>
                                <option value="Administrativo">Administrativo</option>
                                <option value="Jefe">Jefe</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtHoras">Horas Trabajadas</label>
                            <input type="text" class="form-control" id="txtHoras" name="txtHoras" placeholder="Horas trabajadas">
                        </div>
                        <button type="submit" class="btn btn-primary" name="btnProcesar">PROCESAR</button>
                        <button type="button" class="btn btn-primary ml-2" id="btnMostrarDetalles">Mostrar Detalles</button>
                        <button type="button" class="btn btn-primary ml-2" id="btnMostrarPago">Mostrar Pagos</button>
                    </div>
                    <div class="col-md-6">
                        <img src="trabajador.png" class="img-fluid" alt="Trabajador" style="max-width: 200px;">
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php if (!empty($pagos)) : ?>
        <div class="container" id="tablaPagos">
            <div class="row mt-5">
                <div class="col-md-12">
                    <h2 class="text-center">Lista de Pagos</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Trabajador</th>
                                <th>Categoría</th>
                                <th>Horas Trabajadas</th>
                                <th>Costo por Hora</th>
                                <th>Salario Bruto</th>
                                <th>Descuento</th>
                                <th>Salario Neto</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pagos as $pago) : ?>
                                <tr>
                                    <td><?php echo $pago->getTrabajador(); ?></td>
                                    <td><?php echo $pago->getCategoria(); ?></td>
                                    <td><?php echo $pago->getHoras(); ?></td>
                                    <td>$<?php $costoHora = $pago->determinaCostoHora();
                                        echo number_format($costoHora, 2); ?></td>
                                    <td>$<?php $subtotal = $pago->calculaSubtotal();
                                        echo number_format($subtotal, 2); ?></td>
                                    <td>$<?php $descuento = $pago->calculaDescuento();
                                        echo number_format($descuento, 2); ?></td>
                                    <td>$<?php echo number_format($pago->calculaNeto(), 2); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary btn-editar" data-id="<?php echo $pago->getId(); ?>" data-fecha="<?php echo $pago->getFecha(); ?>" data-trabajador="<?php echo $pago->getTrabajador(); ?>" data-categoria="<?php echo $pago->getCategoria(); ?>" data-horas="<?php echo $pago->getHoras(); ?>">Editar</button>
                                    </td>
                                    <td>
                                        <a href="index.php?eliminar=<?php echo $pago->getId(); ?>" class="btn btn-sm btn-danger">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <footer class="text-center mt-5">Departamento de Contabilidad</footer>
</body>

</html>
