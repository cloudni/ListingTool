package com.lt.frontend.company.service.impl;

import java.util.List;
import java.util.Map;

import javax.annotation.Resource;

import org.springframework.stereotype.Service;

import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.model.Company;
import com.lt.frontend.company.service.ICompanyService;
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
	public int deleteByPrimaryKey(Company company)
	{
		
		return companyMapper.deleteByPrimaryKey(company);
	}

	@Override
	public int insert(Company company)
	{
		
		return companyMapper.insert(company);
	}

	@Override
	public Company selectById(Company company)
	{
		
		return companyMapper.selectById(company);
	}

	@Override
	public int updateByPrimaryKey(Company company)
	{
		
		return companyMapper.updateByPrimaryKey(company);
	}

	@Override
	public List<Company> selectAll(Company company)
	{
		
		return companyMapper.selectAll(company);
	}

	@Override
	public int deleteByPrimaryKey(Integer id)
	{
		Company company = new Company();
		company.setId(id);
		return companyMapper.deleteByPrimaryKey(company);
	}

	@Override
	public int insertSelective(Company company)
	{
		
		return companyMapper.insertSelective(company);
	}

	@Override
	public int updateByPrimaryKeySelective(Company company)
	{
		
		return companyMapper.updateByPrimaryKeySelective(company);
	}

	@Override
	public boolean compareBalance(Map<String, Object> map)
	{
		
		return companyMapper.compareBalance(map);
	}

}
