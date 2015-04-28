<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - 新建商店</title>
</head>

<body>
<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${phpPath }">首页</a> &raquo; <a href="${phpPath }/store/index">商店</a> &raquo; <span>新建</span></div><!-- breadcrumbs -->
	
    
<div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw0">
<div class="portlet-decoration">
<div class="portlet-title">操作</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw1">
<li><a href="${ctxPath}/themes/facebook/views/index/listStore.jsp">商店列表</a></li>
</ul></div>
</div>        </div><!-- sidebar -->
    </div>
    

    <div class="span-19" style="margin-right: 0px; width: 800px;">
        <div id="content">
            
<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">新建商店</h1>
                </div>
            </div>
            <div style="display: block; padding: 0px 10px 0px 10px;">
                


<style>
    .platform{ display: none; }
</style>

<div class="form">

<form id="store-form" action="${phpPath }/store/create" method="post">
	<p class="note">带<span class="required"> * </span> 字段是必填项</p>

	
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">名称 <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>

    <div class="container">
        <div class="row left span-4">
            <label for="Store_platform" class="required">平台 <span class="required">*</span></label>        </div>
        <div class="row left">
            <select id="platform_selector" onChange="updatePlatformPanel()" name="Store[platform]">
<option value="">Please select store platform</option>
<option value="1" selected="selected">eBay.com</option>
</select>                    </div>
    </div>

    <div id="platform_1" class="platform">
        <div class="container">
            <div class="row left span-4">
                <label for="Store_ebay_site_code">eBay Site Code</label>            </div>
            <div class="row left">
                <select name="Store[ebay_site_code]" id="Store_ebay_site_code">
<option value="0">US</option>
<option value="100">eBayMotors</option>
<option value="101">Italy</option>
<option value="123">Belgium Dutch</option>
<option value="146">Netherlands</option>
<option value="15">Australia</option>
<option value="16">Austria</option>
<option value="186">Spain</option>
<option value="193">Switzerland</option>
<option value="2">Canada</option>
<option value="201">HongKong</option>
<option value="203">India</option>
<option value="205">Ireland</option>
<option value="207">Malaysia</option>
<option value="210">Canada French</option>
<option value="211">Philippines</option>
<option value="212">Poland</option>
<option value="216">Singapore</option>
<option value="23">Belgium French</option>
<option value="3">UK</option>
<option value="71">France</option>
<option value="77">Germany</option>
</select>                            </div>
        </div>
                <div class="container">
            <div class="row left">
                <label>After submit, we will redirect you to eBay to authorize, so we could access your data and do our job.</label>            </div>
        </div>
    </div>

    <div id="platform_3" class="platform">
    </div>

    <div id="platform_2" class="platform">
    </div>

    <div id="platform_5" class="platform">
    </div>

    <div id="platform_6" class="platform">
    </div>

    <div id="platform_4" class="platform">
    </div>

    <div class="container">
        <div class="row left span-4">
            &nbsp;
        </div>
        <div class="row left">
            <input class="greenButton" style="font-size: 12px; width: 70px;" type="submit" name="yt0" value="新建" />        </div>
    </div>

</form>
</div><!-- form -->

<script>
    $(function(){
        updatePlatformPanel();
    });

    function updatePlatformPanel()
    {
        $("div[id^='platform']").addClass("platform");
        $("#platform_"+$("#platform_selector").val()).removeClass("platform");
    }
</script>            </div>
        </div>
    </div>
</div>        </div><!-- content -->
    </div>

	<%@ include file="/common/footer.jsp"%>

</div><!-- page -->
</body>
</html>
