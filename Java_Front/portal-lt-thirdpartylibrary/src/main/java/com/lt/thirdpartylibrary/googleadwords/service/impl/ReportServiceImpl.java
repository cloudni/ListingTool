package com.lt.thirdpartylibrary.googleadwords.service.impl;

import java.beans.PropertyDescriptor;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.lang.reflect.Constructor;
import java.lang.reflect.Field;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.commons.beanutils.BeanUtils;
import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.google.api.ads.adwords.axis.factory.AdWordsServices;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroup;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupAd;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupAdPage;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupAdServiceInterface;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupPage;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupServiceInterface;
import com.google.api.ads.adwords.axis.v201502.cm.Budget;
import com.google.api.ads.adwords.axis.v201502.cm.BudgetPage;
import com.google.api.ads.adwords.axis.v201502.cm.BudgetServiceInterface;
import com.google.api.ads.adwords.axis.v201502.cm.Campaign;
import com.google.api.ads.adwords.axis.v201502.cm.CampaignPage;
import com.google.api.ads.adwords.axis.v201502.cm.CampaignServiceInterface;
import com.google.api.ads.adwords.axis.v201502.cm.TemplateAd;
import com.google.api.ads.adwords.lib.client.AdWordsSession;
import com.google.api.ads.adwords.lib.jaxb.v201502.DownloadFormat;
import com.google.api.ads.adwords.lib.utils.ReportDownloadResponse;
import com.google.api.ads.adwords.lib.utils.v201502.ReportDownloader;
import com.google.gson.Gson;
import com.lt.dao.mapper.GoogleAdwordsReportKeywordsMapper;
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
import com.lt.dao.model.GoogleAdwordsReportKeywords;
import com.lt.dao.model.GoogleAdwordsReportKeywordsWithBLOBs;
import com.lt.platform.util.CSVAnalysis;
import com.lt.platform.util.CommonUtil;
import com.lt.platform.util.config.PropertiesUtil;
import com.lt.platform.util.http.HttpClientUtil;
import com.lt.platform.util.security.MD5Util;
import com.lt.platform.util.time.DateFormatUtil;
import com.lt.thirdpartylibrary.googleadwords.service.IReportService;
import com.lt.thirdpartylibrary.googleadwords.util.AdwordsUtil;

/**
 * 
 * @author Tik
 */
@Service
public class ReportServiceImpl implements IReportService
{

    private Logger log = Logger.getLogger(ReportServiceImpl.class);
    
//    @Autowired
//    private GoogleAdwordsReportAdGroupMapper googleAdwordsReportAdGroupMapper;
//    @Autowired
//    private GoogleAdwordsReportAdMapper googleAdwordsReportAdMapper;
//    @Autowired
//    private GoogleAdwordsReportAutomaticPlacementsMapper googleAdwordsReportAutomaticPlacementsMapper;
//    @Autowired
//    private GoogleAdwordsReportCampaignMapper googleAdwordsReportCampaignMapper;
//    @Autowired
//    private GoogleAdwordsReportDestinationUrlMapper googleAdwordsReportDestinationUrlMapper;
//    @Autowired
//    private GoogleAdwordsReportGeoMapper googleAdwordsReportGeoMapper;
      @Autowired
      private GoogleAdwordsReportKeywordsMapper googleAdwordsReportKeywordsMapper;

//    @Autowired
//    private GoogleAdwordsAdMapper googleAdwordsAdMapper;
//    @Autowired
//    private GoogleAdwordsAdGroupMapper googleAdwordsAdGroupMapper;
//    @Autowired
//    private GoogleAdwordsCampaignMapper googleAdwordsCampaignMapper;
//    @Autowired
//    private GoogleAdwordsBudgetMapper googleAdwordsBudgetMapper;
//    @Autowired
//    private CompanyMapper companyMapper;
//    @Autowired
//    private AdCampaignMapper adCampaignMapper;
//    @Autowired
//    private AdGroupMapper adGroupMapper;

    private static int PAGE_SIZE = 10000;
//  "http://192.168.0.48/portal-lt-backend/common/adwords/";
    private static final String ADWORDS_URL = "http://transaction.itemtool.com/portal-lt-backend/common/adwords/";
    
//    private static Integer adminId = 1;
    
