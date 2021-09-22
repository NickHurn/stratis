-- MySQL dump 10.13  Distrib 8.0.25, for Linux (x86_64)
--
-- Host: localhost    Database: hireabl
-- ------------------------------------------------------
-- Server version	8.0.25-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accepted_terms`
--

DROP TABLE IF EXISTS `accepted_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accepted_terms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `terms_id` int NOT NULL,
  `accepted_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accepted_terms`
--

LOCK TABLES `accepted_terms` WRITE;
/*!40000 ALTER TABLE `accepted_terms` DISABLE KEYS */;
/*!40000 ALTER TABLE `accepted_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userid` int DEFAULT NULL,
  `line1` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `line2` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `line3` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `county` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_to_address_idx` (`userid`),
  CONSTRAINT `FK_D4E6F81F132696E` FOREIGN KEY (`userid`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,1,'1 Any Road',NULL,NULL,'Anytown','London','EC1 1AB'),(2,2,'edy court','loughton',NULL,'milton keynes','UK','MK5 8DU');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `created_on` datetime NOT NULL,
  `disabled` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,1,'2018-12-20 19:31:06',0);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_data`
--

DROP TABLE IF EXISTS `aml_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aml_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `job_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `authenticity` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_sent` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `testinfo` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `response` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `date_scanned` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_data`
--

LOCK TABLES `aml_data` WRITE;
/*!40000 ALTER TABLE `aml_data` DISABLE KEYS */;
INSERT INTO `aml_data` VALUES (1,2,'0220cea7a1301c1e8f3f2ada78412736','4 edy court','Report Failed','O:8:\"stdClass\":2:{s:16:\"ProfileIDVersion\";O:8:\"stdClass\":2:{s:2:\"ID\";s:36:\"d1546e85-9241-4674-a6ff-6bde0b7b89c8\";s:7:\"Version\";i:0;}s:9:\"InputData\";O:8:\"stdClass\":4:{s:8:\"Personal\";O:8:\"stdClass\":1:{s:15:\"PersonalDetails\";O:8:\"stdClass\":9:{s:5:\"Title\";s:2:\"Mr\";s:8:\"Forename\";s:4:\"matt\";s:7:\"Surname\";s:11:\"dangerfield\";s:6:\"Gender\";s:4:\"Male\";s:6:\"DOBDay\";s:2:\"02\";s:8:\"DOBMonth\";s:2:\"06\";s:7:\"DOBYear\";s:4:\"2021\";s:7:\"Country\";s:3:\"GBR\";s:5:\"Birth\";O:8:\"stdClass\":3:{s:17:\"MothersMaidenName\";s:0:\"\";s:14:\"SurnameAtBirth\";s:0:\"\";s:11:\"TownOfBirth\";s:0:\"\";}}}s:9:\"Addresses\";O:8:\"stdClass\":2:{s:14:\"CurrentAddress\";O:8:\"stdClass\":10:{s:7:\"Country\";s:3:\"GBR\";s:12:\"AddressLine1\";s:11:\"4 edy court\";s:12:\"AddressLine2\";s:6:\"lought\";s:12:\"AddressLine3\";s:13:\"milton keynes\";s:12:\"AddressLine4\";s:7:\"mk5 8DU\";s:12:\"AddressLine5\";s:7:\"mk5 8DU\";s:20:\"FirstYearOfResidence\";s:4:\"2015\";s:21:\"FirstMonthOfResidence\";s:2:\"11\";s:19:\"LastYearOfResidence\";s:4:\"2021\";s:20:\"LastMonthOfResidence\";s:2:\"06\";}s:16:\"PreviousAddress1\";O:8:\"stdClass\":10:{s:7:\"Country\";s:3:\"GBR\";s:12:\"AddressLine1\";s:5:\"5 edy\";s:12:\"AddressLine2\";s:5:\"court\";s:12:\"AddressLine3\";s:13:\"milton keynes\";s:12:\"AddressLine4\";s:5:\"bucks\";s:12:\"AddressLine5\";s:7:\"mk5 8DU\";s:20:\"FirstYearOfResidence\";s:4:\"2003\";s:21:\"FirstMonthOfResidence\";s:2:\"06\";s:19:\"LastYearOfResidence\";s:4:\"2021\";s:20:\"LastMonthOfResidence\";s:2:\"06\";}}s:17:\"IdentityDocuments\";O:8:\"stdClass\":2:{s:21:\"InternationalPassport\";O:8:\"stdClass\":11:{s:6:\"Number\";s:0:\"\";s:19:\"ShortPassportNumber\";s:0:\"\";s:9:\"ExpiryDay\";s:0:\"\";s:11:\"ExpiryMonth\";b:0;s:10:\"ExpiryYear\";b:0;s:15:\"CountryOfOrigin\";s:3:\"GBR\";s:8:\"IssueDay\";s:0:\"\";s:10:\"IssueMonth\";b:0;s:9:\"IssueYear\";b:0;s:8:\"Forename\";s:4:\"matt\";s:7:\"Surname\";s:11:\"dangerfield\";}s:2:\"UK\";O:8:\"stdClass\":2:{s:23:\"NationalInsuranceNumber\";O:8:\"stdClass\":1:{s:6:\"Number\";s:0:\"\";}s:14:\"DrivingLicence\";O:8:\"stdClass\":3:{s:6:\"Number\";s:0:\"\";s:8:\"Forename\";s:4:\"matt\";s:7:\"Surname\";s:11:\"dangerfield\";}}}s:14:\"ContactDetails\";O:8:\"stdClass\":2:{s:13:\"LandTelephone\";O:8:\"stdClass\":1:{s:6:\"Number\";s:10:\"0190874944\";}s:15:\"MobileTelephone\";O:8:\"stdClass\":1:{s:6:\"Number\";s:11:\"07966265939\";}}}}','','N;','2021-06-29 21:24:23');
/*!40000 ALTER TABLE `aml_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apikeys`
--

DROP TABLE IF EXISTS `apikeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apikeys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `apikey` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` int DEFAULT NULL,
  `company` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_accessed` datetime DEFAULT NULL,
  `access_count` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apikeys`
--

LOCK TABLES `apikeys` WRITE;
/*!40000 ALTER TABLE `apikeys` DISABLE KEYS */;
/*!40000 ALTER TABLE `apikeys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_disclosure_data`
--

DROP TABLE IF EXISTS `applicant_disclosure_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_disclosure_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `birth_county` int DEFAULT NULL,
  `address_county` int DEFAULT NULL,
  `applicant_id` int NOT NULL,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `title` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `middlename1` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename2` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename3` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_surname` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_surname_until` int DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_town` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_country` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mothers_maiden_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_line_2` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_towncity` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_country` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_postcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_start_date` date DEFAULT NULL,
  `has_convictions` int DEFAULT NULL,
  `ni_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dl_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dl_country` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_country` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `idcard_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `idcard_country` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_declaration` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FBDE90CCF46527EF` (`birth_county`),
  KEY `IDX_FBDE90CC63BB7A9A` (`address_county`),
  KEY `user1_idx` (`applicant_id`),
  CONSTRAINT `FK_FBDE90CC63BB7A9A` FOREIGN KEY (`address_county`) REFERENCES `counties` (`id`),
  CONSTRAINT `FK_FBDE90CCF46527EF` FOREIGN KEY (`birth_county`) REFERENCES `counties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_disclosure_data`
--

LOCK TABLES `applicant_disclosure_data` WRITE;
/*!40000 ALTER TABLE `applicant_disclosure_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_disclosure_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_disclosure_update_response`
--

DROP TABLE IF EXISTS `applicant_disclosure_update_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_disclosure_update_response` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_disclosure_update_response`
--

LOCK TABLES `applicant_disclosure_update_response` WRITE;
/*!40000 ALTER TABLE `applicant_disclosure_update_response` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_disclosure_update_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_disclosure_verification`
--

DROP TABLE IF EXISTS `applicant_disclosure_verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_disclosure_verification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int DEFAULT NULL,
  `driving_Licence_number` varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `driving_Licence_dob` datetime DEFAULT NULL,
  `driving_Licence_country` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `driving_Licence_issue` datetime DEFAULT NULL,
  `driving_Licence_start` datetime DEFAULT NULL,
  `passport_number` varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_dob` datetime DEFAULT NULL,
  `passport_issue` datetime DEFAULT NULL,
  `passport_nationality` varchar(33) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_certificate_issue` datetime DEFAULT NULL,
  `birth_dob` datetime DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `agree_address` int DEFAULT NULL,
  `agree_dob` int DEFAULT NULL,
  `agree_names` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9FA34AD03E030ACD` (`application_id`),
  CONSTRAINT `FK_9FA34AD03E030ACD` FOREIGN KEY (`application_id`) REFERENCES `applicant_disclosures` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_disclosure_verification`
--

LOCK TABLES `applicant_disclosure_verification` WRITE;
/*!40000 ALTER TABLE `applicant_disclosure_verification` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_disclosure_verification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_disclosures`
--

DROP TABLE IF EXISTS `applicant_disclosures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_disclosures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_id` int NOT NULL,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_status` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hireabl_status` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gbg_status_code` int DEFAULT '0',
  `gbg_status` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gbg_outcome` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gbg_disclosure_number` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_date` datetime DEFAULT NULL,
  `short_url` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_idx` (`code`),
  KEY `user1_idx` (`applicant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_disclosures`
--

LOCK TABLES `applicant_disclosures` WRITE;
/*!40000 ALTER TABLE `applicant_disclosures` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_disclosures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_prev_address`
--

DROP TABLE IF EXISTS `applicant_prev_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_prev_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `county` int DEFAULT NULL,
  `line1` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `line2` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `town_city` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_on` date DEFAULT NULL,
  `end_on` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6127C21758E2FF25` (`county`),
  CONSTRAINT `FK_6127C21758E2FF25` FOREIGN KEY (`county`) REFERENCES `counties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_prev_address`
--

LOCK TABLES `applicant_prev_address` WRITE;
/*!40000 ALTER TABLE `applicant_prev_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_prev_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_prev_name`
--

DROP TABLE IF EXISTS `applicant_prev_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_prev_name` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int NOT NULL,
  `end_date` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_prev_name`
--

LOCK TABLES `applicant_prev_name` WRITE;
/*!40000 ALTER TABLE `applicant_prev_name` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_prev_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_rating`
--

DROP TABLE IF EXISTS `applicant_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_rating` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rating` int DEFAULT NULL,
  `created_on` date NOT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `applicant_id` int NOT NULL,
  `employer_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_rating`
--

LOCK TABLES `applicant_rating` WRITE;
/*!40000 ALTER TABLE `applicant_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_share`
--

DROP TABLE IF EXISTS `applicant_share`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_share` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `applicant_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `created_on` date NOT NULL,
  `unique_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `job_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_share`
--

LOCK TABLES `applicant_share` WRITE;
/*!40000 ALTER TABLE `applicant_share` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_share` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantdata_applicantaddress`
--

DROP TABLE IF EXISTS `applicantdata_applicantaddress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicantdata_applicantaddress` (
  `data_id` int NOT NULL,
  `addr_id` int NOT NULL,
  PRIMARY KEY (`data_id`,`addr_id`),
  UNIQUE KEY `UNIQ_72E88B58174C70DB` (`addr_id`),
  KEY `IDX_72E88B5837F5A13C` (`data_id`),
  CONSTRAINT `FK_72E88B58174C70DB` FOREIGN KEY (`addr_id`) REFERENCES `applicant_prev_address` (`id`),
  CONSTRAINT `FK_72E88B5837F5A13C` FOREIGN KEY (`data_id`) REFERENCES `applicant_disclosure_data` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantdata_applicantaddress`
--

LOCK TABLES `applicantdata_applicantaddress` WRITE;
/*!40000 ALTER TABLE `applicantdata_applicantaddress` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantdata_applicantaddress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantdata_applicantname`
--

DROP TABLE IF EXISTS `applicantdata_applicantname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicantdata_applicantname` (
  `data_id` int NOT NULL,
  `name_id` int NOT NULL,
  PRIMARY KEY (`data_id`,`name_id`),
  UNIQUE KEY `UNIQ_9E44C7CB71179CD6` (`name_id`),
  KEY `IDX_9E44C7CB37F5A13C` (`data_id`),
  CONSTRAINT `FK_9E44C7CB37F5A13C` FOREIGN KEY (`data_id`) REFERENCES `applicant_disclosure_data` (`id`),
  CONSTRAINT `FK_9E44C7CB71179CD6` FOREIGN KEY (`name_id`) REFERENCES `applicant_prev_name` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantdata_applicantname`
--

LOCK TABLES `applicantdata_applicantname` WRITE;
/*!40000 ALTER TABLE `applicantdata_applicantname` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantdata_applicantname` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_verification`
--

DROP TABLE IF EXISTS `bank_verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bank_verification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `confirmed` tinyint(1) NOT NULL,
  `confirm_date` datetime NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_verification`
--

LOCK TABLES `bank_verification` WRITE;
/*!40000 ALTER TABLE `bank_verification` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_verification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkabl_filters`
--

DROP TABLE IF EXISTS `checkabl_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `checkabl_filters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pre_screen` int NOT NULL,
  `history` int NOT NULL,
  `disclosures` int NOT NULL DEFAULT '0',
  `visualid` int NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkabl_filters`
--

LOCK TABLES `checkabl_filters` WRITE;
/*!40000 ALTER TABLE `checkabl_filters` DISABLE KEYS */;
/*!40000 ALTER TABLE `checkabl_filters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checked_details`
--

DROP TABLE IF EXISTS `checked_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `checked_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `jobId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `uniqueId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `forename` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `line1` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `line2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `line3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dlNo` varchar(44) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `passportNo` varchar(2555) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateExp` date DEFAULT NULL,
  `ppOrigin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checked_details`
--

LOCK TABLES `checked_details` WRITE;
/*!40000 ALTER TABLE `checked_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `checked_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checks`
--

DROP TABLE IF EXISTS `checks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `checks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `checkname` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `standard` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checks`
--

LOCK TABLES `checks` WRITE;
/*!40000 ALTER TABLE `checks` DISABLE KEYS */;
/*!40000 ALTER TABLE `checks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `choice_field`
--

DROP TABLE IF EXISTS `choice_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `choice_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  `field_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `choice_field`
--

LOCK TABLES `choice_field` WRITE;
/*!40000 ALTER TABLE `choice_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `choice_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `choice_option`
--

DROP TABLE IF EXISTS `choice_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `choice_option` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `filter_on` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `choice_option`
--

LOCK TABLES `choice_option` WRITE;
/*!40000 ALTER TABLE `choice_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `choice_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `choicefield_choiceoptions`
--

DROP TABLE IF EXISTS `choicefield_choiceoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `choicefield_choiceoptions` (
  `field_id` int NOT NULL,
  `option_id` int NOT NULL,
  PRIMARY KEY (`field_id`,`option_id`),
  UNIQUE KEY `UNIQ_D6628E75A7C41D6F` (`option_id`),
  KEY `IDX_D6628E75443707B0` (`field_id`),
  CONSTRAINT `FK_D6628E75443707B0` FOREIGN KEY (`field_id`) REFERENCES `choice_field` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D6628E75A7C41D6F` FOREIGN KEY (`option_id`) REFERENCES `choice_option` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `choicefield_choiceoptions`
--

LOCK TABLES `choicefield_choiceoptions` WRITE;
/*!40000 ALTER TABLE `choicefield_choiceoptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `choicefield_choiceoptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classmarker_group_results`
--

DROP TABLE IF EXISTS `classmarker_group_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classmarker_group_results` (
  `pk_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `test_id` int NOT NULL,
  `group_id` int NOT NULL,
  `first` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `last` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `percentage` decimal(5,1) NOT NULL,
  `points_scored` decimal(5,1) NOT NULL,
  `points_available` decimal(5,1) NOT NULL,
  `time_started` int NOT NULL,
  `time_finished` int NOT NULL,
  `duration` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `requires_grading` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pk_id`),
  UNIQUE KEY `user_id` (`user_id`,`test_id`,`group_id`,`time_finished`),
  KEY `test_id` (`test_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classmarker_group_results`
--

LOCK TABLES `classmarker_group_results` WRITE;
/*!40000 ALTER TABLE `classmarker_group_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `classmarker_group_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classmarker_groups`
--

DROP TABLE IF EXISTS `classmarker_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classmarker_groups` (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classmarker_groups`
--

LOCK TABLES `classmarker_groups` WRITE;
/*!40000 ALTER TABLE `classmarker_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `classmarker_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classmarker_link_results`
--

DROP TABLE IF EXISTS `classmarker_link_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classmarker_link_results` (
  `pk_id` int NOT NULL AUTO_INCREMENT,
  `link_result_id` int NOT NULL,
  `test_id` int NOT NULL,
  `link_id` int NOT NULL,
  `first` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `last` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `percentage` decimal(5,1) DEFAULT NULL,
  `points_scored` decimal(5,1) NOT NULL,
  `points_available` decimal(5,1) NOT NULL,
  `time_started` int DEFAULT NULL,
  `time_finished` int DEFAULT NULL,
  `duration` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `requires_grading` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cm_user_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `extra_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `extra_info2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `extra_info3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `extra_info4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `extra_info5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pk_id`),
  UNIQUE KEY `link_result_id` (`link_result_id`,`time_finished`),
  KEY `test_id` (`test_id`),
  KEY `link_id` (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classmarker_link_results`
--

LOCK TABLES `classmarker_link_results` WRITE;
/*!40000 ALTER TABLE `classmarker_link_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `classmarker_link_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classmarker_links`
--

DROP TABLE IF EXISTS `classmarker_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classmarker_links` (
  `link_id` int NOT NULL AUTO_INCREMENT,
  `link_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link_url` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `test_id` int DEFAULT NULL,
  PRIMARY KEY (`link_id`),
  UNIQUE KEY `link_id` (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classmarker_links`
--

LOCK TABLES `classmarker_links` WRITE;
/*!40000 ALTER TABLE `classmarker_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `classmarker_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classmarker_tests`
--

DROP TABLE IF EXISTS `classmarker_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classmarker_tests` (
  `test_id` int NOT NULL AUTO_INCREMENT,
  `test_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`test_id`),
  UNIQUE KEY `test_id` (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classmarker_tests`
--

LOCK TABLES `classmarker_tests` WRITE;
/*!40000 ALTER TABLE `classmarker_tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `classmarker_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `completed_form`
--

DROP TABLE IF EXISTS `completed_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `completed_form` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `employer_id` int DEFAULT NULL,
  `form_type_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_360A08735FF69B7D` (`form_id`),
  KEY `IDX_360A0873A76ED395` (`user_id`),
  KEY `IDX_360A087341CD9E7A` (`employer_id`),
  KEY `IDX_360A0873F420ECA8` (`form_type_id`),
  KEY `IDX_360A0873BE04EA9` (`job_id`),
  CONSTRAINT `FK_360A087341CD9E7A` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`),
  CONSTRAINT `FK_360A08735FF69B7D` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`),
  CONSTRAINT `FK_360A0873A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_360A0873BE04EA9` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  CONSTRAINT `FK_360A0873F420ECA8` FOREIGN KEY (`form_type_id`) REFERENCES `form_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `completed_form`
--

LOCK TABLES `completed_form` WRITE;
/*!40000 ALTER TABLE `completed_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `completed_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consent_import`
--

DROP TABLE IF EXISTS `consent_import`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consent_import` (
  `id` int NOT NULL AUTO_INCREMENT,
  `consent_file` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `qualification_id` int DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consent_import`
--

LOCK TABLES `consent_import` WRITE;
/*!40000 ALTER TABLE `consent_import` DISABLE KEYS */;
/*!40000 ALTER TABLE `consent_import` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactrequest`
--

DROP TABLE IF EXISTS `contactrequest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactrequest` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactrequest`
--

LOCK TABLES `contactrequest` WRITE;
/*!40000 ALTER TABLE `contactrequest` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactrequest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counties`
--

DROP TABLE IF EXISTS `counties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `counties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `county` varchar(155) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counties`
--

LOCK TABLES `counties` WRITE;
/*!40000 ALTER TABLE `counties` DISABLE KEYS */;
INSERT INTO `counties` VALUES (1,'Bath and North East Somerset'),(2,'Bedford'),(3,'Blackburn with Darwen'),(4,'Blackpool'),(5,'Bournemouth'),(6,'Bracknell Forest'),(7,'Brighton & Hove'),(8,'Bristol'),(9,'Buckinghamshire'),(10,'Cambridgeshire'),(11,'Central Bedfordshire'),(12,'Cheshire East'),(13,'Cheshire West and Chester'),(14,'Cornwall'),(15,'County Durham'),(16,'Cumbria'),(17,'Darlington'),(18,'Derby'),(19,'Derbyshire'),(20,'Devon'),(21,'Dorset'),(22,'East Riding of Yorkshire'),(23,'East Sussex'),(24,'Essex'),(25,'Gloucestershire'),(26,'Greater London'),(27,'Greater Manchester'),(28,'Halton'),(29,'Hampshire'),(30,'Hartlepool'),(31,'Herefordshire'),(32,'Hertfordshire'),(33,'Hull'),(34,'Isle of Wight'),(35,'Isles of Scilly'),(36,'Kent'),(37,'Lancashire'),(38,'Leicester'),(39,'Leicestershire'),(40,'Lincolnshire'),(41,'Luton'),(42,'Medway'),(43,'Merseyside'),(44,'Middlesbrough'),(45,'Middlesex'),(46,'Milton Keynes'),(47,'Norfolk'),(48,'North East Lincolnshire'),(49,'North Lincolnshire'),(50,'North Somerset'),(51,'North Yorkshire'),(52,'Northamptonshire'),(53,'Northumberland'),(54,'Nottingham'),(55,'Nottinghamshire'),(56,'Oxfordshire'),(57,'Peterborough'),(58,'Plymouth'),(59,'Poole'),(60,'Portsmouth'),(61,'Reading'),(62,'Redcar and Cleveland'),(63,'Rutland'),(64,'Shropshire'),(65,'Slough'),(66,'Somerset'),(67,'South Gloucestershire'),(68,'South Yorkshire'),(69,'Southampton'),(70,'Southend-on-Sea'),(71,'Staffordshire'),(72,'Stockton-on-Tees'),(73,'Stoke-on-Trent'),(74,'Suffolk'),(75,'Surrey'),(76,'Swindon'),(77,'Telford and Wrekin'),(78,'Thurrock'),(79,'Torbay'),(80,'Tyne and Wear'),(81,'Warrington'),(82,'Warwickshire'),(83,'West Berkshire'),(84,'West Midlands'),(85,'West Sussex'),(86,'West Yorkshire'),(87,'Wiltshire'),(88,'Windsor and Maidenhead'),(89,'Wokingham'),(90,'Worcestershire'),(91,'York');
/*!40000 ALTER TABLE `counties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country_field`
--

DROP TABLE IF EXISTS `country_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `country_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `default_country` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country_field`
--

LOCK TABLES `country_field` WRITE;
/*!40000 ALTER TABLE `country_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `country_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credit`
--

DROP TABLE IF EXISTS `credit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `credit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int NOT NULL,
  `credits` int NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credit`
--

LOCK TABLES `credit` WRITE;
/*!40000 ALTER TABLE `credit` DISABLE KEYS */;
/*!40000 ALTER TABLE `credit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `css_schemes`
--

DROP TABLE IF EXISTS `css_schemes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `css_schemes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int DEFAULT NULL,
  `domain` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_background` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `header_logo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `footer_background` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `footer_logo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `footer_co_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `header_logo_admin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `header_background_admin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `footer_background_admin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `footer_logo_admin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_from` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9D340ADC41CD9E7A` (`employer_id`),
  CONSTRAINT `FK_9D340ADC41CD9E7A` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `css_schemes`
--

LOCK TABLES `css_schemes` WRITE;
/*!40000 ALTER TABLE `css_schemes` DISABLE KEYS */;
INSERT INTO `css_schemes` VALUES (1,1,'stratis.local.co.uk','Stratis Digital','#094166','','','#094166','Stratis Digital Limited','','#094166','#064166','','0800 123 1234','info@hireabl.com');
/*!40000 ALTER TABLE `css_schemes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cv`
--

DROP TABLE IF EXISTS `cv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cv` (
  `id` int NOT NULL AUTO_INCREMENT,
  `original_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `stored_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cv`
--

LOCK TABLES `cv` WRITE;
/*!40000 ALTER TABLE `cv` DISABLE KEYS */;
INSERT INTO `cv` VALUES (1,NULL,'8a539719f1a091b0e82d42aa7d690ce.pdf','0220cea7a1301c1e8f3f2ada78412736','2','application/pdf','2021-06-29 20:54:32');
/*!40000 ALTER TABLE `cv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cv_check`
--

DROP TABLE IF EXISTS `cv_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cv_check` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cv_check`
--

LOCK TABLES `cv_check` WRITE;
/*!40000 ALTER TABLE `cv_check` DISABLE KEYS */;
INSERT INTO `cv_check` VALUES (9,1,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `cv_check` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboard_config`
--

DROP TABLE IF EXISTS `dashboard_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dashboard_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `overview_config` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `detail_config` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboard_config`
--

LOCK TABLES `dashboard_config` WRITE;
/*!40000 ALTER TABLE `dashboard_config` DISABLE KEYS */;
INSERT INTO `dashboard_config` VALUES (1,1,'[\"\",[\"1\",\"4\",\"0\",\"3\",\"2\"],[\"1\",\"7\",\"1\",\"3\",\"3\"],[\"1\",\"0\",\"4\",\"3\",\"2\"],[\"1\",\"1\",\"2\",\"2\",\"2\"],[\"1\",\"0\",\"0\",\"2\",\"2\"],[\"1\",\"3\",\"2\",\"4\",\"1\"],[\"1\",\"7\",\"0\",\"3\",\"1\"],[\"1\",\"5\",\"3\",\"2\",\"2\"],[\"1\",\"7\",\"5\",\"3\",\"1\"],[\"1\",\"2\",\"0\",\"2\",\"2\"],[\"1\",\"7\",\"4\",\"3\",\"1\"]]','[\"\",[\"1\",\"3\",\"0\",\"3\",\"2\"],[\"1\",\"0\",\"0\",\"3\",\"4\"],[\"1\",\"8\",\"3\",\"2\",\"1\"],[\"1\",\"6\",\"0\",\"2\",\"2\"],[\"1\",\"3\",\"2\",\"3\",\"2\"],[\"1\",\"6\",\"2\",\"2\",\"2\"],[\"1\",\"8\",\"2\",\"2\",\"1\"],[\"1\",\"8\",\"0\",\"2\",\"2\"],[\"1\",\"3\",\"4\",\"4\",\"1\"],[\"1\",\"0\",\"4\",\"3\",\"1\"],[\"1\",\"7\",\"4\",\"3\",\"1\"]]');
/*!40000 ALTER TABLE `dashboard_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `date_field`
--

DROP TABLE IF EXISTS `date_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `date_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `date_field`
--

LOCK TABLES `date_field` WRITE;
/*!40000 ALTER TABLE `date_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `date_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `date_value`
--

DROP TABLE IF EXISTS `date_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `date_value` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `field_id` int NOT NULL,
  `value` datetime NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `date_value`
--

LOCK TABLES `date_value` WRITE;
/*!40000 ALTER TABLE `date_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `date_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devphone`
--

DROP TABLE IF EXISTS `devphone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devphone` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `msg` varchar(2185) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rand` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devphone`
--

LOCK TABLES `devphone` WRITE;
/*!40000 ALTER TABLE `devphone` DISABLE KEYS */;
/*!40000 ALTER TABLE `devphone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `director_checks`
--

DROP TABLE IF EXISTS `director_checks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `director_checks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `job_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `companies` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `director_checks`
--

LOCK TABLES `director_checks` WRITE;
/*!40000 ALTER TABLE `director_checks` DISABLE KEYS */;
/*!40000 ALTER TABLE `director_checks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `driving_data`
--

DROP TABLE IF EXISTS `driving_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `driving_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `job_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `building` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `document_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `authenticity` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `testinfo` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `response` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `date_scanned` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `driving_data`
--

LOCK TABLES `driving_data` WRITE;
/*!40000 ALTER TABLE `driving_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `driving_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_field`
--

DROP TABLE IF EXISTS `email_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_field`
--

LOCK TABLES `email_field` WRITE;
/*!40000 ALTER TABLE `email_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_verification`
--

DROP TABLE IF EXISTS `email_verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_verification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  `issue_date` datetime NOT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_verification`
--

LOCK TABLES `email_verification` WRITE;
/*!40000 ALTER TABLE `email_verification` DISABLE KEYS */;
INSERT INTO `email_verification` VALUES (1,'9d9cf2',1,'2021-06-29 20:28:52','2021-06-29 20:30:48','matt.dangerfield@fintech-advisers.com');
/*!40000 ALTER TABLE `email_verification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employer_job_titles`
--

DROP TABLE IF EXISTS `employer_job_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employer_job_titles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int NOT NULL,
  `job_title` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `searchType` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employer_job_titles`
--

LOCK TABLES `employer_job_titles` WRITE;
/*!40000 ALTER TABLE `employer_job_titles` DISABLE KEYS */;
/*!40000 ALTER TABLE `employer_job_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employer_job_tracker`
--

DROP TABLE IF EXISTS `employer_job_tracker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employer_job_tracker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `last_accessed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employer_job_tracker`
--

LOCK TABLES `employer_job_tracker` WRITE;
/*!40000 ALTER TABLE `employer_job_tracker` DISABLE KEYS */;
/*!40000 ALTER TABLE `employer_job_tracker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employers`
--

DROP TABLE IF EXISTS `employers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cameratag_app_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gbg_organisation_id` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_hook_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employers`
--

LOCK TABLES `employers` WRITE;
/*!40000 ALTER TABLE `employers` DISABLE KEYS */;
INSERT INTO `employers` VALUES (1,'Stratis Digital',NULL,'123',NULL);
/*!40000 ALTER TABLE `employers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employers_tests`
--

DROP TABLE IF EXISTS `employers_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employers_tests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `created_by` int NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` int NOT NULL,
  `employer_id` int NOT NULL,
  `link_id` int NOT NULL,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employers_tests`
--

LOCK TABLES `employers_tests` WRITE;
/*!40000 ALTER TABLE `employers_tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `employers_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `excel_test_allocation`
--

DROP TABLE IF EXISTS `excel_test_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `excel_test_allocation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int DEFAULT NULL,
  `test_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excel_test_allocation`
--

LOCK TABLES `excel_test_allocation` WRITE;
/*!40000 ALTER TABLE `excel_test_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `excel_test_allocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `excel_test_results`
--

DROP TABLE IF EXISTS `excel_test_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `excel_test_results` (
  `id` int NOT NULL AUTO_INCREMENT,
  `test_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `time_elapsed` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `correct_words` int DEFAULT NULL,
  `incorrect_words` int DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excel_test_results`
--

LOCK TABLES `excel_test_results` WRITE;
/*!40000 ALTER TABLE `excel_test_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `excel_test_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `excel_tests`
--

DROP TABLE IF EXISTS `excel_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `excel_tests` (
  `test_id` int NOT NULL,
  `file` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`test_id`,`file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excel_tests`
--

LOCK TABLES `excel_tests` WRITE;
/*!40000 ALTER TABLE `excel_tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `excel_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `excel_tests_jobs`
--

DROP TABLE IF EXISTS `excel_tests_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `excel_tests_jobs` (
  `test_id` int NOT NULL,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` int NOT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`test_id`,`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excel_tests_jobs`
--

LOCK TABLES `excel_tests_jobs` WRITE;
/*!40000 ALTER TABLE `excel_tests_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `excel_tests_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extrachecks`
--

DROP TABLE IF EXISTS `extrachecks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extrachecks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int DEFAULT NULL,
  `job_code` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `check_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_requested` datetime NOT NULL,
  `date_completed` datetime DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `result` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extrachecks`
--

LOCK TABLES `extrachecks` WRITE;
/*!40000 ALTER TABLE `extrachecks` DISABLE KEYS */;
INSERT INTO `extrachecks` VALUES (2,1,'0220cea7a1301c1e8f3f2ada78412736',2,'KYC/Pack1','2021-06-29 21:04:35','2021-06-29 21:24:23','Completed','Report Failed');
/*!40000 ALTER TABLE `extrachecks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facecompare_checks`
--

DROP TABLE IF EXISTS `facecompare_checks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facecompare_checks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `source` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `response` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `result` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facecompare_checks`
--

LOCK TABLES `facecompare_checks` WRITE;
/*!40000 ALTER TABLE `facecompare_checks` DISABLE KEYS */;
/*!40000 ALTER TABLE `facecompare_checks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field`
--

DROP TABLE IF EXISTS `field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int NOT NULL,
  `order` int NOT NULL,
  `value_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5BF545585FF69B7D` (`form_id`),
  CONSTRAINT `FK_5BF545585FF69B7D` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field`
--

LOCK TABLES `field` WRITE;
/*!40000 ALTER TABLE `field` DISABLE KEYS */;
/*!40000 ALTER TABLE `field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_id` int DEFAULT NULL,
  `employer_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5288FD4FC54C8C93` (`type_id`),
  KEY `IDX_5288FD4F41CD9E7A` (`employer_id`),
  KEY `IDX_5288FD4FBE04EA9` (`job_id`),
  KEY `IDX_5288FD4FA76ED395` (`user_id`),
  CONSTRAINT `FK_5288FD4F41CD9E7A` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`),
  CONSTRAINT `FK_5288FD4FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_5288FD4FBE04EA9` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  CONSTRAINT `FK_5288FD4FC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `form_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_answers`
--

DROP TABLE IF EXISTS `form_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `user_id` int NOT NULL,
  `seq` int NOT NULL,
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `question_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `answer` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `answer_idx` int DEFAULT NULL,
  `pool_id` int DEFAULT '0',
  `pool_question_id` int DEFAULT '0',
  `secs` int DEFAULT '0',
  `data_values` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `score` int DEFAULT '0',
  `max_score` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_answers`
--

LOCK TABLES `form_answers` WRITE;
/*!40000 ALTER TABLE `form_answers` DISABLE KEYS */;
INSERT INTO `form_answers` VALUES (2,1,2,1,'gt','TEXT',NULL,NULL,NULL,NULL,90,'',NULL,NULL);
/*!40000 ALTER TABLE `form_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_completed`
--

DROP TABLE IF EXISTS `form_completed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_completed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `user_id` int NOT NULL,
  `dt_started` datetime DEFAULT NULL,
  `dt_completed` datetime DEFAULT NULL,
  `score` int DEFAULT NULL,
  `max_score` int DEFAULT NULL,
  `pass_score` int DEFAULT NULL,
  `percentage` int DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_completed`
--

LOCK TABLES `form_completed` WRITE;
/*!40000 ALTER TABLE `form_completed` DISABLE KEYS */;
INSERT INTO `form_completed` VALUES (1,1,2,NULL,'2021-06-29 21:05:00',0,0,0,100,NULL,NULL);
/*!40000 ALTER TABLE `form_completed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_jobs`
--

DROP TABLE IF EXISTS `form_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int DEFAULT NULL,
  `form_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_jobs`
--

LOCK TABLES `form_jobs` WRITE;
/*!40000 ALTER TABLE `form_jobs` DISABLE KEYS */;
INSERT INTO `form_jobs` VALUES (3,1,2,1);
/*!40000 ALTER TABLE `form_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_questions`
--

DROP TABLE IF EXISTS `form_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `seq` int NOT NULL,
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `question_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pool_id` int DEFAULT '0',
  `pool_questions` int DEFAULT '0',
  `required` tinyint(1) DEFAULT NULL,
  `secs` int NOT NULL DEFAULT '0',
  `data_values` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_questions`
--

LOCK TABLES `form_questions` WRITE;
/*!40000 ALTER TABLE `form_questions` DISABLE KEYS */;
INSERT INTO `form_questions` VALUES (1,1,1,'gt','TEXT',1,NULL,NULL,90,''),(2,2,1,'boo','TEXT',1,NULL,NULL,10,''),(3,1,1,'','TEXT',1,NULL,NULL,0,''),(4,1,2,'','TEXT',0,NULL,NULL,0,'');
/*!40000 ALTER TABLE `form_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_type`
--

DROP TABLE IF EXISTS `form_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_type`
--

LOCK TABLES `form_type` WRITE;
/*!40000 ALTER TABLE `form_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_user_jobs`
--

DROP TABLE IF EXISTS `form_user_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_user_jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `form_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  `status` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_user_jobs`
--

LOCK TABLES `form_user_jobs` WRITE;
/*!40000 ALTER TABLE `form_user_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_user_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `form_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` int DEFAULT NULL,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_questions` int NOT NULL DEFAULT '0',
  `time_limit` int NOT NULL DEFAULT '0',
  `pass_score` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms`
--

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
INSERT INTO `forms` VALUES (1,'Pre-Screen','PRESCREEN',1,'0220cea7a1301c1e8f3f2ada78412736',3,0,0),(2,'matt','TEST',1,NULL,1,10,0);
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gbg_image_response`
--

DROP TABLE IF EXISTS `gbg_image_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gbg_image_response` (
  `id` int NOT NULL AUTO_INCREMENT,
  `check_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `response` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `authenticated` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `extracted_data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `document_type` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `document_number` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gbg_image_response`
--

LOCK TABLES `gbg_image_response` WRITE;
/*!40000 ALTER TABLE `gbg_image_response` DISABLE KEYS */;
/*!40000 ALTER TABLE `gbg_image_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gbg_response`
--

DROP TABLE IF EXISTS `gbg_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gbg_response` (
  `id` int NOT NULL AUTO_INCREMENT,
  `check_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `repsonse` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `score` int DEFAULT NULL,
  `descision` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gbg_response`
--

LOCK TABLES `gbg_response` WRITE;
/*!40000 ALTER TABLE `gbg_response` DISABLE KEYS */;
/*!40000 ALTER TABLE `gbg_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gbg_responses`
--

DROP TABLE IF EXISTS `gbg_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gbg_responses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `response` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `check_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gbg_responses`
--

LOCK TABLES `gbg_responses` WRITE;
/*!40000 ALTER TABLE `gbg_responses` DISABLE KEYS */;
/*!40000 ALTER TABLE `gbg_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `histories_complete`
--

DROP TABLE IF EXISTS `histories_complete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `histories_complete` (
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `education` int DEFAULT NULL,
  `employment` int DEFAULT NULL,
  PRIMARY KEY (`job_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histories_complete`
--

LOCK TABLES `histories_complete` WRITE;
/*!40000 ALTER TABLE `histories_complete` DISABLE KEYS */;
INSERT INTO `histories_complete` VALUES ('0220cea7a1301c1e8f3f2ada78412736',2,1,1);
/*!40000 ALTER TABLE `histories_complete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `histories_defaults`
--

DROP TABLE IF EXISTS `histories_defaults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `histories_defaults` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employment` int NOT NULL,
  `education` int NOT NULL,
  `employer_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histories_defaults`
--

LOCK TABLES `histories_defaults` WRITE;
/*!40000 ALTER TABLE `histories_defaults` DISABLE KEYS */;
/*!40000 ALTER TABLE `histories_defaults` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `histories_jobs`
--

DROP TABLE IF EXISTS `histories_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `histories_jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int NOT NULL,
  `employment` int NOT NULL,
  `education` int NOT NULL,
  `job_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histories_jobs`
--

LOCK TABLES `histories_jobs` WRITE;
/*!40000 ALTER TABLE `histories_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `histories_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_education`
--

DROP TABLE IF EXISTS `history_education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history_education` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `seq` int NOT NULL,
  `establishment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `qualification` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_education`
--

LOCK TABLES `history_education` WRITE;
/*!40000 ALTER TABLE `history_education` DISABLE KEYS */;
INSERT INTO `history_education` VALUES (1,2,'0220cea7a1301c1e8f3f2ada78412736',1,'yeah','1990-06-01 00:00:00','2021-06-01 00:00:00','NONE','school','2021-06-29 20:32:22');
/*!40000 ALTER TABLE `history_education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_employment`
--

DROP TABLE IF EXISTS `history_employment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history_employment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `seq` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_on` datetime DEFAULT NULL,
  `employment_status` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_employment`
--

LOCK TABLES `history_employment` WRITE;
/*!40000 ALTER TABLE `history_employment` DISABLE KEYS */;
INSERT INTO `history_employment` VALUES (1,2,'0220cea7a1301c1e8f3f2ada78412736','Koine',1,'CTO','2011-06-01 00:00:00','2021-06-01 00:00:00','CTO','2021-06-29 20:31:53','unemployed');
/*!40000 ALTER TABLE `history_employment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `id_check_files`
--

DROP TABLE IF EXISTS `id_check_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `id_check_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `friendlyName` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `storedName` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mimeType` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `docType` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dateStored` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `id_check_files`
--

LOCK TABLES `id_check_files` WRITE;
/*!40000 ALTER TABLE `id_check_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `id_check_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `id_checks`
--

DROP TABLE IF EXISTS `id_checks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `id_checks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `pass` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit_lines` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sanctions` int DEFAULT NULL,
  `pep` int DEFAULT NULL,
  `submitted_on` datetime DEFAULT NULL,
  `short_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `unique_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `director_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'PENDING',
  `directorships` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `director_links` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `id_checks`
--

LOCK TABLES `id_checks` WRITE;
/*!40000 ALTER TABLE `id_checks` DISABLE KEYS */;
INSERT INTO `id_checks` VALUES (1,1,'2','2021-06-20 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'dsfsdf','32342tsdf',NULL,'PENDING',NULL,NULL);
/*!40000 ALTER TABLE `id_checks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `integer_field`
--

DROP TABLE IF EXISTS `integer_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `integer_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  `filterable` int DEFAULT NULL,
  `filter_on` int DEFAULT NULL,
  `filter_operator` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `integer_field`
--

LOCK TABLES `integer_field` WRITE;
/*!40000 ALTER TABLE `integer_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `integer_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interviews`
--

DROP TABLE IF EXISTS `interviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` int NOT NULL,
  `employer_user_id` int NOT NULL,
  `interview_date` datetime NOT NULL,
  `sms` int NOT NULL DEFAULT '0',
  `email` int NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `accepted` int DEFAULT NULL,
  `accepted_on` datetime DEFAULT NULL,
  `rejected` int DEFAULT NULL,
  `rejected_on` datetime DEFAULT NULL,
  `reject_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `details_url` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `unique_ref` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `ics` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interviews`
--

LOCK TABLES `interviews` WRITE;
/*!40000 ALTER TABLE `interviews` DISABLE KEYS */;
INSERT INTO `interviews` VALUES (1,2,'0220cea7a1301c1e8f3f2ada78412736',1,1,'2021-06-30 01:30:00',1,1,'2021-06-29 21:42:43',0,NULL,1,'2021-07-07 12:51:44','',NULL,NULL,'aa4e8c65369cfbe949c078f899791262','London',NULL);
/*!40000 ALTER TABLE `interviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_categories`
--

DROP TABLE IF EXISTS `job_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_categories` (
  `id` int NOT NULL,
  `category` varchar(155) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_categories`
--

LOCK TABLES `job_categories` WRITE;
/*!40000 ALTER TABLE `job_categories` DISABLE KEYS */;
INSERT INTO `job_categories` VALUES (0,'Accountancy, banking and finance'),(1,'Business, consulting and management'),(2,'Charity and voluntary work'),(3,'Cleaning and housekeeping'),(4,'Energy and utilities'),(5,'Engineering and manufacturing'),(6,'Environment and agriculture'),(7,'Healthcare'),(8,'Hospitality and events management'),(9,'Information research and analysis'),(10,'Information technology'),(11,'Insurance and pensions'),(12,'Law'),(13,'Law enforcement and security'),(14,'Leisure, sport and tourism'),(15,'Marketing, advertising and PR'),(16,'Media and internet'),(17,'Performing arts'),(18,'Property and construction'),(19,'Public services and administration'),(20,'Publishing and journalism'),(21,'Recruitment and HR'),(22,'Retail'),(23,'Sales'),(24,'Science and pharmaceuticals'),(25,'Social care'),(26,'Teaching and education'),(27,'Transport and logistics'),(1000,'Background Checks');
/*!40000 ALTER TABLE `job_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_status`
--

DROP TABLE IF EXISTS `job_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_status` (
  `id` int NOT NULL,
  `status` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_status`
--

LOCK TABLES `job_status` WRITE;
/*!40000 ALTER TABLE `job_status` DISABLE KEYS */;
INSERT INTO `job_status` VALUES (1,'Open'),(2,'Interview'),(3,'Offered'),(4,'Closed');
/*!40000 ALTER TABLE `job_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_by` int NOT NULL,
  `employer_id` int NOT NULL,
  `category` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `standfirst` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `county` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `salary` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `positions` int DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `active` int DEFAULT NULL,
  `uniqueid` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `archived` int DEFAULT NULL,
  `archived_date` datetime DEFAULT NULL,
  `short_url` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `checkabl` tinyint(1) DEFAULT '0',
  `testabl` tinyint(1) DEFAULT '0',
  `personabl` tinyint(1) DEFAULT '0',
  `pre_screen` tinyint(1) DEFAULT '0',
  `history` tinyint(1) DEFAULT '0',
  `disclosures` tinyint(1) DEFAULT '0',
  `identity` tinyint(1) DEFAULT '0',
  `jb_indeed` tinyint(1) DEFAULT '0',
  `employment_max` int NOT NULL DEFAULT '0',
  `education_max` int NOT NULL DEFAULT '0',
  `form_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,1,1,'0','0','Smurf','stuff','<p>stuff of stuff</p>','LEGOLAND® Windsor Resort, Winkfield Road, Windsor','2.50',100,'2021-08-01 00:00:00',1,'0220cea7a1301c1e8f3f2ada78412736',NULL,NULL,'https://bit.ly/2UPPHEW\n','2021-06-29 20:26:30',1,1,1,1,1,0,0,0,1,1,'rVskUouc29xqFUinn042vR-sAY3Swh2d0HV_lMan2g8');
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs_statuses`
--

DROP TABLE IF EXISTS `jobs_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs_statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs_statuses`
--

LOCK TABLES `jobs_statuses` WRITE;
/*!40000 ALTER TABLE `jobs_statuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `last_action`
--

DROP TABLE IF EXISTS `last_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `last_action` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `last_action`
--

LOCK TABLES `last_action` WRITE;
/*!40000 ALTER TABLE `last_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `last_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `last_action_exclusions`
--

DROP TABLE IF EXISTS `last_action_exclusions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `last_action_exclusions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `last_action_exclusions`
--

LOCK TABLES `last_action_exclusions` WRITE;
/*!40000 ALTER TABLE `last_action_exclusions` DISABLE KEYS */;
/*!40000 ALTER TABLE `last_action_exclusions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_user`
--

DROP TABLE IF EXISTS `master_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `employer_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_user`
--

LOCK TABLES `master_user` WRITE;
/*!40000 ALTER TABLE `master_user` DISABLE KEYS */;
INSERT INTO `master_user` VALUES (1,1,1);
/*!40000 ALTER TABLE `master_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mediatype` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  `seq` int NOT NULL,
  `format` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `extn` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'VIDEO',2,NULL,1,'VIDEO-ANSWER','iGbyDDHLZWWVm351w8LBLoGs6','mp4'),(2,'VIDEO',2,NULL,1,'VIDEO-ANSWER','YN9Cxl4cH4f69pUI8KDp0VUJL','mp4'),(3,'VIDEO',2,NULL,1,'VIDEO-ANSWER','Ry0eN8TRa04Ngn8Qqyz1T2UFS','mp4'),(4,'VIDEO',2,NULL,1,'VIDEO-ANSWER','mvESenW3mn2XEhTUwrr5ov7Hy','mp4');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `number_range_field`
--

DROP TABLE IF EXISTS `number_range_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `number_range_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `min` int NOT NULL,
  `max` int NOT NULL,
  `required` int NOT NULL,
  `filterable` int DEFAULT NULL,
  `filter_on` int DEFAULT NULL,
  `filter_operator` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `number_range_field`
--

LOCK TABLES `number_range_field` WRITE;
/*!40000 ALTER TABLE `number_range_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `number_range_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `number_value`
--

DROP TABLE IF EXISTS `number_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `number_value` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `field_id` int NOT NULL,
  `value` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `number_value`
--

LOCK TABLES `number_value` WRITE;
/*!40000 ALTER TABLE `number_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `number_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passport_data`
--

DROP TABLE IF EXISTS `passport_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passport_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `job_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiry_date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mrz` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `document_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `authenticity` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `testinfo` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `response` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `date_scanned` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passport_data`
--

LOCK TABLES `passport_data` WRITE;
/*!40000 ALTER TABLE `passport_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `passport_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `code` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `accepted` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pool_questions`
--

DROP TABLE IF EXISTS `pool_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pool_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pool_id` int NOT NULL,
  `seq` int NOT NULL,
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `question_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `secs` int NOT NULL DEFAULT '0',
  `data_values` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pool_questions`
--

LOCK TABLES `pool_questions` WRITE;
/*!40000 ALTER TABLE `pool_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `pool_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pools`
--

DROP TABLE IF EXISTS `pools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pools` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pool_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` int DEFAULT NULL,
  `num_questions` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pools`
--

LOCK TABLES `pools` WRITE;
/*!40000 ALTER TABLE `pools` DISABLE KEYS */;
/*!40000 ALTER TABLE `pools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `postcode_cache`
--

DROP TABLE IF EXISTS `postcode_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `postcode_cache` (
  `postcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_cached` datetime NOT NULL,
  `response` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `keep_cached` int NOT NULL,
  PRIMARY KEY (`postcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postcode_cache`
--

LOCK TABLES `postcode_cache` WRITE;
/*!40000 ALTER TABLE `postcode_cache` DISABLE KEYS */;
INSERT INTO `postcode_cache` VALUES ('EN26TY','2018-07-02 13:23:47','{\"latitude\":51.648383499999987,\"longitude\":-0.080819099999999991,\"addresses\":[\"1 Tiptree Drive, , , , , Enfield, Middlesex\",\"10 Tiptree Drive, , , , , Enfield, Middlesex\",\"11 Tiptree Drive, , , , , Enfield, Middlesex\",\"12 Tiptree Drive, , , , , Enfield, Middlesex\",\"13 Tiptree Drive, , , , , Enfield, Middlesex\",\"14 Tiptree Drive, , , , , Enfield, Middlesex\",\"17 Tiptree Drive, , , , , Enfield, Middlesex\",\"18 Tiptree Drive, , , , , Enfield, Middlesex\",\"19 Tiptree Drive, , , , , Enfield, Middlesex\",\"2 Tiptree Drive, , , , , Enfield, Middlesex\",\"20 Tiptree Drive, , , , , Enfield, Middlesex\",\"21 Tiptree Drive, , , , , Enfield, Middlesex\",\"3 Tiptree Drive, , , , , Enfield, Middlesex\",\"4 Tiptree Drive, , , , , Enfield, Middlesex\",\"5 Tiptree Drive, , , , , Enfield, Middlesex\",\"6 Tiptree Drive, , , , , Enfield, Middlesex\",\"7 Tiptree Drive, , , , , Enfield, Middlesex\",\"8 Tiptree Drive, , , , , Enfield, Middlesex\",\"9 Tiptree Drive, , , , , Enfield, Middlesex\"]}\r\n',1),('EN28JH','2018-07-02 16:50:20','{\"latitude\":51.6646253,\"longitude\":-0.1059172,\"addresses\":[\"102 The Ridgeway, , , , , Enfield, Middlesex\",\"104 The Ridgeway, , , , , Enfield, Middlesex\",\"106 The Ridgeway, , , , , Enfield, Middlesex\",\"108 The Ridgeway, , , , , Enfield, Middlesex\",\"110 The Ridgeway, , , , , Enfield, Middlesex\",\"112 The Ridgeway, , , , , Enfield, Middlesex\",\"114 The Ridgeway, , , , , Enfield, Middlesex\",\"116 The Ridgeway, , , , , Enfield, Middlesex\"]}',1),('EN28PB','2017-07-02 16:35:39','{\"latitude\":51.656052,\"longitude\":-0.098274699999999993,\"addresses\":[\"25 The Ridgeway, , , , , Enfield, Middlesex\",\"27a The Ridgeway, , , , , Enfield, Middlesex\",\"27b The Ridgeway, , , , , Enfield, Middlesex\",\"27c The Ridgeway, , , , , Enfield, Middlesex\",\"27d The Ridgeway, , , , , Enfield, Middlesex\",\"27e The Ridgeway, , , , , Enfield, Middlesex\",\"27f The Ridgeway, , , , , Enfield, Middlesex\",\"31 The Ridgeway, , , , , Enfield, Middlesex\",\"33 The Ridgeway, , , , , Enfield, Middlesex\",\"35 The Ridgeway, , , , , Enfield, Middlesex\",\"Flat 1, 29 The Ridgeway, , , , Enfield, Middlesex\",\"Flat 2, 29 The Ridgeway, , , , Enfield, Middlesex\",\"Flat 3, 29 The Ridgeway, , , , Enfield, Middlesex\",\"Flat 4, 29 The Ridgeway, , , , Enfield, Middlesex\"]}',1);
/*!40000 ALTER TABLE `postcode_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_screen`
--

DROP TABLE IF EXISTS `pre_screen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pre_screen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `java_development_experience` int NOT NULL,
  `low_latency_experience` int NOT NULL,
  `network_layer_experience` int NOT NULL,
  `lock_free_algorithms_experience` int NOT NULL,
  `linear_algebra_experience` int NOT NULL,
  `telemetry_systems_experience` int NOT NULL,
  `cexperience` int NOT NULL,
  `database_experience` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_screen`
--

LOCK TABLES `pre_screen` WRITE;
/*!40000 ALTER TABLE `pre_screen` DISABLE KEYS */;
/*!40000 ALTER TABLE `pre_screen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qualification_checks`
--

DROP TABLE IF EXISTS `qualification_checks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qualification_checks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  `institute_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employer_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int DEFAULT NULL,
  `submitted_on` datetime DEFAULT NULL,
  `short_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `membership` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `award` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `grade` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `enrolment` int DEFAULT NULL,
  `graduated` int DEFAULT NULL,
  `verification_id` int DEFAULT NULL,
  `verification_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `verification_response` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_758AA8F4A76ED395` (`user_id`),
  KEY `IDX_758AA8F4BE04EA9` (`job_id`),
  CONSTRAINT `FK_758AA8F4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_758AA8F4BE04EA9` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qualification_checks`
--

LOCK TABLES `qualification_checks` WRITE;
/*!40000 ALTER TABLE `qualification_checks` DISABLE KEYS */;
/*!40000 ALTER TABLE `qualification_checks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference`
--

DROP TABLE IF EXISTS `reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reference` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reference_request_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(155) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(155) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(155) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reference`
--

LOCK TABLES `reference` WRITE;
/*!40000 ALTER TABLE `reference` DISABLE KEYS */;
/*!40000 ALTER TABLE `reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference_request`
--

DROP TABLE IF EXISTS `reference_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reference_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `applicant_id` int NOT NULL,
  `applicant_message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `no_of_references` int NOT NULL,
  `return_emails` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `unique_ref` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reference_request`
--

LOCK TABLES `reference_request` WRITE;
/*!40000 ALTER TABLE `reference_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `reference_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejection_reason`
--

DROP TABLE IF EXISTS `rejection_reason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rejection_reason` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reason` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rejection_reason`
--

LOCK TABLES `rejection_reason` WRITE;
/*!40000 ALTER TABLE `rejection_reason` DISABLE KEYS */;
/*!40000 ALTER TABLE `rejection_reason` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'ROLE_ADMIN'),(2,'ROLE_CLIENT'),(3,'ROLE_APPLICANT'),(4,'ROLE_MASTER_CLIENT');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section_defaults`
--

DROP TABLE IF EXISTS `section_defaults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `section_defaults` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int NOT NULL,
  `checkabl` int NOT NULL DEFAULT '1',
  `testabl` int NOT NULL DEFAULT '1',
  `personabl` int NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section_defaults`
--

LOCK TABLES `section_defaults` WRITE;
/*!40000 ALTER TABLE `section_defaults` DISABLE KEYS */;
/*!40000 ALTER TABLE `section_defaults` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section_jobs`
--

DROP TABLE IF EXISTS `section_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `section_jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `checkabl` int NOT NULL DEFAULT '1',
  `testabl` int NOT NULL DEFAULT '1',
  `personabl` int NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section_jobs`
--

LOCK TABLES `section_jobs` WRITE;
/*!40000 ALTER TABLE `section_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `section_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `skill` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills_employer`
--

DROP TABLE IF EXISTS `skills_employer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills_employer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `skill_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills_employer`
--

LOCK TABLES `skills_employer` WRITE;
/*!40000 ALTER TABLE `skills_employer` DISABLE KEYS */;
/*!40000 ALTER TABLE `skills_employer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills_jobs_users`
--

DROP TABLE IF EXISTS `skills_jobs_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills_jobs_users` (
  `skill_id` int NOT NULL,
  `user_id` int NOT NULL,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`skill_id`,`user_id`,`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills_jobs_users`
--

LOCK TABLES `skills_jobs_users` WRITE;
/*!40000 ALTER TABLE `skills_jobs_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `skills_jobs_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_verification`
--

DROP TABLE IF EXISTS `sms_verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_verification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  `issue_date` datetime NOT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `status` varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `msgid` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_verification`
--

LOCK TABLES `sms_verification` WRITE;
/*!40000 ALTER TABLE `sms_verification` DISABLE KEYS */;
INSERT INTO `sms_verification` VALUES (1,'cd4cae',1,'2021-06-29 20:30:56','2021-06-29 20:31:15',NULL,NULL,'07966265939');
/*!40000 ALTER TABLE `sms_verification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `source`
--

DROP TABLE IF EXISTS `source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `source` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `source`
--

LOCK TABLES `source` WRITE;
/*!40000 ALTER TABLE `source` DISABLE KEYS */;
INSERT INTO `source` VALUES (1,'Reed'),(2,'Indeed'),(3,'CW Jobs'),(4,'Job Search'),(5,'Monster'),(6,'Job Site'),(7,'Fish4'),(8,'Total Jobs'),(9,'Adecco'),(10,'Permatemps'),(11,'The Times'),(12,'The Guardian'),(13,'The Financial Times'),(14,'The Independant'),(15,'Word of Mouth'),(16,'Manpower'),(17,'Randstad'),(18,'Allegis'),(19,'Hays'),(20,'All Jobs UK'),(21,'Michael Page'),(22,'City Jobs'),(23,'IPS Group');
/*!40000 ALTER TABLE `source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `source_by_employers`
--

DROP TABLE IF EXISTS `source_by_employers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `source_by_employers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `source_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `source_by_employers`
--

LOCK TABLES `source_by_employers` WRITE;
/*!40000 ALTER TABLE `source_by_employers` DISABLE KEYS */;
/*!40000 ALTER TABLE `source_by_employers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terms`
--

DROP TABLE IF EXISTS `terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `terms` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employer` int NOT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terms`
--

LOCK TABLES `terms` WRITE;
/*!40000 ALTER TABLE `terms` DISABLE KEYS */;
/*!40000 ALTER TABLE `terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terms_agreed`
--

DROP TABLE IF EXISTS `terms_agreed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terms_agreed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `job_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terms_agreed`
--

LOCK TABLES `terms_agreed` WRITE;
/*!40000 ALTER TABLE `terms_agreed` DISABLE KEYS */;
/*!40000 ALTER TABLE `terms_agreed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terms_files`
--

DROP TABLE IF EXISTS `terms_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terms_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `terms_id` int NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `friendlyname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terms_files`
--

LOCK TABLES `terms_files` WRITE;
/*!40000 ALTER TABLE `terms_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `terms_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terms_jobs`
--

DROP TABLE IF EXISTS `terms_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terms_jobs` (
  `terms_id` int NOT NULL,
  `job_id` int NOT NULL,
  PRIMARY KEY (`terms_id`,`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terms_jobs`
--

LOCK TABLES `terms_jobs` WRITE;
/*!40000 ALTER TABLE `terms_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `terms_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_allocation`
--

DROP TABLE IF EXISTS `test_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_allocation` (
  `link_id` int NOT NULL,
  `employer_id` int NOT NULL,
  PRIMARY KEY (`link_id`,`employer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_allocation`
--

LOCK TABLES `test_allocation` WRITE;
/*!40000 ALTER TABLE `test_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_allocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `text_area_field`
--

DROP TABLE IF EXISTS `text_area_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `text_area_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `text_area_field`
--

LOCK TABLES `text_area_field` WRITE;
/*!40000 ALTER TABLE `text_area_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `text_area_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `text_area_value`
--

DROP TABLE IF EXISTS `text_area_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `text_area_value` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `field_id` int NOT NULL,
  `value` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `text_area_value`
--

LOCK TABLES `text_area_value` WRITE;
/*!40000 ALTER TABLE `text_area_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `text_area_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `text_field`
--

DROP TABLE IF EXISTS `text_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `text_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `text_field`
--

LOCK TABLES `text_field` WRITE;
/*!40000 ALTER TABLE `text_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `text_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `text_value`
--

DROP TABLE IF EXISTS `text_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `text_value` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `field_id` int NOT NULL,
  `value` varchar(4000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `text_value`
--

LOCK TABLES `text_value` WRITE;
/*!40000 ALTER TABLE `text_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `text_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `url_field`
--

DROP TABLE IF EXISTS `url_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `url_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `url_field`
--

LOCK TABLES `url_field` WRITE;
/*!40000 ALTER TABLE `url_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `url_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(254) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hometel` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobiletel` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailaddress` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL,
  `employer_id` int DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiry` datetime DEFAULT NULL,
  `redirect` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_password` int DEFAULT NULL,
  `reset` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `retention` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$13$ku6rUmMC6vZoQsUNkshRx.1T13n98AcAKWPxpTVAmmlNP/nDuVdZK','Matt','David','+99 8111 2222','+99 07123 123456','admin@dev.dev',NULL,1,'oLMvI8PbEj5qB+eYyYFscfMCkSrR9nGwFJfD+blybca13MIvcCiFxRcXtfmcjTvcSS9PMdusxYrE9E7Il1aExw==','2021-09-23 02:36:22',NULL,0,'',0),(2,NULL,'$2y$13$ku6rUmMC6vZoQsUNkshRx.1T13n98AcAKWPxpTVAmmlNP/nDuVdZK','matt','dangerfield','02034343949','07966265939','matt.dangerfield@fintech-advisers.com',NULL,NULL,'/3oqKu0XJtB6stzRNA64xjy7mAW3VlR42K7bUnbo5tUCHLMjfZM714E0m2kqI6+6AayYZk5zkiMM4ZSFq6NinA==','2021-09-23 02:43:55',NULL,0,'',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_job`
--

DROP TABLE IF EXISTS `users_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_job` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `pre_screen_pass` int DEFAULT NULL,
  `archived` int DEFAULT '0',
  `accepted` int DEFAULT NULL,
  `web_hook_processed` int DEFAULT NULL,
  `offered` int DEFAULT NULL,
  `rejected` int DEFAULT NULL,
  `accepted_on` datetime DEFAULT NULL,
  `offered_on` datetime DEFAULT NULL,
  `rejected_on` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `checkabl_count` int DEFAULT NULL,
  `checkabl_completed` int DEFAULT NULL,
  `testabl_count` int DEFAULT NULL,
  `testabl_completed` int DEFAULT NULL,
  `personabl_count` int DEFAULT NULL,
  `personabl_completed` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_job`
--

LOCK TABLES `users_job` WRITE;
/*!40000 ALTER TABLE `users_job` DISABLE KEYS */;
INSERT INTO `users_job` VALUES (1,'0220cea7a1301c1e8f3f2ada78412736','2021-06-29 20:28:15','2021-06-29 20:28:15',1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,2,7,7,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users_job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_roles` (
  `users_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`users_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles`
--

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` VALUES (1,1),(1,2),(1,4),(2,3);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles_join`
--

DROP TABLE IF EXISTS `users_roles_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_roles_join` (
  `users_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`users_id`,`role_id`),
  KEY `IDX_259D2A3A67B3B43D` (`users_id`),
  KEY `IDX_259D2A3AD60322AC` (`role_id`),
  CONSTRAINT `FK_259D2A3A67B3B43D` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_259D2A3AD60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles_join`
--

LOCK TABLES `users_roles_join` WRITE;
/*!40000 ALTER TABLE `users_roles_join` DISABLE KEYS */;
INSERT INTO `users_roles_join` VALUES (1,1),(1,2),(1,4);
/*!40000 ALTER TABLE `users_roles_join` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usersjob_webhooklog`
--

DROP TABLE IF EXISTS `usersjob_webhooklog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usersjob_webhooklog` (
  `userjob_id` int NOT NULL,
  `weblog_id` int NOT NULL,
  PRIMARY KEY (`userjob_id`,`weblog_id`),
  UNIQUE KEY `UNIQ_7927D3C0AD4CB584` (`weblog_id`),
  KEY `IDX_7927D3C0631A596D` (`userjob_id`),
  CONSTRAINT `FK_7927D3C0631A596D` FOREIGN KEY (`userjob_id`) REFERENCES `users_job` (`id`),
  CONSTRAINT `FK_7927D3C0AD4CB584` FOREIGN KEY (`weblog_id`) REFERENCES `web_hook_log` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usersjob_webhooklog`
--

LOCK TABLES `usersjob_webhooklog` WRITE;
/*!40000 ALTER TABLE `usersjob_webhooklog` DISABLE KEYS */;
/*!40000 ALTER TABLE `usersjob_webhooklog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video` (
  `id` int NOT NULL AUTO_INCREMENT,
  `video_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `app_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `question_id` int NOT NULL,
  `recorded_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video`
--

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_answers`
--

DROP TABLE IF EXISTS `video_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `question_id` int NOT NULL,
  `user_id` int NOT NULL,
  `media_id` int NOT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_answers`
--

LOCK TABLES `video_answers` WRITE;
/*!40000 ALTER TABLE `video_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_questions`
--

DROP TABLE IF EXISTS `video_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `question` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `video` int DEFAULT '0',
  `video_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `media_id` int DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `active` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_questions`
--

LOCK TABLES `video_questions` WRITE;
/*!40000 ALTER TABLE `video_questions` DISABLE KEYS */;
INSERT INTO `video_questions` VALUES (1,'0220cea7a1301c1e8f3f2ada78412736','are you..?',0,NULL,0,'2021-06-29 21:27:05',1),(2,'0220cea7a1301c1e8f3f2ada78412736','who are you?',1,NULL,0,'2021-06-29 21:27:19',1);
/*!40000 ALTER TABLE `video_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `watch`
--

DROP TABLE IF EXISTS `watch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `watch` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` int DEFAULT NULL,
  `applicant_id` int DEFAULT NULL,
  `employer_id` int DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_500B4A26BE04EA9` (`job_id`),
  KEY `IDX_500B4A2697139001` (`applicant_id`),
  KEY `IDX_500B4A2641CD9E7A` (`employer_id`),
  CONSTRAINT `FK_500B4A2641CD9E7A` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`),
  CONSTRAINT `FK_500B4A2697139001` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_500B4A26BE04EA9` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `watch`
--

LOCK TABLES `watch` WRITE;
/*!40000 ALTER TABLE `watch` DISABLE KEYS */;
INSERT INTO `watch` VALUES (1,1,2,1,'2021-06-29 21:08:24');
/*!40000 ALTER TABLE `watch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `web_hook_log`
--

DROP TABLE IF EXISTS `web_hook_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `web_hook_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employer_id` int NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `job_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `response` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_hook_log`
--

LOCK TABLES `web_hook_log` WRITE;
/*!40000 ALTER TABLE `web_hook_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `web_hook_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `web_hook_tests`
--

DROP TABLE IF EXISTS `web_hook_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `web_hook_tests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_hook_tests`
--

LOCK TABLES `web_hook_tests` WRITE;
/*!40000 ALTER TABLE `web_hook_tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `web_hook_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yes_no_field`
--

DROP TABLE IF EXISTS `yes_no_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `yes_no_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `required` int NOT NULL,
  `filter_on` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yes_no_field`
--

LOCK TABLES `yes_no_field` WRITE;
/*!40000 ALTER TABLE `yes_no_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `yes_no_field` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-23  0:35:45
