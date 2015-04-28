package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.LTUser;
@Repository
public interface LTUserMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(LTUser record);

    int insertSelective(LTUser record);

    LTUser selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(LTUser record);

    int updateByPrimaryKey(LTUser record);
}