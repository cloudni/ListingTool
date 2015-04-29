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

ALTER TABLE `lt_company` ADD COLUMN `instant_amount` decimal(10,4) not null default '0' COMMENT '预结算金额';

ALTER TABLE lt_company update COLUMN freeze_amount DECIMAL(20,4) default '0' COMMENT '冻结金额';
ALTER TABLE lt_company update COLUMN markup_type tinyint(4) default '1'  COMMENT '标记类型:1 按cost的百分比;2 按固定收费;3 按clicks';
ALTER TABLE lt_company update COLUMN markup_amount DECIMAL(20,4) default '0.3' COMMENT '标记金额';
ALTER TABLE lt_company update COLUMN authorize_day tinyint(4) default '1' COMMENT '冻结天数';

alter TABLE lt_google_adwords_ad ADD COLUMN ad_id INT DEFAULT null;
/*end 2015-04-29*/