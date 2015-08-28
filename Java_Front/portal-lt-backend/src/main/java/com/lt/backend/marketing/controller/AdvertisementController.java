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
import com.lt.backend.marketing.service.IAdvertisementService;
import com.lt.backend.system.service.ICompanyService;
import com.lt.dao.po.AdAdvertiseFeedPO;
import com.lt.dao.po.AdAdvertiseVariationPO;
import com.lt.dao.po.AdCampaignPO;
import com.lt.dao.po.AdGroupPO;
import com.lt.platform.util.Constants;
import com.lt.platform.util.time.DateFormatUtil;
import com.ssoclient.utils.SessionUtil;

@Controller
@RequestMapping("/marketing")
public class AdvertisementController
{
    
    @Autowired
    IAdvertisementService advertisementService;
    @Autowired
    ICompanyService companyService;

    /**********************************Campaign start******************************************/
    
    /**
     * 
     * @param AdCampaignPO
     * @return
     * @throws Exception
     */
    @RequestMapping("advertisement/getCampaignList")
    public ModelAndView getCampaignList(HttpServletRequest request, AdCampaignPO po) {
        po.setRequestPath(request);
        po.setIspaging(true);
        po.setResults(advertisementService.getCampaignList(po));
        ModelAndView mv = new ModelAndView("/marketing/campaign_list");
        mv.addObject("companys", companyService.selectAll());
        mv.addObject("page", po);
        return mv;
    }

    @RequestMapping("advertisement/getCampaignById")
    @ResponseBody
    public AdCampaignPO getCampaignById(AdCampaignPO po) {
        List<AdCampaignPO> list = advertisementService.getCampaignList(po);
        if (list == null || list.size() == 0) {
            return null;
        }
        return list.get(0);
    }

    @RequestMapping("advertisement/getCampaignListByCompany")
    @ResponseBody
    public List<AdCampaignPO> getCampaignListByCompany(AdCampaignPO po) {
        List<AdCampaignPO> list = advertisementService.getCampaignList(po);
        return list;
    }

    @RequestMapping("advertisement/checkCampaignExist")
    @ResponseBody
    public String checkCampaignExist(String name) {
        return advertisementService.checkCampaignExist(name) ? "1" : "0";
    }

    @RequestMapping("advertisement/createCampaign")
    @ResponseBody
    public String createCampaign(HttpServletRequest request, AdCampaignPO po) {
        try {
            new Gson().fromJson(po.getCriteria(), Map.class);
        } catch (Exception e) {
            return "Criteria is Illegal JSON format!";
        }
        po.setIsDelete(false);
        Integer sysdate = DateFormatUtil.getCurrentIntegerTime();
        po.setCreateTimeUtc(sysdate);
        po.setCreateUserId(SessionUtil.getUserId(request));
        po.setUpdateTimeUtc(sysdate);
        po.setUpdateUserId(SessionUtil.getUserId(request));
        advertisementService.saveCampaign(po);
        return Constants.SUCCESS;
    }

    @RequestMapping("advertisement/updateCampaign")
    @ResponseBody
    public String updateCampaign(HttpServletRequest request, AdCampaignPO po) {
        try {
            new Gson().fromJson(po.getCriteria(), Map.class);
        } catch (Exception e) {
            return "Criteria is Illegal JSON format!";
        }
        po.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
        po.setUpdateUserId(SessionUtil.getUserId(request));
        advertisementService.updateCampaign(po);
        return Constants.SUCCESS;
    }
    /**********************************Campaign end******************************************/
    
    /**********************************Group start ******************************************/


    /**
     * 
     * @param AdGroupPO
     * @return
     * @throws Exception
     */
    @RequestMapping("advertisement/getGroupList")
    public ModelAndView getGroupList(HttpServletRequest request, AdGroupPO po) {
        po.setRequestPath(request);
        po.setIspaging(true);
        po.setResults(advertisementService.getGroupList(po));
        ModelAndView mv = new ModelAndView("/marketing/group_list");
        mv.addObject("companys", companyService.selectAll());
        mv.addObject("page", po);
        return mv;
    }

    @RequestMapping("advertisement/getGroupById")
    @ResponseBody
    public AdGroupPO getGroupById(AdGroupPO po) {
        List<AdGroupPO> list = advertisementService.getGroupList(po);
        if (list == null || list.size() == 0) {
            return null;
        }
        return list.get(0);
    }

