/*start 2015/05/11 */
ALTER TABLE lt_company CHANGE COLUMN freeze_amount authorize_amount decimal(20, 4) DEFAULT 0 COMMENT '������';
ALTER TABLE lt_company MODIFY COLUMN balance decimal(20, 4) DEFAULT 0 COMMENT '�˻����';
ALTER TABLE lt_transaction MODIFY COLUMN `type` tinyint(4) COMMENT '֧��ƽ̨���ͣ�1 Paypal; 2 System';
/*end 2015/05/11*/