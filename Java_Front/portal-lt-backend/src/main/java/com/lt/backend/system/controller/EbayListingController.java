package com.lt.backend.system.controller;

import java.util.List;

import javax.servlet.http.HttpServletRequest;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import com.lt.backend.system.service.ICompanyService;
import com.lt.backend.system.service.IEbayListingService;
import com.lt.backend.system.service.IStoreService;
import com.lt.dao.model.Company;
import com.lt.dao.model.Store;

/**
 * 用于ebay listing 相关操作
 * @author jameschen
 *
 */
//@Controller
//@RequestMapping("/trackingTag")
public class EbayListingController
{
	
	@Autowired
	private IEbayListingService ebayListingService;
	@Autowired
	private ICompanyService companyService;
	@Autowired
	private IStoreService storeService;
	
	private static Logger logger = LoggerFactory
			.getLogger(EbayListingController.class);
	
	private static final String FORMAT = "{\"status\":\"%s\", \"message\": \"%s\"}";
	
	
	//@RequestMapping("home")
	public ModelAndView home()
	{
		List<Company> companys = companyService.selectAll();
		
		ModelAndView view = new ModelAndView("/system/trackingTag/home");
		view.addObject("companys", companys);
		return view;
	}
	
//	@RequestMapping("selectStoreByCompany")
//	@ResponseBody
//	public List<Store> selectStoreByCompany(Integer companyId)
//	{
//		//List<Store> storeList = storeService.selectActive(companyId);
//		return storeList;
//	}
	
	/**
	 * 批量更新pixel
	 * @return
	 */
	//@RequestMapping("batchUpdate")
	//@ResponseBody
	public String batchUpdate(HttpServletRequest request)
	{
		String msg = "";
		try {
			String path = request.getSession().getServletContext().getRealPath("");
			//ebayListingService.batchUpdatePixel(path);
			msg = String.format(FORMAT, "success", "success");
		} catch (Exception e){
			logger.error(e.toString(), e);
			msg = String.format(FORMAT, "error", e.toString());
		}
		
		return msg;
	}
}