    public void saveAdwordsReport(String sysDate) throws Exception 
    {
        
        /*String queryCampaign = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,CampaignStatus,ServingStatus,BudgetId,Ctr,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType ";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportCampaignWithBLOBs", queryCampaign, "CAMPAIGN_PERFORMANCE_REPORT", sysDate);

        String queryGroup = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,AdGroupId,AdGroupName,CampaignId,CampaignName,AdGroupStatus,Ctr,"
                + "CpcBid,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType ";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportAdGroupWithBLOBs", queryGroup, "ADGROUP_PERFORMANCE_REPORT", sysDate);
        
        String queryAd = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,Id,Headline,CampaignId,CampaignName,AdGroupId,AdGroupName,Ctr,"
                + "CreativeApprovalStatus,KeywordId,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType ";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportAdWithBLOBs", queryAd, "AD_PERFORMANCE_REPORT", sysDate);

        String queryPlacement = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,DisplayName,Domain,AdGroupId,AdGroupName,Ctr,"
                + "CriteriaParameters,Cost,Impressions,Clicks,AverageCpc ";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportAutomaticPlacements", queryPlacement, "AUTOMATIC_PLACEMENTS_PERFORMANCE_REPORT", sysDate);

        String queryDestination = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,AdGroupId,AdGroupName,EffectiveDestinationUrl,Ctr,"
                + "CriteriaParameters,Cost,Impressions,Clicks,AverageCpc,AveragePosition,ClickType,Device ";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportDestinationUrl", queryDestination, "DESTINATION_URL_REPORT", sysDate);*/
        
        /*String queryGeo = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,AdGroupId,AdGroupName,CountryCriteriaId,RegionCriteriaId,MetroCriteriaId,CityCriteriaId,MostSpecificCriteriaId,LocationType,Ctr,"
                + "Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device ";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportGeo", queryGeo, "GEO_PERFORMANCE_REPORT", sysDate);*/
        
        String queryKeywords = "AdGroupId,AdGroupName,AverageCpc,AverageCpm,AdGroupStatus,"
                + "Clicks,Cost,CpcBid,Ctr,Date,DayOfWeek,Device,Id,Impressions,KeywordMatchType,KeywordText,LabelIds,Labels,Month,MonthOfYear,Status,TopOfPageCpc,Week,Year";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportKeywordsWithBLOBs", queryKeywords, "KEYWORDS_PERFORMANCE_REPORT", sysDate);

        /*this.getCampaign(sysDate);
        this.getAdGroup(sysDate);
        this.getAd(sysDate);
        this.getBudget(sysDate);*/
    }
    
