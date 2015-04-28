package com.lt.dao.mapper;

import java.util.List;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.Notification;

@Repository
public interface NotificationMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_notification
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_notification
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(Notification notification);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_notification
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(Notification notification);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_notification
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    Notification selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_notification
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(Notification notification);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_notification
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeyWithBLOBs(Notification notification);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_notification
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(Notification notification);
    
    /**
     * List Notification init data
     * Author devin
     * @param Notification
     * @return
     */
    List<Notification> selectAll(Notification notification);
    
    //自定义
    void batchInsert(List<Notification> list);
}