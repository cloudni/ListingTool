<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<%@taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title></title>
</head>

<body>
<h1>cookie 信息</h1>
<hr />
	<%
		Cookie cookies[]=request.getCookies(); //读出用户硬盘上的Cookie，并将所有的Cookie放到一个cookie对象数组里面
		Cookie sCookie=null; 
		for(Cookie cookie : cookies){    //用一个循环语句遍历刚才建立的Cookie对象数组
			out.println(cookie.getName()+"-"+cookie.getValue());
			out.println("<hr/>");
		}
	%>
	<hr />
	
<h1>cookie 结束</h1>
</body>
</html>

