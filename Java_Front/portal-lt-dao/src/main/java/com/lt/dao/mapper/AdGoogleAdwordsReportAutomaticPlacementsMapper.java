package com.lt.dao.mapper;

import java.util.Date;

import org.springframework.stereotype.Repository;

import com.lt.dao.po.AdGoogleAdwordsReportAutomaticPlacementsPO;
@Repository
public interface AdGoogleAdwordsReportAutomaticPlacementsMapper {
	/**
     * 根据时间删除当天数据
     * @param adGoogleAdwordsReportAutomaticPlacementsPO
     */
    void delete(AdGoogleAdwordsReportAutomaticPlacementsPO adGoogleAdwordsReportAutomaticPlacementsPO);
    /**
     * 同步
     * @param adGoogleAdwordsReportAutomaticPlacementsPO
     */
    void syncByGoogleAdwordsReportAutomaticPlacements(AdGoogleAdwordsReportAutomaticPlacementsPO adGoogleAdwordsReportAutomaticPlacementsPO);
    /**
     * 根据点击数修改
     * @param record
     */
    void updateByClicks(AdGoogleAdwordsReportAutomaticPlacementsPO record);
    /**
     * 根据百分比修改
     * @param record
     */
    void updateByPercentage(AdGoogleAdwordsReportAutomaticPlacementsPO record);
    /**
     * 修改状态为已处理
     */
    void updateCharged(Date date);
}