package com.lt.dao.mapper;

import java.util.List;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.TrackingTagJobErrorDetail;
import com.lt.dao.po.TrackingTagJobErrorDetailPO;

@Repository
public interface TrackingTagJobErrorDetailMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_tracking_tag_job_error_detail
     *
     * @mbggenerated Tue Jun 30 16:54:46 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_tracking_tag_job_error_detail
     *
     * @mbggenerated Tue Jun 30 16:54:46 CST 2015
     */
    int insert(TrackingTagJobErrorDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_tracking_tag_job_error_detail
     *
     * @mbggenerated Tue Jun 30 16:54:46 CST 2015
     */
    int insertSelective(TrackingTagJobErrorDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_tracking_tag_job_error_detail
     *
     * @mbggenerated Tue Jun 30 16:54:46 CST 2015
     */
    TrackingTagJobErrorDetail selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_tracking_tag_job_error_detail
     *
     * @mbggenerated Tue Jun 30 16:54:46 CST 2015
     */
    int updateByPrimaryKeySelective(TrackingTagJobErrorDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_tracking_tag_job_error_detail
     *
     * @mbggenerated Tue Jun 30 16:54:46 CST 2015
     */
    int updateByPrimaryKey(TrackingTagJobErrorDetail record);
    
    //自定义
    List<TrackingTagJobErrorDetailPO> selectAll();
}