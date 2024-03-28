

DROP TABLE IF EXISTS `crud_users`;
CREATE TABLE `crud_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `crud_users` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `subscribers` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `boxs`;
CREATE TABLE `boxs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `prayerzone` varchar(100) NOT NULL,
  `subscriber_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`subscriber_id`) REFERENCES `subscribers` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `boxs` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS 'songs';
CREATE TABLE `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `subscriber_id` int(11) NOT NULL,
  `box_id` int(11) NOT NULL,
  `prayerzone` varchar(100) NOT NULL,
  `prayertimedate` date NOT NULL,
  `prayertimeseq` int(11) NOT NULL,
  `prayertime` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`box_id`) REFERENCES `boxs` (`id`),
  FOREIGN KEY (`subscriber_id`) REFERENCES `subscribers` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `songs` WRITE;
UNLOCK TABLES;
