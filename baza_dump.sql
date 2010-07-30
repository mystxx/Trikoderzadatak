/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.1.36-community : Database - trikoder
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`trikoder` /*!40100 DEFAULT CHARACTER SET cp1250 */;

USE `trikoder`;

/*Table structure for table `cars` */

DROP TABLE IF EXISTS `cars`;

CREATE TABLE `cars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primarni kljuc',
  `carModel` varchar(255) DEFAULT NULL COMMENT 'model auta',
  `carMake` varchar(255) DEFAULT NULL COMMENT 'marka auta',
  `carPrice` float DEFAULT NULL COMMENT 'cijena',
  `engineType` enum('gasoline','diesel','hybrid') DEFAULT NULL COMMENT 'vrsta motora',
  `fuelGroupId` int(11) DEFAULT NULL COMMENT 'grupa goriva',
  `oilGroupId` int(11) DEFAULT NULL COMMENT 'grupa ulja',
  `carImage` varbinary(255) DEFAULT NULL COMMENT 'putanja do slike',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=cp1250;

/*Data for the table `cars` */

insert  into `cars`(`id`,`carModel`,`carMake`,`carPrice`,`engineType`,`fuelGroupId`,`oilGroupId`,`carImage`) values (1,'Megane','Renault',100000,'diesel',4,2,'images/car.jpg'),(2,'Fluence','Renault',120000,'gasoline',2,2,'images/car.jpg'),(3,'Duster','Dacia',80000,'gasoline',3,3,'images/car.jpg'),(4,'Beetle','WV',2000,'gasoline',1,5,'images/car.jpg'),(5,'Accord','Honda',2e+006,'diesel',5,4,'images/car.jpg');

/*Table structure for table `fuel` */

DROP TABLE IF EXISTS `fuel`;

CREATE TABLE `fuel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primarni kljuc',
  `fuelMaker` varbinary(255) DEFAULT NULL COMMENT 'firma',
  `fuelGroup` int(11) DEFAULT NULL COMMENT 'grupa',
  `fuelImage` varchar(255) DEFAULT NULL COMMENT 'putanja do slike',
  `fuelPrice` float DEFAULT NULL COMMENT 'cijena',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=cp1250;

/*Data for the table `fuel` */

insert  into `fuel`(`id`,`fuelMaker`,`fuelGroup`,`fuelImage`,`fuelPrice`) values (1,'INA',1,'images/fuel.png',8.23),(2,'Tifon',2,'images/fuel.png',8.12),(3,'OMV',3,'images/fuel.png',8.88),(4,'Lukoil',4,'images/fuel.png',7.66),(5,'Petrol',5,'images/fuel.png',4.22);

/*Table structure for table `fuelgroup` */

DROP TABLE IF EXISTS `fuelgroup`;

CREATE TABLE `fuelgroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primarni kljuc',
  `fuelType` varchar(30) DEFAULT NULL COMMENT 'tip goriva - diesel, benzin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=cp1250;

/*Data for the table `fuelgroup` */

insert  into `fuelgroup`(`id`,`fuelType`) values (1,'Super 98'),(2,'Eurosuper 95'),(3,'Diesel'),(4,'Eurosuper 100'),(5,'Super 95');

/*Table structure for table `oil` */

DROP TABLE IF EXISTS `oil`;

CREATE TABLE `oil` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primarni kljuc',
  `oilName` varchar(255) DEFAULT NULL COMMENT 'proizvodjac',
  `oilGroup` int(11) DEFAULT NULL COMMENT 'grupa kojoj pripada',
  `oilImage` varchar(255) DEFAULT NULL COMMENT 'putanja do slike',
  `oilPrice` float DEFAULT NULL COMMENT 'cijena',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=cp1250;

/*Data for the table `oil` */

insert  into `oil`(`id`,`oilName`,`oilGroup`,`oilImage`,`oilPrice`) values (1,'MAXIMA EURO 4+ ',1,'images/oil.png',44.95),(2,'MAXIMA HC PRESTIGE XLD',5,'images/oil.png',39.99),(3,'MAXIMA HD S3',2,'images/oil.png',57.99),(4,'MAXIMA SUPER MG',4,'images/oil.png',89.22),(5,'MAXIMA HD S3',3,'images/oil.png',99.99);

/*Table structure for table `oilgroup` */

DROP TABLE IF EXISTS `oilgroup`;

CREATE TABLE `oilgroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primarni kljuc',
  `oilType` varchar(20) DEFAULT NULL COMMENT 'tip ulja po imenu ili viskoznosti',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=cp1250;

/*Data for the table `oilgroup` */

insert  into `oilgroup`(`id`,`oilType`) values (1,'SAE 10W-40'),(2,'SAE 15W-40'),(3,'SAE 10W'),(4,'SAE 30'),(5,'SAE 40');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
