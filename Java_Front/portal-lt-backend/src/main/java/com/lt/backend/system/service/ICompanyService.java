package com.lt.backend.system.service;

import java.util.List;

import com.lt.dao.model.Company;

public interface ICompanyService
{
	/**
	 * 通过主键查询企业
	 * @param id
	 * @return
	 */
    Company selectByPrimaryKey(Integer id);
    /**
     * 全查所有企业
     * @return
     */
    List<Company> selectAll();
    
}
