package com.lt.backend.marketing.controller;

import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import com.google.gson.Gson;
import com.lt.backend.marketing.service.IAudienceService;
import com.lt.backend.system.service.ICompanyService;
import com.lt.backend.system.service.IEbayListingService;
import com.lt.backend.system.service.IStoreService;
import com.lt.dao.model.Store;
import com.lt.dao.po.EbayListingPO;
import com.lt.dao.po.GoogleAdwordsAudiencePO;
import com.lt.platform.util.Constants;

@Controller
@RequestMapping("/marketing")
public class AudienceController
{
    
    @Autowired
    IAudienceService audienceService;
    @Autowired
    ICompanyService companyService;
    @Autowired
    IStoreService storeService;
    @Autowired
    IEbayListingService ebayListingService;

    /**
     * 
     * @param AdChangeLogPO
     * @return
     * @throws Exception
     */
    @RequestMapping("audience/getAudienceList")
    public ModelAndView getAudienceList(HttpServletRequest request, GoogleAdwordsAudiencePO po) {
        po.setRequestPath(request);
        po.setIspaging(true);
        po.setResults(audienceService.getAudienceList(po));
        ModelAndView mv = new ModelAndView("/marketing/audience_list");
        mv.addObject("companys", companyService.selectAll());
        mv.addObject("page", po);
        return mv;
    }

    @RequestMapping("audience/getPlatform")
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

    @RequestMapping("audience/getStore")
    @ResponseBody
    public List<Store> getStore(Store po) {
        return storeService.getStores(po);
    }

    @RequestMapping("audience/getSite")
    @ResponseBody
    public List<EbayListingPO> getSite(EbayListingPO po) {
        return ebayListingService.selectSiteByCompanyAndStore(po);
    }

    @RequestMapping("audience/checkExist")
    @ResponseBody
    public String checkExist(String name, Integer id, String rule) {
        try {
            new Gson().fromJson(rule, Map.class);
        } catch (Exception e) {
            return "Criteria is Illegal JSON format!";
        }
        return audienceService.checkExist(name, id) ? "1" : "0";
    }
    


    @RequestMapping("audience/createAudience")
    public String createAudience(HttpServletRequest request, GoogleAdwordsAudiencePO po) {
        po.setIsRun(false);
        audienceService.saveAudience(po);
        return "redirect:/marketing/audience/getAudienceList.shtml";
    }
    
}
