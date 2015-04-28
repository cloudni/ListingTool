package com.lt.frontend.user.controller;

import java.util.List;

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
@RequestMapping("user")
public class UserController
{

	@Autowired
	private IUserService userService;
	
	@Autowired
	private IDepartmentService departmentService;
	
	ModelAndView returnRequest(String url){
		return new ModelAndView("forward:"+url);
	}

	@RequestMapping("listUser")
	public ModelAndView listUser() throws Exception
	{
		ModelAndView model = new ModelAndView("user/listUser");
		List<User> userList=userService.selectAll(null);
		model.addObject("userList", userList);
		return model;
	}
	
	@RequestMapping("toAddUser")
	public ModelAndView toAddUser() throws Exception
	{
		ModelAndView model = new ModelAndView("user/editUser");
		List<Department> departmentList=departmentService.selectAll(new MyBatisSuperModel());
		model.addObject("departmentList", departmentList);
		return model;
	}
	
	@RequestMapping("addUser")
	public ModelAndView addUser(User user) throws Exception
	{
		userService.insert(user);
		return returnRequest("listUser.shtml");
	}
	
	@RequestMapping("deleteUser")
	public ModelAndView deleteUser(User user) throws Exception
	{
		userService.deleteByPrimaryKey(user);
		return returnRequest("listUser.shtml");
	}
	
	@RequestMapping("getUser")
	public ModelAndView getUser(User user) throws Exception
	{
		user=userService.selectByPrimaryKey(user);
		ModelAndView model = new ModelAndView("user/detailUser");
		model.addObject("user", user);
		return model;
	}
	
	@RequestMapping("toUpdateUser")
	public ModelAndView toUpdateUser(User user) throws Exception
	{
		user=userService.selectByPrimaryKey(user);
		ModelAndView model = new ModelAndView("user/editUser");
		model.addObject("user", user);
		
		List<Department> departmentList=departmentService.selectAll(null);
		model.addObject("departmentList", departmentList);
		return model;
	}
	
	@RequestMapping("updateUser")
	public ModelAndView updateUser(User user) throws Exception
	{
		userService.updateByPrimaryKey(user);
		return returnRequest("listUser.shtml");
	}
}
