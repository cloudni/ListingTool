package com.lt.backend.googleadwords.service.impl;

import java.util.List;

import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.googleadwords.service.IAdwordsService;
import com.lt.dao.mapper.AdCampaignMapper;
import com.lt.dao.mapper.AdGroupMapper;
import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.mapper.EbayListingMapper;
import com.lt.dao.mapper.GoogleAdwordsAdGroupMapper;
import com.lt.dao.mapper.GoogleAdwordsAdMapper;
import com.lt.dao.mapper.GoogleAdwordsBudgetMapper;
import com.lt.dao.mapper.GoogleAdwordsCampaignMapper;
import com.lt.dao.mapper.GoogleAdwordsReportAdGroupMapper;
import com.lt.dao.mapper.GoogleAdwordsReportAdMapper;
import com.lt.dao.mapper.GoogleAdwordsReportAutomaticPlacementsMapper;
import com.lt.dao.mapper.GoogleAdwordsReportCampaignMapper;
import com.lt.dao.mapper.GoogleAdwordsReportDestinationUrlMapper;
import com.lt.dao.mapper.GoogleAdwordsReportGeoMapper;
import com.lt.dao.mapper.GoogleAdwordsReportKeywordsMapper;
import com.lt.dao.mapper.GoogleAdwordsReportUrlMapper;
import com.lt.dao.mapper.GoogleAnalyticsReportAudienceOverviewMapper;
import com.lt.dao.mapper.GoogleAnalyticsReportPagePathMapper;
import com.lt.dao.model.AdCampaign;
import com.lt.dao.model.Company;
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
import com.lt.platform.util.CommonUtil;
import com.lt.platform.util.MailUtil;
import com.lt.platform.util.config.PropertiesUtil;
import com.lt.platform.util.time.DateFormatUtil;

@Service
public class AdwordsServiceImpl implements IAdwordsService
{
    private Logger log = Logger.getLogger(AdwordsServiceImpl.class);

    @Autowired
    private GoogleAdwordsReportAdGroupMapper googleAdwordsReportAdGroupMapper;
    @Autowired
    private GoogleAdwordsReportAdMapper googleAdwordsReportAdMapper;
    @Autowired
    private GoogleAdwordsReportAutomaticPlacementsMapper googleAdwordsReportAutomaticPlacementsMapper;
    @Autowired
    private GoogleAdwordsReportCampaignMapper googleAdwordsReportCampaignMapper;
    @Autowired
    private GoogleAdwordsReportDestinationUrlMapper googleAdwordsReportDestinationUrlMapper;
    @Autowired
    private GoogleAdwordsReportGeoMapper googleAdwordsReportGeoMapper;
    @Autowired
    private GoogleAdwordsReportKeywordsMapper googleAdwordsReportKeywordsMapper;
    @Autowired
    private GoogleAdwordsReportUrlMapper googleAdwordsReportUrlMapper;
    
    @Autowired
    private GoogleAdwordsAdMapper googleAdwordsAdMapper;
    @Autowired
    private GoogleAdwordsAdGroupMapper googleAdwordsAdGroupMapper;
    @Autowired
    private GoogleAdwordsCampaignMapper googleAdwordsCampaignMapper;
    @Autowired
    private GoogleAdwordsBudgetMapper googleAdwordsBudgetMapper;
    @Autowired
    private CompanyMapper companyMapper;
    @Autowired
    private AdCampaignMapper adCampaignMapper;
    @Autowired
    private AdGroupMapper adGroupMapper;

    @Autowired
    private GoogleAnalyticsReportAudienceOverviewMapper googleAnalyticsReportAudienceOverviewMapper;
    @Autowired
    private GoogleAnalyticsReportPagePathMapper googleAnalyticsReportPagePathMapper;
    
    @Autowired
    private EbayListingMapper ebayListingMapper;
    
    private static Integer adminId = 1;
    private static String toMail = "cloud.liu@nirvana-info.com";
    
