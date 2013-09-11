-- MySQL dump 10.13  Distrib 5.1.69, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: qm
-- ------------------------------------------------------
-- Server version	5.1.69-log

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
-- Table structure for table `criteria`
--

DROP TABLE IF EXISTS `criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criteria` (
  `criteria_id` int(5) NOT NULL AUTO_INCREMENT,
  `criteria_title` varchar(200) DEFAULT NULL,
  `criteria_rate` int(5) DEFAULT NULL,
  `tenant_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`criteria_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criteria`
--

LOCK TABLES `criteria` WRITE;
/*!40000 ALTER TABLE `criteria` DISABLE KEYS */;
INSERT INTO `criteria` VALUES (1,'Proper Opening',14,1),(2,'Presentation',19,1),(3,'Closing',33,1),(4,'Overall',34,1),(5,'test',0,1),(6,'test',10,1),(7,'test2',90,1),(8,'test',NULL,1),(9,'test3',0,1),(10,'Business Critical',100,1),(11,'biz critical',70,1),(12,'technical',30,1),(13,'sales',NULL,1),(14,'technical',NULL,1),(15,'1 Form To Rule Them All',100,1),(16,'technique',0,1),(17,'opening',0,1),(18,'datacom category 1',0,2),(19,'datacom category 2',NULL,NULL),(20,'opening',NULL,NULL),(21,'closing',NULL,NULL);
/*!40000 ALTER TABLE `criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criteria_and_question`
--

DROP TABLE IF EXISTS `criteria_and_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criteria_and_question` (
  `criteria_id` int(5) NOT NULL,
  `question_id` int(5) NOT NULL,
  `qm_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criteria_and_question`
--

LOCK TABLES `criteria_and_question` WRITE;
/*!40000 ALTER TABLE `criteria_and_question` DISABLE KEYS */;
INSERT INTO `criteria_and_question` VALUES (1,1,1),(1,2,1),(1,3,1),(2,4,1),(2,5,1),(2,6,1),(2,7,1),(3,8,1),(3,9,1),(3,10,1),(3,11,1),(3,12,1),(3,13,1),(3,14,1),(4,15,1),(4,16,1),(4,17,1),(4,18,1),(4,19,1),(4,20,1),(4,21,1),(16,41,11),(16,42,11),(16,43,11),(17,44,11),(17,45,11),(13,48,6),(13,49,6),(13,50,6),(14,51,6),(14,52,6),(14,53,6),(18,54,12),(18,56,12),(18,57,12),(19,58,12),(19,59,12),(19,60,12),(17,61,11),(17,62,11),(20,63,15),(20,64,15),(20,65,15),(20,66,15),(21,67,15),(21,68,15),(21,69,15);
/*!40000 ALTER TABLE `criteria_and_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dist_hr_freq`
--

DROP TABLE IF EXISTS `dist_hr_freq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dist_hr_freq` (
  `hfid` int(11) NOT NULL AUTO_INCREMENT,
  `distid` int(11) DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `freq` int(11) DEFAULT NULL,
  PRIMARY KEY (`hfid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dist_hr_freq`
--

LOCK TABLES `dist_hr_freq` WRITE;
/*!40000 ALTER TABLE `dist_hr_freq` DISABLE KEYS */;
INSERT INTO `dist_hr_freq` VALUES (1,1,'10:00:00','16:00:00',30),(2,2,'10:00:00','18:00:00',40);
/*!40000 ALTER TABLE `dist_hr_freq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dist_profile`
--

DROP TABLE IF EXISTS `dist_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dist_profile` (
  `distid` int(11) NOT NULL AUTO_INCREMENT,
  `profile` varchar(100) DEFAULT NULL,
  `profile_description` varchar(255) DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `tenantid` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`distid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dist_profile`
--

LOCK TABLES `dist_profile` WRITE;
/*!40000 ALTER TABLE `dist_profile` DISABLE KEYS */;
INSERT INTO `dist_profile` VALUES (1,'testing','testing','2013-08-13 10:57:07',1,1),(2,'careline distribution','careline distribution','0000-00-00 00:00:00',NULL,2),(3,'','','0000-00-00 00:00:00',NULL,1);
/*!40000 ALTER TABLE `dist_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dist_profile_agent`
--

DROP TABLE IF EXISTS `dist_profile_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dist_profile_agent` (
  `distid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dist_profile_agent`
--

LOCK TABLES `dist_profile_agent` WRITE;
/*!40000 ALTER TABLE `dist_profile_agent` DISABLE KEYS */;
INSERT INTO `dist_profile_agent` VALUES (1,1037),(1,1034),(1,1009),(1,1038),(1,1035),(1,1040),(1,1050),(1,1022),(1,1018),(1,1015),(1,1022),(1,1019),(1,1016),(1,1020),(1,1017),(1,1014),(1,1021),(1,1024),(1,1031),(1,1028),(1,1025),(1,1032),(1,1029),(1,1026),(1,1023),(1,1033),(1,1030),(1,1027),(1,1045),(1,1042),(1,1022),(1,1046),(1,1043),(1,1038),(1,1047),(1,1044),(1,1041),(1,1054),(1,1051),(1,1048),(1,1055),(1,1052),(1,1049),(1,1013),(1,1056),(1,1053),(1,1036);
/*!40000 ALTER TABLE `dist_profile_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dist_queue`
--

DROP TABLE IF EXISTS `dist_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dist_queue` (
  `dqid` int(11) NOT NULL AUTO_INCREMENT,
  `distid` int(11) DEFAULT NULL,
  `tenantqueueid` int(11) DEFAULT NULL,
  PRIMARY KEY (`dqid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dist_queue`
--

LOCK TABLES `dist_queue` WRITE;
/*!40000 ALTER TABLE `dist_queue` DISABLE KEYS */;
INSERT INTO `dist_queue` VALUES (1,1,15),(2,1,16),(3,1,18),(4,1,13),(5,2,11),(6,2,2),(7,2,1);
/*!40000 ALTER TABLE `dist_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dist_wrapup`
--

DROP TABLE IF EXISTS `dist_wrapup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dist_wrapup` (
  `dwid` int(10) NOT NULL AUTO_INCREMENT,
  `distid` int(11) DEFAULT NULL,
  `wrapupid` int(11) DEFAULT NULL,
  PRIMARY KEY (`dwid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dist_wrapup`
--

LOCK TABLES `dist_wrapup` WRITE;
/*!40000 ALTER TABLE `dist_wrapup` DISABLE KEYS */;
INSERT INTO `dist_wrapup` VALUES (1,1,89),(2,1,83),(3,2,89),(4,2,83);
/*!40000 ALTER TABLE `dist_wrapup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logged`
--

DROP TABLE IF EXISTS `logged`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logged` (
  `logged_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `logged` mediumint(3) DEFAULT NULL,
  `userid` text,
  PRIMARY KEY (`logged_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logged`
--

LOCK TABLES `logged` WRITE;
/*!40000 ALTER TABLE `logged` DISABLE KEYS */;
INSERT INTO `logged` VALUES (1,0,'');
/*!40000 ALTER TABLE `logged` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `other_recordings_file`
--

DROP TABLE IF EXISTS `other_recordings_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `other_recordings_file` (
  `other_recordings_file_id` int(6) NOT NULL AUTO_INCREMENT,
  `record_id` int(6) NOT NULL,
  `filename` varchar(300) NOT NULL,
  PRIMARY KEY (`other_recordings_file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `other_recordings_file`
--

LOCK TABLES `other_recordings_file` WRITE;
/*!40000 ALTER TABLE `other_recordings_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `other_recordings_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qm_and_criteria`
--

DROP TABLE IF EXISTS `qm_and_criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qm_and_criteria` (
  `qm_id` int(5) NOT NULL,
  `criteria_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qm_and_criteria`
--

LOCK TABLES `qm_and_criteria` WRITE;
/*!40000 ALTER TABLE `qm_and_criteria` DISABLE KEYS */;
INSERT INTO `qm_and_criteria` VALUES (1,1),(1,2),(1,3),(1,4),(6,13),(6,14),(7,15),(11,16),(11,17),(12,18),(12,19),(15,20),(15,21);
/*!40000 ALTER TABLE `qm_and_criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qm_form`
--

DROP TABLE IF EXISTS `qm_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qm_form` (
  `qm_id` int(5) NOT NULL AUTO_INCREMENT,
  `qm_title` varchar(100) DEFAULT NULL,
  `major_rate` int(2) DEFAULT NULL,
  `minor_rate` int(2) DEFAULT NULL,
  `weightage` enum('1','2','3') DEFAULT NULL,
  `tenant_id` int(1) DEFAULT NULL,
  PRIMARY KEY (`qm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qm_form`
--

LOCK TABLES `qm_form` WRITE;
/*!40000 ALTER TABLE `qm_form` DISABLE KEYS */;
INSERT INTO `qm_form` VALUES (1,'60 90 & Pre CTOS',70,30,'1',1),(15,'P1 form',70,30,'1',2),(6,'P1',70,30,'1',1),(7,'Careline Test',0,0,'2',1),(11,'datacom',0,0,'3',1),(12,'datacom form',0,0,'3',2);
/*!40000 ALTER TABLE `qm_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qm_level_rate`
--

DROP TABLE IF EXISTS `qm_level_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qm_level_rate` (
  `qm_id` int(5) DEFAULT NULL,
  `level` smallint(2) DEFAULT NULL,
  `minimum_rate` int(3) DEFAULT NULL,
  `maximum_rate` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qm_level_rate`
--

LOCK TABLES `qm_level_rate` WRITE;
/*!40000 ALTER TABLE `qm_level_rate` DISABLE KEYS */;
INSERT INTO `qm_level_rate` VALUES (11,3,0,70),(11,2,70,79),(11,1,80,100),(12,3,0,69),(12,2,70,79),(12,1,80,100),(13,1,10,10),(13,2,10,10),(13,3,10,10);
/*!40000 ALTER TABLE `qm_level_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `question_id` int(5) NOT NULL AUTO_INCREMENT,
  `question_title` varchar(300) DEFAULT NULL,
  `question_type` enum('y','n') DEFAULT NULL,
  `question_na` enum('1','0') DEFAULT NULL,
  `question_score_y_yes` tinyint(1) DEFAULT NULL COMMENT 'if question answer yes',
  `question_score_y_no` tinyint(1) DEFAULT NULL COMMENT 'if question answer no',
  `question_score_n_a` varchar(5) DEFAULT NULL,
  `question_score_n_a_value` varchar(100) DEFAULT NULL COMMENT 'answer A',
  `question_score_n_b` tinyint(5) DEFAULT NULL COMMENT 'B score',
  `question_score_n_b_value` varchar(100) DEFAULT NULL COMMENT 'answer B',
  `question_score_n_c` tinyint(5) DEFAULT NULL COMMENT 'C score',
  `question_score_n_c_value` varchar(100) DEFAULT NULL COMMENT 'answer C',
  `question_score_n_d` tinyint(5) DEFAULT NULL COMMENT 'D score',
  `question_score_n_d_value` varchar(100) DEFAULT NULL COMMENT 'answer D',
  `question_score_n_e` tinyint(5) DEFAULT NULL COMMENT 'E score',
  `question_score_n_e_value` varchar(100) DEFAULT NULL COMMENT 'answer E',
  `question_score_n_answer` varchar(2) DEFAULT NULL,
  `question_score_n` tinyint(5) DEFAULT NULL,
  `question_top_score` mediumint(5) DEFAULT NULL,
  `question_format` tinyint(2) DEFAULT NULL,
  `tenant_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'Introduction (Self & Company)','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(2,'Purpose of Calling','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(3,'Convenient to Talk','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(4,'Re-confirm with Customer Existing Plan','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(5,'Qualifying & Understanding Customer of late payment','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(6,'Positioning & Resolution','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(7,'Bill breakdown & Waiver Given','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(8,'Payment Option/Auto Pay','y','1',1,0,'','',0,'',0,'',0,'',0,'',NULL,NULL,1,1,1),(9,'Verification Of Customer information','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(10,'Provide CRMS ID','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(11,'Educate customer on bill statement viewing/Billing Cycle/Recnnection Fee','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(12,'CTOS warning','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(13,'P1 Contact point & After sales services tools.(Self-care)','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(14,'Proper Closing','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(15,'Communication Skills - Choice of Words & Tone of Voice','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(16,'Communication Skills - Active Listening & Understanding','y','0',1,0,'0','',0,'',0,'',0,'',0,'',NULL,NULL,1,1,1),(17,'Empathy towards customer','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(18,'Applying proper Hold and wait Process.','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(19,'Additional needs Uncovered','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(20,'Professionalism & Misleading Information','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(21,'Leads system Reason Code update','y','0',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(22,'test fatal','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(23,'test minor','n','',0,0,'','',0,'',0,'',0,'',0,'',NULL,NULL,1,2,1),(24,'test fatal in test2 form','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(25,'test','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(26,'test no weightage question','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1),(27,'test12','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,2,1),(28,'test324','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(29,'fatal here','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(30,'minor here asd','n','',NULL,NULL,'1','true',0,'false',0,'',0,'',0,'',NULL,NULL,1,2,1),(31,'fatal for this','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(32,'sadfad','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1),(33,'major test 1-2','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(34,'tseadfadsf','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,2,1),(35,'minion','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(36,'minion 2','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1),(37,'tessadf','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(38,'Correct Scipting','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(42,'adfsaf','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,5,1),(41,'test','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,4,1),(43,'asdf','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,6,1),(44,'critical business','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,4,1),(45,'Critical Customer','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,5,1),(46,'Non Critical','','1',0,0,'0','0',0,'0',0,'0',0,'0',0,'0',NULL,NULL,1,6,1),(47,'careline question','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,6,2),(48,'major','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(49,'minor','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,2,1),(50,'fatal question','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(51,'major 2','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(52,'minor','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,2,1),(53,'fatal 2','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1),(54,'datacom question 1','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,4,2),(55,'datacom category 2','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,5,2),(56,'datacom question 2','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,6,2),(57,'datacom question 3','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,5,2),(58,'datacom question 4','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,4,2),(59,'datacom question 5','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,5,2),(60,'datacom question 6','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,6,2),(61,'Non Critical','y','1',1,0,'','',0,'',0,'',0,'',0,'',NULL,NULL,1,6,1),(62,'critical business 2','n','1',0,0,'1','True',0,'False',0,'',0,'',0,'',NULL,NULL,1,4,1),(63,'Opening question 1','y','1',1,0,'','',0,'',0,'',0,'',0,'',NULL,NULL,1,1,2),(64,'Opening question 2','y','1',1,0,'','',0,'',0,'',0,'',0,'',NULL,NULL,1,1,2),(65,'Opening question 3','y','1',1,0,'','',0,'',0,'',0,'',0,'',NULL,NULL,1,2,2),(66,'Opening question 4','','',0,0,'0','0',0,'0',0,'0',0,'0',0,'0',NULL,NULL,NULL,3,2),(67,'Closing question 1','y','1',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,2),(68,'Closing question 2','y','',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,2,2),(69,'Closing question 3','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,2);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate_info`
--

DROP TABLE IF EXISTS `rate_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate_info` (
  `rate_info_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `userid` int(5) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `connecttime` datetime DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `callerid` varchar(15) DEFAULT NULL,
  `record_id` bigint(5) DEFAULT NULL,
  `qm_title` varchar(100) DEFAULT NULL,
  `qm_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`rate_info_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate_info`
--

LOCK TABLES `rate_info` WRITE;
/*!40000 ALTER TABLE `rate_info` DISABLE KEYS */;
INSERT INTO `rate_info` VALUES (1,1002,'Yap','Poh Eng','0000-00-00 00:00:00','0','0',1,'datacom',11),(2,1081,'','Agent5','0000-00-00 00:00:00','0','0',2,'datacom',11),(3,1082,'','Agent6','0000-00-00 00:00:00','0','0',3,'datacom',11),(4,1084,'','Agent8','0000-00-00 00:00:00','0','0',4,'P1',6),(5,1083,'','Agent7','0000-00-00 00:00:00','0','0',5,'datacom',11),(6,1002,'Yap','Poh Eng','2013-07-17 17:20:08','SIP/3502','60374523500',10,'datacom form',12),(7,1005,'Ahmad Mustaffa ','Ahmad Khairil ','2013-07-17 17:41:53','SIP/3501','60374523500',12,'datacom form',12),(8,1022,'Abdul Rahman','Norazlifah','0000-00-00 00:00:00','0','0',19,'P1',6),(9,1005,'Ahmad Mustaffa ','Ahmad Khairil ','2013-07-17 18:02:35','SIP/3501','60374523500',11,'datacom form',12);
/*!40000 ALTER TABLE `rate_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate_info_criteria`
--

DROP TABLE IF EXISTS `rate_info_criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate_info_criteria` (
  `criteria_id` int(5) DEFAULT NULL,
  `criteria_title` varchar(200) DEFAULT NULL,
  `criteria_rate` tinyint(5) DEFAULT NULL,
  `record_id` bigint(11) DEFAULT NULL,
  UNIQUE KEY `criteria_id` (`criteria_id`,`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate_info_criteria`
--

LOCK TABLES `rate_info_criteria` WRITE;
/*!40000 ALTER TABLE `rate_info_criteria` DISABLE KEYS */;
INSERT INTO `rate_info_criteria` VALUES (17,'opening',NULL,1),(16,'test',NULL,1),(17,'opening',NULL,2),(16,'test',NULL,2),(17,'opening',NULL,3),(16,'test',NULL,3),(13,'sales',NULL,4),(14,'technical',NULL,4),(17,'opening',NULL,5),(16,'test',NULL,5),(18,'datacom category 1',0,10),(19,'datacom category 2',NULL,10),(18,'datacom category 1',0,12),(19,'datacom category 2',NULL,12),(13,'sales',NULL,19),(14,'technical',NULL,19),(18,'datacom category 1',0,11),(19,'datacom category 2',NULL,11);
/*!40000 ALTER TABLE `rate_info_criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate_info_question`
--

DROP TABLE IF EXISTS `rate_info_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate_info_question` (
  `criteria_id` int(5) DEFAULT NULL,
  `question_id` int(5) DEFAULT NULL,
  `question_title` varchar(200) DEFAULT NULL,
  `question_score` smallint(5) DEFAULT NULL,
  `question_score_total` mediumint(5) DEFAULT NULL,
  `question_remark` tinytext,
  `question_overall_remark` text,
  `record_id` bigint(11) DEFAULT NULL,
  `final_score` varchar(10) DEFAULT NULL,
  `question_major` varchar(10) DEFAULT NULL,
  `question_minor` varchar(10) DEFAULT NULL,
  `question_fatal` varchar(1) DEFAULT NULL,
  `question_major_total` varchar(10) DEFAULT NULL,
  `question_minor_total` varchar(10) DEFAULT NULL,
  `question_cb_total` varchar(10) DEFAULT NULL,
  `question_cc_total` varchar(10) DEFAULT NULL,
  `question_nc_total` varchar(10) DEFAULT NULL,
  `question_cb` varchar(10) DEFAULT NULL,
  `question_cc` varchar(10) DEFAULT NULL,
  `question_nc` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate_info_question`
--

LOCK TABLES `rate_info_question` WRITE;
/*!40000 ALTER TABLE `rate_info_question` DISABLE KEYS */;
INSERT INTO `rate_info_question` VALUES (17,46,'Non Critical',9911,NULL,'','',1,NULL,NULL,NULL,NULL,NULL,NULL,'50','100','100',NULL,NULL,'9911'),(17,44,'critical business',0,NULL,'','',1,NULL,NULL,NULL,NULL,NULL,NULL,'50','100','100','0',NULL,NULL),(17,45,'Critical Customer',1,NULL,'','',1,NULL,NULL,NULL,NULL,NULL,NULL,'50','100','100',NULL,'1',NULL),(16,42,'adfsaf',1,NULL,'','',1,NULL,NULL,NULL,NULL,NULL,NULL,'50','100','100',NULL,'1',NULL),(16,43,'asdf',1,NULL,'','',1,NULL,NULL,NULL,NULL,NULL,NULL,'50','100','100',NULL,NULL,'1'),(16,41,'test',1,NULL,'','',1,NULL,NULL,NULL,NULL,NULL,NULL,'50','100','100','1',NULL,NULL),(17,44,'critical business',1,NULL,'','',2,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','50','1',NULL,NULL),(17,45,'Critical Customer',1,NULL,'','',2,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','50',NULL,'1',NULL),(17,46,'Non Critical',0,NULL,'','',2,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','50',NULL,NULL,'0'),(16,41,'test',1,NULL,'','',2,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','50','1',NULL,NULL),(16,42,'adfsaf',1,NULL,'','',2,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','50',NULL,'1',NULL),(16,43,'asdf',1,NULL,'','',2,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','50',NULL,NULL,'1'),(17,46,'Non Critical',0,NULL,'','',3,NULL,NULL,NULL,NULL,NULL,NULL,'33.3333333','100','50',NULL,NULL,'0'),(17,44,'critical business',0,NULL,'','',3,NULL,NULL,NULL,NULL,NULL,NULL,'33.3333333','100','50','0',NULL,NULL),(17,45,'Critical Customer',1,NULL,'','',3,NULL,NULL,NULL,NULL,NULL,NULL,'33.3333333','100','50',NULL,'1',NULL),(16,42,'adfsaf',1,NULL,'','',3,NULL,NULL,NULL,NULL,NULL,NULL,'33.3333333','100','50',NULL,'1',NULL),(16,43,'asdf',9911,NULL,'','',3,NULL,NULL,NULL,NULL,NULL,NULL,'33.3333333','100','50',NULL,NULL,'9911'),(16,41,'test',1,NULL,'','',3,NULL,NULL,NULL,NULL,NULL,NULL,'33.3333333','100','50','1',NULL,NULL),(13,48,'major',1,NULL,'','',4,'0','1',NULL,NULL,'0','0',NULL,NULL,NULL,NULL,NULL,NULL),(13,49,'minor',0,NULL,'','',4,'0',NULL,'0',NULL,'0','0',NULL,NULL,NULL,NULL,NULL,NULL),(13,50,'fatal question',0,NULL,'','',4,'0','0',NULL,'1','0','0',NULL,NULL,NULL,NULL,NULL,NULL),(14,51,'major 2',1,NULL,'','',4,'0','1',NULL,NULL,'0','0',NULL,NULL,NULL,NULL,NULL,NULL),(14,52,'minor',1,NULL,'','',4,'0',NULL,'1',NULL,'0','0',NULL,NULL,NULL,NULL,NULL,NULL),(14,53,'fatal 2',0,NULL,'','',4,'0','0',NULL,'0','0','0',NULL,NULL,NULL,NULL,NULL,NULL),(17,44,'critical business',0,NULL,'','',5,NULL,NULL,NULL,NULL,NULL,NULL,'0','0','0','0',NULL,NULL),(17,45,'Critical Customer',0,NULL,'','',5,NULL,NULL,NULL,NULL,NULL,NULL,'0','0','0',NULL,'0',NULL),(17,46,'Non Critical',0,NULL,'','',5,NULL,NULL,NULL,NULL,NULL,NULL,'0','0','0',NULL,NULL,'0'),(16,43,'asdf',0,NULL,'','',5,NULL,NULL,NULL,NULL,NULL,NULL,'0','0','0',NULL,NULL,'0'),(16,41,'test',0,NULL,'','',5,NULL,NULL,NULL,NULL,NULL,NULL,'0','0','0','0',NULL,NULL),(16,42,'adfsaf',0,NULL,'','',5,NULL,NULL,NULL,NULL,NULL,NULL,'0','0','0',NULL,'0',NULL),(18,54,'datacom question 1',1,NULL,'','',10,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100','1',NULL,NULL),(18,56,'datacom question 2',1,NULL,'','',10,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100',NULL,NULL,'1'),(18,57,'datacom question 3',1,NULL,'','',10,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100',NULL,'1',NULL),(19,59,'datacom question 5',1,NULL,'','',10,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100',NULL,'1',NULL),(19,60,'datacom question 6',1,NULL,'','',10,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100',NULL,NULL,'1'),(19,58,'datacom question 4',1,NULL,'','',10,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100','1',NULL,NULL),(18,56,'datacom question 2',1,NULL,'','',12,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100',NULL,NULL,'1'),(18,57,'datacom question 3',1,NULL,'','',12,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100',NULL,'1',NULL),(18,54,'datacom question 1',1,NULL,'','',12,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100','1',NULL,NULL),(19,59,'datacom question 5',1,NULL,'','',12,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100',NULL,'1',NULL),(19,60,'datacom question 6',1,NULL,'','',12,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100',NULL,NULL,'1'),(19,58,'datacom question 4',1,NULL,'','',12,NULL,NULL,NULL,NULL,NULL,NULL,'100','100','100','1',NULL,NULL),(13,48,'major',1,NULL,'','',19,'85','1',NULL,NULL,'100','50',NULL,NULL,NULL,NULL,NULL,NULL),(13,49,'minor',1,NULL,'','',19,'85',NULL,'1',NULL,'100','50',NULL,NULL,NULL,NULL,NULL,NULL),(13,50,'fatal question',0,NULL,'','',19,'85','0',NULL,'0','100','50',NULL,NULL,NULL,NULL,NULL,NULL),(14,52,'minor',0,NULL,'','',19,'85',NULL,'0',NULL,'100','50',NULL,NULL,NULL,NULL,NULL,NULL),(14,53,'fatal 2',0,NULL,'','',19,'85','0',NULL,'0','100','50',NULL,NULL,NULL,NULL,NULL,NULL),(14,51,'major 2',1,NULL,'','',19,'85','1',NULL,NULL,'100','50',NULL,NULL,NULL,NULL,NULL,NULL),(18,54,'datacom question 1',1,NULL,'','',11,NULL,NULL,NULL,NULL,NULL,NULL,'50','0','0','1',NULL,NULL),(18,56,'datacom question 2',0,NULL,'','',11,NULL,NULL,NULL,NULL,NULL,NULL,'50','0','0',NULL,NULL,'0'),(18,57,'datacom question 3',0,NULL,'','',11,NULL,NULL,NULL,NULL,NULL,NULL,'50','0','0',NULL,'0',NULL),(19,58,'datacom question 4',0,NULL,'','',11,NULL,NULL,NULL,NULL,NULL,NULL,'50','0','0','0',NULL,NULL),(19,59,'datacom question 5',0,NULL,'','',11,NULL,NULL,NULL,NULL,NULL,NULL,'50','0','0',NULL,'0',NULL),(19,60,'datacom question 6',0,NULL,'','',11,NULL,NULL,NULL,NULL,NULL,NULL,'50','0','0',NULL,NULL,'0');
/*!40000 ALTER TABLE `rate_info_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recordings`
--

DROP TABLE IF EXISTS `recordings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recordings` (
  `record_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `record_filename` varchar(200) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `unique_id` varchar(32) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `status` enum('1','2','3','4','5') DEFAULT NULL COMMENT '1=new,2=expired,3=pending,4=complete,5=pending to save',
  `recording_type` enum('1','2','3') NOT NULL COMMENT '1= voice, 2= chat , 3= others',
  `others_recording` text COMMENT 'only for chat and others recording',
  `recover` tinyint(1) DEFAULT NULL,
  `monitoring_type` tinyint(1) DEFAULT NULL,
  `tenantid` mediumint(2) DEFAULT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recordings`
--

LOCK TABLES `recordings` WRITE;
/*!40000 ALTER TABLE `recordings` DISABLE KEYS */;
INSERT INTO `recordings` VALUES (1,'',1002,'',1087,'2013-08-05 09:13:11','5','3','',0,NULL,2),(2,'',1081,'',1087,'2013-08-05 10:28:32','4','3','',1,2,2),(3,'',1082,'',1087,'2013-08-05 11:39:23','5','3','',0,2,2),(4,'',1084,'',1087,'2013-08-05 11:40:29','5','3','',1,2,2),(5,'',1083,'',1087,'2013-08-05 11:47:07','5','3','',NULL,2,2),(11,'t2-EN_Promotion_Plans-ast1-1374055035.2725.mp3',1005,'ast1-1374055035.2725',1087,'2013-08-06 02:46:33','5','1','',1,1,2),(10,'t2-EN_Promotion_Plans-ast1-1374052801.913.mp3',1002,'ast1-1374052801.913',1087,'2013-08-06 02:28:16','4','1','',0,2,2),(12,'t2-EN_Promotion_Plans-ast1-1374054010.1249.mp3',1005,'ast1-1374054010.1249',1087,'2013-08-06 02:47:00','4','1','',0,1,2),(16,'t2-EN_Promotion_Plans-ast2-1374059007.476.wav',1005,'ast2-1374059007.476',1087,'2013-08-07 04:17:36','3','1','',1,0,2),(17,'',1049,'',1088,'2013-08-07 05:50:16','3','3','',NULL,NULL,1),(18,'',1056,'',1088,'2013-08-07 05:57:12','3','3','',NULL,NULL,1),(19,'',1022,'',1088,'2013-08-07 05:59:47','4','3','',1,2,1),(20,'t2-EN_Promotion_Plans-ast2-1375167447.1074.wav',1005,'ast2-1375167447.1074',1087,'2013-08-13 10:49:36','3','1','',0,0,2);
/*!40000 ALTER TABLE `recordings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recordings_and_qm`
--

DROP TABLE IF EXISTS `recordings_and_qm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recordings_and_qm` (
  `record_id` bigint(11) DEFAULT NULL,
  `qm_id` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recordings_and_qm`
--

LOCK TABLES `recordings_and_qm` WRITE;
/*!40000 ALTER TABLE `recordings_and_qm` DISABLE KEYS */;
INSERT INTO `recordings_and_qm` VALUES (1,11),(2,11),(3,11),(4,6),(5,11),(6,12),(11,12),(10,12),(12,12),(16,12),(17,6),(18,6),(19,6),(20,12);
/*!40000 ALTER TABLE `recordings_and_qm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voice_tag`
--

DROP TABLE IF EXISTS `voice_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voice_tag` (
  `voice_tag_id` int(5) NOT NULL AUTO_INCREMENT,
  `record_id` bigint(11) DEFAULT NULL,
  `start_tag` varchar(6) DEFAULT NULL,
  `end_tag` varchar(6) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`voice_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voice_tag`
--

LOCK TABLES `voice_tag` WRITE;
/*!40000 ALTER TABLE `voice_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `voice_tag` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-08-13 11:16:53
