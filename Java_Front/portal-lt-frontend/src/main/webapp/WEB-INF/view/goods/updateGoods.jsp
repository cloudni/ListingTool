<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - 新建商品</title>
</head>

<body>
<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${phpPath }">首页</a> &raquo; <a href="${phpPath }/store/index">商品</a> &raquo; <span>新建</span></div><!-- breadcrumbs -->
	
    
<div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw0">
<div class="portlet-decoration">
<div class="portlet-title">操作</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw1">
<li><a href="${ctxPath}/goods/listGoods.shtml">商品列表</a></li>
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">新建商品</h1>
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
            <label for="Store_platform" class="required">SiteID: <span class="required">*</span></label>        </div>
        <div class="row left">
            <select id="platform_selector" onChange="updatePlatformPanel()" name="Store[platform]">
				<option value="0" selected="selected">US</option>
				<option value="1">UK</option>
				<option value="1">Germary</option>
				<option value="1">Canada</option>
			</select>
		</div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Title: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Category: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_platform" class="required">Listing Type: <span class="required">*</span></label>        </div>
        <div class="row left">
            <select id="platform_selector" onChange="updatePlatformPanel()" name="Store[platform]">
				<option value="1">Chinese</option>
				<option value="1">Duch</option>
				<option value="1">Live</option>
			</select>
		</div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Quantity: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">LotSize: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_platform" class="required">Duration: <span class="required">*</span></label>        </div>
        <div class="row left">
            <select id="platform_selector" onChange="updatePlatformPanel()" name="Store[platform]">
				<option value="1">3 days</option>
				<option value="1">5 days</option>
				<option value="1">7 days</option>
				<option value="1">10 days</option>
				<option value="1">30 days</option>
				<option value="1">GTC</option>
			</select>
		</div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">StartPrice: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">ReservePrice: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">BIN Price: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_platform" class="required">Condition: <span class="required">*</span></label>        </div>
        <div class="row left">
            <select id="platform_selector" onChange="updatePlatformPanel()" name="Store[platform]">
				<option value="0" selected="selected">New</option>
				<option value="1">Used</option>
			</select>
		</div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">PayPalEmail: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">AutoPay: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input name="Store[name]" id="Store_name" type="radio" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Border: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input name="Store[name]" id="Store_name" type="radio" />
        </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">PostalCode: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">VATPercent: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">BoldTitle: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input name="Store[name]" id="Store_name" type="radio" />
        </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Best Offer: <span class="required">*</span></label>        </div>
        <div class="row left">
            
        </div>
    </div>
    <hr/>
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Description: <span class="required">*</span></label>        </div>
        <div class="row left">
            <textarea rows="6" cols="60"></textarea>
        </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Location: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="160" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Picture files for the item: <span class="required">*</span></label>        </div>
        <div class="row left">
            <textarea rows="6" cols="47"></textarea>
        </div>
        <div><br/><br/><br/>
        	<input name="Store[name]" id="Store_name" type="button" value="Add" />
        	<br/>
            <input name="Store[name]" id="Store_name" type="button" value="Remove" />
        </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Payment Profile ID: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Return Profile ID: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Shipping Profile ID: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Payment Profile Name: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Return Profile Name: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
    </div>
    
    <div class="container">
        <div class="row left span-4">
            <label for="Store_name" class="required">Shipping Profile Name: <span class="required">*</span></label>        </div>
        <div class="row left">
            <input size="60" maxlength="256" name="Store[name]" id="Store_name" type="text" />                    </div>
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
            <input class="greenButton" style="font-size: 12px; width: 100px;" type="submit" name="yt0" value="ReviseGoods" />
        </div>
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
