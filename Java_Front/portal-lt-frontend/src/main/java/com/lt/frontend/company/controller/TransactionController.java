package com.lt.frontend.company.controller;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.view.RedirectView;

import com.lt.dao.model.Company;
import com.lt.dao.model.Transaction;
import com.lt.dao.po.TransactionPO;
import com.lt.frontend.common.util.I18nKeyConstants;
import com.lt.frontend.company.service.ICompanyService;
import com.lt.frontend.company.service.ITransactionPaypalService;
import com.lt.frontend.company.service.ITransactionService;
import com.lt.platform.framework.core.model.MyBatisSuperModel;
import com.lt.platform.util.lang.StringUtil;
import com.ssoclient.utils.SessionUtil;

@Controller
@RequestMapping("/company/transaction")
public class TransactionController
{
	@Resource
	private ITransactionService transactionService;
	@Resource
	private ICompanyService companyService;
	@Resource
	private ITransactionPaypalService transactionPaypalService;
	
	@RequestMapping("home")
	public ModelAndView home(){
		
		return new ModelAndView("forward:list.shtml");
	}
	
	/**
	 * 查询公司交易列表
	 * @param msg 是否成功提示
	 * @return
	 */
	@RequestMapping("list")
	public ModelAndView list(HttpServletRequest request, TransactionPO transaction, String msg, MyBatisSuperModel myModel){
		
		Company company = companyService.selectByPrimaryKey(SessionUtil.getCompanyId(request));
		if(transaction == null) {
			transaction = new TransactionPO();
		}
		transaction.setRequestPath(request);
		transaction.setCompanyId(company.getId());
		Map<String, Object> paramMap = new HashMap<String, Object>();
		paramMap.put("companyId", company.getId());
		myModel.setParams(paramMap);
		List<TransactionPO> transactionList = transactionService.selectBySelective(transaction);
		
		HttpSession session = request.getSession();
		@SuppressWarnings("unchecked")
		Map<String, String> i18nSession = (Map<String, String>) session.getAttribute("session");
		for(TransactionPO po: transactionList) {
			getI18nBean(po, i18nSession);
		}
		ModelAndView view = new ModelAndView("/company/transaction");
		view.addObject("company", company);
		view.addObject("transaction", transaction);
		view.addObject("transactionList", transactionList);
		view.addObject("msg", msg);
		
		view.addObject("page", transaction);
		return view;
	}
	
	/**
	 * 查询公司交易详情
	 * @param msg 是否成功提示
	 * @return
	 */
	@RequestMapping("view")
	public ModelAndView view(HttpServletRequest request, Integer id){
		ModelAndView view = new ModelAndView("/company/viewTransaction");
		
		TransactionPO transaction = transactionService.selectByPrimaryKey(id);
		getI18nBean(transaction, request);
		Company company = companyService.selectByPrimaryKey(transaction.getCompanyId());
		
		view.addObject("company", company);
		view.addObject("transaction", transaction);
		
		return view;
	}
	
	@SuppressWarnings("unchecked")
	public void getI18nBean(TransactionPO po, HttpServletRequest request)
	{
		HttpSession session = request.getSession();
		Map<String, String> i18nSession = (Map<String, String>) session.getAttribute("session");
		getI18nBean(po, i18nSession);
	}
	
	public void getI18nBean(TransactionPO po, Map<String, String> i18nSession)
	{
		String typeKey = I18nKeyConstants.getI18nKey(I18nKeyConstants.key_type, po.getType());
		String typeName =  StringUtil.trimToEmpty(i18nSession.get(typeKey));
		po.setTypeName(typeName);
		
		String statusKey = I18nKeyConstants.getI18nKey(I18nKeyConstants.key_status, po.getStatus());
		String statusName = StringUtil.trimToEmpty(i18nSession.get(statusKey));
		po.setStatusName(statusName);
		
		String paymentTransactionType = I18nKeyConstants.getI18nKey(I18nKeyConstants.key_paymentTransactionType, po.getPaymentTransactionType()); 
		String paymentTransactionName = StringUtil.trimToEmpty(i18nSession.get(paymentTransactionType));
		po.setPaymentTransactionTypeName(paymentTransactionName);
	}
	
	/**
	 * 公司发起存款
	 * @param request
	 * @param companyTransaction 公司交易对象，从页面post过来
	 * @return
	 * @throws Exception
	 */
	@RequestMapping("deposit")
	public ModelAndView deposit(HttpServletRequest request,  Transaction transaction) throws Exception{
		transaction.setCompanyId(SessionUtil.getCompanyId(request));
		transaction.setCreateUserId(SessionUtil.getUserId(request));
		transaction.setUpdateUserId(SessionUtil.getUserId(request));
		//transactionService.insertSelective(transaction);
		
		String redirect = transactionPaypalService.deposit(transaction, getUrlPre(request));
		
		Map<String, String> map= new HashMap<String, String>();
		
		if(StringUtil.isBlank(redirect)) {
			redirect = "list.shtml";
			map.put("msg","error_deposit");
		}
		
		return new ModelAndView(new RedirectView(redirect), map);
		
	}
	
	//拼接请求前缀
	private String getUrlPre(HttpServletRequest request) {
		
		return request.getScheme() + "://" + request.getServerName()
				+ ":" + request.getServerPort() + request.getContextPath();
	}
	
	/**
	 * 公司发起退款请求
	 * @param request
	 * @param companyTransaction 公司交易对象，从页面post过来
	 * @return
	 * @throws Exception
	 */
	@RequestMapping("withdraw")
	public ModelAndView withdraw(HttpServletRequest request,  TransactionPO transaction) throws Exception{
		Map<String, String> map= new HashMap<String, String>();
		Integer companyId = SessionUtil.getCompanyId(request);
		
		Map<String, Object> paraMap= new HashMap<String, Object>();
		paraMap.put("balance", transaction.getTotal());
		paraMap.put("companyId", companyId);
		boolean flag = companyService.compareBalance(paraMap);
		if(!flag) {
			map.put("msg", "error_withdraw");
		} else {
			transaction.setCompanyId(SessionUtil.getCompanyId(request));
			transaction.setCreateUserId(SessionUtil.getUserId(request));
			transaction.setUpdateUserId(SessionUtil.getUserId(request));
			
			transactionPaypalService.withdraw(transaction);
			map.put("msg", "success_withdraw");
		}
		return new ModelAndView(new RedirectView("list.shtml"), map);
	}
	
}
