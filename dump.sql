DROP DATABASE IF EXISTS blog_php;
CREATE DATABASE blog_php;

connect blog_php;

DROP TABLE IF EXISTS `utilisateur`;
DROP TABLE IF EXISTS `article`;
DROP TABLE IF EXISTS `commentaire`;

CREATE TABLE `utilisateur`(
	`id` INT NOT NULL AUTO_INCREMENT,
	`userName` VARCHAR(50) NOT NULL,
	`password` VARCHAR(150) NOT NULL,
	`tel` VARCHAR(10) NOT NULL,
	`mail` VARCHAR(50) NOT NULL,
	`image` BLOB,
	`admin` INT DEFAULT 0,
	PRIMARY KEY(`id`)
);


CREATE TABLE `article`(
	`id` INT NOT NULL AUTO_INCREMENT,
	`titre` VARCHAR(100) NOT NULL,
	`contenu` VARCHAR(5000) NOT NULL,
	`auteur` INT NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY (`auteur`) REFERENCES `utilisateur`(`id`)
);


CREATE TABLE `commentaire`(
	`id` INT NOT NULL AUTO_INCREMENT,
	`contenu` VARCHAR(500) NOT NULL,
	`auteur` INT NOT NULL,
	`article` INT NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY (`auteur`) REFERENCES `utilisateur`(`id`),
	FOREIGN KEY (`article`) REFERENCES `article`(`id`)
);

#Ajouter des champs de tests lorsque le cryptage des mots de passe sera mise en place