    /**
     * 解析下载的CSV报表，根据反射插入数据库
     * @param className
     *      要操作的entity对象
     * @param fileName
     *      CSV文件名
     * @param selectFields
     *      报表列，需要反射的字段
     */
    @SuppressWarnings({ "rawtypes", "unchecked" })
    public List saveReportObject(String className, String fileName, String selectFields) {

        try {
            List list = new ArrayList();
            // 读取CSV文件
            List<String[]> datas = CSVAnalysis.readCsv(fileName);
            if (datas == null || datas.size() <= 3) return null;
            for (int i = 2; i < datas.size() - 1; i++) {
                String[] row = datas.get(i);
                String[] fields = selectFields.split(",");
                Map<String, String> map = new HashMap<String, String>();
                for (int col = 0; col < fields.length; col++) {
                    if ("Ctr".equals(fields[col]) || "ctr_significance".equals(fields[col])) {
                        row[col] = row[col].replaceAll("%", "");
                    }
                    if ("CpcBid".equals(fields[col])) {
                        row[col] = row[col].replaceAll("--", "");
                    }
                    map.put(fields[col].toLowerCase(), "".equals(row[col]) ? null : row[col]);
                }
                
                //将报表中的值，set到相应的字段中
                Object obj = getReflectFields(className, map);
                
                // 插入数据库（先删后增）
                if (obj instanceof GoogleAdwordsReportAdWithBLOBs) {
                    GoogleAdwordsReportAdWithBLOBs record = (GoogleAdwordsReportAdWithBLOBs)obj;
//                    if (i == 2) googleAdwordsReportAdMapper.deleteByDate(record.getDate());
//                    googleAdwordsReportAdMapper.insert(record);
                    list.add(record);
                } else if (obj instanceof GoogleAdwordsReportAdGroupWithBLOBs) {
                    GoogleAdwordsReportAdGroupWithBLOBs record = (GoogleAdwordsReportAdGroupWithBLOBs)obj;
//                    if (i == 2) googleAdwordsReportAdGroupMapper.deleteByDate(record.getDate());
//                    googleAdwordsReportAdGroupMapper.insert(record);
                    list.add(record);
                } else if (obj instanceof GoogleAdwordsReportCampaignWithBLOBs) {
                    GoogleAdwordsReportCampaignWithBLOBs record = (GoogleAdwordsReportCampaignWithBLOBs)obj;
//                    if (i == 2) googleAdwordsReportCampaignMapper.deleteByDate(record.getDate());
//                    googleAdwordsReportCampaignMapper.insert(record);
                    list.add(record);
                } else if (obj instanceof GoogleAdwordsReportAutomaticPlacements) {
                    GoogleAdwordsReportAutomaticPlacements record = (GoogleAdwordsReportAutomaticPlacements)obj;
//                    if (i == 2) googleAdwordsReportAutomaticPlacementsMapper.deleteByDate(record.getDate());
//                    googleAdwordsReportAutomaticPlacementsMapper.insert(record);
                    list.add(record);
                } else if (obj instanceof GoogleAdwordsReportDestinationUrl) {
                    GoogleAdwordsReportDestinationUrl record = (GoogleAdwordsReportDestinationUrl)obj;
//                    if (i == 2) googleAdwordsReportDestinationUrlMapper.deleteByDate(record.getDate());
//                    googleAdwordsReportDestinationUrlMapper.insert(record);
                    list.add(record);
                } else if (obj instanceof GoogleAdwordsReportGeo) {
                    GoogleAdwordsReportGeo record = (GoogleAdwordsReportGeo)obj;
//                    if (i == 2) googleAdwordsReportGeoMapper.deleteByDate(record.getDate());
//                    googleAdwordsReportGeoMapper.insert(record);
                    list.add(record);
                } else if (obj instanceof GoogleAdwordsReportKeywordsWithBLOBs) {
                    GoogleAdwordsReportKeywordsWithBLOBs record = (GoogleAdwordsReportKeywordsWithBLOBs)obj;
                  if (i == 2) googleAdwordsReportKeywordsMapper.deleteByDate(record.getDate());
                  googleAdwordsReportKeywordsMapper.insert(record);
//                  list.add(record);
                }
            }
            return list;
        } catch (Exception e) {
            log.error("saveDB error, className:" + className + "\tfileName:" + fileName + "\tselectFields:" + selectFields);
            log.error(CommonUtil.getExceptionMessage(e));
            return null;
        }
    }
    
    public Object getReflectFields(String className, Map<String, String> map)
    {
        try
        {
            Class<?> clazz = Class.forName(className);
            Object obj = clazz.newInstance();
            Field[] fields = clazz.getDeclaredFields();

            // 写数据
            for (Field f : fields)
            {
                if (map.get(f.getName().toLowerCase()) == null) continue;
                PropertyDescriptor pd = new PropertyDescriptor(f.getName(),clazz);
                Method method = pd.getWriteMethod();// 获得写方法
                Class<?> typeClass = f.getType();
                if (typeClass == Date.class) {
                    method.invoke(obj, DateFormatUtil.convertStrToDate(map.get(f.getName().toLowerCase()), "yyyy-MM-dd"));
                    continue;
                }
                Constructor<?> con = typeClass.getConstructor(String.class);
                Object value = con.newInstance(map.get(f.getName().toLowerCase()));
                method.invoke(obj, value);
            }
            if((clazz = clazz.getSuperclass()) != null) {
                try {
                    Field[] superFields = clazz.getDeclaredFields();//
                 // 写数据
                    for (Field f : superFields)
                    {
                        if (map.get(f.getName().toLowerCase()) == null) continue;
                        PropertyDescriptor pd = new PropertyDescriptor(f.getName(),clazz);
                        Method method = pd.getWriteMethod();// 获得写方法
                        Class<?> typeClass = f.getType();
                        if (typeClass == Date.class) {
                            method.invoke(obj, DateFormatUtil.convertStrToDate(map.get(f.getName().toLowerCase()), "yyyy-MM-dd"));
                            continue;
                        }
                        Constructor<?> con = typeClass.getConstructor(String.class);
                        Object value = con.newInstance(map.get(f.getName().toLowerCase()));
                        method.invoke(obj, value);
                    }
                } catch (Exception e) {
                    log.error(CommonUtil.getExceptionMessage(e));
                }
            }
            return obj;
        } catch (Exception e)
        {
            log.error(CommonUtil.getExceptionMessage(e));
            return null;
        }
    }

