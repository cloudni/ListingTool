package com.lt.backend.home.filter;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang.StringUtils;

import com.ssoclient.utils.SSOClientUtil;

public class LoginFilter implements Filter
{

	/*过滤地址*/
	private List<String> excludePathList = Collections.synchronizedList(new ArrayList<String>());
	private List<String> excludeFileList = Collections.synchronizedList(new ArrayList<String>());

	public void init(FilterConfig filterConfig) throws ServletException 
	{
		
		String loadExcludePaths = filterConfig.getInitParameter("excludePath");
		if(StringUtils.isNotBlank(loadExcludePaths)){
			arrayConvertList(loadExcludePaths, excludePathList);
		}
		
		String loadexcludeFiles = filterConfig.getInitParameter("excludeFile");
		if(StringUtils.isNotBlank(loadExcludePaths)){
			arrayConvertList(loadexcludeFiles, excludeFileList);
		}
		
	}

	public void doFilter(ServletRequest req, ServletResponse resp,FilterChain chain) throws IOException, ServletException 
	{
		HttpServletRequest request = (HttpServletRequest) req;
		HttpServletResponse response = (HttpServletResponse) resp;

		/**校验是否特殊地址    排除[excludePath、excludeFile]*/
		if(SSOClientUtil.isVerifyRequestURI(excludeFileList,request) || SSOClientUtil.isVerifyRequestURI(excludePathList,request)){
			chain.doFilter(request, response);
			return;
		}
		
		
		
		chain.doFilter(request, response);
	}

	public void destroy() {
		excludePathList.clear();
		excludeFileList.clear();
	}
	
	/**
	 * 数组转集合
	 * @param arrays
	 * @param addlist
	 */
	private void arrayConvertList(String arrays , List<String> addlist){
		String[] analyArrays = arrays.split(",");
		for(String path : analyArrays){
			addlist.add(path);
		}
	}
	

}
