package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.AdAdVariation;
import com.lt.dao.model.AdAdVariationWithBLOBs;
@Repository
public interface AdAdVariationMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_ad_variation
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_ad_variation
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int insert(AdAdVariationWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_ad_variation
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int insertSelective(AdAdVariationWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_ad_variation
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    AdAdVariationWithBLOBs selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_ad_variation
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int updateByPrimaryKeySelective(AdAdVariationWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_ad_variation
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int updateByPrimaryKeyWithBLOBs(AdAdVariationWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_ad_variation
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int updateByPrimaryKey(AdAdVariation record);
}