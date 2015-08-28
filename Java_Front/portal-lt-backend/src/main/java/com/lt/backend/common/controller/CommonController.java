package com.lt.backend.common.controller;

import java.util.List;

import javax.servlet.http.HttpServletRequest;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.lt.backend.googleadwords.service.IAdwordsService;
import com.lt.backend.marketing.service.IAudienceService;
import com.lt.backend.system.service.ITransactionAuthorizeInstantService;
import com.lt.dao.model.AdCampaign;
import com.lt.dao.model.AdGroup;
import com.lt.dao.model.GoogleAdwordsAd;
import com.lt.dao.model.GoogleAdwordsAdGroupWithBLOBs;
import com.lt.dao.model.GoogleAdwordsBudget;
import com.lt.dao.model.GoogleAdwordsCampaignWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAdGroupWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAdWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAutomaticPlacements;
import com.lt.dao.model.GoogleAdwordsReportCampaignWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportDestinationUrl;
import com.lt.dao.model.GoogleAdwordsReportGeo;
import com.lt.dao.model.GoogleAdwordsReportKeywordsWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportUrl;
import com.lt.dao.model.GoogleAnalyticsReportAudienceOverview;
import com.lt.dao.model.GoogleAnalyticsReportPagePath;
import com.lt.dao.po.GoogleAdwordsAudiencePO;
import com.lt.platform.util.CommonUtil;
import com.lt.platform.util.Constants;
import com.lt.platform.util.VPNUtil;
import com.lt.platform.util.config.PropertiesUtil;
import com.lt.platform.util.security.MD5Util;
import com.lt.thirdpartylibrary.googleadwords.service.IBaseOperatorService;

@Controller
@RequestMapping("/common")
public class CommonController
{
    
    private static Logger log = LoggerFactory.getLogger(CommonController.class);
    @Autowired
    IBaseOperatorService baseOperatorService;
    @Autowired
    IAdwordsService adwordsService;
    @Autowired
    IAudienceService audienceService;
    @Autowired
    ITransactionAuthorizeInstantService transactionAuthorizeInstantService;

