-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2017 at 11:43 AM
-- Server version: 5.7.20-0ubuntu0.16.04.1-log
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asthra_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_colleges`
--

DROP TABLE IF EXISTS `tbl_colleges`;
CREATE TABLE `tbl_colleges` (
  `collegeId` varchar(20) NOT NULL,
  `collegeName` varchar(200) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(300) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_colleges`
--

INSERT INTO `tbl_colleges` (`collegeId`, `collegeName`, `verified`, `address`, `phone`, `Email`) VALUES
('COL5a3e15ca9b03b', 'St.Thomas College ,Konni', 1, NULL, NULL, NULL),
('COL5a3e15cabcef7', 'Alphonsa College, Pala', 1, NULL, NULL, NULL),
('COL5a3e15cad1f52', 'Al Ameen College, Edathala', 1, NULL, NULL, NULL),
('COL5a3e15caebad7', 'Bharata Mata College , Thrikkakkara', 1, NULL, NULL, NULL),
('COL5a3e15cb159d2', 'Baker College for Women, Kottayam', 1, NULL, NULL, NULL),
('COL5a3e15cb3646a', 'Baselios College, kottayam', 1, NULL, NULL, NULL),
('COL5a3e15cb41339', 'Bishop Abraham Memorial College, Thurithicadu', 1, NULL, NULL, NULL),
('COL5a3e15cb4c103', 'Bishop Kurialacherry College for Women', 1, NULL, NULL, NULL),
('COL5a3e15cb56f60', 'BPC College, Piravom', 1, NULL, NULL, NULL),
('COL5a3e15cb61dfc', 'Bishop vayalil memorial holycross college cherpunkal,pala', 1, NULL, NULL, NULL),
('COL5a3e15cb6cc6f', 'Catholicate College, Pathanamthitta', 1, NULL, NULL, NULL),
('COL5a3e15cb77b14', 'Cochin College, Cochin', 1, NULL, NULL, NULL),
('COL5a3e15cb829f7', 'College of Applied Science (IHRD), Kanjirappally', 1, NULL, NULL, NULL),
('COL5a3e15cb8d867', 'College of Applied Science (IHRD), Kattappana', 1, NULL, NULL, NULL),
('COL5a3e15cb98680', 'College of Applied Science (IHRD), Kuttikkanam peeremade', 1, NULL, NULL, NULL),
('COL5a3e15cba35a1', 'DC School of Management and Technology, Vagamon', 1, NULL, NULL, NULL),
('COL5a3e15cbae3ee', 'Deva Matha College, Kuravilangad', 1, NULL, NULL, NULL),
('COL5a3e15cbb9260', 'De Paul Institute of Technology, Angamaly', 1, NULL, NULL, NULL),
('COL5a3e15cbc40a7', 'Ettumanoorappan College, Ettumanoor', 1, NULL, NULL, NULL),
('COL5a3e15cbcef52', 'Girideepam Institute of Advanced Learning,Kottayam', 1, NULL, NULL, NULL),
('COL5a3e15cbd9d88', 'Government College, Nattakam, Kottayam', 1, NULL, NULL, NULL),
('COL5a3e15cbe4c1e', 'Government College, Kattapana', 1, NULL, NULL, NULL),
('COL5a3e15cbefa63', 'Government College, Manimalakunnu, Koothattukulam', 1, NULL, NULL, NULL),
('COL5a3e15cc0668a', 'Government College, Tripunithura', 1, NULL, NULL, NULL),
('COL5a3e15cc114de', 'Henry Baker College, Melukavu', 1, NULL, NULL, NULL),
('COL5a3e15cc1c355', 'Holy Cross College of Management & Technology, Puttady, Idukki', 1, NULL, NULL, NULL),
('COL5a3e15cc271c3', 'Jawaharlal Nehru Institute of Arts & Science (JNIAS),Balagram, Idukki', 1, NULL, NULL, NULL),
('COL5a3e15cc32048', 'JPM College of Arts & Science, Labbakkada, Idukki', 1, NULL, NULL, NULL),
('COL5a3e15cc3ceee', 'Kuriakose Elias College, Mannanam', 1, NULL, NULL, NULL),
('COL5a3e15cc47d6e', 'Kuriakose Gregorios College,Pampady', 1, NULL, NULL, NULL),
('COL5a3e15cc52bb6', 'KMM College of Arts and Science, Thrikkakara', 1, NULL, NULL, NULL),
('COL5a3e15cc5aedd', 'Nirmala College, Muvattupuzha', 1, NULL, NULL, NULL),
('COL5a3e15cc631e7', 'Newman College, Thodupuzha', 1, NULL, NULL, NULL),
('COL5a3e15cc6b4e8', 'MES college, Erattupetta', 1, NULL, NULL, NULL),
('COL5a3e15cc7ba21', 'MES College, Nedumkandam', 1, NULL, NULL, NULL),
('COL5a3e15cc83d7a', 'Mannam Memorial N.S.S. College, Konni', 1, NULL, NULL, NULL),
('COL5a3e15cc8c0d6', 'Mar Augusthinose College, Ramapuram', 1, NULL, NULL, NULL),
('COL5a3e15cc94350', 'Mar Kuriakose College, Puthuvely', 1, NULL, NULL, NULL),
('COL5a3e15cc9c67f', 'Mar Thoma College Thiruvalla', 1, NULL, NULL, NULL),
('COL5a3e15cca4999', 'Mar Thoma College for Advanced Studies', 1, NULL, NULL, NULL),
('COL5a3e15ccb4f85', 'Marian College Kuttikkanam, Idukki', 1, NULL, NULL, NULL),
('COL5a3e15ccbd1bd', 'MES college, Marampally, Aluva', 1, NULL, NULL, NULL),
('COL5a3e15ccc54cf', 'MES College, Erumely', 1, NULL, NULL, NULL),
('COL5a3e15cccd811', 'MES College, Edathala', 1, NULL, NULL, NULL),
('COL5a3e15ccd5b10', 'NSS College, Changanassery', 1, NULL, NULL, NULL),
('COL5a3e15ccdde1a', 'NSS College, Rajakumari', 1, NULL, NULL, NULL),
('COL5a3e15ccee43b', 'Pavanatma College, Murrickacherry', 1, NULL, NULL, NULL),
('COL5a3e15cd025d5', 'PGM College, Kangazha', 1, NULL, NULL, NULL),
('COL5a3e15cd0a838', 'Parumala Mar Gregorios College, Thiruvalla', 1, NULL, NULL, NULL),
('COL5a3e15cd13324', 'RLV College of Music and Fine Arts, Tripunithura', 1, NULL, NULL, NULL),
('COL5a3e15cd23850', 'Rajagiri College of Social Science, Kalamassery', 1, NULL, NULL, NULL),
('COL5a3e15cd2e83d', 'SAS SNDP YOGAM College, Konni', 1, NULL, NULL, NULL),
('COL5a3e15cd3ec0c', 'Santhigiri college of Computer Sciences, Vazhithala', 1, NULL, NULL, NULL),
('COL5a3e15cd49a8b', 'Santhigiri Institute of Management, Vazhithala', 1, NULL, NULL, NULL),
('COL5a3e15cd548d3', 'SNM College, Maliankara, Moothakunnam', 1, NULL, NULL, NULL),
('COL5a3e15cd5f756', 'Saint Ephrem Ecumenical Research Institute', 1, NULL, NULL, NULL),
('COL5a3e15cd6a5d9', 'Siena College of Professional Studies, Edacochin', 1, NULL, NULL, NULL),
('COL5a3e15cd7550a', 'Sree Vidyadhi Raja N S S College', 1, NULL, NULL, NULL),
('COL5a3e15cd802a6', 'St Johns College, Prakkanam', 1, NULL, NULL, NULL),
('COL5a3e15cd8b389', 'St. Dominic\'s College, Kanjirapally', 1, NULL, NULL, NULL),
('COL5a3e15cd962a9', 'St. Johns Institute of Technology, Pathanamthitta', 1, NULL, NULL, NULL),
('COL5a3e15cda67d0', 'St. Mary\'s College, Manarcaud Kottayam', 1, NULL, NULL, NULL),
('COL5a3e15cdb162a', 'St. Peter\'s College, Kolenchery', 1, NULL, NULL, NULL),
('COL5a3e15cdbc590', 'St. Stephen\'s College, Uzhavoor', 1, NULL, NULL, NULL),
('COL5a3e15cdc733a', 'St. Thomas College, Pala', 1, NULL, NULL, NULL),
('COL5a3e15cdd21c1', 'St. Thomas College, Puthencruz', 1, NULL, NULL, NULL),
('COL5a3e15cddd08c', 'St. Xavier\'s College for Women, Aluva', 1, NULL, NULL, NULL),
('COL5a3e15cde7f26', 'St. George\'s College, Aruvithura', 1, NULL, NULL, NULL),
('COL5a3e15cdf2d83', 'St. Thomas College, Kozhencheri', 1, NULL, NULL, NULL),
('COL5a3e15ce06e38', 'Union Christian College, Aluva', 1, NULL, NULL, NULL),
('COL5a3e15ce0f15c', 'Maharaja\'s College, Ernakulam', 1, NULL, NULL, NULL),
('COL5a3e15ce17473', 'Yeldo Mar Baselios College', 1, NULL, NULL, NULL),
('COL5a3e15ce1f737', 'Marthoma College of Management and Technology, Perumbavoor', 1, NULL, NULL, NULL),
('COL5a3e15ce2d150', 'Swami Saswatheekananda College, Poothotta', 1, NULL, NULL, NULL),
('COL5a3e16dbad8dd', 'Government College for Women, Thiruvananthapuram', 1, NULL, NULL, NULL),
('COL5a3e16dbbef0a', 'Government Arts College, Thiruvananthapuram', 1, NULL, NULL, NULL),
('COL5a3e16dbd1f5d', 'University College Thiruvananthapuram', 1, NULL, NULL, NULL),
('COL5a3e16dbdcf31', 'Govt. College, Kariavatttom', 1, NULL, NULL, NULL),
('COL5a3e16dbf2b6a', 'Govt. College, Attingal', 1, NULL, NULL, NULL),
('COL5a3e16dc0edfe', 'Govt. College, Nedumangad', 1, NULL, NULL, NULL),
('COL5a3e16dc19cb9', 'K.N.M. Govt. College, Kanjiramkulam', 1, NULL, NULL, NULL),
('COL5a3e16dc2f8d3', 'All Saints College, Thiruvananthapuram', 1, NULL, NULL, NULL),
('COL5a3e16dc455d2', 'NSS College for Women, Karamana', 1, NULL, NULL, NULL),
('COL5a3e16dc504e0', 'Mahatma Gandhi College, Kesavadasapuram', 1, NULL, NULL, NULL),
('COL5a3e16dc5b330', 'Mar Ivanios College, Nalanchira', 1, NULL, NULL, NULL),
('COL5a3e16dc6619d', 'S.N.College, Sivagiri, Varkala', 1, NULL, NULL, NULL),
('COL5a3e16dc71032', 'S.N.College, Chempazhanthi', 1, NULL, NULL, NULL),
('COL5a3e16dc79377', 'VTM NSS College, Dhanuvachapuram', 1, NULL, NULL, NULL),
('COL5a3e16dc8166e', 'St. Xavier\'s College, Thumba', 1, NULL, NULL, NULL),
('COL5a3e16dc8997f', 'Christian College, Kattakada', 1, NULL, NULL, NULL),
('COL5a3e16dc91c63', 'Iqbal College, Peringammala', 1, NULL, NULL, NULL),
('COL5a3e16dc99f99', 'Mannaniya College of Arts & Science, Pangode', 1, NULL, NULL, NULL),
('COL5a3e16dca2269', 'Loyola College of Social Sciences, Sreekariyam', 1, NULL, NULL, NULL),
('COL5a3e16dcaa563', 'Govt. Arts & science college,Thazhava Karunagappally', 1, NULL, NULL, NULL),
('COL5a3e16dcb28bf', 'Govt. College, Chavara', 1, NULL, NULL, NULL),
('COL5a3e16dcbabcd', 'Fatima Mata National College, Kollam', 1, NULL, NULL, NULL),
('COL5a3e16dcc2f01', 'Devaswom Board College, Sasthamcottah', 1, NULL, NULL, NULL),
('COL5a3e16dccb20c', 'TKM College of Arts & Science, Karicode', 1, NULL, NULL, NULL),
('COL5a3e16dcd3c7c', 'St. Gregorios College, Kottarakara', 1, NULL, NULL, NULL),
('COL5a3e16dcdbfb2', 'St. Stephen\'s College, Pathanapuram', 1, NULL, NULL, NULL),
('COL5a3e16dce6e2d', 'NSS College, Nilamel', 1, NULL, NULL, NULL),
('COL5a3e16dcf1c53', 'SN College for Women, Kollam', 1, NULL, NULL, NULL),
('COL5a3e16dd088bc', 'SN College, Kollam', 1, NULL, NULL, NULL),
('COL5a3e16dd1373a', 'St. John\'s College, Anchal', 1, NULL, NULL, NULL),
('COL5a3e16dd1e588', 'SN College, Punalur', 1, NULL, NULL, NULL),
('COL5a3e16dd2947f', 'Mannam Memorial NSS College, Kottiyam', 1, NULL, NULL, NULL),
('COL5a3e16dd34293', 'SN College, Chathannur', 1, NULL, NULL, NULL),
('COL5a3e16dd3f15c', 'Ayyankali Memorial Arts and Science College, Punalur', 1, NULL, NULL, NULL),
('COL5a3e16dd49f99', 'Bishop Moore College, Mavelikara', 1, NULL, NULL, NULL),
('COL5a3e16dd54e35', 'Christian College, Chengannur', 1, NULL, NULL, NULL),
('COL5a3e16dd5fc78', 'MSM College, Kayamkulam', 1, NULL, NULL, NULL),
('COL5a3e16dd6aad0', 'NSS College, Cherthala', 1, NULL, NULL, NULL),
('COL5a3e16dd759a3', 'SN College, Cherthala', 1, NULL, NULL, NULL),
('COL5a3e16dd807c3', 'SD College, Alappuzha', 1, NULL, NULL, NULL),
('COL5a3e16dd8b6f4', 'St. Joseph\'s College for Women, Alappuzha', 1, NULL, NULL, NULL),
('COL5a3e16dd964eb', 'St. Michael\'s College, Cherthala', 1, NULL, NULL, NULL),
('COL5a3e16dda133c', 'TKMM College, Nangiarkulangara', 1, NULL, NULL, NULL),
('COL5a3e16ddac1bb', 'SN College, Chengannur', 1, NULL, NULL, NULL),
('COL5a3e16ddb7082', 'Sree Ayyappa College, Eramallikara, Thiruvanvandoor', 1, NULL, NULL, NULL),
('COL5a3e16ddc1f49', 'St. Cyril\'s College, Adoor', 1, NULL, NULL, NULL),
('COL5a3e16ddccdbb', 'NSS College, Pandalam', 1, NULL, NULL, NULL),
('COL5a3e19eb18eb7', 'Amal College of Advanced Studies, Nilambur', 1, NULL, NULL, NULL),
('COL5a3e19eb26baa', 'Anwarul Islam Women\'s Arabic College Mongam', 1, NULL, NULL, NULL),
('COL5a3e19eb317d8', 'Aspire College of Advanced Studies, Thrithala, Palakkad', 1, NULL, NULL, NULL),
('COL5a3e19eb3c655', 'Christ College, Irinjalakuda', 1, NULL, NULL, NULL),
('COL5a3e19eb4752a', 'CM College of Arts and Science Nadavayal', 1, NULL, NULL, NULL),
('COL5a3e19eb52351', 'College of Applied Science Malappuram', 1, NULL, NULL, NULL),
('COL5a3e19eb5d23a', 'College of Applied Science, Nadapuram', 1, NULL, NULL, NULL),
('COL5a3e19eb6800c', 'College of Applied Science, Vadakkencherry', 1, NULL, NULL, NULL),
('COL5a3e19eb72ea1', 'Don Bosco College, Thrissur', 1, NULL, NULL, NULL),
('COL5a3e19eb7ddbe', 'E.M.E.A College of Arts & Science, Kondotty, Malappuram', 1, NULL, NULL, NULL),
('COL5a3e19eb88bee', 'Farook College, Feroke, Calicut', 1, NULL, NULL, NULL),
('COL5a3e19eb93a69', 'GEMS Arts & Science College, Ramapuram, Malappuram', 1, NULL, NULL, NULL),
('COL5a3e19eb9e94f', 'Government College Chittur, Palakkad', 1, NULL, NULL, NULL),
('COL5a3e19eba975f', 'Government College for Women, Malappuram', 1, NULL, NULL, NULL),
('COL5a3e19ebbf3ff', 'Government College, Madappally', 1, NULL, NULL, NULL),
('COL5a3e19ebd509a', 'Government College Mokeri', 1, NULL, NULL, NULL),
('COL5a3e19ebdff6e', 'Government Victoria College, Palakkad', 1, NULL, NULL, NULL),
('COL5a3e19ebeadb2', 'Harithagiri Regional College of Science and Humanities, Kizhisseri', 1, NULL, NULL, NULL),
('COL5a3e19ec019e1', 'Jamia Islamia Arts and Science College, Karakkunnu, Trakalagode, Manjeri', 1, NULL, NULL, NULL),
('COL5a3e19ec0c89c', 'Lement College of Advanced Studies, Pattambi', 1, NULL, NULL, NULL),
('COL5a3e19ec1775e', 'Madeenathul Uloom Arabic College', 1, NULL, NULL, NULL),
('COL5a3e19ec22580', 'Ma\'din Arts and Science College, Swalath Nagar, Melmuri Post, Malappuram - 676517', 1, NULL, NULL, NULL),
('COL5a3e19ec2d3e7', 'Majlis Arts & Science College, Valanchery, Malappuram', 1, NULL, NULL, NULL),
('COL5a3e19ec382d8', 'Malabar Christian College, Kozhikode', 1, NULL, NULL, NULL),
('COL5a3e19ec4315e', 'Mar Osthatheos Arts & Science College, Perumpilavu, Thrissur', 1, NULL, NULL, NULL),
('COL5a3e19ec4df5d', 'Markaz College of Arts and Science, Karanthur', 1, NULL, NULL, NULL),
('COL5a3e19ec58e1e', 'Meenchantha Arts College', 1, NULL, NULL, NULL),
('COL5a3e19ec63c6b', 'Mercy College, Palakkad', 1, NULL, NULL, NULL),
('COL5a3e19ec6bf6f', 'MES KVM College, Valanchery', 1, NULL, NULL, NULL),
('COL5a3e19ec742ea', 'M.E.S. Ponnani College, Ponnani', 1, NULL, NULL, NULL),
('COL5a3e19ec7c563', 'Mother Arts and Science College Peruvallur, Thrissur', 1, NULL, NULL, NULL),
('COL5a3e19ec848b9', 'Moulana College, Kuttayi, Tirur', 1, NULL, NULL, NULL),
('COL5a3e19ec8cb63', 'M.P.M.M.S.N Trusts College, Shoranur', 1, NULL, NULL, NULL),
('COL5a3e19ec94ea4', 'N.M.S.M. Govt. College Kalpetta', 1, NULL, NULL, NULL),
('COL5a3e19ec9d1e4', 'NSS College, Manjeri, Malappuram-676 122', 1, NULL, NULL, NULL),
('COL5a3e19eca5528', 'NSS College, Nenmara, Palakkad', 1, NULL, NULL, NULL),
('COL5a3e19ecad841', 'P.S.M.O. College, P.B. No. 2, Tirurangadi, Malappuram', 1, NULL, NULL, NULL),
('COL5a3e19ecb5b0d', 'Pookoya Thangal Memorial Government Arts and Science College, Perinthalmanna', 1, NULL, NULL, NULL),
('COL5a3e19ecbde7c', 'St. Aloysius College, Thrissur', 1, NULL, NULL, NULL),
('COL5a3e19ecc6165', 'St Joseph\'s College, Devagiri, Calicut', 1, NULL, NULL, NULL),
('COL5a3e19ecce7d5', 'St Mary\'s College, Sulthan Bathery', 1, NULL, NULL, NULL),
('COL5a3e19ecd67a6', 'St. Thomas College, Thrissur', 1, NULL, NULL, NULL),
('COL5a3e19ecdea64', 'Sahya Arts and Science College, Wandoor, Malappuram', 1, NULL, NULL, NULL),
('COL5a3e19ece6dbf', 'Silver Arts And Science College Perambra Kozhikode', 1, NULL, NULL, NULL),
('COL5a3e19ecef0c5', 'Sree Gokulam Arts & Science College, Balussery', 1, NULL, NULL, NULL),
('COL5a3e19ed0319b', 'Sree Kerala Varma College, Thrissur', 1, NULL, NULL, NULL),
('COL5a3e19ed0b42e', 'Sree Narayana College, Nattika', 1, NULL, NULL, NULL),
('COL5a3e19ed137cd', 'Sree Narayana Guru College of Advanced Studies, Nattika', 1, NULL, NULL, NULL),
('COL5a3e19ed1ba65', 'Sullamussalam Science College, Areekode', 1, NULL, NULL, NULL),
('COL5a3e19ed2456a', 'V V College of Science and Technology Kanjikode, Palakkad', 1, NULL, NULL, NULL),
('COL5a3e19ed2f424', 'Yuvakshetra Institute of Management Studies (YIMS), Ezhakkad, Mundur, Palakkad', 1, NULL, NULL, NULL),
('COL5a3e19ed3a251', 'Zamorin\'s Guruvayurappan College, Kozhikode-14', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_data`
--

DROP TABLE IF EXISTS `tbl_data`;
CREATE TABLE `tbl_data` (
  `dataId` int(11) NOT NULL,
  `userId` varchar(30) NOT NULL,
  `userEmail` varchar(200) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `collegeId` varchar(20) NOT NULL,
  `phoneNumber` varchar(13) NOT NULL,
  `spotVerified` tinyint(1) NOT NULL DEFAULT '0',
  `EVNT01` enum('SET','UNSET','DONE') DEFAULT 'UNSET',
  `groupIdEVNT01` varchar(20) DEFAULT NULL,
  `EVNT02` enum('SET','UNSET','DONE') DEFAULT 'UNSET',
  `groupIdEVNT02` varchar(20) DEFAULT NULL,
  `EVNT03` enum('SET','UNSET','DONE') DEFAULT 'UNSET',
  `groupIdEVNT03` varchar(20) DEFAULT NULL,
  `EVNT04` enum('SET','UNSET','DONE') DEFAULT 'UNSET',
  `groupIdEVNT04` varchar(20) DEFAULT NULL,
  `EVNT05` enum('SET','UNSET','DONE') DEFAULT 'UNSET',
  `groupIdEVNT05` varchar(20) DEFAULT NULL,
  `EVNT06` enum('SET','UNSET','DONE') DEFAULT 'UNSET',
  `groupIdEVNT06` varchar(20) DEFAULT NULL,
  `EVNT07` enum('SET','UNSET','DONE') DEFAULT 'UNSET',
  `groupIdEVNT07` varchar(20) DEFAULT NULL,
  `EVNT08` enum('SET','UNSET','DONE') DEFAULT 'UNSET',
  `groupIdEVNT08` varchar(20) DEFAULT NULL,
  `extra` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

DROP TABLE IF EXISTS `tbl_events`;
CREATE TABLE `tbl_events` (
  `eventId` varchar(10) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '1',
  `groupEvent` tinyint(1) NOT NULL DEFAULT '0',
  `hasStarted` tinyint(1) NOT NULL DEFAULT '0',
  `hasCompleted` tinyint(1) NOT NULL DEFAULT '0',
  `eventName` varchar(150) NOT NULL,
  `eventDesc` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`eventId`, `verified`, `groupEvent`, `hasStarted`, `hasCompleted`, `eventName`, `eventDesc`) VALUES
('EVNT01', 1, 5, 0, 0, 'BAKER STREET', 'It is a team event <br/> Upto 5 participants are allowed'),
('EVNT02', 1, 1, 0, 0, 'ILLUMINATI', 'It is a solo event.<br /> Every thing else is _ _ _ _'),
('EVNT03', 1, 2, 0, 0, 'SANS-LEXICO', 'It is a team event <br/> Upto 2 participants are allowed'),
('EVNT04', 1, 1, 0, 0, 'KALOPSIA', 'It is a solo event<br />Photography contest'),
('EVNT05', 1, 2, 0, 0, 'TECHNOCRATI', 'It is a team event <br/> Upto 2 participants are allowed'),
('EVNT06', 1, 1, 0, 0, 'VELO-C-DAD', 'It is a solo event<br />Network Gaming'),
('EVNT07', 1, 2, 0, 0, 'CRYP-TRICKS', 'It is a team event.<br /> upto 2 participants are allowed'),
('EVNT08', 1, 1, 0, 0, 'DIGISTHRA', 'It is a solo event<br />Promo video contest');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_results`
--

DROP TABLE IF EXISTS `tbl_results`;
CREATE TABLE `tbl_results` (
  `eventId` varchar(10) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '1',
  `winner` varchar(200) DEFAULT NULL,
  `runnerUp` varchar(200) DEFAULT NULL,
  `runnerUp2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_colleges`
--
ALTER TABLE `tbl_colleges`
  ADD PRIMARY KEY (`collegeId`);

--
-- Indexes for table `tbl_data`
--
ALTER TABLE `tbl_data`
  ADD PRIMARY KEY (`dataId`),
  ADD UNIQUE KEY `userId` (`userId`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `tbl_results`
--
ALTER TABLE `tbl_results`
  ADD PRIMARY KEY (`eventId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_data`
--
ALTER TABLE `tbl_data`
  MODIFY `dataId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
