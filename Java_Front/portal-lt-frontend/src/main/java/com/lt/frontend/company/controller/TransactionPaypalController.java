package com.lt.frontend.company.controller;

import java.util.HashMap;
import java.util.Map;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.view.RedirectView;

import com.lt.dao.model.Transaction;
import com.lt.frontend.company.service.ITransactionPaypalService;
import com.lt.platform.util.time.DateFormatUtil;
import com.lt.thirdpartylibrary.paypal.util.PaypalResponse;

@Controller
@RequestMapping("/company/transaction")
public class TransactionPaypalController
{
	@Resource
	private ITransactionPaypalService transactionPaypalService;
	
	/**
	 * 平台接受存款
	 * @param transactionResponse
	 * @return
	 * @throws Exception
	 */
	@RequestMapping("completePaypalDeposit")
	public ModelAndView completePaypalDeposit(HttpServletRequest request, PaypalResponse transactionResponse) throws Exception{
		Transaction transaction = new Transaction();
		
		transaction.setUpdateUserId(0);
		transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		
		transactionPaypalService.completeDeposit(transaction, transactionResponse);
		
		Map<String, String> map= new HashMap<String, String>();
		map.put("msg", "complete deposit");
		return new ModelAndView(new RedirectView("list.shtml"), map);
	}
	
	/**
	 * 平台接受存款
	 * @param transactionResponse
	 * @return
	 * @throws Exception
	 */
	@RequestMapping("cancelPaypalDeposit")
	public ModelAndView cancelPaypalDeposit(HttpServletRequest request, PaypalResponse transactionResponse) throws Exception{
		Transaction transaction = new Transaction();
		
		transaction.setUpdateUserId(0);
		transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		
		transactionPaypalService.cancelDeposit(transaction, transactionResponse);
		
		Map<String, String> map= new HashMap<String, String>();
		map.put("msg", "cancel success");
		return new ModelAndView(new RedirectView("list.shtml"), map);
	}
}
