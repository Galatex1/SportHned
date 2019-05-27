

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `verified` tinyint(4) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idu_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;

INSERT INTO `users` VALUES (2,'Galatex','Dejv','gTex@example.com','$2y$10$nw3F9TF90eG...ITybbgAur207ANG3MLjYc9EaTXUhomFPeVdd25y',1,'2019-05-24 10:46:45'),(4,'David','Galatex','galatex1@example.com','$2y$10$VoRCyAT7vMuhMvsdeu0bwOAabAMckukEF99XxGc.C78mxO461614q',1,'2019-05-24 12:13:28'),(5,'David','Galatex','galatex@example.com','$2y$10$odWqncYZbF.6oN0fLMiNEumZXx6VjtLcS3ykVaKgLrXrusRO.qumG',0,'2019-05-24 12:17:08'),(9,'David','Minařík','galatex2@seznam.cz','$2y$10$Xg0qaOm7zkgF2vu4aiELv.y9XnMVbEZ1kEpOnw8LipxgHCYzur8lC',0,'2019-05-27 08:39:30'),(10,'David','Minařík','galatex@seznam.cz','$2y$10$TEKvhQ.YVvLQYThdiWdWT.dkGTN9mXVHF/uDBMF5LdfxzpTHFREwq',0,'2019-05-27 08:42:46');

UNLOCK TABLES;



