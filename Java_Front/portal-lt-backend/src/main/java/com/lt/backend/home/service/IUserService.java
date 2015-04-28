package com.lt.backend.home.service;

import java.util.List;

import com.lt.dao.model.User;

public interface IUserService
{
	/**
     * List User  init data
     * Author devin
     * @param User
     * @return
     */
    List<User> selectAll(User user);
    
    int insert(User user);
    
    int deleteByPrimaryKey(User user);
    
    User selectByPrimaryKey(User user);
    
    int updateByPrimaryKey(User user);
    
    /**
     * List User  Department data
     * Author devin
     * @param User
     * @return
     */
    List<User> selectUserByDepartmentId(User user);
    
    /**
     * 用户登录账号查询用户信息
     * @param account
     * @param password
     * @return
     */
    boolean isLogin(String account,String password);

}
