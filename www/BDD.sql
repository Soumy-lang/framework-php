-- Suppression des tables et séquences si elles existent
DROP TABLE IF EXISTS `{prefix}_media`;
DROP TABLE IF EXISTS `{prefix}_post`;
DROP TABLE IF EXISTS `{prefix}_sitesetting`;
DROP TABLE IF EXISTS `{prefix}_theme`;
DROP TABLE IF EXISTS `{prefix}_user`;

-- Création des tables

-- Table `user`
CREATE TABLE `{prefix}_user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `firstname` VARCHAR(25) NOT NULL,
    `lastname` VARCHAR(50) NOT NULL,
    `email` VARCHAR(320) NOT NULL,
    `username` VARCHAR(25) NOT NULL,
    `pwd` VARCHAR(255) NOT NULL,
    `status` SMALLINT DEFAULT '0' NOT NULL,
    `img_path` VARCHAR(255),
    `role` VARCHAR(15) DEFAULT 'user',
    `reset_token` VARCHAR(255),
    `reset_expires` TIMESTAMP,
    `createdat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `updatedat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `activation_token` VARCHAR(255),
    `is_active` BOOLEAN DEFAULT FALSE,
    UNIQUE KEY (`email`),
    UNIQUE KEY (`username`)
) ENGINE=InnoDB;

-- Table `media`
CREATE TABLE `{prefix}_media` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(15) NOT NULL,
    `filepath` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `createdat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    UNIQUE KEY (`id`)
) ENGINE=InnoDB;

-- Table `post`
CREATE TABLE `{prefix}_post` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(40) NOT NULL,
    `body` TEXT NOT NULL,
    `type` VARCHAR(40) NOT NULL,
    `slug` VARCHAR(20) NOT NULL,
    `published` SMALLINT DEFAULT '0' NOT NULL,
    `isdeleted` SMALLINT DEFAULT '0' NOT NULL,
    `createdat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `updatedat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `user_username` VARCHAR(25),
    UNIQUE KEY (`id`),
    KEY `user_username_idx` (`user_username`)
) ENGINE=InnoDB;

-- Index pour la clé étrangère
ALTER TABLE `{prefix}_post`
ADD CONSTRAINT `{prefix}_post_user_username_fkey`
FOREIGN KEY (`user_username`) REFERENCES `{prefix}_user` (`username`) ON UPDATE CASCADE;

-- Table `sitesetting`
CREATE TABLE `{prefix}_sitesetting` (
    `cles` VARCHAR(45) NOT NULL,
    `valeur` VARCHAR(255) NOT NULL,
    `createdat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `updatedat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `isDeleted` SMALLINT DEFAULT '0' NOT NULL,
    `id` SMALLINT AUTO_INCREMENT PRIMARY KEY,
    UNIQUE KEY (`id`)
) ENGINE=InnoDB;

-- Table `theme`
CREATE TABLE `{prefix}_theme` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `actif` SMALLINT DEFAULT '0' NOT NULL
) ENGINE=InnoDB;

