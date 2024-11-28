-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2024 a las 15:51:31
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdcarritocompras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL,
  `cofecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idusuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `cofecha`, `idusuario`) VALUES
(1, '2024-11-18 15:43:52', 1),
(2, '2024-11-22 14:10:49', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraestado` (
  `idcompraestado` bigint(20) UNSIGNED NOT NULL,
  `idcompra` bigint(11) NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT current_timestamp(),
  `cefechafin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `compraestado`
--

INSERT INTO `compraestado` (`idcompraestado`, `idcompra`, `idcompraestadotipo`, `cefechaini`, `cefechafin`) VALUES
(1, 1, 1, '2024-11-18 15:43:53', '0000-00-00 00:00:00'),
(2, 2, 1, '2024-11-22 14:10:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'carrito', 'Items en el carrito'),
(2, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(3, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1'),
(4, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2'),
(5, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `compraitem`
--

INSERT INTO `compraitem` (`idcompraitem`, `idproducto`, `idcompra`, `cicantidad`) VALUES
(1, 0, 1, 10),
(2, 5, 1, 2),
(3, 3, 1, 1),
(4, 2, 1, 1),
(5, 5, 2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT current_timestamp() COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) VALUES
(1, 'Cliente', '#', NULL, NULL),
(2, 'Deposito', '#', NULL, NULL),
(3, 'Administrador', '#', NULL, NULL),
(4, 'Administrar usuarios', '../ABMUsuario/index.php', NULL, '0000-00-00 00:00:00'),
(5, 'Administrar menú', '../ABMMenu/index.php', NULL, '0000-00-00 00:00:00'),
(6, 'Cargar usuario', 'nuevoUsuario', 3, NULL),
(7, 'Cargar menú', 'nuevoMenu', 3, NULL),
(8, 'Administrar compras', '../ABMCompra/index.php', NULL, '0000-00-00 00:00:00'),
(9, 'Productos', '../ABMProducto/index.php', NULL, '0000-00-00 00:00:00'),
(10, 'Cargar productos', 'cargarProducto', 2, NULL),
(11, 'Carrito', '../Carrito/index.php', NULL, '0000-00-00 00:00:00'),
(12, 'Mis compras', 'historialCompras', 1, NULL),
(13, 'Mi perfil', '../Perfil/index.php', NULL, '0000-00-00 00:00:00'),
(14, 'Roles y Permisos', '../ABMRol/index.php', NULL, '0000-00-00 00:00:00'),
(15, 'Pago', '../pago/index.php', NULL, '0000-00-00 00:00:00'),
(16, 'Pedidos', '../Pedidos/index.php', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `menurol`
--

INSERT INTO `menurol` (`idmenu`, `idrol`) VALUES
(4, 1),
(5, 1),
(8, 1),
(8, 2),
(9, 2),
(11, 3),
(13, 1),
(13, 2),
(13, 3),
(14, 1),
(15, 3),
(16, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(100) NOT NULL,
  `pronombre` varchar(500) NOT NULL,
  `proartista` varchar(100) NOT NULL,
  `proprecio` int(100) NOT NULL,
  `prodetalle` varchar(1000) NOT NULL,
  `procantstock` int(100) NOT NULL,
  `protipo` varchar(20) NOT NULL,
  `prodeshabilitado` timestamp(6) NULL DEFAULT NULL,
  `proimg` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `pronombre`, `proartista`, `proprecio`, `prodetalle`, `procantstock`, `protipo`, `prodeshabilitado`, `proimg`) VALUES
(1, 'Discovery', 'Daft Punk', 7500, 'Géneros: French House. Duración: 60:50', 10, 'CD', NULL, '../assets/Discovery.webp'),
(2, 'Locura', 'Virus', 7000, 'Géneros: Synth Pop. Duración 34:00', 5, 'CD', NULL, '../assets/Locura.jpg'),
(3, 'Unlocked', 'Denzel Curry', 7000, 'Géneros: Hip Hop. Duración: 17:47', 3, 'CD', NULL, '../assets/Unlocked.jpg'),
(4, 'Demon Days', 'Gorillaz', 8000, 'Géneros: Rock Alternativo. Duración: 50:44', 9, 'CD', NULL, '../assets/Demon Days.jpg'),
(5, 'Serú Girán', 'Serú Girán', 6500, 'Géneros: Rock Progresivo. Duración: 32:21', 5, 'CD', NULL, '../assets/Serú Girán.jpg'),
(6, 'Blackstar', 'David Bowie', 40000, 'Géneros: Art Rock. Duración: 39:17', 2, 'Vinilo', NULL, '../assets/Blackstar.jpg'),
(7, 'Artaud', 'Pescado Rabioso', 45000, 'Géneros: Art Rock. Folk. Duración: 36:56', 4, 'Vinilo', NULL, '../assets/Artaud.jpg'),
(8, 'Close to the Edge', 'Yes', 48000, 'Géneros: Rock Progresivo. Duración: 37:47', 3, 'Vinilo', NULL, '../assets/Close to the Edge.jpg'),
(9, 'After Chabón', 'Sumo', 40000, 'Géneros: Post-Punk. Duración: 39:03', 4, 'Vinilo', NULL, '../assets/After Chabón.jpg'),
(10, 'To Pimp a Butterfly', 'Kendrick Lamar', 47000, 'Géneros: Jazz Rap. Duración: 78:51', 5, 'Vinilo', NULL, '../assets/To Pimp a Butterfly.jpg'),
(11, 'Stop Making Sense', 'Talking Heads', 25000, 'Géneros: Concierto. Duración: 88:00', 3, 'DVD', NULL, '../assets/Stop Making Sense.jpg'),
(12, 'Symphonic Live', 'Yes', 22000, 'Géneros: Progrock. Duración: 194:00.', 5, 'DVD', NULL, '../assets/Symphonic Live.jpg'),
(13, 'The Song Remains The Same', 'Led Zeppelin', 27000, 'Géneros: Hard Rock. Duración: 131:55', 2, 'DVD', NULL, '../assets/The Song Reamins the Same.jpg'),
(14, 'A Different Kind of Blue', 'Miles Davis', 15000, 'Géneros: Jazz Fusión. Duración: 127:00', 1, 'DVD', NULL, '../assets/A Different Kind of Blue.jpg'),
(15, 'The Wall', 'Pink Floyd', 17000, 'Géneros: Drama Musical. Duración: 95:00', 5, 'DVD', NULL, '../assets/The Wall.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `roldescripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `roldescripcion`) VALUES
(1, 'Administrador'),
(2, 'Depósito'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL,
  `usnombre` varchar(50) NOT NULL,
  `uspass` varchar(150) NOT NULL,
  `usmail` varchar(50) NOT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) VALUES
