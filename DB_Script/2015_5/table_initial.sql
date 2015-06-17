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

/*start 2015-06-17*/
DROP TABLE IF EXISTS `lt_google_adwords_report_keywords`;
CREATE TABLE `lt_google_adwords_report_keywords` (
	account_currency_code	varchar(256) DEFAULT NULL,
	account_descriptive_name	varchar(256) DEFAULT NULL,
	account_time_zone_id	varchar(256) DEFAULT NULL,
	active_view_cpm	decimal(20,4) DEFAULT NULL,
	active_view_impressions	bigint(20) DEFAULT NULL,
	ad_group_id	bigint(20) DEFAULT NULL,
	ad_group_name	varchar(256) DEFAULT NULL,
	ad_group_status	varchar(36) DEFAULT NULL,
	ad_network_type1	varchar(36) DEFAULT NULL,
	ad_network_type2	varchar(36) DEFAULT NULL,
	advertiser_experiment_segmentation_bin	varchar(36) DEFAULT NULL,
	approval_status	varchar(36) DEFAULT NULL,
	average_cpc	decimal(20,4) DEFAULT NULL,
	average_cpm	decimal(20,4) DEFAULT NULL,
	average_pageviews	decimal(20,4) DEFAULT NULL,
	average_position	decimal(20,4) DEFAULT NULL,
	average_time_on_site	decimal(20,4) DEFAULT NULL,
	bid_type	varchar(36) DEFAULT NULL,
	bidding_strategy_id	bigint(20) DEFAULT NULL,
	bidding_strategy_name	varchar(256) DEFAULT NULL,
	bidding_strategy_type	varchar(36) DEFAULT NULL,
	bounce_rate	decimal(20,4) DEFAULT NULL,
	campaign_id	bigint(20) DEFAULT NULL,
	campaign_name	varchar(256) DEFAULT NULL,
	campaign_status	varchar(36) DEFAULT NULL,
	click_assisted_conversion_value	decimal(20,4) DEFAULT NULL,
	click_assisted_conversions	bigint(20) DEFAULT NULL,
	click_assisted_conversions_over_last_click_conversions	decimal(20,4) DEFAULT NULL,
	click_conversion_rate	decimal(20,4) DEFAULT NULL,
	click_conversion_rate_significance	text DEFAULT NULL,
	click_significance	text DEFAULT NULL,
	click_type	varchar(36) DEFAULT NULL,
	clicks	bigint(20) DEFAULT NULL,
	conversion_category_name	varchar(256) DEFAULT NULL,
	conversion_many_per_click_significance	text DEFAULT NULL,
	conversion_rate_many_per_click	decimal(20,4) DEFAULT NULL,
	conversion_rate_many_per_click_significance	text DEFAULT NULL,
	conversion_tracker_id	bigint(20) DEFAULT NULL,
	conversion_type_name	varchar(256) DEFAULT NULL,
	conversion_value	decimal(20,4) DEFAULT NULL,
	conversions_many_per_click	bigint(20) DEFAULT NULL,
	converted_clicks	bigint(20) DEFAULT NULL,
	converted_clicks_significance	text DEFAULT NULL,
	cost	decimal(20,4) DEFAULT NULL,
	cost_per_conversion_many_per_click	decimal(20,4) DEFAULT NULL,
	cost_per_conversion_many_per_click_significance	text DEFAULT NULL,
	cost_per_converted_click	decimal(20,4) DEFAULT NULL,
	cost_per_converted_click_significance	text DEFAULT NULL,
	cost_significance	text DEFAULT NULL,
	cpc_bid	decimal(20,4) DEFAULT NULL,
	cpc_bid_source	decimal(20,4) DEFAULT NULL,
	cpc_significance	text DEFAULT NULL,
	cpm_bid	decimal(20,4) DEFAULT NULL,
	cpm_significance	text DEFAULT NULL,
	criteria_destination_url	varchar(256) DEFAULT NULL,
	ctr	decimal(20,4) DEFAULT NULL,
	ctr_significance	text DEFAULT NULL,
	customer_descriptive_name	varchar(256) DEFAULT NULL,
	date	date DEFAULT NULL,
	day_of_week	varchar(36) DEFAULT NULL,
	device	varchar(36) DEFAULT NULL,
	enhanced_cpc_enabled	varchar(36) DEFAULT NULL,
	external_customer_id	bigint(20) DEFAULT NULL,
	final_app_urls	text DEFAULT NULL,
	final_mobile_urls	text DEFAULT NULL,
	final_urls	text DEFAULT NULL,
	first_page_cpc	decimal(20,4) DEFAULT NULL,
	id	bigint(20) DEFAULT NULL,
	impression_assisted_conversion_value	decimal(20,4) DEFAULT NULL,
	impression_assisted_conversions	bigint(20) DEFAULT NULL,
	impression_assisted_conversions_over_last_click_conversions	decimal(20,4) DEFAULT NULL,
	impression_significance	text DEFAULT NULL,
	impressions	bigint(20) DEFAULT NULL,
	is_negative	varchar(36) DEFAULT NULL,
	keyword_match_type	varchar(36) DEFAULT NULL,
	keyword_text	varchar(256) DEFAULT NULL,
	label_ids	text DEFAULT NULL,
	labels	text DEFAULT NULL,
	month	varchar(256) DEFAULT NULL,
	month_of_year	varchar(36) DEFAULT NULL,
	percent_new_visitors	decimal(20,4) DEFAULT NULL,
	placement_url	varchar(256) DEFAULT NULL,
	position_significance	text DEFAULT NULL,
	primary_company_name	varchar(256) DEFAULT NULL,
	quality_score	bigint(20) DEFAULT NULL,
	quarter	varchar(256) DEFAULT NULL,
	search_exact_match_impression_share	decimal(20,4) DEFAULT NULL,
	search_impression_share	decimal(20,4) DEFAULT NULL,
	search_rank_lost_impression_share	decimal(20,4) DEFAULT NULL,
	slot	varchar(36) DEFAULT NULL,
	status	varchar(36) DEFAULT NULL,
	top_of_page_cpc	decimal(20,4) DEFAULT NULL,
	tracking_url_template	varchar(256) DEFAULT NULL,
	url_custom_parameters	text DEFAULT NULL,
	value_per_conversion_many_per_click	decimal(20,4) DEFAULT NULL,
	value_per_converted_click	decimal(20,4) DEFAULT NULL,
	view_through_conversions	bigint(20) DEFAULT NULL,
	view_through_conversions_significance	text DEFAULT NULL,
	week	varchar(256) DEFAULT NULL,
	year	bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-06-17*/