-- =============================================
-- StockHub Database Schema (Cloud Compatible)
-- Kompatibel dengan MySQL 8.0+ / TiDB / Aiven
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Table: stock (Data Barang)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `stock` (
  `idbarang` int(11) NOT NULL AUTO_INCREMENT,
  `namabarang` varchar(50) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: login (Data Admin)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `login` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin account
INSERT INTO `login` (`email`, `password`) VALUES
('admin@stockhub.com', 'admin123');

-- --------------------------------------------------------
-- Table: masuk (Barang Masuk)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `masuk` (
  `idmasuk` int(11) NOT NULL AUTO_INCREMENT,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`idmasuk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: keluar (Barang Keluar)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `keluar` (
  `idkeluar` int(11) NOT NULL AUTO_INCREMENT,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `penerima` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`idkeluar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