    public String getReport(String fields, String reportName, String date) throws Exception
    {
        try
        {
            AdWordsSession session = getSession();
            String awql = "SELECT " + fields + " FROM " + reportName + " DURING " + date + "," + date;
            ReportDownloadResponse response = new ReportDownloader(session).downloadReport(awql, DownloadFormat.CSV);
            String fileName = System.getProperty("user.home") + File.separatorChar + "report" + File.separatorChar + reportName + "_" + date + ".csv";
            response.saveToFile(fileName);

            log.info("download " + reportName + " with AWQL : " + awql);
            return fileName;

        } catch (Exception e)
        {
            log.info(reportName + " Report was not downloaded due to:" + CommonUtil.getExceptionMessage(e));
            throw e;
        }
    }

    public void getAndSave(String className, String fields, String reportName, String date) throws Exception
    {
        String fileName = getReport(fields, reportName, date);
        if (fileName == null) return;
        @SuppressWarnings("rawtypes")
        List list = this.saveReportObject(className, fileName, fields);
        if (list == null || list.size() == 0)
        {
            return;
        }
        String url = ADWORDS_URL;
        if ("CAMPAIGN_PERFORMANCE_REPORT".equals(reportName)) {
            url += "downloadAdwordsReportCampaign.shtml";
        } else if ("ADGROUP_PERFORMANCE_REPORT".equals(reportName)) {
            url += "downloadAdwordsReportAdGroup.shtml";
        } else if ("AD_PERFORMANCE_REPORT".equals(reportName)) {
            url += "downloadAdwordsReportAd.shtml";
        } else if ("AUTOMATIC_PLACEMENTS_PERFORMANCE_REPORT".equals(reportName)) {
            url += "downloadAdwordsReportAutomaticPlacements.shtml";
        } else if ("DESTINATION_URL_REPORT".equals(reportName)) {
            url += "downloadAdwordsReportDestinationUrl.shtml";
        } else if ("GEO_PERFORMANCE_REPORT".equals(reportName)) {
            url += "downloadAdwordsReportGeo.shtml";
        } else if ("KEYWORDS_PERFORMANCE_REPORT".equals(reportName)) {
            url += "downloadAdwordsReportKeywords.shtml";
        }
        Gson gson = new Gson();
        String para = gson.toJson(list);
        Map<String, String> map = new HashMap<String, String>();
        map.put("json", para);
        map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
        HttpClientUtil.post(url, map);
    }

    
    
    public void getCampaign(String date) {
        getCampaign(date, null, null);
    }

