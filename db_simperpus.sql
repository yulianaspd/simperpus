-- MySQL dump 10.17  Distrib 10.3.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: db_simperpus
-- ------------------------------------------------------
-- Server version	10.3.12-MariaDB-1:10.3.12+maria~bionic-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
  `status` int(11) NOT NULL COMMENT '1= AKTIF / 0 = TDK AKTIF',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`,`no_identitas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota`
--

LOCK TABLES `anggota` WRITE;
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
INSERT INTO `anggota` VALUES (1,'4kjk2sd','1234567890','KTP','Irving Dian Pratama','Irving','Jl Jendral soedirman purbalingga','009876879',1,'2019-01-25 07:16:29'),(2,'edq3lbv','1234567890','KTP','Mr John Lennon','John','California. US','0987654321',1,'2019-02-08 03:47:11'),(3,'4glgoh0t','0527283461980','KTP','Jack Separo Gendeng ','Gendeng ','Jalan Raya, Kota Gede Yogyakarta ','089765123',0,'2019-03-24 06:54:28');
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penulis_id` (`penulis_id`),
  KEY `kategori_id` (`kategori_id`),
  KEY `penerbit_id` (`penerbit_id`),
  CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`penulis_id`) REFERENCES `penulis` (`id`),
  CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  CONSTRAINT `buku_ibfk_3` FOREIGN KEY (`penerbit_id`) REFERENCES `penerbit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (1,'735416238',1,1,1,'Adobe Photoshop Tutorial',100,3,'2019-01-23 04:16:20',NULL),(2,'1253823',1,1,1,'Corel Draw Tutorial',300,4,'2019-01-23 07:25:34',NULL),(3,'1122334455',1,3,2,'Web Service API',120,0,'2019-03-24 06:03:17',NULL),(5,'00998877',3,5,4,'Android Studio Pemula',300,0,'2019-03-24 06:04:46',NULL),(6,'55667788',3,5,2,'React Native Android',130,0,'2019-03-24 06:41:10',NULL);
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_perpanjangan`
--

DROP TABLE IF EXISTS `history_perpanjangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_perpanjangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pinjam_detail_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jatuh_tempo_awal` date NOT NULL,
  `jatuh_tempo_berikutnya` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pinjam_detail_id` (`pinjam_detail_id`),
  KEY `buku_id` (`buku_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `history_perpanjangan_ibfk_1` FOREIGN KEY (`pinjam_detail_id`) REFERENCES `pinjam_detail` (`id`),
  CONSTRAINT `history_perpanjangan_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`),
  CONSTRAINT `history_perpanjangan_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_perpanjangan`
--

