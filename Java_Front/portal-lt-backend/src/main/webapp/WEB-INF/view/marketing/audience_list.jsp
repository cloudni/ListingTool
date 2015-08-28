<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <%@ include file="/common/meta.jsp"%>
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/bootstrap.css"/>
    <title>Item Tool Manage - Audience List</title>
<script>
    $(function(){
    	$("#clear").click(function(){
            $("#id").val("");
            $("#name").val("");
            $("#companyId").val("");
            $("#platform").val("");
            $("#storeId").val("");
            $("#siteId").val("");
            $("#rule").val("");
            $("#update").attr("disabled", true);
    	});
    	
    	function setAudiencesName() {
    		var rule = "";
    		var name = "";
    		if ($("#companyId").val() != "") {
    			name += "_company" + $("#companyId").val();
    			rule += ",\n  company_id:" + $("#companyId").val();
    		}
            if ($("#platform").val() != "") {
                name += "_platform" + $("#platform").val();
                rule += ",\n  platform:" + $("#platform").val();
            }
            if ($("#storeId").val() != "") {
                name += "_store" + $("#storeId").val();
                rule += ",\n  store_id:" + $("#storeId").val();
            }
            if ($("#siteId").val() != "") {
                name += "_site" + $("#siteId").val();
                rule += ",\n  site_id:" + $("#siteId").val();
            }
            if (name.length > 0) {
            	$("#name").val(name.substring(1));
                $("#rule").val("{" + rule.substring(1) + "\n}");
            }
    	}
    	
    	function changeCompany() {
            $("#platform").empty();
            $("#platform").append("<option value=''></option>");
            var data = "companyId=" + $("#companyId").val();
            $.ajax({
                type: 'GET',
                url:"${ctxPath }/marketing/audience/getPlatform.shtml?" + data,
                success: function(data) {
                    $(data).each(function(i, item) {
                        $("#platform").append("<option value='" + item.platform + "'>" + item.name + "</option>");
                    });
                }
            });
            changePlatform();
        }
    	
        function changePlatform() {

            $("#storeId").empty();
            $("#storeId").append("<option value=''></option>");
            var data = "companyId=" + $("#companyId").val() + "&platform=" + $("#platform").val();
            $.ajax({
                type: 'GET',
                url:"${ctxPath }/marketing/audience/getStore.shtml?" + data,
                success: function(data) {
                    $(data).each(function(i, item) {
                        $("#storeId").append("<option value='" + item.id + "'>" + item.name + "</option>");
                    });
                }
            });
            changeStores();
        }
        function changeStores() {

            $("#siteId").empty();
            $("#siteId").append("<option value=''></option>");
            var data = "companyId=" + $("#companyId").val() + "&platform=" + $("#platform").val() + "&storeId=" + $("#storeId").val();
            $.ajax({
                type: 'GET',
                url:"${ctxPath }/marketing/audience/getSite.shtml?" + data,
                success: function(data) {
                    $(data).each(function(i, item) {
                        $("#siteId").append("<option value='" + item.siteId + "'>" + item.siteName + "</option>");
                    });
                }
            });
            setAudiencesName();
        }
        
        $("#companyId").change(changeCompany);
        $("#platform").change(changePlatform);
        $("#storeId").change(changeStores);
        $("#siteId").change(setAudiencesName);
        
        changeCompany();
    });
    
    function checkExist(name) {
    	var submit = true;
    	$.ajax({
            type: 'GET',
            async:false,
            url:"${ctxPath }/marketing/audience/checkExist.shtml",
            data : $("#frm1").serialize(),
            success: function(data) {
                if (data == "1") {
                	submit = false;
                    alert("此规则已存在，不可重复");
                } else if (data != "0") {
                    submit = false;
                    alert(data);
                }
            }
        });
    	return submit;
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
        <span>Audience</span>
    </div><!-- breadcrumbs -->
    
    <div class="span-23">
        <div id="content">
            <div class="search-form">
                <div class="wide form">
                    <form id="frm1" action="${ctxPath }/marketing/audience/createAudience.shtml" method="post">
                        <div class="row">
                            <input name="id" id="id" type="hidden"/>
                            <label for="name">Audiences Name</label> 
                            <input name="name" id="name" type="text" style="width: 300px" readonly="readonly" />
                        </div>
                        <div class="row">
                            <label for="companyId">User(Company)</label> 
                            <select name="companyId" id="companyId">
                                <option value="" selected></option>
                                <c:forEach items="${companys }" var="obj">
                                <option value="${obj.id}">${obj.name}</option>
                                </c:forEach>
                            </select>
                        </div>
                        <div class="row">
                            <label for="platform">Platform</label>
                            <select name="platform" id="platform">
                                <option value=""></option>
                                <c:forEach items="${sites }" var="obj">
                                <option value="${obj.id}" selected>${obj.name}</option>
                                </c:forEach>
                            </select>
                        </div>
                        <div class="row">
                            <label for="status">Store</label> 
                            <select name="storeId" id="storeId">
                                <option value=""></option>
                                <c:forEach items="${stores }" var="obj">
                                <option value="${obj.id}" selected>${obj.name}</option>
                                </c:forEach>
                            </select>
                        </div>
                        <div class="row">
                            <label for="siteId">Site</label> 
                            <select name="siteId" id="siteId">
                                <option value=""></option>
                                <c:forEach items="${sites }" var="obj">
                                <option value="${obj.id}" selected>${obj.name}</option>
                                </c:forEach>
                            </select>
                        </div>
                        <div class="row">
                            <label for="name">Rule</label> 
                            <textarea name="rule" id="rule" type="text" rows=5 cols=60 ></textarea>
                        </div>
                        <div class="row buttons">
                            <input type="submit" onclick="return checkExist(name.value);" id="create" value="Create" />
                            <input type="submit" onclick="return checkExist(name.value, id.value);" id="update" value="Update" />
                            <input type="button" onclick="" id="clear" value="Clear" />
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
                                <a class="sort-link" href="">Audience Name</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Rule</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Is Run</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <c:forEach items="${page.results }" var="obj">
                            <tr>
                                <td>${obj.pkId}</td>
                                <td>${obj.name}</td>
                                <td><div style="width:200px;word-wrap:break-word;">${obj.rule}</div></td>
                                <td>
                                     <c:if test="${obj.isRun == false}">False</c:if>
                                     <c:if test="${obj.isRun == true}">True</c:if>
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

</script>
</body>
</html>
