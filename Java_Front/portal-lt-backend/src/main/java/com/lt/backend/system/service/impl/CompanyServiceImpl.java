package com.lt.backend.system.service.impl;

import java.util.List;

import javax.annotation.Resource;

import org.springframework.stereotype.Service;

import com.lt.backend.system.service.ICompanyService;
import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.model.Company;
@Service
public class CompanyServiceImpl implements ICompanyService
{
	@Resource
	private CompanyMapper companyMapper;

	@Override
	public Company selectByPrimaryKey(Integer id)
	{
		return companyMapper.selectByPrimaryKey(id);
	}
	
	@Override
	public List<Company> selectAll()
	{
		
		return companyMapper.selectAll();
	}

}
