package com.lt.backend.home.service.impl;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.home.service.IUserService;
import com.lt.dao.mapper.UserMapper;
import com.lt.dao.model.User;
import com.lt.platform.util.lang.StringUtil;
import com.lt.platform.util.secret.SecretUtil;

@Service
public class UserServiceImpl implements IUserService {
	@Autowired
	private UserMapper userMapper;

	@Override
	public int deleteByPrimaryKey(User user)
	{
		// TODO Auto-generated method stub
		return userMapper.deleteByPrimaryKey(user);
	}

	@Override
	public int insert(User user)
	{
		// TODO Auto-generated method stub
		return userMapper.insert(user);
	}

	@Override
	public User selectByPrimaryKey(User user)
	{
		// TODO Auto-generated method stub
		return userMapper.selectByPrimaryKey(user);
	}

	@Override
	public int updateByPrimaryKey(User user)
	{
		// TODO Auto-generated method stub
		return userMapper.updateByPrimaryKey(user);
	}

	@Override
	public List<User> selectAll(User user)
	{
		// TODO Auto-generated method stub
		return userMapper.selectAll(user);
	}

	@Override
	public List<User> selectUserByDepartmentId(User user)
	{
		// TODO Auto-generated method stub
		return userMapper.selectUserByDepartmentId(user);
	}

	@Override
	public boolean isLogin(String account,String password) {
		Map<String,Object> loadUserInfo = userMapper.selectLoginUserAdmin(account);
		if(loadUserInfo == null){
			return false;
		}
		String pass = loadUserInfo.get("password").toString();
		String newPassword = SecretUtil.secretMD5(password);
		if(StringUtil.isNotBlank(pass) && newPassword.equals(pass)){
			return true;
		}
		return false;
	}
}
