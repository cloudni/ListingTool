<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - Category relation</title>
	<link rel="stylesheet" type="text/css" href="${ctxPath}/js/tags/ztree/css/zTreeStyle/zTreeStyle.css" />
	<link rel="stylesheet" type="text/css" href="${ctxPath}/js/tags/ztree/css/zTreeStyle/demo.css" />
	
	<script type="text/javascript" src="${ctxPath}/js/tags/ztree/js/jquery.ztree.core-3.5.js"></script>
	<script type="text/javascript" src="${ctxPath}/js/tags/ztree/js/jquery.ztree.excheck-3.5.js"></script>
	<style type="">
		select {
			width:120px;
		}
	</style>
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
			<a href="${ctxPath }/company/transaction/list.shtml">Transaction List</a> &raquo;
			<span>Transaction Add</span>
		</div>
		<!-- breadcrumbs -->
		<form id="addForm" class="validateForm" action="${ctxPath }/company/transaction/add.shtml" method="post">
		<div class="span-22">
			<div id="content">

				<h1>Category relation</h1>
				
				<div class="zTreeDemoBackground left" style="border:1px dashed #000;width:400px;">
					<div style="padding: 5px 10px;">
					站点：
					<select id="siteId" name="siteId">
						<option value="0" selected="selected">US</option>
						<option value="100">eBayMotors</option>
						<option value="101">Italy</option>
						<option value="123">Belgium_Dutch</option>
						<option value="146">Netherlands</option>
						<option value="15">Australia</option>
						<option value="16">Austria</option>
						<option value="186">Spain</option>
						<option value="193">Switzerland</option>
						<option value="196">Taiwan</option>
						<option value="2">Canada</option>
						<option value="201">HongKong</option>
						<option value="203">India</option>
						<option value="205">Ireland</option>
						<option value="207">Malaysia</option>
						<option value="211">Canada_French</option>
						<option value="201">Philippines</option>
						<option value="212">Poland</option>
						<option value="216">Singapore</option>
						<option value="218">Sweden</option>
						<option value="223">China</option>
						<option value="23">Belgium_French</option>
						<option value="3">UK</option>
						<option value="71">France</option>
						<option value="77">Germany</option>
					</select>
					</div>
					<div style="padding: 5px 10px;">
						一级类型：
						<select id="ebay_level_1" name="ebay_level">
							<option value="">请选择</option>
						</select>
					</div>
					<div style="padding: 5px 10px;">
						二级类型：
						<select id="ebay_level_2" name="ebay_level">
							<option value="">请选择</option>
						</select>
					</div>
					<div style="padding: 5px 10px;">
						三级类型：
						<select id="ebay_level_3" name="ebay_level">
							<option value="">请选择</option>
						</select>
					</div>
					<ul id="ebayTree" class="ztree"></ul>
				</div>
				<div style="float: left;height:300px; line-height:500px;">
					<a href="javascript:void(0)" id="associatedGoogleCatetory">关联</a>
				</div>
				<div class="zTreeDemoBackground left" style="border:1px dashed #000;width:400px;">
					<div style="padding: 5px 10px;">
						一级类型：
						<select id="google_level_1" name="google_level">
							<option value="">请选择</option>
						</select>
					</div>
					<div style="padding: 5px 10px;">
						二级类型：
						<select id="google_level_2" name="google_level">
							<option value="">请选择</option>
						</select>
					</div>
					<div style="padding: 5px 10px;">
						三级类型：
						<select id="google_level_3" name="google_level">
							<option value="">请选择</option>
						</select>
					</div>
					<ul id="googleTree" class="ztree"></ul>
				</div>
			</div>
		</div>
		</form>
		<div class="clear"></div>

		<%@ include file="/common/footer.jsp"%><!-- footer -->

	</div>
	<!-- page -->

	<script type="text/javascript">
		var ebaySelectedLevel = 1;
		var googleSelectLevel = 1;
		
		function addEbayOption(msg) 
		{
			 if(msg != "") 
			 {
		    	var current_select = $("#ebay_level_" + ebaySelectedLevel);
				
		    	for(var i = 0; i < msg.length; i ++)
		    	{
		    		var obj = msg[i];
		    		if(obj.isParent == "true") 
		    		{
		    			current_select.append('<option value="' + obj.id + '">' + obj.name + '</option>');
		    		}
		    	}
			 }
		}
		
		function addGoogleOption(msg) 
		{
			 if(msg != "") 
			 {
		    	var current_select = $("#google_level_" + googleSelectLevel);
				
		    	for(var i = 0; i < msg.length; i ++)
		    	{
		    		var obj = msg[i];
		    		if(obj.isParent == "true") 
		    		{
		    			current_select.append('<option value="' + obj.id + '">' + obj.name + '</option>');
		    		}
		    	}
			 }
		}
		
		//设置字体颜色
		function setFontCss(treeId, treeNode) {
			return treeNode.assignFlag == "true" ? {color:"red"} : {};
		};
		
		//获取siteid
		function getSelectedSiteId() {
			return $("#siteId").val();
		}
		
		var ebaysetting = 
		{
			check: 
			{
				enable: true,
				chkStyle: "radio",
				radioType: "all"
			},
			async: 
			{
				enable: true,
				dataType: "json",
				url:"${ctxPath}/category/ebay/findEbayCategoryByAjax.shtml",
				autoParam: ["id"],
				otherParam: {"siteId":getSelectedSiteId}
			},
			view: {
				fontCss: setFontCss
			}
		};
		
		var googlesetting = 
		{
			check: 
			{
				enable: true,
				chkStyle: "radio",
				radioType: "all"
			},
			async: 
			{
				enable: true,
				dataType: "json",
				url:"${ctxPath}/category/ebay/findGoogleAdwordsCategoryByAjax.shtml",
				autoParam: ["id"],
				otherParam: {"siteId":$("#siteId").val()}
			},
			view: {
				fontCss: setFontCss
			}
		};
		
		//初始化树和下拉列表
		function initEbayTree(id) 
		{
			clearEbayLevelSelect(ebaySelectedLevel);
			if(id == "") return;
			$.ajax(
			{
		        type: "post",
		        data: {"id":id, "siteId":$("#siteId").val()},
		        dataType: "json",
		        url: "${ctxPath}/category/ebay/findEbayCategoryByAjax.shtml",
		        async: true,
		        success: function (data, textStatus) 
		        {
		            if (data != null) {
		                $.fn.zTree.init($("#ebayTree"), ebaysetting, data);
		                addEbayOption(data);
		            }
		        }
		    });
		} 
		
		function initGoogleTree(id) 
		{
			clearGoogleLevelSelect(googleSelectLevel);
			if(id == "") return;
			$.ajax(
			{
		        type: "post",
		        data: {"id":id, "siteId":$("#siteId").val()},
		        dataType: "json",
		        url: "${ctxPath}/category/ebay/findGoogleAdwordsCategoryByAjax.shtml",
		        async: true,
		        success: function (data, textStatus) 
		        {
		            if (data != null) {
		                $.fn.zTree.init($("#googleTree"), googlesetting, data);
		                addGoogleOption(data);
		            }
		        }
		    });
		} 
		
		//销毁下拉列表
		function clearEbayLevelSelect(index) {
			$("select[name='ebay_level']:gt(" + (parseInt(index) - 1) + ")").empty().append('<option value="">请选择</option>');
			$("select[name='ebay_level']:eq(" + (parseInt(index) - 1) + ")").empty().append('<option value="">请选择</option>');
		}
		
		function clearGoogleLevelSelect(index) {
			$("select[name='google_level']:gt(" + (parseInt(index) - 1) + ")").empty().append('<option value="">请选择</option>');
			$("select[name='google_level']:eq(" + (parseInt(index) - 1) + ")").empty().append('<option value="">请选择</option>');
		}
		
		$(document).ready(function()
		{
			initEbayTree(null);//初始化ebay一级类别
			initGoogleTree(null);//初始化google一级类别
			
			//选择站点，会触发两棵树的变化
			$("#siteId").change(function()
			{
				$.fn.zTree.destroy("ebayTree");
				ebaySelectedLevel = 1;
				initEbayTree(null);
				initGoogleTree(null);
			});
			
			//选择ebay的类型，会与下级select和树级联触发
			$("select[name='ebay_level']").change(function()
			{
				ebaySelectedLevel = $("select[name='ebay_level']").index(this) + 2;
				initEbayTree($(this).val());
			});
			
			//选择google adwords的类型，会与下级select和树级联触发
			$("select[name='google_level']").change(function()
			{
				googleSelectLevel = $("select[name='google_level']").index(this) + 2;
				initGoogleTree($(this).val());
			});
			
			//点击关联
			$("#associatedGoogleCatetory").click(function()
			{	
				var ebayCheckedId = "";
				var ebayCheckedArr=$.fn.zTree.getZTreeObj("ebayTree").getCheckedNodes(true);
	            if(ebayCheckedArr.length == 0) {
	            	alert("请选择ebay的category");
	            	return false;
	            } else {
	            	ebayCheckedId = ebayCheckedArr[0].id;
	            }
	            
	            var googleCheckedId = "";
				var googleCheckedArr=$.fn.zTree.getZTreeObj("googleTree").getCheckedNodes(true);
	            if(googleCheckedArr.length == 0) {
	            	alert("请选择google的category");
	            	return false;
	            } else {
	            	googleCheckedId = googleCheckedArr[0].id;
	            }
	            
	            $.ajax(
       			{
       		        type: "get",
       		        data: {"ebayId":ebayCheckedId, "googleId":googleCheckedId, "siteId":$("#siteId").val()},
       		        dataType: "json",
       		        url: "${ctxPath}/category/ebay/associatedGoogleCatetory.shtml",
       		        async: true,
       		        success: function (data, textStatus) 
       		        {
       		            if (textStatus == "success") {
       		            	var ebayObj = $.fn.zTree.getZTreeObj("ebayTree");
       		            	var googleObj = $.fn.zTree.getZTreeObj("googleTree");
       		            	var ebayCheckeNode = ebayObj.getCheckedNodes(true)[0];
       		            	var googleCheckedNode = googleObj.getCheckedNodes(true)[0];
       		            	
       		            	//TODO 修改名称未生效
       		            	ebayObj.getCheckedNodes(true)[0].name == "aaa";
       		            	googleCheckedNode.assignFlag == "true";
       		            	
       		            	ebayObj.updateNode(ebayObj.getCheckedNodes(true)[0]);
       		            	googleCheckedNode.updateNode(googleCheckedNode);
       		            }
       		        }
       		    });
			});
		});
	</script>
</body>
</html>
