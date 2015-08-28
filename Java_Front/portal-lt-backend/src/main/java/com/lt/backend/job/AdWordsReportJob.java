package com.lt.backend.job;

import java.beans.PropertyDescriptor;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.lang.reflect.Constructor;
import java.lang.reflect.Field;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.commons.beanutils.BeanUtils;
import org.apache.log4j.Logger;
import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.springframework.scheduling.quartz.QuartzJobBean;
import org.springframework.transaction.CannotCreateTransactionException;

import com.google.api.ads.adwords.axis.factory.AdWordsServices;
import com.google.api.ads.adwords.axis.v201502.cm.MediaSize;
import com.google.api.ads.adwords.axis.v201502.cm.Media_Size_DimensionsMapEntry;
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
import com.google.api.ads.adwords.axis.v201502.cm.ImageAd;
import com.google.api.ads.adwords.axis.v201502.cm.TemplateAd;
import com.google.api.ads.adwords.lib.client.AdWordsSession;
import com.google.api.ads.adwords.lib.client.reporting.ReportingConfiguration;
import com.google.api.ads.adwords.lib.jaxb.v201502.DateRange;
import com.google.api.ads.adwords.lib.jaxb.v201502.DownloadFormat;
import com.google.api.ads.adwords.lib.jaxb.v201502.ReportDefinition;
import com.google.api.ads.adwords.lib.jaxb.v201502.ReportDefinitionDateRangeType;
import com.google.api.ads.adwords.lib.jaxb.v201502.ReportDefinitionReportType;
import com.google.api.ads.adwords.lib.jaxb.v201502.Selector;
import com.google.api.ads.adwords.lib.utils.ReportDownloadResponse;
import com.google.api.ads.adwords.lib.utils.ReportDownloadResponseException;
import com.google.api.ads.adwords.lib.utils.v201502.ReportDownloader;
import com.google.common.collect.Lists;
import com.google.gson.Gson;
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
import com.lt.platform.util.CSVAnalysis;
import com.lt.platform.util.CommonUtil;
import com.lt.platform.util.MailUtil;
import com.lt.platform.util.config.PropertiesUtil;
import com.lt.platform.util.http.HttpClientUtil;
import com.lt.platform.util.security.MD5Util;
import com.lt.platform.util.time.DateFormatUtil;
import com.lt.thirdpartylibrary.googleadwords.util.AdwordsUtil;

/**
 * AdWords定时任务
 * 
 * 
 */
public class AdWordsReportJob extends QuartzJobBean {
    
    private Logger log = Logger.getLogger(AdWordsReportJob.class);
//  "http://192.168.0.48/portal-lt-backend/common/adwords/";
    private static final String ADWORDS_URL = "http://transaction.itemtool.com/portal-lt-backend/common/adwords/";
    
    @Override
    protected void executeInternal(JobExecutionContext context) throws JobExecutionException {

        Calendar cal = Calendar.getInstance();
        cal.add(Calendar.DATE, -1);
        String date = DateFormatUtil.convertDateToStr(cal.getTime(), "yyyyMMdd");
        cal.add(Calendar.DATE, -1);
        String b4Date = DateFormatUtil.convertDateToStr(cal.getTime(), "yyyyMMdd");
        while (true) {
            
            log.info("报表下载开始：" + date);
            // 下载报表
            try {
                getAdwordsReport(b4Date);
                getAdwordsReport(date);
                break;
            } catch (Exception e) {
                if (e instanceof CannotCreateTransactionException) {
                    log.info("CannotCreateTransactionException");
                    break;
                }
                MailUtil.sendHTMLMail(PropertiesUtil.getContextProperty("mail.error.to").toString(), "报表下载异常", "Exception:\n" + CommonUtil.getExceptionMessage(e));
                log.error("报表下载异常，休眠10分钟后重试！");
                try
                {
                    Thread.sleep(10 * 60 * 1000);
                } catch (InterruptedException e1)
                {
                }
            }
        }
        log.info("报表下载结束：" + date);
        MailUtil.sendHTMLMail(PropertiesUtil.getContextProperty("mail.error.to").toString(), "报表下载成功", "报表下载成功:" + date);

        Map<String, String> map = new HashMap<String, String>();
        map.put("date", b4Date);
        map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
        HttpClientUtil.post(ADWORDS_URL + "updateCampaignCostByInstant.shtml", map);
        
        map.put("date", date);
        HttpClientUtil.post(ADWORDS_URL + "updateCampaignCostByInstant.shtml", map);

    }
    
    public static void main(String[] args) throws Exception
    {
        AdWordsReportJob job = new AdWordsReportJob();

        Calendar cal = Calendar.getInstance();
        cal.add(Calendar.DATE, -1);
        String date = DateFormatUtil.convertDateToStr(cal.getTime(), "yyyyMMdd");
        //job.getAdwordsReport("20150621");
        
        for (int i = 20150827; i <= 20150827; i++)
        {
            job.getAdwordsReport(i + "");
            Map<String, String> map = new HashMap<String, String>();
            map.put("date", i + "");
            map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
            HttpClientUtil.post(ADWORDS_URL + "updateCampaignCostByInstant.shtml", map);
        }
    }
    

