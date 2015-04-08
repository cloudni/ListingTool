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

/*start 2015/04/03*/
ALTER TABLE `lt_company` ADD COLUMN `balance` decimal(10,2) NULL;

DROP TABLE IF EXISTS `lt_transaction`;
CREATE TABLE `lt_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL COMMENT '支付平台类型，如paypal',
  `transaction_type` varchar(20) DEFAULT NULL COMMENT '交易类型：存款、取款',
  `status` varchar(20) DEFAULT NULL COMMENT '交易状态(业务状态，区别于支付状态）',
  `contents` varchar(1000) DEFAULT NULL,
  `payment_transaction_id` varchar(100) DEFAULT NULL COMMENT '支付平台的交易号',
  `total` decimal(10,2) DEFAULT NULL COMMENT '发起交易的额度',
  `fee` decimal(10,2) DEFAULT NULL COMMENT '交易平台扣款',
  `net` decimal(10,2) DEFAULT NULL COMMENT '充值成功金额=total-fee',
  `enabled` tinyint(1) DEFAULT '1',
  `create_time_utc` int(11) DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_time_utc` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lt_transaction_access_token`;
CREATE TABLE `lt_transaction_access_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(255) NOT NULL,
  `lift_cycle` bigint(20) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `create_time_utc` int(11) NOT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lt_transaction_credit_card`;
CREATE TABLE `lt_transaction_credit_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) DEFAULT NULL COMMENT '关联表li_transaction_detail.id',
  `first_name` varchar(50) DEFAULT NULL COMMENT '持卡人名字',
  `last_name` varchar(50) DEFAULT NULL COMMENT '持卡人姓',
  `type` varchar(20) DEFAULT NULL COMMENT '卡类型：如visa',
  `number` varchar(30) DEFAULT NULL COMMENT '信用卡号',
  `expire_month` char(2) DEFAULT NULL COMMENT '到期月份',
  `expire_year` char(4) DEFAULT NULL COMMENT '到期年份',
  `cvv2` char(3) DEFAULT NULL COMMENT '卡验证码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lt_transaction_payment_account`;
CREATE TABLE `lt_transaction_payment_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL COMMENT '账号对应的邮箱',
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `payer_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lt_transaction_paypal`;
CREATE TABLE `lt_transaction_paypal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) DEFAULT NULL COMMENT '关联表lt_transaction_detail.id',
  `interface_name` varchar(50) DEFAULT NULL COMMENT '接口名称',
  `action_state` varchar(50) DEFAULT NULL COMMENT '动作对应状态：如created、approved',
  `payment_id` varchar(100) DEFAULT NULL,
  `payment_transaction_id` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `payment_state` varchar(50) DEFAULT NULL,
  `platform_account_name` varchar(50) DEFAULT NULL,
  `platform_account_state` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL COMMENT '发起交易的额度',
  `fee` decimal(10,2) DEFAULT NULL COMMENT '交易平台扣款',
  `net` decimal(10,2) DEFAULT NULL COMMENT '充值成功金额=total-fee',
  `request_content` text COMMENT '请求详情',
  `response_content` text COMMENT '响应详情',
  `response_error_content` text,
  `created_time` varchar(50) DEFAULT NULL,
  `approved_time` varchar(50) DEFAULT NULL,
  `completed_time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lt_transaction_id` (`transaction_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*end 2015/04/03*/