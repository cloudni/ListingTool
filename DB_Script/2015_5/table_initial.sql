/*start 2015/05/11 */
ALTER TABLE lt_company CHANGE COLUMN freeze_amount authorize_amount decimal(20, 4) DEFAULT 0 COMMENT '冻结金额';
ALTER TABLE lt_company MODIFY COLUMN balance decimal(20, 4) DEFAULT 0 COMMENT '账户余额';
ALTER TABLE lt_transaction MODIFY COLUMN `type` tinyint(4) COMMENT '支付平台类型：1 Paypal; 2 System';
/*end 2015/05/11*/

/*start 2015-05-12*/
drop table if exists `lt_wish_listing`;
CREATE TABLE `lt_wish_listing` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `company_id` INT NOT NULL,
  `store_id` INT NOT NULL,
  `wish_id` VARCHAR(255) NOT NULL,
  `main_image` VARCHAR(500) NULL,
  `description` TEXT NULL,
  `name` VARCHAR(255) NULL,
  `review_status` VARCHAR(255) NULL,
  `upc` VARCHAR(255) NULL,
  `extra_images` VARCHAR(255) NULL,
  `landing_page_url` VARCHAR(255) NULL,
  `number_saves` INT NULL,
  `number_sold` INT NULL,
  `parent_sku` VARCHAR(255) NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
  foreign key (`store_id`) references lt_store (`id`) on delete cascade on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `lt_store` ADD COLUMN `wish_token` VARCHAR(500) NULL AFTER `ebay_site_code`;
/*end 2015-05-12*/

/*start 2015-05-14*/
ALTER TABLE `lt_ad_advertise_feed` CHANGE COLUMN `item_type` `item_type` INT NOT NULL DEFAULT 1 ;
/*end 2015-05-14*/

/*start 2015-05-28*/
DROP TABLE IF EXISTS `lt_ebay_lms_log`;
CREATE TABLE `lt_ebay_lms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '类型：1、插入pixel',
  `cmd_date` varchar(20) NOT NULL COMMENT '执行时间，代表某个批次，如：20150527124354',
  `company_id` int(11) NOT NULL COMMENT '所属企业',
  `store_id` int(11) NOT NULL COMMENT '所属门店',
  `site_id` int(11) NOT NULL COMMENT '所属站点',
  `interface_name` varchar(100) NOT NULL COMMENT '对应ebaytrade api接口名称，如"ReviseItem“',
  `item_id` varchar(50) DEFAULT NULL,
  `ack` varchar(20) NOT NULL COMMENT '状态：如成功、失败、终止',
  `short_message` varchar(1000) DEFAULT NULL COMMENT '原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table lt_ad_google_adwords_report_ad drop COLUMN pk_id;
alter table lt_ad_google_adwords_report_ad_group drop COLUMN pk_id;
alter table lt_ad_google_adwords_report_automatic_placements drop COLUMN pk_id;
alter table lt_ad_google_adwords_report_campaign drop COLUMN id;
alter table lt_ad_google_adwords_report_destination_url drop COLUMN pk_id;
alter table lt_ad_google_adwords_report_geo drop COLUMN pk_id;

alter table lt_ad_google_adwords_report_ad MODIFY is_charged tinyint(1) DEFAULT 0;
alter table lt_ad_google_adwords_report_ad_group MODIFY is_charged tinyint(1) DEFAULT 0;
alter table lt_ad_google_adwords_report_automatic_placements MODIFY is_charged tinyint(1) DEFAULT 0;
alter table lt_ad_google_adwords_report_campaign MODIFY is_charged tinyint(1) DEFAULT 0;
alter table lt_ad_google_adwords_report_destination_url MODIFY is_charged tinyint(1) DEFAULT 0;
alter table lt_ad_google_adwords_report_geo MODIFY is_charged tinyint(1) DEFAULT 0;

DROP TABLE IF EXISTS lt_ad_google_adwords_report_campaign_temp;
/*end 2015-05-28*/

/*start 2015-06-02*/
ALTER TABLE lt_transaction add COLUMN ref_date VARCHAR(20);
ALTER TABLE lt_transaction_detail add COLUMN ref_date VARCHAR(20);
/*end 2015-06-02*/

/** 2015-06-08*/
DROP TABLE IF EXISTS `lt_google_adwords_userlist`;
DROP TABLE IF EXISTS `lt_google_adwords_audience`;
CREATE TABLE `lt_google_adwords_audience` (
  `pk_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id` bigint(20) DEFAULT NULL,
  `is_read_only` bit(1) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `integration_code` varchar(32) DEFAULT NULL,
  `access_reason` varchar(20) DEFAULT NULL,
  `account_user_list_status` varchar(20) DEFAULT NULL,
  `membership_life_span` bigint(20) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `size_range` varchar(64) DEFAULT NULL,
  `size_for_search` bigint(20) DEFAULT NULL,
  `size_range_for_search` varchar(64) DEFAULT NULL,
  `list_type` varchar(32) DEFAULT NULL,
  `user_list_type` varchar(32) DEFAULT NULL,
  `rule` text,
  `is_run`  bit(1) DEFAULT false,
  `create_time_utc` int(11) DEFAULT '0',
  `create_user_id` int(11) DEFAULT '0',
  `update_time_utc` int(11) DEFAULT '0',
  `update_user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-06-08*/

