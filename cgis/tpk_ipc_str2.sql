-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.1.10-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for cgis
CREATE DATABASE IF NOT EXISTS `cgis` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;
USE `cgis`;


-- Dumping structure for table cgis.hist_lic_hdr
CREATE TABLE IF NOT EXISTS `hist_lic_hdr` (
  `ID_IJIN` int(20) DEFAULT NULL,
  `NO_IJIN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_AWAL` date DEFAULT NULL,
  `TGL_IJIN` date DEFAULT NULL,
  `TGL_AKHIR` date DEFAULT NULL,
  `KETERANGAN` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `NPWP` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_TRADER` varchar(200) COLLATE latin1_general_cs DEFAULT NULL,
  `ALM_TRADER` varchar(500) COLLATE latin1_general_cs DEFAULT NULL,
  `ID_GA` char(2) COLLATE latin1_general_cs DEFAULT NULL,
  `WKPROSES` datetime DEFAULT NULL,
  `KD_IJIN` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `KODE_STATUS` varchar(3) COLLATE latin1_general_cs DEFAULT NULL,
  `JNS_IJIN` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `USED_BY_CAR` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `JNS_REKAM` varchar(1) COLLATE latin1_general_cs DEFAULT NULL,
  `REKAM_BY` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `WK_REKAM` datetime DEFAULT NULL,
  `UPD_BY` varchar(250) COLLATE latin1_general_cs DEFAULT NULL,
  `UPD_DATE` datetime DEFAULT NULL,
  `FL_DATA` varchar(1) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.hist_ppk_dtl
CREATE TABLE IF NOT EXISTS `hist_ppk_dtl` (
  `ID_IJIN` int(20) NOT NULL,
  `NOSERI` int(20) NOT NULL,
  `NO_HS` varchar(12) COLLATE latin1_general_cs DEFAULT NULL,
  `UR_BRG` varchar(140) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_SAT` varchar(3) COLLATE latin1_general_cs DEFAULT NULL,
  `JM_SAT` float DEFAULT NULL,
  `DTL_NETTO` float DEFAULT NULL,
  `SPP` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_LATIN` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `HISTORY_BY` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `HISTORY_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.log_job
CREATE TABLE IF NOT EXISTS `log_job` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `TIPE_JOB` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `NAMA_JOB` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `SQL_CODE` text COLLATE latin1_general_cs,
  `SQL_ERRM` text COLLATE latin1_general_cs,
  `STATUS` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `KETERANGAN` text COLLATE latin1_general_cs,
  `WK_REKAM` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.log_services
CREATE TABLE IF NOT EXISTS `log_services` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `METHOD` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `USERNAME` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `XML_REQUEST` text COLLATE latin1_general_cs,
  `XML_RESPONSE` text COLLATE latin1_general_cs,
  `REQUEST_FILENAME` varchar(4000) COLLATE latin1_general_cs DEFAULT NULL,
  `RESPONSE_FILENAME` varchar(4000) COLLATE latin1_general_cs DEFAULT NULL,
  `IPADDRESS` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `REMARKS` varchar(4000) COLLATE latin1_general_cs DEFAULT NULL,
  `WK_REKAM` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `METHOD` (`METHOD`),
  KEY `WK_REKAM` (`WK_REKAM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_dokumen
CREATE TABLE IF NOT EXISTS `reff_dokumen` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_dokumen_bc
CREATE TABLE IF NOT EXISTS `reff_dokumen_bc` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_ga
CREATE TABLE IF NOT EXISTS `reff_ga` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_group
CREATE TABLE IF NOT EXISTS `reff_group` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_group_menu
CREATE TABLE IF NOT EXISTS `reff_group_menu` (
  `KD_GROUP` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_MENU` int(20) NOT NULL,
  `HAK_AKSES` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT 'R',
  PRIMARY KEY (`KD_GROUP`,`KD_MENU`),
  KEY `FK_reff_group_menu_reff_menu` (`KD_MENU`),
  CONSTRAINT `FK_reff_group_menu_reff_group` FOREIGN KEY (`KD_GROUP`) REFERENCES `reff_group` (`ID`),
  CONSTRAINT `FK_reff_group_menu_reff_menu` FOREIGN KEY (`KD_MENU`) REFERENCES `reff_menu` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_gudang
CREATE TABLE IF NOT EXISTS `reff_gudang` (
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA_GUDANG` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `LINI` varchar(1) COLLATE latin1_general_cs DEFAULT '2',
  `FL_AKTIF` enum('Y','N') COLLATE latin1_general_cs DEFAULT 'N',
  PRIMARY KEY (`KD_TPS`,`KD_GUDANG`),
  CONSTRAINT `FK_reff_gudang_reff_tps` FOREIGN KEY (`KD_TPS`) REFERENCES `reff_tps` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_jenis_ijin
CREATE TABLE IF NOT EXISTS `reff_jenis_ijin` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_kapal
CREATE TABLE IF NOT EXISTS `reff_kapal` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_KAPAL` varchar(25) COLLATE latin1_general_cs NOT NULL,
  `NM_KAPAL` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `CALL_SIGN` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `WK_REKAM` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_reff_kapal_reff_gudang` (`KD_TPS`,`KD_GUDANG`),
  CONSTRAINT `FK_reff_kapal_reff_gudang` FOREIGN KEY (`KD_TPS`, `KD_GUDANG`) REFERENCES `reff_gudang` (`KD_TPS`, `KD_GUDANG`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_kemasan
CREATE TABLE IF NOT EXISTS `reff_kemasan` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_kode_dok_bc
CREATE TABLE IF NOT EXISTS `reff_kode_dok_bc` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL COMMENT 'KODE DOKUMEN BC ',
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL COMMENT 'NAMA DOKUMEN BC',
  `KD_PERMIT` enum('IMP','EXP') COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_log
CREATE TABLE IF NOT EXISTS `reff_log` (
  `ID` int(18) NOT NULL AUTO_INCREMENT COMMENT 'AUTO INCREMENT',
  `KD_USER` int(18) NOT NULL COMMENT 'FK APP_USER',
  `DESKRIPSI` text COLLATE latin1_general_ci NOT NULL COMMENT 'DESKRIPSI',
  `WK_REKAM` datetime NOT NULL COMMENT 'WAKTU REKAM NOW()',
  PRIMARY KEY (`ID`),
  KEY `FK_KD_USER` (`KD_USER`),
  CONSTRAINT `FK_KD_USER` FOREIGN KEY (`KD_USER`) REFERENCES `reff_user` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_menu
CREATE TABLE IF NOT EXISTS `reff_menu` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `ID_PARENT` int(20) DEFAULT NULL,
  `JUDUL_MENU` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `URL` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `URUTAN` int(20) NOT NULL,
  `TIPE` enum('F','M') CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `TARGET` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL DEFAULT '_SELF',
  `ACTION` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL DEFAULT 'ONHREF',
  `CLS_ICON` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_reff_menu_reff_menu` (`ID_PARENT`),
  CONSTRAINT `FK_reff_menu_reff_menu` FOREIGN KEY (`ID_PARENT`) REFERENCES `reff_menu` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_negara
CREATE TABLE IF NOT EXISTS `reff_negara` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_pelabuhan
CREATE TABLE IF NOT EXISTS `reff_pelabuhan` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_relokasi
CREATE TABLE IF NOT EXISTS `reff_relokasi` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_satuan
CREATE TABLE IF NOT EXISTS `reff_satuan` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_status_cont
CREATE TABLE IF NOT EXISTS `reff_status_cont` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `URUTAN` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_status_ijin
CREATE TABLE IF NOT EXISTS `reff_status_ijin` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_status_relokasi
CREATE TABLE IF NOT EXISTS `reff_status_relokasi` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_tipe_cont
CREATE TABLE IF NOT EXISTS `reff_tipe_cont` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_tps
CREATE TABLE IF NOT EXISTS `reff_tps` (
  `ID` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_user
CREATE TABLE IF NOT EXISTS `reff_user` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `USER_NAME` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `PASS` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `NAMA` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `NOTELP` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `EMAIL` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GA` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GROUP` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS` enum('ACTIVE','INACTIVE','BLOCKED') COLLATE latin1_general_cs DEFAULT NULL,
  `PATH` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `LAST_LOGIN` datetime DEFAULT NULL,
  `WK_REKAM` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_reff_user_reff_ga` (`KD_GA`),
  KEY `FK_reff_user_reff_gudang` (`KD_TPS`,`KD_GUDANG`),
  KEY `FK_reff_user_reff_group` (`KD_GROUP`),
  CONSTRAINT `FK_reff_user_reff_ga` FOREIGN KEY (`KD_GA`) REFERENCES `reff_ga` (`ID`),
  CONSTRAINT `FK_reff_user_reff_group` FOREIGN KEY (`KD_GROUP`) REFERENCES `reff_group` (`ID`),
  CONSTRAINT `FK_reff_user_reff_gudang` FOREIGN KEY (`KD_TPS`, `KD_GUDANG`) REFERENCES `reff_gudang` (`KD_TPS`, `KD_GUDANG`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_user_menu
CREATE TABLE IF NOT EXISTS `reff_user_menu` (
  `KD_USER` int(18) NOT NULL COMMENT 'KODE USER FK APP_USER',
  `KD_MENU` int(18) NOT NULL COMMENT 'KODE MENU FK APP_MENU',
  `HAK_AKSES` enum('R','W') COLLATE latin1_general_ci NOT NULL DEFAULT 'R' COMMENT 'HAK AKSES R=>READ, W=>WRITE',
  PRIMARY KEY (`KD_USER`,`KD_MENU`),
  KEY `FK_app_user_menu_app_menu` (`KD_MENU`),
  CONSTRAINT `FK_reff_user_menu_app_menu` FOREIGN KEY (`KD_MENU`) REFERENCES `reff_menu` (`ID`),
  CONSTRAINT `FK_reff_user_menu_app_user` FOREIGN KEY (`KD_USER`) REFERENCES `reff_user` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.reff_user_ws
CREATE TABLE IF NOT EXISTS `reff_user_ws` (
  `USER_NAME` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `PASS` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `KD_GA` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`USER_NAME`),
  KEY `FK_reff_user_ws_reff_ga` (`KD_GA`),
  KEY `FK_reff_user_ws_reff_gudang` (`KD_TPS`,`KD_GUDANG`),
  CONSTRAINT `FK_reff_user_ws_reff_ga` FOREIGN KEY (`KD_GA`) REFERENCES `reff_ga` (`ID`),
  CONSTRAINT `FK_reff_user_ws_reff_gudang` FOREIGN KEY (`KD_TPS`, `KD_GUDANG`) REFERENCES `reff_gudang` (`KD_TPS`, `KD_GUDANG`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_cocostscont
CREATE TABLE IF NOT EXISTS `t_cocostscont` (
  `ID` int(18) NOT NULL,
  `NO_CONT` varchar(11) COLLATE latin1_general_cs NOT NULL,
  `UK_CONT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `JNS_CONT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `ISO_CODE` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `TEMPERATURE` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_CONT_TIPE` varchar(10) COLLATE latin1_general_cs DEFAULT 'DRY',
  `BRUTO` int(18) DEFAULT NULL,
  `NO_SEGEL` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_BL_AWB` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_BL_AWB` date DEFAULT NULL,
  `NO_MASTER_BL_AWB` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_MASTER_BL_AWB` date DEFAULT NULL,
  `NO_BC11` varchar(12) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_BC11` date DEFAULT NULL,
  `NO_POS_BC11` varchar(12) COLLATE latin1_general_cs DEFAULT NULL,
  `ID_CONSIGNEE` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `CONSIGNEE` varchar(500) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TIMBUN` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `PEL_MUAT` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `PEL_TRANSIT` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `PEL_BONGKAR` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_DOK_IN` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_DOK_IN` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DOK_IN` date DEFAULT NULL,
  `WK_IN` datetime DEFAULT NULL,
  `FL_CONT_KOSONG_IN` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_SARANA_ANGKUT_IN` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_POL_IN` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `GUDANG_TUJUAN_IN` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_DAFTAR_PABEAN_IN` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DAFTAR_PABEAN_IN` date DEFAULT NULL,
  `NO_SEGEL_BC_IN` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_SEGEL_BC_IN` date DEFAULT NULL,
  `NO_IJIN_TPS_IN` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_IJIN_TPS_IN` date DEFAULT NULL,
  `KODE_KANTOR_IN` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_DOK_OUT` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_DOK_OUT` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DOK_OUT` date DEFAULT NULL,
  `WK_OUT` datetime DEFAULT NULL,
  `FL_CONT_KOSONG_OUT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_SARANA_ANGKUT_OUT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_POL_OUT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `GUDANG_TUJUAN_OUT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_DAFTAR_PABEAN_OUT` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DAFTAR_PABEAN_OUT` date DEFAULT NULL,
  `NO_SEGEL_BC_OUT` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_SEGEL_BC_OUT` date DEFAULT NULL,
  `NO_IJIN_TPS_OUT` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_IJIN_TPS_OUT` date DEFAULT NULL,
  `KODE_KANTOR_OUT` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `WK_REKAM` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`,`NO_CONT`),
  KEY `NO_CONT` (`NO_CONT`),
  CONSTRAINT `FK_t_cocostscont_t_cocostshdr` FOREIGN KEY (`ID`) REFERENCES `t_cocostshdr` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_cocostshdr
CREATE TABLE IF NOT EXISTS `t_cocostshdr` (
  `ID` int(18) NOT NULL AUTO_INCREMENT,
  `KD_ASAL_BRG` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_ANGKUT` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_VOY_FLIGHT` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_TIBA` date DEFAULT NULL,
  `WK_REKAM` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_codeco
CREATE TABLE IF NOT EXISTS `t_codeco` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `ID_IJIN_PERMOHONAN` int(20) NOT NULL,
  `ID_IJIN_PENYELESAIAN` int(20) DEFAULT NULL,
  `NO_CONT` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `KD_TPS` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_KAPAL` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_KAPAL` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_VOYAGE` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `CALL_SIGN` varchar(8) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TIMBUN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG_PERIKSA` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS_CONT` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_ON_VESSEL` datetime DEFAULT NULL,
  `TGL_NOT_FOUND` datetime DEFAULT NULL,
  `TGL_DISCHARGE` datetime DEFAULT NULL,
  `TGL_STACKING` datetime DEFAULT NULL,
  `TGL_IN_POSITION` datetime DEFAULT NULL,
  `TGL_PERIKSA` date DEFAULT NULL,
  `TGL_TIBA_PEMERIKSA` datetime DEFAULT NULL,
  `TGL_MULAI_PERIKSA` datetime DEFAULT NULL,
  `TGL_SELESAI_PERIKSA` datetime DEFAULT NULL,
  `NO_PIB` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_PIB` date DEFAULT NULL,
  `WK_PIB` datetime DEFAULT NULL,
  `KD_DOK_INOUT` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_DOK_INOUT` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DOK_INOUT` date DEFAULT NULL,
  `WK_DOK_INOUT` datetime DEFAULT NULL,
  `TGL_GATE_IN` datetime DEFAULT NULL,
  `TGL_GATE_OUT` datetime DEFAULT NULL,
  `WK_REKAM` datetime DEFAULT NULL,
  `FL_DISCHARGE` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `DISCHARGE_SENT` datetime DEFAULT NULL,
  `FL_STACKING` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `STACKING_SENT` datetime DEFAULT NULL,
  `FL_GATEIN` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `GATEIN_SENT` datetime DEFAULT NULL,
  `FL_GATEOUT` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `GATEOUT_SENT` datetime DEFAULT NULL,
  `FL_ON_VESSEL` varchar(1) COLLATE latin1_general_cs DEFAULT '0',
  `ON_VESSEL_SENT` datetime DEFAULT NULL,
  `FL_IN_POSITION` varchar(1) COLLATE latin1_general_cs DEFAULT '0',
  `IN_POSITION_SENT` datetime DEFAULT NULL,
  `FL_NOT_FOUND` varchar(1) COLLATE latin1_general_cs DEFAULT '0',
  `NOT_FOUND_SENT` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_t_codeco_t_lic_hdr` (`ID_IJIN_PERMOHONAN`),
  KEY `FK_t_codeco_t_lic_hdr_2` (`ID_IJIN_PENYELESAIAN`),
  KEY `FK_t_codeco_reff_dokumen_bc` (`KD_DOK_INOUT`),
  CONSTRAINT `t_codeco_ibfk_1` FOREIGN KEY (`KD_DOK_INOUT`) REFERENCES `reff_dokumen_bc` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_codecopermit
CREATE TABLE IF NOT EXISTS `t_codecopermit` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `ID_IJIN_PERMOHONAN` int(20) NOT NULL,
  `ID_IJIN_PENYELESAIAN` int(20) DEFAULT NULL,
  `NO_CONT` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `KD_TPS` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_KAPAL` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_KAPAL` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_VOYAGE` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `CALL_SIGN` varchar(8) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TIMBUN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG_PERIKSA` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS_CONT` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_ON_VESSEL` datetime DEFAULT NULL,
  `TGL_NOT_FOUND` datetime DEFAULT NULL,
  `TGL_DISCHARGE` datetime DEFAULT NULL,
  `TGL_STACKING` datetime DEFAULT NULL,
  `TGL_IN_POSITION` datetime DEFAULT NULL,
  `TGL_PERIKSA` date DEFAULT NULL,
  `TGL_TIBA_PEMERIKSA` datetime DEFAULT NULL,
  `TGL_MULAI_PERIKSA` datetime DEFAULT NULL,
  `TGL_SELESAI_PERIKSA` datetime DEFAULT NULL,
  `NO_PIB` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_PIB` date DEFAULT NULL,
  `WK_PIB` datetime DEFAULT NULL,
  `KD_DOK_INOUT` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_DOK_INOUT` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DOK_INOUT` date DEFAULT NULL,
  `WK_DOK_INOUT` datetime DEFAULT NULL,
  `TGL_GATE_IN` datetime DEFAULT NULL,
  `TGL_GATE_OUT` datetime DEFAULT NULL,
  `WK_REKAM` datetime DEFAULT NULL,
  `FL_DISCHARGE` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `DISCHARGE_SENT` datetime DEFAULT NULL,
  `FL_STACKING` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `STACKING_SENT` datetime DEFAULT NULL,
  `FL_GATEIN` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `GATEIN_SENT` datetime DEFAULT NULL,
  `FL_GATEOUT` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `GATEOUT_SENT` datetime DEFAULT NULL,
  `FL_ON_VESSEL` varchar(1) COLLATE latin1_general_cs DEFAULT '0',
  `ON_VESSEL_SENT` datetime DEFAULT NULL,
  `FL_IN_POSITION` varchar(1) COLLATE latin1_general_cs DEFAULT '0',
  `IN_POSITION_SENT` datetime DEFAULT NULL,
  `FL_NOT_FOUND` varchar(1) COLLATE latin1_general_cs DEFAULT '0',
  `NOT_FOUND_SENT` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_t_codeco_t_lic_hdr` (`ID_IJIN_PERMOHONAN`),
  KEY `FK_t_codeco_t_lic_hdr_2` (`ID_IJIN_PENYELESAIAN`),
  KEY `FK_t_codeco_reff_dokumen_bc` (`KD_DOK_INOUT`),
  CONSTRAINT `t_codecopermit_ibfk_1` FOREIGN KEY (`KD_DOK_INOUT`) REFERENCES `reff_dokumen_bc` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_codeco_kms
CREATE TABLE IF NOT EXISTS `t_codeco_kms` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `ID_IJIN_PERMOHONAN` int(20) NOT NULL,
  `ID_IJIN_PENYELESAIAN` int(20) DEFAULT NULL,
  `KD_KMS` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `KD_TPS` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_KAPAL` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_KAPAL` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_VOYAGE` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `CALL_SIGN` varchar(8) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TIMBUN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DISCHARGE` datetime DEFAULT NULL,
  `TGL_STACKING` datetime DEFAULT NULL,
  `TGL_PERIKSA` date DEFAULT NULL,
  `TGL_TIBA_PEMERIKSA` datetime DEFAULT NULL,
  `TGL_MULAI_PERIKSA` datetime DEFAULT NULL,
  `TGL_SELESAI_PERIKSA` datetime DEFAULT NULL,
  `NO_PIB` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_PIB` date DEFAULT NULL,
  `WK_PIB` datetime DEFAULT NULL,
  `KD_DOK_INOUT` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_DOK_INOUT` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DOK_INOUT` date DEFAULT NULL,
  `WK_DOK_INOUT` datetime DEFAULT NULL,
  `TGL_GATE_IN` datetime DEFAULT NULL,
  `TGL_GATE_OUT` datetime DEFAULT NULL,
  `WK_REKAM` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_t_codeco_kms_reff_dokumen_bc` (`KD_DOK_INOUT`),
  CONSTRAINT `FK_t_codeco_kms_reff_dokumen_bc` FOREIGN KEY (`KD_DOK_INOUT`) REFERENCES `reff_dokumen_bc` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_error
CREATE TABLE IF NOT EXISTS `t_error` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ERROR` text COLLATE latin1_general_cs,
  `CLASS` text COLLATE latin1_general_cs,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_jadwal_kapal
CREATE TABLE IF NOT EXISTS `t_jadwal_kapal` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `KD_TPS` varchar(4) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(6) COLLATE latin1_general_cs NOT NULL,
  `KD_KAPAL` varchar(25) COLLATE latin1_general_cs NOT NULL,
  `NM_KAPAL` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `NO_VOYAGE` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `CALL_SIGN` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `TGL_TIBA` datetime NOT NULL,
  `TGL_SANDAR` datetime DEFAULT NULL,
  `WK_REKAM` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_lic_hdr
CREATE TABLE IF NOT EXISTS `t_lic_hdr` (
  `ID_IJIN` int(20) NOT NULL AUTO_INCREMENT,
  `ID_IJIN_INSPEKSI` int(20) DEFAULT NULL,
  `JENIS_DOK` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_IJIN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_AWAL` date DEFAULT NULL,
  `TGL_IJIN` date DEFAULT NULL,
  `TGL_AKHIR` date DEFAULT NULL,
  `KETERANGAN` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `NPWP` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_TRADER` varchar(200) COLLATE latin1_general_cs DEFAULT NULL,
  `ALM_TRADER` varchar(300) COLLATE latin1_general_cs DEFAULT NULL,
  `ID_GA` char(2) COLLATE latin1_general_cs DEFAULT NULL,
  `WKPROSES` datetime DEFAULT NULL,
  `KD_IJIN` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `KODE_STATUS` varchar(3) COLLATE latin1_general_cs NOT NULL DEFAULT '001',
  `JNS_IJIN` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `USED_BY_CAR` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `JNS_REKAM` varchar(1) COLLATE latin1_general_cs DEFAULT '1',
  `REKAM_BY` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `WK_REKAM` datetime NOT NULL,
  `UPD_BY` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `UPD_DATE` datetime DEFAULT NULL,
  `FL_BAPLIE` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `BAPLIE_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_IJIN`),
  KEY `ID_GA` (`ID_GA`),
  KEY `ID_IJIN_INSPEKSI` (`ID_IJIN_INSPEKSI`),
  KEY `ID_IJIN` (`ID_IJIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_lic_hdr_baplie
CREATE TABLE IF NOT EXISTS `t_lic_hdr_baplie` (
  `ID_IJIN` int(20) NOT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `FL_BAPLIE` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `BAPLIE_DATE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_lokasi_timbun
CREATE TABLE IF NOT EXISTS `t_lokasi_timbun` (
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `BLOK` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `KD_STATUS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  KEY `FK_t_lokasi_timbun_reff_gudang` (`KD_TPS`,`KD_GUDANG`),
  KEY `FK_t_lokasi_timbun_reff_status_cont` (`KD_STATUS`),
  CONSTRAINT `t_lokasi_timbun_ibfk_1` FOREIGN KEY (`KD_TPS`, `KD_GUDANG`) REFERENCES `reff_gudang` (`KD_TPS`, `KD_GUDANG`),
  CONSTRAINT `t_lokasi_timbun_ibfk_2` FOREIGN KEY (`KD_STATUS`) REFERENCES `reff_status_cont` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_permit_cont
CREATE TABLE IF NOT EXISTS `t_permit_cont` (
  `ID` int(18) NOT NULL,
  `NO_CONT` varchar(11) COLLATE latin1_general_cs NOT NULL,
  `KD_CONT_UKURAN` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_CONT_JENIS` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `ISO_CODE` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `TIPE_CONT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TIMBUN` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG_PERIKSA` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `IMO_CODE` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS_CONT` varchar(10) COLLATE latin1_general_cs DEFAULT 'ND',
  `KD_STATUS` varchar(10) COLLATE latin1_general_cs DEFAULT '0',
  `TGL_STATUS` datetime DEFAULT NULL,
  `FL_RELOCATION` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_RELOCATION` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`,`NO_CONT`),
  KEY `ID_NO_CONT` (`ID`,`NO_CONT`),
  CONSTRAINT `FK_t_permit_cont_t_permit_hdr` FOREIGN KEY (`ID`) REFERENCES `t_permit_hdr` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_permit_cont_relocation
CREATE TABLE IF NOT EXISTS `t_permit_cont_relocation` (
  `ID` int(20) NOT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `FL_RELOCATION` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_RELOCATION` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_permit_cont_status
CREATE TABLE IF NOT EXISTS `t_permit_cont_status` (
  `ID` int(20) NOT NULL,
  `NO_CONT` varchar(17) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG_PERIKSA` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TIMBUN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS_CONT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_STATUS` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `TGL_STATUS` datetime NOT NULL,
  `FL_SEND` enum('Y','N') COLLATE latin1_general_cs DEFAULT 'N',
  `TGL_SEND` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_permit_dok
CREATE TABLE IF NOT EXISTS `t_permit_dok` (
  `ID` int(18) NOT NULL,
  `JNS_DOK` varchar(11) COLLATE latin1_general_cs NOT NULL,
  `NO_DOK` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `TGL_DOK` date DEFAULT NULL,
  PRIMARY KEY (`ID`,`JNS_DOK`,`NO_DOK`),
  KEY `ID_JNS_DOK_NO_DOK` (`ID`,`JNS_DOK`,`NO_DOK`),
  CONSTRAINT `FK_t_permit_dok_t_permit_hdr` FOREIGN KEY (`ID`) REFERENCES `t_permit_hdr` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_permit_hdr
CREATE TABLE IF NOT EXISTS `t_permit_hdr` (
  `ID` int(18) NOT NULL AUTO_INCREMENT,
  `CAR` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_KANTOR` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_DOK_INOUT` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `NO_DOK_INOUT` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DOK_INOUT` date DEFAULT NULL,
  `NO_DAFTAR_PABEAN` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_DAFTAR_PABEAN` date DEFAULT NULL,
  `ID_CONSIGNEE` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `CONSIGNEE` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `ALAMAT_CONSIGNEE` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `NPWP_PPJK` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `NAMA_PPJK` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `ALAMAT_PPJK` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_ANGKUT` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_VOY_FLIGHT` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `JML_CONT` int(18) DEFAULT NULL,
  `BRUTO` float DEFAULT NULL,
  `NETTO` float DEFAULT NULL,
  `NO_BC11` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_BC11` date DEFAULT NULL,
  `NO_POS_BC11` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_BL_AWB` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_BL_AWB` date DEFAULT NULL,
  `NO_MASTER_BL_AWB` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_MASTER_BL_AWB` date DEFAULT NULL,
  `KD_KANTOR_PENGAWAS` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_KANTOR_BONGKAR` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `FL_SEGEL` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS_JALUR` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `FL_KARANTINA` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_STATUS` varchar(10) COLLATE latin1_general_cs NOT NULL DEFAULT '100',
  `TGL_STATUS` datetime NOT NULL,
  `FL_BAPLIE` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `BAPLIE_DATE` datetime DEFAULT NULL,
  `ANGKUTKODE_TPS` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `ANGKUTNAMA_TPS` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `ANGKUTNO_TPS` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `TMP_TIMBUN_TPS` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_CAR` (`ID`,`CAR`),
  KEY `FK_t_permit_hdr_reff_kode_dok_bc` (`KD_DOK_INOUT`),
  CONSTRAINT `FK_t_permit_hdr_reff_kode_dok_bc` FOREIGN KEY (`KD_DOK_INOUT`) REFERENCES `reff_kode_dok_bc` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_permit_hdr_baplie
CREATE TABLE IF NOT EXISTS `t_permit_hdr_baplie` (
  `ID` int(20) NOT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `FL_BAPLIE` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `BAPLIE_DATE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_permit_kms
CREATE TABLE IF NOT EXISTS `t_permit_kms` (
  `ID` int(18) NOT NULL,
  `JNS_KMS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `MERK_KMS` text COLLATE latin1_general_cs,
  `JML_KMS` int(18) NOT NULL,
  PRIMARY KEY (`ID`,`JNS_KMS`,`JML_KMS`),
  KEY `ID_JNS_KMS_JML_KMS` (`ID`,`JNS_KMS`,`JML_KMS`),
  CONSTRAINT `FK_t_permit_kms_t_permit_hdr` FOREIGN KEY (`ID`) REFERENCES `t_permit_hdr` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_permit_sent
CREATE TABLE IF NOT EXISTS `t_permit_sent` (
  `ID` int(20) NOT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `FL_SENT` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_SENT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_cont
CREATE TABLE IF NOT EXISTS `t_ppk_cont` (
  `ID_IJIN` int(20) NOT NULL,
  `NO_CONT` varchar(17) COLLATE latin1_general_cs NOT NULL,
  `SEGEL` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `UKURAN` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `ISO_CODE` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `TIPE_CONT` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `IMO_CODE` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_TPFT` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_TPFT` date DEFAULT NULL,
  `KD_GUDANG` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG_PERIKSA` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TIMBUN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS_CONT` varchar(10) COLLATE latin1_general_cs DEFAULT 'ND',
  `STATUS_RELOKASI` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_STATUS` varchar(20) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_STATUS` datetime NOT NULL,
  `FL_RELOCATION` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_RELOCATION` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_IJIN`,`NO_CONT`),
  KEY `FK_t_ppk_cont_reff_status_cont` (`KD_STATUS`),
  KEY `FK_t_ppk_cont_reff_relokasi` (`STATUS_CONT`),
  KEY `ID_IJIN_NO_CONT` (`ID_IJIN`,`NO_CONT`),
  KEY `FK_t_ppk_cont_reff_status_relokasi` (`STATUS_RELOKASI`),
  CONSTRAINT `FK_t_ppk_cont_reff_relokasi` FOREIGN KEY (`STATUS_CONT`) REFERENCES `reff_relokasi` (`ID`),
  CONSTRAINT `FK_t_ppk_cont_reff_status_cont` FOREIGN KEY (`KD_STATUS`) REFERENCES `reff_status_cont` (`ID`),
  CONSTRAINT `FK_t_ppk_cont_reff_status_relokasi` FOREIGN KEY (`STATUS_RELOKASI`) REFERENCES `reff_status_relokasi` (`ID`),
  CONSTRAINT `FK_t_ppk_cont_t_ppk_hdr` FOREIGN KEY (`ID_IJIN`) REFERENCES `t_ppk_hdr` (`ID_IJIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_cont_relocation
CREATE TABLE IF NOT EXISTS `t_ppk_cont_relocation` (
  `ID_IJIN` int(20) NOT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `FL_RELOCATION` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_RELOCATION` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_cont_status
CREATE TABLE IF NOT EXISTS `t_ppk_cont_status` (
  `ID_IJIN` int(20) NOT NULL,
  `NO_CONT` varchar(17) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG_PERIKSA` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_TIMBUN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS_CONT` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `STATUS_RELOKASI` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_STATUS` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `TGL_STATUS` datetime NOT NULL,
  `FL_SEND` enum('Y','N') COLLATE latin1_general_cs DEFAULT 'N',
  `TGL_SEND` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_dok
CREATE TABLE IF NOT EXISTS `t_ppk_dok` (
  `ID_IJIN` int(20) NOT NULL,
  `KD_DOK` varchar(3) COLLATE latin1_general_cs NOT NULL,
  `NO_DOK` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `TG_DOK` date DEFAULT NULL,
  `NEG_DOK` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  KEY `FK_t_ppk_dok_t_ppk_hdr` (`ID_IJIN`),
  CONSTRAINT `FK_t_ppk_dok_t_ppk_hdr` FOREIGN KEY (`ID_IJIN`) REFERENCES `t_ppk_hdr` (`ID_IJIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_dtl
CREATE TABLE IF NOT EXISTS `t_ppk_dtl` (
  `ID_IJIN` int(20) NOT NULL,
  `NOSERI` int(20) NOT NULL,
  `NO_HS` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `UR_BRG` varchar(140) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_SAT` varchar(3) COLLATE latin1_general_cs DEFAULT NULL,
  `JM_SAT` float DEFAULT NULL,
  `DTL_NETTO` float DEFAULT NULL,
  `SPP` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_LATIN` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`ID_IJIN`,`NOSERI`),
  CONSTRAINT `FK_t_ppk_dtl_t_ppk_hdr` FOREIGN KEY (`ID_IJIN`) REFERENCES `t_ppk_hdr` (`ID_IJIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_hdr
CREATE TABLE IF NOT EXISTS `t_ppk_hdr` (
  `ID_IJIN` int(20) NOT NULL,
  `JN_RESPON` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_PARTNER` varchar(70) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_UPT` varchar(6) COLLATE latin1_general_cs DEFAULT NULL,
  `ALM_PARTNER` varchar(80) COLLATE latin1_general_cs DEFAULT NULL,
  `NEG_PARTNER` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `PEL_BKR` varchar(5) COLLATE latin1_general_cs DEFAULT NULL,
  `PEL_MUAT` varchar(5) COLLATE latin1_general_cs DEFAULT NULL,
  `TMP_TIMBUN` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `MODA` varchar(1) COLLATE latin1_general_cs DEFAULT NULL,
  `ANGKUTNAMA` varchar(17) COLLATE latin1_general_cs DEFAULT NULL,
  `ANGKUTNO` varchar(7) COLLATE latin1_general_cs DEFAULT NULL,
  `TG_TIBA` date DEFAULT NULL,
  `JM_CONT` int(11) DEFAULT NULL,
  `JM_BRG` int(11) DEFAULT NULL,
  `TUJ_MASUK` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `NO_RESPON` varchar(26) COLLATE latin1_general_cs DEFAULT NULL,
  `NEG_TUJU` varchar(2) COLLATE latin1_general_cs DEFAULT NULL,
  `DRH_TUJU` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `TG_RESPON` date DEFAULT NULL,
  `NO_DAFTPPK` varchar(26) COLLATE latin1_general_cs DEFAULT NULL,
  `TG_DAFTPPK` date DEFAULT NULL,
  `ISI_RESPON` varchar(140) COLLATE latin1_general_cs DEFAULT NULL,
  `NIP_JAB` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `NM_JAB` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `JAB` varchar(30) COLLATE latin1_general_cs DEFAULT NULL,
  `TMP_INSTALASI` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `ALM_INSTALASI` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `ANGKUTKODE_TPS` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `ANGKUTNAMA_TPS` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `ANGKUTNO_TPS` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `TMP_TIMBUN_TPS` varchar(4) COLLATE latin1_general_cs DEFAULT NULL,
  `UPDATE_BY` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `FL_SEND` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `DATE_SEND` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_IJIN`),
  CONSTRAINT `FK_t_ppk_hdr_t_lic_hdr` FOREIGN KEY (`ID_IJIN`) REFERENCES `t_lic_hdr` (`ID_IJIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_jadwal
CREATE TABLE IF NOT EXISTS `t_ppk_jadwal` (
  `ID_IJIN` int(20) NOT NULL,
  `TGL_PERIKSA` datetime DEFAULT NULL,
  `TGL_TIBA_PEMERIKSA` datetime DEFAULT NULL,
  `TGL_MULAI_PERIKSA` datetime DEFAULT NULL,
  `TGL_SELESAI_PERIKSA` datetime DEFAULT NULL,
  `WK_REKAM` datetime NOT NULL,
  PRIMARY KEY (`ID_IJIN`),
  CONSTRAINT `FK_t_ppk_jadwal_t_ppk_hdr` FOREIGN KEY (`ID_IJIN`) REFERENCES `t_ppk_hdr` (`ID_IJIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_kms
CREATE TABLE IF NOT EXISTS `t_ppk_kms` (
  `ID_IJIN` int(20) NOT NULL,
  `JN_KEMAS` varchar(2) COLLATE latin1_general_cs NOT NULL,
  `JM_KEMAS` int(11) DEFAULT NULL,
  `NO_TPFT` varchar(20) COLLATE latin1_general_cs DEFAULT NULL,
  `TGL_TPFT` date DEFAULT NULL,
  `KD_TIMBUN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_STATUS` varchar(20) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_STATUS` datetime NOT NULL,
  PRIMARY KEY (`ID_IJIN`,`JN_KEMAS`),
  KEY `FK_t_ppk_kms_reff_status_cont` (`KD_STATUS`),
  CONSTRAINT `FK_t_ppk_kms_reff_status_cont` FOREIGN KEY (`KD_STATUS`) REFERENCES `reff_status_cont` (`ID`),
  CONSTRAINT `FK_t_ppk_kms_t_ppk_hdr` FOREIGN KEY (`ID_IJIN`) REFERENCES `t_ppk_hdr` (`ID_IJIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_kms_status
CREATE TABLE IF NOT EXISTS `t_ppk_kms_status` (
  `ID_IJIN` int(20) NOT NULL,
  `JN_KEMAS` varchar(2) COLLATE latin1_general_cs NOT NULL,
  `KD_TIMBUN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_STATUS` varchar(20) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_STATUS` datetime NOT NULL,
  PRIMARY KEY (`ID_IJIN`,`JN_KEMAS`,`KD_STATUS`,`TGL_STATUS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_petugas
CREATE TABLE IF NOT EXISTS `t_ppk_petugas` (
  `ID_IJIN` int(20) NOT NULL,
  `NIP` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `NAMA` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `WK_REKAM` datetime NOT NULL,
  PRIMARY KEY (`ID_IJIN`,`NIP`),
  KEY `NIP` (`NIP`),
  CONSTRAINT `FK_t_ppk_petugas_t_ppk_hdr` FOREIGN KEY (`ID_IJIN`) REFERENCES `t_ppk_hdr` (`ID_IJIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_ppk_petugas_sent
CREATE TABLE IF NOT EXISTS `t_ppk_petugas_sent` (
  `ID_IJIN` int(20) NOT NULL,
  `KD_TPS` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `KD_GUDANG` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `FL_SENT` varchar(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `TGL_SENT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_relationship
CREATE TABLE IF NOT EXISTS `t_relationship` (
  `ID` int(18) NOT NULL AUTO_INCREMENT,
  `JNS_DOKUMEN` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG_SENDER` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `KD_GUDANG_RECEIVER` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `WK_REKAM` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- Data exporting was unselected.


-- Dumping structure for table cgis.t_session
CREATE TABLE IF NOT EXISTS `t_session` (
  `ID` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `IP_ADDRESS` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `TIMESTAMP` int(10) unsigned NOT NULL DEFAULT '0',
  `DATA` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`TIMESTAMP`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.


-- Dumping structure for function cgis.func_active
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `func_active`(`GET_ID` INT) RETURNS varchar(255) CHARSET latin1
BEGIN
    DECLARE RV VARCHAR(255);
    DECLARE CM CHAR(1);
    DECLARE CH INT;

    SET RV = '';
    SET CM = '';
    SET CH = GET_ID;
    WHILE CH > 0 DO
        SELECT IFNULL(ID_PARENT,-1) INTO CH FROM
        (SELECT ID_PARENT FROM app_menu WHERE ID = CH) A;
        IF CH > 0 THEN
            SET RV = CONCAT(RV,CM,CH);
            SET CM = ',';
        END IF;
    END WHILE;
    RETURN RV;
END//
DELIMITER ;


-- Dumping structure for event cgis.evt_checkVesselNameLicense
DELIMITER //
CREATE DEFINER=`tpft`@`%` EVENT `evt_checkVesselNameLicense` ON SCHEDULE EVERY 60 MINUTE STARTS '2016-02-12 11:29:33' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	DECLARE VANGKUTKODE VARCHAR(25);
	DECLARE VANGKUTNAMA VARCHAR(100);
	DECLARE VANGKUTNO VARCHAR(20);
	DECLARE VKD_GUDANG VARCHAR(10);
	DECLARE VID_IJIN INT(20);
	DECLARE CUR CURSOR FOR SELECT A.ANGKUTNAMA, A.ANGKUTNO, A.ID_IJIN FROM t_ppk_hdr A WHERE A.ANGKUTKODE_TPS IS NULL ORDER BY A.ID_IJIN ASC;
	
	OPEN CUR;
		GET_CUR: LOOP
			FETCH CUR INTO VANGKUTNAMA, VANGKUTNO, VID_IJIN;
			
			SELECT A.KD_GUDANG, A.KD_KAPAL, A.NM_KAPAL INTO VKD_GUDANG, VANGKUTKODE, VANGKUTNAMA
			FROM reff_kapal A
			WHERE UPPER(A.NM_KAPAL) LIKE CONCAT('%',VANGKUTNAMA,'%');
			
			IF VKD_GUDANG IS NOT NULL THEN
				UPDATE t_ppk_hdr SET ANGKUTKODE_TPS = VANGKUTKODE, ANGKUTNAMA_TPS = VANGKUTNAMA, TMP_TIMBUN_TPS = VKD_GUDANG
				WHERE A.ANGKUTNAMA = VANGKUTNAMA
						AND A.ANGKUTKODE_TPS IS NULL
						AND A.ID_IJIN = VID_IJIN;
			END IF;
			
			INSERT INTO log_job (TIPE_JOB, NAMA_JOB, SQL_CODE, SQL_ERRM, `STATUS`, KETERANGAN, WK_REKAM)
			VALUES ('EVENT','checkVesselNameLicense', NULL, CONCAT('ID_IJIN: ', VID_IJIN, ', KD_GUDANG: ', VKD_GUDANG, ', ANGKUTKODE: ',VANGKUTKODE),'SUCCESS',NULL, NOW());	
		END LOOP GET_CUR;
	CLOSE CUR;	
END//
DELIMITER ;


-- Dumping structure for trigger cgis.trg_ai_permitcont
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_ai_permitcont` AFTER INSERT ON `t_permit_cont` FOR EACH ROW BEGIN
	DECLARE DONE INT DEFAULT FALSE; 
	DECLARE V_KD_TPS, V_KD_GUDANG VARCHAR(20) DEFAULT NULL;
	DECLARE CCURSOR CURSOR FOR SELECT A.KD_TPS, A.KD_GUDANG
										FROM reff_gudang A 
										WHERE A.LINI IN ('1','2')
											AND A.FL_AKTIF = 'Y';										
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET DONE = TRUE;

	INSERT INTO t_permit_cont_status (ID, NO_CONT, KD_GUDANG, KD_GUDANG_PERIKSA, KD_TIMBUN, STATUS_CONT, KD_STATUS, TGL_STATUS)
	VALUES (NEW.ID, NEW.NO_CONT, NEW.KD_GUDANG, NEW.KD_GUDANG_PERIKSA, NEW.KD_TIMBUN, NEW.STATUS_CONT, NEW.KD_STATUS, NEW.TGL_STATUS);
	
	INSERT INTO t_codecopermit (ID_IJIN_PERMOHONAN, NO_CONT, WK_REKAM)
	VALUES(NEW.ID, NEW.NO_CONT, NOW());
	
	OPEN CCURSOR;
	CCURSOR_LOOP: LOOP
		FETCH CCURSOR INTO V_KD_TPS, V_KD_GUDANG;
		IF DONE THEN
			LEAVE CCURSOR_LOOP;
		END IF;
		
		INSERT INTO t_permit_cont_relocation (ID, KD_TPS, KD_GUDANG, FL_RELOCATION, TGL_RELOCATION)
		VALUES (NEW.ID, V_KD_TPS, V_KD_GUDANG, '0', NOW());
			
	END LOOP CCURSOR_LOOP;
	CLOSE CCURSOR;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_ai_ppkcont
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_ai_ppkcont` BEFORE INSERT ON `t_ppk_cont` FOR EACH ROW BEGIN
	DECLARE VIP_ADDRESS VARCHAR(50) DEFAULT (SELECT ID_IJIN_INSPEKSI FROM t_lic_hdr WHERE ID_IJIN = NEW.ID_IJIN);
	DECLARE VID_IJIN_INSPEKSI INT(20) DEFAULT (SELECT ID_IJIN_INSPEKSI FROM t_lic_hdr WHERE ID_IJIN = NEW.ID_IJIN);
	
	DECLARE DONE INT DEFAULT FALSE; 
	DECLARE V_KD_TPS, V_KD_GUDANG VARCHAR(20) DEFAULT NULL;
	DECLARE CCURSOR CURSOR FOR SELECT A.KD_TPS, A.KD_GUDANG
										FROM reff_gudang A 
										WHERE A.LINI IN ('1','2')
											AND A.FL_AKTIF = 'Y';										
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET DONE = TRUE;
	
	
	INSERT INTO t_ppk_cont_status (ID_IJIN, NO_CONT, KD_GUDANG, KD_GUDANG_PERIKSA, KD_TIMBUN, STATUS_CONT, KD_STATUS, TGL_STATUS, STATUS_RELOKASI)
	VALUES (NEW.ID_IJIN, NEW.NO_CONT, NEW.KD_GUDANG, NEW.KD_GUDANG_PERIKSA, NEW.KD_TIMBUN, NEW.STATUS_CONT, NEW.KD_STATUS, NEW.TGL_STATUS, NEW.STATUS_RELOKASI);
		
	IF VID_IJIN_INSPEKSI IS NULL THEN -- PERIJINAN PERMOHONAN        
	   INSERT INTO t_codeco (ID_IJIN_PERMOHONAN, NO_CONT, WK_REKAM)
	   VALUES(NEW.ID_IJIN,NEW.NO_CONT, NOW());
	ELSE -- PERIJINAN PENYELESAIAN            
	   UPDATE t_codeco SET ID_IJIN_PENYELESAIAN = NEW.ID_IJIN
	   WHERE ID_IJIN_PERMOHONAN = VID_IJIN_INSPEKSI;
	END IF;
	
	OPEN CCURSOR;
	CCURSOR_LOOP: LOOP
		FETCH CCURSOR INTO V_KD_TPS, V_KD_GUDANG;
		IF DONE THEN
			LEAVE CCURSOR_LOOP;
		END IF;
		
		INSERT INTO t_ppk_cont_relocation (ID_IJIN, KD_TPS, KD_GUDANG, FL_RELOCATION, TGL_RELOCATION)
		VALUES (NEW.ID_IJIN, V_KD_TPS, V_KD_GUDANG, '0', NOW());
			
	END LOOP CCURSOR_LOOP;
	CLOSE CCURSOR;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_ai_ppkjadwal
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_ai_ppkjadwal` AFTER INSERT ON `t_ppk_jadwal` FOR EACH ROW BEGIN
	UPDATE t_codeco SET TGL_PERIKSA = NEW.TGL_PERIKSA
   WHERE ID_IJIN_PERMOHONAN = NEW.ID_IJIN;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_ai_ppkpetugas
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_ai_ppkpetugas` AFTER INSERT ON `t_ppk_petugas` FOR EACH ROW BEGIN
	DECLARE DONE INT DEFAULT FALSE; 
	DECLARE V_KD_TPS, V_KD_GUDANG VARCHAR(20) DEFAULT NULL;
	DECLARE CCURSOR CURSOR FOR SELECT A.KD_TPS, A.KD_GUDANG
										FROM reff_gudang A 
										WHERE A.LINI IN ('1','2')
											AND A.FL_AKTIF = 'Y';										
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET DONE = TRUE;
	
	OPEN CCURSOR;
	CCURSOR_LOOP: LOOP
		FETCH CCURSOR INTO V_KD_TPS, V_KD_GUDANG;
		IF DONE THEN
			LEAVE CCURSOR_LOOP;
		END IF;
		
		INSERT INTO t_ppk_petugas_sent (ID_IJIN, KD_TPS, KD_GUDANG, FL_SENT, TGL_SENT)
		VALUES (NEW.ID_IJIN, V_KD_TPS, V_KD_GUDANG, '0', NOW());
			
	END LOOP CCURSOR_LOOP;
	CLOSE CCURSOR;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_au_permitcont
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_au_permitcont` AFTER UPDATE ON `t_permit_cont` FOR EACH ROW BEGIN
	DECLARE V_KD_GUDANG VARCHAR(100) DEFAULT (SELECT KD_GUDANG FROM t_permit_hdr WHERE ID = OLD.ID LIMIT 0,1);
	DECLARE V_NM_ANGKUT VARCHAR(100) DEFAULT (SELECT NM_ANGKUT FROM t_permit_hdr WHERE ID = OLD.ID LIMIT 0,1);
	DECLARE V_VOYAGE VARCHAR(100) DEFAULT (SELECT NO_VOY_FLIGHT FROM t_permit_hdr WHERE ID = OLD.ID LIMIT 0,1);

	INSERT INTO t_permit_cont_status (ID, NO_CONT, KD_GUDANG, KD_GUDANG_PERIKSA, KD_TIMBUN, STATUS_CONT, KD_STATUS, TGL_STATUS)
	VALUES (NEW.ID, NEW.NO_CONT, NEW.KD_GUDANG, NEW.KD_GUDANG_PERIKSA, NEW.KD_TIMBUN, NEW.STATUS_CONT, NEW.KD_STATUS, NEW.TGL_STATUS);
	
	
	UPDATE t_codecopermit SET KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
	WHERE ID_IJIN_PERMOHONAN = OLD.ID AND NO_CONT = OLD.NO_CONT;
	
   IF NEW.KD_STATUS = '1' THEN -- DISCHARGE	 
			UPDATE t_codecopermit SET KD_TPS = NULL, KD_GUDANG = V_KD_GUDANG, KD_KAPAL = NULL, NM_KAPAL = V_NM_ANGKUT, 
			                    NO_VOYAGE = V_VOYAGE, CALL_SIGN = NULL, KD_TIMBUN = NEW.KD_TIMBUN, TGL_DISCHARGE = NEW.TGL_STATUS,
			                    KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
			WHERE ID_IJIN_PERMOHONAN = OLD.ID 
					AND NO_CONT = OLD.NO_CONT;
	ELSEIF NEW.KD_STATUS = '2' THEN -- STACKING	   
			UPDATE t_codecopermit SET TGL_STACKING = NEW.TGL_STATUS, KD_TIMBUN = NEW.KD_TIMBUN, KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
			WHERE ID_IJIN_PERMOHONAN = OLD.ID 
					AND NO_CONT = OLD.NO_CONT;
	ELSEIF NEW.KD_STATUS = '3' THEN -- GATE IN	   
			UPDATE t_codecopermit SET TGL_GATE_IN = NEW.TGL_STATUS
			WHERE ID_IJIN_PERMOHONAN = OLD.ID 
					AND NO_CONT = OLD.NO_CONT;
	ELSEIF NEW.KD_STATUS = '4' THEN -- GATE OUT	   
			UPDATE t_codecopermit SET TGL_GATE_OUT = NEW.TGL_STATUS
			WHERE ID_IJIN_PERMOHONAN = OLD.ID 
					AND NO_CONT = OLD.NO_CONT;
	ELSEIF NEW.KD_STATUS = '5' THEN -- ON VESSEL	   
			UPDATE t_codecopermit SET KD_TPS = NULL, KD_GUDANG = V_KD_GUDANG, KD_KAPAL = NULL, NM_KAPAL = V_NM_ANGKUT, 
			                    NO_VOYAGE = V_VOYAGE, CALL_SIGN = NULL, KD_TIMBUN = NEW.KD_TIMBUN, TGL_ON_VESSEL = NEW.TGL_STATUS,
			                    KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
			WHERE ID_IJIN_PERMOHONAN = OLD.ID 
					AND NO_CONT = OLD.NO_CONT;
	ELSEIF NEW.KD_STATUS = '11' THEN -- STACKING TPFT
			UPDATE t_codecopermit SET TGL_STACKING = NEW.TGL_STATUS, KD_TIMBUN = NEW.KD_TIMBUN, KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
			WHERE ID_IJIN_PERMOHONAN = OLD.ID 
					AND NO_CONT = OLD.NO_CONT;
	ELSEIF NEW.KD_STATUS = '9' THEN -- NOT FOUND
			UPDATE t_codecopermit SET TGL_NOT_FOUND = NEW.TGL_STATUS
			WHERE ID_IJIN_PERMOHONAN = OLD.ID 
					AND NO_CONT = OLD.NO_CONT;
   END IF;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_au_ppkcont
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_au_ppkcont` AFTER UPDATE ON `t_ppk_cont` FOR EACH ROW BEGIN
	DECLARE VID_IJIN_INSPEKSI INT(20) DEFAULT (SELECT ID_IJIN_INSPEKSI FROM t_lic_hdr WHERE ID_IJIN = OLD.ID_IJIN LIMIT 0,1);
	DECLARE VANGKUTKODE_TPS VARCHAR(100) DEFAULT (SELECT ANGKUTKODE_TPS FROM t_ppk_hdr WHERE ID_IJIN = OLD.ID_IJIN LIMIT 0,1);
	DECLARE VANGKUTNAMA_TPS VARCHAR(100) DEFAULT (SELECT ANGKUTNAMA_TPS FROM t_ppk_hdr WHERE ID_IJIN = OLD.ID_IJIN LIMIT 0,1);
	DECLARE VANGKUTNO_TPS VARCHAR(100) DEFAULT (SELECT ANGKUTNO_TPS FROM t_ppk_hdr WHERE ID_IJIN = OLD.ID_IJIN LIMIT 0,1);
	DECLARE VTMP_TIMBUN_TPS VARCHAR(100) DEFAULT (SELECT TMP_TIMBUN_TPS FROM t_ppk_hdr WHERE ID_IJIN = OLD.ID_IJIN LIMIT 0,1);
	DECLARE VCALL_SIGN VARCHAR(100) DEFAULT (SELECT DISTINCT CALL_SIGN FROM t_jadwal_kapal WHERE KD_KAPAL = (SELECT ANGKUTKODE_TPS FROM t_ppk_hdr WHERE ID_IJIN = OLD.ID_IJIN) LIMIT 0,1);
	DECLARE VKD_TPS VARCHAR(100) DEFAULT (SELECT KD_TPS FROM reff_gudang WHERE KD_GUDANG = (SELECT TMP_TIMBUN_TPS FROM t_ppk_hdr WHERE ID_IJIN = OLD.ID_IJIN) LIMIT 0,1);
	DECLARE ISEXIST INT(18);
	
	SELECT COUNT(ID_IJIN) INTO ISEXIST
	FROM t_ppk_cont_status
	WHERE ID_IJIN = OLD.ID_IJIN
			AND NO_CONT = OLD.NO_CONT
			AND KD_STATUS = NEW.KD_STATUS
			AND TGL_STATUS = NEW.TGL_STATUS
			AND KD_TIMBUN = NEW.KD_TIMBUN;
			
	INSERT INTO t_ppk_cont_status (ID_IJIN, NO_CONT, KD_GUDANG, KD_GUDANG_PERIKSA, KD_TIMBUN, STATUS_CONT, KD_STATUS, TGL_STATUS, STATUS_RELOKASI)
	VALUES (OLD.ID_IJIN, OLD.NO_CONT, NEW.KD_GUDANG, NEW.KD_GUDANG_PERIKSA, NEW.KD_TIMBUN, NEW.STATUS_CONT, NEW.KD_STATUS, NEW.TGL_STATUS, NEW.STATUS_RELOKASI);			
			
	UPDATE t_codeco SET KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
	WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN 
			AND NO_CONT = OLD.NO_CONT;
	
	IF ISEXIST = 0 THEN 		
		IF VID_IJIN_INSPEKSI IS NULL THEN -- PERIJINAN PERMOHONAN
		   IF NEW.KD_STATUS = '1' THEN -- DISCHARGE	 
					UPDATE t_codeco SET KD_TPS = VKD_TPS, KD_GUDANG = VTMP_TIMBUN_TPS, KD_KAPAL = VANGKUTKODE_TPS, NM_KAPAL = VANGKUTNAMA_TPS, 
					                    NO_VOYAGE = VANGKUTNO_TPS, CALL_SIGN = VCALL_SIGN, KD_TIMBUN = NEW.KD_TIMBUN, TGL_DISCHARGE = NEW.TGL_STATUS,
					                    KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
					WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN 
							AND NO_CONT = OLD.NO_CONT;
			ELSEIF NEW.KD_STATUS = '2' THEN -- STACKING	   
					UPDATE t_codeco SET TGL_STACKING = NEW.TGL_STATUS, KD_TIMBUN = NEW.KD_TIMBUN, KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
					WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN 
							AND NO_CONT = OLD.NO_CONT;
			ELSEIF NEW.KD_STATUS = '3' THEN -- GATE IN	   
					UPDATE t_codeco SET TGL_GATE_IN = NEW.TGL_STATUS
					WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN 
							AND NO_CONT = OLD.NO_CONT;
			ELSEIF NEW.KD_STATUS = '4' THEN -- GATE OUT	   
					UPDATE t_codeco SET TGL_GATE_OUT = NEW.TGL_STATUS
					WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN 
							AND NO_CONT = OLD.NO_CONT;
			ELSEIF NEW.KD_STATUS = '5' THEN -- ON VESSEL	   
					UPDATE t_codeco SET KD_TPS = VKD_TPS, KD_GUDANG = VTMP_TIMBUN_TPS, KD_KAPAL = VANGKUTKODE_TPS, NM_KAPAL = VANGKUTNAMA_TPS, 
					                    NO_VOYAGE = VANGKUTNO_TPS, CALL_SIGN = VCALL_SIGN, KD_TIMBUN = NEW.KD_TIMBUN, TGL_ON_VESSEL = NEW.TGL_STATUS,
					                    KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
					WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN 
							AND NO_CONT = OLD.NO_CONT;
			ELSEIF NEW.KD_STATUS = '11' THEN -- STACKING TPFT
					UPDATE t_codeco SET TGL_STACKING = NEW.TGL_STATUS, KD_TIMBUN = NEW.KD_TIMBUN, KD_GUDANG_PERIKSA = NEW.KD_GUDANG_PERIKSA, STATUS_CONT = NEW.STATUS_CONT
					WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN 
							AND NO_CONT = OLD.NO_CONT;
			ELSEIF NEW.KD_STATUS = '9' THEN -- NOT FOUND
					UPDATE t_codeco SET TGL_NOT_FOUND = NEW.TGL_STATUS
					WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN 
							AND NO_CONT = OLD.NO_CONT;
		   END IF;
		END IF;
	END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_au_ppkjadwal
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_au_ppkjadwal` AFTER UPDATE ON `t_ppk_jadwal` FOR EACH ROW BEGIN
	UPDATE t_codeco SET TGL_PERIKSA = NEW.TGL_PERIKSA, TGL_TIBA_PEMERIKSA = NEW.TGL_TIBA_PEMERIKSA, 
                        TGL_MULAI_PERIKSA = NEW.TGL_MULAI_PERIKSA, TGL_SELESAI_PERIKSA = NEW.TGL_SELESAI_PERIKSA
  	WHERE ID_IJIN_PERMOHONAN = OLD.ID_IJIN;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_bd_lichdr
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_bd_lichdr` BEFORE DELETE ON `hist_lic_hdr` FOR EACH ROW BEGIN
	DECLARE VIP_ADDRESS VARCHAR(50) DEFAULT (select SUBSTRING_INDEX(host,':',1) from information_schema.processlist WHERE ID=connection_id());
	INSERT INTO hist_lic_hdr (ID_IJIN, NO_IJIN, TGL_AWAL, TGL_IJIN, TGL_AKHIR, KETERANGAN, NPWP, 
                             NM_TRADER, ALM_TRADER, ID_GA, WKPROSES, KD_IJIN, KODE_STATUS, 
                             JNS_IJIN, USED_BY_CAR, JNS_REKAM, REKAM_BY, WK_REKAM, UPD_BY, UPD_DATE, FL_DATA)
	VALUES(OLD.ID_IJIN, OLD.NO_IJIN, OLD.TGL_AWAL, OLD.TGL_IJIN, OLD.TGL_AKHIR, OLD.KETERANGAN, OLD.NPWP, 
          OLD.NM_TRADER, OLD.ALM_TRADER, OLD.ID_GA, OLD.WKPROSES, OLD.KD_IJIN, OLD.KODE_STATUS, 
          OLD.JNS_IJIN, OLD.USED_BY_CAR, OLD.JNS_REKAM, OLD.REKAM_BY, OLD.WK_REKAM, VIP_ADDRESS, NOW(), 'D');   
			 
	DELETE FROM t_ppk_cont_status WHERE ID_IJIN = OLD.ID_IJIN;
	DELETE FROM t_ppk_kms_status WHERE ID_IJIN = OLD.ID_IJIN;                          
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_bd_ppkdtl
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_bd_ppkdtl` BEFORE DELETE ON `t_ppk_dtl` FOR EACH ROW BEGIN
	DECLARE VIP_ADDRESS VARCHAR(50) DEFAULT (select SUBSTRING_INDEX(host,':',1) from information_schema.processlist WHERE ID=connection_id());
	INSERT INTO hist_ppk_dtl (ID_IJIN, NOSERI, NO_HS, UR_BRG, KD_SAT, JM_SAT, DTL_NETTO, SPP, NM_LATIN, HISTORY_BY, HISTORY_DATE)
	VALUES (OLD.ID_IJIN, OLD.NOSERI, OLD.NO_HS, OLD.UR_BRG, OLD.KD_SAT, OLD.JM_SAT, OLD.DTL_NETTO, OLD.SPP, OLD.NM_LATIN, VIP_ADDRESS, NOW());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger cgis.trg_bu_ppkdtl
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_bu_ppkdtl` BEFORE UPDATE ON `t_ppk_dtl` FOR EACH ROW BEGIN
	DECLARE VIP_ADDRESS VARCHAR(50) DEFAULT (select SUBSTRING_INDEX(host,':',1) from information_schema.processlist WHERE ID=connection_id());
	INSERT INTO hist_ppk_dtl (ID_IJIN, NOSERI, NO_HS, UR_BRG, KD_SAT, JM_SAT, DTL_NETTO, SPP, NM_LATIN, HISTORY_BY, HISTORY_DATE)
	VALUES (OLD.ID_IJIN, OLD.NOSERI, OLD.NO_HS, OLD.UR_BRG, OLD.KD_SAT, OLD.JM_SAT, OLD.DTL_NETTO, OLD.SPP, OLD.NM_LATIN, VIP_ADDRESS, NOW());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
