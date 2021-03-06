package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.EbayEntityDecimal;
@Repository
public interface EbayEntityDecimalMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_decimal
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_decimal
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(EbayEntityDecimal record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_decimal
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(EbayEntityDecimal record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_decimal
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    EbayEntityDecimal selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_decimal
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(EbayEntityDecimal record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_decimal
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(EbayEntityDecimal record);
}