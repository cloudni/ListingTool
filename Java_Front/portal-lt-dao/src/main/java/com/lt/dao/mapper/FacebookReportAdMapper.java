package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.FacebookReportAd;
@Repository
public interface FacebookReportAdMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_facebook_report_ad
     *
     * @mbggenerated Thu Aug 20 11:43:02 CST 2015
     */
    int insert(FacebookReportAd record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_facebook_report_ad
     *
     * @mbggenerated Thu Aug 20 11:43:02 CST 2015
     */
    int insertSelective(FacebookReportAd record);
}