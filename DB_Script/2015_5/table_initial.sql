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