package com.lt.frontend.user.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.lt.dao.model.Company;
import com.lt.dao.model.Department;
import com.lt.frontend.company.service.ICompanyService;
import com.lt.frontend.user.service.IDepartmentService;

@Controller
@RequestMapping("company")
public class CompanyController
{

	@Autowired
	private ICompanyService companyService;
	
	@Autowired
	private IDepartmentService departmentService;
	
	ModelAndView returnRequest(String url){
		return new ModelAndView("forward:"+url);
	}

	@RequestMapping("listCompany")
	public ModelAndView index() throws Exception
	{
		ModelAndView model = new ModelAndView("company/listCompany");
		/*List<Company> companyList=companyService.selectAll(null);
		model.addObject("companyList", companyList);*/
		
		Company company=new Company();
		company.setId(1);
		company=companyService.selectById(company);
		model.addObject("company", company);
		return model;
	}
	
	@RequestMapping("toAddCompany")
	public ModelAndView toAddCompany() throws Exception
	{
		ModelAndView model = new ModelAndView("company/editCompany");
		List<Department> departmentList=departmentService.selectAll(null);
		model.addObject("departmentList", departmentList);
		return model;
	}
	
	@RequestMapping("addCompany")
	public ModelAndView addCompany(Company company) throws Exception
	{
		companyService.insert(company);
		return returnRequest("listCompany.shtml");
	}
	
	@RequestMapping("deleteCompany")
	public ModelAndView deleteCompany(Company company) throws Exception
	{
		companyService.deleteByPrimaryKey(company);
		return returnRequest("listCompany.shtml");
	}
	
	@RequestMapping("getCompany")
	public ModelAndView getCompany(Company company) throws Exception
	{
		company=companyService.selectById(company);
		ModelAndView model = new ModelAndView("company/editCompany");
		return model;
	}
	
	@RequestMapping("toUpdateCompany")
	public ModelAndView toUpdateCompany(Company company) throws Exception
	{
		company=new Company();
		company.setId(1);
		company=companyService.selectById(company);
		ModelAndView model = new ModelAndView("company/editCompany");
		model.addObject("company", company);
		return model;
	}
	
	@RequestMapping("updateCompany")
	public ModelAndView updateCompany(Company company) throws Exception
	{
		companyService.updateByPrimaryKey(company);
		return returnRequest("listCompany.shtml");
	}
}
