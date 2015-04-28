package com.lt.frontend.company.service.impl;

import java.util.List;

import javax.annotation.Resource;

import org.springframework.stereotype.Service;

import com.lt.dao.mapper.TransactionMapper;
import com.lt.dao.model.Transaction;
import com.lt.dao.po.TransactionPO;
import com.lt.frontend.company.service.ITransactionService;

@Service
public class TransactionServiceImpl implements ITransactionService
{
	@Resource
	private TransactionMapper transactionMapper;
	
	@Override
	public List<TransactionPO> selectBySelective(TransactionPO transactionPO)
	{
		transactionPO.setIspaging(true);
		return transactionMapper.selectBySelective(transactionPO);
	}

	

	@Override
	public int insertSelective(Transaction transaction)
	{
		
		return transactionMapper.insertSelective(transaction);
	}

	@Override
	public int updateByPrimaryKeySelective(Transaction transaction)
	{
		
		return transactionMapper.updateByPrimaryKeySelective(transaction);
	}



	@Override
	public TransactionPO selectByPrimaryKey(Integer id)
	{
		
		return transactionMapper.selectByPrimaryKey(id);
	}
	
}
