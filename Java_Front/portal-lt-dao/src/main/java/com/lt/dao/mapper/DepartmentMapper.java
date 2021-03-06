package com.lt.dao.mapper;

import java.util.List;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.Department;
import com.lt.platform.framework.core.dao.mapper.MyBatisSuperMapper;
import com.lt.platform.framework.core.model.MyBatisSuperModel;

@Repository
public interface DepartmentMapper extends MyBatisSuperMapper<Department> {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_department
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(Department department);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_department
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(Department department);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_department
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(Department department);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_department
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    Department selectByPrimaryKey(Department department);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_department
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(Department department);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_department
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(Department department);
    
    /**
     * List Department  init data
     * Author devin
     * @param Department
     * @return
     */
    List<Department> selectAll(MyBatisSuperModel model);
    
    /**
     * int Max id
     * Author devin
     * @return
     */
    int selectMaxId();
}