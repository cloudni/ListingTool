package com.lt.backend.category.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.category.service.IEbayCategoryService;
import com.lt.dao.mapper.EbayCategoryMapper;
import com.lt.dao.model.EbayCategory;
import com.lt.dao.po.EbayCategoryPO;
/**
 * 
 * @author jameschen
 *
 */
@Service
public class EbayCategoryServiceImpl implements IEbayCategoryService
{
	@Autowired
	private EbayCategoryMapper ebayCategoryMapper;

	@Override
	public List<EbayCategoryPO> selectByParentId(EbayCategoryPO record)
	{
		
		return ebayCategoryMapper.selectByParentId(record);
	}

	@Override
	public void updateByCategoryIdSelective(EbayCategory ebayCategory)
	{
		ebayCategoryMapper.updateByCategoryIdSelective(ebayCategory);
		
	}

}