LOCK TABLES `history_perpanjangan` WRITE;
/*!40000 ALTER TABLE `history_perpanjangan` DISABLE KEYS */;
INSERT INTO `history_perpanjangan` VALUES (67,54,2,1,'2019-03-21','2019-03-23','2019-03-13 08:51:45','2019-03-13 15:51:45'),(68,55,1,1,'2019-03-21','2019-03-23','2019-03-13 08:51:45','2019-03-13 15:51:45'),(69,54,2,1,'2019-03-23','2019-03-25','2019-03-13 08:52:57','2019-03-13 15:52:57'),(70,55,1,1,'2019-03-23','2019-03-25','2019-03-13 08:52:57','2019-03-13 15:52:57'),(71,54,2,1,'2019-03-25','2019-03-27','2019-03-13 08:53:37','2019-03-13 15:53:37'),(72,55,1,1,'2019-03-25','2019-03-27','2019-03-13 08:53:37','2019-03-13 15:53:37'),(73,54,2,1,'2019-03-27','2019-03-29','2019-03-13 08:54:32','2019-03-13 15:54:32'),(74,55,1,1,'2019-03-27','2019-03-29','2019-03-13 08:54:32','2019-03-13 15:54:32'),(75,54,2,1,'2019-03-29','2019-03-31','2019-03-13 09:35:17','2019-03-13 16:35:17'),(76,55,1,1,'2019-03-29','2019-03-31','2019-03-13 09:35:17','2019-03-13 16:35:17'),(77,54,2,1,'2019-03-31','2019-04-02','2019-03-13 09:35:35','2019-03-13 16:35:35'),(78,55,1,1,'2019-03-31','2019-04-02','2019-03-13 09:35:35','2019-03-13 16:35:35'),(79,54,2,1,'2019-04-02','2019-04-04','2019-03-13 09:36:56','2019-03-13 16:36:56'),(80,55,1,1,'2019-04-02','2019-04-04','2019-03-13 09:36:56','2019-03-13 16:36:56'),(81,54,2,1,'2019-04-04','2019-04-06','2019-03-13 09:37:06','2019-03-13 16:37:06'),(82,55,1,1,'2019-04-04','2019-04-06','2019-03-13 09:37:15','2019-03-13 16:37:15'),(83,57,2,3,'2019-03-16','2019-03-18','2019-03-14 09:36:19','2019-03-14 16:36:19'),(84,57,2,3,'2019-03-18','2019-03-20','2019-03-14 09:37:20','2019-03-14 16:37:20'),(85,58,1,3,'2019-03-16','2019-03-18','2019-03-14 09:37:49','2019-03-14 16:37:49'),(86,58,1,3,'2019-03-18','2019-03-20','2019-03-14 09:38:03','2019-03-14 16:38:03'),(87,61,2,3,'2019-03-16','2019-03-18','2019-03-14 09:44:21','2019-03-14 16:44:21'),(88,61,2,3,'2019-03-18','2019-03-20','2019-03-14 09:44:29','2019-03-14 16:44:29'),(89,60,1,3,'2019-03-16','2019-03-18','2019-03-14 09:44:34','2019-03-14 16:44:34'),(90,60,1,3,'2019-03-18','2019-03-20','2019-03-14 09:44:39','2019-03-14 16:44:39'),(91,62,1,1,'2019-03-23','2019-03-25','2019-03-21 08:29:39','2019-03-21 15:29:39');
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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rak_id` (`rak_id`),
  CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`rak_id`) REFERENCES `rak` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,1,'Desain Grafis','2019-01-21 10:12:52',NULL),(2,2,'Jaringan Komputer','2019-03-02 07:41:20',NULL),(3,3,'Pemrograman Web','2019-03-02 07:41:37',NULL),(5,4,'Pemrograman Android','2019-03-24 12:45:16',NULL),(8,8,'Microsoft Office','2019-03-24 12:47:53',NULL);
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerbit`
--