    private static int PAGE_SIZE = 10000;
//  "http://192.168.0.48/portal-lt-backend/common/adwords/";
//    private static Integer adminId = 1;
    
    public void getAdwordsReport(String sysDate) throws Exception 
    {
        
        String queryCampaign = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,CampaignStatus,ServingStatus,BudgetId,Ctr,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportCampaignWithBLOBs", queryCampaign, "CAMPAIGN_PERFORMANCE_REPORT", sysDate);

        String queryGroup = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,AdGroupId,AdGroupName,CampaignId,CampaignName,AdGroupStatus,Ctr,"
                + "CpcBid,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportAdGroupWithBLOBs", queryGroup, "ADGROUP_PERFORMANCE_REPORT", sysDate);
        
        String queryAd = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,Id,Headline,CampaignId,CampaignName,AdGroupId,AdGroupName,Ctr,"
                + "CreativeApprovalStatus,KeywordId,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType ";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportAdWithBLOBs", queryAd, "AD_PERFORMANCE_REPORT", sysDate);

        String queryUrl = "AccountCurrencyCode,AccountDescriptiveName,AccountTimeZoneId,ActiveViewCpm,ActiveViewImpressions,AdFormat,"
                + "AdGroupCriterionStatus,AdGroupId,AdGroupName,AdGroupStatus,AdNetworkType1,AdNetworkType2,AverageCpc,AverageCpm,"
                + "CampaignId,CampaignName,CampaignStatus,ClickConversionRate,Clicks,Cost,CostPerConversionManyPerClick,CostPerConvertedClick,"
                + "CriteriaParameters,Ctr,CustomerDescriptiveName,Date,DayOfWeek,"
                + "DisplayName,Domain,ExternalCustomerId,Impressions,IsAutoOptimized,IsBidOnPath,IsPathExcluded,Month,MonthOfYear,"
                + "PrimaryCompanyName,Quarter,Url,ValuePerConversionManyPerClick,ValuePerConvertedClick,ViewThroughConversions,Week,Year";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportUrl", queryUrl, "URL_PERFORMANCE_REPORT", sysDate);

        String queryPlacement = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,DisplayName,Domain,AdGroupId,AdGroupName,Ctr,"
                + "CriteriaParameters,Cost,Impressions,Clicks,AverageCpc";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportAutomaticPlacements", queryPlacement, "AUTOMATIC_PLACEMENTS_PERFORMANCE_REPORT", sysDate);

        String queryDestination = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,AdGroupId,AdGroupName,EffectiveDestinationUrl,Ctr,"
                + "CriteriaParameters,Cost,Impressions,Clicks,AverageCpc,AveragePosition,ClickType,Device";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportDestinationUrl", queryDestination, "DESTINATION_URL_REPORT", sysDate);
        
