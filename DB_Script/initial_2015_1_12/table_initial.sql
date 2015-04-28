drop table if exists `lt_AuthItem`;
create table `lt_AuthItem`
(
   `name`                 varchar(64) not null,
   `type`                 integer not null,
   `description`          text,
   `bizrule`              text,
   `data`                 text,
   primary key (`name`)
) engine InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_AuthItemChild`;
create table `lt_AuthItemChild`
(
   `parent`               varchar(64) not null,
   `child`                varchar(64) not null,
   primary key (`parent`,`child`),
   foreign key (`parent`) references `lt_AuthItem` (`name`) on delete cascade on update cascade,
   foreign key (`child`) references `lt_AuthItem` (`name`) on delete cascade on update cascade
) engine InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_AuthAssignment`;
create table `lt_AuthAssignment`
(
   `itemname`             varchar(64) not null,
   `userid`               varchar(64) not null,
   `bizrule`              text,
   `data`                 text,
   primary key (`itemname`,`userid`),
   foreign key (`itemname`) references `lt_AuthItem` (`name`) on delete cascade on update cascade
) engine InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_company`;
CREATE TABLE IF NOT EXISTS `lt_company`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(256) NOT NULL,
	`phone` VARCHAR(256),
	`country` VARCHAR(256),
	`owner_id` INTEGER DEFAULT 0,
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_department`;
CREATE TABLE IF NOT EXISTS `lt_department`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(256) NOT NULL,
	`parent_id` INTEGER DEFAULT 0,
	`company_id` INTEGER DEFAULT 0,
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
    `note` VARCHAR(256) default '',
    foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_user`;
CREATE TABLE IF NOT EXISTS `lt_user`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `email` VARCHAR(256) NOT NULL,
    `username` VARCHAR(256) NOT NULL,
    `password` VARCHAR(256) NOT NULL,
	`company_id` INTEGER DEFAULT 0,
	`department_id` INTEGER DEFAULT 0,
    `last_login_time_utc` INTEGER DEFAULT 0,
	`last_login_ip` VARCHAR(128),
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
	foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
	foreign key (`department_id`) references lt_department (`id`) on delete cascade on update cascade
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_store`;
CREATE TABLE if not exists `lt_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `platform` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1',
  `company_id` int(11) DEFAULT '0',
  `ebay_api_key_id` int(11) DEFAULT NULL,
  `ebay_token` text NULL,
  `HardExpirationTime` INT NULL,
  `ebay_site_code` INT(11) NULL,
  `last_listing_sync_time_utc` int(11) DEFAULT '0',
  `create_time_utc` int(11) DEFAULT '0',
  `create_user_id` int(11) DEFAULT NULL,
  `update_time_utc` int(11) DEFAULT '0',
  `update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  FOREIGN KEY (`company_id`) REFERENCES `lt_company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_admin`;
CREATE TABLE `lt_admin` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `last_login_time_utc` int(11) DEFAULT '0',
  `last_login_ip` varchar(128) DEFAULT NULL,
  `create_time_utc` int(11) DEFAULT '0',
  `create_admin_id` int(11) DEFAULT NULL,
  `update_time_utc` int(11) DEFAULT '0',
  `update_admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ticket`;