    @Override
    public boolean downloadAdwordsReportAd(
            List<GoogleAdwordsReportAdWithBLOBs> list)
    {
        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAdwordsReportAdMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAdwordsReportAdWithBLOBs record : list)
        {
            googleAdwordsReportAdMapper.insert(record);
        }
        return true;
    }

    @Override
    public boolean downloadAdwordsReportAdGroup(
            List<GoogleAdwordsReportAdGroupWithBLOBs> list)
    {

        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAdwordsReportAdGroupMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAdwordsReportAdGroupWithBLOBs record : list)
        {
            googleAdwordsReportAdGroupMapper.insert(record);
        }
        return true;
    }

    @Override
    public boolean downloadAdwordsReportCampaign(
            List<GoogleAdwordsReportCampaignWithBLOBs> list)
    {

        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAdwordsReportCampaignMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAdwordsReportCampaignWithBLOBs record : list)
        {
            googleAdwordsReportCampaignMapper.insert(record);
        }
        return true;
    }

    @Override
    public boolean downloadAdwordsReportAutomaticPlacements(
            List<GoogleAdwordsReportAutomaticPlacements> list)
    {
        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAdwordsReportAutomaticPlacementsMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAdwordsReportAutomaticPlacements record : list)
        {
            googleAdwordsReportAutomaticPlacementsMapper.insert(record);
        }
        return true;
    }

    @Override
    public boolean downloadAdwordsReportDestinationUrl(
            List<GoogleAdwordsReportDestinationUrl> list)
    {
        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAdwordsReportDestinationUrlMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAdwordsReportDestinationUrl record : list)
        {
            googleAdwordsReportDestinationUrlMapper.insert(record);
        }
        return true;
    }

    @Override
    public boolean downloadAdwordsReportGeo(List<GoogleAdwordsReportGeo> list)
    {
        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAdwordsReportGeoMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAdwordsReportGeo record : list)
        {
            googleAdwordsReportGeoMapper.insert(record);
        }
        return true;
    }

    @Override
    public boolean downloadAdwordsReportKeywords(List<GoogleAdwordsReportKeywordsWithBLOBs> list)
    {
        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAdwordsReportKeywordsMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAdwordsReportKeywordsWithBLOBs record : list)
        {
            googleAdwordsReportKeywordsMapper.insert(record);
        }
        return true;
    }

    @Override
    public boolean downloadAdwordsReportUrl(List<GoogleAdwordsReportUrl> list)
    {
        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAdwordsReportUrlMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAdwordsReportUrl record : list)
        {
            googleAdwordsReportUrlMapper.insert(record);
        }
        return true;
    }

    @Override
    public boolean downloadAdwordsCampaign(
            List<GoogleAdwordsCampaignWithBLOBs> list)
    {
        for (GoogleAdwordsCampaignWithBLOBs record : list) 
        {
            GoogleAdwordsCampaignWithBLOBs org = googleAdwordsCampaignMapper.selectByPrimaryKey(record.getId());
            if (org != null) {
                record.setLtAdCampaignId(org.getLtAdCampaignId());
                record.setCreateAdminId(org.getCreateAdminId());
                record.setCreateTimeUtc(org.getCreateTimeUtc());
                record.setUpdateAdminId(org.getUpdateAdminId());
                record.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
            } else {
                record.setCreateAdminId(adminId);
                record.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
                record.setUpdateAdminId(adminId);
                record.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
            }
            if (!"REMOVED".equals(record.getStatus())) {
                record.setLtAdCampaignId(getLtCampaignId(record.getName()));
            }
            googleAdwordsCampaignMapper.deleteByPrimaryKey(record.getId());
            googleAdwordsCampaignMapper.insert(record);
        }
        return false;
    }

    @Override
    public boolean downloadAdwordsAdGroup(
            List<GoogleAdwordsAdGroupWithBLOBs> list)
    {
        for (GoogleAdwordsAdGroupWithBLOBs record : list) 
        {
            GoogleAdwordsAdGroupWithBLOBs org = googleAdwordsAdGroupMapper.selectByPrimaryKey(record.getId());
            if (org != null) {
                record.setLtAdGroupId(org.getLtAdGroupId());
                record.setCreateAdminId(org.getCreateAdminId());
                record.setCreateTimeUtc(org.getCreateTimeUtc());
                record.setUpdateAdminId(org.getUpdateAdminId());
                record.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
            } else {
                record.setCreateAdminId(adminId);
                record.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
                record.setUpdateAdminId(adminId);
                record.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
            }
            if (!"REMOVED".equals(record.getStatus())) {
                record.setLtAdGroupId(getLtGroupId(record.getName()));
            }
            googleAdwordsAdGroupMapper.deleteByPrimaryKey(record.getId());
            googleAdwordsAdGroupMapper.insert(record);
        }
        return false;
    }

    @Override
    public boolean downloadAdwordsAd(List<GoogleAdwordsAd> list)
    {
        for (GoogleAdwordsAd record : list) 
        {
            GoogleAdwordsAd org = googleAdwordsAdMapper.selectByPrimaryKey(record.getId());
            if (org != null)
            {
                record.setLtAdAdvertiseVariationId(org.getLtAdAdvertiseVariationId());
            }
            googleAdwordsAdMapper.deleteByPrimaryKey(record.getId());
            googleAdwordsAdMapper.insert(record);
        }
        return false;
    }

    @Override
    public boolean downloadAdwordsBudget(List<GoogleAdwordsBudget> list)
    {
        for (GoogleAdwordsBudget record : list) 
        {
            googleAdwordsBudgetMapper.deleteByPrimaryKey(record.getBudgetId());
            googleAdwordsBudgetMapper.insert(record);
        }
        return false;
    }


    
    /**
     * 取得campaignID，命名规则：$$$username####company_id###campaign_name(20位)###campaign_id$$$
     * @param name
     * @return
     */
    private Long getLtCampaignId(String name) {
        try {

//            String format = "$$$username####company_id###campaign_name(20位)###campaign_id$$$";
            String[] campaigns = name.split("###");
//            if (campaigns.length != 4) {
//                MailUtil.sendHTMLMail(toMail, "campaign name 设置有误", "\t原始内容:" + name + "<br/>格式有误,必须是：" + format);
//                return null;
//            }
            
            Company para = new Company();
            para.setId(Integer.parseInt(campaigns[1]));
            Company company = companyMapper.selectByPrimaryKey(para);
            if (company == null) {
                MailUtil.sendHTMLMail(toMail, "company_id设置有误", "\t原始内容:" + name + "<br/>格式有误,company_id: " + campaigns[1] + "不存在");
                return null;
            }

            String campaignId = campaigns.length > 4 ? campaigns[3] : campaigns[3].substring(0, campaigns[3].length() - 3);
            AdCampaign campaign = adCampaignMapper.selectByPrimaryKey(Integer.parseInt(campaignId));
            if (campaign == null) {
                MailUtil.sendHTMLMail(toMail, "campaign_id设置有误", "\t原始内容:" + name + "<br/>格式有误,campaign_id:" + campaignId + "不存在");
                return null;
            }
            
            return Long.parseLong(campaignId);
        } catch(Exception e) {
            MailUtil.sendHTMLMail(toMail, "Campaign Name设置有误", "\t原始内容:" + name + "<br/>格式有误");
            log.error(CommonUtil.getExceptionMessage(e));
            return null;
        }
    }
    
    static {

        try
        {
            toMail = PropertiesUtil.getContextProperty("mail.error.to").toString();
        } catch (Exception e)
        {
        }
    }
    /**
     * 取得groupID，命名规则:$$$username###company_id###campaign_name(20位)###campaign_id###group_name(20位)###group_id$$$
     * @param name
     * @return
     */
    private Integer getLtGroupId(String name) {
        try {
//            String format = "$$$username###company_id###campaign_name(20位)###campaign_id###group_name(20位)###group_id$$$";
            String[] groups = name.split("###");
//            if (groups.length != 6) {
//                // send mail
//                MailUtil.sendHTMLMail(toMail, "group name 设置有误", "\t原始内容:" + name + "<br/>格式有误,必须是：" + format);
//                return null;
//            }
    
            Company para = new Company();
            para.setId(Integer.parseInt(groups[1]));
            Company company = companyMapper.selectByPrimaryKey(para);
            if (company == null) {
                MailUtil.sendHTMLMail(toMail, "company_id设置有误", "\t原始内容:" + name + "<br/>格式有误,company_id: " + groups[1] + "不存在");
                return null;
            }
            
            AdCampaign campaign = adCampaignMapper.selectByPrimaryKey(Integer.parseInt(groups[3]));
            if (campaign == null) {
                MailUtil.sendHTMLMail(toMail, "campaign_id设置有误", "\t原始内容:" + name + "<br/>格式有误,campaign_id:" + groups[3] + "不存在");
                return null;
            }
            
            String groupId = groups.length > 6 ? groups[5] :  groups[5].substring(0, groups[5].length() - 3);
            com.lt.dao.model.AdGroup group = adGroupMapper.selectByPrimaryKey(Integer.parseInt(groupId));
            if (group == null) {
                MailUtil.sendHTMLMail(toMail, "group_id设置有误", "\t原始内容:" + name + "<br/>格式有误,group_id:" + groupId + "不存在");
                return null;
            }
            
            return Integer.parseInt(groupId);
        } catch(Exception e) {
            MailUtil.sendHTMLMail(toMail, "Group Name设置有误", "\t原始内容:" + name + "<br/>格式有误");
            log.error(CommonUtil.getExceptionMessage(e));
            return null;
        }
    }

    @Override
    public boolean downloadAnalyticsReportAudienceOverview(List<GoogleAnalyticsReportAudienceOverview> list)
    {
        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAnalyticsReportAudienceOverviewMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAnalyticsReportAudienceOverview record : list)
        {
            googleAnalyticsReportAudienceOverviewMapper.insert(record);
        }
        return true;
    }

    @Override
    public String selectGaTrackingIdByEbayListingId(String ebayListingId)
    {
        return ebayListingMapper.selectGaTrackingIdByEbayListingId(ebayListingId);
    }

    @Override
    public boolean downloadAnalyticsReportPagePath(List<GoogleAnalyticsReportPagePath> list)
    {
        if (list == null || list.size() == 0)
        {
            return true;
        }
        googleAnalyticsReportPagePathMapper.deleteByDate(list.get(0).getDate());
        for (GoogleAnalyticsReportPagePath record : list)
        {
            googleAnalyticsReportPagePathMapper.insert(record);
        }
        return true;
    }
}
