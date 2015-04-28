<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <%@ include file="/common/meta.jsp"%>
<title>ebay token ${ctxPath}</title>
</head>

<body>
	<input type="button" value="ebay授权" onclick="auth()"/> 
	<input type="button" value="获取token值" onclick="token()"/> 
	<input type="button" value="测试获取客户端mac地址" onclick="mac()"/> 
	<label id="sessionId"></label>
	<label id="tokenId"></label>
	<label id="tokenExp"></label>
	
<script>
	function auth(){
		/* alert(1);
		 $.ajax({url:"${ctxPath}/ebay/auth/remote.shtml",async:false,success:function(data){
			 alert(data);
			 
		 }}); */
		window.open("${ctxPath}/ebay/auth/remote.shtml?storeId=1");
		 var r=confirm("是否授权完成？")
		  if (r==true)
		    {
			  $.ajax({url:"${ctxPath}/ebay/auth/token.shtml",async:false,success:function(data){
					$("#sessionId").text(data.sessionID);
					$("#tokenId").text(data.token);
					$("#tokenExp").text(data.tokenExp);
				}});
		    }
		  else
		    {
		    alert('你已经取消授权！');
		    }
	} 
	function token(){
		$.ajax({url:"${ctxPath}/ebay/auth/token.shtml",async:false,success:function(data){
			$("#sessionId").text(data.sessionID);
			$("#tokenId").text(data.token);
			$("#tokenExp").text(data.tokenExp);
		}});
	}
	function mac(){
		$.ajax({url:"${ctxPath}/ebay/auth/mac.shtml",async:false,success:function(data){
			alert(data.ip + "=" + data.mac + "= " + data.mac1);
		}});
	}
</script>
</body>
</html>

