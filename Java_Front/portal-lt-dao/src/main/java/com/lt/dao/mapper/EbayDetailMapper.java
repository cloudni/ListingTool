package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.EbayDetail;
@Repository
public interface EbayDetailMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_detail
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_detail
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(EbayDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_detail
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(EbayDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_detail
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    EbayDetail selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_detail
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(EbayDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_detail
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(EbayDetail record);
}