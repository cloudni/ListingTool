/*start 2015/05/11 */
LOCK TABLES `lt_resource_string` WRITE;
insert into lt_resource_string (`key`, `language`, `environment`, `message`)
values ('payment_transaction_type', 2, 0, 'PaymentType'), ('payment_transaction_type', 1, 0, '交易类型');

update lt_resource_string set message = '交易渠道' where `key` = 'type' and `language` = 2;
UNLOCK TABLES;
/*end 2015/05/11*/