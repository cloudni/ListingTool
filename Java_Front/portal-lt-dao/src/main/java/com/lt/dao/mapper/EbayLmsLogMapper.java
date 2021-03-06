package com.lt.dao.mapper;

import java.util.List;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.EbayLmsLog;
import com.lt.dao.po.EbayLmsLogPO;

@Repository
public interface EbayLmsLogMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_lms_log
     *
     * @mbggenerated Wed May 27 21:22:36 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_lms_log
     *
     * @mbggenerated Wed May 27 21:22:36 CST 2015
     */
    int insert(EbayLmsLog record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_lms_log
     *
     * @mbggenerated Wed May 27 21:22:36 CST 2015
     */
    int insertSelective(EbayLmsLog record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_lms_log
     *
     * @mbggenerated Wed May 27 21:22:36 CST 2015
     */
    EbayLmsLog selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_lms_log
     *
     * @mbggenerated Wed May 27 21:22:36 CST 2015
     */
    int updateByPrimaryKeySelective(EbayLmsLog record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_lms_log
     *
     * @mbggenerated Wed May 27 21:22:36 CST 2015
     */
    int updateByPrimaryKey(EbayLmsLog record);
    
    void batchInsertSelective(List<EbayLmsLogPO> list);
}