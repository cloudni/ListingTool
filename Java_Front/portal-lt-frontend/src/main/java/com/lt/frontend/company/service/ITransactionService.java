package com.lt.frontend.company.service;

import java.util.List;

import com.lt.dao.model.Transaction;
import com.lt.dao.po.TransactionPO;

public interface ITransactionService
{
	/**
	 * 新增交易
	 * @param transaction 交易对象
	 * @return
	 */
	int insertSelective(Transaction transaction);
	
	/**
	 * 修改交易
	 * @param transaction 交易对象
	 * @return
	 */
	int updateByPrimaryKeySelective(Transaction transaction);
	 
	/**
	 * 条件查询交易历史
	 * @param transactionPO
	 * @return
	 */
	List<TransactionPO> selectBySelective(TransactionPO transactionPO);
	
	/**
	 * 查看交易详情
	 * @param id
	 * @return
	 */
	TransactionPO selectByPrimaryKey(Integer id);
}
