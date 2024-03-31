-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2024 a las 00:29:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `appointments_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `reason` varchar(45) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `appointment`
--

INSERT INTO `appointment` (`id`, `date`, `duration`, `reason`, `doctor_id`, `status_id`, `user_id`) VALUES
(1, '2024-03-18 09:30:00', 30, 'consultation', 1, 4, 1),
(2, '2024-03-28 16:00:00', 30, 'operation', 4, 4, 1),
(3, '2024-03-20 15:00:00', 30, 'consultation', 3, 4, 1),
(4, '2024-03-18 16:00:00', 30, 'consultation', 1, 4, 1),
(5, '2024-03-27 10:00:00', 30, 'consultation', 1, 4, 1),
(6, '2024-03-28 10:30:00', 30, 'consultation', 3, 4, 1),
(7, '2024-03-20 08:00:00', 30, 'consultation', 3, 4, 1),
(8, '2024-03-30 16:30:00', 30, 'consultation', 1, 4, 1),
(9, '2024-03-28 14:30:00', 30, 'consultation', 3, 4, 2),
(10, '2024-03-30 16:30:00', 90, 'skin care', 5, 4, 4),
(11, '2024-03-29 18:30:00', 90, 'session', 1, 4, 4),
(12, '2024-03-29 18:30:00', 90, 'session', 1, 4, 4),
(13, '2024-03-29 14:00:00', 60, 'operation', 3, 4, 4),
(14, '2024-03-29 09:30:00', 120, 'long session', 1, 4, 1),
(15, '2024-03-29 09:30:00', 30, 'short session', 1, 2, 4),
(16, '2024-03-27 12:00:00', 30, 'consultation', 4, 2, 4),
(17, '2024-03-27 16:00:00', 60, 'long talk', 5, 4, 1),
(18, '2024-03-31 12:00:00', 30, 'consultation', 4, 2, 1),
(19, '2024-03-24 09:30:00', 30, 'consultation', 1, 4, 1),
(20, '2024-03-24 13:30:00', 30, 'something', 5, 4, 4),
(21, '2024-03-24 12:00:00', 30, 'consultation', 3, 4, 1),
(22, '2024-03-30 08:30:00', 30, 'consultation', 3, 4, 1),
(23, '2024-03-31 17:00:00', 90, 'Skin exam', 5, 2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `specialization_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`id`, `fullname`, `image`, `start_time`, `end_time`, `specialization_id`, `hospital_id`) VALUES
(1, 'Francisco Leia', 'therapist.jpg', '09:30:00', '19:30:00', 1, 1),
(3, 'Vanesa Rio', 'cardiology.jpeg', '07:00:00', '15:00:00', 4, 1),
(4, 'Joseph Garrison', 'dentist.jpeg', '07:00:00', '15:00:00', 3, 5),
(5, 'Catalina Jones', 'dermatology.jpeg', '13:30:00', '23:00:00', 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospital`
--

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `address` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hospital`
--

INSERT INTO `hospital` (`id`, `name`, `address`) VALUES
(1, '25th May Hospital', 'There 123'),
(2, 'Central Hospital', 'Here 321'),
(3, 'Belgrano', 'Av. Independence'),
(4, 'Healthy Hospital', 'July 11th 8492'),
(5, 'TakeCare', 'Guarani 294'),
(6, 'Thema', 'Washington 242'),
(8, 'Guard', 'Coast Street 829');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'USER'),
(2, 'ADMIN'),
(3, 'SUPER_ADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `specialization`
--

CREATE TABLE `specialization` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `specialization`
--

INSERT INTO `specialization` (`id`, `name`) VALUES
(1, 'therapist'),
(2, 'pediatrician'),
(3, 'dentist'),
(4, 'cardiology'),
(5, 'dermatology');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `name`, `image`) VALUES
(1, 'to be confirmed', 'status-to-be-confirmed.png'),
(2, 'completed', 'status-completed.png'),
(3, 'confirmed', 'status-confirmed.png'),
(4, 'cancelled', 'status-cancelled.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `image`, `role_id`) VALUES
(1, 'Eze', 'eze@gmail.com', '$2y$10$z2hE6rTZqceZh/0vY./i0.jm34WtswEFRf.VbLsorcS5JahfOPz0S', 'person.jpg', 1),
(2, 'Admin', 'admin@gmail.com', '$2y$10$ph6Im4dyGzNm3nrpiOc3HOAU9v7V.jVeNlahbuY7UA3P3QAZ1ciJW', 'robot.png', 2),
(3, 'Super Admin', 'superadmin@gmail.com', '$2y$10$gmtN3daDelxsvJyjJT/sfehonrlSfIFIB80PRYJlrnCAAdrE9UBfm', 'roboticon.jpg', 3),
(4, 'Mati', 'mati@gmail.com', '$2y$10$CtF1Pz7jjii1Da6ZPqTlte764tNPGpVJ1hZOqoamWV0fG49DhBJi6', 'person2.jpg', 1),
(5, 'Ale', 'ale@gmail.com', '$2y$10$XhjPslyHbeo5IZzD/y4uAOfL4WXgJh4Um/VsB5sk/Nn6jrayUriGi', 'default.jpg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctor_appointment` (`doctor_id`) USING BTREE,
  ADD KEY `fk_status_appointment` (`status_id`) USING BTREE,
  ADD KEY `fk_user_appointment` (`user_id`) USING BTREE;

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_specialization_doctor` (`specialization_id`) USING BTREE,
  ADD KEY `fk_hospital_doctor` (`hospital_id`) USING BTREE;

--
-- Indices de la tabla `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_user` (`role_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `specialization`
--
ALTER TABLE `specialization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`id`),
  ADD CONSTRAINT `doctor_ibfk_2` FOREIGN KEY (`specialization_id`) REFERENCES `specialization` (`id`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
