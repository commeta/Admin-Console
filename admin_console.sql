-- MySQL dump 10.14  Distrib 5.5.64-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: dev_admin_console
-- ------------------------------------------------------
-- Server version	5.5.64-MariaDB

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
-- Table structure for table `md_meta`
--

DROP TABLE IF EXISTS `md_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_meta` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `friendly_url` varchar(256) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_h1` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_text` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `friendly_url` (`friendly_url`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_meta`
--

LOCK TABLES `md_meta` WRITE;
/*!40000 ALTER TABLE `md_meta` DISABLE KEYS */;
INSERT INTO `md_meta` VALUES (1,'/index.html','Главная','Главная','Главная','Главная','Главная','<p>Главная content</p>','undefined'),(7,'/price.html','Прайс','Прайс','','','','<p>Но базовый вектор развития способствует повышению качества системы обучения кадров, соответствующей насущным потребностям. Господа, высококачественный прототип будущего проекта создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса системы массового участия. Кстати, некоторые особенности внутренней политики, вне зависимости от их уровня, должны быть подвергнуты целой серии независимых исследований.</p><p>Противоположная точка зрения подразумевает, что тщательные исследования конкурентов освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, функционально разнесены на независимые элементы! Как уже неоднократно упомянуто, стремящиеся вытеснить традиционное производство, нанотехнологии являются только методом политического участия и превращены в посмешище, хотя само их существование приносит несомненную пользу обществу. Противоположная точка зрения подразумевает, что явные признаки победы институционализации, которые представляют собой яркий пример континентально-европейского типа политической культуры, будут указаны как претенденты на роль ключевых факторов. Кстати, независимые государства, превозмогая сложившуюся непростую экономическую ситуацию, объединены в целые кластеры себе подобных. Противоположная точка зрения подразумевает, что многие известные личности могут быть преданы социально-демократической анафеме.</p><p>Кстати, ключевые особенности структуры проекта являются только методом политического участия и объективно рассмотрены соответствующими инстанциями. В своём стремлении повысить качество жизни, они забывают, что сложившаяся структура организации в значительной степени обусловливает важность системы обучения кадров, соответствующей насущным потребностям. Но дальнейшее развитие различных форм деятельности в значительной степени обусловливает важность направлений прогрессивного развития. Имеется спорная точка зрения, гласящая примерно следующее: реплицированные с зарубежных источников, современные исследования формируют глобальную экономическую сеть и при этом - объявлены нарушающими общечеловеческие нормы этики и морали. Прежде всего, сложившаяся структура организации, а также свежий взгляд на привычные вещи - безусловно открывает новые горизонты для экономической целесообразности принимаемых решений.</p><p>В частности, укрепление и развитие внутренней структуры однозначно фиксирует необходимость новых принципов формирования материально-технической и кадровой базы. А также интерактивные прототипы лишь добавляют фракционных разногласий и ассоциативно распределены по отраслям. А также некоторые особенности внутренней политики неоднозначны и будут заблокированы в рамках своих собственных рациональных ограничений. Как уже неоднократно упомянуто, базовые сценарии поведения пользователей набирают популярность среди определенных слоев населения, а значит, должны быть обнародованы.</p><p>В рамках спецификации современных стандартов, базовые сценарии поведения пользователей представляют собой не что иное, как квинтэссенцию победы маркетинга над разумом и должны быть рассмотрены исключительно в разрезе маркетинговых и финансовых предпосылок. Таким образом, глубокий уровень погружения напрямую зависит от кластеризации усилий. А ещё базовые сценарии поведения пользователей могут быть заблокированы в рамках своих собственных рациональных ограничений. Есть над чем задуматься: реплицированные с зарубежных источников, современные исследования могут быть обнародованы. В целом, конечно, постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании системы массового участия. Банальные, но неопровержимые выводы, а также акционеры крупнейших компаний призывают нас к новым свершениям, которые, в свою очередь, должны быть указаны как претенденты на роль ключевых факторов.</p>','undefined');
/*!40000 ALTER TABLE `md_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `md_users`
--

DROP TABLE IF EXISTS `md_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL COMMENT '0 - пользователь, 1 - админ',
  `login` varchar(255) NOT NULL COMMENT 'E-mail',
  `password` varchar(255) NOT NULL,
  `reg_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `gender` int(1) NOT NULL COMMENT '0 - не указан, 1 - М, 2 - Ж',
  `birthday` date NOT NULL,
  `phone` varchar(255) NOT NULL,
  `photo_url` varchar(500) NOT NULL,
  `news_check` int(1) NOT NULL COMMENT 'Согласие на получение рассылки',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_users`
--

LOCK TABLES `md_users` WRITE;
/*!40000 ALTER TABLE `md_users` DISABLE KEYS */;
INSERT INTO `md_users` VALUES (1,1,'admin','5f4dcc3b5aa765d61d8327deb882cf99','2020-02-15 01:59:13','Администратор','','',0,'1981-11-09','','files/user_upload/photo-10.jpg',0);
/*!40000 ALTER TABLE `md_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `md_users_login`
--

DROP TABLE IF EXISTS `md_users_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_users_login` (
  `user_login_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `login_ip` varchar(255) NOT NULL,
  `login_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xauthtoken` varchar(255) NOT NULL,
  PRIMARY KEY (`user_login_id`),
  KEY `user_id` (`user_id`),
  KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_users_login`
--

LOCK TABLES `md_users_login` WRITE;
/*!40000 ALTER TABLE `md_users_login` DISABLE KEYS */;
INSERT INTO `md_users_login` VALUES (5,1,'','178.130.37.64','2020-04-14 01:27:34','4bfe15be794c74e657adaf0bdddf3c1f44da90b1ace558a363bc688fe7cc8df2'),(9,1,'','178.130.37.64','2020-04-14 13:37:12','4403e3fa5465929ca38ff4011acb75188cb9988d3adf8cad42e5e5d592c374f6'),(7,1,'','178.130.37.64','2020-04-14 12:53:57','4a141f1d0446fef14f48d30f3849a2ef9a724eeb7ad29c34b28b2c76bc73c756'),(10,1,'','178.130.37.64','2020-04-14 14:28:11','74caf7d8e1a0113e06841aeec7e58f0a561d797677f33af1c40bc79b4b1b560e'),(11,1,'','178.130.37.64','2020-04-14 14:29:00','8b6e88b8110491f40adc02f41582af77ba24f59ecdd7a3074bb47b2a631a0e30');
/*!40000 ALTER TABLE `md_users_login` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-14 18:43:46
