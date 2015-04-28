package com.lt.backend.category.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.category.service.IGoogleAdwordsCategoryService;
import com.lt.dao.mapper.GoogleAdwordsCategoryMapper;
import com.lt.dao.po.GoogleAdwordsCategoryPO;
/**
 * 
 * @author jameschen
 *
 */
@Service
public class GoogleAdewordsCategoryServiceImpl implements IGoogleAdwordsCategoryService
{
	@Autowired
	private GoogleAdwordsCategoryMapper googleAdwordsCategoryMapper;

	@Override
	public List<GoogleAdwordsCategoryPO> selectByParentId(
			GoogleAdwordsCategoryPO googleAdwordsCategory)
	{
		
		return googleAdwordsCategoryMapper.selectByParentId(googleAdwordsCategory);
	}


}
