/*start 2015/05/11 */
LOCK TABLES `lt_resource_string` WRITE;
insert into lt_resource_string (`key`, `language`, `environment`, `message`)
values ('payment_transaction_type', 2, 0, 'Payment Type'), ('payment_transaction_type', 1, 0, '交易类型');
UNLOCK TABLES;
update lt_resource_string set message = '类型' where `key` = 'type' and `language` = 1;
update lt_resource_string set message = 'Type' where `key` = 'type' and `language` = 2;
/*end 2015/05/11*/

/*start 2015/05/15 */
insert into lt_resource_string (`key`, `language`, `environment`, `message`) values ('company_authorize_amount', 2, 0, 'Authorize Amount'), ('company_authorize_amount', 1, 0, '冻结金额');
/*end 2015/05/15*/

/*start 2015-05-16*/
LOCK TABLES `lt_resource_string` WRITE;
INSERT INTO `lt_resource_string` (`key`,`language`,`environment`,`message`,`create_time_utc`,`create_admin_id`,`update_time_utc`,`update_admin_id`) VALUES ('wish_listing',1,0,'Wish产品',1431669751,1,1431669751,1);
INSERT INTO `lt_resource_string` (`key`,`language`,`environment`,`message`,`create_time_utc`,`create_admin_id`,`update_time_utc`,`update_admin_id`) VALUES ('wish_listing',2,0,'Wish Item',1431669768,1,1431669768,1);
INSERT INTO `lt_resource_string` (`key`,`language`,`environment`,`message`,`create_time_utc`,`create_admin_id`,`update_time_utc`,`update_admin_id`) VALUES ('wish_listing_id',1,0,'Wish产品ID',1431669847,1,1431669847,1);
INSERT INTO `lt_resource_string` (`key`,`language`,`environment`,`message`,`create_time_utc`,`create_admin_id`,`update_time_utc`,`update_admin_id`) VALUES ('wish_listing_id',2,0,'Wish Item ID',1431669858,1,1431669858,1);
INSERT INTO `lt_resource_string` (`key`,`language`,`environment`,`message`,`create_time_utc`,`create_admin_id`,`update_time_utc`,`update_admin_id`) VALUES ('wish_api_key',1,0,'Wish API密钥',1431786457,1,1431786457,1);
INSERT INTO `lt_resource_string` (`key`,`language`,`environment`,`message`,`create_time_utc`,`create_admin_id`,`update_time_utc`,`update_admin_id`) VALUES ('wish_api_key',2,0,'Wish API Key',1431786470,1,1431786470,1);
UNLOCK TABLES;
/*end 2015-05-16*/

/*start 2015-05-27*/
LOCK TABLES `lt_resource_string` WRITE;
update lt_resource_string set message = '扣款' where `key`='payment_transaction_type_deduaction';
/*end 2015-05-27*/