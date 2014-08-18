SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `user_picture`;

CREATE TABLE IF NOT EXISTS `user_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `active` enum('1','0') NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `user_picture`
(`id`, `path`, `description`, `active`)
VALUES
(1, 'assets/dashboard/img/profiles/face-1.png', '', '1'),
(2, 'assets/dashboard/img/profiles/face-2.jpg', '', '1'),
(3, 'assets/dashboard/img/profiles/face-3.png', '', '1'),
(4, 'assets/dashboard/img/profiles/face-4.png', '', '1'),
(5, 'assets/dashboard/img/profiles/face-5.jpg', '', '1'),
(6, 'assets/dashboard/img/profiles/face-6.jpg', '', '1'),
(7, 'assets/dashboard/img/profiles/face-7.png', '', '1'),
(8, 'assets/dashboard/img/profiles/face-8.jpg', '', '1'),
(9, 'assets/dashboard/img/profiles/face-9.png', '', '1');

DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `society` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profilePicture` varchar(255) DEFAULT NULL,
  `datetime` date DEFAULT NULL,
  `admin` enum('1','0') NOT NULL,
  `active` enum('1','0') NOT NULL,
  `picture` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`email`, `password`, `active`),
  CONSTRAINT FOREIGN KEY (`picture`) REFERENCES `user_picture`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `user`
(`id`, `firstname`, `lastname`, `username`, `email`, `password`, `society`, `address`, `datetime`, `admin`, `active`, `picture`)
VALUES
(1, 'Gabriel', 'Malet', 'UbikZ', 'gabrielmalet@gmail.com', '2de4a995b7b50c2535f89e4472ba906789929976', 'Galilée', '415, 71th/5th Street, NYC', '2014-08-02', '1', '1', 1),
(2, 'Firstname', 'Lastname', 'GuestUser', 'user@user.com', '2de4a995b7b50c2535f89e4472ba906789929976', 'Galilée', '21, 39th/5th Street, NYC', '2014-08-13', '0', '1', 1);

DROP TABLE IF EXISTS `user_wall_message`;

CREATE TABLE IF NOT EXISTS `user_wall_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMessageSrc` int(11) DEFAULT NULL,
  `idUserSrc` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`idMessageSrc`) REFERENCES `user_wall_message`(`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`idUserSrc`) REFERENCES `user`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

DROP TABLE IF EXISTS `user_wall`;

CREATE TABLE IF NOT EXISTS  `user_wall` (
  `idUser` int(11) NOT NULL,
  `idMessage` int(11) DEFAULT NULL,
  `active` enum('1', '0') NOT NULL,
  CONSTRAINT FOREIGN KEY (`idUser`) REFERENCES `user`(`id`),
  CONSTRAINT FOREIGN KEY (`idMessage`) REFERENCES `user_wall_message`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

SET FOREIGN_KEY_CHECKS=1;