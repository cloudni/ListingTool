package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.GoogleAnalyticsReportPagePath;

@Repository
public interface GoogleAnalyticsReportPagePathMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_analytics_report_page_path
     *
     * @mbggenerated Fri Aug 07 16:15:04 CST 2015
     */
    int insert(GoogleAnalyticsReportPagePath record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_analytics_report_page_path
     *
     * @mbggenerated Fri Aug 07 16:15:04 CST 2015
     */
    int insertSelective(GoogleAnalyticsReportPagePath record);
    
    int deleteByDate(java.util.Date date);
}