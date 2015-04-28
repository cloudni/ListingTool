package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.EbayAttribute;
@Repository
public interface EbayAttributeMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(EbayAttribute record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(EbayAttribute record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    EbayAttribute selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(EbayAttribute record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(EbayAttribute record);
}