    @RequestMapping("advertisement/getGroupListBySelective")
    @ResponseBody
    public List<AdGroupPO> getGroupListBySelective(AdGroupPO po) {
        return advertisementService.getGroupList(po);
    }

    @RequestMapping("advertisement/checkGroupExist")
    @ResponseBody
    public String checkGroupExist(AdGroupPO po) {
        return advertisementService.checkGroupExist(po) ? "1" : "0";
    }

    @RequestMapping("advertisement/createGroup")
    @ResponseBody
    public String createGroup(HttpServletRequest request, AdGroupPO po) {
        try {
            new Gson().fromJson(po.getCriteria(), Map.class);
        } catch (Exception e) {
            return "Criteria is Illegal JSON format!";
        }
        po.setIsDelete(false);
        Integer sysdate = DateFormatUtil.getCurrentIntegerTime();
        po.setCreateTimeUtc(sysdate);
        po.setCreateUserId(SessionUtil.getUserId(request));
        po.setUpdateTimeUtc(sysdate);
        po.setUpdateUserId(SessionUtil.getUserId(request));
        advertisementService.saveGroup(po);
        return Constants.SUCCESS;
    }

    @RequestMapping("advertisement/updateGroup")
    @ResponseBody
    public String updateGroup(HttpServletRequest request, AdGroupPO po) {
        try {
            new Gson().fromJson(po.getCriteria(), Map.class);
        } catch (Exception e) {
            return "Criteria is Illegal JSON format!";
        }
        po.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
        po.setUpdateUserId(SessionUtil.getUserId(request));
        advertisementService.updateGroup(po);
        return Constants.SUCCESS;
    }
    /**********************************Group end ******************************************/
    

    /**********************************AD start ******************************************/

    /**
     * 
     * @param AdGroupPO
     * @return
     * @throws Exception
     */
    @RequestMapping("advertisement/getAdFeedList")
    public ModelAndView getAdFeedList(HttpServletRequest request, AdAdvertiseFeedPO po) {
        po.setRequestPath(request);
        po.setIspaging(true);
        po.setResults(advertisementService.getAdFeedList(po));
        ModelAndView mv = new ModelAndView("/marketing/advertise_feed");
        mv.addObject("companys", companyService.selectAll());
        mv.addObject("page", po);
        return mv;
    }

    @RequestMapping("advertisement/getAdFeedById")
    @ResponseBody
    public AdAdvertiseFeedPO getAdFeedById(AdAdvertiseFeedPO po) {
        List<AdAdvertiseFeedPO> list = advertisementService.getAdFeedList(po);
        if (list == null || list.size() == 0) {
            return null;
        }
        return list.get(0);
    }
    

    @RequestMapping("advertisement/updateAdFeed")
    @ResponseBody
    public String updateAdFeed(HttpServletRequest request, AdAdvertiseFeedPO po) {
        po.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
        po.setUpdateUserId(SessionUtil.getUserId(request));
        advertisementService.updateAdFeed(po);
        return Constants.SUCCESS;
    }

    @RequestMapping("advertisement/getAdVariationList")
    @ResponseBody
    public ModelAndView getAdVariationList(HttpServletRequest request, AdAdvertiseVariationPO po) {
        po.setRequestPath(request);
        po.setIspaging(true);
        po.setResults(advertisementService.getAdVariationList(po));
        ModelAndView mv = new ModelAndView("/marketing/advertise_variation");
        mv.addObject("companys", companyService.selectAll());
        mv.addObject("page", po);
        return mv;
    }

    @RequestMapping("advertisement/getAdVariationByAdId")
    @ResponseBody
    public AdAdvertiseVariationPO getAdVariationByAdId(AdAdvertiseVariationPO po) {
        List<AdAdvertiseVariationPO> list = advertisementService.getAdVariationList(po);
        if (list == null || list.size() == 0) {
            return null;
        }
        return list.get(0);
    }

    @RequestMapping("advertisement/updateAdVariation")
    @ResponseBody
    public String updateAdVariation(HttpServletRequest request, AdAdvertiseVariationPO po) {
        try {
            new Gson().fromJson(po.getCriteria(), Map.class);
        } catch (Exception e) {
            return "Criteria is Illegal JSON format!";
        }
        po.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
        po.setUpdateUserId(SessionUtil.getUserId(request));
        advertisementService.updateAdVariation(po);
        return Constants.SUCCESS;
    }/**/
    /**********************************AD end ******************************************/
    
}
