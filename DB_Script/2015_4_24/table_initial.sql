/*start 2015-04-29*/
CREATE TABLE lt_ad_google_adwords_report_ad_group LIKE lt_google_adwords_report_ad_group;

ALTER TABLE lt_ad_google_adwords_report_ad_group ADD COLUMN pk_id int(11) NOT NULL AUTO_INCREMENT,add primary key (pk_id);  
ALTER TABLE lt_ad_google_adwords_report_ad_group ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_google_adwords_report_ad_group ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_ad_group ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_ad_group ADD COLUMN ad_ad_id int(11);
ALTER TABLE lt_ad_google_adwords_report_ad_group ADD COLUMN is_charged tinyint(1) default '0';

CREATE TABLE lt_ad_google_adwords_report_campaign_temp LIKE lt_google_adwords_report_campaign;

ALTER TABLE lt_ad_google_adwords_report_campaign_temp ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_google_adwords_report_campaign_temp ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_campaign_temp ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_campaign_temp ADD COLUMN ad_campaign_id int(11);
ALTER TABLE lt_ad_google_adwords_report_campaign_temp ADD COLUMN is_charged tinyint(1) default '0';

ALTER TABLE `lt_company` ADD COLUMN `instant_amount` decimal(10,4) not null default '0' COMMENT '预扣款金额';

ALTER TABLE lt_company change COLUMN `freeze_amount` `freeze_amount` DECIMAL(20,4) default '0';
ALTER TABLE lt_company change COLUMN `markup_type` `markup_type` tinyint(4) default '1' ;
ALTER TABLE lt_company change COLUMN `markup_amount` `markup_amount` DECIMAL(20,4) default '0.3';
ALTER TABLE lt_company change COLUMN `authorize_day` `authorize_day` tinyint(4) default '1' ;

/*end 2015-04-29*/

/*start 2015-05-02*/
CREATE TABLE lt_ad_google_adwords_report_geo LIKE lt_google_adwords_report_geo;
ALTER TABLE lt_ad_google_adwords_report_geo ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_google_adwords_report_geo ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_geo ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_geo ADD COLUMN is_charged tinyint(1) default '0';

CREATE TABLE lt_ad_google_adwords_report_destination_url LIKE lt_google_adwords_report_destination_url;
ALTER TABLE lt_ad_google_adwords_report_destination_url ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_google_adwords_report_destination_url ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_destination_url ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_destination_url ADD COLUMN is_charged tinyint(1) default '0';

CREATE TABLE lt_ad_google_adwords_report_automatic_placements LIKE lt_google_adwords_report_automatic_placements;
ALTER TABLE lt_ad_google_adwords_report_automatic_placements ADD COLUMN markup_type tinyint(4);
ALTER TABLE lt_ad_google_adwords_report_automatic_placements ADD COLUMN markup_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_automatic_placements ADD COLUMN charge_amount DECIMAL(20,4);
ALTER TABLE lt_ad_google_adwords_report_automatic_placements ADD COLUMN is_charged tinyint(1) default '0';
/*end 2015-05-02*/

/*start 2015-05-4*/
DROP TABLE IF EXISTS `lt_transaction_change_log`;
CREATE TABLE `lt_transaction_change_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `object_type` tinyint(4) NOT NULL COMMENT '记录这条log对应对象的类名，比如ADCampaign',
  `object_id` int(11) NOT NULL COMMENT '记录这条log对应对象的主键',
  `action` int(11) NOT NULL DEFAULT '0' COMMENT '记录的动作，包括新增，更新，删除',
  `content` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '记录这条log是否已经被同步过，包括等待处理，已处理，处理出错',
  `priority` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'log的优先级，一般，高优先级，最高优先级，紧急',
  `create_time_utc` int(11) DEFAULT '0',
  `create_user_id` int(11) DEFAULT '0' COMMENT '记录产生动作触发这条log的用户ID',
  `update_time_utc` int(11) DEFAULT '0',
  `update_user_id` int(11) DEFAULT '0' COMMENT '记录这条log最后更新的管理员ID',
  PRIMARY KEY (`id`),
  KEY `lt_transaction_change_log_company_id` (`company_id`),
  CONSTRAINT `lt_transaction_change_log_company_id` FOREIGN KEY (`company_id`) REFERENCES `lt_company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

