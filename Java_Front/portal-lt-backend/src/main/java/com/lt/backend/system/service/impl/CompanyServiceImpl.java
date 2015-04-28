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
	public int deleteByPrimaryKey(Company company)
	{
		// TODO Auto-generated method stub
		return companyMapper.deleteByPrimaryKey(company);
	}

	@Override
	public int insert(Company company)
	{
		// TODO Auto-generated method stub
		return companyMapper.insert(company);
	}

	@Override
	public Company selectById(Company company)
	{
		// TODO Auto-generated method stub
		return companyMapper.selectById(company);
	}

	@Override
	public int updateByPrimaryKey(Company company)
	{
		// TODO Auto-generated method stub
		return companyMapper.updateByPrimaryKey(company);
	}

	@Override
	public List<Company> selectAll(Company company)
	{
		// TODO Auto-generated method stub
		return companyMapper.selectAll(company);
	}

	@Override
	public int deleteByPrimaryKey(Integer id)
	{
		return deleteByPrimaryKey(id);
	}

	@Override
	public int insertSelective(Company company)
	{
		// TODO Auto-generated method stub
		return insertSelective(company);
	}

	@Override
	public int updateByPrimaryKeySelective(Company company)
	{
		// TODO Auto-generated method stub
		return updateByPrimaryKeySelective(company);
	}

}
