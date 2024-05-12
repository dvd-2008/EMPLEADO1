<?php

include 'conexion.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_trabajador = $_POST['id_trabajador'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

 
    $sql_insert = "INSERT INTO detalle_trabajador (id_trabajador, apellido, direccion, telefono) VALUES ('$id_trabajador', '$apellido', '$direccion', '$telefono')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "Detalle agregado correctamente";
    } else {
        echo "Error al agregar detalle: " . $conn->error;
    }
}


$sql_select_trabajadores = "SELECT id, nombre FROM trabajador";
$result_trabajadores = $conn->query($sql_select_trabajadores);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Trabajador</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
       
        <div class="modal fade" id="agregarDetalleModal" tabindex="-1" role="dialog" aria-labelledby="agregarDetalleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarDetalleModalLabel">Agregar Nuevo Detalle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label>Trabajador:</label>
                                <select class="form-control" name="id_trabajador" required>
                                    <?php
                                
                                    if ($result_trabajadores->num_rows > 0) {
                                        while($row = $result_trabajadores->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No hay trabajadores disponibles</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Apellido:</label>
                                <input type="text" class="form-control" name="apellido" required>
                            </div>
                            <div class="form-group">
                                <label>Dirección:</label>
                                <input type="text" class="form-control" name="direccion" required>
                            </div>
                            <div class="form-group">
                                <label>Teléfono:</label>
                                <input type="text" class="form-control" name="telefono" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Agregar Detalle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h2>Detalles del Trabajador</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Trabajador</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php
            
                $sql_select = "SELECT * FROM detalle_trabajador";
                $result = $conn->query($sql_select);

                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_trabajador'] . "</td>";
                        echo "<td>" . $row['apellido'] . "</td>";
                        echo "<td>" . $row['direccion'] . "</td>";
                        echo "<td>" . $row['telefono'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay detalles disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>

   
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarDetalleModal">
            Agregar Detalle
        </button>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
