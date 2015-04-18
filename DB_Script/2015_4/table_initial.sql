/*start 2015/04/03*/
ALTER TABLE `lt_company` ADD COLUMN `balance` decimal(10,4) NULL;

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
  `criteria` text null comment 'other criterias in JSON format, like language, location, schedule', 
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
  `criteria` text null comment 'other criterias in JSON format, like keyword, placement', 
  `note` VARCHAR(255) NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,						
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
  foreign key (`campaign_id`) references lt_ad_campaign (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**********************Create by Tik Begin***********************/
drop table if exists lt_ad_advertise;
create table lt_ad_advertise
(
   `id`                  int not null PRIMARY KEY AUTO_INCREMENT,
   `ad_group_id`          int not null,
   `ad_campaign_id`		int not null,
   `name`				varchar(255) not null,
   `note`				varchar(255) null,
   `company_id` INT NOT NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,						
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
   foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
   foreign key (`ad_group_id`) references lt_ad_group (`id`) on delete cascade on update cascade,
   foreign key (`ad_campaign_id`) references lt_ad_campaign (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists lt_ad_advertise_feed;
create table lt_ad_advertise_feed
(
   `id`                   int not null PRIMARY KEY AUTO_INCREMENT,
   `ad_advertise_id`			int not null,
   `ad_group_id`          int not null,
   `ad_campaign_id`		int not null,
   `company_id` INT NOT NULL,
   `item_id`              varchar(50) not null,
   `item_type`			varchar(255) not null default 'eBayListing',
   `item_keywords`        text null,
   `item_headline`        varchar(100)  not null,
   `item_sub_headline`    varchar(100) null,
   `item_description`     varchar(255) null,
   `item_address`         varchar(255) null,
   `price`                DECIMAL(20,4) not null default 0,
   `image_url`            varchar(500) not null,
   `item_category`        int null,
   `sale_price`           DECIMAL(20,4) null default 0,
   `remarketing_url`      varchar(500) not null,
   `destination_url`      varchar(500) not null,
   `final_url`      varchar(500) not null,
   `create_time_utc`      INT NULL DEFAULT 0,
   `create_user_id`       INT NULL DEFAULT 0,
   `update_time_utc`      INT NULL DEFAULT 0,
   `update_user_id`       INT NULL DEFAULT 0,
   foreign key (`ad_advertise_id`) references lt_ad_advertise (`id`) on delete cascade on update cascade,
   foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
   foreign key (`ad_group_id`) references lt_ad_group (`id`) on delete cascade on update cascade,
   foreign key (`ad_campaign_id`) references lt_ad_campaign (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists lt_ad_advertise_variation;
create table lt_ad_advertise_variation
(
   `id`                   int not null PRIMARY KEY AUTO_INCREMENT,
   `ad_group_id`          int not null,
   `ad_campaign_id`		int not null,
   `ad_advertise_id`              int not null,
   `company_id` INT NOT NULL,
   `type`             tinyint(4) not null default 3 comment '广告类型（1：文字 2：图片 3：创意广告）',
   `code`				int not null default 1 comment '1, flash;2,html5;',
   `status`               tinyint(4) not null default 0 comment '状态',
   `criteria`				text not null,
   `display_url`          varchar(500) not null comment '显示网址',
   `landing_page`			varchar(500) null default null,
   `width`				int not null default 0,
   `height`				int not null default 0,
   `is_delete`            tinyint(4) not null comment '逻辑删除标记（0：未删除 1：删除）',
   `create_time_utc`      INT NULL DEFAULT 0,
   `create_user_id`      INT NULL DEFAULT 0,
   `update_time_utc`      INT NULL DEFAULT 0,
   `update_user_id`       INT NULL DEFAULT 0,
   foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
   foreign key (`ad_advertise_id`) references lt_ad_advertise (`id`) on delete cascade on update cascade,
   foreign key (`ad_group_id`) references lt_ad_group (`id`) on delete cascade on update cascade,
   foreign key (`ad_campaign_id`) references lt_ad_campaign (`id`) on delete cascade on update cascade
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
  `object_type` varchar(255) NOT NULL comment '记录这条log对应对象的类名，比如ADCampaign',
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

DROP TABLE IF EXISTS `lt_google_adwords_category`;
CREATE TABLE `lt_google_adwords_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryId` int(11) NOT NULL,
  `CategoryName` varchar(100) DEFAULT NULL,
  `CategoryNameCn` varchar(100) DEFAULT NULL,
  `CategoryLevel` tinyint(4) DEFAULT NULL,
  `CategoryParentID` int(11) DEFAULT NULL,
  `CategoryValue` varchar(255) DEFAULT NULL,
  `CategoryDesc` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `google_adwords_category_id` (`id`) USING BTREE,
  KEY `google_adwords_category_id_2` (`CategoryId`) USING BTREE,
  KEY `google_adwords_category_parentId` (`CategoryParentID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table lt_ebay_category add column google_adwords_category_id int(11);
ALTER TABLE `lt_ebay_category` ADD INDEX `ebay_google_adwords_id` ( `google_adwords_category_id` ) USING BTREE;
ALTER TABLE `lt_ebay_category` ADD INDEX `ebay_category_parentId` ( `CategoryParentID` ) USING BTREE;

DROP TABLE IF EXISTS `lt_transaction_authorize`;
CREATE TABLE `lt_transaction_authorize` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `company_id` int(11) DEFAULT NULL COMMENT '关联lt_company.id',
  `amount` decimal(10,4) DEFAULT NULL COMMENT '冻结金额',
  `ref_id` int(11) DEFAULT NULL COMMENT '外键，关联表的id',
  `ref_object` varchar(30) DEFAULT NULL COMMENT '关联表的类型：google为“AdCampaign”',
  PRIMARY KEY (`id`),
  KEY `transaction_authorize_company_id` (`company_id`),
  CONSTRAINT `transaction_authorize_company_id` FOREIGN KEY (`company_id`) REFERENCES `lt_company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_ad`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_ad`;
CREATE TABLE `lt_google_adwords_ad` (
  `id` bigint(20) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `display_url` varchar(255) DEFAULT NULL,
  `final_urls` varchar(255) DEFAULT NULL,
  `final_mobile_urls` varchar(255) DEFAULT NULL,
  `final_app_urls` varchar(255) DEFAULT NULL,
  `tracking_url_template` varchar(255) DEFAULT NULL,
  `url_custom_parameters` text,
  `device_preference` bigint(20) DEFAULT NULL,
  `ad_type` varchar(255) DEFAULT NULL,
  `adGroupId` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_ad_group`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_ad_group`;
CREATE TABLE `lt_google_adwords_ad_group` (
  `id` bigint(20) NOT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(36) DEFAULT NULL,
  `settings` text,
  `experiment_data` text,
  `labels` text,
  `forward_compatibility_map` text,
  `bidding_strategy_configuration` text,
  `content_bid_criterionType_group` text,
  `tracking_url_template` varchar(255) DEFAULT NULL,
  `url_custom_parameters` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='adwords广告组';

-- ----------------------------
-- Table structure for `lt_google_adwords_ad_group_criterion`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_ad_group_criterion`;
CREATE TABLE `lt_google_adwords_ad_group_criterion` (
  `id` bigint(20) NOT NULL,
  `ad_group_id` bigint(20) DEFAULT NULL,
  `criterion_use` varchar(36) DEFAULT NULL,
  `criterion` text,
  `labels` text,
  `forward_compatibility_map` text,
  `ad_group_criterion_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_campaign`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_campaign`;
CREATE TABLE `lt_google_adwords_campaign` (
  `id` bigint(20) NOT NULL,
  `lt_campaign_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(36) DEFAULT NULL,
  `serving_status` varchar(36) DEFAULT NULL,
  `start_date` varchar(8) DEFAULT NULL,
  `end_date` varchar(8) DEFAULT NULL,
  `budget` bigint(20) DEFAULT NULL,
  `conversion_optimizer_eligibility` text,
  `adServing_optimization_status` varchar(20) DEFAULT NULL,
  `frequency_cap` text,
  `settings` text,
  `advertising_channel_type` varchar(10) DEFAULT NULL,
  `advertising_channel_sub_type` varchar(20) DEFAULT NULL,
  `network_setting` text,
  `labels` text,
  `bidding_strategy_configuration` text,
  `forward_compatibility_map` text,
  `tracking_url_template` text,
  `url_custom_parameters` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_campaign_criterion`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_campaign_criterion`;
CREATE TABLE `lt_google_adwords_campaign_criterion` (
  `id` bigint(20) NOT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `is_negative` bit(1) DEFAULT NULL,
  `criterion` text,
  `bid_modifier` double DEFAULT NULL,
  `forward_compatibility_map` text,
  `campaign_criterion_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_customer`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_customer`;
CREATE TABLE `lt_google_adwords_customer` (
  `id` bigint(20) NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `currency_code` varchar(20) DEFAULT NULL,
  `date_time_zone` varchar(8) DEFAULT NULL,
  `descriptive_name` varchar(8) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `can_manage_clients` bit(1) DEFAULT NULL,
  `test_account` bit(1) DEFAULT NULL,
  `auto_tagging_enabled` bit(1) DEFAULT NULL,
  `tracking_url_template` varchar(255) DEFAULT NULL,
  `conversion_tracking_settings` text,
  `remarketing_settings` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_report_ad`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_report_ad`;
CREATE TABLE `lt_google_adwords_report_ad` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` bigint(20) NOT NULL,
  `account_currency_code` varchar(255) DEFAULT NULL,
  `account_descriptive_name` varchar(255) DEFAULT NULL,
  `account_time_zone_id` varchar(255) DEFAULT NULL,
  `active_view_cpm` decimal(20,4) DEFAULT NULL,
  `active_view_impressions` int(11) DEFAULT NULL,
  `ad_group_ad_disapproval_reasons` text,
  `ad_group_id` bigint(20) DEFAULT NULL,
  `ad_group_name` varchar(255) DEFAULT NULL,
  `ad_group_status` varchar(36) DEFAULT NULL,
  `ad_network_type1` varchar(36) DEFAULT NULL,
  `ad_network_type2` varchar(36) DEFAULT NULL,
  `ad_type` varchar(36) DEFAULT NULL,
  `advertiser_experiment_segmentation_bin` text,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `average_pageviews` double DEFAULT NULL,
  `average_position` double DEFAULT NULL,
  `average_time_on_site` double DEFAULT NULL,
  `bounce_rate` double DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `click_assisted_conversion_value` double DEFAULT NULL,
  `click_assisted_conversions` int(11) DEFAULT NULL,
  `click_assisted_conversions_over_last_click_conversions` double DEFAULT NULL,
  `click_conversion_rate` double DEFAULT NULL,
  `click_conversion_rate_significance` text,
  `click_significance` text,
  `click_type` varchar(36) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `conversion_category_name` varchar(255) DEFAULT NULL,
  `conversion_many_per_click_significance` text,
  `conversion_rate_many_per_click` double DEFAULT NULL,
  `conversion_rate_many_per_click_significance` text,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(255) DEFAULT NULL,
  `conversion_value` double DEFAULT NULL,
  `conversions_many_per_click` int(11) DEFAULT NULL,
  `converted_clicks` int(11) DEFAULT NULL,
  `converted_clicks_significance` text,
  `cost` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click_significance` text,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click_significance` text,
  `cost_significance` text,
  `cpc_significance` text,
  `cpm_significance` text,
  `creative_approval_status` varchar(36) DEFAULT NULL,
  `creative_destination_url` varchar(255) DEFAULT NULL,
  `creative_final_app_urls` text,
  `creative_final_mobile_urls` text,
  `creative_final_urls` text,
  `creative_tracking_url_template` varchar(255) DEFAULT NULL,
  `creative_url_custom_parameters` text,
  `ctr` double DEFAULT NULL,
  `ctr_significance` text,
  `customer_descriptive_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `description1` varchar(255) DEFAULT NULL,
  `description2` varchar(255) DEFAULT NULL,
  `device` varchar(36) DEFAULT NULL,
  `device_preference` bigint(20) DEFAULT NULL,
  `display_url` varchar(255) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `headline` varchar(255) DEFAULT NULL,
  `image_ad_url` varchar(255) DEFAULT NULL,
  `image_creative_name` varchar(255) DEFAULT NULL,
  `impression_assisted_conversion_value` double DEFAULT NULL,
  `impression_assisted_conversions` int(11) DEFAULT NULL,
  `impression_assisted_conversions_over_last_click_conversions` double DEFAULT NULL,
  `impression_significance` text,
  `impressions` int(11) DEFAULT NULL,
  `is_negative` varchar(36) DEFAULT NULL,
  `keyword_id` bigint(20) DEFAULT NULL,
  `label_ids` text,
  `labels` text,
  `month` varchar(255) DEFAULT NULL,
  `month_of_year` varchar(10) DEFAULT NULL,
  `percent_new_visitors` double DEFAULT NULL,
  `position_significance` text,
  `primary_company_name` varchar(255) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `shared_set_name` varchar(255) DEFAULT NULL,
  `slot` text,
  `status` varchar(36) DEFAULT NULL,
  `trademarks` text,
  `value_per_conversion_many_per_click` double DEFAULT NULL,
  `value_per_converted_click` double DEFAULT NULL,
  `view_through_conversions` int(11) DEFAULT NULL,
  `view_through_conversions_significance` text,
  `week` varchar(10) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `generate_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_report_ad_group`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_report_ad_group`;
CREATE TABLE `lt_google_adwords_report_ad_group` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_group_id` bigint(20) NOT NULL,
  `account_currency_code` varchar(36) DEFAULT NULL,
  `account_descriptive_name` varchar(255) DEFAULT NULL,
  `account_time_zone_id` varchar(255) DEFAULT NULL,
  `active_view_cpm` decimal(20,4) DEFAULT NULL,
  `active_view_impressions` bigint(20) DEFAULT NULL,
  `ad_group_name` varchar(255) DEFAULT NULL,
  `ad_group_status` varchar(36) DEFAULT NULL,
  `ad_network_type1` varchar(36) DEFAULT NULL,
  `ad_network_type2` varchar(36) DEFAULT NULL,
  `advertiser_experiment_segmentation_bin` text,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `average_pageviews` double DEFAULT NULL,
  `average_position` double DEFAULT NULL,
  `average_time_on_site` double DEFAULT NULL,
  `avg_cost_for_offline_interaction` decimal(20,4) DEFAULT NULL,
  `bid_type` varchar(36) DEFAULT NULL,
  `bidding_strategy_id` bigint(20) DEFAULT NULL,
  `bidding_strategy_name` varchar(255) DEFAULT NULL,
  `bidding_strategy_type` varchar(36) DEFAULT NULL,
  `bounce_rate` double DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `click_assisted_conversion_value` double DEFAULT NULL,
  `click_assisted_conversions` bigint(20) DEFAULT NULL,
  `click_assisted_conversions_over_last_click_conversions` double DEFAULT NULL,
  `click_conversion_rate` double DEFAULT NULL,
  `click_conversion_rate_significance` text,
  `click_significance` text,
  `click_type` varchar(36) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `content_bid_criterion_type_group` varchar(36) DEFAULT NULL,
  `content_impression_share` double DEFAULT NULL,
  `content_rank_lost_impression_share` double DEFAULT NULL,
  `conversion_category_name` varchar(255) DEFAULT NULL,
  `conversion_many_per_click_significance` text,
  `conversion_rate_many_per_click` double DEFAULT NULL,
  `conversion_rate_many_per_click_significance` text,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(255) DEFAULT NULL,
  `conversion_value` double DEFAULT NULL,
  `conversions_many_per_click` int(11) DEFAULT NULL,
  `converted_clicks` int(11) DEFAULT NULL,
  `converted_clicks_significance` text,
  `cost` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click_significance` text,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click_significance` text,
  `cost_per_estimated_total_conversion` double DEFAULT NULL,
  `cost_significance` text,
  `cpc_bid` decimal(20,4) DEFAULT NULL,
  `cpc_significance` text,
  `cpm_bid` decimal(20,4) DEFAULT NULL,
  `cpm_significance` text,
  `ctr` double DEFAULT NULL,
  `ctr_significance` text,
  `customer_descriptive_name` varchar(255) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `device` varchar(36) DEFAULT NULL,
  `enhanced_cpc_enabled` varchar(36) DEFAULT NULL,
  `estimated_cross_device_conversions` int(11) DEFAULT NULL,
  `estimated_total_conversion_rate` double DEFAULT NULL,
  `estimated_total_conversion_value` double DEFAULT NULL,
  `estimated_total_conversion_value_per_click` double DEFAULT NULL,
  `estimated_total_conversion_value_per_cost` double DEFAULT NULL,
  `estimated_total_conversions` int(11) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `hour_of_day` int(11) DEFAULT NULL,
  `impression_assisted_conversion_value` double DEFAULT NULL,
  `impression_assisted_conversions` int(11) DEFAULT NULL,
  `impression_assisted_conversions_over_last_click_conversions` double DEFAULT NULL,
  `impression_significance` text,
  `impressions` int(11) DEFAULT NULL,
  `label_ids` text,
  `labels` text,
  `month` varchar(10) DEFAULT NULL,
  `month_of_year` varchar(255) DEFAULT NULL,
  `num_offline_impressions` int(11) DEFAULT NULL,
  `num_offline_interactions` int(11) DEFAULT NULL,
  `offline_interaction_cost` decimal(20,4) DEFAULT NULL,
  `offline_interaction_rate` double DEFAULT NULL,
  `percent_new_visitors` double DEFAULT NULL,
  `position_significance` text,
  `primary_company_name` varchar(255) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `relative_ctr` double DEFAULT NULL,
  `search_exact_match_impression_share` double DEFAULT NULL,
  `search_impression_share` double DEFAULT NULL,
  `search_rank_lost_impression_share` double DEFAULT NULL,
  `slot` text,
  `target_cpa` decimal(20,4) DEFAULT NULL,
  `total_cost` decimal(20,4) DEFAULT NULL,
  `tracking_url_template` varchar(255) DEFAULT NULL,
  `url_custom_parameters` text,
  `value_per_conversion_many_per_click` double DEFAULT NULL,
  `value_per_converted_click` double DEFAULT NULL,
  `value_per_estimated_total_conversion` double DEFAULT NULL,
  `view_through_conversions` int(11) DEFAULT NULL,
  `view_through_conversions_significance` text,
  `week` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `generate_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_report_automatic_placements`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_report_automatic_placements`;
CREATE TABLE `lt_google_adwords_report_automatic_placements` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` bigint(20) NOT NULL,
  `account_currency_code` varchar(255) DEFAULT NULL,
  `account_descriptive_name` varchar(255) DEFAULT NULL,
  `account_time_zone_id` varchar(255) DEFAULT NULL,
  `active_view_cpm` decimal(20,4) DEFAULT NULL,
  `active_view_impressions` int(11) DEFAULT NULL,
  `ad_format` text,
  `ad_group_id` bigint(20) DEFAULT NULL,
  `ad_group_name` varchar(255) DEFAULT NULL,
  `ad_group_status` varchar(36) DEFAULT NULL,
  `ad_network_type1` varchar(36) DEFAULT NULL,
  `ad_network_type2` varchar(36) DEFAULT NULL,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `click_conversion_rate` double DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `conversion_category_name` varchar(255) DEFAULT NULL,
  `conversion_rate_many_per_click` double DEFAULT NULL,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(255) DEFAULT NULL,
  `conversion_value` double DEFAULT NULL,
  `conversions_many_per_click` int(11) DEFAULT NULL,
  `converted_clicks` int(11) DEFAULT NULL,
  `cost` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `criteria_parameters` varchar(255) DEFAULT NULL,
  `ctr` double DEFAULT NULL,
  `customer_descriptive_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `is_auto_optimized` tinyint(1) DEFAULT NULL,
  `is_bid_on_path` tinyint(1) DEFAULT NULL,
  `is_path_excluded` tinyint(1) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `month_of_year` varchar(10) DEFAULT NULL,
  `primary_company_name` varchar(255) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `value_per_conversion_many_per_click` double DEFAULT NULL,
  `value_per_converted_click` double DEFAULT NULL,
  `view_through_conversions` int(11) DEFAULT NULL,
  `week` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `generate_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_report_campaign`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_report_campaign`;
CREATE TABLE `lt_google_adwords_report_campaign` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_currency_code` varchar(20) DEFAULT NULL,
  `account_descriptive_name` varchar(255) DEFAULT NULL,
  `account_time_zone_id` varchar(36) DEFAULT NULL,
  `active_view_cpm` decimal(20,4) DEFAULT NULL,
  `active_view_impressions` int(11) DEFAULT NULL,
  `ad_network_type1` text,
  `ad_network_type2` text,
  `advertiser_experiment_segmentation_bin` text,
  `advertising_channel_sub_type` varchar(36) DEFAULT NULL,
  `advertising_channel_type` varchar(36) DEFAULT NULL,
  `amount` decimal(20,4) DEFAULT NULL,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `average_frequency` double DEFAULT NULL,
  `average_pageviews` double DEFAULT NULL,
  `average_position` double DEFAULT NULL,
  `average_time_on_site` double DEFAULT NULL,
  `avg_cost_for_offline_interaction` decimal(20,4) DEFAULT NULL,
  `bid_type` varchar(36) DEFAULT NULL,
  `bidding_strategy_id` bigint(20) DEFAULT NULL,
  `bidding_strategy_name` varchar(255) DEFAULT NULL,
  `bidding_strategy_type` varchar(36) DEFAULT NULL,
  `bounce_rate` double DEFAULT NULL,
  `budget_id` bigint(20) DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `click_assisted_conversion_value` double DEFAULT NULL,
  `click_assisted_conversions` int(11) DEFAULT NULL,
  `click_assisted_conversions_over_last_click_conversions` double DEFAULT NULL,
  `click_conversion_rate` double DEFAULT NULL,
  `click_conversion_rate_significance` text,
  `click_significance` text,
  `click_type` varchar(36) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `content_budget_lost_impression_share` double DEFAULT NULL,
  `content_impression_share` double DEFAULT NULL,
  `content_rank_lost_impression_share` double DEFAULT NULL,
  `conversion_category_name` varchar(255) DEFAULT NULL,
  `conversion_many_per_click_significance` text,
  `conversion_rate_many_per_click` double DEFAULT NULL,
  `conversion_rate_many_per_click_significance` text,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(255) DEFAULT NULL,
  `conversion_value` double DEFAULT NULL,
  `conversions_many_per_click` int(11) DEFAULT NULL,
  `converted_clicks` int(11) DEFAULT NULL,
  `converted_clicks_significance` text,
  `cost` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click_significance` text,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click_significance` text,
  `cost_per_estimated_total_conversion` double DEFAULT NULL,
  `cost_significance` text,
  `cpc_significance` text,
  `cpm_significance` text,
  `ctr` double DEFAULT NULL,
  `ctr_significance` text,
  `customer_descriptive_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `day_of_week` varchar(36) DEFAULT NULL,
  `device` varchar(36) DEFAULT NULL,
  `enhanced_cpc_enabled` varchar(36) DEFAULT NULL,
  `estimated_cross_device_conversions` int(11) DEFAULT NULL,
  `estimated_total_conversion_rate` double DEFAULT NULL,
  `estimated_total_conversion_value` double DEFAULT NULL,
  `estimated_total_conversion_value_per_click` double DEFAULT NULL,
  `estimated_total_conversion_value_per_cost` double DEFAULT NULL,
  `estimated_total_conversions` int(11) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `hour_of_day` int(11) DEFAULT NULL,
  `impression_assisted_conversion_value` double DEFAULT NULL,
  `impression_assisted_conversions` int(11) DEFAULT NULL,
  `impression_assisted_conversions_over_last_click_conversions` double DEFAULT NULL,
  `impression_reach` int(11) DEFAULT NULL,
  `impression_significance` text,
  `impressions` int(11) DEFAULT NULL,
  `invalid_click_rate` double DEFAULT NULL,
  `invalid_clicks` int(11) DEFAULT NULL,
  `is_budget_explicitly_shared` varchar(36) DEFAULT NULL,
  `label_ids` text,
  `labels` text,
  `month` varchar(10) DEFAULT NULL,
  `month_of_year` varchar(36) DEFAULT NULL,
  `num_offline_impressions` int(11) DEFAULT NULL,
  `num_offline_interactions` int(11) DEFAULT NULL,
  `offline_interaction_cost` decimal(20,4) DEFAULT NULL,
  `offline_interaction_rate` double DEFAULT NULL,
  `percent_new_visitors` double DEFAULT NULL,
  `period` text,
  `position_significance` text,
  `primary_company_name` varchar(255) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `relative_ctr` double DEFAULT NULL,
  `search_budget_lost_impression_share` double DEFAULT NULL,
  `search_exact_match_impression_share` double DEFAULT NULL,
  `search_impression_share` double DEFAULT NULL,
  `search_rank_lost_impression_share` double DEFAULT NULL,
  `serving_status` varchar(36) DEFAULT NULL,
  `slot` text,
  `total_budget` decimal(20,4) DEFAULT NULL,
  `total_cost` decimal(20,4) DEFAULT NULL,
  `tracking_url_template` varchar(255) DEFAULT NULL,
  `url_custom_parameters` text,
  `value_per_conversion_many_per_click` double DEFAULT NULL,
  `value_per_converted_click` double DEFAULT NULL,
  `value_per_estimated_total_conversion` double DEFAULT NULL,
  `view_through_conversions` int(11) DEFAULT NULL,
  `view_through_conversions_significance` text,
  `week` varchar(10) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `generate_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_report_destination_url`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_report_destination_url`;
CREATE TABLE `lt_google_adwords_report_destination_url` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_currency_code` varchar(255) DEFAULT NULL,
  `account_descriptive_name` varchar(255) DEFAULT NULL,
  `account_time_zone_id` varchar(255) DEFAULT NULL,
  `active_view_cpm` decimal(20,4) DEFAULT NULL,
  `active_view_impressions` int(11) DEFAULT NULL,
  `ad_group_id` bigint(20) DEFAULT NULL,
  `ad_group_name` varchar(255) DEFAULT NULL,
  `ad_group_status` varchar(36) DEFAULT NULL,
  `ad_network_type1` varchar(36) DEFAULT NULL,
  `ad_network_type2` varchar(36) DEFAULT NULL,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `average_position` double DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `click_conversion_rate` double DEFAULT NULL,
  `click_type` varchar(36) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `conversion_category_name` varchar(255) DEFAULT NULL,
  `conversion_rate_many_per_click` double DEFAULT NULL,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(255) DEFAULT NULL,
  `conversion_value` double DEFAULT NULL,
  `conversions_many_per_click` int(11) DEFAULT NULL,
  `converted_clicks` int(11) DEFAULT NULL,
  `cost` varchar(36) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `criteria_destination_url` varchar(255) DEFAULT NULL,
  `criteria_parameters` varchar(255) DEFAULT NULL,
  `criteria_status` varchar(36) DEFAULT NULL,
  `criteria_type_name` varchar(255) DEFAULT NULL,
  `ctr` double DEFAULT NULL,
  `customer_descriptive_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `device` varchar(36) DEFAULT NULL,
  `effective_destination_url` varchar(255) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `is_negative` varchar(36) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `month_of_year` varchar(10) DEFAULT NULL,
  `primary_company_name` varchar(255) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `slot` text,
  `value_per_conversion_many_per_click` double DEFAULT NULL,
  `value_per_converted_click` double DEFAULT NULL,
  `view_through_conversions` int(11) DEFAULT NULL,
  `week` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `generate_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_report_geo`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_report_geo`;
CREATE TABLE `lt_google_adwords_report_geo` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_currency_code` varchar(255) DEFAULT NULL,
  `account_descriptive_name` varchar(255) DEFAULT NULL,
  `account_time_zone_id` varchar(255) DEFAULT NULL,
  `ad_format` varchar(36) DEFAULT NULL,
  `ad_group_id` bigint(20) DEFAULT NULL,
  `ad_group_name` varchar(255) DEFAULT NULL,
  `ad_group_status` varchar(36) DEFAULT NULL,
  `ad_network_type1` varchar(36) DEFAULT NULL,
  `ad_network_type2` varchar(36) DEFAULT NULL,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `average_position` double DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `city_criteria_id` varchar(20) DEFAULT NULL,
  `click_conversion_rate` double DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `conversion_category_name` varchar(255) DEFAULT NULL,
  `conversion_rate_many_per_click` double DEFAULT NULL,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(255) DEFAULT NULL,
  `conversion_value` double DEFAULT NULL,
  `conversions_many_per_click` int(11) DEFAULT NULL,
  `converted_clicks` int(11) DEFAULT NULL,
  `cost` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `country_criteria_id` bigint(20) DEFAULT NULL,
  `ctr` double DEFAULT NULL,
  `customer_descriptive_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `device` varchar(36) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `is_targeting_location` varchar(36) DEFAULT NULL,
  `location_type` varchar(36) DEFAULT NULL,
  `metro_criteria_id` varchar(20) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `month_of_year` varchar(10) DEFAULT NULL,
  `most_specific_criteria_id` bigint(20) DEFAULT NULL,
  `primary_company_name` varchar(255) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `region_criteria_id` varchar(20) DEFAULT NULL,
  `value_per_conversion_many_per_click` double DEFAULT NULL,
  `value_per_converted_click` double DEFAULT NULL,
  `view_through_conversions` bigint(20) DEFAULT NULL,
  `week` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `generate_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15502 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_report_placement`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_report_placement`;
CREATE TABLE `lt_google_adwords_report_placement` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_currency_code` varchar(255) DEFAULT NULL,
  `account_descriptive_name` varchar(255) DEFAULT NULL,
  `account_time_zone_id` varchar(255) DEFAULT NULL,
  `active_view_cpm` decimal(20,4) DEFAULT NULL,
  `active_view_impressions` int(11) DEFAULT NULL,
  `ad_group_id` bigint(20) DEFAULT NULL,
  `ad_group_name` varchar(255) DEFAULT NULL,
  `ad_group_status` varchar(36) DEFAULT NULL,
  `ad_network_type1` varchar(36) DEFAULT NULL,
  `ad_network_type2` varchar(36) DEFAULT NULL,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `bid_modifier` double DEFAULT NULL,
  `bid_type` varchar(36) DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `click_conversion_rate` double DEFAULT NULL,
  `click_type` varchar(36) DEFAULT NULL,
  `clicks` bigint(20) DEFAULT NULL,
  `conversion_category_name` varchar(255) DEFAULT NULL,
  `conversion_rate_many_per_click` double DEFAULT NULL,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(255) DEFAULT NULL,
  `conversion_value` double DEFAULT NULL,
  `conversions_many_per_click` bigint(20) DEFAULT NULL,
  `converted_clicks` bigint(20) DEFAULT NULL,
  `cost` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `cpc_bid` decimal(20,4) DEFAULT NULL,
  `cpc_bid_source` text,
  `cpm_bid` decimal(20,4) DEFAULT NULL,
  `cpm_bid_source` text,
  `criteria_destination_url` varchar(255) DEFAULT NULL,
  `ctr` double DEFAULT NULL,
  `customer_descriptive_name` varchar(255) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `device` varchar(36) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `final_app_urls` text,
  `final_mobile_urls` text,
  `final_urls` text,
  `impressions` bigint(20) DEFAULT NULL,
  `is_negative` varchar(36) DEFAULT NULL,
  `is_restrict` varchar(36) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `month_of_year` varchar(10) DEFAULT NULL,
  `placement_url` varchar(255) DEFAULT NULL,
  `primary_company_name` varchar(255) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `status` varchar(36) DEFAULT NULL,
  `tracking_url_template` varchar(255) DEFAULT NULL,
  `url_custom_parameters` text,
  `value_per_conversion_many_per_click` double DEFAULT NULL,
  `value_per_converted_click` double DEFAULT NULL,
  `view_through_conversions` bigint(20) DEFAULT NULL,
  `week` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `generate_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lt_google_adwords_userlist`
-- ----------------------------
DROP TABLE IF EXISTS `lt_google_adwords_userlist`;
CREATE TABLE `lt_google_adwords_userlist` (
  `id` bigint(20) NOT NULL,
  `is_readonly` bit(1) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(36) DEFAULT NULL,
  `integration_code` varchar(255) DEFAULT NULL,
  `access_reason` varchar(36) DEFAULT NULL,
  `account_userlist_status` varchar(36) DEFAULT NULL,
  `membership_life_span` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `size_range` varchar(36) DEFAULT NULL,
  `size_for_search` int(11) DEFAULT NULL,
  `size_range_for_search` varchar(36) DEFAULT NULL,
  `list_type` varchar(36) DEFAULT NULL,
  `userlist_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-04-14*/

/*start 2015/04/16*/
alter table lt_transaction_payment_account rename to lt_transaction_paypal_account;
alter table lt_transaction add ref_id int(11);
alter table lt_transaction add ref_object varchar(30);
alter table lt_transaction change `type` payment_transaction_type varchar(20);
alter table lt_transaction change transaction_type `type` varchar(20);
/*end 2015-04-16*/