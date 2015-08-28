package com.lt.dao.mapper;

import java.math.BigDecimal;
import java.util.Date;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.AdFacebookReportAd;
import com.lt.dao.po.CampaignCostPO;
@Repository
public interface AdFacebookReportAdMapper {
	/**
     * 根据时间删除当天数据
     * @param campaignCostPO
     */
    void delete(CampaignCostPO campaignCostPO);
    /**
     * 同步
     * @param record
     */
    void sync(CampaignCostPO campaignCostPO);
    
    /**
     * 根据点击数修改
     * @param campaignCostPO
     */
    void updateByClicks(CampaignCostPO campaignCostPO);
    /**
     * 根据百分比修改
     * @param campaignCostPO
     */
    void updateByPercentage(CampaignCostPO campaignCostPO);
    /**
     * 修改状态为已处理
     */
    void updateCharged(Date date);
    /**
     * 根据广告id，查询该广告的花费
     * @param adFacebookReportAd
     * @return
     */
    BigDecimal countAmountByAdId(AdFacebookReportAd adFacebookReportAd);
}