        String queryGeo = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,AdGroupId,AdGroupName,CountryCriteriaId,RegionCriteriaId,MetroCriteriaId,CityCriteriaId,MostSpecificCriteriaId,LocationType,Ctr,"
                + "Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportGeo", queryGeo, "GEO_PERFORMANCE_REPORT", sysDate);
        
        String queryKeywords = "AdGroupId,AdGroupName,AdGroupStatus,AverageCpc,AverageCpm,CampaignId,CampaignName,CampaignStatus,Clicks,ConversionValue,Cost,CpcBid,Ctr,CustomerDescriptiveName,Date,DayOfWeek,Device,Id,Impressions,KeywordText,Month,MonthOfYear,Status,Week,Year";
        this.getAndSave("com.lt.dao.model.GoogleAdwordsReportKeywordsWithBLOBs", queryKeywords, "KEYWORDS_PERFORMANCE_REPORT", sysDate);

        this.getAd(sysDate);
        
        this.getAdGroup(sysDate);
        
        this.getCampaign(sysDate);
        
        this.getBudget(sysDate);
    }

    public void getAndSave(String className, String fields, String reportName, String date) throws Exception
    {
        String fileName = getReport(fields, reportName, date);
        if (fileName == null) return;
        @SuppressWarnings("rawtypes")
        List list = this.getReportObject(className, fileName, fields);
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
        } else if ("URL_PERFORMANCE_REPORT".equals(reportName)) {
            url += "downloadAdwordsReportUrl.shtml";
        }
        Gson gson = new Gson();
        String para = gson.toJson(list);
        Map<String, String> map = new HashMap<String, String>();
        map.put("json", para);
        map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
        HttpClientUtil.post(url, map);
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
    public List getReportObject(String className, String fileName, String selectFields) {

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
                    if ("Ctr".equals(fields[col]) || "ctr_significance".equals(fields[col]) || "ClickConversionRate".equals(fields[col])) {
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
//                  if (i == 2) googleAdwordsReportKeywordsMapper.deleteByDate(record.getDate());
//                  googleAdwordsReportKeywordsMapper.insert(record);
                  list.add(record);
                } else if (obj instanceof GoogleAdwordsReportUrl) {
                    GoogleAdwordsReportUrl record = (GoogleAdwordsReportUrl)obj;
//                  if (i == 2) googleAdwordsReportKeywordsMapper.deleteByDate(record.getDate());
//                  googleAdwordsReportKeywordsMapper.insert(record);
                  list.add(record);
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
                try {
                    
                    Constructor<?> con = typeClass.getConstructor(String.class);
                    Object value = con.newInstance(map.get(f.getName().toLowerCase()));
                    method.invoke(obj, value);
                } catch (Exception e) {
                    log.error(String.format("Name:s% Value:%s", f.getName().toLowerCase(), map.get(f.getName().toLowerCase())));
                    throw e;
                }
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
            if ("KEYWORDS_PERFORMANCE_REPORT".equals(reportName)) {
                return getKeywords(reportName, date);
            }
            String awql = "SELECT " + fields + " FROM " + reportName + " DURING " + date + "," + date;
            if ("URL_PERFORMANCE_REPORT".equals(reportName)) {
                awql = "SELECT " + fields + " FROM " + reportName + " WHERE CriteriaParameters='Content' DURING " + date + "," + date;
            }
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
    
    public String getKeywords(String reportName,String date) throws Exception {
        Selector selector = new Selector();
        selector.getFields().addAll(Lists.newArrayList(
                "AdGroupId",
                "AdGroupName",
                "AdGroupStatus",
                "AverageCpc",
                "AverageCpm",
                "CampaignId",
                "CampaignName",
                "CampaignStatus",
                "Clicks",
                "ConversionValue",
                "Cost",
                "CpcBid",
                "Ctr",
                "CustomerDescriptiveName",
                "Date",
                "DayOfWeek",
                "Device",
                "Id",
                "Impressions",
                "KeywordText",
                "Month",
                "MonthOfYear",
                "Status",
                "Week",
                "Year"));

        // Create report definition.
        ReportDefinition reportDefinition = new ReportDefinition();
        reportDefinition.setReportName("Kerwords performance report #" + System.currentTimeMillis());
        reportDefinition.setDateRangeType(ReportDefinitionDateRangeType.CUSTOM_DATE);
        reportDefinition.setReportType(ReportDefinitionReportType.DISPLAY_KEYWORD_PERFORMANCE_REPORT);
        reportDefinition.setDownloadFormat(DownloadFormat.CSV);
        // Enable to allow rows with zero impressions to show.
        reportDefinition.setIncludeZeroImpressions(true);
        
        // Optional: Set the reporting configuration of the session to suppress header or
        // summary rows in the report output. You can also configure this via your ads.properties
        // configuration file. See AdWordsSession.Builder.from(Configuration) for details.
        ReportingConfiguration reportingConfiguration = new ReportingConfiguration.Builder()
            .skipReportHeader(false)
            .skipReportSummary(false)
            .build();
        AdWordsSession session = getSession();
        session.setReportingConfiguration(reportingConfiguration);

        DateRange dr = new DateRange();
        dr.setMin(date);
        dr.setMax(date);
        selector.setDateRange(dr);
        reportDefinition.setSelector(selector);

        try {
          // Set the property api.adwords.reportDownloadTimeout or call
          // ReportDownloader.setReportDownloadTimeout to set a timeout (in milliseconds)
          // for CONNECT and READ in report downloads.
          ReportDownloadResponse response =
              new ReportDownloader(session).downloadReport(reportDefinition);
          String fileName = System.getProperty("user.home") + File.separatorChar + "report" + File.separatorChar + reportName + "_" + date + ".csv";
          response.saveToFile(fileName);
          
          System.out.printf("Report successfully downloaded to: %s%n", fileName);
          return fileName;
        } catch (ReportDownloadResponseException e) {
          System.out.printf("Report was not downloaded due to: %s%n", e);
          return null;
        }
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
                        if ((adGroupAd.getAd() instanceof ImageAd)) {

                            ImageAd ad = (ImageAd)adGroupAd.getAd();
                            GoogleAdwordsAd record = new GoogleAdwordsAd();
                            record.setId(ad.getId());
                            record.setName(ad.getName());
                            record.setAdType(adGroupAd.getAd().getAdType());
                            record.setUrl(adGroupAd.getAd().getUrl());
                            record.setDisplayUrl(adGroupAd.getAd().getDisplayUrl());
                            record.setFinalUrls(CommonUtil.object2Json(adGroupAd.getAd().getFinalUrls()));
                            record.setAdgroupid(adGroupAd.getAdGroupId());
                            if (ad.getImage() != null)
                            {
                                for (Media_Size_DimensionsMapEntry msd : ad.getImage().getDimensions()) {
                                    if (msd.getKey().getValue() == MediaSize._FULL) {
                                        record.setHeight(msd.getValue().getHeight());
                                        record.setWidth(msd.getValue().getWidth());
                                    }
                                }
                            }
                            list.add(record);
                            continue;
                        }
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
    
    private static AdWordsSession session;
    private AdWordsSession getSession() throws Exception {
        if (session != null) return session;
        
        return AdwordsUtil.getSession();
    }
}