CREATE TABLE if not exists `lt_ticket` (
	`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`title` varchar(255) default '',
	`content` text ,
	`type` smallint default 0,
	`is_repliable` tinyint default 1,
	`is_viewable` tinyint default 1,
	`parent_id`	int	default 0,
	`create_time_utc` INTEGER DEFAULT 0,
	`create_user_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_user_id` INTEGER,
	`is_user` tinyint default 0,
	`is_new` TINYINT(4) NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ticket_attachment`;
CREATE TABLE `lt_ticket_attachment` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `ticket_id` INT NULL,
  `name` VARCHAR(45) NULL,
  `company_id` INT NULL,
  `path` VARCHAR(255) NULL,
  `view_url` varchar(500) null,
  `type` VARCHAR(45) NULL,
  `is_delete` TINYINT(1) NULL DEFAULT 0,
  `size` INT NULL,
  `create_time_utc` INT NULL,
  `create_user_id` INT NULL,
  `update_time_utc` INT NULL,
  `update_user_id` INT NULL,
  foreign key (`ticket_id`) references lt_ticket (`id`) on delete cascade on update cascade,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_bulletin`;
CREATE TABLE if not exists `lt_bulletin` (
	`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`title` varchar(255) default '',
	`content` text ,
	`is_new` tinyint default 0,
	`is_top`tinyint default 0,
	`is_viewable` tinyint default 1,
	`create_time_utc` INTEGER DEFAULT 0,
	`create_admin_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_admin_id` INTEGER,
	`owner` TINYINT(4) NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_notification`;
CREATE TABLE if not exists `lt_notification` (
	`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`title` varchar(255)  NOT NULL,
	`content` text NOT NULL,
	`type` smallint default 0,
	`is_viewable` tinyint default 1,
	`is_important` tinyint default 1,
	`is_new` tinyint default 0,
	`company_id`	int	default 0 NOT NULL,
	`create_time_utc` INTEGER DEFAULT 0,
	`create_user_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_user_id` INTEGER
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_api_key`;
CREATE TABLE if not exists `lt_ebay_api_key` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`api_url` varchar(255) NOT NULL,
	`compatibility_level` varchar(50) NOT NULL,
	`type` smallint not null default 1,
	`dev_id` varchar(255) NOT NULL,
	`app_id` varchar(255) NOT NULL,
	`cert_id` varchar(255) NOT NULL,
	`runame` VARCHAR(255) NULL DEFAULT '',
	`create_time_utc` int(11) DEFAULT '0',
	`create_admin_id` int(11) DEFAULT '0',
	`update_time_utc` int(11) DEFAULT '0',
	`update_admin_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_resource_string`;
CREATE TABLE if not exists `lt_resource_string` (
	`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`key` varchar(100) not null,
	`language` smallint not null,
	`environment` smallint not null default 0,
	`message` text not null,
	`create_time_utc` int(11) DEFAULT '0',
	`create_admin_id`  int(11) DEFAULT NULL,
	`update_time_utc` int(11) DEFAULT '0',
	`update_admin_id`  int(11) DEFAULT NULL,
	unique index (`key`,`language`, `environment`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_product_folder`;
CREATE TABLE IF NOT EXISTS `lt_product_folder`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(256) NOT NULL,
	`parent_id` INTEGER DEFAULT 0,
	`is_delete` tinyint NOT NULL DEFAULT 0,
	`company_id` INTEGER DEFAULT 0,
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
    foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_product`;
CREATE TABLE IF NOT EXISTS `lt_product`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`sn` varchar(256) not null,
    `name` VARCHAR(256) NOT NULL,
	`folder_id` INTEGER NOT NULL DEFAULT 1,
	`is_real` tinyint NOT NULL DEFAULT 1,
	`is_delete` tinyint NOT NULL DEFAULT 1,
	`company_id` INTEGER DEFAULT 0,
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
    foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
	foreign key (`folder_id`) references lt_product_folder (`id`) on delete cascade on update cascade
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_picture_folder`;
CREATE TABLE IF NOT EXISTS `lt_picture_folder`
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(256) NOT NULL,
	`parent_id` INTEGER DEFAULT 0,
	`company_id` INTEGER DEFAULT 0,
    `create_time_utc` INTEGER DEFAULT 0,
    `create_user_id` INTEGER,
    `update_time_utc` INTEGER DEFAULT 0,
    `update_user_id` INTEGER,
     foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_picture`;
create table if not exists `lt_picture`
(
	`id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(256) NOT NULL,
	`is_delete` tinyint NOT NULL DEFAULT 1,
	`folder_id` INTEGER NOT NULL DEFAULT 1,
	`company_id` INTEGER DEFAULT 0,
	`type`  VARCHAR(50) NULL DEFAULT 'jpg',
	`width` int(11) NULL DEFAULT 0 ,
	`height`int(11) NULL DEFAULT 0 ,
	`title` VARCHAR(256) NULL DEFAULT '',
	`file_path` VARCHAR(256) NULL DEFAULT '',
	`create_time_utc` INTEGER DEFAULT 0,
	`create_user_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_user_id` INTEGER,
	foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
	foreign key (`folder_id`) references lt_picture_folder (`id`) on delete cascade on update cascade
)ENGINE = InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_type`;
create table if not exists `lt_ebay_entity_type`(
	`id` int not null primary key AUTO_INCREMENT,
	`name` varchar(255) not null,
	`entity_table` varchar(255) not null,
	`entity_model` varchar(255) not null,
	`attribute_table` varchar(255) not null default 'ebay_attribute',
	`attribute_model` varchar(255) not null default 'eBayAttribute',
	`value_table` varchar(255) not null,
	`value_model` varchar(255) NULL,
	`create_time_utc` INTEGER DEFAULT 0,
	`create_admin_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_admin_id` INTEGER,
	UNIQUE KEY `entity_table_UNIQUE` (`entity_table`),
	UNIQUE KEY `entity_model_UNIQUE` (`entity_model`)
) engine=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_attribute`;
create table if not exists `lt_ebay_attribute`(
	`id` int not null primary key AUTO_INCREMENT,
	`name` varchar(255) not null,
	`code` VARCHAR(255) NOT NULL,
	`backend_type` SMALLINT(6) NOT NULL DEFAULT 1,
	`size` INT NULL DEFAULT '500',
	`frontend_input` SMALLINT NULL DEFAULT 1,
	`frontend_label` varchar(255) default '',
	`note` varchar(255) default '',
	`create_time_utc` INTEGER DEFAULT 0,
	`create_admin_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_admin_id` INTEGER
) engine=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_attribute_set`;
create table if not exists `lt_ebay_attribute_set`(
	`id` int not null primary key AUTO_INCREMENT,
	`name` varchar(255) not null,
	`entity_type_id` int not null,
	`is_active` tinyint default 1,
	`sort_order` smallint default 0,
	`create_time_utc` INTEGER DEFAULT 0,
	`create_admin_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_admin_id` INTEGER,
	foreign key (`entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade
) engine=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_attribute_group`;
create table if not exists `lt_ebay_attribute_group`(
	`id` int not null primary key AUTO_INCREMENT,
	`name` varchar(255) not null,
	`attribute_set_id` int not null,
	`parent_group_id` int default 0,
	`sort_order` smallint default 0,
	`create_time_utc` INTEGER DEFAULT 0,
	`create_admin_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_admin_id` INTEGER,
	foreign key (`attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) engine=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_attribute`;
create table if not exists `lt_ebay_entity_attribute`(
	`id` int not null primary key AUTO_INCREMENT,
	`entity_type_id` int  not null,
	`attribute_set_id` int not null,
	`attribute_group_id` int not null,
	`attribute_id` int not null,
	`parent_id` INT(11) default 0,
	`sort_order` smallint default 0,
	`is_required` tinyint default 0,
	`is_unique` tinyint default 1,
	`create_time_utc` INTEGER DEFAULT 0,
	`create_admin_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_admin_id` INTEGER,
	foreign key (`entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade,
	foreign key (`attribute_group_id`) references lt_ebay_attribute_group (`id`) on delete cascade on update cascade,
	foreign key (`attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade
) engine=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_listing`;
create table if not exists `lt_ebay_listing`(
	`id` int not null primary key AUTO_INCREMENT,
	`store_id` int not null,
	`company_id` int not null,
	`ebay_listing_id` VARCHAR(50) NOT NULL,
	`site_id` INT NULL ,
	`ebay_entity_type_id` int not null,
	`ebay_attribute_set_id` int not null,
	`is_active` tinyint default 1,
	`note` varchar(255) default '',
	`create_time_utc` INTEGER DEFAULT 0,
	`create_user_id` INTEGER,
	`update_time_utc` INTEGER DEFAULT 0,
	`update_user_id` INTEGER,
	foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
	foreign key (`store_id`) references lt_store (`id`) on delete cascade on update cascade,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) engine=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_varchar`;
CREATE TABLE if not exists `lt_ebay_entity_varchar` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` VARCHAR(500) NULL DEFAULT '' ,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_text`;
CREATE TABLE if not exists `lt_ebay_entity_text` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` MEDIUMTEXT default null,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_int`;
CREATE TABLE if not exists `lt_ebay_entity_int` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` int NULL,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_decimal`;
CREATE TABLE if not exists `lt_ebay_entity_decimal` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` decimal(12,4) default 0.0000,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_datetime`;
CREATE TABLE if not exists `lt_ebay_entity_datetime` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` int default 0,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_container`;
CREATE TABLE if not exists `lt_ebay_entity_container` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` varchar(255) default '',
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_entity_boolean`;
CREATE TABLE if not exists `lt_ebay_entity_boolean` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` tinyint default 0,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_category`;
CREATE TABLE `lt_ebay_category` (
  `id` INT NOT NULL primary key AUTO_INCREMENT,
  `AutoPayEnabled` TINYINT(1) NULL DEFAULT 0,
  `B2BVATEnabled` TINYINT(1) NULL DEFAULT 0,
  `BestOfferEnabled` TINYINT(1) NULL DEFAULT 0,
  `CategoryID` VARCHAR(10) NULL,
  `CategorySiteID` INT NULL,
  `CategoryLevel` INT NULL,
  `CategoryName` VARCHAR(30) NULL,
  `CategoryParentID` VARCHAR(10) NULL,
  `Expired` TINYINT(1) NULL DEFAULT 0,
  `LeafCategory` TINYINT(1) NULL DEFAULT 0,
  `LSD` TINYINT(1) NULL DEFAULT 0,
  `ORPA` TINYINT(1) NULL DEFAULT 0,
  `ORRA` TINYINT(1) NULL DEFAULT 0,
  `Virtual` TINYINT(1) NULL DEFAULT 0,
  `ebay_entity_type_id` INT NULL,
  `ebay_attribute_set_id` INT NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` INT NULL,
  `create_user_id` INT NULL DEFAULT 0,
  `update_time_utc` INT NULL,
  `update_user_id` INT NULL DEFAULT 0,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_instant_job`;
CREATE TABLE `lt_instant_job` (
  `id` INT primary key NOT NULL AUTO_INCREMENT,
  `platform` SMALLINT NULL,
  `action` VARCHAR(255) NULL,
  `params` TEXT NULL,
  `status` VARCHAR(45) NULL,
  `result` VARCHAR(500) NULL,
  `create_time_utc` INT NULL,
  `execute_time_utc` INT NULL,
  `finish_time_utc` INT NULL
)engine InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_schedule_job`;
CREATE TABLE `lt_schedule_job` (
  `id` INT primary key NOT NULL AUTO_INCREMENT,
  `platform` INT NULL,
  `action` INT NULL,
  `params` TEXT NULL,
  `is_active` TINYINT(1) NULL,
  `create_time_utc` INT NULL,
  `last_execute_status` INT NULL,
  `last_execute_result` VARCHAR(500) NULL,
  `last_execute_time_utc` INT NULL,
  `last_finish_time_utc` INT NULL,
  `next_execute_time_utc` int null,
  `crontab` VARCHAR(255) NULL,
  `type` smallint NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_detail`;
CREATE TABLE `lt_ebay_detail` (
  `id` INT PRIMARY key NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `site_id` int NULL,
  `ebay_entity_type_id` int NULL,
  `ebay_attribute_set_id` int NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` INTEGER DEFAULT 0,
  `create_admin_id` INTEGER,
  `update_time_utc` INTEGER DEFAULT 0,
  `update_admin_id` INTEGER,
  foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
  foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_category_feature`;
CREATE TABLE `lt_ebay_category_feature` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `category_id` VARCHAR(10) NULL,
  `site_id` int NULL,
  `ebay_entity_type_id` int NULL,
  `ebay_attribute_set_id` int NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` int NULL default 0,
  `create_admin_id` int NULL,
  `update_time_utc` int NULL,
  `update_admin_id` int NULL default 0,
  foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
  foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_category_feature_definition_and_default`;
CREATE TABLE `lt_ebay_category_feature_definition_and_default` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `site_id` int NULL,
  `CategoryVersion` VARCHAR(255) null,
  `ebay_entity_type_id` int NULL,
  `ebay_attribute_set_id` int NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` int NULL default 0,
  `create_admin_id` int NULL,
  `update_time_utc` int NULL,
  `update_admin_id` int NULL default 0,
  foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
  foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_prefetch_varchar`;
CREATE TABLE if not exists `lt_ebay_prefetch_varchar` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` VARCHAR(500) NULL DEFAULT '' ,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_prefetch_text`;
CREATE TABLE if not exists `lt_ebay_prefetch_text` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` MEDIUMTEXT default null,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_prefetch_int`;
CREATE TABLE if not exists `lt_ebay_prefetch_int` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` int NULL,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_prefetch_decimal`;
CREATE TABLE if not exists `lt_ebay_prefetch_decimal` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` decimal(12,4) default 0.0000,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_prefetch_datetime`;
CREATE TABLE if not exists `lt_ebay_prefetch_datetime` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` int default 0,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_prefetch_container`;
CREATE TABLE if not exists `lt_ebay_prefetch_container` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` varchar(255) default '',
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_prefetch_boolean`;
CREATE TABLE if not exists `lt_ebay_prefetch_boolean` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ebay_entity_type_id` int(11) DEFAULT NULL,
	`ebay_attribute_id` int(11) DEFAULT NULL,
	`ebay_entity_id` int(11) DEFAULT NULL,
	`value` tinyint default 0,
	`ebay_entity_attribute_id` INT(11) NULL DEFAULT NULL,
	`parent_value_id` INT(11) NULL,
	`parent_value_type` SMALLINT(6) NULL,
	`parent_value_entity_attribute_id` INT(11) NULL,
	foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
	foreign key (`ebay_attribute_id`) references lt_ebay_attribute (`id`) on delete cascade on update cascade,
	INDEX `entity_id_and_entity_attribute_id` (`ebay_entity_id` ASC, `ebay_entity_attribute_id` ASC),
	INDEX `entity_attribute_id` (`ebay_entity_attribute_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_seller_dashboard`;
CREATE TABLE `lt_ebay_seller_dashboard` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `store_id` int NULL,
  `ebay_entity_type_id` int NULL,
  `ebay_attribute_set_id` int NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` int NULL default 0,
  `create_admin_id` int NULL,
  `update_time_utc` int NULL,
  `update_admin_id` int NULL default 0,
  foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
  foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_seller`;
CREATE TABLE `lt_ebay_seller` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `store_id` int NULL,
  `ebay_entity_type_id` int NULL,
  `ebay_attribute_set_id` int NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` int NULL default 0,
  `create_admin_id` int NULL,
  `update_time_utc` int NULL,
  `update_admin_id` int NULL default 0,
  foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
  foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*start 2015-02-16*/

drop table if exists `lt_ebay_user`;
CREATE TABLE `lt_ebay_user` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `store_id` int NULL,
  `ebay_entity_type_id` int NULL,
  `ebay_attribute_set_id` int NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` int NULL default 0,
  `create_admin_id` int NULL,
  `update_time_utc` int NULL,
  `update_admin_id` int NULL default 0,
  foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
  foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*end 2015-02-16*/