    public void getCampaign(String date, Long campaignId, Long ltAdCampaignId)
    {
        String reportName = "campaign";
        List<GoogleAdwordsCampaignWithBLOBs> list = new ArrayList<GoogleAdwordsCampaignWithBLOBs>();
        try
        {
            int offset = 0;
            CampaignServiceInterface campaignService = new AdWordsServices().get(getSession(), CampaignServiceInterface.class);
            StringBuffer awql = new StringBuffer();
            StringBuffer fields = new StringBuffer();
            fields.append("SELECT ");
            fields.append("Id,");
            fields.append("Name,");
            fields.append("Status,");
            fields.append("ServingStatus,");
            fields.append("StartDate,");
            fields.append("EndDate,");
            fields.append("BudgetId,");
//            fields.append("ConversionOptimizerEligibility,");
//            fields.append("AdServingOptimizationStatus,");
//            fields.append("FrequencyCap,");
            fields.append("Settings,");
            fields.append("AdvertisingChannelType,");
            fields.append("AdvertisingChannelSubType,");
//            fields.append("NetworkSetting,");
            fields.append("Labels,");
//            fields.append("BiddingStrategyConfiguration,");
//            fields.append("ForwardCompatibilityMap,");
            fields.append("TrackingUrlTemplate,");
            fields.append("UrlCustomParameters ");
            awql.append(fields.toString());
            awql.append(campaignId == null ? "" : " WHERE Id = " + campaignId);
            awql.append(date == null ? "" : " DURING " + date + "," + date);
            CampaignPage page = null;
            String fileName = null;
            do {
                String pageQuery = awql.append(String.format(" LIMIT %d, %d", offset, PAGE_SIZE)).toString();
                page = campaignService.query(pageQuery);
                if (page.getEntries() != null)
                {
                    fileName = System.getProperty("user.home") + File.separatorChar + "report" + File.separatorChar + reportName + "_" + date + ".csv";
                    File csv = new File(fileName); // CSV数据文件
                    BufferedWriter bw = new BufferedWriter(new FileWriter(csv, false)); // 附加
                    for (Campaign campaign : page.getEntries())
                    {
                        System.out.println("Campaign with name \"" + campaign.getName() + "\" and id \"" + campaign.getId() + "\" was found.");
                        // 添加新的数据行
                        bw.write(campaign.getId() + "," + campaign.getName() + "," + campaign.getStatus());
                        bw.newLine();

                        GoogleAdwordsCampaignWithBLOBs record = new GoogleAdwordsCampaignWithBLOBs();
                        BeanUtils.copyProperties(record, campaign);
                        record.setStatus(campaign.getStatus().getValue());
                        record.setServingStatus(campaign.getServingStatus().getValue());
                        record.setBudget(campaign.getBudget().getBudgetId());
                        record.setSettings(CommonUtil.object2Json(campaign.getSettings()));
                        
//                        if (ltAdCampaignId == null) {
//                            GoogleAdwordsCampaignWithBLOBs org = googleAdwordsCampaignMapper.selectByPrimaryKey(record.getId());
//                            if (org != null) {
//                                ltAdCampaignId = org.getLtAdCampaignId();
//                                record.setLtAdCampaignId(org.getLtAdCampaignId());
//                                record.setCreateAdminId(org.getCreateAdminId());
//                                record.setCreateTimeUtc(org.getCreateTimeUtc());
//                                record.setUpdateAdminId(org.getUpdateAdminId());
//                                record.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
//                            }
//                        } else {
//                            record.setLtAdCampaignId(ltAdCampaignId.longValue());
//                            record.setCreateAdminId(adminId);
//                            record.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
//                            record.setUpdateAdminId(adminId);
//                            record.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
//                        }
//                        if (!CampaignStatus.REMOVED.equals(campaign.getStatus().getValue())) {
//                            record.setLtAdCampaignId(getLtCampaignId(campaign.getName()));
//                        }
//                        googleAdwordsCampaignMapper.deleteByPrimaryKey(record.getId());
//                        googleAdwordsCampaignMapper.insert(record);
                        list.add(record);
                    }
                    bw.close();
                } else
                {
                    log.info(date + " : No campaigns were found.");
                }

              offset += PAGE_SIZE;
            } while (offset < page.getTotalNumEntries());
            log.info("download " + reportName + " with AWQL : " + awql);

            if (list.size() == 0) return;
            String para = new Gson().toJson(list);
            Map<String, String> map = new HashMap<String, String>();
            map.put("json", para);
            map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
            HttpClientUtil.post(ADWORDS_URL + "downloadAdwordsCampaign.shtml", map);
            
        } catch (Exception e)
        {
            log.info(reportName + " Report was not downloaded due to:" + CommonUtil.getExceptionMessage(e));
        }

    }
    
    public void getAdGroup(String date)
    {

        getAdGroup(date, null, null);
    }

