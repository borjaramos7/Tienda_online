CREATE DATABASE  IF NOT EXISTS `tienda_online` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `tienda_online`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: tienda_online
-- ------------------------------------------------------
-- Server version	5.6.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `idcat` int(11) NOT NULL AUTO_INCREMENT,
  `nombrecat` varchar(45) NOT NULL,
  `codcat` varchar(10) NOT NULL,
  `descrip_cat` varchar(120) DEFAULT NULL,
  `anuncio_cat` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idcat`),
  UNIQUE KEY `idcat_UNIQUE` (`idcat`),
  UNIQUE KEY `codcat_UNIQUE` (`codcat`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'iphone','1','Moviles Iphone',NULL),(2,'samsung','2','Moviles samsung',NULL),(3,'lg','3','Moviles LG',NULL),(4,'sony','4','Moviles Sony',NULL),(5,'htc','5','Moviles HTC',NULL),(6,'huawei','6','Moviles Huawei',NULL),(8,'Motorola','8','Moviles Motorola',NULL);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linea_pedido`
--

DROP TABLE IF EXISTS `linea_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linea_pedido` (
  `pedido_idpedido` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_ped` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`pedido_idpedido`,`producto_id`),
  KEY `fk_pedido_has_producto_producto1_idx` (`producto_id`),
  KEY `fk_pedido_has_producto_pedido1_idx` (`pedido_idpedido`),
  CONSTRAINT `fk_pedido_has_producto_pedido1` FOREIGN KEY (`pedido_idpedido`) REFERENCES `pedido` (`idpedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linea_pedido`
--

LOCK TABLES `linea_pedido` WRITE;
/*!40000 ALTER TABLE `linea_pedido` DISABLE KEYS */;
INSERT INTO `linea_pedido` VALUES (31,1,3,666.00),(31,6,3,662.67),(32,4,5,562.60),(33,6,1,220.89),(34,6,1,220.89),(35,6,1,220.89),(35,9,1,886.89),(36,11,1,794.60),(37,10,3,54.45),(38,2,1,406.00),(39,6,4,883.56),(40,1,3,666.00);
/*!40000 ALTER TABLE `linea_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `idpedido` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_pedido` date DEFAULT NULL,
  `forma_pago` varchar(45) DEFAULT NULL,
  `usuario_iduser` int(11) NOT NULL,
  `estado_ped` varchar(35) DEFAULT NULL COMMENT 'el pedido puede tener varios estados como procesado confirmado y demas.',
  `total_ped` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`idpedido`),
  UNIQUE KEY `idpedido_UNIQUE` (`idpedido`),
  KEY `fk_pedido_usuario1_idx` (`usuario_iduser`),
  CONSTRAINT `fk_pedido_usuario1` FOREIGN KEY (`usuario_iduser`) REFERENCES `usuario` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES (31,'2016-02-17',NULL,3,'Pendiente de envio',1328.67),(32,'2016-02-17',NULL,3,'Anulado',562.60),(33,'2016-02-18',NULL,3,'Anulado',220.89),(34,'2016-02-19',NULL,3,'Pendiente de envio',220.89),(35,'2016-02-19',NULL,3,'Pendiente de envio',1107.78),(36,'2016-03-04',NULL,3,'Pendiente de envio',794.60),(37,'2016-03-04',NULL,3,'Pendiente de envio',54.45),(38,'2016-03-04',NULL,3,'Pendiente de envio',406.00),(39,'2016-03-04',NULL,3,'Pendiente de envio',883.56),(40,'2016-03-04',NULL,3,'Pendiente de envio',666.00);
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codpro` varchar(10) NOT NULL,
  `nombrepro` varchar(45) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `descuento` int(2) DEFAULT NULL,
  `imagenpro` varchar(256) DEFAULT NULL,
  `iva` int(2) NOT NULL,
  `descripcion` text,
  `anuncio` text,
  `stock` int(5) NOT NULL,
  `categoria_idcat` int(11) NOT NULL,
  `destacado` tinyint(1) DEFAULT '0',
  `fechacom` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `oculto` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombrepro_UNIQUE` (`nombrepro`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `codpro_UNIQUE` (`codpro`),
  KEY `fk_Producto_categoria_idx` (`categoria_idcat`),
  CONSTRAINT `fk_Producto_categoria` FOREIGN KEY (`categoria_idcat`) REFERENCES `categoria` (`idcat`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'1','galaxy s3',200.00,10,'galaxys3.jpg',21,'Tamaño: 147,39 x 82,6 x 9,35 mm.  <br> Pantalla: 5.3 pulgadas. <br> Procesador: 4 nucleos 1.8 GHz','Movil rebajado',41,2,1,'2016-01-01','2016-01-07',0),(2,'2','iphone 5',350.00,5,'iphone5.jpg',21,'Tamaño: 150,39 x 72,6 x 8,35 mm.  <br> Pantalla: 4.7 pulgadas. <br> Procesador: 1 nucleo 1,5 GHz','Movil economico',1,1,1,'2016-02-03','2016-02-09',0),(3,'3','HTC One M8',68.00,10,'htconem8.jpg',21,'Tamaño: 146,36 x 70,6 x 9,35 mm.  <br> Pantalla: 5 pulgadas. <br> Procesador: 2 nucleos','Movil basico',3,5,1,'2016-01-01','2016-02-08',0),(4,'4','HTC desire',97.00,5,'htcdesire.jpg',21,'Tamaño: 150,39 x 72,6 x 10,35 mm.  <br> Pantalla: 4.5 pulgadas. <br> Procesador: 2 nucleo 1,5 GHz','Movil basico',111,5,0,NULL,NULL,0),(5,'5','HTC Sensation',99.00,0,'htcsensation.jpg',21,'Tamaño: 150,39 x 72,6 x 8,35 mm.  <br> Pantalla: 4.7 pulgadas. <br> Procesador: 1 nucleo 1,5 GHz','Movil basico',14,5,0,NULL,NULL,0),(6,'6','HTC One Mini',199.00,10,'htcmini.jpg',21,'Tamaño: 125,39 x 72,6 x 7,35 mm.  <br> Pantalla: 4.5 pulgadas. <br> Procesador: 2 nucleo 1,5 GHz','Movil basico',120,5,1,'2016-01-01','2016-04-01',0),(7,'7','HTC 8X',299.00,5,'htc8x.jpg',21,'Tamaño: 147,39 x 82,6 x 9,35 mm.  <br> Pantalla: 5 pulgadas. <br> Procesador: 1 nucleo 2,3 GHz','Movil alta gama',15,5,0,NULL,NULL,0),(8,'8','Samsung Galaxy S6',765.00,5,'galaxys6.jpg',21,'Tamaño: 147,39 x 82,6 x 9,35 mm.  <br> Pantalla: 5.3 pulgadas. <br> Procesador: 4 nucleos 1.8 GHz','Movil alta gama',45,2,0,NULL,NULL,0),(9,'9','Samsung Galaxy Note Edge',799.00,10,'galaxynote.jpg',21,'Tamaño: 162 x 92,6 x 10,31 mm.  <br> Pantalla: 6 pulgadas. <br> Procesador: 4 nucleos 1.8 GHz','Movil \"tablet\"',111,2,1,'2016-02-07','2016-02-27',0),(10,'10','Samsung Galaxy Trend',15.00,0,'galaxytrend.jpg',21,'Tamaño: 134 x 90,6 x 9,31 mm.  <br> Pantalla: 4.5 pulgadas. <br> Procesador: 1 nucleo 1.8 GHz','Movil libre',2,2,1,'2016-02-04','2018-09-01',0),(11,'11','Iphone 6s ',685.00,5,'iphone6s.jpg',21,'Tamaño: 144 x 80,6 x 10,21 mm.  <br> Pantalla: 5 pulgadas. <br> Procesador: 2 nucleos 2.5 GHz','Movil alta gama',17,1,0,NULL,NULL,0),(12,'12','Iphone 6',510.00,10,'iphone6.jpg',21,'Tamaño: 144 x 81,6 x 9,31 mm.  <br> Pantalla: 4.8 pulgadas. <br> Procesador: 2 nucleos 2.3 GHz','Movil alta gama',12,1,0,NULL,NULL,0),(13,'13','LG Optimus L9',49.00,0,'lgoptl9.jpg',21,'Tamaño: 142 x 76,6 x 11,31 mm.  <br> Pantalla: 5 pulgadas. <br> Procesador: 2 nucleos 1.8 GHz','Movil basico',82,3,0,NULL,NULL,0),(14,'14','LG L40',59.00,3,'lgl40.jpg',21,'Tamaño: 134 x 90,6 x 9,31 mm.  <br> Pantalla: 4.5 pulgadas. <br> Procesador: 2 nucleos 1.6 GHz','Movil libre',58,3,1,'2016-02-07','2018-09-01',0),(17,'15','Sony Xperia M4',147.00,5,'sonym4.jpg',21,'Tamaño: 144 x 80,6 x 10,21 mm.  <br> Pantalla: 5 pulgadas. <br> Procesador: 2 nucleos 2.5 GHz','Movil libre',78,4,1,'2016-02-07','2016-05-07',0),(18,'16','Sony Xperia P',69.00,5,'sonyp.jpg',21,'Tamaño: 142 x 92,6 x 10 mm.  <br> Pantalla:4.5 pulgadas. <br> Procesador: 4 nucleos 1.8 GHz','Movil alta gama',24,4,0,NULL,NULL,0),(20,'17','Sony Xperia ',125.00,10,'sonyz3.jpg',21,'Tamaño: 162 x 92,6 x 10,31 mm.  <br> Pantalla: 6 pulgadas. <br> Procesador: 2 nucleos 1.6 GHz','Movil alta gama',14,4,0,NULL,NULL,0),(23,'18','Huawei P8 Lite',258.00,10,'hp8.jpg',21,'Tamaño: 119 x 80 x 12,21 mm.  <br> Pantalla: 5.5 pulgadas. <br> Procesador: 2 nucleos 1.6 GHz','Movil libre',17,6,0,NULL,NULL,0),(24,'19','Huawei Ascend',450.00,5,'hascend.jpg',21,'Tamaño: 124 x 70 x 12 mm.  <br> Pantalla: 5 pulgadas. <br> Procesador: 2 nucleos 1.8 GHz','Movil libre',110,6,0,NULL,NULL,0);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(10) NOT NULL,
  `nombreus` varchar(18) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `cp` int(5) DEFAULT NULL,
  `provincia` varchar(45) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `estado` varchar(45) NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `idusuario_UNIQUE` (`dni`),
  UNIQUE KEY `nombreus_UNIQUE` (`nombreus`),
  UNIQUE KEY `iduser_UNIQUE` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (3,'48940053D','borjaramos7','47bce5c74f589f4867dbd57e9ca9f808','Borja','Ramos','C/ San cristobal',21830,'Huelva','borjaramos7@gmail.com','ok');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-07 10:46:17
