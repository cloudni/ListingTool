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
    	
        function changePlatform() {
            $("#storeId").empty();
            $("#siteIdDiv").html("");
            $("#storeId").append("<option value=''>全选</option>");
            var data = "companyId=" + $("#companyId").val() + "&platform=" + $("#platform").val();
            $.ajax({
                type: 'GET',
                url:"${ctxPath }/trackingTag/getStore.shtml?" + data,
                success: function(data) {
                    $(data).each(function(i, item) {
                        $("#storeId").append("<option value='" + item.id + "'>" + item.name + "</option>");
                    });
                }
            });
        }
        function changeStores() {
            $("#siteIdDiv").html("");
            var data = "companyId=" + $("#companyId").val() + "&platform=" + $("#platform").val() + "&storeId=" + $("#storeId").val();
            $.ajax({
                type: 'GET',
                url:"${ctxPath }/trackingTag/getSite.shtml?" + data,
                success: function(data) {
                	var siteHtml = "";
                    $(data).each(function(i, item) {
                    	siteHtml += "<input type=\"checkbox\" name=\"ebaySiteIds\" value=\"" + item.siteId + "\"/>" + item.siteName;
                    });
                    $("#siteIdDiv").html(siteHtml);
                }
            });
        }
        
        $("#companyId").change(function(){
            $("#platform").empty();
            $("#storeId").empty();
            $("#siteIdDiv").html("");
            $("#platform").append("<option value=''></option>");
            var data = "companyId=" + $("#companyId").val();
            $.ajax({
                type: 'GET',
                url:"${ctxPath }/trackingTag/getPlatform.shtml?" + data,
                success: function(data) {
                    $(data).each(function(i, item) {
                    	$("#platform").append("<option value='" + item.platform + "'>" + item.name + "</option>");
                    });
                }
            });
        });
        
        $("#platform").change(changePlatform);
        $("#storeId").change(changeStores);
        
        $("#selectFlag").change(function() {
        	if($(this).is(":checked")) {
        		$("[id^='selectFlag_child']").css("display", "");
        	} else {
        		$("[id^='selectFlag_child']").css("display", "none");
        	}
        });
        
        $("#descriptionReviseMode_Replace").click(function() {
        	if($(this).is(":checked")) {
        		$("[id^='descriptionReviseMode_Replace_']").css("display", "");
        		$("[id^='descriptionReviseMode_Append_']").css("display", "none");
        	} else {
        		$("[id^='descriptionReviseMode_Replace_']").css("display", "none");
        		$("[id^='descriptionReviseMode_Append_']").css("display", "");
        	}
        });
        
        $("#descriptionReviseMode_Append").click(function() {
        	if($(this).is(":checked")) {
        		$("[id^='descriptionReviseMode_Append_']").css("display", "");
        		$("[id^='descriptionReviseMode_Replace_']").css("display", "none");
        	} else {
        		$("[id^='descriptionReviseMode_Append_']").css("display", "none");
        		$("[id^='descriptionReviseMode_Replace_']").css("display", "");
        	}
        });
        
        $("#descriptionReviseMode_All").click(function() {
        	if($(this).is(":checked")) {
        		$("[id^='descriptionReviseMode_Append_']").css("display", "");
        		$("[id^='descriptionReviseMode_Replace_']").css("display", "");
        	}
        });
        
        $("#selectFlag").trigger("change");
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
        <span>Tracking Tag</span>
    </div><!-- breadcrumbs -->
    
    <div class="span-23">
        <div id="content">
            <div class="search-form">
                <div class="wide form">
                    <form id="searchForm" action="${ctxPath }/trackingTag/batchUpdate.shtml" method="post">
                        <div class="row">
                            <label for="companyId">User(Company):</label> 
                            <select name="companyId" id="companyId">
                                <option value="" selected>全选</option>
                                <c:forEach items="${companys }" var="obj">
                                	<option value="${obj.id}">${obj.name}</option>
                                </c:forEach>
                            </select>
                        </div>
                        <div class="row">
                            <label for="platform">Platform:</label>
                            <select name="platform" id="platform">
                                <option value=""></option>
                                <c:forEach items="${sites }" var="obj">
                                <option value="${obj.id}" selected>${obj.name}</option>
                                </c:forEach>
                            </select>
                        </div>
                        <div class="row">
                            <label for="status">Store:</label> 
                            <select name="storeId" id="storeId">
                                <option value="">全选</option>
                                <c:forEach items="${stores }" var="obj">
                                <option value="${obj.id}" selected>${obj.name}</option>
                                </c:forEach>
                            </select>
                        </div>
                        <div class="row">
                            <label for="siteId">Site:</label>
                            <div id="siteIdDiv">
                            	<c:forEach items="${sites }" var="obj"><input type="checkbox" class="checkbox" name="ebaySiteIds" value="${obj.id}"/>${obj.name}</c:forEach>
                            </div>
                            <!-- <select name="siteId" id="siteId">
                                <option value=""></option>
                                <c:forEach items="${sites }" var="obj">
                                <option value="${obj.id}" selected>${obj.name}</option>
                                </c:forEach>
                            </select> -->
                        </div>
                        <div class="row">
                            <label for="siteId">是否根据条件过滤:</label>
                            <input type="checkbox" name="selectFlag" id="selectFlag" checked="checked"/>是
                        </div>
                        <div class="row" id="selectFlag_child_1" >
                            <label for="selectDescRule">条件过滤（正则表达式）:</label>
                            <input type="radio" name="selectDescFlag" value="1" />匹配
                            <input type="radio" name="selectDescFlag" value="0" checked="checked"/>不匹配
                        </div>
                        <div class="row" id="selectFlag_child_2" >
                            <label for="selectDescRule"></label>
                            <textarea rows="3" cols="50" name="selectDescRule" id="selectDescRule">transaction.itemtool.com/portal-lt-backend/js/itemtool.min.j</textarea>
                        </div>
                        <div class="row">
                            <label for="selectDescRule">修改方式</label>
                            <input type="radio" name="descriptionReviseMode" id="descriptionReviseMode_Replace" value="Replace" />删除
                            <input type="radio" name="descriptionReviseMode" id="descriptionReviseMode_Append" value="Append" checked="checked"/>追加
                            <input type="radio" name="descriptionReviseMode" id="descriptionReviseMode_All" value="AppendAndReplace"/>删除且追加
                        </div>
                        <div class="row" id="descriptionReviseMode_Replace_1"  style="display: none;">
                        	<label for="replaceRule">删除内容（正则表达式）:</label>
                        	内容一：<textarea rows="1" cols="100" name="replaceRuleArray" ><itemtool>[\s|\S]*</itemtool></textarea>
                        </div>
                         <div class="row" id="descriptionReviseMode_Replace_1"  style="display: none;">
                        	<label for="replaceRule">删除内容（正则表达式）:</label>
                        	内容二：<textarea rows="1" cols="100" name="replaceRuleArray" ><googletag>[\s|\S]*</googletag></textarea>
                        </div>
                        <div class="row" id="descriptionReviseMode_Replace_1"  style="display: none;">
                        	<label for="replaceRule">删除内容（正则表达式）:</label>
                        	内容三：<textarea rows="1" cols="100" name="replaceRuleArray" ><itemtooltag>[\s|\S]*</itemtooltag></textarea>
                        </div>
                        <!-- <div class="row" id="descriptionReviseMode_Replace_2" >
                        	<label for="replaceRule"></label>
                        	内容二：<textarea rows="3" cols="100" name="replaceRuleArray" ><div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/[0-9].+/\?value=0&amp;guid=ON&amp;script=0"/></div></textarea>
                        </div>
                         <div class="row" id="descriptionReviseMode_Replace_3" >
                        	<label for="replaceRule"></label>
                        	内容三：<textarea rows="3" cols="100" name="replaceRuleArray"><script type="text/javascript">\s+var.*google_tag_params.*=.*\{\s+user_id.*:.*[0-9].+.*,\s+platform.*:.+,\s+store_id.*:.*[0-9].+.*,\s+site_id.*:.*[0-9].+.*\s+\};\s+</script>\s+<script type="text/javascript">\s+var.*google_conversion_id.*=.*[0-9].+;\s+var.*google_custom_params.*=.*window.google_tag_params;\s+var.*google_remarketing_only.*=.*true;\s+</script>\s+<script type="text/javascript">\s+document.write\("<sc".*\+.*"ript.*type=".*\+.*"'tex".*\+.*"t/jav".*\+.*"ascript'".*\+.*".*src='//www.googl".*\+.*"eadser".*\+.*"vices.com/pagead/conve".*\+.*"rsion.j".*\+.*"s'>".*\+.*"<".*\+.*"/sc".*\+.*"ript>"\);\s+document.write\("<nos".*\+.*"cript><div.*style='display:inline;'><img.*height='1'.*width='1'.*style='border-style:none;'.*alt=''.*src='//googleads.g.doubleclick.net/pagead/viewthroughconversion/947969982/\?value=0&.*guid=ON&.*script=0'\\/><\\/div><\\/nos".*\+.*"cript>"\);\s+</script></textarea>
                        </div> -->
                        <div class="row" id="descriptionReviseMode_Append_1">
                        	<label for="replaceTarget">tracking tag 值:</label>
                 			<textarea rows="3" cols="100" name="replaceTarget" id="replaceTarget_1">${trackingTagStr }</textarea>
                        	<!--  -->
                        </div>
                        <div class="row" id="descriptionReviseMode_Append_2">
                        	<label for="replaceTarget"></label>
                 			<textarea rows="3" cols="100" name="replaceTarget" id="replaceTarget_2">${gaStr }</textarea>
                        	<!--  -->
                        </div>
                        <div class="row buttons">
                            <input type="submit" name="yt0" value="执行" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- content -->
</div>
	<%-- <itemtool><script type="" src="${ctxPath}/js/itemtool.js?site_id=1&category_id=2&secondary_category_id=3&company_id=4&store_id=5"></script></itemtool> --%>
    <!-- <itemtool id="itemtool"><script type="text/javascript">document.write("<sc" + "ript type=" + "'tex" + "t/jav" + "ascript'" + " src='//transaction.itemtool.com/portal-lt-backend/js/itemtool.j" + "s?platform=1&site_id=2&category_id=3&secondary_category_id=4&company_id=5&store_id=6'>" + "<" + "/sc" + "ript>");</script></itemtool>
    <itemtool><script type="text/javascript">document.write("<sc" + "ript type=" + "'tex" + "t/jav" + "ascript'" + " src='//transaction.itemtool.com/portal-lt-backend/js/ga.j" + "s?tracker_code=11'>" + "<" + "/sc" + "ript>")</script></itemtool> -->
    <div class="clear"></div>
    <%@ include file="/common/footer.jsp"%><!-- footer -->
</div>

</script>
</body>
</html>