/*start 2015-06-02*/
ALTER TABLE lt_transaction add COLUMN ref_date VARCHAR(20);
ALTER TABLE lt_transaction_detail add COLUMN ref_date VARCHAR(20);
/*end 2015-06-02*/

/*start 2015-06-15*/
CREATE getCategoryIdLevel1 (category_id VARCHAR(20),
	site_id INTEGER)
 RETURNS varchar(60)
BEGIN
	DECLARE temp_category_id VARCHAR(20);
	DECLARE temp_level INTEGER;

	SET temp_category_id = category_id;
	
	SELECT CategoryLevel INTO temp_level
		FROM lt_ebay_category 
		where CategoryID = temp_category_id 
		and CategorySiteID = site_id;

	WHILE temp_level > 1 DO
			SELECT CategoryParentID, CategoryLevel 
				INTO temp_category_id, temp_level
				FROM lt_ebay_category 
				where CategoryID = temp_category_id 
				and CategorySiteID = site_id;
	END WHILE; 
	RETURN temp_category_id;

END;
/*end 2015-06-15*/

/*start 2015-06-17*/
DROP TABLE IF EXISTS `lt_google_adwords_report_keywords`;
CREATE TABLE `lt_google_adwords_report_keywords` (
  `account_currency_code` varchar(256) DEFAULT NULL,
  `account_descriptive_name` varchar(256) DEFAULT NULL,
  `account_time_zone_id` varchar(256) DEFAULT NULL,
  `active_view_cpm` decimal(20,4) DEFAULT NULL,
  `active_view_impressions` bigint(20) DEFAULT NULL,
  `ad_group_id` bigint(20) DEFAULT NULL,
  `ad_group_name` varchar(256) DEFAULT NULL,
  `ad_group_status` varchar(36) DEFAULT NULL,
  `ad_network_type1` varchar(36) DEFAULT NULL,
  `ad_network_type2` varchar(36) DEFAULT NULL,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `bid_type` varchar(36) DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(256) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `click_conversion_rate` decimal(20,4) DEFAULT NULL,
  `click_type` varchar(36) DEFAULT NULL,
  `clicks` bigint(20) DEFAULT NULL,
  `conversion_category_name` varchar(256) DEFAULT NULL,
  `conversion_rate_many_per_click` decimal(20,4) DEFAULT NULL,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(256) DEFAULT NULL,
  `conversion_value` decimal(20,4) DEFAULT NULL,
  `conversions_many_per_click` bigint(20) DEFAULT NULL,
  `converted_clicks` bigint(20) DEFAULT NULL,
  `cost` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `cpc_bid` decimal(20,4) DEFAULT NULL,
  `cpc_bid_source` varchar(36) DEFAULT NULL,
  `cpm_bid` decimal(20,4) DEFAULT NULL,
  `cpm_bid_source` varchar(36) DEFAULT NULL,
  `criteria_destination_url` varchar(256) DEFAULT NULL,
  `ctr` decimal(20,4) DEFAULT NULL,
  `customer_descriptive_name` varchar(256) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `day_of_week` varchar(36) DEFAULT NULL,
  `device` varchar(36) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `final_app_urls` text,
  `final_mobile_urls` text,
  `final_urls` text,
  `id` bigint(20) DEFAULT NULL,
  `impressions` bigint(20) DEFAULT NULL,
  `is_negative` varchar(36) DEFAULT NULL,
  `is_restrict` varchar(36) DEFAULT NULL,
  `keyword_text` varchar(256) DEFAULT NULL,
  `month` varchar(256) DEFAULT NULL,
  `month_of_year` varchar(36) DEFAULT NULL,
  `primary_company_name` varchar(256) DEFAULT NULL,
  `quarter` varchar(256) DEFAULT NULL,
  `status` varchar(36) DEFAULT NULL,
  `tracking_url_template` varchar(256) DEFAULT NULL,
  `url_custom_parameters` varchar(256) DEFAULT NULL,
  `value_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `value_per_converted_click` decimal(20,4) DEFAULT NULL,
  `view_through_conversions` bigint(20) DEFAULT NULL,
  `week` varchar(256) DEFAULT NULL,
  `year` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE lt_ad_google_adwords_report_keywords LIKE lt_google_adwords_report_keywords;
  
ALTER TABLE lt_ad_google_adwords_report_keywords ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_google_adwords_report_keywords ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_keywords ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_keywords ADD COLUMN lt_ad_group_id int(11);
ALTER TABLE lt_ad_google_adwords_report_keywords ADD COLUMN is_charged tinyint(1) default '0';
/*end 2015-06-17*/

/*start 2015-06-24*/
ALTER TABLE lt_ebay_detail ADD COLUMN site_name varchar(36) DEFAULT NULL;

DROP TABLE IF EXISTS `lt_google_adwords_report_url`;
CREATE TABLE `lt_google_adwords_report_url` (
  `account_currency_code` varchar(256) DEFAULT NULL,
  `account_descriptive_name` varchar(256) DEFAULT NULL,
  `account_time_zone_id` varchar(256) DEFAULT NULL,
  `active_view_cpm` decimal(20,4) DEFAULT NULL,
  `active_view_impressions` bigint(20) DEFAULT NULL,
  `ad_format` varchar(36) DEFAULT NULL,
  `ad_group_criterion_status` varchar(36) DEFAULT NULL,
  `ad_group_id` bigint(20) DEFAULT NULL,
  `ad_group_name` varchar(256) DEFAULT NULL,
  `ad_group_status` varchar(36) DEFAULT NULL,
  `ad_network_type1` varchar(36) DEFAULT NULL,
  `ad_network_type2` varchar(36) DEFAULT NULL,
  `average_cpc` decimal(20,4) DEFAULT NULL,
  `average_cpm` decimal(20,4) DEFAULT NULL,
  `campaign_id` bigint(20) DEFAULT NULL,
  `campaign_name` varchar(256) DEFAULT NULL,
  `campaign_status` varchar(36) DEFAULT NULL,
  `click_conversion_rate` decimal(20,4) DEFAULT NULL,
  `clicks` bigint(20) DEFAULT NULL,
  `conversion_category_name` varchar(256) DEFAULT NULL,
  `conversion_rate_many_per_click` decimal(20,4) DEFAULT NULL,
  `conversion_tracker_id` bigint(20) DEFAULT NULL,
  `conversion_type_name` varchar(256) DEFAULT NULL,
  `conversion_value` decimal(20,4) DEFAULT NULL,
  `conversions_many_per_click` bigint(20) DEFAULT NULL,
  `converted_clicks` bigint(20) DEFAULT NULL,
  `cost` decimal(20,4) DEFAULT NULL,
  `cost_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `cost_per_converted_click` decimal(20,4) DEFAULT NULL,
  `criteria_parameters` varchar(256) DEFAULT NULL,
  `ctr` decimal(20,4) DEFAULT NULL,
  `customer_descriptive_name` varchar(256) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `day_of_week` varchar(36) DEFAULT NULL,
  `display_name` varchar(256) DEFAULT NULL,
  `domain` varchar(256) DEFAULT NULL,
  `external_customer_id` bigint(20) DEFAULT NULL,
  `impressions` bigint(20) DEFAULT NULL,
  `is_auto_optimized` varchar(36) DEFAULT NULL,
  `is_bid_on_path` varchar(36) DEFAULT NULL,
  `is_path_excluded` varchar(36) DEFAULT NULL,
  `month` varchar(256) DEFAULT NULL,
  `month_of_year` varchar(36) DEFAULT NULL,
  `primary_company_name` varchar(256) DEFAULT NULL,
  `quarter` varchar(256) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `value_per_conversion_many_per_click` decimal(20,4) DEFAULT NULL,
  `value_per_converted_click` decimal(20,4) DEFAULT NULL,
  `view_through_conversions` bigint(20) DEFAULT NULL,
  `week` varchar(256) DEFAULT NULL,
  `year` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-06-24*/

/*start 2015-07-09*/
DROP TABLE IF EXISTS `lt_google_analytics_report_audience_overview`;
CREATE TABLE `lt_google_analytics_report_audience_overview` (
  `date` date NOT NULL,
  `sessions` int(11) DEFAULT NULL,
  `users` int(11) DEFAULT NULL,
  `pageviews` int(11) DEFAULT NULL,
  `pageviews_per_session` decimal(20,4) DEFAULT NULL,
  `avg_session_duration` decimal(20,4) DEFAULT NULL,
  `bounce_rate` decimal(20,4) DEFAULT NULL,
  `percent_new_sessions` decimal(20,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-07-09*/

/*start 2015-08-07*/
DROP TABLE IF EXISTS `lt_google_analytics_report_page_path`;
CREATE TABLE `lt_google_analytics_report_page_path` (
  `date` date NOT NULL,
  `property` varchar(64) NOT NULL,
  `page` varchar(512) NOT NULL,
  `sessions` int(11) DEFAULT NULL,
  `bounce_rate` decimal(20,4) DEFAULT NULL,
  `session_duration` decimal(20,4) DEFAULT NULL,
  `pageviews_per_session` decimal(20,4) DEFAULT NULL,
  `avg_time_on_page` decimal(20,4) DEFAULT NULL,
  `unique_pageviews` int(11) DEFAULT NULL,
  `entrances` int(11) DEFAULT NULL,
  `pageviews` int(11) DEFAULT NULL,
  `exits` int(11) DEFAULT NULL,
  `avg_session_duration` decimal(20,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-08-07*/

/*start 2015-08-14*/
DROP TABLE IF EXISTS `lt_facebook_report_campaign`;
CREATE TABLE `lt_facebook_report_campaign` (
  `date` date NOT NULL,
  `campaign_id` varchar(14) NOT NULL,
  `campaign_name` varchar(36) DEFAULT NULL,
  `placement` varchar(255) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `cpm` decimal(20,4) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `ctr` decimal(20,4) DEFAULT NULL,
  `cpc` decimal(20,4) DEFAULT NULL,
  `cost` decimal(20,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lt_facebook_report_ad_set`;
CREATE TABLE `lt_facebook_report_ad_set` (
  `date` date NOT NULL,
  `campaign_id` varchar(14) NOT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `ad_set_id` varchar(14) DEFAULT NULL,
  `ad_set_name` varchar(255) DEFAULT NULL,
  `placement` varchar(255) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `cpm` decimal(20,4) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `ctr` decimal(20,4) DEFAULT NULL,
  `cpc` decimal(20,4) DEFAULT NULL,
  `cost` decimal(20,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lt_facebook_report_ad`;
CREATE TABLE `lt_facebook_report_ad` (
  `date` date NOT NULL,
  `campaign_id` varchar(14) NOT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `ad_set_id` varchar(14) DEFAULT NULL,
  `ad_set_name` varchar(255) DEFAULT NULL,
  `ad_id` varchar(14) DEFAULT NULL,
  `placement` varchar(255) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `cpm` decimal(20,4) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `ctr` decimal(20,4) DEFAULT NULL,
  `cpc` decimal(20,4) DEFAULT NULL,
  `cost` decimal(20,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-08-14*/

/*start 2015-08-21*/
DROP TABLE IF EXISTS `lt_facebook_ad`;
CREATE TABLE `lt_facebook_ad` (
  `id` varchar(14) DEFAULT NULL,
  `lt_ad_advertise_variation_id` int null,
  `account_id` varchar(14) DEFAULT NULL,
  `adgroup_review_feedback` varchar(1024) DEFAULT NULL,
  `adgroup_status` varchar(36) DEFAULT NULL,
  `bid_amount` int(11) DEFAULT NULL,
  `bid_info` varchar(512) DEFAULT NULL,
  `campaign_id` varchar(14) DEFAULT NULL,
  `campaign_group_id` varchar(14) DEFAULT NULL,
  `conversion_specs` varchar(512) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  `creative` varchar(1024) DEFAULT NULL,
  `failed_delivery_checks` varchar(1024) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `targeting` varchar(1024) DEFAULT NULL,
  `tracking_specs` varchar(1024) DEFAULT NULL,
  `updated_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-08-21*/

/*start 2015-08-24*/
DROP TABLE IF EXISTS lt_ad_facebook_report_ad;
CREATE TABLE lt_ad_facebook_report_ad LIKE lt_facebook_report_ad;
  
ALTER TABLE lt_ad_facebook_report_ad ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_facebook_report_ad ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_facebook_report_ad ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_facebook_report_ad ADD COLUMN lt_ad_advertise_id int(11);
ALTER TABLE lt_ad_facebook_report_ad ADD COLUMN is_charged tinyint(1) default '0';

DROP TABLE IF EXISTS lt_ad_facebook_report_campaign;
CREATE TABLE lt_ad_facebook_report_campaign LIKE lt_facebook_report_campaign;
  
ALTER TABLE lt_ad_facebook_report_campaign ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_facebook_report_campaign ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_facebook_report_campaign ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_facebook_report_campaign ADD COLUMN lt_ad_group_id int(11);
ALTER TABLE lt_ad_facebook_report_campaign ADD COLUMN is_charged tinyint(1) default '0';

DROP TABLE IF EXISTS lt_ad_facebook_report_ad_set;
CREATE TABLE lt_ad_facebook_report_ad_set LIKE lt_facebook_report_ad_set;
  
ALTER TABLE lt_ad_facebook_report_ad_set ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_facebook_report_ad_set ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_facebook_report_ad_set ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_facebook_report_ad_set ADD COLUMN lt_ad_campaign_id int(11);
ALTER TABLE lt_ad_facebook_report_ad_set ADD COLUMN is_charged tinyint(1) default '0';
/*end 2015-08-24*/