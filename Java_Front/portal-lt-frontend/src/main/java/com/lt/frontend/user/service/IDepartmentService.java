package com.lt.frontend.user.service;

import java.util.List;

import com.lt.dao.model.Department;
import com.lt.platform.framework.core.model.MyBatisSuperModel;

public interface IDepartmentService
{
	/**
     * List Department  init data
     * Author devin
     * @param Department
     * @return
     */
    List<Department> selectAll(MyBatisSuperModel model);
    
    int insert(Department department);
    
    int deleteByPrimaryKey(Department department);
    
    Department selectByPrimaryKey(Department department);
    
    int updateByPrimaryKey(Department department);
}
