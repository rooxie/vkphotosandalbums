
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `last_sync` TIMESTAMP NOT NULL DEFAULT now(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- albums
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `albums`;

CREATE TABLE `albums`
(
    `id` INTEGER NOT NULL,
    `owner_id` INTEGER NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `created` DATETIME NOT NULL,
    `updated` DATETIME NOT NULL,
    `size` VARCHAR(255) NOT NULL,
    `last_sync` TIMESTAMP NOT NULL DEFAULT now(),
    PRIMARY KEY (`id`),
    INDEX `albums_owner_id_index` (`owner_id`),
    CONSTRAINT `albums_fk_973e78`
        FOREIGN KEY (`owner_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- photos
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `photos`;

CREATE TABLE `photos`
(
    `id` INTEGER NOT NULL,
    `album_id` INTEGER,
    `owner_id` INTEGER NOT NULL,
    `photo_75` VARCHAR(255) NOT NULL,
    `photo_130` VARCHAR(255) NOT NULL,
    `photo_604` VARCHAR(255) NOT NULL,
    `photo_807` VARCHAR(255) NOT NULL,
    `photo_1280` VARCHAR(255) NOT NULL,
    `width` INTEGER NOT NULL,
    `height` INTEGER NOT NULL,
    `text` TEXT,
    `created` DATETIME NOT NULL,
    `last_sync` TIMESTAMP NOT NULL DEFAULT now(),
    PRIMARY KEY (`id`),
    INDEX `photos_owner_id_index` (`owner_id`),
    INDEX `photos_fi_e8a595` (`album_id`),
    CONSTRAINT `photos_fk_973e78`
        FOREIGN KEY (`owner_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `photos_fk_e8a595`
        FOREIGN KEY (`album_id`)
        REFERENCES `albums` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
