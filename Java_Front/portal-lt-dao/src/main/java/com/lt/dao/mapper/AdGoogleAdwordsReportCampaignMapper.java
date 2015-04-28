package com.lt.dao.mapper;

import java.util.Date;
import java.util.List;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.AdGoogleAdwordsReportCampaign;
import com.lt.dao.model.AdGoogleAdwordsReportCampaignWithBLOBs;
import com.lt.dao.po.AdGoogleAdwordsReportCampaignPO;
@Repository
public interface AdGoogleAdwordsReportCampaignMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_google_adwords_report_campaign
     *
     * @mbggenerated Mon Apr 27 11:55:29 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_google_adwords_report_campaign
     *
     * @mbggenerated Mon Apr 27 11:55:29 CST 2015
     */
    int insert(AdGoogleAdwordsReportCampaignWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_google_adwords_report_campaign
     *
     * @mbggenerated Mon Apr 27 11:55:29 CST 2015
     */
    int insertSelective(AdGoogleAdwordsReportCampaignWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_google_adwords_report_campaign
     *
     * @mbggenerated Mon Apr 27 11:55:29 CST 2015
     */
    AdGoogleAdwordsReportCampaignWithBLOBs selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_google_adwords_report_campaign
     *
     * @mbggenerated Mon Apr 27 11:55:29 CST 2015
     */
    int updateByPrimaryKeySelective(AdGoogleAdwordsReportCampaignWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_google_adwords_report_campaign
     *
     * @mbggenerated Mon Apr 27 11:55:29 CST 2015
     */
    int updateByPrimaryKeyWithBLOBs(AdGoogleAdwordsReportCampaignWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_google_adwords_report_campaign
     *
     * @mbggenerated Mon Apr 27 11:55:29 CST 2015
     */
    int updateByPrimaryKey(AdGoogleAdwordsReportCampaign record);
    
    //自定义
    void syncByGoogleAdwordsReportCampaign(Date date);
    
    List<AdGoogleAdwordsReportCampaign> selectByCampaign(AdGoogleAdwordsReportCampaignPO adGoogleAdwordsReportCampaignPO);
    
    void batchUpdate(List<AdGoogleAdwordsReportCampaign> list);
    
    void update(AdGoogleAdwordsReportCampaign adGoogleAdwordsReportCampaign);
}