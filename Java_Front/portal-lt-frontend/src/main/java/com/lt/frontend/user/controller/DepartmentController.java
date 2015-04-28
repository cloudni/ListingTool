package com.lt.frontend.user.controller;

import java.util.List;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletContext;
import javax.servlet.http.HttpServletRequest;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.lt.dao.model.Department;
import com.lt.dao.model.User;
import com.lt.frontend.user.service.IDepartmentService;
import com.lt.frontend.user.service.IUserService;
import com.lt.platform.framework.core.model.MyBatisSuperModel;

@Controller
@RequestMapping("department")
public class DepartmentController
{
	@Autowired
	private IUserService userService;
	
	@Autowired
	private IDepartmentService departmentService;
	
	ModelAndView returnRequest(String url){
		return new ModelAndView("forward:"+url);
	}

	/*@RequestMapping("listDepartment")
	public ModelAndView listDepartment() throws Exception
	{
		ModelAndView model = new ModelAndView("department/listDepartment");
		return model;
	}*/
	
	@RequestMapping("/listDepartment")
	public ModelAndView listModeDepartment(MyBatisSuperModel myModel, HttpServletRequest request) {
		ModelAndView model = new ModelAndView("department/listDepartment");
		myModel.setRequestPath(request);
		List<Department> departmentList=departmentService.selectAll(myModel);
		model.addObject("departmentList", departmentList);
		model.addObject("page", myModel);
		return model;
	}
	
	/*@RequestMapping("/listModeDepartment")
	@ResponseBody
	public MyBatisSuperModel listModeDepartment(MyBatisSuperModel model) {
		Map<String, Object> paramMap = new HashMap<String, Object>();
		model.setParams(paramMap);
		List<Department> departmentList=departmentService.selectAll(model);
		model.setResults(departmentList);
		return model;
	}*/
	
	@RequestMapping("toAddDepartment")
	public ModelAndView toAddDepartment() throws Exception
	{
		ModelAndView model = new ModelAndView("department/editDepartment");
		
		//部门列表
		List<Department> departmentList=departmentService.selectAll(new MyBatisSuperModel());
		model.addObject("departmentList", departmentList);
		
		//用户列表
		List<User> userList=userService.selectAll(null);
		model.addObject("userList", userList);
		
		return model;
	}
	
	@RequestMapping("addDepartment")
	public ModelAndView addDepartment(Department department, HttpServletRequest request) throws Exception
	{
		departmentService.insert(department);
		return returnRequest("listDepartment.shtml");
	}
	
	@RequestMapping("deleteDepartment")
	public ModelAndView deleteDepartment(Department department) throws Exception
	{
		departmentService.deleteByPrimaryKey(department);
		return returnRequest("listDepartment.shtml");
	}
	
	@RequestMapping("getDepartment")
	public ModelAndView getDepartment(Department department) throws Exception
	{
		department=departmentService.selectByPrimaryKey(department);
		ModelAndView model = new ModelAndView("department/detailDepartment");
		model.addObject("department", department);
		return model;
	}
	
	@RequestMapping("toUpdateDepartment")
	public ModelAndView toUpdateDepartment(Department department) throws Exception
	{
		department=departmentService.selectByPrimaryKey(department);
		ModelAndView model = new ModelAndView("department/editDepartment");
		model.addObject("department", department);
		
		List<Department> departmentList=departmentService.selectAll(new MyBatisSuperModel());
		model.addObject("departmentList", departmentList);
		
		//现在已关联的用户
		User user=new User();
		user.setDepartmentId(department.getId());
		user.setOp("=");
		List<User> userListByDepartmentId=userService.selectUserByDepartmentId(user);
		model.addObject("userListByDepartmentId", userListByDepartmentId);
		
		//用户列表
		user=new User();
		user.setDepartmentId(department.getId());
		user.setOp("!=");
		List<User> userList=userService.selectUserByDepartmentId(user);
		model.addObject("userList", userList);
				
		return model;
	}
	
	@RequestMapping("updateDepartment")
	public ModelAndView updateDepartment(Department department) throws Exception
	{
		departmentService.updateByPrimaryKey(department);
		return returnRequest("listDepartment.shtml");
	}
}
