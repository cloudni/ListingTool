package com.lt.frontend.company.test;

import org.junit.Test;
import org.springframework.beans.factory.annotation.Autowired;

import test.BaseJunitTest;

import com.lt.dao.mapper.TransactionMapper;
import com.lt.dao.model.Transaction;
import com.lt.frontend.company.service.ITransactionService;

public class TestTransactionService extends BaseJunitTest
{
	@Autowired
	private TransactionMapper transactionMapper;
	@Autowired
	private ITransactionService transactionService;
	
	@Test
	public void  insert() throws Exception{
		
	}
}
