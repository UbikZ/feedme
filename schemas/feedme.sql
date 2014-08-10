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
(`path`, `description`, `active`)
VALUES
('assets/dashboard/img/profiles/face-1.png', '', '1'),
('assets/dashboard/img/profiles/face-2.jpg', '', '1'),
('assets/dashboard/img/profiles/face-3.png', '', '1'),
('assets/dashboard/img/profiles/face-4.png', '', '1'),
('assets/dashboard/img/profiles/face-5.jpg', '', '1'),
('assets/dashboard/img/profiles/face-6.jpg', '', '1'),
('assets/dashboard/img/profiles/face-7.png', '', '1'),
('assets/dashboard/img/profiles/face-8.jpg', '', '1'),
('assets/dashboard/img/profiles/face-9.png', '', '1');

DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `datetime` date DEFAULT NULL,
  `admin` enum('1','0') NOT NULL,
  `active` enum('1','0') NOT NULL,
  `picture` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`email`, `password`, `active`),
  CONSTRAINT FOREIGN KEY (`picture`) REFERENCES `user_picture`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `user`
(`firstname`, `lastname`, `username`, `email`, `password`, `datetime`, `admin`, `active`, `picture`)
VALUES
('Gabriel', 'Malet', 'UbikZ', 'gabrielmalet@gmail.com', '2de4a995b7b50c2535f89e4472ba906789929976', '2014-08-02', '1', '1', 1);

SET FOREIGN_KEY_CHECKS=1;