package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.EbayAttributeGroup;
@Repository
public interface EbayAttributeGroupMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute_group
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute_group
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(EbayAttributeGroup record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute_group
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(EbayAttributeGroup record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute_group
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    EbayAttributeGroup selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute_group
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(EbayAttributeGroup record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_attribute_group
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(EbayAttributeGroup record);
}