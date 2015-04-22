/*start 2015/03/17 */
drop table if exists `lt_ebay_item_shopping_api`;
CREATE TABLE `lt_ebay_item_shopping_api` (
  `id` INT NOT NULL AUTO_INCREMENT primary key ,
  `ebay_listing_id` VARCHAR(45) NOT NULL,
  `site_id` INT NULL DEFAULT NULL,
  `ebay_entity_type_id` INT NOT NULL,
  `ebay_attribute_set_id` INT NOT NULL,
  `note` VARCHAR(255) NULL default null,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  UNIQUE KEY `entity_table_UNIQUE` (`ebay_listing_id`),
  foreign key (`ebay_entity_type_id`) references lt_ebay_entity_type (`id`) on delete cascade on update cascade,
  foreign key (`ebay_attribute_set_id`) references lt_ebay_attribute_set (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ebay_third_party_varchar`;
CREATE TABLE if not exists `lt_ebay_third_party_varchar` (
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

drop table if exists `lt_ebay_third_party_text`;
CREATE TABLE if not exists `lt_ebay_third_party_text` (
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

drop table if exists `lt_ebay_third_party_int`;
CREATE TABLE if not exists `lt_ebay_third_party_int` (
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

drop table if exists `lt_ebay_third_party_decimal`;
CREATE TABLE if not exists `lt_ebay_third_party_decimal` (
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

drop table if exists `lt_ebay_third_party_datetime`;
CREATE TABLE if not exists `lt_ebay_third_party_datetime` (
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

drop table if exists `lt_ebay_third_party_container`;
CREATE TABLE if not exists `lt_ebay_third_party_container` (
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

drop table if exists `lt_ebay_third_party_boolean`;
CREATE TABLE if not exists `lt_ebay_third_party_boolean` (
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
/*end 2015/03/17 */

/*start 2015/03/22*/
drop table if exists `lt_ebay_target_and_track`;
CREATE TABLE `lt_ebay_target_and_track` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  `company_id` INT NOT NULL,
  `target_ebay_item_id` VARCHAR(500) NOT NULL,
  `tracking_ebay_listing_id` VARCHAR(500) NOT NULL,
  `update_param` VARCHAR(1000) NOT NULL,
  `is_active` tinyint(1) not null default 0,
  `note` VARCHAR(256) NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015/03/22*/

/*start 2015/03/25*/
ALTER TABLE `lt_ticket` ADD COLUMN `company_id` INT NOT NULL AFTER `id`;
ALTER TABLE `lt_ticket` ADD INDEX `company_id_idx` (`company_id` ASC);
ALTER TABLE `lt_ticket` ADD CONSTRAINT `company_id` FOREIGN KEY (`company_id`) REFERENCES `lt_company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
/*end 2015/03/25*/