package com.lt.dao.mapper;

import com.lt.dao.model.Session;

public interface SessionMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_session
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(String id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_session
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(Session record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_session
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(Session record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_session
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    Session selectByPrimaryKey(String id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_session
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(Session record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_session
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeyWithBLOBs(Session record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_session
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(Session record);
}