<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
	<script  type="text/javascript">
		
		function upload() {
            var fileObj = document.getElementById("logoId").files[0];
            var FileController = "http://localhost:8080/portal-lt-frontend/adwords/upload.shtml";

            var form = new FormData();
            form.append("file", fileObj);

            var xhr = new XMLHttpRequest();
            xhr.open("post", FileController, true);
            xhr.onload = function () {
                alert(xhr.responseText + ":上传成功");
            };
            xhr.send(form);
        }
        
	</script>
</head>

<body>

	<input type="file" id="logoId" name="file" value="上传" onchange="upload();" style="display:none">
	<input type="button" id="testUpload" value="Test Ajax Upload" onclick="logoId.click();">
</body>
</html>
