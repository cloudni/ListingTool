package com.lt.backend.system.service;

import com.lt.dao.model.Transaction;
/**
 * paypal收款和付款接口
 * @author jameschen
 *
 */
public interface ITransactionPaypalService
{
	
    /**
     * 同意退款
     * @param tran
     * @throws Exception
     */
    void approveWithdraw(Transaction tran) throws Exception;
}
