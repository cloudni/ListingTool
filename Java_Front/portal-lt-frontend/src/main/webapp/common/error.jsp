<%@ page contentType="text/html;charset=UTF-8" isErrorPage="true"%>
<%@ include file="/common/taglibs.jsp"%>
<html>
	<head>
		<title>Error Page</title>
		<script src="<c:url value="/scripts/prototype.js"/>" type="text/javascript"></script>
		<script language="javascript">
		function showDetail()
		{
			$('detail_error_msg').toggle();
		}
	</script>
	</head>

	<body>

		<div id="content">
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<div align="center" style="color: red; font-size: 20px;">
				Network exception occurs, please try again!
			</div>
			<br>
			<button onclick="history.back();">
				Return
			</button>
			<br>
		</div>
	</body>
</html>