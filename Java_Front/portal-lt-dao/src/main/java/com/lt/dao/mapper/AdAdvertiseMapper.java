package com.lt.dao.mapper;

import java.util.List;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.AdAdvertise;
@Repository
public interface AdAdvertiseMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_advertise
     *
     * @mbggenerated Mon May 04 11:11:12 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_advertise
     *
     * @mbggenerated Mon May 04 11:11:12 CST 2015
     */
    int insert(AdAdvertise record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_advertise
     *
     * @mbggenerated Mon May 04 11:11:12 CST 2015
     */
    int insertSelective(AdAdvertise record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_advertise
     *
     * @mbggenerated Mon May 04 11:11:12 CST 2015
     */
    AdAdvertise selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_advertise
     *
     * @mbggenerated Mon May 04 11:11:12 CST 2015
     */
    int updateByPrimaryKeySelective(AdAdvertise record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_advertise
     *
     * @mbggenerated Mon May 04 11:11:12 CST 2015
     */
    int updateByPrimaryKey(AdAdvertise record);
    
    //自定义
    List<AdAdvertise> selectByAdCampaign(Integer adCampaignId);
}