-- MySQL Script generated by MySQL Workbench
-- Sat Jan 21 13:29:08 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema bcm_delivery
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bcm_delivery
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bcm_delivery` DEFAULT CHARACTER SET utf8 ;
USE `bcm_delivery` ;

-- -----------------------------------------------------
-- Table `bcm_delivery`.`truck`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bcm_delivery`.`truck` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `truck_label` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `truck_label_UNIQUE` (`truck_label` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bcm_delivery`.`driver`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bcm_delivery`.`driver` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `driver_first_name` VARCHAR(45) NULL,
  `driver_last_name` VARCHAR(45) NULL,
  `truck_status_id` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bcm_delivery`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bcm_delivery`.`status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status_label` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bcm_delivery`.`truck_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bcm_delivery`.`truck_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `note` VARCHAR(500) NOT NULL,
  `truck_id` INT NOT NULL,
  `status_id` INT NOT NULL,
  `driver_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_truck_status_driver_idx` (`driver_id` ASC) VISIBLE,
  INDEX `fk_truck_status_truck1_idx` (`truck_id` ASC) VISIBLE,
  INDEX `fk_truck_status_status1_idx` (`status_id` ASC) VISIBLE,
  CONSTRAINT `fk_truck_status_driver`
    FOREIGN KEY (`driver_id`)
    REFERENCES `bcm_delivery`.`driver` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_truck_status_truck1`
    FOREIGN KEY (`truck_id`)
    REFERENCES `bcm_delivery`.`truck` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_truck_status_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `bcm_delivery`.`status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `bcm_delivery` ;

-- -----------------------------------------------------
-- Placeholder table for view `bcm_delivery`.`status_overview`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bcm_delivery`.`status_overview` (`truck_id` INT, `truck_label` INT, `status_id` INT, `status_label` INT, `driver_id` INT, `driver_first_name` INT, `driver_last_name` INT, `note` INT);

-- -----------------------------------------------------
-- View `bcm_delivery`.`status_overview`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bcm_delivery`.`status_overview`;
USE `bcm_delivery`;
CREATE  OR REPLACE VIEW `status_overview` AS
    SELECT 
        truck_id,
        truck_label,
        status_id,
        status_label,
        driver_id,
        driver_first_name,
        driver_last_name,
        note
    FROM
        truck_status,
        truck,
        driver,
        status
    WHERE
        truck_status.truck_id = truck.id
            AND truck_status.driver_id = driver.id
            AND truck_status.status_id = status.id;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
