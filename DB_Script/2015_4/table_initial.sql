/*start 2015-04-07*/
CREATE TABLE `lt_ad_campaign` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `company_id` INT NOT NULL,
  `status` tinyint(1) not null default 0,
  `is_delete` tinyint(1) not null default 0,
  `type` TINYINT(4) NOT NULL DEFAULT 1,
  `bid_strategy` TINYINT(1) NOT NULL DEFAULT 1,
  `budget` DECIMAL(20,4) NULL DEFAULT 0,
  `target_language` TEXT NOT NULL,
  `target_area` TEXT NOT NULL,
  `start_datetime` INT NOT NULL DEFAULT 0,
  `end_datetime` INT NULL DEFAULT NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
);

CREATE TABLE `lt_ad_campaign_schedule` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `campaign_id` INT NULL,
  `days` INT NULL,
  `from_hour` CHAR(2) NULL DEFAULT '00',
  `from_minute` CHAR(2) NULL DEFAULT '00',
  `to_hour` CHAR(2) NULL DEFAULT '00',
  `to_minute` CHAR(2) NULL DEFAULT '00',
  `timezone` VARCHAR(255) NULL DEFAULT 'Asia/Shanghai',
  foreign key (`campaign_id`) references lt_ad_campaign (`id`) on delete cascade on update cascade
);

CREATE TABLE `lt_ad_group` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `company_id` INT NOT NULL,
  `campaign_id` INT NULL,
  `status` tinyint(1) not null default 0,
  `is_delete` tinyint(1) not null default 0,
  `default_bid` DECIMAL(20,4) NOT NULL,
  `audenice_list` VARCHAR(255) NULL,
  `keywords` TEXT NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,						
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
  foreign key (`campaign_id`) references lt_ad_campaign (`id`) on delete cascade on update cascade
);

CREATE TABLE `lt_ad_group_placement` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `URL` VARCHAR(500) NOT NULL,
  foreign key (`group_id`) references lt_ad_group (`id`) on delete cascade on update cascade
);
/*end 2015-04-07*/