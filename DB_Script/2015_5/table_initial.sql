/*start 2015/05/11 */
ALTER TABLE lt_company CHANGE COLUMN freeze_amount authorize_amount decimal(20, 4) DEFAULT 0 COMMENT '冻结金额';
ALTER TABLE lt_company MODIFY COLUMN balance decimal(20, 4) DEFAULT 0 COMMENT '账户余额';
ALTER TABLE lt_transaction MODIFY COLUMN `type` tinyint(4) COMMENT '支付平台类型：1 Paypal; 2 System';
/*end 2015/05/11*/