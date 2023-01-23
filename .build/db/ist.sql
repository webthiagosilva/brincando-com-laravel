/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE `ist`;
USE `ist`;

# Dump of table pessoas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pessoas`;

CREATE TABLE `pessoas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL DEFAULT '',
  `cpf` varchar(11) NOT NULL DEFAULT '',
  `endereco` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `pessoas` WRITE;
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;

INSERT INTO `pessoas` (`id`, `nome`, `cpf`, `endereco`)
VALUES
 (1, 'Marcelo Ramos', '48349778032', 'Rua Luiz Demo, n 120, Bairro Passagem, Tubarão/SC'),
 (2, 'Renato Silva', '76537136024', 'Rua Alexandre de Sá, n 98, Bairro Dehon, Tubarão/SC'),
 (3, 'Maria Cordeiro', '01054804010', 'Rua Júlio Pozza, n 450, Bairro São João, Tubarão/SC');

/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table contas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contas`;

CREATE TABLE `contas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) unsigned NOT NULL,
  `numero` varchar(20) NOT NULL DEFAULT '',
  `saldo` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `FK_contas_pessoas` (`id_pessoa`),
    CONSTRAINT `FK_contas_pessoas` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `contas` WRITE;
/*!40000 ALTER TABLE `contas` DISABLE KEYS */;

INSERT INTO `contas` (`id`, `id_pessoa`, `numero`, `saldo`)
VALUES
 (1, 1, '123456', 1000.00),
 (2, 2, '654321', 2000.00),
 (3, 3, '987654', 3000.00);

/*!40000 ALTER TABLE `contas` ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table movimentacoes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movimentacoes`;

CREATE TABLE `movimentacoes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_conta` int(11) unsigned NOT NULL,
  `data` date NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tipo` enum('D','C') NOT NULL DEFAULT 'D',
  PRIMARY KEY (`id`),
  KEY `FK_movimentacoes_contas` (`id_conta`),
    CONSTRAINT `FK_movimentacoes_contas` FOREIGN KEY (`id_conta`) REFERENCES `contas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `movimentacoes` WRITE;
/*!40000 ALTER TABLE `movimentacoes` DISABLE KEYS */;

INSERT INTO `movimentacoes` (`id`, `id_conta`, `data`, `valor`, `tipo`)
VALUES
 (1, 1, '2016-01-01', 100.00, 'D'),
 (2, 1, '2016-01-02', 200.00, 'C'),
 (3, 1, '2016-01-03', 300.00, 'D'),
 (4, 2, '2016-01-01', 100.00, 'D'),
 (5, 2, '2016-01-02', 200.00, 'C'),
 (6, 2, '2016-01-03', 300.00, 'D'),
 (7, 3, '2016-01-01', 100.00, 'D'),
 (8, 3, '2016-01-02', 200.00, 'C'),
 (9, 3, '2016-01-03', 300.00, 'D');

/*!40000 ALTER TABLE `movimentacoes` ENABLE KEYS */;
UNLOCK TABLES;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
