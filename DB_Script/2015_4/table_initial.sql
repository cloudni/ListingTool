/*start 2015-04-07*/
drop table if exists `lt_ad_campaign`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ad_campaign_schedule`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ad_group`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `lt_ad_group_placement`;
CREATE TABLE `lt_ad_group_placement` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `URL` VARCHAR(500) NOT NULL,
  foreign key (`group_id`) references lt_ad_group (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**********************Create by Tik Begin***********************/
drop table if exists lt_ad_feed;
create table lt_ad_feed
(
   id                   int not null PRIMARY KEY AUTO_INCREMENT,
   feed_name            varchar(255),
   ad_id				int not null,
   remarketing_url      varchar(100) not null,
   item_id              int not null,
   item_keywords        text,
   item_headline        varchar(100),
   item_sub_headline    varchar(100),
   item_description     varchar(255),
   item_address         varchar(255),
   price                DECIMAL(20,4) not null,
   image_url            varchar(200) not null,
   item_category        int,
   sale_price           DECIMAL(20,4) not null,
   create_time_utc      INT NULL DEFAULT 0,
   create_user_id       INT NULL DEFAULT 0,
   update_time_utc      INT NULL DEFAULT 0,
   update_user_id       INT NULL DEFAULT 0,
   foreign key (`ad_id`) references lt_ad_ad (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists lt_ad_ad;
create table lt_ad_ad
(
   id                   int not null PRIMARY KEY AUTO_INCREMENT,
   ad_group_id          int not null,
   `name`				varchar(255) not null,
   `note`				varchar(255) null,
   `company_id` INT NOT NULL,
   foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
   foreign key (`ad_group_id`) references lt_ad_group (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists lt_ad_ad_variation;
create table lt_ad_ad_variation
(
   id                   int not null PRIMARY KEY AUTO_INCREMENT,
   ad_group_id          int not null comment '所属广告组ID',
   ad_id                int not null,
   `company_id` INT NOT NULL,
   ad_type              int not null comment '广告类型（1：文字 2：图片 3：创意广告）',
   status               tinyint(1) not null comment '状态',
   headline             varchar(100) not null comment '标题',
   headline_style       text comment '标题样式',
   price_prefix         varchar(50) comment '价格前缀',
   price_prefix_style   text comment '价格前缀样式',
   button_caption       varchar(20) comment '按钮名称',
   button_style         text comment '按钮样式',
   display_url          varchar(100) comment '显示网址',
   ad_style             text comment '广告style',
   ad_name              varchar(255) not null comment '广告名',
   is_delete            tinyint(1) not null comment '逻辑删除标记（0：未删除 1：删除）',
   create_time_utc      INT NULL DEFAULT 0,
   create_user_id       INT NULL DEFAULT 0,
   update_time_utc      INT NULL DEFAULT 0,
   update_user_id       INT NULL DEFAULT 0,
   foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
   foreign key (`ad_id`) references lt_ad_ad (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/**********************Create by Tik End*************************/
/*end 2015-04-07*/

/*start 2015-04-09*/
ALTER TABLE `lt_ebay_category` CHANGE COLUMN `CategoryID` `CategoryID` VARCHAR(10) NOT NULL;
ALTER TABLE `lt_ebay_category` add constraint category_id_and_site_id UNIQUE(CategoryID,CategorySiteID);
/*end 2015-04-09*/