ALTER TABLE lt_ad_google_adwords_report_ad MODIFY COLUMN is_charged tinyint(1) default '1';
ALTER TABLE lt_ad_google_adwords_report_campaign MODIFY COLUMN is_charged tinyint(1) default '1';
ALTER TABLE lt_ad_google_adwords_report_campaign_temp MODIFY COLUMN is_charged tinyint(1) default '1';
ALTER TABLE lt_ad_google_adwords_report_ad_group MODIFY COLUMN is_charged tinyint(1) default '1';
ALTER TABLE lt_ad_google_adwords_report_geo MODIFY COLUMN is_charged tinyint(1) default '1';
ALTER TABLE lt_ad_google_adwords_report_destination_url MODIFY COLUMN is_charged tinyint(1) default '1';
ALTER TABLE lt_ad_google_adwords_report_automatic_placements MODIFY COLUMN is_charged tinyint(1) default '1';

ALTER TABLE lt_ad_google_adwords_report_ad CHANGE ad_ad_id  lt_ad_advertise_id int(11);
ALTER TABLE lt_ad_google_adwords_report_campaign CHANGE ad_campaign_id  lt_ad_campaign_id int(11);
ALTER TABLE lt_ad_google_adwords_report_campaign_temp CHANGE ad_campaign_id  lt_ad_campaign_id int(11);

ALTER TABLE lt_ad_google_adwords_report_ad_group CHANGE ad_ad_id lt_ad_group_id int(11);
ALTER TABLE lt_ad_google_adwords_report_geo ADD COLUMN lt_ad_group_id int(11);
ALTER TABLE lt_ad_google_adwords_report_destination_url ADD COLUMN lt_ad_group_id int(11);
ALTER TABLE lt_ad_google_adwords_report_automatic_placements ADD COLUMN lt_ad_group_id int(11);

ALTER TABLE lt_ad_google_adwords_report_geo ADD COLUMN pk_id int(11) NOT NULL AUTO_INCREMENT,add primary key (pk_id); 
ALTER TABLE lt_ad_google_adwords_report_destination_url ADD COLUMN pk_id int(11) NOT NULL AUTO_INCREMENT,add primary key (pk_id); 
ALTER TABLE lt_ad_google_adwords_report_automatic_placements ADD COLUMN pk_id int(11) NOT NULL AUTO_INCREMENT,add primary key (pk_id); 

ALTER TABLE lt_ad_google_adwords_report_ad MODIFY COLUMN charge_amount DECIMAL(20,4) default 0;
ALTER TABLE lt_ad_google_adwords_report_campaign MODIFY COLUMN charge_amount DECIMAL(20,4) default 0;
ALTER TABLE lt_ad_google_adwords_report_campaign_temp MODIFY COLUMN charge_amount DECIMAL(20,4) default 0;
ALTER TABLE lt_ad_google_adwords_report_ad_group MODIFY COLUMN charge_amount DECIMAL(20,4) default 0;
ALTER TABLE lt_ad_google_adwords_report_geo MODIFY COLUMN charge_amount DECIMAL(20,4) default 0;
ALTER TABLE lt_ad_google_adwords_report_destination_url MODIFY COLUMN charge_amount DECIMAL(20,4) default 0;
ALTER TABLE lt_ad_google_adwords_report_automatic_placements MODIFY COLUMN charge_amount DECIMAL(20,4) default 0;
/*end 2015-05-4*/

/*start 2015-05-05*/
alter TABLE lt_google_adwords_ad drop COLUMN ad_id;

/*end 2015-05-05*/