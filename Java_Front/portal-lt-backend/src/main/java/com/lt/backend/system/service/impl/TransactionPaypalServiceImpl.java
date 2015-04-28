package com.lt.backend.system.service.impl;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Random;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.system.service.ITransactionPaypalService;
import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.mapper.TransactionMapper;
import com.lt.dao.mapper.TransactionPaypalAccountMapper;
import com.lt.dao.mapper.TransactionPaypalMapper;
import com.lt.dao.model.Transaction;
import com.lt.dao.model.TransactionPaypalAccount;
import com.lt.dao.model.TransactionPaypalWithBLOBs;
import com.lt.dao.po.TransactionPO;
import com.lt.platform.util.time.DateFormatUtil;
import com.lt.thirdpartylibrary.paypal.service.ITransactionAccessTokenService;
import com.lt.thirdpartylibrary.paypal.util.PaypalConstant;
import com.lt.thirdpartylibrary.paypal.util.TransactionConstants;
import com.paypal.api.payments.Currency;
import com.paypal.api.payments.Payout;
import com.paypal.api.payments.PayoutBatch;
import com.paypal.api.payments.PayoutItem;
import com.paypal.api.payments.PayoutSenderBatchHeader;
import com.paypal.base.rest.PayPalRESTException;

@Service
public class TransactionPaypalServiceImpl implements ITransactionPaypalService
{
	private static Logger logger = LoggerFactory
			.getLogger(TransactionPaypalServiceImpl.class);

	@Autowired
	private TransactionMapper transactionMapper;

	@Autowired
	private CompanyMapper companyMapper;

	@Autowired
	private TransactionPaypalMapper transactionPaypalMapper;

	@Autowired
	private TransactionPaypalAccountMapper transactionPaypalAccountMapper;
	
	@Autowired
	private ITransactionAccessTokenService transactionAccessTokenService;

	@Override
	public void approveWithdraw(Transaction tran) throws Exception
	{
		Transaction transaction = transactionMapper.selectByPrimaryKey(tran
				.getId());
		TransactionPaypalAccount account = transactionPaypalAccountMapper
				.selectByTransactionId(transaction.getId());
		
		TransactionPaypalWithBLOBs record = new TransactionPaypalWithBLOBs();
		record.setTransactionId(transaction.getId());

		Payout payout = new Payout();
		PayoutSenderBatchHeader senderBatchHeader = new PayoutSenderBatchHeader();

		Random random = new Random();
		senderBatchHeader.setSenderBatchId(String.valueOf(random.nextLong()))
				.setEmailSubject("You have a Payout!");

		Currency amount = new Currency();
		amount.setValue(String.format("%.2f", transaction.getTotal().negate()));
		amount.setCurrency(PaypalConstant.CURRENCY_USD);
				
		PayoutItem senderItem = new PayoutItem();
		senderItem.setRecipientType("Email")
				.setNote("Thanks for your patronage")
				.setReceiver(account.getEmail())
				.setSenderItemId(String.valueOf(random.nextLong()))
				.setAmount(amount);

		List<PayoutItem> items = new ArrayList<PayoutItem>();
		items.add(senderItem);

		payout.setSenderBatchHeader(senderBatchHeader).setItems(items);

		PayoutBatch batch = null;
		boolean callFlag = true;
		try
		{
			logger.info("call payout execute with paypal. param :");
			logger.info(payout.toString());
			String accessToken = transactionAccessTokenService.getAccessToken();
			batch = payout.createSynchronous(accessToken);
			logger.info("callback payout execute with paypal. param :");
			logger.info(Payout.getLastResponse());

			//payoutVO.setTimeCreated(batch.getBatchHeader().getTimeCreated());
			
		} catch (PayPalRESTException e)
		{
			logger.error(e.getMessage(), e);
			callFlag = !callFlag;
			
			transaction.setStatus(TransactionPO.STATE_FAIL);
			transaction.setEnabled(Boolean.FALSE);
			record.setResponseErrorContent(e.getMessage());
		}
		
		if(callFlag) {
			BigDecimal fee = new BigDecimal(batch.getBatchHeader().getFees().getValue());
			BigDecimal net = transaction.getTotal().subtract(fee);
			String paymentTransactionId = batch.getItems().get(0).getTransactionId();
			transaction.setFee(fee);
			transaction.setNet(net);
			transaction.setStatus(TransactionPO.STATE_SUCCESS);
			transaction.setPaymentTransactionId(paymentTransactionId);
			
			record.setPaymentTransactionId(paymentTransactionId);
			record.setTotal(fee.add(net));
			record.setFee(fee);
			record.setNet(net);
			
			record.setPaymentState(batch.getItems().get(0).getTransactionStatus());
			record.setCompletedTime(batch.getBatchHeader().getTimeCompleted());
			
		}
		
		transaction.setUpdateUserId(tran.getUpdateUserId());
		transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());

		transactionMapper.updateByPrimaryKeySelective(transaction);

		transaction = transactionMapper.selectByPrimaryKey(transaction.getId());

		record.setInterfaceName(TransactionConstants.INTERFACE_PAYOUT);
		record.setActionState(TransactionConstants.INTERFACE_PAYOUT_EXECUTE);
		record.setRequestContent(Payout.getLastRequest());
		record.setResponseContent(Payout.getLastResponse());
		
		transactionPaypalMapper.insertSelective(record);

		if(callFlag) {
			Map<String, String> map = new HashMap<String, String>();
			map.put("paymentTransactionId", transaction.getPaymentTransactionId());
			companyMapper.updateBalanceByTransactionId(map);
		}
	}
}
