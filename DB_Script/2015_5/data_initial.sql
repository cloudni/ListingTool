/*start 2015/05/11 */
LOCK TABLES `lt_resource_string` WRITE;
insert into lt_resource_string (`key`, `language`, `environment`, `message`)
values ('payment_transaction_type', 2, 0, 'PaymentType'), ('payment_transaction_type', 1, 0, '交易类型');

update lt_resource_string set message = '类型' where `key` = 'type' and `language` = 1;
update lt_resource_string set message = 'Type' where `key` = 'type' and `language` = 2;
UNLOCK TABLES;
/*end 2015/05/11*/

/*start 2015/05/15 */
insert into lt_resource_string (`key`, `language`, `environment`, `message`) values ('company_authorize_amount', 2, 0, 'Authorize Amount'), ('company_authorize_amount', 1, 0, '冻结金额');
/*end 2015/05/15*/