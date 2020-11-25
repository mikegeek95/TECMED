/*
 Navicat Premium Data Transfer

 Source Server         : LOCALHOST
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : capshop

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 24/11/2020 21:14:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners`  (
  `idbanners` int(11) NOT NULL AUTO_INCREMENT,
  `imagen` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1 COMMENT '0 - desactivo\n1 - activo\n',
  `titulo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatustexto` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Mostrar titulo y descripcion\n1 - quitar titulo y descripcion',
  `t_banner` int(11) NOT NULL DEFAULT 0 COMMENT '0 - pagina web\n1 - app',
  PRIMARY KEY (`idbanners`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bitacora
-- ----------------------------
DROP TABLE IF EXISTS `bitacora`;
CREATE TABLE `bitacora`  (
  `idbitacora` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `direccion_ip` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sistema_operativo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `navegador` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_ingreso` datetime(0) NOT NULL,
  PRIMARY KEY (`idbitacora`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3527 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bitacora_movimientos
-- ----------------------------
DROP TABLE IF EXISTS `bitacora_movimientos`;
CREATE TABLE `bitacora_movimientos`  (
  `idbitacora_movimientos` int(11) NOT NULL AUTO_INCREMENT,
  `idbitacora` int(11) NOT NULL,
  `modulo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_movimiento` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idbitacora_movimientos`) USING BTREE,
  INDEX `fk_bitacora_movimientos_bitacora1`(`idbitacora`) USING BTREE,
  CONSTRAINT `bitacora_movimientos_ibfk_1` FOREIGN KEY (`idbitacora`) REFERENCES `bitacora` (`idbitacora`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11090 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog`  (
  `idblog` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `imagen` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idblog`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for categoria_precio
-- ----------------------------
DROP TABLE IF EXISTS `categoria_precio`;
CREATE TABLE `categoria_precio`  (
  `idcategoria_precio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1 COMMENT '0 - desactivado\n1- activado\n',
  PRIMARY KEY (`idcategoria_precio`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for categoria_precios_niveles
-- ----------------------------
DROP TABLE IF EXISTS `categoria_precios_niveles`;
CREATE TABLE `categoria_precios_niveles`  (
  `idcategoria_precio` int(11) NOT NULL,
  `idniveles` int(11) NOT NULL,
  `descuento` int(3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idcategoria_precio`, `idniveles`) USING BTREE,
  INDEX `fk_categoria_precios_niveles_categoria_precio1_idx`(`idcategoria_precio`) USING BTREE,
  INDEX `fk_categoria_precios_niveles_niveles1_idx`(`idniveles`) USING BTREE,
  CONSTRAINT `categoria_precios_niveles_ibfk_1` FOREIGN KEY (`idcategoria_precio`) REFERENCES `categoria_precio` (`idcategoria_precio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `categoria_precios_niveles_ibfk_2` FOREIGN KEY (`idniveles`) REFERENCES `niveles` (`idniveles`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias`  (
  `idcategoria` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0-desactivado\n1-activo',
  `nivel` int(11) NOT NULL,
  PRIMARY KEY (`idcategoria`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `idcliente` int(10) NOT NULL AUTO_INCREMENT,
  `idniveles` int(11) NOT NULL,
  `no_tarjeta` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'SI EL NEGOCIO UTILIZA UN NO. DE TARJETA PARA EL SISTEMA DE LEALTAD\n',
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `paterno` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `materno` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `f_nacimiento` date NULL DEFAULT '1900-12-12',
  `sexo` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'H' COMMENT 'H - HOMBRE\nM - MUJER',
  `direccion` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telefono` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fax` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fis_razonsocial` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Razon Social',
  `fis_rfc` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'RFC',
  `fis_direccion` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Direccion Fiscal',
  `fis_no_int` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'No. Interior Fiscal',
  `fis_no_ext` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'No. Exterior Fiscal',
  `fis_col` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Colonia Fiscal',
  `fis_ciudad` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Ciudad Fiscal',
  `fis_estado` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Estado Fiscal',
  `fis_CP` int(11) NULL DEFAULT NULL COMMENT 'Codigo Postal Fiscal',
  `estatus` int(11) NOT NULL,
  `md5_clave` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idcliente`) USING BTREE,
  INDEX `fk_clientes_niveles1_idx`(`idniveles`) USING BTREE,
  CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`idniveles`) REFERENCES `niveles` (`idniveles`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4136 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for compra_detalle
-- ----------------------------
DROP TABLE IF EXISTS `compra_detalle`;
CREATE TABLE `compra_detalle`  (
  `idcompras` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL COMMENT 'CANTIDAD DEL PRODUCTO A COMPRAR\n',
  `costo` float(12, 2) NULL DEFAULT 0 COMMENT 'Seria actualización cuando se agregue el detalle de la compra con factura aumentamos el costo del producto.',
  `estatus` int(11) NOT NULL DEFAULT 0 COMMENT '0 - activa\n1 - cancelada\n',
  INDEX `fk_compra_detalle_compras1_idx`(`idcompras`) USING BTREE,
  INDEX `fk_compra_detalle_productos1_idx`(`idproducto`) USING BTREE,
  CONSTRAINT `compra_detalle_ibfk_1` FOREIGN KEY (`idcompras`) REFERENCES `compras` (`idcompras`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compra_detalle_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for compras
-- ----------------------------
DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras`  (
  `idcompras` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0) COMMENT 'FECHA EN QUE SE CREA LA ORDEN DE COMPRA',
  `fecha_compra` date NULL DEFAULT NULL COMMENT 'fecha en que realizan la compra\n',
  `prioridad` int(11) NULL DEFAULT NULL COMMENT '0 - normal\n1 - urgente\n2 - alta\n',
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `estatus` int(11) NULL DEFAULT 0 COMMENT '0 - activo\n1 - cancelado\n2 -  comprado\n\n',
  `idsucursales` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idcompras`) USING BTREE,
  INDEX `fk_compras_usuarios1_idx`(`idusuarios`) USING BTREE,
  INDEX `sucuralescompras`(`idsucursales`) USING BTREE,
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sucuralescompras` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for compras_detalles_fact
-- ----------------------------
DROP TABLE IF EXISTS `compras_detalles_fact`;
CREATE TABLE `compras_detalles_fact`  (
  `idcompras` int(11) NOT NULL,
  `idproveedores` int(11) NOT NULL,
  `no_factura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cantidad` float(12, 2) NULL DEFAULT NULL,
  INDEX `fk_compras_detalles_fact_compras1_idx`(`idcompras`) USING BTREE,
  INDEX `fk_compras_detalles_fact_proveedores1_idx`(`idproveedores`) USING BTREE,
  CONSTRAINT `compras_detalles_fact_ibfk_1` FOREIGN KEY (`idcompras`) REFERENCES `compras` (`idcompras`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compras_detalles_fact_ibfk_2` FOREIGN KEY (`idproveedores`) REFERENCES `proveedores` (`idproveedores`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for configuracion
-- ----------------------------
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion`  (
  `idconfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `telefonos` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `razon_social` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `rfc` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `direccion_fiscal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `no_int_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `no_ext_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ciudad_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `colonia_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cp_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cuentasbancarias` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `moneda` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `iva` int(11) NOT NULL DEFAULT 0,
  `t_descuento` int(11) NOT NULL DEFAULT 0 COMMENT '0 - por producto.\n1 - por paquete.\n3 - combinado.\n',
  `logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'logoempresa.png',
  `e_smtp` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'servidor saliente de email',
  `e_psaliente` int(11) NULL DEFAULT NULL COMMENT 'Puerto Saliente\n',
  `e_pop` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'servidor entrante de emails',
  `e_pentrante` int(11) NULL DEFAULT NULL COMMENT 'Puerto Entrante\n',
  `e_cuenta` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'cuenta de email',
  `e_clave` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'clave del email',
  `e_ss` int(11) NULL DEFAULT 0 COMMENT 'Servidor Seguro?\n\n0 - no\n1 - si\n',
  `e_autentication` int(11) NULL DEFAULT 0 COMMENT '0 - no\n1- si\n',
  `e_verificado` int(11) NULL DEFAULT 0 COMMENT '0 - no\n1 - si',
  `clave_caja` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'clave de la caja para hacer descuentos directos\n',
  `porc_comision` int(11) NULL DEFAULT 0,
  `notas_print` int(1) NULL DEFAULT 0 COMMENT '0 - CARTA\n1 - TERMICO',
  `email_pedido` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `horario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `facebook` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `instagram` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `youtube` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `twitter` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idconfiguracion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for corte
-- ----------------------------
DROP TABLE IF EXISTS `corte`;
CREATE TABLE `corte`  (
  `idcorte` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `idsucursales` int(11) NOT NULL,
  `f_inicio` date NULL DEFAULT NULL,
  `h_inicio` time(0) NULL DEFAULT NULL,
  `cajachica` float(10, 2) NULL DEFAULT NULL,
  `f_corte` date NULL DEFAULT NULL,
  `h_corte` time(0) NULL DEFAULT NULL,
  `cajacorte` float(10, 2) NULL DEFAULT NULL,
  `cajafinal` float(10, 2) NULL DEFAULT NULL,
  `estatus` int(1) NULL DEFAULT NULL COMMENT '0 - CERRADO\n1 - ACTIVO',
  `efectivo` float(10, 2) NULL DEFAULT NULL,
  `tarjeta` float(10, 2) NULL DEFAULT NULL,
  `trasfer` float(10, 2) NULL DEFAULT NULL,
  `virtual` float(10, 2) NULL DEFAULT NULL,
  `cheque` float(10, 2) NULL DEFAULT NULL,
  `deposito` float(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`idcorte`) USING BTREE,
  INDEX `fk_corte_usuarios1_idx`(`idusuarios`) USING BTREE,
  INDEX `fk_corte_sucursales1_idx`(`idsucursales`) USING BTREE,
  CONSTRAINT `corte_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `corte_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cotizacion
-- ----------------------------
DROP TABLE IF EXISTS `cotizacion`;
CREATE TABLE `cotizacion`  (
  `idcotizacion` int(11) NOT NULL AUTO_INCREMENT,
  `idsucursales` int(11) NOT NULL,
  `idcliente` int(10) NOT NULL,
  `idniveles` int(11) NOT NULL,
  `idusuarios` int(11) NOT NULL,
  `fecha` timestamp(0) NULL DEFAULT current_timestamp(0),
  `iva` float(10, 2) NULL DEFAULT NULL,
  `total` float(10, 2) NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL COMMENT '0 - desactivado\n1 - activo',
  `descuento` float(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`idcotizacion`) USING BTREE,
  INDEX `fk_cotizacion_sucursales1_idx`(`idsucursales`) USING BTREE,
  INDEX `fk_cotizacion_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cotizacion_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for detalle_cotizacion
-- ----------------------------
DROP TABLE IF EXISTS `detalle_cotizacion`;
CREATE TABLE `detalle_cotizacion`  (
  `idcotizacion` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL COMMENT '	',
  `costo` float(12, 2) NOT NULL,
  `subtotal` float(12, 2) NOT NULL,
  `descuento_porc` int(11) NOT NULL,
  `descuento` float(10, 2) NOT NULL DEFAULT 0,
  `total` float(12, 2) NOT NULL,
  INDEX `fk_table1_cotizacion1_idx`(`idcotizacion`) USING BTREE,
  INDEX `fk_detalle_cotizacion_productos1_idx`(`idproducto`) USING BTREE,
  CONSTRAINT `detalle_cotizacion_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_cotizacion_ibfk_2` FOREIGN KEY (`idcotizacion`) REFERENCES `cotizacion` (`idcotizacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas
-- ----------------------------
DROP TABLE IF EXISTS `entradas`;
CREATE TABLE `entradas`  (
  `identradas` int(11) NOT NULL AUTO_INCREMENT,
  `idsucursales` int(11) NOT NULL,
  `tipoentrada` int(11) NULL DEFAULT NULL COMMENT '0 - POR COMPRA\n1 - POR DEVOLUCION\n2 - OTROS\n',
  `idusuarios` int(11) NOT NULL,
  `idcompras` int(11) NULL DEFAULT NULL COMMENT 'Si el tipo es compra, se coloca el id de la compra\n',
  `idnota_remision` int(11) NULL DEFAULT NULL COMMENT 'si el motivo es por cambio o devolución, es importante colocar el id de la nota de remisión\n',
  `fecha_entrada` timestamp(0) NOT NULL DEFAULT current_timestamp(0) COMMENT 'fecha de la nota de remisión o factura de la compra',
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`identradas`) USING BTREE,
  INDEX `fk_entradas_usuarios1_idx`(`idusuarios`) USING BTREE,
  INDEX `fk_entradas_sucursales1_idx`(`idsucursales`) USING BTREE,
  CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 535 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas_detalles
-- ----------------------------
DROP TABLE IF EXISTS `entradas_detalles`;
CREATE TABLE `entradas_detalles`  (
  `identradas` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idtallas` int(11) NOT NULL,
  INDEX `fk_entradas_detalles_entradas1_idx`(`identradas`) USING BTREE,
  INDEX `fk_entradas_detalles_productos1_idx`(`idproducto`) USING BTREE,
  INDEX `fk_entradas_detalles_tallas1_idx`(`idtallas`) USING BTREE,
  CONSTRAINT `entradas_detalles_ibfk_1` FOREIGN KEY (`identradas`) REFERENCES `entradas` (`identradas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entradas_detalles_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entradas_detalles_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for etiqueta_detalle
-- ----------------------------
DROP TABLE IF EXISTS `etiqueta_detalle`;
CREATE TABLE `etiqueta_detalle`  (
  `idetiquetas` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idtallas` int(11) NULL DEFAULT NULL,
  INDEX `fk_table1_etiquetas1_idx`(`idetiquetas`) USING BTREE,
  INDEX `fk_table1_productos1_idx`(`idproducto`) USING BTREE,
  INDEX `valorunidad`(`idtallas`) USING BTREE,
  CONSTRAINT `etiqueta_detalle_ibfk_1` FOREIGN KEY (`idetiquetas`) REFERENCES `etiquetas` (`idetiquetas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `etiqueta_detalle_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `etiqueta_detalle_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for etiquetas
-- ----------------------------
DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE `etiquetas`  (
  `idetiquetas` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `descripcion` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idetiquetas`) USING BTREE,
  INDEX `fk_etiquetas_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for gastos_categorias
-- ----------------------------
DROP TABLE IF EXISTS `gastos_categorias`;
CREATE TABLE `gastos_categorias`  (
  `idgastos_categorias` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `tipo` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1 COMMENT '0 - desactivado\n1 - activado\n',
  PRIMARY KEY (`idgastos_categorias`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for gastos_detalles
-- ----------------------------
DROP TABLE IF EXISTS `gastos_detalles`;
CREATE TABLE `gastos_detalles`  (
  `idgastos_detalles` int(11) NOT NULL AUTO_INCREMENT,
  `idgastos_categorias` int(11) NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `monto` float(12, 2) NOT NULL DEFAULT 0,
  `estatus` int(11) NOT NULL DEFAULT 0 COMMENT '0 - pendiente\n1 - pagado\n2 - cancelado\n',
  PRIMARY KEY (`idgastos_detalles`) USING BTREE,
  INDEX `fk_gastos_detalles_gastos_categorias1_idx`(`idgastos_categorias`) USING BTREE,
  CONSTRAINT `gastos_detalles_ibfk_1` FOREIGN KEY (`idgastos_categorias`) REFERENCES `gastos_categorias` (`idgastos_categorias`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for guias
-- ----------------------------
DROP TABLE IF EXISTS `guias`;
CREATE TABLE `guias`  (
  `idguias` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha` timestamp(0) NULL DEFAULT current_timestamp(0),
  `idnota_remision` int(11) NOT NULL,
  `idpaqueterias` int(11) NOT NULL,
  `fecha_envio` date NULL DEFAULT NULL,
  `comentario` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - pendiente\n1 - activado\n2 - cancelado\n',
  PRIMARY KEY (`idguias`) USING BTREE,
  INDEX `fk_guias_paqueterias1_idx`(`idpaqueterias`) USING BTREE,
  INDEX `fk_guias_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  CONSTRAINT `guias_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `guias_ibfk_2` FOREIGN KEY (`idpaqueterias`) REFERENCES `paqueterias` (`idpaqueterias`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for inventario
-- ----------------------------
DROP TABLE IF EXISTS `inventario`;
CREATE TABLE `inventario`  (
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idtallas` int(11) NOT NULL,
  `idsucursales` int(11) NOT NULL,
  `existencia` int(11) NOT NULL DEFAULT 0,
  INDEX `fk_inventario_productos1_idx`(`idproducto`) USING BTREE,
  INDEX `fk_inventario_sucursales1_idx`(`idsucursales`) USING BTREE,
  INDEX `fk_inventario_tallas1_idx`(`idtallas`) USING BTREE,
  CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lealtad
-- ----------------------------
DROP TABLE IF EXISTS `lealtad`;
CREATE TABLE `lealtad`  (
  `idlealtad` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(10) NOT NULL,
  `idnota_remision` int(11) NOT NULL,
  PRIMARY KEY (`idlealtad`) USING BTREE,
  INDEX `fk_lealtad_clientes1_idx`(`idcliente`) USING BTREE,
  INDEX `fk_lealtad_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  CONSTRAINT `lealtad_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lealtad_ibfk_2` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for modulos
-- ----------------------------
DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos`  (
  `idmodulos` int(11) NOT NULL AUTO_INCREMENT,
  `modulo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nivel` int(1) NOT NULL DEFAULT 0,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - No activo\n1 - Activo',
  `icono` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idmodulos`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for modulos_menu
-- ----------------------------
DROP TABLE IF EXISTS `modulos_menu`;
CREATE TABLE `modulos_menu`  (
  `idmodulos_menu` int(11) NOT NULL AUTO_INCREMENT,
  `idmodulos` int(11) NOT NULL,
  `menu` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `archivo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ubicacion_archivo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nivel` int(1) NOT NULL DEFAULT 0,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - No activo\n1 - Activo',
  `icono` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idmodulos_menu`) USING BTREE,
  INDEX `fk_submenus_menus1`(`idmodulos`) USING BTREE,
  CONSTRAINT `modulos_menu_ibfk_1` FOREIGN KEY (`idmodulos`) REFERENCES `modulos` (`idmodulos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 66 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for niveles
-- ----------------------------
DROP TABLE IF EXISTS `niveles`;
CREATE TABLE `niveles`  (
  `idniveles` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - desactivado\n1 - activado\n',
  PRIMARY KEY (`idniveles`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_descripcion
-- ----------------------------
DROP TABLE IF EXISTS `nota_descripcion`;
CREATE TABLE `nota_descripcion`  (
  `idnota_remision` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idtallas` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` float(12, 2) NOT NULL,
  `subtotal` float(12, 2) NOT NULL,
  `descuento_porc` int(11) NULL DEFAULT NULL COMMENT 'la sumatoria del porcentaje de descuento por producto y nivel\n',
  `descuento` float(10, 2) NOT NULL DEFAULT 0 COMMENT 'monto de descuento de ese producto\n\nla multiplicación de pv. por cantidad por descu.\n',
  `total` float(12, 2) NOT NULL COMMENT 'es la diferencia entre subtotal y el descuento.\n\n\n\n',
  `estatus` int(11) NULL DEFAULT 0 COMMENT '0 - vendido\n1- devuelto',
  `dev_derecho` int(11) NULL DEFAULT 0 COMMENT '0 - SI TIENE DERECHO A DEVOLVER\n\n1 - NO TIENE DERECHO A DEVOLVER',
  `nombre_categoria` varchar(90) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  INDEX `fk_nota_descripcion_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  INDEX `fk_nota_descripcion_tallas1_idx`(`idtallas`) USING BTREE,
  INDEX `fk_nota_descripcion_productos1_idx`(`idproducto`) USING BTREE,
  CONSTRAINT `nota_descripcion_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_descripcion_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_descripcion_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_entrega
-- ----------------------------
DROP TABLE IF EXISTS `nota_entrega`;
CREATE TABLE `nota_entrega`  (
  `idnota_entrega` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_entrega` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `idnota_remision` int(11) NOT NULL,
  `idusuarios` int(11) NOT NULL,
  PRIMARY KEY (`idnota_entrega`) USING BTREE,
  INDEX `fk_nota_entrega_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  INDEX `fk_nota_entrega_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `nota_entrega_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_entrega_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_entrega_detalle
-- ----------------------------
DROP TABLE IF EXISTS `nota_entrega_detalle`;
CREATE TABLE `nota_entrega_detalle`  (
  `idnota_entrega` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NULL DEFAULT NULL,
  INDEX `fk_nota_entrega_detalle_nota_entrega1_idx`(`idnota_entrega`) USING BTREE,
  INDEX `fk_nota_entrega_detalle_productos1_idx`(`idproducto`) USING BTREE,
  CONSTRAINT `nota_entrega_detalle_ibfk_1` FOREIGN KEY (`idnota_entrega`) REFERENCES `nota_entrega` (`idnota_entrega`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_entrega_detalle_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_remision
-- ----------------------------
DROP TABLE IF EXISTS `nota_remision`;
CREATE TABLE `nota_remision`  (
  `idnota_remision` int(11) NOT NULL AUTO_INCREMENT,
  `idsucursales` int(11) NOT NULL,
  `idcliente` int(10) NOT NULL DEFAULT 0 COMMENT '1 - VENTA DIRECTA.\n\nCUALQUIER ID SI ES GENERADA POR UN CLIENTE EN ESPECIFICO DESDE EL WEB O DE UN CLIENTE EN LA BASE DE DATOS.\n',
  `idniveles` int(11) NOT NULL,
  `idusuarios` int(11) NOT NULL DEFAULT 0 COMMENT '0 - GENERADO DESDE EL SITIO WEB O CIENTE.\n\nCUALQUIER OTRO IDE DE USUARIO SI ES GENERADO EN VENTANILLA\n',
  `fechapedido` timestamp(0) NOT NULL DEFAULT current_timestamp(0) COMMENT 'Fecha cuando realizamos el pedido.',
  `fecha_pago` timestamp(0) NULL DEFAULT NULL COMMENT 'fecha cuando realizamos el pago.\nde la nota de remisión o crédito\n',
  `tipo_pago` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Efectivo\n1 - tarjeta de credito\n2 - tarjeta de debito\n3 - cheque\n4 - deposito\n5 - transferencia\n6 - credito\n\n',
  `referencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0' COMMENT '0 - no existe ninguna referencia fue contado.',
  `no_seguridad` varchar(34) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'no. de seguridad obtenido por el encriptado en php MD5 de \nno. de pedido,no de cliente, fecha y hora minutos segundos para enviarlo a paypal o cualquier otro método de cobro en linea.\n\nesto hacer que mi pedido sea único en su cadena.',
  `tipo_descuento` int(11) NOT NULL DEFAULT 0 COMMENT '0 - por producto\n1 - por paquete\n2 - por ambos\n3 - Directo\n',
  `facturado` int(11) NOT NULL DEFAULT 0 COMMENT '0 - no\n1 -si\n',
  `no_factura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'XAXX010101000',
  `corte` int(1) NOT NULL DEFAULT 0 COMMENT 'este campo nos indica si la venta sigue activa para el corte.\n\n0 - activo para corte\n1 - ya en corte\n',
  `subtotal` float(12, 2) NOT NULL DEFAULT 0,
  `desc_producto` float(12, 2) NULL DEFAULT 0 COMMENT 'descuento aplicado directamente en el producto.',
  `desc_paquetes` float(12, 2) NULL DEFAULT 0 COMMENT 'descuento que se aplica dese un catalogo de un minimo a máximo de compra y genera un descuento\n',
  `porc_desc_directo` int(10) NULL DEFAULT 0 COMMENT 'Porcentaje que se aplica a la nota en descuento directo sobre la nota de remisión.',
  `desc_directo` float(12, 2) NULL DEFAULT 0 COMMENT 'descuento aplicado directamente desde caja.',
  `iva` float(12, 2) NOT NULL DEFAULT 0,
  `total` float(12, 2) NOT NULL DEFAULT 0,
  `estatus` int(11) NULL DEFAULT 0 COMMENT '0 - pendiente de pago   \n1 - pagado  //si se paga en caja o se termina de pagar un crédito.\n2 - cancelado\n3 - Crédito\n4.- Crédito Pagado\n\n',
  `tipo_tc` int(1) NULL DEFAULT NULL COMMENT 'tipo de tarjeta de credito o debito\n\n0 - credito\n1 - debito.',
  `4digi_tc` int(4) NULL DEFAULT NULL,
  `monto_tc` float(12, 2) NULL DEFAULT NULL,
  `refer_tc` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'no. de movimiento que se cobro con la tarjeta.',
  `monto_cheque` float(12, 2) NULL DEFAULT NULL COMMENT '			',
  `refer_cheque` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `monto_deposito` float(10, 2) NULL DEFAULT NULL,
  `refer_deposito` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `no_deposito` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `banco_deposito` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `monto_transfer` float(10, 2) NULL DEFAULT NULL,
  `refer_transfer` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `no_transfer` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `banco_transfer` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `monto_efec` float(10, 2) NULL DEFAULT NULL,
  `cambio` float(10, 2) NULL DEFAULT NULL,
  `monto_virtual` float(10, 2) NULL DEFAULT 0 COMMENT 'PAGO CON DINERO VIRTUAL, SE TOMA DE LA TABLA CLIENTE MONEDERO.\n',
  `idcliente_monedero` int(11) NOT NULL DEFAULT 0 COMMENT 'en esta area ingresamos el idcliente_monedero para hacer referencia al movimiento en cliente_monedero.\n\nsiempre y cuando pague con monedero virtual.\n\n',
  `autorizado` int(1) NOT NULL DEFAULT 0,
  `tipo_envio` int(1) NULL DEFAULT 1 COMMENT '0 - RECOGER EN TIENDA\n1 - ENVIO A DIRECCION',
  `direccion_envio` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `comentario` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`idnota_remision`) USING BTREE,
  INDEX `fk_nota_remision_sucursales1_idx`(`idsucursales`) USING BTREE,
  CONSTRAINT `nota_remision_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2870 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_remision_depositos
-- ----------------------------
DROP TABLE IF EXISTS `nota_remision_depositos`;
CREATE TABLE `nota_remision_depositos`  (
  `idnota_remision_depositos` int(11) NOT NULL AUTO_INCREMENT,
  `idnota_remision` int(11) NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `fecha_deposito` datetime(0) NOT NULL,
  `referencia` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `banco` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `monto` float(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`idnota_remision_depositos`) USING BTREE,
  INDEX `fk_nota_remision_depositos_nota_remision2_idx`(`idnota_remision`) USING BTREE,
  CONSTRAINT `nota_remision_depositos_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1269 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_remision_imgdepositos
-- ----------------------------
DROP TABLE IF EXISTS `nota_remision_imgdepositos`;
CREATE TABLE `nota_remision_imgdepositos`  (
  `idnota_remision_imgdepositos` int(11) NOT NULL AUTO_INCREMENT,
  `idnota_remision` int(11) NOT NULL,
  `imagen` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fecha` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idnota_remision_imgdepositos`) USING BTREE,
  INDEX `fk_nota_remision_depositos_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  CONSTRAINT `nota_remision_imgdepositos_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1240 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for pagos
-- ----------------------------
DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos`  (
  `idpagos` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `authorization` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `operation_type` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `method` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `transaction_type` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_type` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_brand` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_card_number` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_expiration_year` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_expiration_month` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_allows_charges` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_allows_payouts` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_bank_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_bank_code` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `creation_date` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `operation_date` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `order_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `currency` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `amount` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idpagos`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for paqueterias
-- ----------------------------
DROP TABLE IF EXISTS `paqueterias`;
CREATE TABLE `paqueterias`  (
  `idpaqueterias` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `direccion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `email` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tel` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - desactivado\n1 - activado.\n',
  `urlrastreo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idpaqueterias`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for perfiles
-- ----------------------------
DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE `perfiles`  (
  `idperfiles` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - No activo\n1 - Activo',
  PRIMARY KEY (`idperfiles`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for perfiles_permisos
-- ----------------------------
DROP TABLE IF EXISTS `perfiles_permisos`;
CREATE TABLE `perfiles_permisos`  (
  `idperfiles` int(11) NOT NULL,
  `idmodulos_menu` int(11) NOT NULL,
  `insertar` int(11) NULL DEFAULT 0,
  `borrar` int(11) NULL DEFAULT 0,
  `modificar` int(11) NULL DEFAULT 0,
  INDEX `fk_perfiles_has_modulos_menu_modulos_menu1`(`idmodulos_menu`) USING BTREE,
  INDEX `fk_perfiles_has_modulos_menu_perfiles1`(`idperfiles`) USING BTREE,
  CONSTRAINT `perfiles_permisos_ibfk_1` FOREIGN KEY (`idmodulos_menu`) REFERENCES `modulos_menu` (`idmodulos_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `perfiles_permisos_ibfk_2` FOREIGN KEY (`idperfiles`) REFERENCES `perfiles` (`idperfiles`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for preguntas
-- ----------------------------
DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE `preguntas`  (
  `idpreguntas` int(12) NOT NULL AUTO_INCREMENT,
  `pregunta` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `respuesta` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `estatus` int(12) NULL DEFAULT NULL COMMENT '0- desactivado, 1- activado',
  PRIMARY KEY (`idpreguntas`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos`  (
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'no acepta caracteres especiales',
  `idcategoria_precio` int(11) NOT NULL DEFAULT 1,
  `cod_proveedor` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'Contienen el código de su proveedor.',
  `f_creacion` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `pc` float(11, 2) NULL DEFAULT 0 COMMENT 'Precio Costo',
  `pv` float(11, 2) NOT NULL COMMENT 'precio venta ya con iva.\n',
  `descuento` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `thumb` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `stok_min` int(11) NOT NULL DEFAULT 0,
  `unidad` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'PZ' COMMENT 'PZ - PIEZAS\nLT - LITROS\nKG - KILOGRAMOS.',
  `estatus` int(11) NOT NULL DEFAULT 0 COMMENT '0 - no activo\n1 - activo\n',
  `idsobrepedido_camp` int(11) NULL DEFAULT NULL,
  `idsubcategoria` int(15) NOT NULL,
  PRIMARY KEY (`idproducto`) USING BTREE,
  INDEX `fk_productos_categoria_precio1_idx`(`idcategoria_precio`) USING BTREE,
  INDEX `fk_subcategoria1_idx`(`idsubcategoria`) USING BTREE,
  CONSTRAINT `fk_subcategoria1` FOREIGN KEY (`idsubcategoria`) REFERENCES `subcategoria` (`idsubcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idcategoria_precio`) REFERENCES `categoria_precio` (`idcategoria_precio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for proveedores
-- ----------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores`  (
  `idproveedores` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `telefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `email` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `contacto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatus` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT '0 - no activo el proveedor\n1 - activo el proveedor\n',
  `url` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idproveedores`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for push_mensajes
-- ----------------------------
DROP TABLE IF EXISTS `push_mensajes`;
CREATE TABLE `push_mensajes`  (
  `idpush_mensajes` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fecha` datetime(0) NOT NULL,
  `de` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `para` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tipo` int(1) NULL DEFAULT NULL COMMENT '0 - mensaje general\n1 - mensaje de sistema\n2 - guias\n3 - mensajes sobre pedido',
  `mensaje` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `estatus` int(1) NULL DEFAULT 0 COMMENT '0 - pendiente\n1 - leido\n2 - borrado',
  PRIMARY KEY (`idpush_mensajes`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for push_registro
-- ----------------------------
DROP TABLE IF EXISTS `push_registro`;
CREATE TABLE `push_registro`  (
  `idpush_registro` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `token` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `so` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alias` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idusuario` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idpush_registro`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for salidas
-- ----------------------------
DROP TABLE IF EXISTS `salidas`;
CREATE TABLE `salidas`  (
  `idsalidas` int(11) NOT NULL AUTO_INCREMENT,
  `idsucursales` int(11) NOT NULL,
  `idusuarios` int(11) NOT NULL,
  `fecha` datetime(0) NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT 0 COMMENT '0 - ventas\n1 - devolución\n2 - producto falla\n3 - caducado\n\n',
  `idnota_remision` int(11) NULL DEFAULT NULL COMMENT 'es el no. de la nota de remisión.\nsi el producto sale por venta\n',
  PRIMARY KEY (`idsalidas`) USING BTREE,
  INDEX `fk_salidas_sucursales1_idx`(`idsucursales`) USING BTREE,
  INDEX `fk_salidas_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `salidas_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `salidas_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for salidas_detalles
-- ----------------------------
DROP TABLE IF EXISTS `salidas_detalles`;
CREATE TABLE `salidas_detalles`  (
  `idsalidas` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float(12, 2) NOT NULL,
  `descuento` int(11) NOT NULL DEFAULT 0,
  `total` float(12, 2) NOT NULL,
  `idtallas` int(11) NOT NULL,
  INDEX `fk_salidas_detalles_salidas1_idx`(`idsalidas`) USING BTREE,
  INDEX `fk_salidas_detalles_productos1_idx`(`idproducto`) USING BTREE,
  INDEX `fk_salidas_detalles_tallas1_idx`(`idtallas`) USING BTREE,
  CONSTRAINT `salidas_detalles_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `salidas_detalles_ibfk_2` FOREIGN KEY (`idsalidas`) REFERENCES `salidas` (`idsalidas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `salidas_detalles_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for subcategoria
-- ----------------------------
DROP TABLE IF EXISTS `subcategoria`;
CREATE TABLE `subcategoria`  (
  `idsubcategoria` int(15) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(15) NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `estatus` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`idsubcategoria`) USING BTREE,
  INDEX `categoria`(`idcategoria`) USING BTREE,
  CONSTRAINT `categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sucursales
-- ----------------------------
DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE `sucursales`  (
  `idsucursales` int(11) NOT NULL AUTO_INCREMENT,
  `sucursal` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `tel` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipo` int(1) NULL DEFAULT NULL COMMENT '0 - principal\n1 - sucursales\n',
  `notas_print` int(1) NULL DEFAULT NULL COMMENT '0 - CARTA\n1 - TERMICO',
  `estatus` int(255) NULL DEFAULT NULL COMMENT '0- desactivo, 1 - activo',
  PRIMARY KEY (`idsucursales`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tallas
-- ----------------------------
DROP TABLE IF EXISTS `tallas`;
CREATE TABLE `tallas`  (
  `idtallas` int(11) NOT NULL AUTO_INCREMENT,
  `unidad` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `valor` varchar(90) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`idtallas`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for traspaso
-- ----------------------------
DROP TABLE IF EXISTS `traspaso`;
CREATE TABLE `traspaso`  (
  `idtraspaso` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `fecha` timestamp(0) NULL DEFAULT current_timestamp(0),
  `de` int(11) NULL DEFAULT NULL COMMENT 'ID DE LA SUCURSAL QUE ENVIA',
  `para` int(11) NULL DEFAULT NULL COMMENT 'ID SUCURSAL QUE RECIBE.',
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`idtraspaso`) USING BTREE,
  INDEX `fk_traspaso_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `traspaso_ibfk_1` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for traspaso_detalle
-- ----------------------------
DROP TABLE IF EXISTS `traspaso_detalle`;
CREATE TABLE `traspaso_detalle`  (
  `idtraspaso` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idtallas` int(11) NULL DEFAULT NULL,
  INDEX `idtraspaso`(`idtraspaso`) USING BTREE,
  INDEX `idproducto`(`idproducto`) USING BTREE,
  INDEX `idproducto_2`(`idproducto`) USING BTREE,
  INDEX `idproducto_3`(`idproducto`) USING BTREE,
  INDEX `idproducto_4`(`idproducto`) USING BTREE,
  INDEX `idproducto_5`(`idproducto`) USING BTREE,
  CONSTRAINT `traspaso_detalle_ibfk_1` FOREIGN KEY (`idtraspaso`) REFERENCES `traspaso` (`idtraspaso`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `idusuarios` int(11) NOT NULL AUTO_INCREMENT COMMENT '0 - USUARIOS INTERNOS\n1 - USUARIOS EXTERNOS',
  `idperfiles` int(11) NOT NULL,
  `nombre` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `paterno` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `materno` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefono` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '----',
  `celular` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '----',
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usuario` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `clave` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1,
  `tipo` int(1) NULL DEFAULT NULL COMMENT '0 - super usuario\n1 - Empresa',
  `tipo_usuario` int(1) NULL DEFAULT 0 COMMENT '0 - USUARIOS INTERNOS\n1 - USUARIOS EXTERNOS',
  `tipo_telefono` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '1' COMMENT '1 - android\n0 - iphone',
  `token` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idsucursales` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idusuarios`) USING BTREE,
  INDEX `fk_usuarios_perfiles1`(`idperfiles`) USING BTREE,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idperfiles`) REFERENCES `perfiles` (`idperfiles`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
