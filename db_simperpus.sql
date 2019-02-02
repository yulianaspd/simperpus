-- MySQL dump 10.16  Distrib 10.1.35-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: db_simperpus
-- ------------------------------------------------------
-- Server version	10.1.35-MariaDB

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
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) NOT NULL,
  `no_identitas` varchar(50) NOT NULL,
  `jenis_identitas` varchar(10) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `nama_panggilan` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1= AKTIF / 0 = TDK AKTIF',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`,`no_identitas`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota`
--

LOCK TABLES `anggota` WRITE;
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
INSERT INTO `anggota` VALUES (1,'4kjk2sd','1234567890','KTP','Irving Dian Pratama','Irving','Jl Jendral soedirman purbalingga','009876879','4kjk2sd.jpg',1,'2019-01-25 07:16:29');
/*!40000 ALTER TABLE `anggota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(255) NOT NULL,
  `penulis_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `penerbit_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `halaman` int(11) NOT NULL,
  `jumlah_tersedia` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penulis_id` (`penulis_id`),
  KEY `kategori_id` (`kategori_id`),
  KEY `penerbit_id` (`penerbit_id`),
  CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`penulis_id`) REFERENCES `penulis` (`id`),
  CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  CONSTRAINT `buku_ibfk_3` FOREIGN KEY (`penerbit_id`) REFERENCES `penerbit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (1,'735416238',1,1,1,'Adobe Photoshop Tutorial',100,3,'2019-01-23 04:16:20',NULL),(2,'1253823',1,1,1,'Corel Draw Tutorial',300,4,'2019-01-23 07:25:34',NULL);
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_perpanjangan`
--

DROP TABLE IF EXISTS `history_perpanjangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_perpanjangan` (
  `peminjaman_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jatuh_tempo_awal` date NOT NULL,
  `jatuh_tempo_akhir` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `peminjaman_id` (`peminjaman_id`),
  KEY `user_id` (`user_id`),
  KEY `buku_id` (`buku_id`),
  CONSTRAINT `history_perpanjangan_ibfk_1` FOREIGN KEY (`peminjaman_id`) REFERENCES `pinjam` (`id`),
  CONSTRAINT `history_perpanjangan_ibfk_3` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`),
  CONSTRAINT `history_perpanjangan_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `history_perpanjangan_ibfk_5` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_perpanjangan`
--

LOCK TABLES `history_perpanjangan` WRITE;
/*!40000 ALTER TABLE `history_perpanjangan` DISABLE KEYS */;
/*!40000 ALTER TABLE `history_perpanjangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rak_id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rak_id` (`rak_id`),
  CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`rak_id`) REFERENCES `rak` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,1,'Desain Grafis','2019-01-21 10:12:52',NULL);
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penerbit`
--

DROP TABLE IF EXISTS `penerbit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penerbit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerbit`
--

LOCK TABLES `penerbit` WRITE;
/*!40000 ALTER TABLE `penerbit` DISABLE KEYS */;
INSERT INTO `penerbit` VALUES (1,'Media Aksara 11','Jl.XYZ no 50 - Jakarta Timur 11','081000','info123@mediaaksara.com','2019-01-22 02:02:45','2019-01-22 03:47:39');
/*!40000 ALTER TABLE `penerbit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penulis`
--

DROP TABLE IF EXISTS `penulis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penulis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penulis`
--

LOCK TABLES `penulis` WRITE;
/*!40000 ALTER TABLE `penulis` DISABLE KEYS */;
INSERT INTO `penulis` VALUES (1,'Matt Shadow','2019-01-15 07:31:33');
/*!40000 ALTER TABLE `penulis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pinjam`
--

DROP TABLE IF EXISTS `pinjam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pinjam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pinjam` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `qty` int(11) NOT NULL,
  `total_denda` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `anggota_id` (`anggota_id`),
  CONSTRAINT `pinjam_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `pinjam_ibfk_2` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pinjam`
--

LOCK TABLES `pinjam` WRITE;
/*!40000 ALTER TABLE `pinjam` DISABLE KEYS */;
INSERT INTO `pinjam` VALUES (2,'2410d62e26',1,1,'2019-02-01 00:00:00',1,0,'2019-02-01 09:22:26','0000-00-00 00:00:00'),(3,'2410d67733',1,1,'2019-02-01 00:00:00',1,0,'2019-02-01 09:25:33','0000-00-00 00:00:00'),(4,'2410d699ea',1,1,'2019-02-01 00:00:00',1,0,'2019-02-01 09:27:02','0000-00-00 00:00:00'),(5,'39b48ad34',1,1,'2019-02-01 00:00:00',1,0,'2019-02-01 09:28:50','0000-00-00 00:00:00'),(6,'2410d6f6e3',1,1,'2019-02-01 00:00:00',1,0,'2019-02-01 09:31:00','0000-00-00 00:00:00'),(7,'2410d6fe57',1,1,'2019-02-01 00:00:00',1,0,'2019-02-01 09:31:19','0000-00-00 00:00:00'),(8,'2410d713d7',1,1,'2019-02-01 00:00:00',1,0,'2019-02-01 09:32:14','0000-00-00 00:00:00'),(9,'241131ce5c',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:03:14','0000-00-00 00:00:00'),(10,'39b51cee3',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:06:14','0000-00-00 00:00:00'),(11,'2411323969',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:07:48','0000-00-00 00:00:00'),(12,'39b51d39b',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:08:15','0000-00-00 00:00:00'),(13,'24113245e1',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:08:20','0000-00-00 00:00:00'),(14,'241132cfc4',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:14:13','0000-00-00 00:00:00'),(15,'2411332750',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:17:57','0000-00-00 00:00:00'),(16,'39b51eb2a',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:18:18','0000-00-00 00:00:00'),(17,'39b51f54e',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:22:38','0000-00-00 00:00:00'),(18,'241133a76d',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:23:25','0000-00-00 00:00:00'),(19,'24113408a4',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:27:34','0000-00-00 00:00:00'),(20,'39b521d51',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:39:42','0000-00-00 00:00:00'),(21,'2411352dfe',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:40:05','0000-00-00 00:00:00'),(22,'241135baa6',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:46:05','0000-00-00 00:00:00'),(23,'241135dab7',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:47:27','0000-00-00 00:00:00'),(24,'241135f926',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:48:45','0000-00-00 00:00:00'),(25,'39b52353d',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:49:54','0000-00-00 00:00:00'),(26,'2411362235',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:50:30','0000-00-00 00:00:00'),(27,'39b523a68',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:52:07','0000-00-00 00:00:00'),(28,'39b523d3a',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:53:19','0000-00-00 00:00:00'),(29,'2411366b39',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:53:37','0000-00-00 00:00:00'),(30,'241136e18c',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:58:40','0000-00-00 00:00:00'),(31,'241136e4b6',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 02:58:48','0000-00-00 00:00:00'),(32,'39b524e5c',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:00:38','0000-00-00 00:00:00'),(33,'24113765fd',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:04:19','0000-00-00 00:00:00'),(34,'2411376ef3',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:04:42','0000-00-00 00:00:00'),(35,'2411377f0b',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:05:23','0000-00-00 00:00:00'),(36,'241137b41c',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:07:39','0000-00-00 00:00:00'),(37,'241137dc68',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:09:22','0000-00-00 00:00:00'),(38,'39b526352',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:09:34','0000-00-00 00:00:00'),(39,'241137eebd',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:10:09','0000-00-00 00:00:00'),(40,'2411380371',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:11:02','0000-00-00 00:00:00'),(41,'39b526950',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:12:08','0000-00-00 00:00:00'),(42,'2411381fe8',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:12:15','0000-00-00 00:00:00'),(43,'24113830c0',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:12:58','0000-00-00 00:00:00'),(44,'2411386067',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:15:00','0000-00-00 00:00:00'),(45,'39b527100',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:15:24','0000-00-00 00:00:00'),(46,'39b52734e',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:16:23','0000-00-00 00:00:00'),(47,'24113903a3',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:21:58','0000-00-00 00:00:00'),(48,'2411396048',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:25:55','0000-00-00 00:00:00'),(49,'39b528c89',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:27:09','0000-00-00 00:00:00'),(50,'241139a4f9',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:28:51','0000-00-00 00:00:00'),(51,'241139b1e1',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:29:24','0000-00-00 00:00:00'),(52,'241139d129',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:30:44','0000-00-00 00:00:00'),(53,'39b5298a2',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:32:19','0000-00-00 00:00:00'),(54,'24113a80f3',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:38:14','0000-00-00 00:00:00'),(55,'24113a9092',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:38:54','0000-00-00 00:00:00'),(56,'24113a9f5a',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:39:32','0000-00-00 00:00:00'),(57,'24113bfa47',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:54:20','0000-00-00 00:00:00'),(58,'24113c0986',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:54:59','0000-00-00 00:00:00'),(59,'24113c3be1',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:57:08','0000-00-00 00:00:00'),(60,'39b52d710',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 03:58:57','0000-00-00 00:00:00'),(61,'24113cd507',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:03:40','0000-00-00 00:00:00'),(62,'24113cfd3f',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:05:23','0000-00-00 00:00:00'),(63,'39b52e6ef',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:05:43','0000-00-00 00:00:00'),(64,'39b52e895',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:06:26','0000-00-00 00:00:00'),(65,'24113d1fab',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:06:51','0000-00-00 00:00:00'),(66,'24113d30d1',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:07:35','0000-00-00 00:00:00'),(67,'39b52edc5',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:08:38','0000-00-00 00:00:00'),(68,'24113d7c40',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:10:48','0000-00-00 00:00:00'),(69,'24113dd5af',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:14:37','0000-00-00 00:00:00'),(70,'24113de030',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:15:04','0000-00-00 00:00:00'),(71,'39b52fe63',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:15:44','0000-00-00 00:00:00'),(72,'39b53206e',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:30:15','0000-00-00 00:00:00'),(73,'24113f4fcb',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:30:45','0000-00-00 00:00:00'),(74,'39b532990',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:34:09','0000-00-00 00:00:00'),(75,'24113fae50',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:34:47','0000-00-00 00:00:00'),(76,'24113fb9ae',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:35:16','0000-00-00 00:00:00'),(77,'39b533fc7',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:43:38','0000-00-00 00:00:00'),(78,'241140a462',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:45:17','0000-00-00 00:00:00'),(79,'241140b276',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:45:53','0000-00-00 00:00:00'),(80,'241140c470',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:46:39','0000-00-00 00:00:00'),(81,'24114145c4',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:52:10','0000-00-00 00:00:00'),(82,'2411415d8b',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:53:11','0000-00-00 00:00:00'),(83,'241141969b',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:55:37','0000-00-00 00:00:00'),(84,'241141a6a6',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:56:18','0000-00-00 00:00:00'),(85,'39b535d82',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:56:19','0000-00-00 00:00:00'),(86,'241141b69c',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:56:59','0000-00-00 00:00:00'),(87,'241141ca8b',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:57:50','0000-00-00 00:00:00'),(88,'241141cdb1',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:57:58','0000-00-00 00:00:00'),(89,'241141de1a',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 04:58:40','0000-00-00 00:00:00'),(90,'2411428e9b',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 05:06:12','0000-00-00 00:00:00'),(91,'39b5375ec',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 05:06:44','0000-00-00 00:00:00'),(92,'39b5376bf',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 05:07:05','0000-00-00 00:00:00'),(93,'2411443ac3',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 05:24:28','0000-00-00 00:00:00'),(94,'39b53a1c5',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 05:25:26','0000-00-00 00:00:00'),(95,'39b53a1fb',1,1,'2019-02-02 00:00:00',1,0,'2019-02-02 05:25:32','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `pinjam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pinjam_detail`
--

DROP TABLE IF EXISTS `pinjam_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pinjam_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pinjam_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `jml_perpanjangan` int(11) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `status` int(11) NOT NULL,
  `tanggal_kembali` datetime NOT NULL,
  `denda` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `peminjaman_id` (`pinjam_id`),
  KEY `buku_id` (`buku_id`),
  CONSTRAINT `pinjam_detail_ibfk_1` FOREIGN KEY (`pinjam_id`) REFERENCES `pinjam` (`id`),
  CONSTRAINT `pinjam_detail_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pinjam_detail`
--

LOCK TABLES `pinjam_detail` WRITE;
/*!40000 ALTER TABLE `pinjam_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `pinjam_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pinjam_temp`
--

DROP TABLE IF EXISTS `pinjam_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pinjam_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buku_id` int(11) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buku_id` (`buku_id`),
  CONSTRAINT `pinjam_temp_ibfk_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pinjam_temp`
--

LOCK TABLES `pinjam_temp` WRITE;
/*!40000 ALTER TABLE `pinjam_temp` DISABLE KEYS */;
INSERT INTO `pinjam_temp` VALUES (12,2,'1253823','Corel Draw Tutorial',NULL),(13,1,'735416238','Adobe Photoshop Tutorial',NULL);
/*!40000 ALTER TABLE `pinjam_temp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rak`
--

DROP TABLE IF EXISTS `rak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rak`
--

LOCK TABLES `rak` WRITE;
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
INSERT INTO `rak` VALUES (1,'A001','2019-01-15 07:24:16','2019-01-20 20:42:21'),(2,'A002','2019-01-15 07:24:16','2019-01-18 23:35:30'),(3,'A003','2019-01-18 08:16:04','2019-01-18 23:27:33');
/*!40000 ALTER TABLE `rak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3','2018-12-20 04:35:57');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-02 18:32:58
