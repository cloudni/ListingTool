<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/bootstrap.css"/>
    <title>Item Tool Manage - Ad Change Log</title>
    <script src="http://cdn.bootcss.com/bootstrap/2.3.1/js/bootstrap-transition.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/2.3.1/js/bootstrap-modal.js"></script>
    <script>
	    function openDialog(id) {
	        $("#mymodal").modal("toggle");
	    	$("#changeLogId").val(id);
	    }
	    $(function(){
	        $("#update").click(function(){
	        	var data = "id=" + $("#changeLogId").val() + "&status=" + $("[name='status']").filter(":checked").val();
	        	$.ajax({
	        		type: 'GET',
	        		url:"${ctxPath }/marketing/adchangelog/updateStatus.shtml?" + data,
	        		success: function(data) {
	        			if (data == "1") {
	        				alert("Update successful!");
	        	            $("#mymodal").modal("toggle");
	        	            window.location.reload(true);
	        			}
	        		}
	        	});
	        });
	    });
	</script>
</head>

<body>

<div id="ajaxloading">
    <div>
        <img src="/images/load.gif" align="absmiddle" /><span>Data is loading</span>
    </div>
</div>

<div class="container" id="page">

	<%@ include file="/common/top.jsp"%>
	
	<!-- mainmenu -->
	<div class="breadcrumbs">
		<a href="${phpPath }">Home</a> &raquo; 
		<span>Ad Change Log</span>
	</div><!-- breadcrumbs -->
	
	<div class="span-23">
		<div id="content">
			<div class="search-form">
				<div class="wide form">
					<form id="searchForm" onsubmit="return validate();" action="${ctxPath }/marketing/adchangelog/getAdChangeLog.shtml" method="post">
						<div class="row">
							<label for="companyName">Company</label> 
							<input name="companyName" id="companyName" type="text" />
						</div>
						<div class="row">
							<label for="status">Status</label> 
							<select name="status" id="status">
								<option value="">All</option>
								<option value="0" selected>Pending</option>
								<option value="1">Solved</option>
	                            <option value="2">Error</option>
							</select>
						</div>
						<div class="row buttons">
							<input type="submit" name="yt0" value="Search" />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" name="clear" id="clear" value="Clear" />
						</div>
					</form>
				</div>
			</div>
			<div id="resource-string-grid" class="grid-view">
	            <%@ include file="/common/page.jsp"%>
				<table class="items">
					<thead>
						<tr>
							<th id="resource-string-grid_c0">
								<a class="sort-link" href="">ID</a>
							</th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">ObjectType</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">ObjectName</a>
                            </th>
							<th id="resource-string-grid_c0">
								<a class="sort-link" href="">Content</a>
							</th>
							<th id="resource-string-grid_c0">
								<a class="sort-link" href="">Status</a>
							</th>
							<th id="resource-string-grid_c0">
								<a class="sort-link" href="">Priority</a>
							</th>
                            <th>
                                &nbsp;
                            </th>
						</tr>
					</thead>
					<tbody>
						<c:forEach items="${page.results }" var="obj">
							<tr>
                                <td>${obj.id}</td>
							    <td>${obj.objectType}</td>
                                <td><div style="width:200px;word-wrap:break-word;">${obj.objectName}</div></td>
                                <td><div style="width:400px;word-wrap:break-word;">${obj.content}</div></td>
							    <td>
                                     <c:if test="${obj.status == 0}">Pending</c:if>
                                     <c:if test="${obj.status == 1}">Solved</c:if>
                                     <c:if test="${obj.status == 2}">Error</c:if>
                                 <td>${obj.priority }</td>
                                 <td>
                                     <a onclick="openDialog(${obj.id});">Edit</a>
                                </td>
							</tr>
							</c:forEach>
					</tbody>
				</table>
			</div>
		</div>
		<!-- content -->
</div>

	<div class="clear"></div>
	<%@ include file="/common/footer.jsp"%><!-- footer -->
</div>

<div class="modal" id="mymodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Update Status</h4>
            </div>
            <div class="modal-body">
                <span>Status:</span>
                <input type="radio" id="radio0" name="status" value="0"/><label for="radio0">Pending</label> 
				<input type="radio" id="radio1" name="status" value="1" checked="checked"/><label for="radio1">Solved</label> 
				<input type="radio" id="radio2" name="status" value="2" /><label for="radio2">Error</label> 
				<input type="hidden" name="id" id="changeLogId"></input>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                <button type="button" class="btn btn-primary" id="update">update</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
	//初始化，如果带条件的查询返回时，展开查询条件
	if("${conditionSearchFlag}" == "true") {
		var tranType = "${transaction.type }";
		if(tranType != "") {
			$("select option[value='"+ tranType +"']").attr("selected","selected");
		}
		$('.search-form').toggle();
	}
	
	//
	$("#clear").click(function() {
		$("input[type='text']").val("");
		$("select option:first").attr("selected","selected");
	});
	
});

function validate() {
	
}
/*]]>*/
</script>
</body>
</html>
