<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div id="editarPagoModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarPagoForm" method="POST" action="editar_pago.php">
                    <input type="hidden" id="editarPagoId" name="editarPagoId">
                    <div class="form-group">
                        <label for="editarFecha">Fecha:</label>
                        <input type="text" class="form-control" id="editarFecha" name="editarFecha">
                    </div>
                    <div class="form-group">
                        <label for="editarTrabajador">Trabajador:</label>
                        <input type="text" class="form-control" id="editarTrabajador" name="editarTrabajador">
                    </div>
                    <div class="form-group">
                        <label for="editarCategoria">Categoría:</label>
                        <input type="text" class="form-control" id="editarCategoria" name="editarCategoria">
                    </div>
                    <div class="form-group">
                        <label for="editarHoras">Horas Trabajadas:</label>
                        <input type="text" class="form-control" id="editarHoras" name="editarHoras">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <script>
        // Función para abrir el modal y cargar los datos del pago a editar
        function abrirModalEditar(id, fecha, trabajador, categoria, horas) {
            $("#editarPagoId").val(id);
            $("#editarFecha").val(fecha);
            $("#editarTrabajador").val(trabajador);
            $("#editarCategoria").val(categoria);
            $("#editarHoras").val(horas);
            $("#editarPagoModal").modal("show");
        }

        // Asignar evento clic a los botones de editar para abrir el modal
        $(document).ready(function() {
            $(".btn-editar").click(function() {
                var id = $(this).data("id");
                var fecha = $(this).data("fecha");
                var trabajador = $(this).data("trabajador");
                var categoria = $(this).data("categoria");
                var horas = $(this).data("horas");
                abrirModalEditar(id, fecha, trabajador, categoria, horas);
            });
        });
    </script>