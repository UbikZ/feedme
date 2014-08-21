SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `user_picture`;

CREATE TABLE IF NOT EXISTS `user_picture` (
  `id`          INT(11)        NOT NULL AUTO_INCREMENT,
  `path`        VARCHAR(255)   NOT NULL,
  `description` VARCHAR(255)   NOT NULL,
  `active`      ENUM('0', '1') NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`active`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =1;

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
  `id`             INT(11)        NOT NULL AUTO_INCREMENT,
  `firstname`      VARCHAR(255) DEFAULT NULL,
  `lastname`       VARCHAR(255) DEFAULT NULL,
  `username`       VARCHAR(255) DEFAULT NULL,
  `email`          VARCHAR(255)   NOT NULL,
  `password`       VARCHAR(255)   NOT NULL,
  `society`        VARCHAR(255) DEFAULT NULL,
  `address`        VARCHAR(255) DEFAULT NULL,
  `about`          VARCHAR(255) DEFAULT NULL,
  `profilePicture` VARCHAR(255) DEFAULT NULL,
  `datetime`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `admin`          ENUM('0', '1') NOT NULL,
  `active`         ENUM('0', '1') NOT NULL,
  `picture`        INT(11)        NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`email`, `password`, `active`),
  CONSTRAINT FOREIGN KEY (`picture`) REFERENCES `user_picture` (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =2;

INSERT INTO `user`
(`id`, `firstname`, `lastname`, `username`, `email`, `password`, `society`, `address`, `datetime`, `admin`, `active`, `picture`)
VALUES
  (1, 'Gabriel', 'Malet', 'UbikZ', 'gabrielmalet@gmail.com', '2de4a995b7b50c2535f89e4472ba906789929976', 'Galilée',
   '415, 71th/5th Street, NYC', '2014-08-02', '1', '1', 1),
  (2, 'Firstname', 'Lastname', 'GuestUser', 'user@user.com', '2de4a995b7b50c2535f89e4472ba906789929976', 'Galilée',
   '21, 39th/5th Street, NYC', '2014-08-02', '0', '1', 2);

DROP TABLE IF EXISTS `user_wall_message`;

CREATE TABLE IF NOT EXISTS `user_wall_message` (
  `id`           INT(11) NOT NULL AUTO_INCREMENT,
  `idMessageSrc` INT(11) DEFAULT NULL,
  `idUserSrc`    INT(11) NOT NULL,
  `message`      VARCHAR(255) DEFAULT NULL,
  `adddate`      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`idMessageSrc`) REFERENCES `user_wall_message` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`idUserSrc`) REFERENCES `user` (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =3;

DROP TABLE IF EXISTS `user_wall`;

CREATE TABLE IF NOT EXISTS `user_wall` (
  `idUser`    INT(11)        NOT NULL,
  `idMessage` INT(11) DEFAULT NULL,
  `active`    ENUM('0', '1') NOT NULL,
  INDEX (`active`),
  CONSTRAINT FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
  CONSTRAINT FOREIGN KEY (`idMessage`) REFERENCES `user_wall_message` (`id`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =4;

DROP TABLE IF EXISTS `feed_type`;

CREATE TABLE IF NOT EXISTS `feed_type` (
  `id`     INT(11)        NOT NULL AUTO_INCREMENT,
  `label`  VARCHAR(255)   NOT NULL,
  `class`  VARCHAR(255)   NOT NULL,
  `active` ENUM('0', '1') NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =5;

INSERT INTO `feed_type`
(`id`, `label`, `class`, `active`)
VALUES
  (1, 'reddit', 'fa fa-reddit', '1'),
  (2, 'google', 'fa fa-google', '0'),
  (3, 'vine', 'fa fa-vine', '0'),
  (4, 'stack-overflow', 'fa fa-stack-overflow', '1'),
  (5, 'tumblr', 'fa fa-tumblr', '1'),
  (7, 'github', 'fa fa-github', '0'),
  (8, 'flickr', 'fa fa-flick', '0'),
  (9, 'twitter', 'fa fa-twitter', '0'),
  (10, 'other', 'fa fa-empire', '1');

DROP TABLE IF EXISTS `feed`;

CREATE TABLE IF NOT EXISTS `feed` (
  `id`          INT(11)        NOT NULL AUTO_INCREMENT,
  `idCreator`   INT(11)        NOT NULL,
  `url`         VARCHAR(255)   NOT NULL,
  `label`         VARCHAR(255)   NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `type`        INT(11)        NOT NULL,
  `adddate`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `validate`  ENUM('0', '1', '2') DEFAULT '1',
  `public`      ENUM('0', '1') NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`validate`, `public`, `url`),
  CONSTRAINT FOREIGN KEY (`type`) REFERENCES `feed_type` (`id`),
  CONSTRAINT FOREIGN KEY (`idCreator`) REFERENCES `user` (`id`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =6;

INSERT INTO `feed`
(`id`, `idCreator`, `url`, `label`, `type`, `adddate`, `validate`, `public`)
VALUES
  (1, 1, 'http://runningdrawing.tumblr.com', 'Runnning Drawing', 4, '2014-08-02', '1', '1'),
  (2, 1, 'http://www.reddit.com/r/philosophy', 'Philosophy', 1, '2014-08-02', '2', '1'),
  (3, 2, 'http://stackoverflow.com/questions/25313878', 'Algo 1', 3, '2014-08-02', '1', '0'),
  (4, 1, 'http://stackoverflow.com/questions/5964825', 'Algo 2', 3, '2014-08-02', '0', '1');

DROP TABLE IF EXISTS `user_feed`;

CREATE TABLE IF NOT EXISTS `user_feed` (
  `idUser`    INT(11) NOT NULL,
  `idFeed`    INT(11) NOT NULL,
  `subscribe` ENUM('0', '1') DEFAULT '0',
  `like`      ENUM('0', '1') DEFAULT '0',
  INDEX (`subscribe`, `like`),
  CONSTRAINT FOREIGN KEY (`idUser`) REFERENCES `user` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`idFeed`) REFERENCES `feed` (`id`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =7;

INSERT INTO `user_feed`
(`idUser`, `idFeed`, `subscribe`, `like`)
VALUES
  (1, 1, '0', '0'),
  (1, 2, '1', '1'),
  (2, 1, '0', '1'),
  (2, 2, '2', '1'),
  (2, 3, '1', '0');

DROP TABLE IF EXISTS `feed_item`;

CREATE TABLE IF NOT EXISTS `feed_item` (
  `id`         INT(11)        NOT NULL AUTO_INCREMENT,
  `idFeed`     INT(11)        NOT NULL,
  `title`      VARCHAR(255)   NOT NULL,
  `categories` VARCHAR(255) DEFAULT NULL,
  `authorName` VARCHAR(255) DEFAULT NULL,
  `authorUri`  VARCHAR(255) DEFAULT NULL,
  `link`       VARCHAR(255) DEFAULT NULL,
  `adddate`    TIMESTAMP NOT NULL,
  `changedate` TIMESTAMP NOT NULL,
  `summary`    TEXT DEFAULT NULL,
  `extract`    TEXT DEFAULT NULL,
  `active`     ENUM('0', '1') NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`active`),
  CONSTRAINT FOREIGN KEY (`idFeed`) REFERENCES `feed` (`id`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =8;

DROP TABLE IF EXISTS `user_feed_item`;

CREATE TABLE IF NOT EXISTS `user_feed_item` (
  `idUser`     INT(11) NOT NULL,
  `idFeedItem` INT(11) NOT NULL,
  `seen`       ENUM('0', '1') DEFAULT '0',
  `like`       ENUM('0', '1') DEFAULT '0',
  INDEX (`seen`, `like`),
  CONSTRAINT FOREIGN KEY (`idUser`) REFERENCES `user` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`idFeedItem`) REFERENCES `feed_item` (`id`)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1
  AUTO_INCREMENT =9;

SET FOREIGN_KEY_CHECKS = 1;