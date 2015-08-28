package com.lt.dao.mapper;

import java.util.Date;

import org.springframework.stereotype.Repository;

import com.lt.dao.po.CampaignCostPO;
@Repository
public interface AdGoogleAdwordsReportAdGroupMapper {

    //自定义
    /**
     * 同步
     * @param date
     */
    void sync(CampaignCostPO campaignCostPO);
    /**
     * 根据时间删除当天数据
     * @param campaignCostPO
     */
    void delete(CampaignCostPO campaignCostPO);
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
}