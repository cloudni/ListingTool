<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <%@ include file="/common/meta.jsp"%>
    <title>Item Tool Manage - AD Advertise Variation List</title>
    <script type="text/javascript" src="${ctxPath}/js/tags/My97DatePicker/WdatePicker.js"></script>
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/bootstrap.css"/>
    <style>
        .text input {
            width: 400px;
        }
    </style>
    <script src="http://cdn.bootcss.com/bootstrap/2.3.1/js/bootstrap-transition.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/2.3.1/js/bootstrap-modal.js"></script>
	<script type="text/javascript" src="${ctxPath}/js/tags/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript">
	   
	    $(document).ready(function(){
    	    $("#companyIdSearch").change(changeCompanySearch);
            $("#campaignIdSearch").change(changeCampaignSearch);
            $("#companyId").change(changeCompany);
            $("#adCampaignId").change(changeCampaign);
            changeCompanySearch();
            $("#campaignIdSearch").val("${page.adCampaignId}");
            $("#groupIdSearch").val("${page.adGroupId}");

            $("#updateAdVariation").click(function(){

                var url = "${ctxPath }/marketing/advertisement/updateAdVariation.shtml";
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
	
	    function changeCompanySearch() {
	        $("#campaignIdSearch").empty();
            $("#campaignIdSearch").append("<option value=''></option>");
	        var data = "companyId=" + $("#companyIdSearch").val();
	        $.ajax({
	            type: 'GET',
	            async: false,
	            url:"${ctxPath }/marketing/advertisement/getCampaignListByCompany.shtml?" + data,
	            success: function(data) {
	                $(data).each(function(i, item) {
	                    $("#campaignIdSearch").append("<option value='" + item.id + "'>" + item.name + "</option>");
	                });
	            }
	        });
	        changeCampaignSearch();
	    }
        function changeCampaignSearch() {
            $("#groupIdSearch").empty();
            $("#groupIdSearch").append("<option value=''></option>");

            var data = "adCampaignId=" + $("#campaignIdSearch").val();
            $.ajax({
                type: 'GET',
                async: false,
                url:"${ctxPath }/marketing/advertisement/getGroupListBySelective.shtml?" + data,
                success: function(data) {
                    $(data).each(function(i, item) {
                        $("#groupIdSearch").append("<option value='" + item.id + "'>" + item.name + "</option>");
                    });
                }
            });
        }
    
        function changeCompany() {
        	$("#adCampaignId").empty();
            if ($("#companyId").val() == "") {
                return;
            }
            var data = "companyId=" + $("#companyId").val();
            $.ajax({
                type: 'GET',
                async: false,
                url:"${ctxPath }/marketing/advertisement/getCampaignListByCompany.shtml?" + data,
                success: function(data) {
                    $(data).each(function(i, item) {
                        $("#adCampaignId").append("<option value='" + item.id + "'>" + item.name + "</option>");
                    });
                }
            });
        }
        function changeCampaign() {
            $("#adGroupId").empty();
            if ($("#adCampaignId").val() == "") {
                return;
            }
            var data = "adCampaignId=" + $("#adCampaignId").val();
            $.ajax({
                type: 'GET',
                async: false,
                url:"${ctxPath }/marketing/advertisement/getGroupListBySelective.shtml?" + data,
                success: function(data) {
                    $(data).each(function(i, item) {
                        $("#adGroupId").append("<option value='" + item.id + "'>" + item.name + "</option>");
                    });
                }
            });
        }
        

        
        function clearDialogData() {
            $("#adAdvertiseId").val("");
            $("#companyId").val("");
            $("#companyName").val("");
            $("#adCampaignId").val("");
            $("#campaignName").val("");
            $("#adGroupId").val("");
            $("#groupName").val("");
            $("#adName").val("");
            $("#criteria").val("");
            $("#displayUrl").val("");
            $("#landingPage").val("");
        }
        function openDialog(adAdvertiseId) {
            $("#mymodal").modal("toggle");
            clearDialogData();
            changeCompany();
            if (adAdvertiseId != null) {
                $("#adAdvertiseId").val(adAdvertiseId);
                $("#divId").show();
                $.ajax({
                    type: 'GET',
                    async:false,
                    url:"${ctxPath }/marketing/advertisement/getAdVariationByAdId.shtml?adAdvertiseId=" + adAdvertiseId,
                    success: function(data) {
                        if (data != null) {
                            var json = eval(data);
                            $("#adAdvertiseId").val(json.adAdvertiseId);
                            $("#companyId").val(json.companyId);
                            $("#companyName").val(json.companyName);
                            $("#adCampaignId").val(json.adCampaignId);
                            $("#campaignName").val(json.campaignName);
                            $("#adGroupId").val(json.adGroupId);
                            $("#groupName").val(json.groupName);
                            $("#adName").val(json.adName);
                            $("#criteria").val(json.criteria);
                            $("#displayUrl").val(json.displayUrl);
                            $("#landingPage").val(json.landingPage);
                        }
                    }
                });
            } else {
                $("#divId").hide();
            }
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
        <span>AD Advertise Variation</span>
    </div><!-- breadcrumbs -->

    <div class="span-23">

<div id="ad_variation_tab" style="clear: both; width: 100%; position: relative; top: -5px; ">
    <div class="borderBlock">
        <div class="search-form">
            <div class="wide form">
                <form action="${ctxPath }/marketing/advertisement/getAdVariationList.shtml" method="post">
                    <div class="row">
                        <label for="companyIdSearch">Company</label> 
                        <select name="companyId" id="companyIdSearch">
                            <option value="" selected></option>
                            <c:forEach items="${companys }" var="obj">
                            <option value="${obj.id}" <c:if test="${obj.id==page.companyId}">selected</c:if>>${obj.name}</option>
                            </c:forEach>
                        </select>
                    </div>
                    <div class="row">
                        <label for="campaignIdSearch">Campaign</label> 
                        <select name="adCampaignId" id="campaignIdSearch">
                            <option value="" selected></option>
                        </select>
                    </div>
                    <div class="row">
                        <label for="groupIdSearch">Group</label> 
                        <select name="adGroupId" id="groupIdSearch">
                            <option value="" selected></option>
                        </select>
                    </div>
                    <div class="row buttons">
                        <input type="submit" name="yt0" value="Search" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="borderBlock">
        <div id="content">
            <div id="resource-string-grid" class="grid-view">
                <%@ include file="/common/page.jsp"%>
                <table class="items">
                    <thead>
                        <tr>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">AD ID</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Ad Name</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Group</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Criteria</a>
                            </th>
                            <th id="resource-string-grid_c0">
                                <a class="sort-link" href="">Price</a>
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <c:forEach items="${page.results }" var="obj">
                            <tr>
                                <td>${obj.adAdvertiseId}</td>
                                <td title="${obj.companyName}->${obj.campaignName}->${obj.groupName}->${obj.adName}">${obj.adName}</td>
                                <td>${obj.groupName}</td>
                                <td>${obj.criteria}</td>
                                <td><a onclick="openDialog(${obj.adAdvertiseId});">Edit</a></td>
                            </tr>
                        </c:forEach>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
        <!-- content -->
</div>


<div class="modal" id="mymodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">AD Advertise Variation</h4>
            </div>
            <div class="modal-body"  style="overflow:auto;height:70%;">
                <div class="wide form">
                    <form id="frm1" action="${ctxPath }/marketing/advertisement/updateGroup.shtml" method="post">
                        <div id="divId" class="row text">
                            <label for="id">AD ID</label> 
                            <input type="text" id="adAdvertiseId" name="adAdvertiseId" readonly="readonly"></input>
                        </div>
                        <div class="row text">
                            <label for="companyName">Company</label>
                            <input type="text" id="companyName" name="companyName" readonly="readonly"></input>
                            <input type="hidden" id="companyId" name="companyId"></input>
                        </div>
                        <div class="row text">
                            <label for="adCampaignId">Campaign</label> 
                            <input type="text" id="campaignName" name="campaignName" readonly="readonly"></input>
                            <input type="hidden" id="adCampaignId" name="adCampaignId"></input>
                        </div>
                        <div class="row text">
                            <label for="name">Group</label> 
                            <input type="text" id="groupName" name="groupName" readonly="readonly"></input>
                            <input type="hidden" id="adGroupId" name="adGroupId"></input>
                        </div>
                        <div class="row text">
                            <label for="name">AD Name</label> 
                            <input type="text" id="adName" name="adName" readonly="readonly"></input>
                        </div>
                        <div class="row text">
                            <label for="name">Criteria</label> 
                            <textarea id="criteria" name="criteria" rows=9 cols=51></textarea>
                        </div>
                        <div class="row text">
                            <label for="name">Display Url</label> 
                            <input type="text" id="displayUrl" name="displayUrl"></input>
                        </div>
                        <div class="row text">
                            <label for="name">Landing Page</label> 
                            <input type="text" id="landingPage" name="landingPage"></input>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateAdVariation">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <div class="clear"></div>
    <%@ include file="/common/footer.jsp"%><!-- footer -->
</div>

</body>
</html>

