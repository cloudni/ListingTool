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

ALTER TABLE `lt_company` ADD COLUMN `instant_amount` decimal(10,4) not null default '0' COMMENT 'Ô¤½áËã½ð¶î';

ALTER TABLE lt_company change COLUMN `freeze_amount` `freeze_amount` DECIMAL(20,4) default '0';
ALTER TABLE lt_company change COLUMN `markup_type` `markup_type` tinyint(4) default '1' ;
ALTER TABLE lt_company change COLUMN `markup_amount` `markup_amount` DECIMAL(20,4) default '0.3';
ALTER TABLE lt_company change COLUMN `authorize_day` `authorize_day` tinyint(4) default '1' ;

alter TABLE lt_google_adwords_ad ADD COLUMN ad_id INT DEFAULT null;
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