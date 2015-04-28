package com.lt.backend.system.service.impl;

import java.math.BigDecimal;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.annotation.Resource;

import org.springframework.stereotype.Service;

import com.lt.backend.system.service.ITransactionService;
import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.mapper.TransactionMapper;
import com.lt.dao.model.Transaction;
import com.lt.dao.po.TransactionPO;

@Service
public class TransactionServiceImpl implements ITransactionService
{
	@Resource
	private TransactionMapper transactionMapper;
	
	@Resource
	private CompanyMapper companyMapper;
	
	@Override
	public List<TransactionPO> selectBySelective(TransactionPO transactionPO)
	{
		transactionPO.setIspaging(true);
		return transactionMapper.selectBySelective(transactionPO);
	}

	

	@Override
	public void insertTransactionBySystem(Transaction transaction)
	{
		transaction.setFee(new BigDecimal(0));
		transaction.setNet(transaction.getTotal());
		transactionMapper.insertSelective(transaction);
		
		Map<String, Object> map = new HashMap<String, Object>();
		map.put("id", transaction.getCompanyId());
		map.put("total", transaction.getTotal());
		companyMapper.updateBalanceById(map);
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
