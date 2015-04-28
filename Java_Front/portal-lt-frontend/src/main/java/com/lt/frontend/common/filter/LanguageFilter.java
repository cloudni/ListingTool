package com.lt.frontend.common.filter;

import java.io.IOException;

import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;
import javax.servlet.http.HttpServletRequest;

import com.lt.frontend.home.service.IResourceStringService;
import com.lt.platform.util.config.SpringUtil;

public class LanguageFilter implements Filter
{
	
	public void doFilter(ServletRequest req, ServletResponse resp,FilterChain chain) throws IOException, ServletException {
		IResourceStringService resourceStringService = SpringUtil.getBeanByType(IResourceStringService.class);
		resourceStringService.getResource((HttpServletRequest) req);
		chain.doFilter(req, resp);
	}

	@Override
	public void init(FilterConfig filterConfig) throws ServletException
	{
		
	}

	@Override
	public void destroy()
	{
		// TODO Auto-generated method stub
		
	}
}
