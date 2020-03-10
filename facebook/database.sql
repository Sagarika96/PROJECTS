DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
	`postid` varchar(5),`owner` varchar(50),FOREIGN KEY (`owner`) REFERENCES `users`(`username`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
	`commentid` varchar(5),`owner` varchar(50),FOREIGN KEY (`owner`) REFERENCES `users`(`username`) ON DELETE CASCADE
);
