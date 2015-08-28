<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <%@ include file="/common/meta.jsp"%>
    <title>Item Tool Manage - Campaign List</title>
<script type="text/javascript" src="${ctxPath}/js/tags/My97DatePicker/WdatePicker.js"></script>
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/bootstrap.css"/>
    <script src="http://cdn.bootcss.com/bootstrap/2.3.1/js/bootstrap-transition.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/2.3.1/js/bootstrap-modal.js"></script>
<script>

    $(function(){

        $("#update").click(function(){

            if ($("#companyId").val() == "") {
                alert("Company不能为空！");
                return false;
            }
            if ($("#name").val() == "") {
                alert("Campaign Name不能为空！");
                return false;
            }
            if (checkExist($("#name").val())) {
                alert("Campaign Name已存在，不可重复！");
                return false;
            }
            if ($("#budget").val() == "") {
                alert("Budget不能为空！");
                return false;
            }
            if ($("#startDateTimeStr").val() == "") {
                alert("Budget不能为空！");
                return false;
            }
            var url = $("#id").val() == "" ? "${ctxPath }/marketing/advertisement/createCampaign.shtml" : "${ctxPath }/marketing/advertisement/updateCampaign.shtml";
            $.ajax({
                type: 'POST',
                url:url,
                data : $("#frm1").serialize(),
                success: function(data) {
                    if (data == "1") {
                        alert("Save successful!");
                        $("#mymodal").modal("toggle");
                        window.location.reload(true);
                    } else {
                    	alert(data);
                    }
                }
            });
        });
    });
    
    function clearDialogData() {
        $("#companyId").val("");
        $("#companyName").val("");
        $("#id").val("");
        $("#name").val("");
        $("#budget").val("");
        $("#status").val("");
        $("#startDateTimeStr").val("");
        $("#endDateTimeStr").val("");
        $("#criteria").val("");
        $("#note").val("");
        orgName = "";
    }
    function openDialog(id) {
        $("#mymodal").modal("toggle");
        clearDialogData();
        if (id != null) {
            $("#id").val(id);
            $("#divId").show();
            $.ajax({
                type: 'GET',
                async:false,
                url:"${ctxPath }/marketing/advertisement/getCampaignById.shtml?id=" + id,
                success: function(data) {
                    if (data != null) {
                    	var json = eval(data);
                        $("#companyId").val(json.companyId);
                        $("#companyName").val($("#companyId").find("option:selected").text());
                        $("#id").val(json.id);
                        $("#name").val(json.name);
                        $("#budget").val(json.budget);
                        $("#status").val(json.status);
                        $("#startDateTimeStr").val(json.startDateTimeStr);
                        $("#endDateTimeStr").val(json.endDateTimeStr);
                        $("#criteria").val(json.criteria);
                        $("#note").val(json.note);
                        orgName = json.name;
                    }
                }
            });
        } else {
        	$("#divId").hide();
        }
    }
    var orgName = "";
    
    function checkExist(name) {
    	if (name == orgName) return false;
        var exist = false;
        $.ajax({
            type: 'GET',
            async:false,
            url:"${ctxPath }/marketing/advertisement/checkCampaignExist.shtml",
            data : $("#frm1").serialize(),
            success: function(data) {
                if (data == "1") {
                	exist = true;
                }
            }
        });
        return exist;
    }
    
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
        <span>Campaign</span>
    </div><!-- breadcrumbs -->
    
    <div class="span-23">
        <div id="content">
            <div class="search-form">
                <div class="wide form">
                    <form action="${ctxPath }/marketing/advertisement/getCampaignList.shtml" method="post">
                        <div class="row">
                            <label for="companyIdSearch">Company</label> 
                            <select name="companyId" id="companyIdSearch">
                                <option value="" selected></option>
                                <c:forEach items="${companys }" var="obj">
                                <option value="${obj.id}" <c:if test="${obj.id==page.companyId}">selected</c:if>>${obj.name}</option>
                                </c:forEach>
                            </select>
                        </div>
                        <div class="row buttons">
                            <input type="submit" name="yt0" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
            <div id="resource-string-grid" class="grid-view">
                <a onclick="openDialog(null);" >Add</a>
                <%@ include file="/common/page.jsp"%>
                <table class="items">
                    <thead>
                        <tr>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">ID</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Campaign</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Budget</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Status</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Start Date</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">End Date</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Criteria</a>
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
                                <td>${obj.name}</td>
                                <td>${obj.budget}</td>
                                <td>
                                     <c:if test="${obj.status == 0}">UNKNOWN</c:if>
                                     <c:if test="${obj.status == 1}">ENABLED</c:if>
                                     <c:if test="${obj.status == 2}">PAUSED</c:if>
                                     <c:if test="${obj.status == 3}">REMOVED</c:if>
                                </td>
                                <td>${obj.startDateTimeStr}</td>
                                <td>${obj.endDateTimeStr}</td>
                                <td><div style="width:500px;word-wrap:break-word;">${obj.criteria}</div></td>
                                <td><a onclick="openDialog(${obj.id});">Edit</a></td>
                            </tr>
                            </c:forEach>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- content -->
</div>


<div class="modal" id="mymodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Campaign</h4>
            </div>
            <div class="modal-body">
                <div class="wide form">
                    <form id="frm1" action="${ctxPath }/marketing/advertisement/updateCampaign.shtml" method="post">
                        <div id="divId" class="row">
                            <label for="id">ID</label> 
                            <input name="id" id="id" type="text" readonly="readonly" />
                        </div>
                        <div class="row">
                            <label for="companyId">Company</label> 
                            <select name="companyId" id="companyId">
                                <option value=""></option>
                                <c:forEach items="${companys }" var="obj">
                                <option value="${obj.id}">${obj.name}</option>
                                </c:forEach>
                            </select>
                            <input type="hidden" id="companyName" name="companyName"></input>
                        </div>
                        <div class="row">
                            <label for="name">Campaign</label> 
                            <input name="name" id="name" type="text" style="width: 300px" maxlength="100" />
                        </div>
                        <div class="row">
                            <label for="budget">Budget</label>
                            <input name="budget" id="budget" type="text" onkeyup="if(isNaN(this.value)) {this.value = this.value.substring(0,this.value.length - 1);return false;}" onafterpaste="if(isNaN(this.value)) execCommand('undo')"  />
                        </div>
                        <div class="row">
                            <label for="status">Status</label> 
                            <select name="status" id="status">
                                <option value="0">UNKNOWN</option>
                                <option value="1">ENABLED</option>
                                <option value="2">PAUSED</option>
                                <option value="3">REMOVED</option>
                            </select>
                        </div>
                        <div class="row">
                            <label for="startDateTimeStr">Start DateTime</label>
                            <input name="startDateTimeStr" id="startDateTimeStr" type="text" class="Wdate" readonly="readonly" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd'})" />
                        </div>
                        <div class="row">
                            <label for="endDateTimeStr">End DateTime</label>
                            <input name="endDateTimeStr" id="endDateTimeStr" type="text" class="Wdate" readonly="readonly" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd'})" />
                        </div>
                        <div class="row">
                            <label for="criteria">Criteria</label> 
                            <textarea name="criteria" id="criteria" type="text" cols=50 rows=7 ></textarea>
                        </div>
                        <div class="row">
                            <label for="note">Note</label> 
                            <textarea name="note" id="note" type="text" cols=50 rows=2 ></textarea>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="update">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <div class="clear"></div>
    <%@ include file="/common/footer.jsp"%><!-- footer -->
</div>

</script>
</body>
</html>
