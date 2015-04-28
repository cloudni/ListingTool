//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

package com.lt.thirdpartylibrary.googleadwords.service.impl;

import java.beans.PropertyDescriptor;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.lang.reflect.Constructor;
import java.lang.reflect.Field;
import java.lang.reflect.Method;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

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
import com.google.api.ads.adwords.axis.v201502.cm.Campaign;
import com.google.api.ads.adwords.axis.v201502.cm.CampaignPage;
import com.google.api.ads.adwords.axis.v201502.cm.CampaignServiceInterface;
import com.google.api.ads.adwords.axis.v201502.cm.TemplateAd;
import com.google.api.ads.adwords.lib.client.AdWordsSession;
import com.google.api.ads.adwords.lib.jaxb.v201502.DownloadFormat;
import com.google.api.ads.adwords.lib.utils.ReportDownloadResponse;
import com.google.api.ads.adwords.lib.utils.v201502.ReportDownloader;
import com.google.api.ads.common.lib.auth.OfflineCredentials;
import com.google.api.ads.common.lib.auth.OfflineCredentials.Api;
import com.google.api.client.auth.oauth2.Credential;
import com.lt.dao.mapper.GoogleAdwordsAdGroupMapper;
import com.lt.dao.mapper.GoogleAdwordsAdMapper;
import com.lt.dao.mapper.GoogleAdwordsCampaignMapper;
import com.lt.dao.mapper.GoogleAdwordsReportAdGroupMapper;
import com.lt.dao.mapper.GoogleAdwordsReportAdMapper;
import com.lt.dao.mapper.GoogleAdwordsReportAutomaticPlacementsMapper;
import com.lt.dao.mapper.GoogleAdwordsReportCampaignMapper;
import com.lt.dao.mapper.GoogleAdwordsReportDestinationUrlMapper;
import com.lt.dao.mapper.GoogleAdwordsReportGeoMapper;
import com.lt.dao.model.GoogleAdwordsAd;
import com.lt.dao.model.GoogleAdwordsAdGroupWithBLOBs;
import com.lt.dao.model.GoogleAdwordsCampaignWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAdGroupWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAdWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAutomaticPlacements;
import com.lt.dao.model.GoogleAdwordsReportCampaignWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportDestinationUrl;
import com.lt.dao.model.GoogleAdwordsReportGeo;
import com.lt.platform.util.CSVAnalysis;
import com.lt.platform.util.time.DateFormatUtil;
import com.lt.thirdpartylibrary.googleadwords.service.IReportService;
import com.lt.thirdpartylibrary.paypal.service.ITransactionAccessTokenService;

/**
 * 
 * @author Tik
 */
public class ReportServiceImpl implements IReportService
{

    private Logger log = Logger.getLogger(ReportServiceImpl.class);
    
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
    private GoogleAdwordsAdMapper googleAdwordsAdMapper;
    @Autowired
    private GoogleAdwordsAdGroupMapper googleAdwordsAdGroupMapper;
    @Autowired
    private GoogleAdwordsCampaignMapper googleAdwordsCampaignMapper;
    @Autowired
    private ITransactionAccessTokenService transactionAuthorizeService;

    private static int PAGE_SIZE = 10000;
    