    public void getAdGroup(String date, Long adGroupId, Integer ltAdGroupId)
    {
        String reportName = "adGroup";
        List<GoogleAdwordsAdGroupWithBLOBs> list = new ArrayList<GoogleAdwordsAdGroupWithBLOBs>();
        try
        {
            int offset = 0;
            AdGroupServiceInterface adGroupService = new AdWordsServices().get(getSession(), AdGroupServiceInterface.class);
            String awql = "SELECT Id,Name,CampaignId,CampaignName,Status ";
            awql += (adGroupId == null ? "" : " WHERE Id=" + adGroupId);
            awql += (date == null ? "" : " DURING " + date + "," + date);
            AdGroupPage page = null;
            String fileName = null;
            do {
                String pageQuery = awql + String.format(" LIMIT %d, %d", offset, PAGE_SIZE);
                page = adGroupService.query(pageQuery);
                if (page.getEntries() != null)
                {
                    fileName = System.getProperty("user.home") + File.separatorChar + "report" + File.separatorChar + reportName + "_" + date + ".csv";
                    File csv = new File(fileName); // CSV数据文件
                    BufferedWriter bw = new BufferedWriter(new FileWriter(csv, false)); // 附加
                    for (AdGroup adGroup : page.getEntries())
                    {
                        // 添加新的数据行
                        bw.write(adGroup.getId() + "," + adGroup.getName() + "," + adGroup.getCampaignId() + "," + adGroup.getCampaignName() + "," + adGroup.getStatus());
                        bw.newLine();

                        GoogleAdwordsAdGroupWithBLOBs record = new GoogleAdwordsAdGroupWithBLOBs();
                        record.setId(adGroup.getId());
                        record.setName(adGroup.getName());
                        record.setCampaignId(adGroup.getCampaignId());
                        record.setCampaignName(adGroup.getCampaignName());
                        record.setStatus(adGroup.getStatus().getValue());
//                        if (ltAdGroupId == null) {
//                            GoogleAdwordsAdGroupWithBLOBs org = googleAdwordsAdGroupMapper.selectByPrimaryKey(record.getId());
//                            if (org != null) {
//                                ltAdGroupId = org.getLtAdGroupId();
//                                record.setLtAdGroupId(org.getLtAdGroupId());
//                                record.setCreateAdminId(org.getCreateAdminId());
//                                record.setCreateTimeUtc(org.getCreateTimeUtc());
//                                record.setUpdateAdminId(org.getUpdateAdminId());
//                                record.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
//                            }
//                        } else {
//                            record.setLtAdGroupId(ltAdGroupId);
//                            record.setCreateAdminId(adminId);
//                            record.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
//                            record.setUpdateAdminId(adminId);
//                            record.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
//                        }
//                        if (!AdGroupStatus.REMOVED.equals(adGroup.getStatus().getValue())) {
//                            record.setLtAdGroupId(getLtGroupId(adGroup.getName()));
//                        }
//                        googleAdwordsAdGroupMapper.deleteByPrimaryKey(record.getId());
//                        googleAdwordsAdGroupMapper.insert(record);
                        list.add(record);
                    }
                    bw.close();
                } else
                {
                    log.info(date + " : No campaigns were found.");
                }

              offset += PAGE_SIZE;
            } while (offset < page.getTotalNumEntries());
            log.info("download " + reportName + " with AWQL : " + awql);

            if (list.size() == 0) return;
            String para = new Gson().toJson(list);
            Map<String, String> map = new HashMap<String, String>();
            map.put("json", para);
            map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
            HttpClientUtil.post(ADWORDS_URL + "downloadAdwordsAdGroup.shtml", map);
        } catch (Exception e)
        {
            log.info(reportName + " Report was not downloaded due to:" + CommonUtil.getExceptionMessage(e));
        }

    }
    
    /**
     * 按日期下载广告
     */
    public void getAd(String date)
    {
        getAd(date, null, null);
    }
    
    /**
     * 
     * 按日期下载广告
     * @param date 日期
     * @param adId 广告ID
     * @param ltAdId 业务广告ID
     */
    public void getAd(String date, Long adId, Integer ltAdAdvertiseVariationId)
    {
        String reportName = "adGroupAd";
        List<GoogleAdwordsAd> list = new ArrayList<GoogleAdwordsAd>();
        try
        {
            int offset = 0;
            AdGroupAdServiceInterface adGroupAdService = new AdWordsServices().get(getSession(), AdGroupAdServiceInterface.class);
            String awql = "SELECT Id, Name, AdGroupId, Status,Url,DisplayUrl,CreativeFinalUrls,CreativeFinalMobileUrls,CreativeFinalAppUrls"
                    + ",CreativeTrackingUrlTemplate,CreativeUrlCustomParameters,DevicePreference ";
            awql += (adId == null ? "" : " WHERE Id=" + adId);
            awql += (date == null ? "" : " DURING " + date + "," + date);
            AdGroupAdPage page = null;
            String fileName = null;
            do {
                String pageQuery = awql + String.format(" LIMIT %d, %d", offset, PAGE_SIZE);
                page = adGroupAdService.query(pageQuery);
                if (page.getEntries() != null)
                {
                    fileName = System.getProperty("user.home") + File.separatorChar + "report" + File.separatorChar + reportName + "_" + date + ".csv";
                    File csv = new File(fileName); // CSV数据文件
                    BufferedWriter bw = new BufferedWriter(new FileWriter(csv, false)); // 附加
                    for (AdGroupAd adGroupAd : page.getEntries()) {
                        if (!(adGroupAd.getAd() instanceof TemplateAd)) {
                            continue;
                        }
                        TemplateAd ad = (TemplateAd)adGroupAd.getAd();
                        //ad.getTemplateElements(0).getFields(0).get
//                        String var = " (" + ad.getDimensions().getWidth() + " x " + ad.getDimensions().getHeight() + ")";
                        bw.write(ad.getId() + "," + ad.getName() + ","
                                + adGroupAd.getAd().getAdType() + ","
                                + adGroupAd.getAd().getUrl() + ","
                                + adGroupAd.getAd().getDisplayUrl() + ","
                                + CommonUtil.object2Json(adGroupAd.getAd().getFinalUrls()) + ","
                                + adGroupAd.getAdGroupId() + ","
                                + adGroupAd.getStatus());
                        bw.newLine();
                        GoogleAdwordsAd record = new GoogleAdwordsAd();
                        record.setId(ad.getId());
                        record.setName(ad.getName());
                        record.setAdType(adGroupAd.getAd().getAdType());
                        record.setUrl(adGroupAd.getAd().getUrl());
                        record.setDisplayUrl(adGroupAd.getAd().getDisplayUrl());
                        record.setFinalUrls(CommonUtil.object2Json(adGroupAd.getAd().getFinalUrls()));
                        record.setAdgroupid(adGroupAd.getAdGroupId());
                        if (ad.getDimensions() != null)
                        {
                            record.setHeight(ad.getDimensions().getHeight());
                            record.setWidth(ad.getDimensions().getWidth());
                        }
                        record.setTemplateElements(CommonUtil.object2Json(ad.getTemplateElements()));
//                        if (ltAdAdvertiseVariationId == null)
//                        {
//                            GoogleAdwordsAd org = googleAdwordsAdMapper.selectByPrimaryKey(record.getId());
//                            if (org != null)
//                            {
//                                record.setLtAdAdvertiseVariationId(org.getLtAdAdvertiseVariationId());
//                            }
//                        } else
//                        {
//                            record.setLtAdAdvertiseVariationId(ltAdAdvertiseVariationId);
//                        }
//                        googleAdwordsAdMapper.deleteByPrimaryKey(record.getId());
//                        googleAdwordsAdMapper.insert(record);
                        list.add(record);
                    }
                    bw.close();
                } else
                {
                    log.info(date + " : No campaigns were found.");
                }

                offset += PAGE_SIZE;
            } while (offset < page.getTotalNumEntries());
            log.info("download " + reportName + " with AWQL : " + awql);

            if (list.size() == 0) return;
            String para = new Gson().toJson(list);
            Map<String, String> map = new HashMap<String, String>();
            map.put("json", para);
            map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
            HttpClientUtil.post(ADWORDS_URL + "downloadAdwordsAd.shtml", map);
        } catch (Exception e)
        {
            log.info(reportName + " Report was not downloaded due to:" + CommonUtil.getExceptionMessage(e));
        }

    }

