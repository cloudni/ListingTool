package com.lt.frontend.company.service.impl;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.mapper.TransactionMapper;
import com.lt.dao.mapper.TransactionPaypalAccountMapper;
import com.lt.dao.mapper.TransactionPaypalMapper;
import com.lt.dao.model.Transaction;
import com.lt.dao.model.TransactionPaypal;
import com.lt.dao.model.TransactionPaypalAccount;
import com.lt.dao.model.TransactionPaypalWithBLOBs;
import com.lt.dao.po.TransactionPO;
import com.lt.frontend.company.service.ITransactionPaypalService;
import com.lt.platform.util.config.CusotmizedPropertyUtil;
import com.lt.platform.util.lang.StringUtil;
import com.lt.platform.util.time.DateFormatUtil;
import com.lt.thirdpartylibrary.paypal.service.ITransactionAccessTokenService;
import com.lt.thirdpartylibrary.paypal.util.PaymentJsonConverter;
import com.lt.thirdpartylibrary.paypal.util.PaypalConstant;
import com.lt.thirdpartylibrary.paypal.util.PaypalResponse;
import com.lt.thirdpartylibrary.paypal.util.TransactionConstants;
import com.paypal.api.payments.Amount;
import com.paypal.api.payments.Details;
import com.paypal.api.payments.Item;
import com.paypal.api.payments.ItemList;
import com.paypal.api.payments.Links;
import com.paypal.api.payments.Payer;
import com.paypal.api.payments.Payment;
import com.paypal.api.payments.PaymentExecution;
import com.paypal.api.payments.RedirectUrls;

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
	
	private static final String ERROR_CONNECT_FIAL = "retry fails..  check log for more information";

	@Override
	public String deposit(Transaction transaction, String urlPre)
			throws Exception
	{
		String total = String.format(TransactionConstants.DOUBLE_FORMAT,
				transaction.getTotal());

		Details details = new Details();
		details.setSubtotal(total);

		Amount amount = new Amount();
		amount.setCurrency(PaypalConstant.CURRENCY_USD);
		amount.setTotal(total);
		amount.setDetails(details);

		com.paypal.api.payments.Transaction paypalTransaction = new com.paypal.api.payments.Transaction();
		paypalTransaction.setAmount(amount);
		paypalTransaction.setDescription(paypalTransaction.getDescription());

		Item item = new Item();
		item.setName("customer payment in advance").setQuantity("1");
		item.setCurrency(PaypalConstant.CURRENCY_USD).setPrice(total);
		ItemList itemList = new ItemList();
		List<Item> items = new ArrayList<Item>();
		items.add(item);
		itemList.setItems(items);

		paypalTransaction.setItemList(itemList);

		List<com.paypal.api.payments.Transaction> transactions = new ArrayList<com.paypal.api.payments.Transaction>();
		transactions.add(paypalTransaction);

		Payer payer = new Payer();
		payer.setPaymentMethod(PaypalConstant.METHOD_PAYPAL);

		Payment payment = new Payment();
		payment.setIntent(PaypalConstant.INTENT_SALE);
		payment.setPayer(payer);
		payment.setTransactions(transactions);

		RedirectUrls redirectUrls = new RedirectUrls();
		redirectUrls.setCancelUrl(urlPre
				+ "/company/transaction/cancelPaypalDeposit.shtml");
		redirectUrls.setReturnUrl(urlPre
				+ "/company/transaction/completePaypalDeposit.shtml");
		payment.setRedirectUrls(redirectUrls);
		
		transaction.setType(TransactionPO.PAYMENT_TYPE_DEPOSIT);
		transaction.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		
		TransactionPaypalWithBLOBs record = new TransactionPaypalWithBLOBs();
		record.setInterfaceName(TransactionConstants.INTERFACE_PAYMENT);
		record.setActionState(TransactionConstants.INTERFACE_PAYMENT_CREATE);
		
		Payment createdPayment = null;
		String approvalUrl = "";
		boolean callFlag = true;
		try
		{
			logger.info("call payment create with paypal. param :");
			logger.info(payment.toString());
			Object o= CusotmizedPropertyUtil.getContextProperty("transaction.paypal.call.times");
			Integer times = o != null? Integer.parseInt(o.toString()) : null;
			createdPayment = createPayment(payment, times);
			logger.info("callback payment create with paypal. param :");
			logger.info(Payment.getLastResponse());

			Iterator<Links> links = createdPayment.getLinks().iterator();
			while (links.hasNext())
			{
				Links link = links.next();
				if (link.getRel().equalsIgnoreCase(PaypalConstant.APPROVAL_URL))
				{
					approvalUrl = link.getHref();
					break;
				}
			}
		} catch (Exception e)
		{
			logger.error(e.getMessage(), e);
			
			transaction.setStatus(TransactionPO.STATE_FAIL);
			transaction.setEnabled(Boolean.FALSE);
			record.setResponseErrorContent(e.getMessage());
			callFlag = !callFlag;
		}
		
		if(callFlag) {
			transaction.setStatus(TransactionPO.STATE_CREATE);
			
			String token = null;
			if(StringUtil.isNotBlank(approvalUrl)) {
				String str = "token=";
				int index = approvalUrl.indexOf(str);
				token =  approvalUrl.substring(index + str.length());
			}
			
			record.setToken(token);
			record.setTotal(transaction.getTotal());
			record.setPaymentId(createdPayment.getId());
			record.setPaymentState(createdPayment.getState());
			record.setCreatedTime(createdPayment.getCreateTime());
		}
		
		transactionMapper.insertSelective(transaction);

		int id = transactionMapper.selectLastestInsertId();
		
		record.setTransactionId(id);
		record.setRequestContent(Payment.getLastRequest());
		record.setResponseContent(Payment.getLastResponse());
		transactionPaypalMapper.insertSelective(record);
		return approvalUrl;
	}
	
	private Payment createPayment(Payment payment, Integer times) throws Exception {
		Payment createdPayment = null;
		try {
			String accessToken = transactionAccessTokenService.getAccessToken();
			createdPayment = payment.create(accessToken);
		} catch(Exception e) {
			//执行times次仍旧失败，抛出异常
			if(times == null || times == 1) {
				throw e;
			}
			String errorMsg = e.getMessage();
			//如果是超时连接对应的错误提示，继续执行，直到执行times次为止。
			if(ERROR_CONNECT_FIAL.equals(errorMsg)) {
				createdPayment = createPayment(payment, --times);
			} else {
				throw e;
			}
		}
		return createdPayment;
	}

	@Override
	public void completeDeposit(Transaction transaction,
			PaypalResponse transactionResponse) throws Exception
	{

		Payment payment = new Payment();
		payment.setId(transactionResponse.getPaymentId());

		PaymentExecution paymentExecution = new PaymentExecution();
		paymentExecution.setPayerId(transactionResponse.getPayerID());
		
		int transactionId =transactionPaypalMapper.selectTransactionId(transactionResponse.getPaymentId());
		transaction.setId(transactionId);
		
		TransactionPaypalWithBLOBs record = new TransactionPaypalWithBLOBs();
		record.setTransactionId(transactionId);
		
		Payment createdPayment = null;
		boolean callFlag = true;
		try
		{
			logger.info("call payment execute with paypal. param :");
			logger.info(payment.toString());
			
			Object o= CusotmizedPropertyUtil.getContextProperty("transaction.paypal.call.times");
			Integer times = o != null? Integer.parseInt(o.toString()) : null;
			createdPayment = executePayment(payment, paymentExecution, times);
			
			logger.info("callback payment execute with paypal. param :");
			logger.info(Payment.getLastResponse());
			
		} catch (Exception e)
		{
			logger.error(e.getMessage(), e);
			transaction.setStatus(TransactionPO.STATE_FAIL);
			transaction.setEnabled(Boolean.FALSE);
			record.setResponseErrorContent(e.getMessage());
			callFlag = !callFlag;
		}
		
		if(callFlag) {
			String paymentTransactionId = createdPayment.getTransactions()
					.get(0).getRelatedResources().get(0).getSale().getId();

			BigDecimal fee = new BigDecimal(
					PaymentJsonConverter.getPaymentFee(Payment.getLastResponse()));
			BigDecimal net = new BigDecimal(createdPayment.getTransactions().get(0)
					.getAmount().getTotal()).subtract(fee);
			transaction.setFee(fee);
			transaction.setNet(net);
			transaction.setPaymentTransactionId(paymentTransactionId);
			transaction.setStatus(TransactionPO.STATE_SUCCESS);
			
			TransactionPaypalAccount account = new TransactionPaypalAccount();
			account.setTransactionId(transactionId);
			account.setEmail(createdPayment.getPayer().getPayerInfo().getEmail());
			account.setFirstName(createdPayment.getPayer().getPayerInfo()
					.getFirstName());
			account.setLastName(createdPayment.getPayer().getPayerInfo()
					.getLastName());
			account.setPayerId(transactionResponse.getPayerID());
			transactionPaypalAccountMapper.insertSelective(account);
			
			record.setPaymentId(createdPayment.getId());
			record.setPaymentTransactionId(paymentTransactionId);
			record.setTotal(fee.add(net));
			record.setFee(fee);
			record.setNet(net);
			record.setPaymentState(createdPayment.getState());
			record.setCreatedTime(createdPayment.getCreateTime());
			record.setApprovedTime(createdPayment.getUpdateTime());
			
		}
		
		transactionMapper.updateByPrimaryKeySelective(transaction);

		record.setInterfaceName(TransactionConstants.INTERFACE_PAYMENT);
		record.setActionState(TransactionConstants.INTERFACE_PAYMENT_EXECUTE);
		
		record.setRequestContent(Payment.getLastRequest());
		record.setResponseContent(Payment.getLastResponse());
		
		transactionPaypalMapper.insertSelective(record);
		
		if(callFlag) {
			Map<String, String> map = new HashMap<String, String>();
			map.put("paymentTransactionId", transaction.getPaymentTransactionId());
			companyMapper.updateBalanceByTransactionId(map);
		}
	}
	
	private Payment executePayment(Payment payment, PaymentExecution paymentExecution, Integer times) throws Exception {
		Payment createdPayment = null;
		try {
			String accessToken = transactionAccessTokenService.getAccessToken();
			createdPayment = payment.execute(accessToken, paymentExecution);
		} catch(Exception e) {
			//执行times次仍旧失败，抛出异常
			if(times == null || times == 1) {
				throw e;
			}
			String errorMsg = e.getMessage();
			//如果是超时连接对应的错误提示，继续执行，直到执行times次为止。
			if(ERROR_CONNECT_FIAL.equals(errorMsg)) {
				createdPayment = executePayment(payment, paymentExecution, --times);
			} else {
				throw e;
			}
		}
		return createdPayment;
	}

	@Override
	public void withdraw(TransactionPO tran)
	{
		Transaction transaction = new Transaction();
		transaction.setTotal(tran.getTotal().negate());
		transaction.setCompanyId(tran.getCompanyId());
		transaction.setCreateUserId(tran.getCreateUserId());
		transaction.setUpdateUserId(tran.getUpdateUserId());
		transaction.setContents(tran.getContents());

		transaction.setType(TransactionPO.PAYMENT_TYPE_WITHDRAW);
		transaction.setPaymentTransactionType(tran.getPaymentTransactionType());;
		transaction.setStatus(TransactionPO.STATE_CREATE);
		transaction.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		transactionMapper.insertSelective(transaction);

		int id = transactionMapper.selectLastestInsertId();

		TransactionPaypalAccount account = new TransactionPaypalAccount();
		account.setTransactionId(id);
		account.setEmail(tran.getEmail());
		transactionPaypalAccountMapper.insertSelective(account);
	}

	@Override
	public void cancelDeposit(Transaction transaction,
			PaypalResponse transactionResponse) throws Exception
	{
		TransactionPaypal paypal = transactionPaypalMapper.selectByToken(transactionResponse.getToken());
		
		transaction.setId(paypal.getTransactionId());
		transaction.setStatus(TransactionPO.STATE_CANCEL);
		transactionMapper.updateByPrimaryKeySelective(transaction);
	}
	
}