    public void downloadAdwordsReport() 
    {
        Calendar cal = Calendar.getInstance();
        cal.add(Calendar.DATE, -1);
        String sysDate = DateFormatUtil.convertDateToStr(cal.getTime(), "yyyyMMdd");
        sysDate = "20150406";
        String fileName;
        String queryCampaign = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,CampaignStatus,ServingStatus,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType ";
        fileName = this.download(queryCampaign, "CAMPAIGN_PERFORMANCE_REPORT", sysDate);
        if (fileName == null) return;
        this.saveDB("com.lt.dao.model.GoogleAdwordsReportCampaignWithBLOBs", fileName, queryCampaign);

        String queryGroup = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,AdGroupId,AdGroupName,CampaignId,CampaignName,AdGroupStatus,"
                + "CpcBid,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType ";
        fileName = this.download(queryGroup, "ADGROUP_PERFORMANCE_REPORT", sysDate);
        if (fileName == null) return;
        this.saveDB("com.lt.dao.model.GoogleAdwordsReportAdGroupWithBLOBs", fileName, queryGroup);
        
        String queryAd = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,Id,Headline,CampaignId,CampaignName,AdGroupId,AdGroupName,"
                + "CreativeApprovalStatus,KeywordId,Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device,ClickType ";
        fileName = this.download(queryAd, "AD_PERFORMANCE_REPORT", sysDate);
        if (fileName == null) return;
//        this.saveDB("com.lt.dao.model.GoogleAdwordsReportAdWithBLOBs", fileName, queryAd);

        String queryPlacement = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,Domain,AdGroupId,AdGroupName,"
                + "CriteriaParameters,Cost,Impressions,Clicks,AverageCpc ";
        fileName = this.download(queryPlacement, "AUTOMATIC_PLACEMENTS_PERFORMANCE_REPORT", sysDate);
        if (fileName == null) return;
        this.saveDB("com.lt.dao.model.GoogleAdwordsReportAutomaticPlacements", fileName, queryPlacement);

        String queryDestination = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,AdGroupId,AdGroupName,EffectiveDestinationUrl,"
                + "CriteriaParameters,Cost,Impressions,Clicks,AverageCpc,AveragePosition,ClickType,Device ";
        fileName = this.download(queryDestination, "DESTINATION_URL_REPORT", sysDate);
        if (fileName == null) return;
        this.saveDB("com.lt.dao.model.GoogleAdwordsReportDestinationUrl", fileName, queryDestination);
        
        String queryGeo = "Date,DayOfWeek,Month,MonthOfYear,Week,Year,CampaignId,CampaignName,AdGroupId,AdGroupName,CountryCriteriaId,RegionCriteriaId,MetroCriteriaId,CityCriteriaId,MostSpecificCriteriaId,LocationType,"
                + "Cost,Impressions,Clicks,AverageCpc,AveragePosition,Device ";
        fileName = this.download(queryGeo, "GEO_PERFORMANCE_REPORT", sysDate);
        if (fileName == null) return;
        this.saveDB("com.lt.dao.model.GoogleAdwordsReportGeo", fileName, queryGeo);
        
        String fields = " Id, Name, AdGroupId, Status ";
        fileName = this.downloadAd(fields, "adGroupAd", sysDate);
        
        fields = " Id,Name,CampaignId,CampaignName,Status ";
        fileName = this.downloadAdGroup(fields, "adGroup", sysDate);
//        if (fileName == null) return;
//        this.saveBaseObject2DB("com.lt.dao.model.GoogleAdwordsAdGroupWithBLOBs", fileName, fields);
        
        fields = " Id, Name, Status ";
        fileName = this.downloadCampaign(fields, "campaign", sysDate);
//        if (fileName == null) return;
//        this.saveBaseObject2DB("com.lt.dao.model.GoogleAdwordsCampaignWithBLOBs", fileName, fields);
        
    }
    
