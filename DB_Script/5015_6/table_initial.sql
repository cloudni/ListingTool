/*start 2015-06-30*/
ALTER TABLE `lt_store` 
ADD COLUMN `ga_email` VARCHAR(50) NULL DEFAULT NULL AFTER `last_listing_sync_time_utc`,
ADD COLUMN `ga_account` VARCHAR(50) NULL DEFAULT NULL AFTER `ga_email`,
ADD COLUMN `ga_track_id` VARCHAR(50) NULL DEFAULT NULL AFTER `ga_account`;
/*end 2015-06-30*/