-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bikebook
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.10.1

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
-- Table structure for table `ka_admin`
--

DROP TABLE IF EXISTS `ka_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ka_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `now_in` varchar(250) NOT NULL,
  `_pwd_hash` char(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `_salt` char(60) NOT NULL,
  `_mobile` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ka_admin`
--

LOCK TABLES `ka_admin` WRITE;
/*!40000 ALTER TABLE `ka_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `ka_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ka_admin_history`
--

DROP TABLE IF EXISTS `ka_admin_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ka_admin_history` (
  `admin_id` int(10) unsigned NOT NULL,
  `type` enum('last_login','now_in') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ka_admin_history`
--

LOCK TABLES `ka_admin_history` WRITE;
/*!40000 ALTER TABLE `ka_admin_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `ka_admin_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ka_autosave`
--

DROP TABLE IF EXISTS `ka_autosave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ka_autosave` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL,
  `entry_type` varchar(250) NOT NULL,
  `entry_id` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Автосохранение админской херни';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ka_autosave`
--

LOCK TABLES `ka_autosave` WRITE;
/*!40000 ALTER TABLE `ka_autosave` DISABLE KEYS */;
/*!40000 ALTER TABLE `ka_autosave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ka_user`
--

DROP TABLE IF EXISTS `ka_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ka_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `register_date` datetime NOT NULL,
  `email` varchar(150) NOT NULL,
  `dob` date NOT NULL,
  `sex` enum('man','woman') NOT NULL DEFAULT 'man',
  `nickname` varchar(250) NOT NULL,
  `_activated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `_pwd_hash` char(60) NOT NULL,
  `_salt` char(60) NOT NULL,
  `_auth_hash` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_email` (`email`),
  UNIQUE KEY `index_security_hash` (`_pwd_hash`),
  UNIQUE KEY `key_auth` (`id`,`_auth_hash`),
  KEY `sex` (`sex`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ka_user`
--

LOCK TABLES `ka_user` WRITE;
/*!40000 ALTER TABLE `ka_user` DISABLE KEYS */;
INSERT INTO `ka_user` VALUES (1,'2013-02-15 02:58:42','donflash@gmail.com','1987-02-13','man','',1,'$2a$11$arxTMzeYPABSBhdtDFwdAOu9w1nE3DfOL.VllKKmi37YFdu2iWXUS','sEVxaY5EBZ','5Wd.K9f$gN-o80dnDA5f5My17dwfxem19Y#HuSgXIp$SOq@(b#_pnqB0S.-.x.qDnVWWN.NDFk(W8bys7w3!!CI#WC_tXPIZB()IC5Mm9D.Eu-@)HrXm#mURQMbZ34'),(2,'2013-02-21 04:35:41','flash-boss@mail.ru','1987-02-13','man','',0,'$2a$11$h2FdGl6cnzkIksJ669nVkeEaQCXT7WPNGdsf/3ioZpuwj8py60PPi','uq8T-gwcTfU8#2','#y4g9pj(.MF@09mKyxpXZZw$.ZJTVlE6f95eXBD-R(U8#Qq)YUm$Qokls$!jAv9-z)!UNmo.SKuq$QnZ)w9jqNMRpskCQ9kYDl1t26q-@Sn5R4JpD(sOp1wjQsL)c-$zL_E');
/*!40000 ALTER TABLE `ka_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ka_user_session`
--

DROP TABLE IF EXISTS `ka_user_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ka_user_session` (
  `user_id` int(10) unsigned NOT NULL,
  `auth_time` int(10) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `user_agent` varchar(250) NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ka_user_session`
--

LOCK TABLES `ka_user_session` WRITE;
/*!40000 ALTER TABLE `ka_user_session` DISABLE KEYS */;
INSERT INTO `ka_user_session` VALUES (1,1361481144,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.70 Safari/537.17'),(1,1361481367,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.70 Safari/537.17'),(1,1361481388,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.70 Safari/537.17');
/*!40000 ALTER TABLE `ka_user_session` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-02-26 12:45:36
