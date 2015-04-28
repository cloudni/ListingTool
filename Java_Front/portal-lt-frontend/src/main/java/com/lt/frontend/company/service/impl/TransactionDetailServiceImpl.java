package com.lt.frontend.company.service.impl;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.dao.mapper.TransactionDetailMapper;
import com.lt.frontend.company.service.ITransactionDetailService;
@Service
public class TransactionDetailServiceImpl implements ITransactionDetailService
{
	@Autowired
	private TransactionDetailMapper transactionDetailMapper;
}
