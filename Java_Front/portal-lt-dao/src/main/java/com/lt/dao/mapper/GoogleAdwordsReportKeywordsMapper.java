package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.GoogleAdwordsReportKeywordsWithBLOBs;

@Repository
public interface GoogleAdwordsReportKeywordsMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_report_keywords
     *
     * @mbggenerated Fri Jun 19 16:31:03 CST 2015
     */
    int insert(GoogleAdwordsReportKeywordsWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_report_keywords
     *
     * @mbggenerated Fri Jun 19 16:31:03 CST 2015
     */
    int insertSelective(GoogleAdwordsReportKeywordsWithBLOBs record);
    int deleteByDate(java.util.Date date);
}