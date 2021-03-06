package com.lt.dao.mapper;

import java.util.List;

import org.apache.ibatis.annotations.Param;
import org.springframework.stereotype.Repository;

import com.lt.dao.model.GoogleAdwordsCampaign;
import com.lt.dao.model.GoogleAdwordsCampaignWithBLOBs;
@Repository
public interface GoogleAdwordsCampaignMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_campaign
     *
     * @mbggenerated Wed Apr 22 11:31:17 CST 2015
     */
    int deleteByPrimaryKey(Long id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_campaign
     *
     * @mbggenerated Wed Apr 22 11:31:17 CST 2015
     */
    int insert(GoogleAdwordsCampaignWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_campaign
     *
     * @mbggenerated Wed Apr 22 11:31:17 CST 2015
     */
    int insertSelective(GoogleAdwordsCampaignWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_campaign
     *
     * @mbggenerated Wed Apr 22 11:31:17 CST 2015
     */
    GoogleAdwordsCampaignWithBLOBs selectByPrimaryKey(Long id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_campaign
     *
     * @mbggenerated Wed Apr 22 11:31:17 CST 2015
     */
    int updateByPrimaryKeySelective(GoogleAdwordsCampaignWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_campaign
     *
     * @mbggenerated Wed Apr 22 11:31:17 CST 2015
     */
    int updateByPrimaryKeyWithBLOBs(GoogleAdwordsCampaignWithBLOBs record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_campaign
     *
     * @mbggenerated Wed Apr 22 11:31:17 CST 2015
     */
    int updateByPrimaryKey(GoogleAdwordsCampaign record);
    
    List<GoogleAdwordsCampaignWithBLOBs> getCampaignList(GoogleAdwordsCampaignWithBLOBs po);
    Integer checkExist(@Param("name")String name);
}