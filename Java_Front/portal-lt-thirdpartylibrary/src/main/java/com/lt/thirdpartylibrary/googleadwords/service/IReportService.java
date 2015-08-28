package com.lt.thirdpartylibrary.googleadwords.service;

public interface IReportService
{
    /**
     * 报表批量下载
     */
    public void saveAdwordsReport(String date) throws Exception;
    
    
    /**
     * 
     * @param date 日期
     * @param adId adwordsID
     * @param ltAdAdvertiseVariationId 业务ID
     */
    public void getAd(String date, Long adId, Integer ltAdAdvertiseVariationId);
    
    /**
     * 
     * @param date 日期
     * @param adGroupId adwordsID
     * @param ltAdGroupId 业务ID
     */
    public void getAdGroup(String date, Long adGroupId, Integer ltAdGroupId);
    
    /**
     * 
     * @param date 日期
     * @param campaignId adwordsID
     * @param ltAdCampaignId 业务ID
     */
    public void getCampaign(String date, Long campaignId, Long ltAdCampaignId);

    
    /**
     * 下载预算
     * @param date 日期
     * @param budgetId 预算ID
     */
    public void getBudget(String date, Long budgetId);
}
