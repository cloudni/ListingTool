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

/*start 2015-04-07*/
drop table if exists `lt_ad_campaign`;
CREATE TABLE `lt_ad_campaign` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `company_id` INT NOT NULL,
  `status` tinyint(1) not null default 0,
  `is_delete` tinyint(1) not null default 0,
  `criteria` text null comment 'other criterias in JSON format', 
  `budget` DECIMAL(20,4) NULL DEFAULT 0,
  `start_datetime` INT NOT NULL DEFAULT 0,
  `end_datetime` INT NULL DEFAULT NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
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

/*start 2015-04-14*/
drop table if exists `lt_ad_change_log`;
CREATE TABLE `lt_ad_change_log` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `company_id` INT NOT NULL,
  `object_type` TINYINT(4) NOT NULL comment '记录这条log对应对象的类名，比如ADCampaign',
  `object_id` INT NOT NULL comment '记录这条log对应对象的主键',
  `action` INT NOT NULL DEFAULT 0 comment '记录的动作，包括新增，更新，删除',
  `content` TEXT NOT NULL,
  `status` TINYINT(4) NOT NULL DEFAULT 0 comment '记录这条log是否已经被同步过，包括等待处理，已处理，处理出错',
  `priority` TINYINT(4) NOT NULL DEFAULT 0 comment 'log的优先级，一般，高优先级，最高优先级，紧急',
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0 comment '记录产生动作触发这条log的用户ID',
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0 comment '记录这条log最后更新的管理员ID',
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
);
/*end 2015-04-14*/