-- MySQL dump 10.13  Distrib 5.6.16, for osx10.6 (x86_64)
--
-- Host: localhost    Database: gongshi
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `t_login_log`
--

DROP TABLE IF EXISTS `t_login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) DEFAULT NULL,
  `login_datetime` datetime DEFAULT NULL,
  `login_ip` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_login_log`
--

LOCK TABLES `t_login_log` WRITE;
/*!40000 ALTER TABLE `t_login_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_project`
--

DROP TABLE IF EXISTS `t_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_code` varchar(50) DEFAULT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `sts` int(11) DEFAULT NULL,
  `pcontent` varchar(200) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_project`
--

LOCK TABLES `t_project` WRITE;
/*!40000 ALTER TABLE `t_project` DISABLE KEYS */;
INSERT INTO `t_project` VALUES (1,'1','1',1,'1','2014-01-01','2014-01-02',NULL),(2,'123','123',1,'123','2014-01-01','2014-11-02',NULL);
/*!40000 ALTER TABLE `t_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_project_user`
--

DROP TABLE IF EXISTS `t_project_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_project_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uname` varchar(50) DEFAULT NULL,
  `sts` int(11) DEFAULT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_project_user`
--

LOCK TABLES `t_project_user` WRITE;
/*!40000 ALTER TABLE `t_project_user` DISABLE KEYS */;
INSERT INTO `t_project_user` VALUES (1,1,1,'admin',1,NULL),(2,1,2,'1',1,NULL),(3,2,1,'admin',1,NULL);
/*!40000 ALTER TABLE `t_project_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_project_workunit`
--

DROP TABLE IF EXISTS `t_project_workunit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_project_workunit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitname` varchar(40) DEFAULT NULL,
  `sts` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `seq` int(11) DEFAULT NULL,
  `workunit` varchar(40) DEFAULT NULL,
  `bh` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_project_workunit`
--

LOCK TABLES `t_project_workunit` WRITE;
/*!40000 ALTER TABLE `t_project_workunit` DISABLE KEYS */;
INSERT INTO `t_project_workunit` VALUES (1,'台',NULL,10,NULL,'搬家','311');
/*!40000 ALTER TABLE `t_project_workunit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `job` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `sts` int(11) DEFAULT NULL,
  `seq` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_user`
--

LOCK TABLES `t_user` WRITE;
/*!40000 ALTER TABLE `t_user` DISABLE KEYS */;
INSERT INTO `t_user` VALUES (1,'admin','cc','boss','21232f297a57a5a743894a0e4a801fc3',0,0,15),(2,'1','1','1','c4ca4238a0b923820dcc509a6f75849b',NULL,NULL,1),(3,'2','2','2','c81e728d9d4c2f636f067f89cc14862c',NULL,NULL,2),(4,'3','3','3','eccbc87e4b5ce2fe28308fd9f2a7baf3',NULL,NULL,4);
/*!40000 ALTER TABLE `t_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_work_log_project`
--

DROP TABLE IF EXISTS `t_work_log_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_work_log_project` (
  `work_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `starttime` date DEFAULT NULL,
  `endtime` date DEFAULT NULL,
  `hourcount` int(11) DEFAULT NULL,
  `logdate` date DEFAULT NULL,
  `uname` varchar(50) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `projectsum` int(11) DEFAULT NULL,
  `worklogproject` varchar(200) DEFAULT NULL,
  `sts` int(11) DEFAULT NULL,
  `unitname` varchar(40) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `je` float DEFAULT NULL,
  `shr` varchar(50) DEFAULT NULL,
  `shrname` varchar(100) DEFAULT NULL,
  `shdate` date DEFAULT NULL,
  `shcontent` varchar(100) DEFAULT NULL,
  `notes` varchar(100) DEFAULT NULL,
  `bh` varchar(40) DEFAULT NULL,
  `workunit` varchar(40) DEFAULT NULL,
  `workunitid` int(11) DEFAULT NULL,
  PRIMARY KEY (`work_log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_work_log_project`
--

LOCK TABLES `t_work_log_project` WRITE;
/*!40000 ALTER TABLE `t_work_log_project` DISABLE KEYS */;
INSERT INTO `t_work_log_project` VALUES (1,1,NULL,NULL,10,'2014-10-26','admin','cc',2,'12',2,'台',10,20,'admin','cc',NULL,NULL,NULL,'311','搬家',1);
/*!40000 ALTER TABLE `t_work_log_project` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-26 12:58:18
