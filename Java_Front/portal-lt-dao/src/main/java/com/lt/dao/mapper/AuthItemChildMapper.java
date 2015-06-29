package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.AuthItemChildKey;
@Repository
public interface AuthItemChildMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_AuthItemChild
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(AuthItemChildKey key);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_AuthItemChild
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(AuthItemChildKey record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_AuthItemChild
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(AuthItemChildKey record);
}