<?php
class Pago {
    private $id;
    private $fecha='';
    private $trabajador='';
    private $categoria='';
    private $horas=0;

    public function __construct($id, $fecha, $trabajador, $categoria, $horas){
        $this->id = $id;
        $this->fecha = $fecha;
        $this->trabajador = $trabajador;
        $this->categoria = $categoria;
        $this->horas = $horas;
    }

    public function getId() {
        return $this->id;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getTrabajador(){
        return $this->trabajador;
    }

    public function getCategoria(){
        return $this->categoria;
    }

    public function getHoras(){
        return $this->horas;
    }

    public function actualizarEnBaseDatos($conn) {
        $sql = "UPDATE trabajador SET fecha=?, nombre=?, categoria=?, horas_trabajadas=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $this->fecha, $this->trabajador, $this->categoria, $this->horas, $this->id);
        $stmt->execute();
        $stmt->close();
    }

    public function eliminarDeBaseDatos($conn) {
        $sql = "DELETE FROM trabajador WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();
    }

    public function determinaCostoHora(){
        if ($this->categoria=='Operario')
            return 10;
        elseif ($this->categoria=='Administrativo')
            return 20;
        elseif ($this->categoria=='Jefe')
            return 40;
        else
            return 0;
    }

    public function calculaSubtotal(){
        return $this->determinaCostoHora()*$this->horas;
    }

    public function calculaDescuento(){
        $subtotal = $this->calculaSubtotal();
        if ($subtotal<1000)
            return 0.075*$subtotal;
        elseif ($subtotal<=2000)
            return 0.14*$subtotal;
        elseif ($subtotal>2000)
            return 0.20*$subtotal;
        else
            return 0;
    }

    public function calculaNeto(){
        return $this->calculaSubtotal()-$this->calculaDescuento();
    }

    public function guardarEnBaseDatos($conn) {
        $sql = "INSERT INTO Trabajador (nombre, fecha, categoria, horas_trabajadas, costo_por_hora, salario_bruto, descuento, salario_neto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $costoHora = $this->determinaCostoHora();
        $subtotal = $this->calculaSubtotal();
        $descuento = $this->calculaDescuento();
        $neto = $this->calculaNeto();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $this->trabajador, $this->fecha, $this->categoria, $this->horas, $costoHora, $subtotal, $descuento, $neto);
        $stmt->execute();
        $stmt->close();
    }

    public static function obtenerTodosDesdeBaseDatos($conn) {
        $sql = "SELECT * FROM Trabajador";
        $result = $conn->query($sql);
        $pagos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pago = new Pago($row['id'], $row['fecha'], $row['nombre'], $row['categoria'], $row['horas_trabajadas']);
                $pagos[] = $pago;
            }
        }
        return $pagos;
    }
}
?>