    public void getBudget(String date)
    {
        getBudget(date, null);
    }
    
    public void getBudget(String date, Long budgetId)
    {
        String reportName = "budget";
        List<GoogleAdwordsBudget> list = new ArrayList<GoogleAdwordsBudget>();
        try
        {
            int offset = 0;
            BudgetServiceInterface service = new AdWordsServices().get(getSession(), BudgetServiceInterface.class);
            String awql = "SELECT BudgetId,BudgetName,Period,Amount,DeliveryMethod,BudgetReferenceCount,IsBudgetExplicitlyShared,BudgetStatus ";
            awql += (budgetId == null ? "" : " WHERE BudgetId=" + budgetId);
            awql += (date == null ? "" : " DURING " + date + "," + date);
            BudgetPage page = null;
            String fileName = null;
            do {
                String pageQuery = awql + String.format(" LIMIT %d, %d", offset, PAGE_SIZE);
                page = service.query(pageQuery);
                if (page.getEntries() != null)
                {
                    fileName = System.getProperty("user.home") + File.separatorChar + "report" + File.separatorChar + reportName + "_" + date + ".csv";
                    File csv = new File(fileName); // CSV数据文件
                    BufferedWriter bw = new BufferedWriter(new FileWriter(csv, false)); // 附加
                    GoogleAdwordsBudget entity = null;
                    for (Budget data : page.getEntries()) {
                        bw.write(data.getBudgetId()
                              + "," + data.getName()
                              + "," + data.getPeriod()
                              + "," + data.getAmount().getMicroAmount()
                              + "," + data.getDeliveryMethod()
                              + "," + data.getReferenceCount()
                              + "," + data.getIsExplicitlyShared()
                              + "," + data.getStatus()
                        );
                        bw.newLine();
                        entity = new GoogleAdwordsBudget();
                        entity.setBudgetId(data.getBudgetId());
                        entity.setName(data.getName());
                        entity.setPeriod(data.getPeriod().getValue());
                        entity.setAmount(data.getAmount().getMicroAmount());
                        entity.setDeliveryMethod(data.getDeliveryMethod().getValue());
                        entity.setReferenceCount(data.getReferenceCount());
                        entity.setIsExplicitlyShared(data.getIsExplicitlyShared());
                        entity.setStatus(data.getStatus().getValue());
//                        googleAdwordsBudgetMapper.deleteByPrimaryKey(entity.getBudgetId());
//                        googleAdwordsBudgetMapper.insert(entity);
                        list.add(entity);
                    }
                    bw.close();
                } else
                {
                    log.info(date + " : No " + reportName + " were found.");
                }

              offset += PAGE_SIZE;
            } while (offset < page.getTotalNumEntries());

            if (list.size() == 0) return;
            String para = new Gson().toJson(list);
            Map<String, String> map = new HashMap<String, String>();
            map.put("json", para);
            map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
            HttpClientUtil.post(ADWORDS_URL + "downloadAdwordsBudget.shtml", map);
        } catch (Exception e)
        {
            log.info(reportName + " Report was not downloaded due to:" + CommonUtil.getExceptionMessage(e));
        }

    }
    

    
//    public String downloadLocationCriterion(String fields, String reportName, String date)
//    {
//        try
//        {
//            LocationCriterionService service = new AdWordsServices().get(getSession(), LocationCriterionService.class);
//            String awql = "SELECT " + fields + " DURING " + date + "," + date;
//            LocationCriterion[] page = null;
//            String fileName = null;
//            log.info("download " + reportName + " with AWQL : " + awql);
//            return fileName;
//        } catch (Exception e)
//        {
//            log.info(reportName + " Report was not downloaded due to:" + CommonUtil.getExceptionMessage(e));
//        }
//        return null;
//
//    }
    
