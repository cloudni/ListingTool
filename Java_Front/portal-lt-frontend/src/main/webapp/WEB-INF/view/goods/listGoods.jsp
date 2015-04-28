<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - 商品</title>
</head>

<body>

<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${phpPath }">首页</a> &raquo; <span>商品</span></div><!-- breadcrumbs -->
	
    
<div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw0">
<div class="portlet-decoration">
<div class="portlet-title">操作</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw1">
<li><a href="${ctxPath}/goods/createGoods.shtml">新建商品</a></li>
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
					<h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">商品</h1>
				</div>
			</div>
			<div style="display: block; padding: 0px 10px 10px 10px;">
				<div class="grid-view">
					<div id="yw0" class="list-view">
<div class="summary">第 1-3 条, 共 3 条.</div>

<div class="items">

<div class="view">

	<b>名称:</b>
    <a href="${ctxPath}/goods/detailGoods.shtml">LOF ebay-fl</a>	<br />

	<b>平台:</b>
    eBay.com
    <b>最后一次订单同步的时间:</b>
    1970/01/01 12:00:00am    <br />

</div>
<div class="view">

	<b>名称:</b>
    <a href="${ctxPath}/goods/detailGoods.shtml">LOF ebay-discount</a>	<br />

	<b>平台:</b>
    eBay.com
    <b>最后一次订单同步的时间:</b>
    1970/01/01 12:00:00am    <br />

</div>
<div class="view">

	<b>名称:</b>
    <a href="${ctxPath}/goods/detailGoods.shtml">hjv.kjb/l</a>	<br />

	<b>平台:</b>
    eBay.com
    <b>最后一次订单同步的时间:</b>
    1970/01/01 12:00:00am    <br />

</div></div>
<div class="keys" style="display:none" title="${phpPath }/store"><span>1</span><span>2</span><span>3</span></div>
</div>				</div>
			</div>
		</div>
	</div>
</div>
        </div><!-- content -->
    </div>

	<%@ include file="/common/footer.jsp"%>

</div><!-- page -->
<script >
    function changeLanguage(tag){
        $.ajax({
            type: "POST",
            url: '${phpPath }/site/setLanguage',
            data: {pid:tag},
            dataType: "JSON",
            success: function(data, status, xhr) {
                if(data.status=='success'){
                    window.location.reload(true);
                }
            },
            error: function(data, status, xhr) {
            }
        });
    }
</script>
<script type="text/javascript" src="/assets/9e717463/listview/jquery.yiilistview.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('#yw0').yiiListView({'ajaxUpdate':['yw0'],'ajaxVar':'ajax','pagerClass':'pager','loadingClass':'list-view-loading','sorterClass':'sorter','enableHistory':false});
});
/*]]>*/
</script>
</body>
</html>
