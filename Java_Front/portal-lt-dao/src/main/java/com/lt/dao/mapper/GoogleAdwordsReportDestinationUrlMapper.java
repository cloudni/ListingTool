package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.GoogleAdwordsReportDestinationUrl;

@Repository
public interface GoogleAdwordsReportDestinationUrlMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_report_destination_url
     *
     * @mbggenerated Sun Apr 26 09:45:03 CST 2015
     */
    int insert(GoogleAdwordsReportDestinationUrl record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_report_destination_url
     *
     * @mbggenerated Sun Apr 26 09:45:03 CST 2015
     */
    int insertSelective(GoogleAdwordsReportDestinationUrl record);
    
    /**
     * 验证该记录是否存在
     * @param record
     * @return 主键ID
     */
    Integer checkExist(GoogleAdwordsReportDestinationUrl record);
    int deleteByDate(java.util.Date date);
    
}