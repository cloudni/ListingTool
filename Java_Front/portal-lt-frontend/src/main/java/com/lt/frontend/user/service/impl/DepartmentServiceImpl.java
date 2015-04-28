package com.lt.frontend.user.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.dao.mapper.DepartmentMapper;
import com.lt.dao.mapper.UserMapper;
import com.lt.dao.model.Department;
import com.lt.dao.model.User;
import com.lt.frontend.user.service.IDepartmentService;
import com.lt.platform.framework.core.model.MyBatisSuperModel;

@Service
public class DepartmentServiceImpl implements IDepartmentService {
	@Autowired
	private DepartmentMapper departmentMapper;
	
	@Autowired
	private UserMapper userMapper;

	@Override
	public int deleteByPrimaryKey(Department department)
	{
		// TODO Auto-generated method stub
		return departmentMapper.deleteByPrimaryKey(department);
	}

	@Override
	public int insert(Department department)
	{
		int result=departmentMapper.insert(department);
		// TODO Auto-generated method stub
		
		//修改用户所属部门
		//List<String> userIdList = new ArrayList<String>();
		String userIds=department.getUserIds();
		String removeIds=department.getRemoveIds();
		//获取最新的部门
		int maxDepartmentId=departmentMapper.selectMaxId();
		
		if(null!=userIds && !"".equals(userIds)){
			userIds=userIds.substring(0,userIds.length()-1);
			String[] userArray=userIds.split(",");
			if(null!=userArray && userArray.length>0){
				for (int i = 0; i < userArray.length; i++)
				{
					//userIdList.add(userArray[i]);
					String userId=userArray[i];
					User user =new User();
					user.setId(Integer.parseInt(userId));
					user=userMapper.selectByPrimaryKey(user);
					user.setDepartmentId(maxDepartmentId);
					userMapper.updateByPrimaryKey(user);
				}
				//批量更新用户部门
				//userMapper.updateByIdBatch(userIdList, department.getId());
			}
		}
		
		//userIdList = new ArrayList<String>();
		if(null!=removeIds && !"".equals(removeIds)){
			removeIds=removeIds.substring(0,removeIds.length()-1);
			String[] removeUserArray=removeIds.split(",");
			if(null!=removeUserArray && removeUserArray.length>0){
				for (int i = 0; i < removeUserArray.length; i++)
				{
					//userIdList.add(removeUserArray[i]);
					String userId=removeUserArray[i];
					User user =new User();
					user.setId(Integer.parseInt(userId));
					user=userMapper.selectByPrimaryKey(user);
					user.setDepartmentId(4);//此处要改
					userMapper.updateByPrimaryKey(user);
				}
				//批量更新用户部门
				//userMapper.updateByIdBatch(userIdList, null);
			}
		}
		
		return result;
	}

	@Override
	public Department selectByPrimaryKey(Department department)
	{
		// TODO Auto-generated method stub
		return departmentMapper.selectByPrimaryKey(department);
	}

	@Override
	public int updateByPrimaryKey(Department department)
	{
		// TODO Auto-generated method stub
		int result=departmentMapper.updateByPrimaryKey(department);
		// TODO Auto-generated method stub
		
		//修改用户所属部门
		//List<String> userIdList = new ArrayList<String>();
		String userIds=department.getUserIds();
		String removeIds=department.getRemoveIds();
		if(null!=userIds && !"".equals(userIds)){
			userIds=userIds.substring(0,userIds.length()-1);
			String[] userArray=userIds.split(",");
			if(null!=userArray && userArray.length>0){
				for (int i = 0; i < userArray.length; i++)
				{
					//userIdList.add(userArray[i]);
					String userId=userArray[i];
					User user =new User();
					user.setId(Integer.parseInt(userId));
					user=userMapper.selectByPrimaryKey(user);
					user.setDepartmentId(department.getId());
					userMapper.updateByPrimaryKey(user);
				}
				//批量更新用户部门
				//userMapper.updateByIdBatch(userIdList, department.getId());
			}
		}
		
		//userIdList = new ArrayList<String>();
		if(null!=removeIds && !"".equals(removeIds)){
			removeIds=removeIds.substring(0,removeIds.length()-1);
			String[] removeUserArray=removeIds.split(",");
			if(null!=removeUserArray && removeUserArray.length>0){
				for (int i = 0; i < removeUserArray.length; i++)
				{
					//userIdList.add(removeUserArray[i]);
					String userId=removeUserArray[i];
					User user =new User();
					user.setId(Integer.parseInt(userId));
					user=userMapper.selectByPrimaryKey(user);
					user.setDepartmentId(4);//此处要改
					userMapper.updateByPrimaryKey(user);
				}
				//批量更新用户部门
				//userMapper.updateByIdBatch(userIdList, null);
			}
		}
		
		return result;
	}

	@Override
	public List<Department> selectAll(MyBatisSuperModel model)
	{
		// TODO Auto-generated method stub
		model.setIspaging(true);
		return departmentMapper.selectAll(model);
	}
}
