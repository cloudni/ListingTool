package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.AdGroup;
@Repository
public interface AdGroupMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_group
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_group
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int insert(AdGroup record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_group
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int insertSelective(AdGroup record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_group
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    AdGroup selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_group
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int updateByPrimaryKeySelective(AdGroup record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_group
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int updateByPrimaryKeyWithBLOBs(AdGroup record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ad_group
     *
     * @mbggenerated Mon Apr 13 18:46:40 CST 2015
     */
    int updateByPrimaryKey(AdGroup record);
}