package com.lt.backend.category.service;

import java.util.List;

import com.lt.dao.po.GoogleAdwordsCategoryPO;
public interface IGoogleAdwordsCategoryService
{
	public List<GoogleAdwordsCategoryPO> selectByParentId(GoogleAdwordsCategoryPO googleAdwordsCategory);
}