    public void saveDB(String className, String fileName, String selectFields) {

        List<String[]> datas = CSVAnalysis.readCsv(fileName);
        if (datas == null || datas.size() <= 3) return;
        for (int i = 2; i < datas.size() - 1; i++) {
            String[] row = datas.get(i);
            String[] fields = selectFields.split(",");
            Map<String, String> map = new HashMap<String, String>();
            for (int col = 0; col < fields.length; col++) {
                if ("Ctr".equals(fields[col]) || "ctr_significance".equals(fields[col])) {
                    row[col] = row[col].replaceAll("%", "");
                }
                map.put(fields[col].toLowerCase(), "".equals(row[col]) ? null : row[col]);
            }
            
            Object obj = setReflectFields(className, map);
            if (obj instanceof GoogleAdwordsReportAdWithBLOBs) {
                GoogleAdwordsReportAdWithBLOBs record = (GoogleAdwordsReportAdWithBLOBs)obj;
//                Integer cnt = googleAdwordsReportAdMapper.checkExist(record);
//                if (cnt > 0) {
//                    googleAdwordsReportAdMapper.updateByPrimaryKey(record);
//                } else {
//                    googleAdwordsReportAdMapper.insert(record);
//                }
                googleAdwordsReportAdMapper.deleteByDate(record.getDate());
                googleAdwordsReportAdMapper.insert(record);
            } else if (obj instanceof GoogleAdwordsReportAdGroupWithBLOBs) {
                GoogleAdwordsReportAdGroupWithBLOBs record = (GoogleAdwordsReportAdGroupWithBLOBs)obj;
//                Integer cnt = googleAdwordsReportAdGroupMapper.checkExist(record);
//                if (cnt > 0) {
//                    googleAdwordsReportAdGroupMapper.updateByPrimaryKey(record);
//                } else {
//                    googleAdwordsReportAdGroupMapper.insert(record);
//                }
                googleAdwordsReportAdGroupMapper.deleteByDate(record.getDate());
                googleAdwordsReportAdGroupMapper.insert(record);
            } else if (obj instanceof GoogleAdwordsReportCampaignWithBLOBs) {
                GoogleAdwordsReportCampaignWithBLOBs record = (GoogleAdwordsReportCampaignWithBLOBs)obj;
//                Integer cnt = googleAdwordsReportCampaignMapper.checkExist(record);
//                if (cnt == null) {
//                    googleAdwordsReportCampaignMapper.insert(record); 
//                } else {
//                    googleAdwordsReportCampaignMapper.updateByPrimaryKey(record);
//                }
                googleAdwordsReportCampaignMapper.deleteByDate(record.getDate());
                googleAdwordsReportCampaignMapper.insert(record);
            } else if (obj instanceof GoogleAdwordsReportAutomaticPlacements) {
                GoogleAdwordsReportAutomaticPlacements record = (GoogleAdwordsReportAutomaticPlacements)obj;
                googleAdwordsReportAutomaticPlacementsMapper.deleteByDate(record.getDate());
                googleAdwordsReportAutomaticPlacementsMapper.insert(record);
            } else if (obj instanceof GoogleAdwordsReportDestinationUrl) {
                GoogleAdwordsReportDestinationUrl record = (GoogleAdwordsReportDestinationUrl)obj;
                googleAdwordsReportDestinationUrlMapper.deleteByDate(record.getDate());
                googleAdwordsReportDestinationUrlMapper.insert(record);
            } else if (obj instanceof GoogleAdwordsReportGeo) {
                GoogleAdwordsReportGeo record = (GoogleAdwordsReportGeo)obj;
                googleAdwordsReportGeoMapper.deleteByDate(record.getDate());
                googleAdwordsReportGeoMapper.insert(record);
            }
        }
    }
    

    
    public void saveBaseObject2DB(String className, String fileName, String selectFields) {

        List<String[]> datas = CSVAnalysis.readCsv(fileName);
        if (datas == null || datas.size() == 0) return;
        for (int i = 0; i < datas.size(); i++) {
            String[] row = datas.get(i);
            String[] fields = selectFields.split(",");
            Map<String, String> map = new HashMap<String, String>();
            for (int col = 0; col < fields.length; col++) {
                if ("Ctr".equals(fields[col]) || "ctr_significance".equals(fields[col])) {
                    row[col] = row[col].replaceAll("%", "");
                }
                map.put(fields[col].toLowerCase(), "".equals(row[col]) ? null : row[col]);
            }
            
            Object obj = setReflectFields(className, map);
            if (obj instanceof GoogleAdwordsAd) {
                GoogleAdwordsAd record = (GoogleAdwordsAd)obj;
                googleAdwordsAdMapper.deleteByPrimaryKey(record.getId());
                googleAdwordsAdMapper.insert(record);
            } else if (obj instanceof GoogleAdwordsAdGroupWithBLOBs) {
                GoogleAdwordsAdGroupWithBLOBs record = (GoogleAdwordsAdGroupWithBLOBs)obj;
                googleAdwordsAdGroupMapper.deleteByPrimaryKey(record.getId());
                googleAdwordsAdGroupMapper.insert(record);
            } else if (obj instanceof GoogleAdwordsCampaignWithBLOBs) {
                GoogleAdwordsCampaignWithBLOBs record = (GoogleAdwordsCampaignWithBLOBs)obj;
                googleAdwordsCampaignMapper.deleteByPrimaryKey(record.getId());
                googleAdwordsCampaignMapper.insert(record);
            }
        }
    }
    
