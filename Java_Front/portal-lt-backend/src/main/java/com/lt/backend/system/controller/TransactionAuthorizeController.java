package com.lt.backend.system.controller;

import java.math.BigDecimal;

import javax.servlet.http.HttpServletRequest;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

import com.lt.backend.system.service.ICompanyService;
import com.lt.backend.system.service.ITransactionAuthorizeService;
import com.lt.dao.model.AdCampaign;
import com.lt.dao.model.Company;
import com.lt.platform.util.config.CusotmizedPropertyUtil;
import com.lt.platform.util.lang.StringUtil;
import com.lt.thirdpartylibrary.paypal.util.TransactionConstants;

@Controller
@RequestMapping("/company/transaction/authorize")
public class TransactionAuthorizeController
{
	private static Logger logger = LoggerFactory
			.getLogger(TransactionAuthorizeController.class);
	
	@Autowired
	private ITransactionAuthorizeService transactionAuthorizeService;
	
	@Autowired
	private ICompanyService companyService;
	
	/**
	 * 查询公司交易列表
	 * @param msg 是否成功提示
	 * @return
	 */
	@RequestMapping("freeze")
	@ResponseBody
	public String freeze(HttpServletRequest request,String companyId, String campaignId, String budget){
		String msg = "";
		
		if(StringUtil.isBlank(companyId) || StringUtil.isBlank(campaignId) 
				|| StringUtil.isBlank(budget))
		{
			return TransactionConstants.getNullErrorMsg(companyId, campaignId, budget);
		}
		
		Integer companyIdInteger = null;
		Integer campaignIdInteger = null;
		BigDecimal budgetBig = null;
		try 
		{
			companyIdInteger = Integer.valueOf(companyId);
			campaignIdInteger = Integer.valueOf(campaignId);
			budgetBig = new BigDecimal(budget);
		}
		catch(Exception e) 
		{
			logger.error(String.format(TransactionConstants.PARA_FORMAT, 
							companyId, campaignId, budget) +"\n" + e.getMessage(), e);
			return TransactionConstants.getFormatErrorMsg(companyId, campaignId, budget);
		}
		
		Company company = this.companyService.selectByPrimaryKey(companyIdInteger);
		
		BigDecimal times = new BigDecimal(Integer.parseInt(CusotmizedPropertyUtil.getContextProperty("transaction.authorize.freeze.times").toString()));
		BigDecimal freeze = budgetBig.multiply(times);
		if(freeze.compareTo(company.getBalance()) == 1) {
			return TransactionConstants.getFreezeErrorMsg(companyId, campaignId, budget);
		}
		
		AdCampaign adCampaign = new AdCampaign();
		adCampaign.setBudget(budgetBig);
		adCampaign.setId(campaignIdInteger);
		adCampaign.setCompanyId(companyIdInteger);
		transactionAuthorizeService.freezeCampaignBudget(adCampaign);
		return msg;
	}
}
