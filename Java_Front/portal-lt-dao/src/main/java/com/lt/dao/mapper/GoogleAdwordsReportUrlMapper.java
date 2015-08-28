package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.GoogleAdwordsReportUrl;

@Repository
public interface GoogleAdwordsReportUrlMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_report_url
     *
     * @mbggenerated Wed Jun 24 15:26:11 CST 2015
     */
    int insert(GoogleAdwordsReportUrl record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_report_url
     *
     * @mbggenerated Wed Jun 24 15:26:11 CST 2015
     */
    int insertSelective(GoogleAdwordsReportUrl record);

    int deleteByDate(java.util.Date date);
}