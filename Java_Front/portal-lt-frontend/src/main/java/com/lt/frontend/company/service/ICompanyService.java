package com.lt.frontend.company.service;

import java.util.List;
import java.util.Map;

import com.lt.dao.model.Company;

public interface ICompanyService
{
	
    int deleteByPrimaryKey(Integer id);

    int insertSelective(Company record);

    Company selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(Company record);

    /**
     * List Company  init data
     * Author devin
     * @param Company
     * @return
     */
    List<Company> selectAll(Company company);
    
    int insert(Company company);
    
    int deleteByPrimaryKey(Company company);
    
    Company selectById(Company company);
    
    int updateByPrimaryKey(Company company);
    
    boolean compareBalance(Map<String, Object> map);
}
