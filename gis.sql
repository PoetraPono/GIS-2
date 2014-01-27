/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : gis

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2014-01-27 21:39:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `TB_MSPRZ`
-- ----------------------------
DROP TABLE IF EXISTS `TB_MSPRZ`;
CREATE TABLE `TB_MSPRZ` (
  `MSPRZ_ID` int(6) NOT NULL AUTO_INCREMENT,
  `PRZ_ID` int(5) NOT NULL,
  `PRS_ID` int(5) NOT NULL,
  `MSPRZ_MS_BR` date NOT NULL,
  PRIMARY KEY (`MSPRZ_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of TB_MSPRZ
-- ----------------------------
INSERT INTO `TB_MSPRZ` VALUES ('1', '1', '1', '2014-09-18');
INSERT INTO `TB_MSPRZ` VALUES ('2', '2', '1', '2014-09-18');
INSERT INTO `TB_MSPRZ` VALUES ('3', '1', '2', '2019-09-18');
INSERT INTO `TB_MSPRZ` VALUES ('4', '3', '1', '2019-10-01');
INSERT INTO `TB_MSPRZ` VALUES ('5', '1', '3', '2014-09-19');
INSERT INTO `TB_MSPRZ` VALUES ('6', '2', '3', '2014-09-19');
INSERT INTO `TB_MSPRZ` VALUES ('7', '5', '3', '2014-09-19');
INSERT INTO `TB_MSPRZ` VALUES ('8', '18', '3', '2018-01-01');
INSERT INTO `TB_MSPRZ` VALUES ('9', '19', '3', '2034-01-11');
INSERT INTO `TB_MSPRZ` VALUES ('10', '19', '3', '2034-01-11');
INSERT INTO `TB_MSPRZ` VALUES ('11', '51', '2', '2081-01-07');
INSERT INTO `TB_MSPRZ` VALUES ('12', '2', '6', '2013-10-14');
INSERT INTO `TB_MSPRZ` VALUES ('18', '0', '0', '0000-00-00');
INSERT INTO `TB_MSPRZ` VALUES ('25', '3', '10', '2013-10-31');
INSERT INTO `TB_MSPRZ` VALUES ('26', '4', '11', '2013-11-06');

-- ----------------------------
-- Table structure for `TB_PII`
-- ----------------------------
DROP TABLE IF EXISTS `TB_PII`;
CREATE TABLE `TB_PII` (
  `PII_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PII_UE` varchar(5) NOT NULL,
  `PII_PSW` varchar(150) NOT NULL,
  `PII_NM` varchar(150) NOT NULL,
  `PII_PII` enum('2','1') NOT NULL DEFAULT '2',
  PRIMARY KEY (`PII_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of TB_PII
-- ----------------------------
INSERT INTO `TB_PII` VALUES ('1', 'root', '913f8cfc77c2c974cc3a838cde8c7e6b', 'Admin', '1');
INSERT INTO `TB_PII` VALUES ('4', 'k1m0c', 'de798e12f57b36a0b1a3266b2dbd02af', 'k1m0ch1', '2');

-- ----------------------------
-- Table structure for `TB_PRS`
-- ----------------------------
DROP TABLE IF EXISTS `TB_PRS`;
CREATE TABLE `TB_PRS` (
  `PRS_ID` int(5) NOT NULL AUTO_INCREMENT COMMENT 'PERUSAHAAN ID',
  `PRS_NM` varchar(150) NOT NULL COMMENT 'PERUSAHAAN NAMA',
  `PRS_AL` varchar(150) NOT NULL COMMENT 'PERUSAHAAN ALAMAT',
  `PRS_TL` varchar(150) NOT NULL COMMENT 'PERUSAHAAN TELEPON',
  `PRS_KT` varchar(150) NOT NULL COMMENT 'PERUSAHAAN KATEGORI',
  `PRS_TN` varchar(200) NOT NULL COMMENT 'PERUSAHAAN TENTANG',
  PRIMARY KEY (`PRS_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of TB_PRS
-- ----------------------------
INSERT INTO `TB_PRS` VALUES ('1', 'PT. Avebe Indonesia', 'Bukit Indah Industrial Park Kav. F3 Sector 1A, Cikampek, Karawang Jawa Barat, Indonesia', '(0264) 351163', 'Starch', 'Perusahaan Avebe Indonesia Menyediakan Starch');
INSERT INTO `TB_PRS` VALUES ('2', 'PT. Satonas Utama', 'Jl. Raya Klari Km. 10, Karawang 41371 Jawa Barat, Indonesia', '(0267) 431510', 'Particle board Askaboard', 'Perusahaan Satonas Utama Menyediakan Particle board Askaboard');
INSERT INTO `TB_PRS` VALUES ('3', 'PT. Sarimas Sentosa', 'Jl. Raya Karawang Cikampek, Klari, Karawang 41373 Jawa Barat, Indonesia', '(0267) 431102', 'Manufacture', 'Perusahaan sarimas Sentos menyediakan Manufacture');
INSERT INTO `TB_PRS` VALUES ('4', 'PT A & K Door Indonesia', 'Karawang International Industrial City Lot C No. 3-B, Jl. Permata Raya, Teluk Jambe, Karawang, Jawa Barat 41361', '(021) 8904210', 'Wooden door and fram', 'Perusahaan A & K Door Indonesia menyediakan Wooden door and fram');
INSERT INTO `TB_PRS` VALUES ('5', 'PT AT Indonesia', 'Karawang International Industrial City Lot H No. 1-5,Jl. Maligi III, Tol Jakarta-Cikampek Km. 47, Karawang, Jawa Barat 41361', '(021) 8904376', 'Spare part for motor vehicle : suspension, brake, steering', 'PT AT Indonesia Spare part for motor vehicle : suspension, brake, steering');
INSERT INTO `TB_PRS` VALUES ('6', 'PT DNP Indonesia', 'Karawang International Industrial City Lot 1-4,  Jl. Maligi Raya, Karawang, Jawa Barat 41361', ' (021) 89107224', 'Plastic packaging; Printing', 'PT DNP Indonesia Plastic packaging; Printing');
INSERT INTO `TB_PRS` VALUES ('7', 'PT Horiguchi Engineering Indonesia', 'Karawang International Industrial City Lot D-I A,   Jl. Maligi Raya, Teluk Jambe, Karawang, Jawa Barat 41361', '(021) 8901612', 'Maintenance service and heavy equipment repair', 'PT Horiguchi Engineering Indonesia Maintenance service and heavy equipment repair');
INSERT INTO `TB_PRS` VALUES ('8', 'PT Fujita Indonesia', 'Karawang International Industrial City Lot N-3A,   Jl. Maligi III, Karawang, Jawa Barat 41361', '(021) 89107777', 'Motorcycle spare parts', 'Perusahaan Fujita Indonesia bekerja di kategori Motorcycle spare parts');
INSERT INTO `TB_PRS` VALUES ('9', 'PT Koyama Indonesia', 'Karawang International Industrial City Lot Q No. 1-A3,   Jl. Maligi VI, Karawang, Jawa Barat 41361', '(021) 8902535', 'Motorcycle spare parts', 'PT Koyama Indonesia Motorcycle spare parts');
INSERT INTO `TB_PRS` VALUES ('10', 'PT Suncall Indonesia', 'Karawang International Industrial City Lot B No. 5,   Jl. Maligi I, Karawang, Jawa Barat 41361', '(021) 8905430', 'Manufacturer of paper feeding roller for colour printer', 'PT Suncall Indonesia Manufacturer of paper feeding roller for colour printer');
INSERT INTO `TB_PRS` VALUES ('11', 'PT Oriental Manufacturing Indonesia', 'Karawang International Industrial City Lot C No. 4-B,  Jl. Maligi II, Teluk Jambe, Karawang, Jawa Barat 41361', '(021) 8904242 1', 'Plastic injection moulding', 'PT Oriental Manufacturing Indonesia Plastic injection moulding');

-- ----------------------------
-- Table structure for `TB_PRZ`
-- ----------------------------
DROP TABLE IF EXISTS `TB_PRZ`;
CREATE TABLE `TB_PRZ` (
  `PRZ_ID` int(3) NOT NULL AUTO_INCREMENT COMMENT 'PERIZINAN ID',
  `PRZ_NM` varchar(150) NOT NULL COMMENT 'PERIZINAN NAMA',
  PRIMARY KEY (`PRZ_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of TB_PRZ
-- ----------------------------
INSERT INTO `TB_PRZ` VALUES ('1', 'Izin Lokasi');
INSERT INTO `TB_PRZ` VALUES ('2', 'Izin Membuka Tanah');
INSERT INTO `TB_PRZ` VALUES ('3', 'Izin Pemakaian Tanah Bagian DMJ');
INSERT INTO `TB_PRZ` VALUES ('4', 'Izin Mendirikan Bangunan');
INSERT INTO `TB_PRZ` VALUES ('5', 'Izin Pengelolaan Kamar Mandi/ Kamar Kecil');
INSERT INTO `TB_PRZ` VALUES ('6', 'Izin Usaha Pengelolaan Kebersihan Lingkungan');
INSERT INTO `TB_PRZ` VALUES ('7', 'Izin Penyelengaraan Pengobatan Tradisional');
INSERT INTO `TB_PRZ` VALUES ('8', 'Izin Penyelenggaraan Apotek');
INSERT INTO `TB_PRZ` VALUES ('9', 'Izin Penyelenggaraan Toko Obat');
INSERT INTO `TB_PRZ` VALUES ('10', 'Izin Penyelenggaraan Optikal');
INSERT INTO `TB_PRZ` VALUES ('11', 'Izin Kerja Asisten Apoteker');
INSERT INTO `TB_PRZ` VALUES ('12', 'Tanda Daftar Salon Kecantikan');
INSERT INTO `TB_PRZ` VALUES ('13', 'Tanda Daftar Sarana Tempat-Tempat Umum');
INSERT INTO `TB_PRZ` VALUES ('14', 'Tanda Daftar Jasa Boga');
INSERT INTO `TB_PRZ` VALUES ('15', 'Izin Sarana dan Jasa Pariwisata');
INSERT INTO `TB_PRZ` VALUES ('16', 'Izin Usaha Obyek dan Daya Tarik Wisata');
INSERT INTO `TB_PRZ` VALUES ('17', 'Izin Trayek Angkutan Kota');
INSERT INTO `TB_PRZ` VALUES ('18', 'Tanda Daftar Industri');
INSERT INTO `TB_PRZ` VALUES ('19', 'Izin Usaha Industri');
INSERT INTO `TB_PRZ` VALUES ('20', 'Izin Perluasan Industri');
INSERT INTO `TB_PRZ` VALUES ('21', 'Izin Usaha Perdagangan');
INSERT INTO `TB_PRZ` VALUES ('22', 'Izin Menempati Bangunan');
INSERT INTO `TB_PRZ` VALUES ('23', 'Izin Usaha Perusahaan Pengeboran Air Bawah Tanah');
INSERT INTO `TB_PRZ` VALUES ('24', 'Izin Juru Bor');
INSERT INTO `TB_PRZ` VALUES ('25', 'Izin Eksplorasi');
INSERT INTO `TB_PRZ` VALUES ('26', 'Tanda Daftar Perusahaan');
INSERT INTO `TB_PRZ` VALUES ('27', 'Tanda Daftar Gudang');
INSERT INTO `TB_PRZ` VALUES ('28', 'Izin Pengeboran Air Bawah Tanah');
INSERT INTO `TB_PRZ` VALUES ('29', 'Izin Pengambilan Air Bawah Tanah');
INSERT INTO `TB_PRZ` VALUES ('30', 'Izin Usaha Tambak di Kawasan Hutan');
INSERT INTO `TB_PRZ` VALUES ('31', 'Izin Pendirian Lembaga Pelatihan Kerja');
INSERT INTO `TB_PRZ` VALUES ('32', 'Izin Pendirian Lembaga Bursa Kerja');
INSERT INTO `TB_PRZ` VALUES ('33', 'Izin Operasional TKS');
INSERT INTO `TB_PRZ` VALUES ('34', 'Izin Pendirian Kantor Cabang Perusahaan Jasa Tenaga Kerja Indonesia ');
INSERT INTO `TB_PRZ` VALUES ('35', 'Izin Asrama atau Akomodasi Penampungan Calon TKI');
INSERT INTO `TB_PRZ` VALUES ('36', 'Izin Operasional Perusahaan Penyedia Jasa Pekerja/Buruh');
INSERT INTO `TB_PRZ` VALUES ('37', 'Izin Usaha Pengelolaan dan Pemasaran Hasil Perikanan');
INSERT INTO `TB_PRZ` VALUES ('38', 'Izin Pengumpulan Limbah B3');
INSERT INTO `TB_PRZ` VALUES ('39', 'Izin Pembuangan Limbah Ke Air Atau Sumber Air');
INSERT INTO `TB_PRZ` VALUES ('40', 'Izin Pemanfaatan Limbah');
INSERT INTO `TB_PRZ` VALUES ('41', 'Izin Gangguan');
INSERT INTO `TB_PRZ` VALUES ('42', 'Izin Pendirian Sekolah Swasta');
INSERT INTO `TB_PRZ` VALUES ('43', 'Izin Reklame');
INSERT INTO `TB_PRZ` VALUES ('44', 'Izin Usaha Jasa Konstruksi');
INSERT INTO `TB_PRZ` VALUES ('45', 'Izin Penyimpanan Sementara Limbah B3');
INSERT INTO `TB_PRZ` VALUES ('46', 'Izin Operasi Angkutan Taksi');
INSERT INTO `TB_PRZ` VALUES ('47', 'Izin Operasi Angkutan Sewa');
INSERT INTO `TB_PRZ` VALUES ('48', 'Izin Usaha Angkutan Pariwisata');
INSERT INTO `TB_PRZ` VALUES ('49', 'Izin Usaha Angkutan Barang');
INSERT INTO `TB_PRZ` VALUES ('50', 'Izin Usaha Kawasan Industri');
INSERT INTO `TB_PRZ` VALUES ('51', 'Izin Perluasan Kawasan Industri');
INSERT INTO `TB_PRZ` VALUES ('52', 'Umum');
INSERT INTO `TB_PRZ` VALUES ('53', 'Rekomendasi Kios Sarana Produksi Pertanian');
INSERT INTO `TB_PRZ` VALUES ('54', 'Pengesahan Rencana Tapak');
INSERT INTO `TB_PRZ` VALUES ('55', 'Kartu Pengawasan');
INSERT INTO `TB_PRZ` VALUES ('56', 'Izin Usaha Pertambangan Energi dan Sumber Daya Mineral');

-- ----------------------------
-- Table structure for `TB_PT`
-- ----------------------------
DROP TABLE IF EXISTS `TB_PT`;
CREATE TABLE `TB_PT` (
  `PT_ID` int(20) NOT NULL AUTO_INCREMENT,
  `SRE_ID` int(5) NOT NULL,
  `PT_NM_FL` varchar(150) NOT NULL,
  PRIMARY KEY (`PT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of TB_PT
-- ----------------------------
INSERT INTO `TB_PT` VALUES ('1', '1', '1.jpg');
INSERT INTO `TB_PT` VALUES ('2', '1', '2.jpg');
INSERT INTO `TB_PT` VALUES ('3', '2', '3.jpg');
INSERT INTO `TB_PT` VALUES ('4', '2', '4.jpg');
INSERT INTO `TB_PT` VALUES ('5', '3', '5.jpg');
INSERT INTO `TB_PT` VALUES ('6', '1', '6.jpg');
INSERT INTO `TB_PT` VALUES ('7', '7', '7.jpg');
INSERT INTO `TB_PT` VALUES ('8', '7', '8.jpg');
INSERT INTO `TB_PT` VALUES ('9', '7', '9.jpg');

-- ----------------------------
-- Table structure for `TB_SRE`
-- ----------------------------
DROP TABLE IF EXISTS `TB_SRE`;
CREATE TABLE `TB_SRE` (
  `SRE_ID` int(20) NOT NULL AUTO_INCREMENT,
  `PRS_ID` int(5) NOT NULL,
  `SRE_LT` varchar(20) NOT NULL,
  `SRE_LN` varchar(20) NOT NULL,
  `SRE_TGL_PNI` date NOT NULL,
  `SRE_JML_KRA` varchar(9) NOT NULL,
  `SRE_DLT` enum('1','0') DEFAULT '0',
  PRIMARY KEY (`SRE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of TB_SRE
-- ----------------------------
INSERT INTO `TB_SRE` VALUES ('1', '3', '-6.371856', '107.381817', '2013-09-05', '1500', '0');
INSERT INTO `TB_SRE` VALUES ('2', '1', '-6.260697', '107.337584', '2013-09-04', '1505', '0');
INSERT INTO `TB_SRE` VALUES ('3', '2', '-6.257285', '107.315628', '2013-09-05', '1000', '0');
INSERT INTO `TB_SRE` VALUES ('4', '4', '-6.328863', '107.332636', '1990-01-01', '1500', '0');
INSERT INTO `TB_SRE` VALUES ('5', '5', '-6.361023', '107.310226', '1990-01-01', '1500', '0');
INSERT INTO `TB_SRE` VALUES ('6', '6', '-6.379703', '107.327829', '1990-01-01', '1500', '0');
INSERT INTO `TB_SRE` VALUES ('7', '11', '-6.357099', '107.280781', '1950-01-01', '1500', '0');
