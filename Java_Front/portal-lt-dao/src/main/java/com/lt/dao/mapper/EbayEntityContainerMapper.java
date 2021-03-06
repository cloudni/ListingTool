package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.EbayEntityContainer;
@Repository
public interface EbayEntityContainerMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_container
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_container
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(EbayEntityContainer record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_container
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(EbayEntityContainer record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_container
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    EbayEntityContainer selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_container
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(EbayEntityContainer record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_entity_container
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(EbayEntityContainer record);
}