package com.lt.backend.home.controller;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.lt.backend.home.service.IUserService;
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

	@RequestMapping("index")
	public ModelAndView index(HttpServletRequest request) throws Exception
	{
		ModelAndView model = new ModelAndView("list");
		return model;
	}

	@RequestMapping("login")
	public ModelAndView login(HttpServletResponse response,HttpServletRequest request,String userName,String password) throws Exception
	{
		ModelAndView model = new ModelAndView("login");
		
		/**验证参数是否有效*/
		if(StringUtil.isBlank(userName) || StringUtil.isBlank(password)){
			model.addObject("login_invalid_error", "username or password fail!");
		}else{
			
			/**验证是否输入正确*/
			boolean isLogin = userService.isLogin(userName, password);
			if(isLogin){
				
				model = new ModelAndView("redirect:/index.shtml");
				
				String newToken = SecretUtil.secretMD5(userName + SSOClientFilter.getSecretKey());
				SSOClientUtil.setCookie(response, SSOClientUtil.TOKEN_CODE_KEY, newToken, SSOClientFilter.getSessionInvalid());
				SSOClientUtil.setCookie(response, SSOClientUtil.ACCOUNT_NO_KEY, SecretUtil.getBase64(userName), SSOClientFilter.getSessionInvalid());
				SSOClientFilter.isLoginUserAdmin(request, userName);
			}else{
				model.addObject("login_invalid_error", "username or password fail!");
			}
		}
		
		
		return model;
	}
	

	@RequestMapping("logout")
	public ModelAndView logout(HttpServletResponse response,HttpServletRequest request) throws Exception
	{
		ModelAndView model = new ModelAndView("redirect:http://www.itemtool.com");
		SSOClientUtil.clearUser(response, request);
		return model;
	}
	@RequestMapping("detail")
	public ModelAndView detail() throws Exception{
		ModelAndView model = new ModelAndView("detail");
		return model;
	}
}