    /**
     * 取得campaignID，命名规则：$$$username####company_id###campaign_name(20位)###campaign_id$$$
     * @param name
     * @return
     */
    /*    @SuppressWarnings("unused")
    private Long getLtCampaignId(String name) {
        try {

            String format = "$$$username####company_id###campaign_name(20位)###campaign_id$$$";
            String[] campaigns = name.split("###");
            if (campaigns.length != 4) {
                MailUtil.sendHTMLMail(toMail, "campaign name 设置有误", "\t原始内容:" + name + "<br/>格式有误,必须是：" + format);
                return null;
            }
            
            Company para = new Company();
            para.setId(Integer.parseInt(campaigns[1]));
            Company company = companyMapper.selectByPrimaryKey(para);
            if (company == null) {
                MailUtil.sendHTMLMail(toMail, "company_id设置有误", "\t原始内容:" + name + "<br/>格式有误,company_id: " + campaigns[1] + "不存在");
                return null;
            }

            String campaignId = campaigns[3].substring(0, campaigns[3].length() - 3);
            AdCampaign campaign = adCampaignMapper.selectByPrimaryKey(Integer.parseInt(campaignId));
            if (campaign == null) {
                MailUtil.sendHTMLMail(toMail, "campaign_id设置有误", "\t原始内容:" + name + "<br/>格式有误,campaign_id:" + campaignId + "不存在");
                return null;
            }
            
            return Long.parseLong(campaignId);
        } catch(Exception e) {
            log.error(CommonUtil.getExceptionMessage(e));
            return null;
        }
    }*/
    
    /**
     * 取得groupID，命名规则:$$$username###company_id###campaign_name(20位)###campaign_id###group_name(20位)###group_id$$$
     * @param name
     * @return
     */
/*    @SuppressWarnings("unused")
    private Integer getLtGroupId(String name) {
        try {
            String format = "$$$username###company_id###campaign_name(20位)###campaign_id###group_name(20位)###group_id$$$";
            String[] groups = name.split("###");
            if (groups.length != 6) {
                // send mail
                MailUtil.sendHTMLMail(toMail, "group name 设置有误", "\t原始内容:" + name + "<br/>格式有误,必须是：" + format);
                return null;
            }
    
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
            
            String groupId = groups[5].substring(0, groups[5].length() - 3);
            com.lt.dao.model.AdGroup group = adGroupMapper.selectByPrimaryKey(Integer.parseInt(groupId));
            if (group == null) {
                MailUtil.sendHTMLMail(toMail, "group_id设置有误", "\t原始内容:" + name + "<br/>格式有误,group_id:" + groupId + "不存在");
                return null;
            }
            
            return Integer.parseInt(groupId);
        } catch(Exception e) {
            log.error(CommonUtil.getExceptionMessage(e));
            return null;
        }
    }*/
    
    private static AdWordsSession session;
    private AdWordsSession getSession() throws Exception {
        if (session != null) return session;
        
        return AdwordsUtil.getSession();
    }
    
    public static void main(String[] args)
    {
        
        new ReportServiceImpl().getAd("20140523");
        
    }
    
}
