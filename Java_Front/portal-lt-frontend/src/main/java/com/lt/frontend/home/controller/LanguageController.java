package com.lt.frontend.home.controller;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

import com.lt.frontend.home.service.IResourceStringService;
import com.lt.frontend.home.service.impl.ResourceStringServiceImpl;
import com.lt.platform.util.Constants;

@Controller
@RequestMapping("language")
public class LanguageController
{
	@Resource
	private IResourceStringService resourceStringService;
	
	/**
	 * 语言切换
	 * 
	 * @param lanType
	 *            String lanType: 1:zh_cn 2:en_us
	 * @author devin.yang
	 */
	@RequestMapping("/setLanguage")
	@ResponseBody
	public String setLanguage(Short lanType, HttpServletRequest request) throws Exception
	{
		HttpSession session = request.getSession();
		try
		{
			Short currLanType = (Short) session.getAttribute("lanType");

			// 如果重复点击语言环境
			if (lanType == currLanType)
			{
				return Constants.SUCCESS;
			}

			resourceStringService.getResource(request);
			return Constants.SUCCESS;
		} catch (Exception e)
		{
			e.printStackTrace();
			return Constants.FAILURE;
		}
	}
}
