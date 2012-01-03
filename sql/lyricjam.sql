SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `lyricjam` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `lyricjam` ;

-- -----------------------------------------------------
-- Table `lyricjam`.`songs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lyricjam`.`songs` ;

CREATE  TABLE IF NOT EXISTS `lyricjam`.`songs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(200) NOT NULL ,
  `lyrics` TEXT NOT NULL ,
  `uuid` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `musicbrainz_id_UNIQUE` (`uuid` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `lyricjam`.`artists`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lyricjam`.`artists` ;

CREATE  TABLE IF NOT EXISTS `lyricjam`.`artists` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(200) NOT NULL ,
  `uuid` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `musicbrainz_id_UNIQUE` (`uuid` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `lyricjam`.`albums`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lyricjam`.`albums` ;

CREATE  TABLE IF NOT EXISTS `lyricjam`.`albums` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(200) NOT NULL ,
  `uuid` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `musicbrainz_id_UNIQUE` (`uuid` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `lyricjam`.`albums_songs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lyricjam`.`albums_songs` ;

CREATE  TABLE IF NOT EXISTS `lyricjam`.`albums_songs` (
  `song_id` INT NOT NULL ,
  `album_id` INT NOT NULL ,
  PRIMARY KEY (`song_id`, `album_id`) ,
  INDEX `fk_songs_has_albums_albums1` (`album_id` ASC) ,
  INDEX `fk_songs_has_albums_songs` (`song_id` ASC) ,
  CONSTRAINT `fk_songs_has_albums_songs`
    FOREIGN KEY (`song_id` )
    REFERENCES `lyricjam`.`songs` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_songs_has_albums_albums1`
    FOREIGN KEY (`album_id` )
    REFERENCES `lyricjam`.`albums` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lyricjam`.`artists_songs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lyricjam`.`artists_songs` ;

CREATE  TABLE IF NOT EXISTS `lyricjam`.`artists_songs` (
  `song_id` INT NOT NULL ,
  `artist_id` INT NOT NULL ,
  PRIMARY KEY (`song_id`, `artist_id`) ,
  INDEX `fk_songs_has_artists_artists1` (`artist_id` ASC) ,
  INDEX `fk_songs_has_artists_songs1` (`song_id` ASC) ,
  CONSTRAINT `fk_songs_has_artists_songs1`
    FOREIGN KEY (`song_id` )
    REFERENCES `lyricjam`.`songs` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_songs_has_artists_artists1`
    FOREIGN KEY (`artist_id` )
    REFERENCES `lyricjam`.`artists` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
