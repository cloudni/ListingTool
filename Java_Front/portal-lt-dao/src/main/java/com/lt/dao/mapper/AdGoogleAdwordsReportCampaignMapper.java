package com.lt.dao.mapper;

import java.math.BigDecimal;
import java.util.Date;

import org.springframework.stereotype.Repository;

import com.lt.dao.po.AdGoogleAdwordsReportCampaignPO;
import com.lt.dao.po.CampaignCostPO;
@Repository
public interface AdGoogleAdwordsReportCampaignMapper {
    /**
     * 根据时间将当天报表数据同步至临时表
     * @param campaignCostPO
     */
    void sync(CampaignCostPO campaignCostPO);
    
    /***************新方案*******************
    /**
     * 根据时间删除当天数据
     * @param campaignCostPO
     */
    void delete(CampaignCostPO campaignCostPO);
    /**
     * 根据条件查询临时表数据
     * @param date
     * @return
     */
    Integer getIsCharged(Date date);
    /**
     * 根据点击数修改临时表数据
     * @param campaignCostPO
     */
    void updateByClicks(CampaignCostPO campaignCostPO);
    
    /**
     * 根据百分比修改临时表数据
     * @param campaignCostPO
     */
    void updateByPercentage(CampaignCostPO campaignCostPO);
    /**
     * 根据公司id，查询该公司应被预冻结的金额
     * @param adGoogleAdwordsReportCampaign
     * @return
     */
    BigDecimal countAmountByCompanyId(AdGoogleAdwordsReportCampaignPO adGoogleAdwordsReportCampaign);
    
    /**
     * 根据活动id，查询该活动应花费
     * @param adGoogleAdwordsReportCampaign
     * @return
     */
    BigDecimal countAmountByCampaignId(CampaignCostPO campaignCostPO);
    /**
     * 修改状态为已处理
     */
    void updateCharged(Date date);
}