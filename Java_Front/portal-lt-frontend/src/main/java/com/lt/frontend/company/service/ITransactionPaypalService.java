package com.lt.frontend.company.service;

import com.lt.dao.model.Transaction;
import com.lt.dao.po.TransactionPO;
import com.lt.thirdpartylibrary.paypal.util.PaypalResponse;
/**
 * paypal收款和付款接口
 * @author jameschen
 *
 */
public interface ITransactionPaypalService
{
	/**
	 * 发起存款
	 * @param transaction
	 * @param urlPre 回调接口前缀
	 * @return
	 * @throws Exception
	 */
	String deposit(Transaction transaction, String urlPre) throws Exception;

	/**
	 * 完成存款
	 * @param transaction
	 * @param transactionResponse
	 * @throws Exception
	 */
	void completeDeposit(Transaction transaction, PaypalResponse transactionResponse) throws Exception;
	
	/**
	 * 申请退款
	 * @param transaction
	 * @return
	 */
	void withdraw(TransactionPO tran);
    
   /**
    * 
    * @param transaction
    * @param transactionResponse
    * @throws Exception
    */
    void cancelDeposit(Transaction transaction, PaypalResponse transactionResponse) throws Exception;
}
