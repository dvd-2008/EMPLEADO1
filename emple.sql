-- Creación de la tabla `trabajador`
CREATE TABLE `trabajador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `horas_trabajadas` float NOT NULL,
  `costo_por_hora` float NOT NULL,
  `salario_bruto` float NOT NULL,
  `descuento` float NOT NULL,
  `salario_neto` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `trabajador`
INSERT INTO `trabajador` (`nombre`, `fecha`, `categoria`, `horas_trabajadas`, `costo_por_hora`, `salario_bruto`, `descuento`, `salario_neto`) VALUES
('juan', '2024-04-10', 'Operario', 12, 10, 120, 9, 111),
('juan', '2024-04-10', 'Administrativo', 12, 20, 240, 18, 222),
('jhon', '2024-04-10', 'Jefe', 12, 40, 480, 36, 444),
('david', '2024-04-10', 'Administrativo', 30, 20, 600, 45, 555);

-- Creación de la tabla `detalle_trabajador`
CREATE TABLE `detalle_trabajador` (
  `id_trabajador` int(11) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  PRIMARY KEY (`id_trabajador`),
  FOREIGN KEY (`id_trabajador`) REFERENCES `trabajador` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