    public Object setReflectFields(String className, Map<String, String> map)
    {
        try
        {
            Class<?> clazz = Class.forName(className);// 这里的类名是全名。。有包的话要加上包名
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
                method.invoke(obj, value);// 因为知道是int类型的属性，所以传个int过去就是了。实际情况中需要判断下他的参数类型
            }
            if((clazz = clazz.getSuperclass()) != null) {
                try {
                    Field[] superFields = clazz.getDeclaredFields();//原写法，无论如何，都return回去了。
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
                    log.error(e.getMessage());
                    e.printStackTrace();
                }
            }
            return obj;
        } catch (Exception e)
        {
            log.info(e);
            e.printStackTrace();
            return null;
        }
    }

    public String download(String fields, String reportName, String date)
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
            log.info(reportName + " Report was not downloaded due to:", e);
        }
        return null;
    }
    


    public String downloadCampaign(String fields, String reportName, String date)
    {
        try
        {
            int offset = 0;
            CampaignServiceInterface campaignService = new AdWordsServices().get(getSession(), CampaignServiceInterface.class);
            String awql = "SELECT " + fields + " DURING " + date + "," + date;
            CampaignPage page = null;
            String fileName = null;
            do {
                String pageQuery = awql + String.format(" LIMIT %d, %d", offset, PAGE_SIZE);
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
                        record.setId(campaign.getId());
                        record.setName(campaign.getName());
                        record.setStatus(campaign.getStatus().getValue());
                        googleAdwordsCampaignMapper.deleteByPrimaryKey(record.getId());
                        googleAdwordsCampaignMapper.insert(record);
                    }
                    bw.close();
                } else
                {
                    log.info(date + " : No campaigns were found.");
                }

              offset += PAGE_SIZE;
            } while (offset < page.getTotalNumEntries());
            log.info("download " + reportName + " with AWQL : " + awql);
            return fileName;
        } catch (Exception e)
        {
            log.info(reportName + " Report was not downloaded due to:", e);
        }
        return null;

    }
    public String downloadAdGroup(String fields, String reportName, String date)
    {
        try
        {
            int offset = 0;
            AdGroupServiceInterface adGroupService = new AdWordsServices().get(getSession(), AdGroupServiceInterface.class);
            String awql = "SELECT " + fields + " DURING " + date + "," + date;
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
                        googleAdwordsAdGroupMapper.deleteByPrimaryKey(record.getId());
                        googleAdwordsAdGroupMapper.insert(record);
                    }
                    bw.close();
                } else
                {
                    log.info(date + " : No campaigns were found.");
                }

              offset += PAGE_SIZE;
            } while (offset < page.getTotalNumEntries());
            log.info("download " + reportName + " with AWQL : " + awql);
            return fileName;
        } catch (Exception e)
        {
            log.info(reportName + " Report was not downloaded due to:", e);
        }
        return null;

    }
    
    public String downloadAd(String fields, String reportName, String date)
    {
        try
        {
            int offset = 0;
            AdGroupAdServiceInterface adGroupAdService = new AdWordsServices().get(getSession(), AdGroupAdServiceInterface.class);
            String awql = "SELECT " + fields + " DURING " + date + "," + date;
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
                        System.out.println("Ad with id  \"" + adGroupAd.getAd().getId() + "\"" + " and type \""
                            + adGroupAd.getAd().getAdType() + "\" was found.");
                        TemplateAd ad = (TemplateAd)adGroupAd.getAd();
                          bw.write(ad.getId() + "," + ad.getName()
                                   + "," + adGroupAd.getAd().getAdType()
                                   + "," + adGroupAd.getAd().getUrl()
                                   + "," + adGroupAd.getAd().getDisplayUrl()       
                                   + "," + adGroupAd.getAdGroupId() + "," + adGroupAd.getStatus());
                          bw.newLine();
                          GoogleAdwordsAd record = new GoogleAdwordsAd();
                          record.setId(ad.getId());
                          record.setName(ad.getName());
                          record.setAdType(adGroupAd.getAd().getAdType());
                          record.setUrl(adGroupAd.getAd().getUrl());
                          record.setDisplayUrl(adGroupAd.getAd().getDisplayUrl());
                          record.setAdgroupid(adGroupAd.getAdGroupId());
                          googleAdwordsAdMapper.deleteByPrimaryKey(record.getId());
                          googleAdwordsAdMapper.insert(record);
                      }
                    bw.close();
                } else
                {
                    log.info(date + " : No campaigns were found.");
                }

              offset += PAGE_SIZE;
            } while (offset < page.getTotalNumEntries());
            log.info("download " + reportName + " with AWQL : " + awql);
            return fileName;
        } catch (Exception e)
        {
            log.info(reportName + " Report was not downloaded due to:", e);
        }
        return null;

    }
    
    private static AdWordsSession session;
    private AdWordsSession getSession() throws Exception {
        if (session != null) return session;
        
     // Generate a refreshable OAuth2 credential similar to a ClientLogin
        // token and can be used in place of a service account.
        Credential oAuth2Credential = new OfflineCredentials.Builder().forApi(Api.ADWORDS).fromFile().build().generateCredential();

        // Construct an AdWordsSession.
        session = new AdWordsSession.Builder().fromFile().withOAuth2Credential(oAuth2Credential).build();
        return session;
    }
    
    public static void main(String[] args)
    {
        
        new ReportServiceImpl().downloadAdwordsReport();
        Date d = new Date("20150420");
        d = new Date("2015-04-20");
        
    }
    
}
