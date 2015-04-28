package com.lt.frontend.home.service.impl;

import javax.annotation.Resource;

import org.springframework.stereotype.Service;

import com.lt.dao.mapper.LTUserMapper;
import com.lt.dao.model.LTUser;
import com.lt.frontend.home.service.IDemoService;

@Service
public class DemoServiceImpl implements IDemoService {
	@Resource
	private LTUserMapper ltUserMapper;

	public LTUser findAll(Integer id) throws Exception {
		return ltUserMapper.selectByPrimaryKey(id);
	}
	
	

}
