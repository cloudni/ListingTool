/*start 2015-07-01*/
DROP TABLE IF EXISTS `lt_ad_campaign_exclude_placement`;
CREATE TABLE `lt_ad_campaign_exclude_placement` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT NOT NULL,
  `ad_campaign_id` INT NOT NULL,
  `domain` VARCHAR(500) NOT NULL,
  `create_time_utc` int(11) DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_time_utc` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lt_ad_group_exclude_placement`;
CREATE TABLE `lt_ad_group_exclude_placement` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT NOT NULL,
  `ad_group_id` INT NOT NULL,
  `domain` VARCHAR(500) NOT NULL,
  `create_time_utc` int(11) DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_time_utc` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*end 2015-07-01*/