package com.lt.backend.system.controller;

import java.io.File;
import java.util.List;

import javax.servlet.http.HttpServletRequest;

import org.apache.commons.lang3.StringUtils;
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
import com.lt.backend.system.util.StreamUtils;
import com.lt.dao.model.Company;
import com.lt.dao.model.Store;
import com.lt.dao.po.EbayListingPO;
import com.lt.dao.po.TrackingTagPO;
import com.lt.platform.util.Constants;
import com.lt.platform.util.lang.StringUtil;

/**
 * 用于tracking tag相关操作（主要用于向产品描述中中pixel）
 * @author jameschen
 *
 */
@Controller
@RequestMapping("/trackingTag")
public class TrackingTagController
{
	@Autowired
	private IEbayListingService ebayListingService;
	@Autowired
	private ICompanyService companyService;
	@Autowired
	private IStoreService storeService;
	
	private static Logger logger = LoggerFactory.getLogger(TrackingTagController.class);
	
	private static final String FORMAT = "{\"status\":\"%s\", \"message\": \"%s\"}";
	
	@RequestMapping("home")
	public ModelAndView home(HttpServletRequest request)
	{
		List<Company> companys = companyService.selectAll();
		
		ModelAndView view = new ModelAndView("/system/trackingTag/home");
		view.addObject("companys", companys);
		
		String path = request.getSession().getServletContext().getRealPath("");
		String trackingTagStr = StreamUtils.readFile(path + File.separator + "res" + File.separator + "tracking_tag_1.txt");
		view.addObject("trackingTagStr", trackingTagStr);
		
		String gaStr = StreamUtils.readFile(path + File.separator + "res" + File.separator + "ga.txt");
		view.addObject("gaStr", gaStr);
		return view;
	}
	
	@RequestMapping("getPlatform")
    @ResponseBody
    public List<Store> getPlatform(Integer companyId) {
        List<Store> platforms = storeService.getPlatforms(companyId);
        for (Store store : platforms) {
            switch (store.getPlatform()) {
                case Constants.PLATFORM_EBAY : 
                    store.setName("EBAY");
                    break;
                case Constants.PLATFORM_AMAZON : 
                    store.setName("AMAZON");
                    break;
                case Constants.PLATFORM_ALIEXPRESS : 
                    store.setName("ALIEXPRESS");
                    break;
                case Constants.PLATFORM_WISH : 
                    store.setName("WISH");
                    break;
                case Constants.PLATFORM_ECSHOP : 
                    store.setName("ECSHOP");
                    break;
                case Constants.PLATFORM_MAGENTO : 
                    store.setName("MAGENTO");
                    break;
                default : store.setName("");
            }
        }
        return platforms;
    }
	
	@RequestMapping("getStore")
    @ResponseBody
    public List<Store> getStore(Store po) {
        return storeService.getStores(po);
    }

    @RequestMapping("getSite")
    @ResponseBody
    public List<EbayListingPO> getSite(EbayListingPO po) {
        return ebayListingService.selectSiteByCompanyAndStore(po);
    }
    
    /**
	 * 批量更新pixel
	 * @return
	 */
	@RequestMapping("batchUpdate")
	//@ResponseBody
	public ModelAndView batchUpdate(HttpServletRequest request, TrackingTagPO trackingTagPO)
	{
		String msg = "";
		try {
			String path = request.getSession().getServletContext().getRealPath("");
			ebayListingService.batchUpdatePixel(path, trackingTagPO);
			msg = String.format(FORMAT, "success", "success");
		} catch (Exception e){
			logger.error(e.toString(), e);
			msg = String.format(FORMAT, "error", e.toString());
		}
		ModelAndView view = new ModelAndView("/system/trackingTag/home");
		view.addObject("msg", msg);
		return view;
	}
	
	/**
	 * 批量更新pixel
	 * @return
	 */
//	@RequestMapping("syncStore")
//	@ResponseBody
	public String syncStore(HttpServletRequest request, String storeId) {
		String msg = "";
		try {
			if(StringUtils.isBlank(storeId)) {
				msg = "error: storeId is empty or null";
				logger.error(msg);
				return msg;
			}
			Integer storeIdInt = null;
			try {
				storeIdInt  = Integer.parseInt(storeId);
			} catch (Exception e) {
				msg = "error: storeId (" + storeId + ") must be number";
				logger.error(msg + "\n" + e.toString(), e);
				return msg;
			}
			
			String path = request.getSession().getServletContext().getRealPath("");
			msg = ebayListingService.batchUpdateDescByStore(storeIdInt, path);
		} catch (Exception e){
			logger.error(e.toString(), e);
			msg = "error: " + e.toString();
		}
		return msg;
	}
}