LOCK TABLES `penerbit` WRITE;
/*!40000 ALTER TABLE `penerbit` DISABLE KEYS */;
INSERT INTO `penerbit` VALUES (1,'Media Aksara 11','Jl.XYZ no 50 - Jakarta Timur 11','081000','info123@mediaaksara.com','2019-01-22 02:02:45','2019-01-22 03:47:39'),(2,'Erlangga Sukses','Jl. Achmad Yani No 23. Surabaya Jawa Timur','0987654321','info@erlangga.com','2019-03-02 00:39:22','2019-03-24 12:57:50'),(4,'Mizan Store','Jl Blibis Raya, Kota Bandung, Jawa Barat','081234567','info@mizanstore.com','2019-03-24 05:58:24','2019-03-24 12:59:01');
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
  `nama_lengkap` varchar(255) NOT NULL,
  `nama_alias` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penulis`
--

LOCK TABLES `penulis` WRITE;
/*!40000 ALTER TABLE `penulis` DISABLE KEYS */;
INSERT INTO `penulis` VALUES (1,'Matt Shadow','Matt','2019-01-15 07:31:33','2019-03-01 21:00:09'),(2,'John Mayer','Mayer','2019-03-24 05:50:10','0000-00-00 00:00:00'),(3,'Iriyanto','Yanto','2019-03-24 05:51:34','2019-03-24 12:54:30'),(7,'Jack Separo Gendeng','Jack','2019-03-24 05:53:59','2019-03-24 12:54:39');
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
  `tanggal_pinjam` date NOT NULL,
  `qty` int(11) NOT NULL,
  `total_denda` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `anggota_id` (`anggota_id`),
  CONSTRAINT `pinjam_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `pinjam_ibfk_2` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pinjam`
--

LOCK TABLES `pinjam` WRITE;
/*!40000 ALTER TABLE `pinjam` DISABLE KEYS */;
INSERT INTO `pinjam` VALUES (152,'24144cbd22',1,1,'2019-02-08',1,44000,'2019-02-08 02:46:01','2019-03-02 01:22:03'),(153,'24144d3a7a',1,1,'2019-02-08',2,44000,'2019-02-08 02:51:22','2019-03-02 01:06:36'),(154,'24144d81f5',1,1,'2019-02-08',2,44000,'2019-02-08 02:54:25','2019-03-02 01:06:36'),(156,'39bc94a52',1,1,'2019-02-11',1,15000,'2019-02-11 03:36:53','2019-03-02 01:06:36'),(157,'241f99c197',1,2,'2019-03-02',2,0,'2019-03-02 01:25:29','2019-03-02 01:26:02'),(158,'241f9a79fd',1,2,'2019-03-02',1,0,'2019-03-02 01:33:21','2019-03-02 01:34:37'),(159,'39ce34a71',1,2,'2019-03-04',2,0,'2019-03-04 12:58:51','2019-03-04 12:59:58'),(160,'39d16840d',3,1,'2019-03-08',1,0,'2019-03-08 10:13:59','2019-03-08 10:14:21'),(163,'39d2f29ea',1,2,'2019-03-14',1,0,'2019-03-10 07:06:12','2019-03-14 09:34:41'),(164,'39d3d2a63',1,2,'2019-03-15',1,0,'2019-03-11 08:35:34','0000-00-00 00:00:00'),(165,'39d64ae54',1,2,'2019-03-16',1,0,'2019-03-14 08:31:42','2019-03-14 09:34:32'),(166,'2425ef405d',1,1,'2019-03-17',1,0,'2019-03-14 08:36:32','2019-03-14 09:41:25'),(167,'2425ef5c7c',1,1,'2019-03-17',1,0,'2019-03-14 08:37:44','2019-03-14 09:45:32'),(170,'2425f25f20',3,2,'2019-03-19',1,0,'2019-03-14 09:10:37','2019-03-14 09:34:32'),(171,'2425f56e54',3,1,'2019-03-20',2,0,'2019-03-14 09:44:02','0000-00-00 00:00:00'),(172,'2429897000',1,2,'2019-03-21',1,0,'2019-03-21 08:29:16','0000-00-00 00:00:00');
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
  `status` int(11) NOT NULL COMMENT '1 = Keluar / 0= Kembali',
  `tanggal_kembali` date NOT NULL,
  `denda` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pinjam_id` (`pinjam_id`),
  CONSTRAINT `pinjam_detail_ibfk_1` FOREIGN KEY (`pinjam_id`) REFERENCES `pinjam` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pinjam_detail`
--

LOCK TABLES `pinjam_detail` WRITE;
/*!40000 ALTER TABLE `pinjam_detail` DISABLE KEYS */;
INSERT INTO `pinjam_detail` VALUES (41,152,1,0,'2019-02-08',0,'2019-03-01',22000,'2019-02-08 02:46:01','2019-03-02 08:21:45'),(42,152,2,0,'2019-02-08',0,'2019-03-01',22000,'2019-02-08 02:46:01','2019-03-02 08:21:45'),(43,153,1,0,'2019-02-08',0,'2019-03-02',22000,'2019-02-08 02:51:23','2019-03-02 08:22:03'),(44,153,2,0,'2019-02-08',0,'2019-03-02',22000,'2019-02-08 02:51:23','2019-03-02 08:22:03'),(45,154,1,0,'2019-02-08',0,'2019-03-02',22000,'2019-02-08 02:54:25','2019-03-02 08:22:03'),(46,154,2,0,'2019-02-08',0,'2019-03-03',22000,'2019-02-08 02:54:25','2019-03-02 08:22:03'),(47,156,2,0,'2019-02-15',0,'2019-03-03',15000,'2019-02-11 03:36:53','2019-03-02 08:22:03'),(48,157,1,0,'2019-03-02',0,'2019-03-10',0,'2019-03-02 01:25:29','2019-03-02 08:26:02'),(49,157,2,0,'2019-03-02',0,'2019-03-10',0,'2019-03-02 01:25:29','2019-03-02 08:26:02'),(50,158,1,0,'2019-03-04',0,'2019-03-11',0,'2019-03-02 01:33:21','2019-03-02 08:34:37'),(51,159,1,0,'2019-03-06',0,'2019-03-11',0,'2019-03-04 12:58:51','2019-03-04 19:59:58'),(52,159,2,0,'2019-03-06',0,'2019-03-12',0,'2019-03-04 12:58:51','2019-03-04 19:59:58'),(53,160,1,0,'2019-03-10',0,'2019-03-12',0,'2019-03-08 10:13:59','2019-03-08 17:14:21'),(54,163,2,2,'2019-04-06',0,'2019-03-14',0,'2019-03-10 07:06:12','2019-03-14 16:34:41'),(55,164,1,2,'2019-04-06',0,'2019-03-14',0,'2019-03-11 08:35:34','2019-03-14 16:34:32'),(56,165,2,0,'2019-03-16',0,'2019-03-14',0,'2019-03-14 08:31:42','2019-03-14 16:34:07'),(57,166,2,2,'2019-03-20',0,'2019-03-14',0,'2019-03-14 08:36:32','2019-03-14 16:41:25'),(58,167,1,2,'2019-03-20',0,'2019-03-14',0,'2019-03-14 08:37:44','2019-03-14 16:45:27'),(59,170,1,0,'2019-03-16',0,'2019-03-14',0,'2019-03-14 09:10:37','2019-03-14 16:34:07'),(60,171,1,2,'2019-03-20',0,'2019-03-14',0,'2019-03-14 09:44:02','2019-03-14 16:45:32'),(61,171,2,2,'2019-03-20',0,'2019-03-14',0,'2019-03-14 09:44:02','2019-03-14 16:45:32'),(62,172,1,1,'2019-03-25',1,'0000-00-00',0,'2019-03-21 08:29:16','0000-00-00 00:00:00');
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
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `buku_id` (`buku_id`),
  CONSTRAINT `pinjam_temp_ibfk_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pinjam_temp`
--

LOCK TABLES `pinjam_temp` WRITE;
/*!40000 ALTER TABLE `pinjam_temp` DISABLE KEYS */;
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rak`
--

