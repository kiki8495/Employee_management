-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 04:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `empresa`
--

-- --------------------------------------------------------

--
-- Table structure for table `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estado` enum('Marcó a tiempo','Marcó con retraso','No marcó turno') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asistencias`
--

INSERT INTO `asistencias` (`id`, `empleado_id`, `fecha`, `hora`, `estado`) VALUES
(1, 1, '2024-09-23', '08:15:00', 'Marcó a tiempo'),
(2, 1, '2024-09-24', '09:25:00', 'Marcó con retraso'),
(11, 1, '2024-09-25', '22:11:16', 'Marcó con retraso'),
(13, 1, '2024-09-26', '08:02:07', 'Marcó a tiempo'),
(14, 2, '2024-09-26', '11:49:56', 'Marcó con retraso'),
(15, 2, '2024-09-25', NULL, 'No marcó turno');

-- --------------------------------------------------------

--
-- Table structure for table `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `fecha_contrato` date DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empleados`
--

INSERT INTO `empleados` (`id`, `imagen`, `nombre`, `departamento`, `cargo`, `fecha_contrato`, `salario`, `cedula`, `fecha_nacimiento`, `correo`, `contrasena`, `direccion`) VALUES
(1, '/wwwroot/uploads/user-avatar.png', 'Cristhian Morales', 'Ventas', 'Vendedor', '2024-01-15', 1230000.00, '123456789', '2002-12-17', 'cristhian_mora@email.com', 'contraseña123', 'Calle 19B sur #16-67'),
(2, '/wwwroot/uploads/marcela_ramos.jpeg', 'Marcela Ramos', 'Recursos Humanos', 'Gerente de RRHH', '2022-05-15', 230200.50, '1122334455', '1985-08-12', 'marcela.ramos@empresa.com', '123', 'Carrera 48 #8-9');

-- --------------------------------------------------------

--
-- Table structure for table `nomina`
--

CREATE TABLE `nomina` (
  `id` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `mes` int(11) DEFAULT NULL CHECK (`mes` >= 1 and `mes` <= 12),
  `anio` int(11) DEFAULT NULL,
  `archivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nomina`
--

INSERT INTO `nomina` (`id`, `id_empleado`, `mes`, `anio`, `archivo`) VALUES
(1, 1, 8, 2024, '/wwwroot/uploads/nominas/01_08_2024.pdf'),
(2, 1, 9, 2024, '/wwwroot/uploads/nominas/01_09_2024.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `mes` int(20) NOT NULL,
  `anio` int(11) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id`, `mes`, `anio`, `archivo`) VALUES
(1, 8, 2024, '/wwwroot/uploads/ventas/082024.pdf'),
(2, 9, 2024, '/wwwroot/uploads/ventas/092024.pdf'),
(3, 10, 2024, '/wwwroot/uploads/ventas/102024.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indexes for table `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomina`
--
ALTER TABLE `nomina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nomina`
--
ALTER TABLE `nomina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nomina`
--
ALTER TABLE `nomina`
  ADD CONSTRAINT `nomina_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
