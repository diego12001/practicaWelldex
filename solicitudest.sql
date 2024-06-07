-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2024 a las 23:43:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `solicitudest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aduana`
--

CREATE TABLE `aduana` (
  `ID_Ad` int(11) NOT NULL,
  `Estado_Ad` varchar(100) NOT NULL,
  `Ubicacion_Ad` varchar(200) NOT NULL,
  `Telefono_Ad` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aduana`
--

INSERT INTO `aduana` (`ID_Ad`, `Estado_Ad`, `Ubicacion_Ad`, `Telefono_Ad`) VALUES
(1, 'Guerrero', 'Guerrero,Guerrero', '6667778889'),
(2, 'Sonora', 'Agua Prieta, Sonora', '0000000000'),
(43, 'Veracruz', 'Avenida 6 Calle 18', '2293389229');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cli` int(11) NOT NULL,
  `Nombre_Cli` varchar(100) NOT NULL,
  `Telefono_Cli` char(10) NOT NULL,
  `Correo_Cli` varchar(100) NOT NULL,
  `Estado_Cli` varchar(100) NOT NULL,
  `Ubicacion_Cli` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cli`, `Nombre_Cli`, `Telefono_Cli`, `Correo_Cli`, `Estado_Cli`, `Ubicacion_Cli`) VALUES
(1, 'Juan Pérez Gómez', '2717027491', 'perez@gmail.com', 'Veracruz', 'Avenida 6 Calle 18'),
(2, 'Aaron Lopez Simon', '2291104815', 'aaron@gmail.com', 'Veracruz', 'Torrentes'),
(3, 'Diego Nava Taguada', '2717027491', 'diego@gmail.com', 'Veracruz', 'Avenida 6 Calle 18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenedoressoli`
--

CREATE TABLE `contenedoressoli` (
  `ID_ConSol` int(11) NOT NULL,
  `ID_Solicitud` int(11) DEFAULT NULL,
  `Serie_Contenedor` varchar(30) DEFAULT NULL,
  `ID_TipoC` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contenedoressoli`
--

INSERT INTO `contenedoressoli` (`ID_ConSol`, `ID_Solicitud`, `Serie_Contenedor`, `ID_TipoC`) VALUES
(1, 2, 'W111-222', 1),
(2, 2, 'W111-223', 3),
(4, 5, 'C111-222', 3),
(5, 5, 'C111-223', 2),
(6, 6, 'J111-222', 4),
(7, 6, 'J111-223', 1),
(8, 7, 'W111-333', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `ID_Estado` int(11) NOT NULL,
  `Nombre_Estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`ID_Estado`, `Nombre_Estado`) VALUES
(1, 'Alta de Solicitud de Transporte'),
(2, 'Solicitud de Transporte Emitida'),
(3, 'Solicitud de Transporte Aceptada'),
(4, 'Embarcado'),
(5, 'En Trayecto'),
(6, 'En Espera para Descargo'),
(7, 'En Descargo'),
(8, 'Descargada'),
(9, 'Liberada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `importador`
--

CREATE TABLE `importador` (
  `ID_Imp` int(11) NOT NULL,
  `Empresa_Imp` varchar(100) NOT NULL,
  `Operador_Imp` varchar(100) NOT NULL,
  `Telefono_Imp` char(10) NOT NULL,
  `Correo_Imp` varchar(100) NOT NULL,
  `Pais_Imp` varchar(100) NOT NULL,
  `Ubicacion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `importador`
--

INSERT INTO `importador` (`ID_Imp`, `Empresa_Imp`, `Operador_Imp`, `Telefono_Imp`, `Correo_Imp`, `Pais_Imp`, `Ubicacion`) VALUES
(1, 'Amazon', 'Diego Nava Taguada', '2222222222', 'info@empresa.com', 'Estados Unidos', 'Avenida 6 Calle 18'),
(2, 'FEDEX', 'Victor Guzman Casanova', '2223334441', 'victor@gmail.com', 'Rusia', 'Avenida 6 Calle 50'),
(3, 'Google', 'José Augusto', '1111111112', 'jose@gmail.com', 'Brasil', 'Avenida 6 Calle 18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mercancia`
--

CREATE TABLE `mercancia` (
  `ID_Merc` int(11) NOT NULL,
  `Nombre_Merc` varchar(100) NOT NULL,
  `Marca_Merc` varchar(100) NOT NULL,
  `Peso_Merc` decimal(10,2) NOT NULL,
  `Volumen_Merc` decimal(10,2) NOT NULL,
  `Dimensiones_Merc` varchar(10) NOT NULL,
  `ID_TipoM` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mercancia`
--

INSERT INTO `mercancia` (`ID_Merc`, `Nombre_Merc`, `Marca_Merc`, `Peso_Merc`, `Volumen_Merc`, `Dimensiones_Merc`, `ID_TipoM`) VALUES
(1, 'Cereal', 'Zucaritas', 1000.00, 100.00, '10', 2),
(2, 'Maíz', 'Maizon', 1000.00, 1000.00, '100', 1),
(3, 'Jamon', 'FUD', 100.00, 10.00, '100', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion`
--

CREATE TABLE `operacion` (
  `Referencia` varchar(10) NOT NULL,
  `Pedimento` varchar(20) NOT NULL,
  `ID_Imp` int(11) NOT NULL,
  `ID_Cli` int(11) NOT NULL,
  `ID_Ad` int(11) NOT NULL,
  `Fecha_Salida` date NOT NULL,
  `Fecha_Entrega` date NOT NULL,
  `ID_Merc` int(11) NOT NULL,
  `ID_Pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operacion`
--

INSERT INTO `operacion` (`Referencia`, `Pedimento`, `ID_Imp`, `ID_Cli`, `ID_Ad`, `Fecha_Salida`, `Fecha_Entrega`, `ID_Merc`, `ID_Pago`) VALUES
('1620024-00', '104', 1, 1, 43, '2024-06-08', '2024-06-29', 1, 1),
('1620024-01', '104', 1, 1, 43, '2024-06-20', '2024-06-27', 2, 2),
('1620024-05', '105', 2, 2, 43, '2024-06-15', '2024-06-30', 1, 2),
('1620024-10', '110', 2, 3, 43, '2024-06-21', '2024-06-29', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `ID_Respuesta` int(11) NOT NULL,
  `ID_Solicitud` int(11) NOT NULL,
  `Matricula` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`ID_Respuesta`, `ID_Solicitud`, `Matricula`) VALUES
(1, 2, 'ABCDE12344'),
(2, 2, 'ABCDE12345'),
(5, 3, 'ABCDE12344'),
(7, 5, 'ABCDE12346'),
(8, 6, 'ABCDE12344'),
(9, 6, 'ABCDE12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `ID_Solicitud` int(11) NOT NULL,
  `Referencia` varchar(10) DEFAULT NULL,
  `ID_Transp` int(11) NOT NULL,
  `ID_Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`ID_Solicitud`, `Referencia`, `ID_Transp`, `ID_Estado`) VALUES
(2, '1620024-00', 1, 4),
(3, '1620024-01', 1, 5),
(5, '1620024-05', 2, 4),
(6, '1620024-10', 1, 9),
(7, '1620024-10', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontenedor`
--

CREATE TABLE `tipocontenedor` (
  `ID_TipoC` int(11) NOT NULL,
  `Descripcion_Cont` varchar(100) DEFAULT NULL,
  `Dimension_Cont` varchar(100) DEFAULT NULL,
  `Categoria_Cont` varchar(100) DEFAULT NULL,
  `Inicial_Cont` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipocontenedor`
--

INSERT INTO `tipocontenedor` (`ID_TipoC`, `Descripcion_Cont`, `Dimension_Cont`, `Categoria_Cont`, `Inicial_Cont`) VALUES
(1, 'CONTENEDOR ESTANDAR 20', '20', 'ESTANDAR', 'DC20'),
(2, 'CONTENEDOR ESTANDAR 40', '40', 'ESTANDAR', 'DC40'),
(3, 'CONTENEDOR DE CUBO ALTO 40', '20', 'HIGH CUBE', 'HC20'),
(4, 'CONTENEDOR TAPA DURA 20', '20', 'HARD TOP', 'HT20'),
(6, 'CONTENEDOR TAPA DURA 40', '20', 'HARD TOP', 'HT40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomercancia`
--

CREATE TABLE `tipomercancia` (
  `ID_TipoM` int(11) NOT NULL,
  `TipoM` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipomercancia`
--

INSERT INTO `tipomercancia` (`ID_TipoM`, `TipoM`) VALUES
(1, 'Carga Suelta'),
(2, 'Contenedores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopago`
--

CREATE TABLE `tipopago` (
  `ID_Pago` int(11) NOT NULL,
  `Pago` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipopago`
--

INSERT INTO `tipopago` (`ID_Pago`, `Pago`) VALUES
(1, 'Virtual'),
(2, 'Efectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transporte`
--

CREATE TABLE `transporte` (
  `Matricula` varchar(50) NOT NULL,
  `Color_Transporte` varchar(30) NOT NULL,
  `Tipo_Transporte` varchar(50) NOT NULL,
  `Marca_Transporte` varchar(50) NOT NULL,
  `Limite_Contenedores` int(11) NOT NULL,
  `Peso_Limite` decimal(10,2) NOT NULL,
  `ID_Transp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transporte`
--

INSERT INTO `transporte` (`Matricula`, `Color_Transporte`, `Tipo_Transporte`, `Marca_Transporte`, `Limite_Contenedores`, `Peso_Limite`, `ID_Transp`) VALUES
('ABCDE12344', 'Rojo', 'Plano', 'DODGE', 2, 5000.00, 1),
('ABCDE12345', 'Blanco', 'Plano', 'Toyota', 1, 10000.00, 1),
('ABCDE12346', 'Negro', 'Plano', 'Toyota', 1, 6000.00, 2),
('ABCDE12347', 'Negro', 'Plano', 'BMW', 2, 6000.00, 2),
('ABCDE12350', 'Gris', 'Plana', 'DODGE', 2, 1000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportista`
--

CREATE TABLE `transportista` (
  `ID_Transp` int(11) NOT NULL,
  `Empresa_Transp` varchar(100) NOT NULL,
  `Telefono_Transp` char(10) NOT NULL,
  `Correo_Transp` varchar(100) NOT NULL,
  `Estado_Transp` varchar(100) NOT NULL,
  `Ubicacion_Transp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transportista`
--

INSERT INTO `transportista` (`ID_Transp`, `Empresa_Transp`, `Telefono_Transp`, `Correo_Transp`, `Estado_Transp`, `Ubicacion_Transp`) VALUES
(1, 'Welldex', '1111111111', 'welldex@gmail.com', 'Veracruz', 'Avenida 6 Calle 18'),
(2, 'CC', '1112223335', 'info@empresa.com', 'Veracruz', 'Avenida Galeana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Usuario` varchar(40) DEFAULT NULL,
  `Passwd` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Usuario`, `Passwd`) VALUES
(1, 'admin', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aduana`
--
ALTER TABLE `aduana`
  ADD PRIMARY KEY (`ID_Ad`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cli`);

--
-- Indices de la tabla `contenedoressoli`
--
ALTER TABLE `contenedoressoli`
  ADD PRIMARY KEY (`ID_ConSol`),
  ADD KEY `ID_Solicitud` (`ID_Solicitud`),
  ADD KEY `ID_TipoC` (`ID_TipoC`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`ID_Estado`);

--
-- Indices de la tabla `importador`
--
ALTER TABLE `importador`
  ADD PRIMARY KEY (`ID_Imp`);

--
-- Indices de la tabla `mercancia`
--
ALTER TABLE `mercancia`
  ADD PRIMARY KEY (`ID_Merc`),
  ADD KEY `ID_TipoM` (`ID_TipoM`);

--
-- Indices de la tabla `operacion`
--
ALTER TABLE `operacion`
  ADD PRIMARY KEY (`Referencia`),
  ADD KEY `ID_Imp` (`ID_Imp`),
  ADD KEY `ID_Cli` (`ID_Cli`),
  ADD KEY `ID_Merc` (`ID_Merc`),
  ADD KEY `ID_Pago` (`ID_Pago`),
  ADD KEY `ID_Ad` (`ID_Ad`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`ID_Respuesta`),
  ADD KEY `Matricula` (`Matricula`),
  ADD KEY `ID_Solicitud` (`ID_Solicitud`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`ID_Solicitud`),
  ADD KEY `ID_Estado` (`ID_Estado`),
  ADD KEY `Referencia` (`Referencia`),
  ADD KEY `ID_Transp` (`ID_Transp`);

--
-- Indices de la tabla `tipocontenedor`
--
ALTER TABLE `tipocontenedor`
  ADD PRIMARY KEY (`ID_TipoC`);

--
-- Indices de la tabla `tipomercancia`
--
ALTER TABLE `tipomercancia`
  ADD PRIMARY KEY (`ID_TipoM`);

--
-- Indices de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  ADD PRIMARY KEY (`ID_Pago`);

--
-- Indices de la tabla `transporte`
--
ALTER TABLE `transporte`
  ADD PRIMARY KEY (`Matricula`),
  ADD KEY `ID_Transp` (`ID_Transp`);

--
-- Indices de la tabla `transportista`
--
ALTER TABLE `transportista`
  ADD PRIMARY KEY (`ID_Transp`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contenedoressoli`
--
ALTER TABLE `contenedoressoli`
  MODIFY `ID_ConSol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `ID_Estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `importador`
--
ALTER TABLE `importador`
  MODIFY `ID_Imp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mercancia`
--
ALTER TABLE `mercancia`
  MODIFY `ID_Merc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `ID_Respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `ID_Solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipocontenedor`
--
ALTER TABLE `tipocontenedor`
  MODIFY `ID_TipoC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipomercancia`
--
ALTER TABLE `tipomercancia`
  MODIFY `ID_TipoM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  MODIFY `ID_Pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transportista`
--
ALTER TABLE `transportista`
  MODIFY `ID_Transp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contenedoressoli`
--
ALTER TABLE `contenedoressoli`
  ADD CONSTRAINT `contenedoressoli_ibfk_1` FOREIGN KEY (`ID_Solicitud`) REFERENCES `solicitud` (`ID_Solicitud`),
  ADD CONSTRAINT `contenedoressoli_ibfk_2` FOREIGN KEY (`ID_TipoC`) REFERENCES `tipocontenedor` (`ID_TipoC`);

--
-- Filtros para la tabla `mercancia`
--
ALTER TABLE `mercancia`
  ADD CONSTRAINT `mercancia_ibfk_1` FOREIGN KEY (`ID_TipoM`) REFERENCES `tipomercancia` (`ID_TipoM`);

--
-- Filtros para la tabla `operacion`
--
ALTER TABLE `operacion`
  ADD CONSTRAINT `operacion_ibfk_1` FOREIGN KEY (`ID_Imp`) REFERENCES `importador` (`ID_Imp`),
  ADD CONSTRAINT `operacion_ibfk_2` FOREIGN KEY (`ID_Cli`) REFERENCES `cliente` (`ID_Cli`),
  ADD CONSTRAINT `operacion_ibfk_3` FOREIGN KEY (`ID_Merc`) REFERENCES `mercancia` (`ID_Merc`),
  ADD CONSTRAINT `operacion_ibfk_4` FOREIGN KEY (`ID_Pago`) REFERENCES `tipopago` (`ID_Pago`),
  ADD CONSTRAINT `operacion_ibfk_5` FOREIGN KEY (`ID_Ad`) REFERENCES `aduana` (`ID_Ad`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`Matricula`) REFERENCES `transporte` (`Matricula`),
  ADD CONSTRAINT `respuesta_ibfk_2` FOREIGN KEY (`ID_Solicitud`) REFERENCES `solicitud` (`ID_Solicitud`);

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`ID_Estado`) REFERENCES `estado` (`ID_Estado`),
  ADD CONSTRAINT `solicitud_ibfk_2` FOREIGN KEY (`Referencia`) REFERENCES `operacion` (`Referencia`),
  ADD CONSTRAINT `solicitud_ibfk_3` FOREIGN KEY (`ID_Transp`) REFERENCES `transportista` (`ID_Transp`);

--
-- Filtros para la tabla `transporte`
--
ALTER TABLE `transporte`
  ADD CONSTRAINT `transporte_ibfk_1` FOREIGN KEY (`ID_Transp`) REFERENCES `transportista` (`ID_Transp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
