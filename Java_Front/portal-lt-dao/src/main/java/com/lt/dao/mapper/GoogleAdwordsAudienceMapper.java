package com.lt.dao.mapper;

import java.util.List;

import org.apache.ibatis.annotations.Param;
import org.springframework.stereotype.Repository;

import com.lt.dao.model.GoogleAdwordsAudience;
import com.lt.dao.po.GoogleAdwordsAudiencePO;

@Repository
public interface GoogleAdwordsAudienceMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_audience
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    int deleteByPrimaryKey(Long pkId);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_audience
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    int insert(GoogleAdwordsAudience record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_audience
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    int insertSelective(GoogleAdwordsAudience record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_audience
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    GoogleAdwordsAudience selectByPrimaryKey(Long pkId);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_audience
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    int updateByPrimaryKeySelective(GoogleAdwordsAudience record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_audience
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    int updateByPrimaryKeyWithBLOBs(GoogleAdwordsAudience record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_audience
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    int updateByPrimaryKey(GoogleAdwordsAudience record);
    
    List<GoogleAdwordsAudiencePO> selectAllByPage(GoogleAdwordsAudiencePO po);
    
    List<GoogleAdwordsAudiencePO> getJobList();
    
    int updateAudienceRun(@Param("ids") String ids);
    
    int checkExist(@Param("name") String name, @Param("id") Integer id);
}