package com.lt.dao.mapper;

import java.math.BigDecimal;
import java.util.Date;

import org.springframework.stereotype.Repository;

import com.lt.dao.po.AdGoogleAdwordsReportAdPO;
import com.lt.dao.po.CampaignCostPO;
@Repository
public interface AdGoogleAdwordsReportAdMapper {
	/**
	 * 根据根据同步报表数据
	 * @param date
	 */
    void sync(CampaignCostPO campaignCostPO);
    
    /**
     * 根据点击数修改报表数据
     * @param campaignCostPO
     */
    void updateByClicks(CampaignCostPO campaignCostPO);
    
    /**
     * 根据百分比修改报表数据
     * @param campaignCostPO
     */
    void updateByPercentage(CampaignCostPO campaignCostPO);
    
    /**
     * 根据时间删除当天数据
     * @param campaignCostPO
     */
    void delete(CampaignCostPO campaignCostPO);
    
    /**
     * 根据广告id，查询该广告的花费
     * @param adGoogleAdwordsReportAdPO
     * @return
     */
    BigDecimal countAmountByAdId(AdGoogleAdwordsReportAdPO adGoogleAdwordsReportAdPO);
    /**
     * 修改状态为已处理
     */
    void updateCharged(Date date);
}