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