-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 20, 2018 at 07:35 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hireabl_v3_minimal`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_terms`
--

DROP TABLE IF EXISTS `accepted_terms`;
CREATE TABLE `accepted_terms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `terms_id` int(11) NOT NULL,
  `accepted_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `line1` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line2` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line3` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `county` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `userid`, `line1`, `line2`, `line3`, `town`, `county`, `postcode`) VALUES
(1, 1, '1 Any Road', NULL, NULL, 'Anytown', 'London', 'EC1 1AB');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `disabled` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `created_on`, `disabled`) VALUES
(1, 1, '2018-12-20 19:31:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `aml_data`
--

DROP TABLE IF EXISTS `aml_data`;
CREATE TABLE `aml_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_code` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `authenticity` varchar(50) NOT NULL,
  `data_sent` text,
  `testinfo` text NOT NULL,
  `response` text NOT NULL,
  `date_scanned` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apikeys`
--

DROP TABLE IF EXISTS `apikeys`;
CREATE TABLE `apikeys` (
  `id` int(11) NOT NULL,
  `apikey` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_accessed` datetime DEFAULT NULL,
  `access_count` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicantdata_applicantaddress`
--

DROP TABLE IF EXISTS `applicantdata_applicantaddress`;
CREATE TABLE `applicantdata_applicantaddress` (
  `data_id` int(11) NOT NULL,
  `addr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicantdata_applicantname`
--

DROP TABLE IF EXISTS `applicantdata_applicantname`;
CREATE TABLE `applicantdata_applicantname` (
  `data_id` int(11) NOT NULL,
  `name_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_disclosures`
--

DROP TABLE IF EXISTS `applicant_disclosures`;
CREATE TABLE `applicant_disclosures` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_status` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hireabl_status` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gbg_status_code` int(11) DEFAULT '0',
  `gbg_status` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gbg_outcome` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gbg_disclosure_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `short_url` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_disclosure_data`
--

DROP TABLE IF EXISTS `applicant_disclosure_data`;
CREATE TABLE `applicant_disclosure_data` (
  `id` int(11) NOT NULL,
  `birth_county` int(11) DEFAULT NULL,
  `address_county` int(11) DEFAULT NULL,
  `applicant_id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_data` text COLLATE utf8_unicode_ci,
  `title` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `middlename1` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename2` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename3` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_surname` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_surname_until` int(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_town` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_country` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mothers_maiden_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_2` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_towncity` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address_country` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `address_postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `address_start_date` date DEFAULT NULL,
  `has_convictions` int(11) DEFAULT NULL,
  `ni_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dl_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dl_country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idcard_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idcard_country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_declaration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_disclosure_update_response`
--

DROP TABLE IF EXISTS `applicant_disclosure_update_response`;
CREATE TABLE `applicant_disclosure_update_response` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_disclosure_verification`
--

DROP TABLE IF EXISTS `applicant_disclosure_verification`;
CREATE TABLE `applicant_disclosure_verification` (
  `id` int(11) NOT NULL,
  `application_id` int(11) DEFAULT NULL,
  `driving_Licence_number` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driving_Licence_dob` datetime DEFAULT NULL,
  `driving_Licence_country` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driving_Licence_issue` datetime DEFAULT NULL,
  `driving_Licence_start` datetime DEFAULT NULL,
  `passport_number` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_dob` datetime DEFAULT NULL,
  `passport_issue` datetime DEFAULT NULL,
  `passport_nationality` varchar(33) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_certificate_issue` datetime DEFAULT NULL,
  `birth_dob` datetime DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `agree_address` int(11) DEFAULT NULL,
  `agree_dob` int(11) DEFAULT NULL,
  `agree_names` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_prev_address`
--

DROP TABLE IF EXISTS `applicant_prev_address`;
CREATE TABLE `applicant_prev_address` (
  `id` int(11) NOT NULL,
  `county` int(11) DEFAULT NULL,
  `line1` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `line2` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town_city` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `start_on` date DEFAULT NULL,
  `end_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_prev_name`
--

DROP TABLE IF EXISTS `applicant_prev_name`;
CREATE TABLE `applicant_prev_name` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_rating`
--

DROP TABLE IF EXISTS `applicant_rating`;
CREATE TABLE `applicant_rating` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_on` date NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_share`
--

DROP TABLE IF EXISTS `applicant_share`;
CREATE TABLE `applicant_share` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `created_on` date NOT NULL,
  `unique_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_verification`
--

DROP TABLE IF EXISTS `bank_verification`;
CREATE TABLE `bank_verification` (
  `id` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `confirm_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkabl_filters`
--

DROP TABLE IF EXISTS `checkabl_filters`;
CREATE TABLE `checkabl_filters` (
  `id` int(11) NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `pre_screen` int(11) NOT NULL,
  `history` int(11) NOT NULL,
  `disclosures` int(11) NOT NULL DEFAULT '0',
  `visualid` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checked_details`
--

DROP TABLE IF EXISTS `checked_details`;
CREATE TABLE `checked_details` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `jobId` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `uniqueId` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `forename` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `line1` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `line2` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `line3` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `dlNo` varchar(44) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passportNo` varchar(2555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateExp` date DEFAULT NULL,
  `ppOrigin` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checks`
--

DROP TABLE IF EXISTS `checks`;
CREATE TABLE `checks` (
  `id` int(11) NOT NULL,
  `checkname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `standard` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classmarker_links`
--

DROP TABLE IF EXISTS `classmarker_links`;
CREATE TABLE `classmarker_links` (
  `link_id` int(11) NOT NULL,
  `link_name` varchar(100) NOT NULL,
  `link_url` varchar(45) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `classmarker_link_results`
--

DROP TABLE IF EXISTS `classmarker_link_results`;
CREATE TABLE `classmarker_link_results` (
  `pk_id` int(11) NOT NULL,
  `link_result_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `first` varchar(50) DEFAULT NULL,
  `last` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `percentage` decimal(5,1) DEFAULT NULL,
  `points_scored` decimal(5,1) NOT NULL,
  `points_available` decimal(5,1) NOT NULL,
  `time_started` int(11) DEFAULT NULL,
  `time_finished` int(11) DEFAULT NULL,
  `duration` varchar(8) NOT NULL,
  `status` varchar(2) DEFAULT NULL,
  `requires_grading` varchar(3) DEFAULT NULL,
  `cm_user_id` varchar(100) DEFAULT NULL,
  `access_code` varchar(255) DEFAULT NULL,
  `extra_info` varchar(255) DEFAULT NULL,
  `extra_info2` varchar(255) DEFAULT NULL,
  `extra_info3` varchar(255) DEFAULT NULL,
  `extra_info4` varchar(255) DEFAULT NULL,
  `extra_info5` varchar(255) DEFAULT NULL,
  `ip_address` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `classmarker_tests`
--

DROP TABLE IF EXISTS `classmarker_tests`;
CREATE TABLE `classmarker_tests` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `consent_import`
--

DROP TABLE IF EXISTS `consent_import`;
CREATE TABLE `consent_import` (
  `id` int(11) NOT NULL,
  `consent_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qualification_id` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactrequest`
--

DROP TABLE IF EXISTS `contactrequest`;
CREATE TABLE `contactrequest` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

DROP TABLE IF EXISTS `counties`;
CREATE TABLE `counties` (
  `id` int(11) NOT NULL,
  `county` varchar(155) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`id`, `county`) VALUES
(1, 'Bath and North East Somerset'),
(2, 'Bedford'),
(3, 'Blackburn with Darwen'),
(4, 'Blackpool'),
(5, 'Bournemouth'),
(6, 'Bracknell Forest'),
(7, 'Brighton & Hove'),
(8, 'Bristol'),
(9, 'Buckinghamshire'),
(10, 'Cambridgeshire'),
(11, 'Central Bedfordshire'),
(12, 'Cheshire East'),
(13, 'Cheshire West and Chester'),
(14, 'Cornwall'),
(15, 'County Durham'),
(16, 'Cumbria'),
(17, 'Darlington'),
(18, 'Derby'),
(19, 'Derbyshire'),
(20, 'Devon'),
(21, 'Dorset'),
(22, 'East Riding of Yorkshire'),
(23, 'East Sussex'),
(24, 'Essex'),
(25, 'Gloucestershire'),
(26, 'Greater London'),
(27, 'Greater Manchester'),
(28, 'Halton'),
(29, 'Hampshire'),
(30, 'Hartlepool'),
(31, 'Herefordshire'),
(32, 'Hertfordshire'),
(33, 'Hull'),
(34, 'Isle of Wight'),
(35, 'Isles of Scilly'),
(36, 'Kent'),
(37, 'Lancashire'),
(38, 'Leicester'),
(39, 'Leicestershire'),
(40, 'Lincolnshire'),
(41, 'Luton'),
(42, 'Medway'),
(43, 'Merseyside'),
(44, 'Middlesbrough'),
(45, 'Middlesex'),
(46, 'Milton Keynes'),
(47, 'Norfolk'),
(48, 'North East Lincolnshire'),
(49, 'North Lincolnshire'),
(50, 'North Somerset'),
(51, 'North Yorkshire'),
(52, 'Northamptonshire'),
(53, 'Northumberland'),
(54, 'Nottingham'),
(55, 'Nottinghamshire'),
(56, 'Oxfordshire'),
(57, 'Peterborough'),
(58, 'Plymouth'),
(59, 'Poole'),
(60, 'Portsmouth'),
(61, 'Reading'),
(62, 'Redcar and Cleveland'),
(63, 'Rutland'),
(64, 'Shropshire'),
(65, 'Slough'),
(66, 'Somerset'),
(67, 'South Gloucestershire'),
(68, 'South Yorkshire'),
(69, 'Southampton'),
(70, 'Southend-on-Sea'),
(71, 'Staffordshire'),
(72, 'Stockton-on-Tees'),
(73, 'Stoke-on-Trent'),
(74, 'Suffolk'),
(75, 'Surrey'),
(76, 'Swindon'),
(77, 'Telford and Wrekin'),
(78, 'Thurrock'),
(79, 'Torbay'),
(80, 'Tyne and Wear'),
(81, 'Warrington'),
(82, 'Warwickshire'),
(83, 'West Berkshire'),
(84, 'West Midlands'),
(85, 'West Sussex'),
(86, 'West Yorkshire'),
(87, 'Wiltshire'),
(88, 'Windsor and Maidenhead'),
(89, 'Wokingham'),
(90, 'Worcestershire'),
(91, 'York');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `iso2` varchar(200) NOT NULL,
  `iso3` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`name`, `iso2`, `iso3`) VALUES
('Andorra', 'AD', 'AND'),
('United Arab Emirates', 'AE', 'ARE'),
('Afghanistan', 'AF', 'AFG'),
('Antigua and Barbuda', 'AG', 'ATG'),
('Anguilla', 'AI', 'AIA'),
('Albania', 'AL', 'ALB'),
('Armenia', 'AM', 'ARM'),
('Angola', 'AO', 'AGO'),
('Antarctica', 'AQ', 'ATA'),
('Argentina', 'AR', 'ARG'),
('American Samoa', 'AS', 'ASM'),
('Austria', 'AT', 'AUT'),
('Australia', 'AU', 'AUS'),
('Aruba', 'AW', 'ABW'),
('Åland Islands', 'AX', 'ALA'),
('Azerbaijan', 'AZ', 'AZE'),
('Bosnia and Herzegovina', 'BA', 'BIH'),
('Barbados', 'BB', 'BRB'),
('Bangladesh', 'BD', 'BGD'),
('Belgium', 'BE', 'BEL'),
('Burkina Faso', 'BF', 'BFA'),
('Bulgaria', 'BG', 'BGR'),
('Bahrain', 'BH', 'BHR'),
('Burundi', 'BI', 'BDI'),
('Benin', 'BJ', 'BEN'),
('Saint Barthélemy', 'BL', 'BLM'),
('Bermuda', 'BM', 'BMU'),
('Brunei Darussalam', 'BN', 'BRN'),
('Bolivia (Plurinational State of)', 'BO', 'BOL'),
('Bonaire, Sint Eustatius and Saba', 'BQ', 'BES'),
('Brazil', 'BR', 'BRA'),
('Bahamas', 'BS', 'BHS'),
('Bhutan', 'BT', 'BTN'),
('Bouvet Island', 'BV', 'BVT'),
('Botswana', 'BW', 'BWA'),
('Belarus', 'BY', 'BLR'),
('Belize', 'BZ', 'BLZ'),
('Canada', 'CA', 'CAN'),
('Cocos (Keeling) Islands', 'CC', 'CCK'),
('Congo (Democratic Republic of the)', 'CD', 'COD'),
('Central African Republic', 'CF', 'CAF'),
('Congo', 'CG', 'COG'),
('Switzerland', 'CH', 'CHE'),
('Côte d\'Ivoire', 'CI', 'CIV'),
('Cook Islands', 'CK', 'COK'),
('Chile', 'CL', 'CHL'),
('Cameroon', 'CM', 'CMR'),
('China', 'CN', 'CHN'),
('Colombia', 'CO', 'COL'),
('Costa Rica', 'CR', 'CRI'),
('Cuba', 'CU', 'CUB'),
('Cabo Verde', 'CV', 'CPV'),
('Curaçao', 'CW', 'CUW'),
('Christmas Island', 'CX', 'CXR'),
('Cyprus', 'CY', 'CYP'),
('Czechia', 'CZ', 'CZE'),
('Germany', 'DE', 'DEU'),
('Djibouti', 'DJ', 'DJI'),
('Denmark', 'DK', 'DNK'),
('Dominica', 'DM', 'DMA'),
('Dominican Republic', 'DO', 'DOM'),
('Algeria', 'DZ', 'DZA'),
('Ecuador', 'EC', 'ECU'),
('Estonia', 'EE', 'EST'),
('Egypt', 'EG', 'EGY'),
('Western Sahara', 'EH', 'ESH'),
('Eritrea', 'ER', 'ERI'),
('Spain', 'ES', 'ESP'),
('Ethiopia', 'ET', 'ETH'),
('Finland', 'FI', 'FIN'),
('Fiji', 'FJ', 'FJI'),
('Falkland Islands (Malvinas)', 'FK', 'FLK'),
('Micronesia (Federated States of)', 'FM', 'FSM'),
('Faroe Islands', 'FO', 'FRO'),
('France', 'FR', 'FRA'),
('Gabon', 'GA', 'GAB'),
('United Kingdom of Great Britain and Northern Ireland', 'GB', 'GBR'),
('Grenada', 'GD', 'GRD'),
('Georgia', 'GE', 'GEO'),
('French Guiana', 'GF', 'GUF'),
('Guernsey', 'GG', 'GGY'),
('Ghana', 'GH', 'GHA'),
('Gibraltar', 'GI', 'GIB'),
('Greenland', 'GL', 'GRL'),
('Gambia', 'GM', 'GMB'),
('Guinea', 'GN', 'GIN'),
('Guadeloupe', 'GP', 'GLP'),
('Equatorial Guinea', 'GQ', 'GNQ'),
('Greece', 'GR', 'GRC'),
('South Georgia and the South Sandwich Islands', 'GS', 'SGS'),
('Guatemala', 'GT', 'GTM'),
('Guam', 'GU', 'GUM'),
('Guinea-Bissau', 'GW', 'GNB'),
('Guyana', 'GY', 'GUY'),
('Hong Kong', 'HK', 'HKG'),
('Heard Island and McDonald Islands', 'HM', 'HMD'),
('Honduras', 'HN', 'HND'),
('Croatia', 'HR', 'HRV'),
('Haiti', 'HT', 'HTI'),
('Hungary', 'HU', 'HUN'),
('Indonesia', 'ID', 'IDN'),
('Ireland', 'IE', 'IRL'),
('Israel', 'IL', 'ISR'),
('Isle of Man', 'IM', 'IMN'),
('India', 'IN', 'IND'),
('British Indian Ocean Territory', 'IO', 'IOT'),
('Iraq', 'IQ', 'IRQ'),
('Iran (Islamic Republic of)', 'IR', 'IRN'),
('Iceland', 'IS', 'ISL'),
('Italy', 'IT', 'ITA'),
('Jersey', 'JE', 'JEY'),
('Jamaica', 'JM', 'JAM'),
('Jordan', 'JO', 'JOR'),
('Japan', 'JP', 'JPN'),
('Kenya', 'KE', 'KEN'),
('Kyrgyzstan', 'KG', 'KGZ'),
('Cambodia', 'KH', 'KHM'),
('Kiribati', 'KI', 'KIR'),
('Comoros', 'KM', 'COM'),
('Saint Kitts and Nevis', 'KN', 'KNA'),
('Korea (Democratic People\'s Republic of)', 'KP', 'PRK'),
('Korea (Republic of)', 'KR', 'KOR'),
('Kuwait', 'KW', 'KWT'),
('Cayman Islands', 'KY', 'CYM'),
('Kazakhstan', 'KZ', 'KAZ'),
('Lao People\'s Democratic Republic', 'LA', 'LAO'),
('Lebanon', 'LB', 'LBN'),
('Saint Lucia', 'LC', 'LCA'),
('Liechtenstein', 'LI', 'LIE'),
('Sri Lanka', 'LK', 'LKA'),
('Liberia', 'LR', 'LBR'),
('Lesotho', 'LS', 'LSO'),
('Lithuania', 'LT', 'LTU'),
('Luxembourg', 'LU', 'LUX'),
('Latvia', 'LV', 'LVA'),
('Libya', 'LY', 'LBY'),
('Morocco', 'MA', 'MAR'),
('Monaco', 'MC', 'MCO'),
('Moldova (Republic of)', 'MD', 'MDA'),
('Montenegro', 'ME', 'MNE'),
('Saint Martin (French part)', 'MF', 'MAF'),
('Madagascar', 'MG', 'MDG'),
('Marshall Islands', 'MH', 'MHL'),
('Macedonia (the former Yugoslav Republic of)', 'MK', 'MKD'),
('Mali', 'ML', 'MLI'),
('Myanmar', 'MM', 'MMR'),
('Mongolia', 'MN', 'MNG'),
('Macao', 'MO', 'MAC'),
('Northern Mariana Islands', 'MP', 'MNP'),
('Martinique', 'MQ', 'MTQ'),
('Mauritania', 'MR', 'MRT'),
('Montserrat', 'MS', 'MSR'),
('Malta', 'MT', 'MLT'),
('Mauritius', 'MU', 'MUS'),
('Maldives', 'MV', 'MDV'),
('Malawi', 'MW', 'MWI'),
('Mexico', 'MX', 'MEX'),
('Malaysia', 'MY', 'MYS'),
('Mozambique', 'MZ', 'MOZ'),
('Namibia', 'NA', 'NAM'),
('New Caledonia', 'NC', 'NCL'),
('Niger', 'NE', 'NER'),
('Norfolk Island', 'NF', 'NFK'),
('Nigeria', 'NG', 'NGA'),
('Nicaragua', 'NI', 'NIC'),
('Netherlands', 'NL', 'NLD'),
('Norway', 'NO', 'NOR'),
('Nepal', 'NP', 'NPL'),
('Nauru', 'NR', 'NRU'),
('Niue', 'NU', 'NIU'),
('New Zealand', 'NZ', 'NZL'),
('Oman', 'OM', 'OMN'),
('Panama', 'PA', 'PAN'),
('Peru', 'PE', 'PER'),
('French Polynesia', 'PF', 'PYF'),
('Papua New Guinea', 'PG', 'PNG'),
('Philippines', 'PH', 'PHL'),
('Pakistan', 'PK', 'PAK'),
('Poland', 'PL', 'POL'),
('Saint Pierre and Miquelon', 'PM', 'SPM'),
('Pitcairn', 'PN', 'PCN'),
('Puerto Rico', 'PR', 'PRI'),
('Palestine, State of', 'PS', 'PSE'),
('Portugal', 'PT', 'PRT'),
('Palau', 'PW', 'PLW'),
('Paraguay', 'PY', 'PRY'),
('Qatar', 'QA', 'QAT'),
('Réunion', 'RE', 'REU'),
('Romania', 'RO', 'ROU'),
('Serbia', 'RS', 'SRB'),
('Russian Federation', 'RU', 'RUS'),
('Rwanda', 'RW', 'RWA'),
('Saudi Arabia', 'SA', 'SAU'),
('Solomon Islands', 'SB', 'SLB'),
('Seychelles', 'SC', 'SYC'),
('Sudan', 'SD', 'SDN'),
('Sweden', 'SE', 'SWE'),
('Singapore', 'SG', 'SGP'),
('Saint Helena, Ascension and Tristan da Cunha', 'SH', 'SHN'),
('Slovenia', 'SI', 'SVN'),
('Svalbard and Jan Mayen', 'SJ', 'SJM'),
('Slovakia', 'SK', 'SVK'),
('Sierra Leone', 'SL', 'SLE'),
('San Marino', 'SM', 'SMR'),
('Senegal', 'SN', 'SEN'),
('Somalia', 'SO', 'SOM'),
('Suriname', 'SR', 'SUR'),
('South Sudan', 'SS', 'SSD'),
('Sao Tome and Principe', 'ST', 'STP'),
('El Salvador', 'SV', 'SLV'),
('Sint Maarten (Dutch part)', 'SX', 'SXM'),
('Syrian Arab Republic', 'SY', 'SYR'),
('Swaziland', 'SZ', 'SWZ'),
('Turks and Caicos Islands', 'TC', 'TCA'),
('Chad', 'TD', 'TCD'),
('French Southern Territories', 'TF', 'ATF'),
('Togo', 'TG', 'TGO'),
('Thailand', 'TH', 'THA'),
('Tajikistan', 'TJ', 'TJK'),
('Tokelau', 'TK', 'TKL'),
('Timor-Leste', 'TL', 'TLS'),
('Turkmenistan', 'TM', 'TKM'),
('Tunisia', 'TN', 'TUN'),
('Tonga', 'TO', 'TON'),
('Turkey', 'TR', 'TUR'),
('Trinidad and Tobago', 'TT', 'TTO'),
('Tuvalu', 'TV', 'TUV'),
('Taiwan, Province of China', 'TW', 'TWN'),
('Tanzania, United Republic of', 'TZ', 'TZA'),
('Ukraine', 'UA', 'UKR'),
('Uganda', 'UG', 'UGA'),
('United States Minor Outlying Islands', 'UM', 'UMI'),
('United States of America', 'US', 'USA'),
('Uruguay', 'UY', 'URY'),
('Uzbekistan', 'UZ', 'UZB'),
('Holy See', 'VA', 'VAT'),
('Saint Vincent and the Grenadines', 'VC', 'VCT'),
('Venezuela (Bolivarian Republic of)', 'VE', 'VEN'),
('Virgin Islands (British)', 'VG', 'VGB'),
('Virgin Islands (U.S.)', 'VI', 'VIR'),
('Viet Nam', 'VN', 'VNM'),
('Vanuatu', 'VU', 'VUT'),
('Wallis and Futuna', 'WF', 'WLF'),
('Samoa', 'WS', 'WSM'),
('Yemen', 'YE', 'YEM'),
('Mayotte', 'YT', 'MYT'),
('South Africa', 'ZA', 'ZAF'),
('Zambia', 'ZM', 'ZMB'),
('Zimbabwe', 'ZW', 'ZWE');

-- --------------------------------------------------------

--
-- Table structure for table `country_field`
--

DROP TABLE IF EXISTS `country_field`;
CREATE TABLE `country_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `default_country` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit`
--

DROP TABLE IF EXISTS `credit`;
CREATE TABLE `credit` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `css_schemes`
--

DROP TABLE IF EXISTS `css_schemes`;
CREATE TABLE `css_schemes` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `domain` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_background` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `header_logo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `footer_background` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `footer_logo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `footer_co_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `header_logo_admin` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `header_background_admin` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `footer_background_admin` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `footer_logo_admin` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `css_schemes`
--

INSERT INTO `css_schemes` (`id`, `employer_id`, `domain`, `company_name`, `header_background`, `header_logo`, `footer_background`, `footer_logo`, `footer_co_name`, `header_logo_admin`, `header_background_admin`, `footer_background_admin`, `footer_logo_admin`, `contact_number`, `email_from`) VALUES
(1, 1, 'hireabl.co.uk', 'HIreabl', '#d91919', '', '', '#d91919', 'Hireabl Ltd', '', '#d91919', '#d91919', '', '0800 123 1234', 'info@hireabl.com');

-- --------------------------------------------------------

--
-- Table structure for table `cv`
--

DROP TABLE IF EXISTS `cv`;
CREATE TABLE `cv` (
  `id` int(11) NOT NULL,
  `original_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stored_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cv_check`
--

DROP TABLE IF EXISTS `cv_check`;
CREATE TABLE `cv_check` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_config`
--

DROP TABLE IF EXISTS `dashboard_config`;
CREATE TABLE `dashboard_config` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `overview_config` text,
  `detail_config` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `date_field`
--

DROP TABLE IF EXISTS `date_field`;
CREATE TABLE `date_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `date_value`
--

DROP TABLE IF EXISTS `date_value`;
CREATE TABLE `date_value` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devphone`
--

DROP TABLE IF EXISTS `devphone`;
CREATE TABLE `devphone` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `rand` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `director_checks`
--

DROP TABLE IF EXISTS `director_checks`;
CREATE TABLE `director_checks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_code` varchar(100) NOT NULL,
  `companies` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `driving_data`
--

DROP TABLE IF EXISTS `driving_data`;
CREATE TABLE `driving_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_code` varchar(50) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `nationality` varchar(3) DEFAULT NULL,
  `building` varchar(50) DEFAULT NULL,
  `street` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `document_number` varchar(200) DEFAULT NULL,
  `country` varchar(3) DEFAULT NULL,
  `authenticity` varchar(50) DEFAULT NULL,
  `testinfo` text NOT NULL,
  `response` text NOT NULL,
  `date_scanned` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_field`
--

DROP TABLE IF EXISTS `email_field`;
CREATE TABLE `email_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

DROP TABLE IF EXISTS `email_verification`;
CREATE TABLE `email_verification` (
  `id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  `issue_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirm_date` datetime DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

DROP TABLE IF EXISTS `employers`;
CREATE TABLE `employers` (
  `id` int(11) NOT NULL,
  `company` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cameratag_app_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gbg_organisation_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_hook_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employers`
--

INSERT INTO `employers` (`id`, `company`, `cameratag_app_id`, `gbg_organisation_id`, `web_hook_url`) VALUES
(1, 'Hireabl', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employers_tests`
--

DROP TABLE IF EXISTS `employers_tests`;
CREATE TABLE `employers_tests` (
  `id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employer_job_titles`
--

DROP TABLE IF EXISTS `employer_job_titles`;
CREATE TABLE `employer_job_titles` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `job_title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `searchType` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employer_job_tracker`
--

DROP TABLE IF EXISTS `employer_job_tracker`;
CREATE TABLE `employer_job_tracker` (
  `id` int(11) NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_accessed` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `excel_tests`
--

DROP TABLE IF EXISTS `excel_tests`;
CREATE TABLE `excel_tests` (
  `test_id` int(11) NOT NULL,
  `file` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `excel_tests_jobs`
--

DROP TABLE IF EXISTS `excel_tests_jobs`;
CREATE TABLE `excel_tests_jobs` (
  `test_id` int(11) NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` int(11) NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `excel_test_allocation`
--

DROP TABLE IF EXISTS `excel_test_allocation`;
CREATE TABLE `excel_test_allocation` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `excel_test_results`
--

DROP TABLE IF EXISTS `excel_test_results`;
CREATE TABLE `excel_test_results` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time_elapsed` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correct_words` int(11) DEFAULT NULL,
  `incorrect_words` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extrachecks`
--

DROP TABLE IF EXISTS `extrachecks`;
CREATE TABLE `extrachecks` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `job_code` varchar(64) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `check_type` varchar(20) NOT NULL,
  `date_requested` datetime NOT NULL,
  `date_completed` datetime DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `result` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facecompare_checks`
--

DROP TABLE IF EXISTS `facecompare_checks`;
CREATE TABLE `facecompare_checks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_code` varchar(100) NOT NULL,
  `source` varchar(20) NOT NULL,
  `response` text CHARACTER SET utf8 NOT NULL,
  `result` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
CREATE TABLE `form` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `form_name` varchar(100) NOT NULL,
  `form_type` varchar(20) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `job_id` varchar(32) DEFAULT NULL,
  `num_questions` int(11) NOT NULL DEFAULT '0',
  `time_limit` int(11) NOT NULL DEFAULT '0',
  `pass_score` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_answers`
--

DROP TABLE IF EXISTS `form_answers`;
CREATE TABLE `form_answers` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `question_type` varchar(20) NOT NULL,
  `pool_id` int(11) DEFAULT '0',
  `pool_question_id` int(11) DEFAULT '0',
  `secs` int(11) DEFAULT '0',
  `data_values` text,
  `answer` text,
  `answer_idx` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `max_score` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `form_completed`
--

DROP TABLE IF EXISTS `form_completed`;
CREATE TABLE `form_completed` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dt_started` datetime DEFAULT NULL,
  `dt_completed` datetime DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `max_score` int(11) DEFAULT NULL,
  `pass_score` int(11) DEFAULT NULL,
  `percentage` int(11) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_jobs`
--

DROP TABLE IF EXISTS `form_jobs`;
CREATE TABLE `form_jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_questions`
--

DROP TABLE IF EXISTS `form_questions`;
CREATE TABLE `form_questions` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `question_type` varchar(20) NOT NULL,
  `pool_id` int(11) DEFAULT '0',
  `pool_questions` int(11) DEFAULT '0',
  `required` tinyint(4) DEFAULT '0',
  `secs` int(11) NOT NULL DEFAULT '60',
  `data_values` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `form_type`
--

DROP TABLE IF EXISTS `form_type`;
CREATE TABLE `form_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_user_jobs`
--

DROP TABLE IF EXISTS `form_user_jobs`;
CREATE TABLE `form_user_jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gbg_image_response`
--

DROP TABLE IF EXISTS `gbg_image_response`;
CREATE TABLE `gbg_image_response` (
  `id` int(11) NOT NULL,
  `check_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `response` text COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `authenticated` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extracted_data` text COLLATE utf8_unicode_ci,
  `document_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `document_number` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gbg_response`
--

DROP TABLE IF EXISTS `gbg_response`;
CREATE TABLE `gbg_response` (
  `id` int(11) NOT NULL,
  `check_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `repsonse` text COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) DEFAULT NULL,
  `descision` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gbg_responses`
--

DROP TABLE IF EXISTS `gbg_responses`;
CREATE TABLE `gbg_responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `response` text COLLATE utf8_unicode_ci,
  `check_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histories_complete`
--

DROP TABLE IF EXISTS `histories_complete`;
CREATE TABLE `histories_complete` (
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `education` int(11) DEFAULT NULL,
  `employment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histories_defaults`
--

DROP TABLE IF EXISTS `histories_defaults`;
CREATE TABLE `histories_defaults` (
  `id` int(11) NOT NULL,
  `employment` int(11) NOT NULL,
  `education` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histories_jobs`
--

DROP TABLE IF EXISTS `histories_jobs`;
CREATE TABLE `histories_jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `employment` int(11) NOT NULL,
  `education` int(11) NOT NULL,
  `job_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_education`
--

DROP TABLE IF EXISTS `history_education`;
CREATE TABLE `history_education` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `seq` int(11) DEFAULT '0',
  `establishment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_employment`
--

DROP TABLE IF EXISTS `history_employment`;
CREATE TABLE `history_employment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `seq` int(11) DEFAULT '0',
  `company_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `id_checks`
--

DROP TABLE IF EXISTS `id_checks`;
CREATE TABLE `id_checks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `pass` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit_lines` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sanctions` int(11) DEFAULT NULL,
  `pep` int(11) DEFAULT NULL,
  `submitted_on` datetime DEFAULT NULL,
  `short_url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `unique_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `profile` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `director_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'PENDING',
  `directorships` text COLLATE utf8_unicode_ci,
  `director_links` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `id_check_files`
--

DROP TABLE IF EXISTS `id_check_files`;
CREATE TABLE `id_check_files` (
  `id` int(11) NOT NULL,
  `uniqueId` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `friendlyName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `storedName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `mimeType` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `docType` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `dateStored` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `integer_field`
--

DROP TABLE IF EXISTS `integer_field`;
CREATE TABLE `integer_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `required` int(11) NOT NULL,
  `filterable` int(11) DEFAULT NULL,
  `filter_on` int(11) DEFAULT NULL,
  `filter_operator` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

DROP TABLE IF EXISTS `interviews`;
CREATE TABLE `interviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` int(11) NOT NULL,
  `employer_user_id` int(11) NOT NULL,
  `interview_date` datetime NOT NULL,
  `sms` int(11) NOT NULL DEFAULT '0',
  `email` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accepted` int(11) DEFAULT NULL,
  `accepted_on` datetime DEFAULT NULL,
  `rejected` int(11) DEFAULT NULL,
  `rejected_on` datetime DEFAULT NULL,
  `reject_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rejected_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details_url` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unique_ref` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8_unicode_ci,
  `ics` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `category` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salary` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `positions` int(11) DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `uniqueid` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `archived` int(11) DEFAULT NULL,
  `archived_date` datetime DEFAULT NULL,
  `short_url` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `checkabl` tinyint(4) DEFAULT '0',
  `personabl` tinyint(4) DEFAULT '0',
  `testabl` tinyint(4) DEFAULT '0',
  `pre_screen` tinyint(4) DEFAULT '0',
  `history` tinyint(4) DEFAULT '0',
  `disclosures` tinyint(4) DEFAULT '0',
  `identity` tinyint(4) DEFAULT '0',
  `jb_indeed` smallint(6) NOT NULL DEFAULT '0',
  `employment_max` int(11) NOT NULL DEFAULT '0',
  `education_max` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_statuses`
--

DROP TABLE IF EXISTS `jobs_statuses`;
CREATE TABLE `jobs_statuses` (
  `id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

DROP TABLE IF EXISTS `job_categories`;
CREATE TABLE `job_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(155) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `category`) VALUES
(0, 'Accountancy, banking and finance'),
(1, 'Business, consulting and management'),
(2, 'Charity and voluntary work'),
(3, 'Cleaning and housekeeping'),
(4, 'Energy and utilities'),
(5, 'Engineering and manufacturing'),
(6, 'Environment and agriculture'),
(7, 'Healthcare'),
(8, 'Hospitality and events management'),
(9, 'Information research and analysis'),
(10, 'Information technology'),
(11, 'Insurance and pensions'),
(12, 'Law'),
(13, 'Law enforcement and security'),
(14, 'Leisure, sport and tourism'),
(15, 'Marketing, advertising and PR'),
(16, 'Media and internet'),
(17, 'Performing arts'),
(18, 'Property and construction'),
(19, 'Public services and administration'),
(20, 'Publishing and journalism'),
(21, 'Recruitment and HR'),
(22, 'Retail'),
(23, 'Sales'),
(24, 'Science and pharmaceuticals'),
(25, 'Social care'),
(26, 'Teaching and education'),
(27, 'Transport and logistics'),
(1000, 'Background Checks');

-- --------------------------------------------------------

--
-- Table structure for table `job_status`
--

DROP TABLE IF EXISTS `job_status`;
CREATE TABLE `job_status` (
  `id` int(11) NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_status`
--

INSERT INTO `job_status` (`id`, `status`) VALUES
(1, 'Open'),
(2, 'Interview'),
(3, 'Offered'),
(4, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `last_action`
--

DROP TABLE IF EXISTS `last_action`;
CREATE TABLE `last_action` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `last_action_exclusions`
--

DROP TABLE IF EXISTS `last_action_exclusions`;
CREATE TABLE `last_action_exclusions` (
  `id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_user`
--

DROP TABLE IF EXISTS `master_user`;
CREATE TABLE `master_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `master_user`
--

INSERT INTO `master_user` (`id`, `user_id`, `employer_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `mediatype` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `job_id` varchar(40) DEFAULT NULL,
  `seq` int(11) NOT NULL,
  `filename` varchar(32) NOT NULL,
  `format` varchar(20) NOT NULL DEFAULT 'ORIGINAL',
  `extn` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `number_range_field`
--

DROP TABLE IF EXISTS `number_range_field`;
CREATE TABLE `number_range_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `required` int(11) NOT NULL,
  `filterable` int(11) DEFAULT NULL,
  `filter_on` int(11) DEFAULT NULL,
  `filter_operator` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `number_value`
--

DROP TABLE IF EXISTS `number_value`;
CREATE TABLE `number_value` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passport_data`
--

DROP TABLE IF EXISTS `passport_data`;
CREATE TABLE `passport_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_code` varchar(50) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `nationality` varchar(3) DEFAULT NULL,
  `issue_date` varchar(20) DEFAULT NULL,
  `expiry_date` varchar(20) DEFAULT NULL,
  `mrz` varchar(100) DEFAULT NULL,
  `document_number` varchar(200) DEFAULT NULL,
  `country` varchar(3) DEFAULT NULL,
  `authenticity` varchar(50) DEFAULT NULL,
  `testinfo` text NOT NULL,
  `response` text NOT NULL,
  `date_scanned` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accepted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pools`
--

DROP TABLE IF EXISTS `pools`;
CREATE TABLE `pools` (
  `id` int(11) NOT NULL,
  `pool_name` varchar(100) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `num_questions` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pool_questions`
--

DROP TABLE IF EXISTS `pool_questions`;
CREATE TABLE `pool_questions` (
  `id` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `question_type` varchar(20) NOT NULL,
  `secs` int(11) NOT NULL DEFAULT '60',
  `data_values` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `postcode_cache`
--

DROP TABLE IF EXISTS `postcode_cache`;
CREATE TABLE `postcode_cache` (
  `postcode` varchar(10) NOT NULL,
  `date_cached` datetime NOT NULL,
  `response` text NOT NULL,
  `keep_cached` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postcode_cache`
--

INSERT INTO `postcode_cache` (`postcode`, `date_cached`, `response`, `keep_cached`) VALUES
('EN26TY', '2018-07-02 13:23:47', '{\"latitude\":51.648383499999987,\"longitude\":-0.080819099999999991,\"addresses\":[\"1 Tiptree Drive, , , , , Enfield, Middlesex\",\"10 Tiptree Drive, , , , , Enfield, Middlesex\",\"11 Tiptree Drive, , , , , Enfield, Middlesex\",\"12 Tiptree Drive, , , , , Enfield, Middlesex\",\"13 Tiptree Drive, , , , , Enfield, Middlesex\",\"14 Tiptree Drive, , , , , Enfield, Middlesex\",\"17 Tiptree Drive, , , , , Enfield, Middlesex\",\"18 Tiptree Drive, , , , , Enfield, Middlesex\",\"19 Tiptree Drive, , , , , Enfield, Middlesex\",\"2 Tiptree Drive, , , , , Enfield, Middlesex\",\"20 Tiptree Drive, , , , , Enfield, Middlesex\",\"21 Tiptree Drive, , , , , Enfield, Middlesex\",\"3 Tiptree Drive, , , , , Enfield, Middlesex\",\"4 Tiptree Drive, , , , , Enfield, Middlesex\",\"5 Tiptree Drive, , , , , Enfield, Middlesex\",\"6 Tiptree Drive, , , , , Enfield, Middlesex\",\"7 Tiptree Drive, , , , , Enfield, Middlesex\",\"8 Tiptree Drive, , , , , Enfield, Middlesex\",\"9 Tiptree Drive, , , , , Enfield, Middlesex\"]}\r\n', 1),
('EN28JH', '2018-07-02 16:50:20', '{\"latitude\":51.6646253,\"longitude\":-0.1059172,\"addresses\":[\"102 The Ridgeway, , , , , Enfield, Middlesex\",\"104 The Ridgeway, , , , , Enfield, Middlesex\",\"106 The Ridgeway, , , , , Enfield, Middlesex\",\"108 The Ridgeway, , , , , Enfield, Middlesex\",\"110 The Ridgeway, , , , , Enfield, Middlesex\",\"112 The Ridgeway, , , , , Enfield, Middlesex\",\"114 The Ridgeway, , , , , Enfield, Middlesex\",\"116 The Ridgeway, , , , , Enfield, Middlesex\"]}', 1),
('EN28PB', '2017-07-02 16:35:39', '{\"latitude\":51.656052,\"longitude\":-0.098274699999999993,\"addresses\":[\"25 The Ridgeway, , , , , Enfield, Middlesex\",\"27a The Ridgeway, , , , , Enfield, Middlesex\",\"27b The Ridgeway, , , , , Enfield, Middlesex\",\"27c The Ridgeway, , , , , Enfield, Middlesex\",\"27d The Ridgeway, , , , , Enfield, Middlesex\",\"27e The Ridgeway, , , , , Enfield, Middlesex\",\"27f The Ridgeway, , , , , Enfield, Middlesex\",\"31 The Ridgeway, , , , , Enfield, Middlesex\",\"33 The Ridgeway, , , , , Enfield, Middlesex\",\"35 The Ridgeway, , , , , Enfield, Middlesex\",\"Flat 1, 29 The Ridgeway, , , , Enfield, Middlesex\",\"Flat 2, 29 The Ridgeway, , , , Enfield, Middlesex\",\"Flat 3, 29 The Ridgeway, , , , Enfield, Middlesex\",\"Flat 4, 29 The Ridgeway, , , , Enfield, Middlesex\"]}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pre_screen`
--

DROP TABLE IF EXISTS `pre_screen`;
CREATE TABLE `pre_screen` (
  `id` int(11) NOT NULL,
  `job_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `java_development_experience` int(11) NOT NULL,
  `low_latency_experience` int(11) NOT NULL,
  `network_layer_experience` int(11) NOT NULL,
  `lock_free_algorithms_experience` int(11) NOT NULL,
  `linear_algebra_experience` int(11) NOT NULL,
  `telemetry_systems_experience` int(11) NOT NULL,
  `cexperience` int(11) NOT NULL,
  `database_experience` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualification_checks`
--

DROP TABLE IF EXISTS `qualification_checks`;
CREATE TABLE `qualification_checks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `institute_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employer_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `submitted_on` datetime DEFAULT NULL,
  `short_url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `membership` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `award` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grade` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enrolment` int(11) DEFAULT NULL,
  `graduated` int(11) DEFAULT NULL,
  `verification_id` int(11) DEFAULT NULL,
  `verification_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verification_response` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

DROP TABLE IF EXISTS `reference`;
CREATE TABLE `reference` (
  `id` int(11) NOT NULL,
  `reference_request_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(155) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reference_request`
--

DROP TABLE IF EXISTS `reference_request`;
CREATE TABLE `reference_request` (
  `id` int(11) NOT NULL,
  `job_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `applicant_message` text COLLATE utf8_unicode_ci NOT NULL,
  `no_of_references` int(11) NOT NULL,
  `return_emails` text COLLATE utf8_unicode_ci NOT NULL,
  `unique_ref` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rejection_reason`
--

DROP TABLE IF EXISTS `rejection_reason`;
CREATE TABLE `rejection_reason` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_CLIENT'),
(3, 'ROLE_APPLICANT'),
(4, 'ROLE_MASTER_CLIENT');

-- --------------------------------------------------------

--
-- Table structure for table `section_defaults`
--

DROP TABLE IF EXISTS `section_defaults`;
CREATE TABLE `section_defaults` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `checkabl` int(11) NOT NULL DEFAULT '1',
  `testabl` int(11) NOT NULL DEFAULT '1',
  `personabl` int(11) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_jobs`
--

DROP TABLE IF EXISTS `section_jobs`;
CREATE TABLE `section_jobs` (
  `id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `checkabl` int(11) NOT NULL DEFAULT '1',
  `testabl` int(11) NOT NULL DEFAULT '1',
  `personabl` int(11) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `skill` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills_employer`
--

DROP TABLE IF EXISTS `skills_employer`;
CREATE TABLE `skills_employer` (
  `id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills_jobs_users`
--

DROP TABLE IF EXISTS `skills_jobs_users`;
CREATE TABLE `skills_jobs_users` (
  `skill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_verification`
--

DROP TABLE IF EXISTS `sms_verification`;
CREATE TABLE `sms_verification` (
  `id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  `issue_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirm_date` datetime DEFAULT NULL,
  `status` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msgid` varchar(65) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

DROP TABLE IF EXISTS `source`;
CREATE TABLE `source` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `source`
--

INSERT INTO `source` (`id`, `name`) VALUES
(1, 'Reed'),
(2, 'Indeed'),
(3, 'CW Jobs'),
(4, 'Job Search'),
(5, 'Monster'),
(6, 'Job Site'),
(7, 'Fish4'),
(8, 'Total Jobs'),
(9, 'Adecco'),
(10, 'Permatemps'),
(11, 'The Times'),
(12, 'The Guardian'),
(13, 'The Financial Times'),
(14, 'The Independant'),
(15, 'Word of Mouth'),
(16, 'Manpower'),
(17, 'Randstad'),
(18, 'Allegis'),
(19, 'Hays'),
(20, 'All Jobs UK'),
(21, 'Michael Page'),
(22, 'City Jobs'),
(23, 'IPS Group');

-- --------------------------------------------------------

--
-- Table structure for table `source_by_employers`
--

DROP TABLE IF EXISTS `source_by_employers`;
CREATE TABLE `source_by_employers` (
  `id` int(11) NOT NULL,
  `source_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `employer_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `terms` text COLLATE utf8_unicode_ci NOT NULL,
  `employer` int(11) NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_agreed`
--

DROP TABLE IF EXISTS `terms_agreed`;
CREATE TABLE `terms_agreed` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terms_files`
--

DROP TABLE IF EXISTS `terms_files`;
CREATE TABLE `terms_files` (
  `id` int(11) NOT NULL,
  `terms_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendlyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_jobs`
--

DROP TABLE IF EXISTS `terms_jobs`;
CREATE TABLE `terms_jobs` (
  `terms_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_allocation`
--

DROP TABLE IF EXISTS `test_allocation`;
CREATE TABLE `test_allocation` (
  `link_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `text_area_field`
--

DROP TABLE IF EXISTS `text_area_field`;
CREATE TABLE `text_area_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `text_area_value`
--

DROP TABLE IF EXISTS `text_area_value`;
CREATE TABLE `text_area_value` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `text_field`
--

DROP TABLE IF EXISTS `text_field`;
CREATE TABLE `text_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `text_value`
--

DROP TABLE IF EXISTS `text_value`;
CREATE TABLE `text_value` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `url_field`
--

DROP TABLE IF EXISTS `url_field`;
CREATE TABLE `url_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(254) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hometel` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobiletel` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailaddress` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiry` datetime DEFAULT NULL,
  `redirect` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_password` int(11) DEFAULT NULL,
  `retention` int(11) DEFAULT '0',
  `reset` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `surname`, `hometel`, `mobiletel`, `emailaddress`, `last_logged_in`, `employer_id`, `token`, `expiry`, `redirect`, `temp_password`, `retention`, `reset`) VALUES
(1, 'admin', '$2y$10$KfkTStdsezr1/9ZZ2EbQzukCl5e7nAxcq75JeXwkKC95kaarBrhTu', 'Matt', 'David', '+99 8111 2222', '+99 07123 123456', 'admin@dev.dev', NULL, 1, NULL, NULL, NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usersjob_webhooklog`
--

DROP TABLE IF EXISTS `usersjob_webhooklog`;
CREATE TABLE `usersjob_webhooklog` (
  `userjob_id` int(11) NOT NULL,
  `weblog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_job`
--

DROP TABLE IF EXISTS `users_job`;
CREATE TABLE `users_job` (
  `id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `checkabl_count` int(11) DEFAULT NULL,
  `checkabl_completed` int(11) DEFAULT NULL,
  `testabl_count` int(11) DEFAULT NULL,
  `testabl_completed` int(11) DEFAULT NULL,
  `personabl_count` int(11) DEFAULT NULL,
  `personabl_completed` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pre_screen_pass` int(11) DEFAULT NULL,
  `archived` int(11) DEFAULT '0',
  `accepted` int(11) DEFAULT NULL,
  `web_hook_processed` int(11) DEFAULT NULL,
  `offered` int(11) DEFAULT NULL,
  `rejected` int(11) DEFAULT NULL,
  `accepted_on` datetime DEFAULT NULL,
  `offered_on` datetime DEFAULT NULL,
  `rejected_on` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles` (
  `users_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`users_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `video_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `app_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `question_id` int(11) NOT NULL,
  `recorded_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `videos_and_questions`
--

DROP TABLE IF EXISTS `videos_and_questions`;
CREATE TABLE `videos_and_questions` (
  `id` int(11) NOT NULL,
  `job_id` varchar(32) NOT NULL,
  `question` varchar(512) NOT NULL,
  `video` int(11) DEFAULT '0',
  `qvideo_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) DEFAULT NULL,
  `recorded_on` datetime DEFAULT NULL,
  `video_id` varchar(45) DEFAULT NULL,
  `vid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `video_answers`
--

DROP TABLE IF EXISTS `video_answers`;
CREATE TABLE `video_answers` (
  `id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_questions`
--

DROP TABLE IF EXISTS `video_questions`;
CREATE TABLE `video_questions` (
  `id` int(11) NOT NULL,
  `job_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `question` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `video` int(11) DEFAULT '0',
  `media_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watch`
--

DROP TABLE IF EXISTS `watch`;
CREATE TABLE `watch` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_hook_log`
--

DROP TABLE IF EXISTS `web_hook_log`;
CREATE TABLE `web_hook_log` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `response` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_hook_tests`
--

DROP TABLE IF EXISTS `web_hook_tests`;
CREATE TABLE `web_hook_tests` (
  `id` int(11) NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `yes_no_field`
--

DROP TABLE IF EXISTS `yes_no_field`;
CREATE TABLE `yes_no_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `required` int(11) NOT NULL,
  `filter_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_terms`
--
ALTER TABLE `accepted_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_to_address_idx` (`userid`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aml_data`
--
ALTER TABLE `aml_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apikeys`
--
ALTER TABLE `apikeys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicantdata_applicantaddress`
--
ALTER TABLE `applicantdata_applicantaddress`
  ADD PRIMARY KEY (`data_id`,`addr_id`),
  ADD UNIQUE KEY `UNIQ_72E88B58174C70DB` (`addr_id`),
  ADD KEY `IDX_72E88B5837F5A13C` (`data_id`);

--
-- Indexes for table `applicantdata_applicantname`
--
ALTER TABLE `applicantdata_applicantname`
  ADD PRIMARY KEY (`data_id`,`name_id`),
  ADD UNIQUE KEY `UNIQ_9E44C7CB71179CD6` (`name_id`),
  ADD KEY `IDX_9E44C7CB37F5A13C` (`data_id`);

--
-- Indexes for table `applicant_disclosures`
--
ALTER TABLE `applicant_disclosures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_idx` (`code`);

--
-- Indexes for table `applicant_disclosure_data`
--
ALTER TABLE `applicant_disclosure_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FBDE90CCF46527EF` (`birth_county`),
  ADD KEY `IDX_FBDE90CC63BB7A9A` (`address_county`),
  ADD KEY `user1_idx` (`applicant_id`);

--
-- Indexes for table `applicant_disclosure_update_response`
--
ALTER TABLE `applicant_disclosure_update_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_disclosure_verification`
--
ALTER TABLE `applicant_disclosure_verification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9FA34AD03E030ACD` (`application_id`);

--
-- Indexes for table `applicant_prev_address`
--
ALTER TABLE `applicant_prev_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6127C21758E2FF25` (`county`);

--
-- Indexes for table `applicant_prev_name`
--
ALTER TABLE `applicant_prev_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_rating`
--
ALTER TABLE `applicant_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_share`
--
ALTER TABLE `applicant_share`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_verification`
--
ALTER TABLE `bank_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkabl_filters`
--
ALTER TABLE `checkabl_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checked_details`
--
ALTER TABLE `checked_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checks`
--
ALTER TABLE `checks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consent_import`
--
ALTER TABLE `consent_import`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactrequest`
--
ALTER TABLE `contactrequest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counties`
--
ALTER TABLE `counties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `county` (`county`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`iso2`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `country_field`
--
ALTER TABLE `country_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `css_schemes`
--
ALTER TABLE `css_schemes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9D340ADC41CD9E7A` (`employer_id`);

--
-- Indexes for table `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cv_check`
--
ALTER TABLE `cv_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_config`
--
ALTER TABLE `dashboard_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `date_field`
--
ALTER TABLE `date_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date_value`
--
ALTER TABLE `date_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devphone`
--
ALTER TABLE `devphone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `director_checks`
--
ALTER TABLE `director_checks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driving_data`
--
ALTER TABLE `driving_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_field`
--
ALTER TABLE `email_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employers_tests`
--
ALTER TABLE `employers_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer_job_titles`
--
ALTER TABLE `employer_job_titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer_job_tracker`
--
ALTER TABLE `employer_job_tracker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `excel_tests`
--
ALTER TABLE `excel_tests`
  ADD PRIMARY KEY (`test_id`,`file`);

--
-- Indexes for table `excel_tests_jobs`
--
ALTER TABLE `excel_tests_jobs`
  ADD PRIMARY KEY (`test_id`,`job_id`);

--
-- Indexes for table `excel_test_allocation`
--
ALTER TABLE `excel_test_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `excel_test_results`
--
ALTER TABLE `excel_test_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extrachecks`
--
ALTER TABLE `extrachecks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facecompare_checks`
--
ALTER TABLE `facecompare_checks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form_name` (`form_name`,`form_type`,`employer_id`,`job_id`);

--
-- Indexes for table `form_answers`
--
ALTER TABLE `form_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_completed`
--
ALTER TABLE `form_completed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_jobs`
--
ALTER TABLE `form_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employer_id` (`employer_id`,`form_id`,`job_id`);

--
-- Indexes for table `form_questions`
--
ALTER TABLE `form_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_type`
--
ALTER TABLE `form_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_user_jobs`
--
ALTER TABLE `form_user_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form_id` (`form_id`,`user_id`,`job_id`);

--
-- Indexes for table `gbg_image_response`
--
ALTER TABLE `gbg_image_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gbg_response`
--
ALTER TABLE `gbg_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gbg_responses`
--
ALTER TABLE `gbg_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histories_complete`
--
ALTER TABLE `histories_complete`
  ADD PRIMARY KEY (`job_id`,`user_id`);

--
-- Indexes for table `histories_defaults`
--
ALTER TABLE `histories_defaults`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histories_jobs`
--
ALTER TABLE `histories_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_education`
--
ALTER TABLE `history_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_employment`
--
ALTER TABLE `history_employment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id_checks`
--
ALTER TABLE `id_checks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id_check_files`
--
ALTER TABLE `id_check_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `integer_field`
--
ALTER TABLE `integer_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_statuses`
--
ALTER TABLE `jobs_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_status`
--
ALTER TABLE `job_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_action`
--
ALTER TABLE `last_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_action_exclusions`
--
ALTER TABLE `last_action_exclusions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_user`
--
ALTER TABLE `master_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `number_range_field`
--
ALTER TABLE `number_range_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `number_value`
--
ALTER TABLE `number_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passport_data`
--
ALTER TABLE `passport_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pools`
--
ALTER TABLE `pools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form_name` (`pool_name`,`employer_id`);

--
-- Indexes for table `pool_questions`
--
ALTER TABLE `pool_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postcode_cache`
--
ALTER TABLE `postcode_cache`
  ADD UNIQUE KEY `postcode` (`postcode`);

--
-- Indexes for table `pre_screen`
--
ALTER TABLE `pre_screen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qualification_checks`
--
ALTER TABLE `qualification_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_758AA8F4A76ED395` (`user_id`),
  ADD KEY `IDX_758AA8F4BE04EA9` (`job_id`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference_request`
--
ALTER TABLE `reference_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rejection_reason`
--
ALTER TABLE `rejection_reason`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_defaults`
--
ALTER TABLE `section_defaults`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_jobs`
--
ALTER TABLE `section_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills_employer`
--
ALTER TABLE `skills_employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills_jobs_users`
--
ALTER TABLE `skills_jobs_users`
  ADD PRIMARY KEY (`skill_id`,`user_id`,`job_id`);

--
-- Indexes for table `sms_verification`
--
ALTER TABLE `sms_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source`
--
ALTER TABLE `source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source_by_employers`
--
ALTER TABLE `source_by_employers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_agreed`
--
ALTER TABLE `terms_agreed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_files`
--
ALTER TABLE `terms_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_jobs`
--
ALTER TABLE `terms_jobs`
  ADD PRIMARY KEY (`terms_id`,`job_id`);

--
-- Indexes for table `test_allocation`
--
ALTER TABLE `test_allocation`
  ADD PRIMARY KEY (`link_id`,`employer_id`);

--
-- Indexes for table `text_area_field`
--
ALTER TABLE `text_area_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `text_area_value`
--
ALTER TABLE `text_area_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `text_field`
--
ALTER TABLE `text_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `text_value`
--
ALTER TABLE `text_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `url_field`
--
ALTER TABLE `url_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- Indexes for table `usersjob_webhooklog`
--
ALTER TABLE `usersjob_webhooklog`
  ADD PRIMARY KEY (`userjob_id`,`weblog_id`),
  ADD UNIQUE KEY `UNIQ_7927D3C0AD4CB584` (`weblog_id`),
  ADD KEY `IDX_7927D3C0631A596D` (`userjob_id`);

--
-- Indexes for table `users_job`
--
ALTER TABLE `users_job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`users_id`,`role_id`),
  ADD KEY `IDX_51498A8E67B3B43D` (`users_id`),
  ADD KEY `IDX_51498A8ED60322AC` (`role_id`);

--
-- Indexes for table `video_answers`
--
ALTER TABLE `video_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_questions`
--
ALTER TABLE `video_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watch`
--
ALTER TABLE `watch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_500B4A26BE04EA9` (`job_id`),
  ADD KEY `IDX_500B4A2697139001` (`applicant_id`),
  ADD KEY `IDX_500B4A2641CD9E7A` (`employer_id`);

--
-- Indexes for table `web_hook_log`
--
ALTER TABLE `web_hook_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_hook_tests`
--
ALTER TABLE `web_hook_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yes_no_field`
--
ALTER TABLE `yes_no_field`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_terms`
--
ALTER TABLE `accepted_terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `aml_data`
--
ALTER TABLE `aml_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `apikeys`
--
ALTER TABLE `apikeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applicant_disclosures`
--
ALTER TABLE `applicant_disclosures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applicant_disclosure_data`
--
ALTER TABLE `applicant_disclosure_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applicant_disclosure_update_response`
--
ALTER TABLE `applicant_disclosure_update_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applicant_disclosure_verification`
--
ALTER TABLE `applicant_disclosure_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applicant_prev_address`
--
ALTER TABLE `applicant_prev_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applicant_prev_name`
--
ALTER TABLE `applicant_prev_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applicant_rating`
--
ALTER TABLE `applicant_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applicant_share`
--
ALTER TABLE `applicant_share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bank_verification`
--
ALTER TABLE `bank_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checkabl_filters`
--
ALTER TABLE `checkabl_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checked_details`
--
ALTER TABLE `checked_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checks`
--
ALTER TABLE `checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consent_import`
--
ALTER TABLE `consent_import`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contactrequest`
--
ALTER TABLE `contactrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `counties`
--
ALTER TABLE `counties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `country_field`
--
ALTER TABLE `country_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `credit`
--
ALTER TABLE `credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `css_schemes`
--
ALTER TABLE `css_schemes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cv`
--
ALTER TABLE `cv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cv_check`
--
ALTER TABLE `cv_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dashboard_config`
--
ALTER TABLE `dashboard_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `date_field`
--
ALTER TABLE `date_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `date_value`
--
ALTER TABLE `date_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `devphone`
--
ALTER TABLE `devphone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `director_checks`
--
ALTER TABLE `director_checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `driving_data`
--
ALTER TABLE `driving_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_field`
--
ALTER TABLE `email_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_verification`
--
ALTER TABLE `email_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employers`
--
ALTER TABLE `employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `employers_tests`
--
ALTER TABLE `employers_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employer_job_titles`
--
ALTER TABLE `employer_job_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employer_job_tracker`
--
ALTER TABLE `employer_job_tracker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `excel_test_allocation`
--
ALTER TABLE `excel_test_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `excel_test_results`
--
ALTER TABLE `excel_test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `extrachecks`
--
ALTER TABLE `extrachecks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `facecompare_checks`
--
ALTER TABLE `facecompare_checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `form_answers`
--
ALTER TABLE `form_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `form_completed`
--
ALTER TABLE `form_completed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `form_jobs`
--
ALTER TABLE `form_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `form_questions`
--
ALTER TABLE `form_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `form_type`
--
ALTER TABLE `form_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `form_user_jobs`
--
ALTER TABLE `form_user_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gbg_image_response`
--
ALTER TABLE `gbg_image_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gbg_response`
--
ALTER TABLE `gbg_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gbg_responses`
--
ALTER TABLE `gbg_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `histories_defaults`
--
ALTER TABLE `histories_defaults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `histories_jobs`
--
ALTER TABLE `histories_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `history_education`
--
ALTER TABLE `history_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `history_employment`
--
ALTER TABLE `history_employment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `id_checks`
--
ALTER TABLE `id_checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `id_check_files`
--
ALTER TABLE `id_check_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `integer_field`
--
ALTER TABLE `integer_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs_statuses`
--
ALTER TABLE `jobs_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `last_action`
--
ALTER TABLE `last_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `last_action_exclusions`
--
ALTER TABLE `last_action_exclusions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master_user`
--
ALTER TABLE `master_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `number_range_field`
--
ALTER TABLE `number_range_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `number_value`
--
ALTER TABLE `number_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `passport_data`
--
ALTER TABLE `passport_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pools`
--
ALTER TABLE `pools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pool_questions`
--
ALTER TABLE `pool_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pre_screen`
--
ALTER TABLE `pre_screen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `qualification_checks`
--
ALTER TABLE `qualification_checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reference_request`
--
ALTER TABLE `reference_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rejection_reason`
--
ALTER TABLE `rejection_reason`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `section_defaults`
--
ALTER TABLE `section_defaults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `section_jobs`
--
ALTER TABLE `section_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `skills_employer`
--
ALTER TABLE `skills_employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sms_verification`
--
ALTER TABLE `sms_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `source`
--
ALTER TABLE `source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `source_by_employers`
--
ALTER TABLE `source_by_employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `terms_agreed`
--
ALTER TABLE `terms_agreed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `terms_files`
--
ALTER TABLE `terms_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `text_area_field`
--
ALTER TABLE `text_area_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `text_area_value`
--
ALTER TABLE `text_area_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `text_field`
--
ALTER TABLE `text_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `text_value`
--
ALTER TABLE `text_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `url_field`
--
ALTER TABLE `url_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_job`
--
ALTER TABLE `users_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `video_answers`
--
ALTER TABLE `video_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `video_questions`
--
ALTER TABLE `video_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `watch`
--
ALTER TABLE `watch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `web_hook_log`
--
ALTER TABLE `web_hook_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `web_hook_tests`
--
ALTER TABLE `web_hook_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `yes_no_field`
--
ALTER TABLE `yes_no_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
