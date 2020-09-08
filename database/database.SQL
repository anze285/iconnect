/*
Created: 02/09/2020
Modified: 08/09/2020
Model: MySQL 8.0
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table users

CREATE TABLE `users`
(
  `id` Int NOT NULL,
  `name` Char(50) NOT NULL,
  `username` Char(50) NOT NULL,
  `bio` Text,
  `email` Char(50) NOT NULL,
  `phone_number` Char(20),
  `password` Char(255) NOT NULL
)
;

ALTER TABLE `users` ADD PRIMARY KEY (`id`)
;

-- Table followers

CREATE TABLE `followers`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `date` Timestamp NOT NULL,
  `user_id` Int NOT NULL,
  `follower_id` Int NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship1` ON `followers` (`user_id`)
;

CREATE INDEX `IX_Relationship2` ON `followers` (`follower_id`)
;

-- Table posts

CREATE TABLE `posts`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `description` Text,
  `user_id` Int NOT NULL,
  `location_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship3` ON `posts` (`user_id`)
;

CREATE INDEX `IX_Relationship4` ON `posts` (`location_id`)
;

-- Table locations

CREATE TABLE `locations`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `title` Char(30) NOT NULL,
  PRIMARY KEY (`id`)
)
;

-- Table comments

CREATE TABLE `comments`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `date` Timestamp NOT NULL,
  `message` Text NOT NULL,
  `comment_id` Int,
  `post_id` Int NOT NULL,
  `user_id` Int NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship5` ON `comments` (`comment_id`)
;

CREATE INDEX `IX_Relationship6` ON `comments` (`post_id`)
;

CREATE INDEX `IX_Relationship7` ON `comments` (`user_id`)
;

-- Table likes

CREATE TABLE `likes`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `date` Timestamp NOT NULL,
  `post_id` Int,
  `user_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship8` ON `likes` (`post_id`)
;

CREATE INDEX `IX_Relationship9` ON `likes` (`user_id`)
;

-- Table saved_posts

CREATE TABLE `saved_posts`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `date` Timestamp NOT NULL,
  `user_id` Int NOT NULL,
  `post_id` Int NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship10` ON `saved_posts` (`user_id`)
;

CREATE INDEX `IX_Relationship11` ON `saved_posts` (`post_id`)
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `followers` ADD CONSTRAINT `Relationship1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `followers` ADD CONSTRAINT `Relationship2` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `posts` ADD CONSTRAINT `Relationship3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `posts` ADD CONSTRAINT `Relationship4` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `comments` ADD CONSTRAINT `Relationship5` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `comments` ADD CONSTRAINT `Relationship6` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `comments` ADD CONSTRAINT `Relationship7` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `likes` ADD CONSTRAINT `Relationship8` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `likes` ADD CONSTRAINT `Relationship9` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `saved_posts` ADD CONSTRAINT `Relationship10` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `saved_posts` ADD CONSTRAINT `Relationship11` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;