LOCK TABLES `rak` WRITE;
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
INSERT INTO `rak` VALUES (1,'A001','2019-01-15 07:24:16','2019-01-20 20:42:21'),(2,'A002','2019-01-15 07:24:16','2019-01-18 23:35:30'),(3,'A003','2019-01-18 08:16:04','2019-01-18 23:27:33'),(4,'B001','2019-03-24 05:41:13',NULL),(5,'C001','2019-03-24 05:41:23',NULL),(8,'B002','2019-03-24 05:43:06',NULL);
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
  `nama_lengkap` varchar(50) NOT NULL,
  `panggilan` varchar(20) NOT NULL,
  `jenis_kelamin` int(11) NOT NULL COMMENT '1= Laki-Laki, 0=Perempuan',
  `alamat` text NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `hak_akses` int(11) NOT NULL COMMENT '1= Administrator, 0=Operator',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1= Aktif, 0=Non Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Irving Dian Pratama ','Irving',1,'Sokaraja Tengah RT 2. RW 4 ','089123098',1,'admin@simperpus.com','5a07d51143f9a970549192acdba49d01',1,'2018-12-20 04:35:57','2019-03-24 14:49:33'),(3,'John Lennon','Lennon',0,'Jimmy Street No 23. Paris','0987654321',0,'johnlennon@simperpus.com','5a07d51143f9a970549192acdba49d01',0,'2019-03-07 13:34:21','2019-03-24 13:59:47'),(4,'Iriyanto','Yanto',0,'Sokaraja Tengah, Banyumas','098567432',0,'iriyanto@gmail.com','5a07d51143f9a970549192acdba49d01',1,'2019-03-24 06:59:32','2019-03-25 11:02:18'),(5,'Lisa Blekping','Lisa',0,'Seoul, Kroya Kidul ','09874512412',1,'lisablekping@simperpus.com','5a07d51143f9a970549192acdba49d01',1,'2019-03-24 07:13:45','2019-03-24 15:13:59'),(6,'Jack Separo Gendeng','John',0,'wdwdw','1223',0,'pratama828@gmail.com','5a07d51143f9a970549192acdba49d01',0,'2019-03-24 07:15:00','2019-03-24 14:15:08');
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

-- Dump completed on 2019-03-25 11:11:26
