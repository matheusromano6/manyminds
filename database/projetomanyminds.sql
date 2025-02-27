CREATE DATABASE  IF NOT EXISTS `projetomanyminds` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `projetomanyminds`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: projetomanyminds
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `enderecos_colaboradores`
--

DROP TABLE IF EXISTS `enderecos_colaboradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enderecos_colaboradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `colaborador_id` int(11) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `padrao` enum('sim','nao') NOT NULL DEFAULT 'nao',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `colaborador_id` (`colaborador_id`),
  CONSTRAINT `enderecos_colaboradores_ibfk_1` FOREIGN KEY (`colaborador_id`) REFERENCES `usuarios_colaboradores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enderecos_colaboradores`
--

LOCK TABLES `enderecos_colaboradores` WRITE;
/*!40000 ALTER TABLE `enderecos_colaboradores` DISABLE KEYS */;
/*!40000 ALTER TABLE `enderecos_colaboradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistema_logs`
--

DROP TABLE IF EXISTS `sistema_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sistema_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` enum('login','logout','login_bloqueado','usuario_cadastro','usuario_edicao','usuario_inativacao','usuario_ativacao','colaborador_listar','colaborador_cadastro','colaborador_edicao','colaborador_exclusao','colaborador_inativacao','colaborador_ativacao','colaborador_acessar','colaborador_alterar_status','endereco_listar','endereco_cadastro','endereco_edicao','endereco_exclusao','endereco_inativacao','endereco_salvar','endereco_atualizar','log_listar','colaborador_atualizacao') NOT NULL,
  `acao` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `executado_por` varchar(50) NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistema_logs`
--

LOCK TABLES `sistema_logs` WRITE;
/*!40000 ALTER TABLE `sistema_logs` DISABLE KEYS */;
INSERT INTO `sistema_logs` VALUES (1,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 15:57:50'),(2,'colaborador_acessar','Acessou tela de cadastro','','matheusromano','success','::1','2025-02-27 15:57:52'),(3,'colaborador_acessar','Acessou tela de cadastro','','matheusromano','success','::1','2025-02-27 16:00:10'),(4,'colaborador_cadastro','Colaborador cadastrado','41','matheusromano','success','::1','2025-02-27 16:00:29'),(5,'colaborador_edicao','Acessou tela de edição','41','matheusromano','success','::1','2025-02-27 16:00:29'),(6,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:00:31'),(7,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:00:49'),(8,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:00:50'),(9,'colaborador_acessar','Acessou tela de cadastro','','matheusromano','success','::1','2025-02-27 16:00:51'),(10,'','Erro: E-mail duplicado','A@A','matheusromano','failed','::1','2025-02-27 16:01:20'),(11,'colaborador_acessar','Acessou tela de cadastro','','matheusromano','success','::1','2025-02-27 16:01:21'),(12,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:01:33'),(13,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:01:39'),(14,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:01:40'),(15,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:01:40'),(16,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:01:40'),(17,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:01:40'),(18,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:01:40'),(19,'colaborador_acessar','Acessou tela de cadastro','','matheusromano','success','::1','2025-02-27 16:01:42'),(20,'colaborador_cadastro','Colaborador cadastrado','42','matheusromano','success','::1','2025-02-27 16:01:55'),(21,'colaborador_edicao','Acessou tela de edição','42','matheusromano','success','::1','2025-02-27 16:01:55'),(22,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:01:57'),(23,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:02:13'),(24,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:02:14'),(25,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:02:14'),(26,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:02:14'),(27,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:02:15'),(28,'colaborador_acessar','Acessou tela de cadastro','','matheusromano','success','::1','2025-02-27 16:02:34'),(29,'colaborador_cadastro','Colaborador cadastrado','43','matheusromano','success','::1','2025-02-27 16:02:50'),(30,'colaborador_edicao','Acessou tela de edição','43','matheusromano','success','::1','2025-02-27 16:02:50'),(31,'endereco_salvar','Endereço cadastrado/atualizado','43','matheusromano','success','::1','2025-02-27 16:02:57'),(32,'colaborador_edicao','Acessou tela de edição','43','matheusromano','success','::1','2025-02-27 16:02:57'),(33,'endereco_salvar','Endereço cadastrado/atualizado','43','matheusromano','success','::1','2025-02-27 16:03:05'),(34,'colaborador_edicao','Acessou tela de edição','43','matheusromano','success','::1','2025-02-27 16:03:05'),(35,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:03:10'),(36,'colaborador_edicao','Acessou tela de edição','43','matheusromano','success','::1','2025-02-27 16:03:17'),(37,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:03:22'),(38,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:05:39'),(39,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:05:40'),(40,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:12:47'),(41,'login','Login bem-sucedido','matheusromano','matheusromano','success','::1','2025-02-27 16:12:57'),(42,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:13:08'),(43,'login','Senha incorreta','matheusromano','sistema','failed','::1','2025-02-27 16:13:22'),(44,'login','Senha incorreta','matheusromano','sistema','failed','::1','2025-02-27 16:13:27'),(45,'login','Senha incorreta','matheusromano','sistema','failed','::1','2025-02-27 16:13:31'),(46,'login','Login bem-sucedido','matheusromano','matheusromano','success','::1','2025-02-27 16:14:55'),(47,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:15:03'),(48,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:21:29'),(49,'colaborador_alterar_status','Status alterado','43','matheusromano','success','::1','2025-02-27 16:21:31'),(50,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:21:32'),(51,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 16:22:32'),(52,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 17:34:41'),(53,'colaborador_acessar','Acessou tela de cadastro','','matheusromano','success','::1','2025-02-27 17:34:43'),(54,'colaborador_cadastro','Colaborador cadastrado','44','matheusromano','success','::1','2025-02-27 17:34:59'),(55,'colaborador_edicao','Acessou tela de edição','44','matheusromano','success','::1','2025-02-27 17:34:59'),(56,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 17:35:02'),(57,'colaborador_listar','Listagem de colaboradores realizada','matheusromano','matheusromano','success','::1','2025-02-27 19:27:36');
/*!40000 ALTER TABLE `sistema_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `ip_locked` varchar(45) DEFAULT NULL,
  `lock_time` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `api_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_colaboradores`
--

DROP TABLE IF EXISTS `usuarios_colaboradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_colaboradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `cargo` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `data_admissao` date DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_colaboradores`
--

LOCK TABLES `usuarios_colaboradores` WRITE;
/*!40000 ALTER TABLE `usuarios_colaboradores` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_colaboradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'projetomanyminds'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-27 16:58:17
