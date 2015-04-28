package com.lt.frontend.home.controller;

import javax.annotation.Resource;
import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.lt.frontend.home.service.IResourceStringService;
import com.lt.frontend.user.service.IUserService;
import com.lt.platform.util.lang.StringUtil;
import com.lt.platform.util.secret.SecretUtil;
import com.ssoclient.filter.SSOClientFilter;
import com.ssoclient.utils.SSOClientUtil;

@Controller
@RequestMapping
public class HomeController
{

	@Resource
	private IUserService userService;
	@Resource
	private IResourceStringService resourceStringService;

	@RequestMapping("index")
	public ModelAndView index(HttpServletRequest request) throws Exception
	{
		ModelAndView model = new ModelAndView("index");
		//new LanguageController().getResource(model, request);
		return model;
	}

	@RequestMapping("login")
	public ModelAndView login(HttpServletResponse response,HttpServletRequest request,String userName,String password,String tid,String ctl00$ContentPlaceHolder1$RandomCode1$txtValidateCode) throws Exception
	{
		ModelAndView model = new ModelAndView("login");
		
		/**妤��������������澶��*/
		if(StringUtil.isBlank(userName) || StringUtil.isBlank(password)){
			model.addObject("login_invalid_error", "username or password fail!");
		}else{
			
			/**妤��������������锝��*/
			boolean isLogin = userService.isLogin(userName, password);
			if(isLogin){
				
				model = new ModelAndView("redirect:/index.shtml");
				
				String newToken = SecretUtil.secretMD5(userName + SSOClientFilter.getSecretKey());
				SSOClientUtil.setCookie(response, SSOClientUtil.TOKEN_CODE_KEY, newToken, SSOClientFilter.getSessionInvalid());
				SSOClientUtil.setCookie(response, SSOClientUtil.ACCOUNT_NO_KEY, SecretUtil.getBase64(userName), SSOClientFilter.getSessionInvalid());
				SSOClientFilter.isLoginUser(request, userName);
			}else{
				model.addObject("login_invalid_error", "username or password fail!");
			}
		}
		
		// 缁��娅�ぐ�冲�session �ヤ�妾���у棘��拷
		/*request.getSession().removeAttribute("session");
		request.getSession().removeAttribute("lanType");*/
		//resourceStringService.getResource(request);
		
		return model;
	}
	

	@RequestMapping("logout")
	public ModelAndView logout(HttpServletResponse response,HttpServletRequest request) throws Exception
	{
		ModelAndView model = new ModelAndView("redirect:http://www.itemtool.com/index.php/site/logout.html");
		SSOClientUtil.clearUser(response, request);
		return model;
	}

	@RequestMapping("demo1")
	public ModelAndView testCookie(HttpServletRequest request,
			HttpServletResponse response) throws Exception
	{

		Cookie cookie = new Cookie("cookiename_", "cookievalue_");
		cookie.setPath("/");
		response.addCookie(cookie);

		Cookie cookieDemo = new Cookie("demo1key-abc.com", "demo1value-abc.com");
		cookieDemo.setDomain("abc.com");
		cookieDemo.setMaxAge(3600);
		cookieDemo.setPath("/");
		response.addCookie(cookieDemo);

		Cookie cookieDemo1 = new Cookie("demo1key-www.abc.com",
				"demo1value-www.abc.com");
		cookieDemo1.setDomain("www.abc.com");
		cookieDemo1.setMaxAge(3600);
		cookieDemo1.setPath("/");
		response.addCookie(cookieDemo1);

		return new ModelAndView("testCookie");
	}

	@RequestMapping("demo2")
	public ModelAndView demo2(HttpServletRequest request,
			HttpServletResponse response) throws Exception
	{
		return new ModelAndView("testCookie");
	}
}
