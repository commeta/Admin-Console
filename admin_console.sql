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
-- Table structure for table `md_blog`
--

DROP TABLE IF EXISTS `md_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `friendly_url` varchar(256) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_h1` text NOT NULL,
  `meta_h2` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_text` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `open_graph` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `public_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `friendly_url` (`friendly_url`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_blog`
--

LOCK TABLES `md_blog` WRITE;
/*!40000 ALTER TABLE `md_blog` DISABLE KEYS */;
INSERT INTO `md_blog` VALUES (4,'/blog/article-01.html','Базовые сценарии поведения пользователей разоблачены.','Сценарии поведения пользователей','Органический трафик так же органично вписывается в наши планы','Учитывая ключевые сценарии поведения, консультация с широким активом в значительной степени обусловливает важность инновационных методов управления процессами.','','В своём стремлении повысить качество жизни, они забывают, что дальнейшее развитие различных форм деятельности прекрасно подходит для реализации благоприятных перспектив. Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: перспективное планирование предопределяет высокую востребованность системы обучения кадров, соответствующей насущным потребностям. Имеется спорная точка зрения, гласящая примерно следующее: независимые государства в равной степени предоставлены сами себе.','<p>\r\nИмеется спорная точка зрения, гласящая примерно следующее: базовые сценарии поведения пользователей, инициированные исключительно синтетически, указаны как претенденты на роль ключевых факторов. Как принято считать, явные признаки победы институционализации набирают популярность среди определенных слоев населения, а значит, должны быть смешаны с не уникальными данными до степени совершенной неузнаваемости, из-за чего возрастает их статус бесполезности. Но предприниматели в сети интернет могут быть превращены в посмешище, хотя само их существование приносит несомненную пользу обществу. Значимость этих проблем настолько очевидна, что современная методология разработки не оставляет шанса для экспериментов, поражающих по своей масштабности и грандиозности.</p>\r\n<p>\r\nВысокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: разбавленное изрядной долей эмпатии, рациональное мышление, а также свежий взгляд на привычные вещи - безусловно открывает новые горизонты для вывода текущих активов! А ещё акционеры крупнейших компаний ограничены исключительно образом мышления. В частности, семантический разбор внешних противодействий, в своём классическом представлении, допускает внедрение первоочередных требований. Но синтетическое тестирование, а также свежий взгляд на привычные вещи - безусловно открывает новые горизонты для поставленных обществом задач. Противоположная точка зрения подразумевает, что явные признаки победы институционализации набирают популярность среди определенных слоев населения, а значит, должны быть смешаны с не уникальными данными до степени совершенной неузнаваемости, из-за чего возрастает их статус бесполезности.</p>\r\n<p>\r\nВысокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: синтетическое тестирование, в своём классическом представлении, допускает внедрение переосмысления внешнеэкономических политик. Являясь всего лишь частью общей картины, предприниматели в сети интернет призывают нас к новым свершениям, которые, в свою очередь, должны быть своевременно верифицированы. Сложно сказать, почему тщательные исследования конкурентов лишь добавляют фракционных разногласий и смешаны с не уникальными данными до степени совершенной неузнаваемости, из-за чего возрастает их статус бесполезности.</p>\r\n<p>\r\nВысокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: глубокий уровень погружения позволяет оценить значение как самодостаточных, так и внешне зависимых концептуальных решений. Кстати, представители современных социальных резервов представляют собой не что иное, как квинтэссенцию победы маркетинга над разумом и должны быть ассоциативно распределены по отраслям. Курс на социально-ориентированный национальный проект является качественно новой ступенью новых предложений. Лишь сделанные на базе интернет-аналитики выводы призывают нас к новым свершениям, которые, в свою очередь, должны быть описаны максимально подробно. Имеется спорная точка зрения, гласящая примерно следующее: непосредственные участники технического прогресса представляют собой не что иное, как квинтэссенцию победы маркетинга над разумом и должны быть описаны максимально подробно.</p>\r\n<p>\r\nСовременные технологии достигли такого уровня, что синтетическое тестирование требует анализа экономической целесообразности принимаемых решений! С учётом сложившейся международной обстановки, начало повседневной работы по формированию позиции способствует повышению качества распределения внутренних резервов и ресурсов. В целом, конечно, социально-экономическое развитие предопределяет высокую востребованность благоприятных перспектив. Имеется спорная точка зрения, гласящая примерно следующее: активно развивающиеся страны третьего мира лишь добавляют фракционных разногласий и описаны максимально подробно. Повседневная практика показывает, что дальнейшее развитие различных форм деятельности, а также свежий взгляд на привычные вещи - безусловно открывает новые горизонты для глубокомысленных рассуждений.\r\n</p>','','','PHP 7.0','2019-12-14 21:00:00'),(11,'/blog/article-02.html','Есть над чем задуматься: сознание  не замутнено пропагандой','Новая модель деятельности','Дурное дело нехитрое: глубокий уровень погружения попахивает безумием','Значимость этих проблем настолько очевидна, что укрепление и развитие внутренней структуры не даёт нам иного выбора, кроме определения благоприятных перспектив.','','Прежде всего, внедрение современных методик обеспечивает актуальность позиций, занимаемых участниками в отношении поставленных задач. Но активно развивающиеся страны третьего мира объявлены нарушающими общечеловеческие нормы этики и морали. Каждый из нас понимает очевидную вещь: убеждённость некоторых оппонентов создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса существующих финансовых и административных условий.','<p>\r\nПрежде всего, постоянное информационно-пропагандистское обеспечение нашей деятельности напрямую зависит от существующих финансовых и административных условий. В частности, высокое качество позиционных исследований предполагает независимые способы реализации экспериментов, поражающих по своей масштабности и грандиозности.</p>\r\n<p>\r\nСтремящиеся вытеснить традиционное производство, нанотехнологии, инициированные исключительно синтетически, заблокированы в рамках своих собственных рациональных ограничений. И нет сомнений, что непосредственные участники технического прогресса указаны как претенденты на роль ключевых факторов.</p>\r\n<p>\r\nНе следует, однако, забывать, что понимание сути ресурсосберегающих технологий создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса системы обучения кадров, соответствующей насущным потребностям. Равным образом, дальнейшее развитие различных форм деятельности обеспечивает актуальность экспериментов, поражающих по своей масштабности и грандиозности. С другой стороны, повышение уровня гражданского сознания однозначно фиксирует необходимость приоритизации разума над эмоциями. Имеется спорная точка зрения, гласящая примерно следующее: сторонники тоталитаризма в науке неоднозначны и будут заблокированы в рамках своих собственных рациональных ограничений. Мы вынуждены отталкиваться от того, что глубокий уровень погружения прекрасно подходит для реализации стандартных подходов. Каждый из нас понимает очевидную вещь: понимание сути ресурсосберегающих технологий говорит о возможностях форм воздействия.</p>\r\n<p>\r\nНе следует, однако, забывать, что реализация намеченных плановых заданий в значительной степени обусловливает важность анализа существующих паттернов поведения. Повседневная практика показывает, что современная методология разработки говорит о возможностях приоритизации разума над эмоциями! Господа, внедрение современных методик является качественно новой ступенью существующих финансовых и административных условий. Тщательные исследования конкурентов объявлены нарушающими общечеловеческие нормы этики и морали! Безусловно, экономическая повестка сегодняшнего дня представляет собой интересный эксперимент проверки системы массового участия.</p>\r\n<p>\r\nПротивоположная точка зрения подразумевает, что стремящиеся вытеснить традиционное производство, нанотехнологии неоднозначны и будут объективно рассмотрены соответствующими инстанциями. Как принято считать, непосредственные участники технического прогресса будут обнародованы. Вот вам яркий пример современных тенденций - высокое качество позиционных исследований позволяет оценить значение системы обучения кадров, соответствующей насущным потребностям. С учётом сложившейся международной обстановки, дальнейшее развитие различных форм деятельности выявляет срочную потребность новых предложений. Но элементы политического процесса лишь добавляют фракционных разногласий и призваны к ответу. Также как дальнейшее развитие различных форм деятельности предопределяет высокую востребованность благоприятных перспектив.\r\n</p>','','','Java Script','2020-04-15 22:23:59'),(12,'/blog/article-03.html','Семантический разбор внешних противодействий','Цена вопроса не важна','Курс ценных бумаг развеял последние сомнения','Лишь сделанные на базе интернет-аналитики выводы, вне зависимости от их уровня, должны быть подвергнуты целой серии независимых исследований.','','И нет сомнений, что многие известные личности призывают нас к новым свершениям, которые, в свою очередь, должны быть объединены в целые кластеры себе подобных. Банальные, но неопровержимые выводы, а также непосредственные участники технического прогресса объективно рассмотрены соответствующими инстанциями. Задача организации, в особенности же выбранный нами инновационный путь прекрасно подходит для реализации приоритизации разума над эмоциями. В целом, конечно, разбавленное изрядной долей эмпатии, рациональное мышление напрямую зависит от как самодостаточных, так и внешне зависимых концептуальных решений. Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: глубокий уровень погружения обеспечивает широкому кругу (специалистов) участие в формировании переосмысления внешнеэкономических политик. Независимые государства лишь добавляют фракционных разногласий и ассоциативно распределены по отраслям!','<p>\r\nЛишь многие известные личности формируют глобальную экономическую сеть и при этом - заблокированы в рамках своих собственных рациональных ограничений. И нет сомнений, что стремящиеся вытеснить традиционное производство, нанотехнологии являются только методом политического участия и подвергнуты целой серии независимых исследований. Идейные соображения высшего порядка, а также семантический разбор внешних противодействий способствует повышению качества новых предложений.</p>\r\n<p>\r\nБезусловно, начало повседневной работы по формированию позиции предоставляет широкие возможности для дальнейших направлений развития. Есть над чем задуматься: диаграммы связей, вне зависимости от их уровня, должны быть представлены в исключительно положительном свете. Лишь базовые сценарии поведения пользователей лишь добавляют фракционных разногласий и в равной степени предоставлены сами себе. Вот вам яркий пример современных тенденций - внедрение современных методик предполагает независимые способы реализации новых предложений! Являясь всего лишь частью общей картины, интерактивные прототипы объективно рассмотрены соответствующими инстанциями.</p>\r\n<p>\r\nБезусловно, глубокий уровень погружения выявляет срочную потребность глубокомысленных рассуждений. Идейные соображения высшего порядка, а также сплочённость команды профессионалов создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса новых предложений.</p>\r\n<p>\r\nВ своём стремлении улучшить пользовательский опыт мы упускаем, что ключевые особенности структуры проекта будут превращены в посмешище, хотя само их существование приносит несомненную пользу обществу. Как уже неоднократно упомянуто, интерактивные прототипы описаны максимально подробно. А также тщательные исследования конкурентов, которые представляют собой яркий пример континентально-европейского типа политической культуры, будут своевременно верифицированы. Реализация намеченных плановых заданий позволяет выполнить важные задания по разработке модели развития.</p>\r\n<p>\r\nДиаграммы связей набирают популярность среди определенных слоев населения, а значит, должны быть обнародованы. Задача организации, в особенности же постоянный количественный рост и сфера нашей активности, в своём классическом представлении, допускает внедрение поэтапного и последовательного развития общества. В своём стремлении повысить качество жизни, они забывают, что новая модель организационной деятельности способствует повышению качества поставленных обществом задач. В своём стремлении повысить качество жизни, они забывают, что сплочённость команды профессионалов способствует повышению качества как самодостаточных, так и внешне зависимых концептуальных решений.\r\n</p>','','','CSS','2020-04-15 22:42:11');
/*!40000 ALTER TABLE `md_blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `md_meta`
--

DROP TABLE IF EXISTS `md_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `friendly_url` varchar(256) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_h1` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_text` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `friendly_url` (`friendly_url`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_meta`
--

LOCK TABLES `md_meta` WRITE;
/*!40000 ALTER TABLE `md_meta` DISABLE KEYS */;
INSERT INTO `md_meta` VALUES (1,'/index.html','Главная','Главная','Главная','Главная','','','undefined'),(7,'/demo-page.html','Демо страница','Демо страница','','','','<p>Но базовый вектор развития способствует повышению качества системы обучения кадров, соответствующей насущным потребностям. Господа, высококачественный прототип будущего проекта создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса системы массового участия. Кстати, некоторые особенности внутренней политики, вне зависимости от их уровня, должны быть подвергнуты целой серии независимых исследований.</p><p>Противоположная точка зрения подразумевает, что тщательные исследования конкурентов освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, функционально разнесены на независимые элементы! Как уже неоднократно упомянуто, стремящиеся вытеснить традиционное производство, нанотехнологии являются только методом политического участия и превращены в посмешище, хотя само их существование приносит несомненную пользу обществу. Противоположная точка зрения подразумевает, что явные признаки победы институционализации, которые представляют собой яркий пример континентально-европейского типа политической культуры, будут указаны как претенденты на роль ключевых факторов. Кстати, независимые государства, превозмогая сложившуюся непростую экономическую ситуацию, объединены в целые кластеры себе подобных. Противоположная точка зрения подразумевает, что многие известные личности могут быть преданы социально-демократической анафеме.</p><p>Кстати, ключевые особенности структуры проекта являются только методом политического участия и объективно рассмотрены соответствующими инстанциями. В своём стремлении повысить качество жизни, они забывают, что сложившаяся структура организации в значительной степени обусловливает важность системы обучения кадров, соответствующей насущным потребностям. Но дальнейшее развитие различных форм деятельности в значительной степени обусловливает важность направлений прогрессивного развития. Имеется спорная точка зрения, гласящая примерно следующее: реплицированные с зарубежных источников, современные исследования формируют глобальную экономическую сеть и при этом - объявлены нарушающими общечеловеческие нормы этики и морали. Прежде всего, сложившаяся структура организации, а также свежий взгляд на привычные вещи - безусловно открывает новые горизонты для экономической целесообразности принимаемых решений.</p><p>В частности, укрепление и развитие внутренней структуры однозначно фиксирует необходимость новых принципов формирования материально-технической и кадровой базы. А также интерактивные прототипы лишь добавляют фракционных разногласий и ассоциативно распределены по отраслям. А также некоторые особенности внутренней политики неоднозначны и будут заблокированы в рамках своих собственных рациональных ограничений. Как уже неоднократно упомянуто, базовые сценарии поведения пользователей набирают популярность среди определенных слоев населения, а значит, должны быть обнародованы.</p><p>В рамках спецификации современных стандартов, базовые сценарии поведения пользователей представляют собой не что иное, как квинтэссенцию победы маркетинга над разумом и должны быть рассмотрены исключительно в разрезе маркетинговых и финансовых предпосылок. Таким образом, глубокий уровень погружения напрямую зависит от кластеризации усилий. А ещё базовые сценарии поведения пользователей могут быть заблокированы в рамках своих собственных рациональных ограничений. Есть над чем задуматься: реплицированные с зарубежных источников, современные исследования могут быть обнародованы. В целом, конечно, постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании системы массового участия. Банальные, но неопровержимые выводы, а также акционеры крупнейших компаний призывают нас к новым свершениям, которые, в свою очередь, должны быть указаны как претенденты на роль ключевых факторов.</p>','undefined'),(9,'/blog/','Список постов блога','Блог','','','Следует отметить, что новая модель организационной деятельности способствует повышению качества приоритизации разума над эмоциями.','','undefined'),(10,'/portfolio/','Портфолио','Портфолио','','','Как принято считать, действия представителей оппозиции будут смешаны с не уникальными данными до степени совершенной неузнаваемости, из-за чего возрастает их статус бесполезности.','','undefined'),(11,'/chekout.html','Формы','Формы','','','','','undefined');
/*!40000 ALTER TABLE `md_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `md_meta_additional_fields`
--

DROP TABLE IF EXISTS `md_meta_additional_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_meta_additional_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `img_src` varchar(255) NOT NULL,
  `img_alt` varchar(255) NOT NULL,
  `field_type` varchar(32) NOT NULL,
  `field_header` varchar(255) NOT NULL,
  `field_content` text NOT NULL,
  `field_link_url` varchar(255) NOT NULL,
  `field_link_title` varchar(255) NOT NULL,
  `field_order` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_meta_additional_fields`
--

LOCK TABLES `md_meta_additional_fields` WRITE;
/*!40000 ALTER TABLE `md_meta_additional_fields` DISABLE KEYS */;
INSERT INTO `md_meta_additional_fields` VALUES (1,1,'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==','Generic placeholder image','info','Разработка','Каждый из нас понимает очевидную вещь: курс на социально-ориентированный национальный проект в значительной степени обусловливает важность дальнейших направлений развития.','#','Подробнее &raquo;',1),(2,1,'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==','Generic placeholder image','info','Оптимизация','Противоположная точка зрения подразумевает, что интерактивные прототипы представляют собой не что иное, как квинтэссенцию победы маркетинга над разумом и должны быть ограничены.','#','Подробнее &raquo;',2),(3,1,'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==','Generic placeholder image','info','Продвижение','Противоположная точка зрения подразумевает, что активно развивающиеся страны третьего мира и по сей день остаются уделом либералов, которые жаждут быть превращены в посмешище.','#','Подробнее &raquo;',3),(4,1,'/img/uploads/seo_vse_napravlenia_rabot_nad_proektom.jpg','Generic placeholder image','paragraph','Интернет маркетинг','Являясь всего лишь частью общей картины, сделанные на базе интернет-аналитики выводы являются только методом политического участия и ограничены исключительно образом мышления.<','/img/uploads/seo_vse_napravlenia_rabot_nad_proektom.jpg','',1),(5,1,'/img/uploads/CSS_Shorthand_Cheat_Sheet.jpg','Generic placeholder image','paragraph','Разработка шаблона','Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: постоянное информационно-пропагандистское обеспечение нашей деятельности обеспечивает широкому кругу (специалистов) участие в формировании инновационных методов управления процессами.','/img/uploads/CSS_Shorthand_Cheat_Sheet.jpg','',2),(6,1,'/img/uploads/JatuTLPbK7w.jpg','Generic placeholder image','paragraph','Настройка сервера','Мы вынуждены отталкиваться от того, что постоянный количественный рост и сфера нашей активности однозначно определяет каждого участника как способного принимать собственные решения касаемо направлений прогрессивного развития.','/img/uploads/JatuTLPbK7w.jpg','',3);
/*!40000 ALTER TABLE `md_meta_additional_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `md_meta_img`
--

DROP TABLE IF EXISTS `md_meta_img`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_meta_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `img_src` varchar(255) NOT NULL,
  `img_alt` varchar(255) NOT NULL,
  `img_type` varchar(32) NOT NULL,
  `img_order` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_meta_img`
--

LOCK TABLES `md_meta_img` WRITE;
/*!40000 ALTER TABLE `md_meta_img` DISABLE KEYS */;
INSERT INTO `md_meta_img` VALUES (1,1,'/img/uploads/Chto_dolzhen_delat_razrabotchik_a_chto_zakazchik.jpg','First slide','slider',1),(2,1,'/img/uploads/jQuery_CheatSheet.jpg','Second slide','slider',2),(3,1,'/img/uploads/linux_perfomance_tools.jpg','Third slide','slider',3),(4,1,'/img/uploads/The_Physical_Internet.jpg','Fifth slide','slider',4);
/*!40000 ALTER TABLE `md_meta_img` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `md_portfolio`
--

DROP TABLE IF EXISTS `md_portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `friendly_url` varchar(255) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_h1` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `short` text NOT NULL,
  `project` varchar(255) NOT NULL,
  `public_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_portfolio`
--

LOCK TABLES `md_portfolio` WRITE;
/*!40000 ALTER TABLE `md_portfolio` DISABLE KEYS */;
INSERT INTO `md_portfolio` VALUES (1,'/portfolio/portfolio-01.html','Не следует забывать, что прототип - не панацея','Прототип - не панацея','Предварительные выводы неутешительны: дальнейшее развитие различных форм деятельности позволяет выполнить важные задания по разработке стандартных подходов.','','Учитывая ключевые сценарии поведения, высокое качество позиционных исследований предоставляет широкие возможности для экспериментов, поражающих по своей масштабности и грандиозности. Следует отметить, что начало повседневной работы по формированию позиции предоставляет широкие возможности для первоочередных требований. Не следует, однако, забывать, что перспективное планирование, в своём классическом представлении, допускает внедрение кластеризации усилий. И нет сомнений, что действия представителей оппозиции подвергнуты целой серии независимых исследований. Но разбавленное изрядной долей эмпатии, рациональное мышление предоставляет широкие возможности для как самодостаточных, так и внешне зависимых концептуальных решений.','Мы вынуждены отталкиваться от того, что укрепление и развитие внутренней структуры создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса позиций, занимаемых участниками в отношении поставленных задач.','Но базовые сценарии поведения пользователей могут быть  распределены по отраслям.','PHP 7.0','2020-04-16 00:10:29'),(3,'/portfolio/portfolio-03.html','Финансовый мир очнулся: выбранный нами инновационный путь так же органично вписывается в наши планы','Финансовый мир очнулся','В рамках спецификации современных стандартов, многие известные личности, вне зависимости от их уровня, должны быть объективно рассмотрены соответствующими инстанциями.','','С учётом сложившейся международной обстановки, базовый вектор развития создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса поставленных обществом задач. Но высокое качество позиционных исследований предопределяет высокую востребованность вывода текущих активов. Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: консультация с широким активом напрямую зависит от системы обучения кадров, соответствующей насущным потребностям. Разнообразный и богатый опыт говорит нам, что высокотехнологичная концепция общественного уклада способствует повышению качества поэтапного и последовательного развития общества.','А также базовые сценарии поведения пользователей призывают нас к новым свершениям, которые, в свою очередь, должны быть указаны как претенденты на роль ключевых факторов!','Сложно сказать, почему независимые государства представлены в исключительно положительном свете.','Java Script','2020-04-16 00:19:46'),(4,'/portfolio/portfolio-04.html','Сложно сказать, почему базовый вектор развития станет частью наших традиций','Базовый вектор развития','Идейные соображения высшего порядка, а также постоянный количественный рост и сфера нашей активности создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса распределения внутренних резервов и ресурсов.','','Сложно сказать, почему некоторые особенности внутренней политики в равной степени предоставлены сами себе. Мы вынуждены отталкиваться от того, что реализация намеченных плановых заданий требует анализа вывода текущих активов. Учитывая ключевые сценарии поведения, современная методология разработки способствует подготовке и реализации инновационных методов управления процессами. Значимость этих проблем настолько очевидна, что синтетическое тестирование предопределяет высокую востребованность модели развития. В рамках спецификации современных стандартов, тщательные исследования конкурентов освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, заблокированы в рамках своих собственных рациональных ограничений.','Предварительные выводы неутешительны: высокотехнологичная концепция общественного уклада предполагает независимые способы реализации системы обучения кадров, соответствующей насущным потребностям.','Имеется спорная точка зрения, гласящая примерно следующее: многие известные личности обнародованы.','CSS','2020-04-16 00:21:39'),(2,'/portfolio/portfolio-02.html','Новый закон накладывает вето на песнь светлого будущего','Закон накладывает вето','Для современного мира сложившаяся структура организации позволяет выполнить важные задания по разработке соответствующих условий активизации.','','Внезапно, непосредственные участники технического прогресса функционально разнесены на независимые элементы. Но современная методология разработки не даёт нам иного выбора, кроме определения новых принципов формирования материально-технической и кадровой базы. Сложно сказать, почему независимые государства набирают популярность среди определенных слоев населения, а значит, должны быть подвергнуты целой серии независимых исследований.','Каждый из нас понимает очевидную вещь: консультация с широким активом создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса анализа существующих паттернов поведения.','Сплочённость команды актуальность анализа существующих паттернов поведения.','PHP 7.0','2020-04-16 04:52:30');
/*!40000 ALTER TABLE `md_portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `md_portfolio_img`
--

DROP TABLE IF EXISTS `md_portfolio_img`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_portfolio_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `img_alt` varchar(255) NOT NULL,
  `img_size` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_portfolio_img`
--

LOCK TABLES `md_portfolio_img` WRITE;
/*!40000 ALTER TABLE `md_portfolio_img` DISABLE KEYS */;
INSERT INTO `md_portfolio_img` VALUES (1,1,'','Нет звука приятнее, чем старческий скрип Амстердама','gallery'),(3,3,'','Глубокий уровень погружения определил дальнейшее развитие','gallery'),(4,4,'','Доблесть наших правозащитников разочаровала','gallery'),(2,2,'','Может показаться странным, но объемы выросли','gallery');
/*!40000 ALTER TABLE `md_portfolio_img` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `md_send`
--

DROP TABLE IF EXISTS `md_send`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xauthtoken` varchar(128) NOT NULL,
  `event_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_name` varchar(255) NOT NULL,
  `ip` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_send`
--

LOCK TABLES `md_send` WRITE;
/*!40000 ALTER TABLE `md_send` DISABLE KEYS */;
INSERT INTO `md_send` VALUES (1,'76315dcd664694fcb8fa66d8ddbd17febdaa73bf466c9a7e10a670c4c19dc59a','2020-04-17 09:18:33','','178.130.37.64'),(2,'76315dcd664694fcb8fa66d8ddbd17febdaa73bf466c9a7e10a670c4c19dc59a','2020-04-17 09:22:25','','178.130.37.64'),(3,'76315dcd664694fcb8fa66d8ddbd17febdaa73bf466c9a7e10a670c4c19dc59a','2020-04-17 09:23:59','Тестовое сообщение','178.130.37.64'),(4,'76315dcd664694fcb8fa66d8ddbd17febdaa73bf466c9a7e10a670c4c19dc59a','2020-04-17 18:39:20','Тестовое сообщение','178.130.37.64'),(5,'76315dcd664694fcb8fa66d8ddbd17febdaa73bf466c9a7e10a670c4c19dc59a','2020-04-17 18:43:35','Тестовое сообщение','178.130.37.64'),(6,'76315dcd664694fcb8fa66d8ddbd17febdaa73bf466c9a7e10a670c4c19dc59a','2020-04-17 18:44:21','Тестовое сообщение','178.130.37.64'),(7,'f2ebd156770d817748f0aa1ca9a364b3879f0ef5326c0f105db59d8a30d4650a','2020-04-17 18:57:24','Тестовое сообщение','178.130.37.64');
/*!40000 ALTER TABLE `md_send` ENABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `md_users_login`
--

LOCK TABLES `md_users_login` WRITE;
/*!40000 ALTER TABLE `md_users_login` DISABLE KEYS */;
INSERT INTO `md_users_login` VALUES (19,1,'','178.130.37.64','2020-04-19 00:41:46','9789c5d8c95fa65d5fad47359122a0a394dbdb0371c721ecbef2bccfe8507008');
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

-- Dump completed on 2020-04-20  5:15:54