(0, 'Lolo', '6ebe76c9fb411be97b3b0d48b791a7c9', 'holalolo@gmail.com', '0000-00-00 00:00:00'),
(1, 'pepitocliente', 'b881f5beb1135cc00a4bd5186a9225fa', 'artimonkis@gmail.com', '0000-00-00 00:00:00'),
(2, 'empleadodeposito', '58c583ac2d31e73486f26dccdf560cea', 'eldeldeposito@gmail.com', '0000-00-00 00:00:00'),
(3, 'eladmin', '3f06664c98831fa9ef021349d486944c', 'admin@admin.com', '0000-00-00 00:00:00'),
(4, 'andres', 'cb3bae31bb1c443fbf3db8889055f2fe', 'andres@hotmail.com', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idusuario`, `idrol`) VALUES
(-1, 3),
(1, 3),
(2, 2),
(3, 1),
(4, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD UNIQUE KEY `idcompra` (`idcompra`),
  ADD KEY `fkcompra_1` (`idusuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idcompraestado`),
  ADD UNIQUE KEY `idcompraestado` (`idcompraestado`),
  ADD KEY `fkcompraestado_1` (`idcompra`),
  ADD KEY `fkcompraestado_2` (`idcompraestadotipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idcompraestadotipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idcompraitem`),
  ADD UNIQUE KEY `idcompraitem` (`idcompraitem`),
  ADD KEY `fkcompraitem_1` (`idcompra`),
  ADD KEY `fkcompraitem_2` (`idproducto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD UNIQUE KEY `idmenu` (`idmenu`),
  ADD KEY `fkmenu_1` (`idpadre`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idrol`),
  ADD KEY `fkmenurol_2` (`idrol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `idrol` (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  MODIFY `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  MODIFY `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
