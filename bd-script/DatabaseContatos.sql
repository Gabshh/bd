CREATE DATABASE  IF NOT EXISTS `database_contatos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `database_contatos`;
-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: database_contatos
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `table_contatos`
--

DROP TABLE IF EXISTS `table_contatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_contatos` (
  `id_contato` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  `celular` varchar(19) NOT NULL,
  `email` varchar(320) NOT NULL,
  `obs` text,
  PRIMARY KEY (`id_contato`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_contatos`
--

LOCK TABLES `table_contatos` WRITE;
/*!40000 ALTER TABLE `table_contatos` DISABLE KEYS */;
INSERT INTO `table_contatos` VALUES (1,'Schmebulock','(011)4772-4700','(011)97878-0666','schmebulock@gmail.com','i like trains'),(2,'Mabel','(011)4772-4700','(011)97878-0666','MabelPines@gmail.com','i like trains'),(5,'teste','47808066','11966686666','teste@gol.com','tessste'),(6,'globglogabgalab','47808066','11966686666','glublgub@gol.com','i am the globglogabgalab and i love books\r\nthe schwabble dwabble wabble gwabble flibba blabba blab\r\n\r\nschwabble dwabble glibble wabble schribble schwap glab\r\ndibble dabble schribble schrabble glibbi-glab schwap\r\n'),(7,'globglodgrob','47808066','11966686666','aimeuglob@gol.com','grodgrod\r\n'),(16,'Joe','703','10924719478','sayitaintsojoe@please.com','thats not what i thought joe'),(17,'Mike wazowski','47808066','1','mike@tyson.com',''),(18,'Bill Cipher','666666666','999999999','weirdageddon@gmail.com','deer teeth');
/*!40000 ALTER TABLE `table_contatos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-01 16:52:31
