<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ taglib uri="http://java.sun.com/jstl/core_rt" prefix="c"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<jsp:include page="/common/common.jsp"></jsp:include>
<title>错误</title>
</head>
<body >
	<h3><strong>错误信息：</strong></h3>
		<h4>
			<c:if test="${empty exception }">哎呀！服务器出错!</c:if>
			<c:if test="${emsg == 'server-error' }">${emsg} : 服务器未知异常</c:if>
			<c:if test="${emsg == 'number-format' }">${emsg} : 数据转换异常</c:if>
			<c:if test="${emsg == 'null' }">${emsg} : 空指针异常</c:if>
			<c:if test="${emsg == '404' }">${emsg} : 找不到对应的资源</c:if>
		</h4>
</body>
</html>