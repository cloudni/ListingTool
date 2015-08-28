package com.lt.backend.system.controller;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.view.RedirectView;

import com.lt.backend.system.service.ICompanyService;
import com.lt.backend.system.service.ITransactionPaypalService;
import com.lt.backend.system.service.ITransactionService;
import com.lt.dao.model.Company;
import com.lt.dao.model.Transaction;
import com.lt.dao.po.TransactionPO;
import com.lt.platform.util.time.DateFormatUtil;
import com.ssoclient.utils.SessionUtil;

@Controller
@RequestMapping("/company/transaction")
public class TransactionController
{
	@Autowired
	private ITransactionService transactionService;
	
	@Autowired
	private ICompanyService companyService;
	
	@Autowired
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
	public ModelAndView list(HttpServletRequest request, TransactionPO transaction, String msg){
		
		transaction.setIsManagerPage(true);
		List<TransactionPO> transactionList = transactionService.selectBySelective(transaction);
		
		ModelAndView view = new ModelAndView("/system/transaction/listTransaction");
		view.addObject("transaction", transaction);
		view.addObject("transactionList", transactionList);
		view.addObject("conditionSearchFlag", transaction.isConditionSearch());
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
		ModelAndView view = new ModelAndView("/system/transaction/viewTransaction");
		if(id == null || id <= 0) {
			view.addObject("error", "error");
		} else {
			TransactionPO transaction = transactionService.selectByPrimaryKey(id);
			Company company = companyService.selectByPrimaryKey(transaction.getCompanyId());
			
			view.addObject("company", company);
			view.addObject("transaction", transaction);
		}
		return view;
	}
	
	/**
	 * 平台处理退款申请
	 * @param request
	 * @param transactionId
	 * @return
	 * @throws Exception
	 */
	@RequestMapping("approveWithdraw")
	public ModelAndView approveWithdraw(HttpServletRequest request,  int id) throws Exception{
		Map<String, String> map= new HashMap<String, String>();
		Transaction transaction = transactionService.selectByPrimaryKey(id);
		
		if(transaction == null || TransactionPO.STATE_SUCCESS == transaction.getStatus()) {
			map.put("error", "transaction is not exist or transaction is be excute");
		} else {
			transaction.setUpdateUserId(SessionUtil.getUserId(request));
			transactionPaypalService.approveWithdraw(transaction);
			map.put("success", "withdraw quest success");
		}
		
		return new ModelAndView(new RedirectView("list.shtml"), map);
	}
	
	/**
	 * 跳转至添加交易页面
	 * @param request
	 * @param id
	 * @return
	 * @throws Exception
	 */
	@RequestMapping("toAdd")
	public ModelAndView toAdd() throws Exception{
		ModelAndView view = new ModelAndView("/system/transaction/addTransaction");
		
		List<Company> companyList = companyService.selectAll();
		view.addObject("companyList", companyList);
		
		return view;
	}
	
	/**
	 * 添加交易
	 * @param request
	 * @param transaction
	 * @return
	 * @throws Exception
	 */
	@RequestMapping("add")
	public ModelAndView add(HttpServletRequest request,  TransactionPO transaction) throws Exception{
		Map<String, String> map= new HashMap<String, String>();
		
		transaction.setStatus(TransactionPO.STATE_SUCCESS);
		transaction.setCreateUserId(SessionUtil.getUserId(request));
		transaction.setUpdateUserId(SessionUtil.getUserId(request));
		transaction.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		
		transactionService.insertTransactionBySystem(transaction);
		
		return new ModelAndView(new RedirectView("list.shtml"), map);
	}
}