    /**
     * 
     * VPN下载后的数据插入数据库
     * 
     * @param json
     *          数据
     * @param key
     *          用于验证链接来源合法性（MD5加密）
     * @return
     * @throws Exception
     */
    @RequestMapping("adwords/downloadAdwordsReportCampaign")
    @ResponseBody
    public String downloadAdwordsReportCampaign(String json, String key) {
        log.info("downloadAdwordsReportCampaign start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key incorrect,invalid key! key=" + key);
            return "invalid key!";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsReportCampaignWithBLOBs> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsReportCampaignWithBLOBs>>(){}.getType());
        adwordsService.downloadAdwordsReportCampaign(list);
        log.info("downloadAdwordsReportCampaign end!");
        return Constants.SUCCESS;
    }

    @RequestMapping("adwords/fakeHostAd")
    public ModelAndView fakeHostAd(HttpServletRequest request, String itemId, String ga_track_id) {
//        String gaTrackingId = adwordsService.selectGaTrackingIdByEbayListingId(itemId);
        log.info("getQueryString:" + request.getQueryString());
        log.info(String.format("adwords fake host request reached, itemId=%s,ga_track_id=%s,referrer=%s", itemId, ga_track_id, request.getHeader("Referer")));
        ModelAndView mv = new ModelAndView("fakeHostAd");
        mv.addObject("ga_track_id", ga_track_id);
        mv.addObject("itemId", itemId);
        return mv;
    }
    @RequestMapping("adwords/tracking")
    public ModelAndView tracking(HttpServletRequest request, String itemId, String ga_track_id, String placement, String keyword, String campaignid, String targetid) {
//        String gaTrackingId = adwordsService.selectGaTrackingIdByEbayListingId(itemId);
        log.info("getQueryString:" + request.getQueryString());
        log.info(String.format("adwords request reached, itemId=%s,ga_track_id=%s,placement=%s,keyword=%s,campaignid=%s,targetid=%s", itemId, ga_track_id, placement, keyword, campaignid, targetid));
        ModelAndView mv = new ModelAndView("tracking");
        mv.addObject("ga_track_id", ga_track_id);
        mv.addObject("itemId", itemId);
        return mv;
    }
    
    @RequestMapping("adwords/downloadAdwordsReportAdGroup")
    public String downloadAdwordsReportAdGroup(String json, String key) {
        log.info("downloadAdwordsReportAdGroup start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsReportAdGroupWithBLOBs> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsReportAdGroupWithBLOBs>>(){}.getType());
        adwordsService.downloadAdwordsReportAdGroup(list);
        log.info("downloadAdwordsReportAdGroup end!");
        return Constants.SUCCESS;
    }
    @RequestMapping("adwords/downloadAdwordsReportAd")
    public String downloadAdwordsReportAd(String json, String key)
    {
        log.info("downloadAdwordsReportAd start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsReportAdWithBLOBs> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsReportAdWithBLOBs>>(){}.getType());
        adwordsService.downloadAdwordsReportAd(list);
        log.info("downloadAdwordsReportAd end!");
        return Constants.SUCCESS;
    }
    @RequestMapping("adwords/downloadAdwordsReportAutomaticPlacements")
    public String downloadAdwordsReportAutomaticPlacements(String json, String key) {
        log.info("downloadAdwordsReportAutomaticPlacements start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsReportAutomaticPlacements> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsReportAutomaticPlacements>>(){}.getType());
        adwordsService.downloadAdwordsReportAutomaticPlacements(list);
        log.info("downloadAdwordsReportAutomaticPlacements end!");
        return Constants.SUCCESS;
    }
    @RequestMapping("adwords/downloadAdwordsReportDestinationUrl")
    public String downloadAdwordsReportDestinationUrl(String json, String key) {
        log.info("downloadAdwordsReportDestinationUrl start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsReportDestinationUrl> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsReportDestinationUrl>>(){}.getType());
        adwordsService.downloadAdwordsReportDestinationUrl(list);
        log.info("downloadAdwordsReportDestinationUrl end!");
        return Constants.SUCCESS;
    }
    @RequestMapping("adwords/downloadAdwordsReportGeo")
    public String downloadAdwordsReportGeo(String json, String key) {
        log.info("downloadAdwordsReportGeo start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsReportGeo> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsReportGeo>>(){}.getType());
        adwordsService.downloadAdwordsReportGeo(list);
        log.info("downloadAdwordsReportGeo end!");
        return Constants.SUCCESS;
    }
    
    @RequestMapping("adwords/downloadAdwordsReportKeywords")
    public String downloadAdwordsReportKeywords(String json, String key) {
        log.info("downloadAdwordsReportKeywords start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsReportKeywordsWithBLOBs> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsReportKeywordsWithBLOBs>>(){}.getType());
        adwordsService.downloadAdwordsReportKeywords(list);
        log.info("downloadAdwordsReportKeywords end!");
        return Constants.SUCCESS;
    }
    
    @RequestMapping("adwords/downloadAdwordsReportUrl")
    public String downloadAdwordsReportUrl(String json, String key) {
        log.info("downloadAdwordsReportUrl start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsReportUrl> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsReportUrl>>(){}.getType());
        adwordsService.downloadAdwordsReportUrl(list);
        log.info("downloadAdwordsReportUrl end!");
        return Constants.SUCCESS;
    }
    
    @RequestMapping("adwords/downloadAdwordsCampaign")
    public String downloadAdwordsCampaign(String json, String key) {
        log.info("downloadAdwordsCampaign start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsCampaignWithBLOBs> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsCampaignWithBLOBs>>(){}.getType());
        adwordsService.downloadAdwordsCampaign(list);
        log.info("downloadAdwordsCampaign end!");
        return Constants.SUCCESS;
    }
    @RequestMapping("adwords/downloadAdwordsAdGroup")
    public String downloadAdwordsAdGroup(String json, String key) {
        log.info("downloadAdwordsAdGroup start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsAdGroupWithBLOBs> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsAdGroupWithBLOBs>>(){}.getType());
        adwordsService.downloadAdwordsAdGroup(list);
        log.info("downloadAdwordsAdGroup end!");
        return Constants.SUCCESS;
    }
    @RequestMapping("adwords/downloadAdwordsAd")
    public String downloadAdwordsAd(String json, String key) {
        log.info("downloadAdwordsAd start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsAd> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsAd>>(){}.getType());
        adwordsService.downloadAdwordsAd(list);
        log.info("downloadAdwordsAd end!");
        return Constants.SUCCESS;
    }
    @RequestMapping("adwords/downloadAdwordsBudget")
    public String downloadAdwordsBudget(String json, String key) {
        log.info("downloadAdwordsBudget start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAdwordsBudget> list = gson.fromJson(json, new TypeToken<List<GoogleAdwordsBudget>>(){}.getType());
        adwordsService.downloadAdwordsBudget(list);
        log.info("downloadAdwordsBudget end!");
        return Constants.SUCCESS;
    }

    @RequestMapping("adwords/updateCampaignCostByInstant")
    public String updateCampaignCostByInstant(String date, String key) {
        log.info("updateCampaignCostByInstant start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用!";
        }
        transactionAuthorizeInstantService.updateCampaignCostByInstant(date.substring(0,4) + "-" + date.substring(4,6) + "-" + date.substring(6,8));
        log.info("updateCampaignCostByInstant end!");
        return Constants.SUCCESS;
    }

    @RequestMapping("analytics/downloadAnalyticsReportAudienceOverview")
    public String downloadAnalyticsReportAudienceOverview(String json, String key) {
        log.info("downloadAnalyticsReportAudienceOverview start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAnalyticsReportAudienceOverview> list = gson.fromJson(json, new TypeToken<List<GoogleAnalyticsReportAudienceOverview>>(){}.getType());
        adwordsService.downloadAnalyticsReportAudienceOverview(list);
        log.info("downloadAnalyticsReportAudienceOverview end!");
        return Constants.SUCCESS;
    }

    @RequestMapping("analytics/downloadAnalyticsReportPagePath")
    public String downloadAnalyticsReportPagePath(String json, String key) {
        log.info("downloadAnalyticsReportPagePath start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        Gson gson = new Gson();
        List<GoogleAnalyticsReportPagePath> list = gson.fromJson(json, new TypeToken<List<GoogleAnalyticsReportPagePath>>(){}.getType());
        adwordsService.downloadAnalyticsReportPagePath(list);
        log.info("downloadAnalyticsReportPagePath end!");
        return Constants.SUCCESS;
    }
    
    /**
     * 
     * 添加campaign
     * 
     * @param json
     * @return
     * @throws Exception
     */
    @RequestMapping("adwords/addCampaign")
    @ResponseBody
    public Integer addCampaign(String json) throws Exception
    {
        AdCampaign campaign = CommonUtil.json2Ojbect(json, AdCampaign.class);
        if (!VPNUtil.connectVPN()) return 0;
        boolean result = false;
        try
        {
            result = baseOperatorService.addCampaigns(campaign);
        } catch (Exception e)
        {
            log.error("添加Campaign失败，参数：" + json);
            log.error("异常信息" + CommonUtil.getExceptionMessage(e));
        } finally {
            VPNUtil.disconnectVPN();
        }
        return result ? 1 : 0;
    }
    
    /**
     * 添加campaign
     * 
     * @param json
     * @return
     * @throws Exception
     */
    @RequestMapping("adwords/addGroup")
    @ResponseBody
    public Integer addGroup(String json)
    {
        AdGroup group = CommonUtil.json2Ojbect(json, AdGroup.class);
        if (!VPNUtil.connectVPN()) return 0;
        boolean result = false;
        try
        {
            result = baseOperatorService.AddAdGroups(group);
        } catch (Exception e)
        {
            log.error("添加Group失败，参数：" + json);
            log.error("异常信息" + CommonUtil.getExceptionMessage(e));
        } finally {
            VPNUtil.disconnectVPN();
        }
        return result ? 1 : 0;
    }

    @RequestMapping("adwords/getAudienceJobList")
    @ResponseBody
    public List<GoogleAdwordsAudiencePO> getAudienceJobList(String key) {
        log.info("downloadAdwordsBudget start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return null;
        }
        return audienceService.getJobList();
    }

    @RequestMapping("adwords/updateAudienceRun")
    @ResponseBody
    public String updateAudienceRun(String ids, String key) {

        log.info("downloadAdwordsBudget start!");
        if (!key.equals(MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()))) {
            log.info("remote.key不正确，非法调用!");
            return "remote.key不正确，非法调用";
        }
        audienceService.updateAudienceRun(ids);
        return Constants.SUCCESS;
    }
    
    public void downloadAudienceList() throws Exception {
        baseOperatorService.downloadAudienceList();
    }
    
    public String addAudienceList(String audienceListName, String id) throws Exception{
        
        try {
            baseOperatorService.addAudienceList(audienceListName, id);
            return Constants.SUCCESS;
        } catch (Exception e) {
            log.error(CommonUtil.getExceptionMessage(e));
            return CommonUtil.getExceptionMessage(e);
        }
    }
    
    public String updateAudiencelist(Long audienceListId, String audienceListName, String id) throws Exception{
        
        try {
            baseOperatorService.updateAudienceList(audienceListId, audienceListName, id);
            return Constants.SUCCESS;
        } catch (Exception e) {
            log.error(CommonUtil.getExceptionMessage(e));
            return CommonUtil.getExceptionMessage(e);
        }
    }
    
    public String deleteAudiencelist(Long audienceListId) {
        try {
            baseOperatorService.deleteAudienceList(audienceListId);
            return Constants.SUCCESS;
        } catch (Exception e) {
            log.error(CommonUtil.getExceptionMessage(e));
            return CommonUtil.getExceptionMessage(e);
        }
    }

}
