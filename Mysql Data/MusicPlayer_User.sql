-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: MusicPlayer
-- ------------------------------------------------------
-- Server version	8.0.2-dmr

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
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `upwd` varchar(255) NOT NULL,
  `uemail` varchar(45) DEFAULT NULL,
  `realname` varchar(45) DEFAULT NULL,
  `ucity` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid_UNIQUE` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'JJJJJ','1','joshuamansfieldchan@gmail.coms',NULL,NULL),(2,'Bob','1','u',NULL,NULL),(3,'Tim','1','wef',NULL,NULL),(4,'DanielW','1','qwf',NULL,NULL),(5,'adjasfjhd','1','qf',NULL,NULL),(6,'IURHIU','1','wefa',NULL,NULL),(7,'20128','1','gqew',NULL,NULL),(8,'kSHfkjbyu','1','qgegr',NULL,NULL),(9,'sdfwef','1','wdg',NULL,NULL),(10,'897623108','1','weeff',NULL,NULL),(11,'1lkjdfghi','1','wqeghfwebhu',NULL,NULL),(13,'ALALALAL','','lancemchan@sina.com',NULL,NULL),(14,'dsfsdfdsfds','','jo@goiaho.com',NULL,NULL),(27,'wsdfdsf','$2y$10$wPOwcincL8nhEsolG7sr/O.QDeAvwodYBZHqVZdTMfYuNjYF3132W','iuy@iuhwihe.com','',''),(28,'wsdfdsf','$2y$10$.gpGJbaFbFBspPx7LMusSOqaLOXSEUhkj0rJxQByVk5fLDwdOQgTW','iuy@iuhwihe.com','',''),(29,'1111111111','$2y$10$/DLfxo2X8LL58nKadUoaO.XekAzvG3.TlH3k29yWJx9yQHKQ/f7Be','p@p.p','',''),(30,'Mario','$2y$10$467RviugJsLmAFxOAobE5e8j5zlLRqjOLZMmF2To8atE//eDfiWnG','joshuamansfieldchan@gmail.com','Tgbus','Tgbus'),(31,'1232131442','$2y$10$BpwOLO.SulnL7FI3NcYjY.u1IZxZe6h84Tvi0ZNopBsy/ywMs8V.G','q@q.com','',''),(34,'1232131442','$2y$10$3FUwnFrQCwRDoPwvZS6kYuDggjGYI3zcMIQLnw82LOl/5xe18thou','q@q.com','',''),(35,'1232131442','$2y$10$3FUwnFrQCwRDoPwvZS6kYuDggjGYI3zcMIQLnw82LOl/5xe18thou',NULL,'',''),(36,'1232131442','$2y$10$3FUwnFrQCwRDoPwvZS6kYuDggjGYI3zcMIQLnw82LOl/5xe18thou',NULL,'',''),(37,'1232131442','$2y$10$3FUwnFrQCwRDoPwvZS6kYuDggjGYI3zcMIQLnw82LOl/5xe18thou',NULL,'',''),(38,'Fenghen111','$2y$10$.b/cLuNINJG4yd7rMgDkvOL3IwFEMyuXPPXg2MblC4vYE0TRoZ01q','joshuamansfieldchan1@gmail.com','',''),(39,'Fenghen111','$2y$10$anzof81zYIUye2e9wuTmvexBfzx9paxoZ1w/B0mHUvQyUvHzkvjgi',NULL,'',''),(40,'FengChen','$2y$10$QSSGsx/oKJ7ZwpbAs9s69uOqJTnXyGwntkUvpI8nweYllpYaw65ey','m@m.m','',''),(41,'FengChen','$2y$10$YlqzXYJkFh.6r/ptaWBfuupn/wqsCYyy33XFGRXtnDdtXgbaHuhAG','fc1344@nyu.edu','','');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-12 15:32:33
