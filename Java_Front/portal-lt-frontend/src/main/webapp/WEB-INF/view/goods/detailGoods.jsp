<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - 商品明细</title>
</head>

<body>
<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${phpPath }">首页</a> &raquo; <a href="${phpPath }/store/index">商品</a> &raquo; <span>LOF ebay-fl@</span></div><!-- breadcrumbs -->
	
    
    
    
	    <div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw1">
<div class="portlet-decoration">
<div class="portlet-title">操作</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw2">
<li><a href="${ctxPath}/goods/listGoods.shtml">商品列表</a></li>
<li><a href="${ctxPath}/goods/createGoods.shtml">新建商品</a></li>
<li><a href="${ctxPath}/goods/getGoods.shtml">修改商品</a></li>
<li><a href="javascript:delGoods('1','${ctxPath}/goods/deleteGoods.shtml')" id="yt0">删除商品</a></li>
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">LOF ebay-fl@</h1>
                </div>
            </div>
            <div style="display: block;">
                <table class="detail-view" id="yw0"><tr class="odd"><th>名称</th><td>LOF ebay-fl@</td></tr>
<tr class="even"><th>平台</th><td>eBay.com</td></tr>
<tr class="odd"><th>是否有效</th><td>Yes</td></tr>
<tr class="even"><th>最后一次订单同步的时间</th><td>1970/01/01 12:00:00am</td></tr>
<tr class="odd"><th>E Bay  Site</th><td>US</td></tr>
<tr class="even"><th>Token  Expired  Date</th><td>1970/01/01 12:00:00am</td></tr>
<tr class="odd"><th></th><td><a href="${phpPath }/store/getToken/1">Please click here to renew your authorized token if needed</a></td></tr>
</table>            </div>
        </div>
    </div>
</div>




        </div><!-- content -->
    </div>

	<div class="clear" style="height: 20px;%"></div>

    <div id="pageFooter" >
        <ul class="clearfix" style="list-style: none; margin: 0px; padding: 0px; display: block;clear: both;">
            <li class="lfloat">
                <a title="English (US)" onclick="changeLanguage('en_us');">English (US)</a>
            </li>
            <li class="lfloat" style="padding-left: 10px;">
                <a title="Simplified Chinese (China)" onclick="changeLanguage('zh_cn');">中文(简体)</a>
            </li>
        </ul><br/>
        Copyright &copy; 2015 by Nirvana Info.<br/>
        All Rights Reserved.<br/>
        Powered by <a href="http://www.yiiframework.com/" rel="external">Yii Framework</a>.<br/>
        SQL executed: 26, Time usage: 0.020268440246582    </div>

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
<script type="text/javascript">
function delGoods(goodId, url){
	$.messager.confirm('提示', '你确定要删除吗?', function(r) {
		if (r) {
			$.ajax({ 
				url: url,
				data:"goodId="+goodId,
				dataType: 'json',
				type:'POST',
				success: function(data){
					//window.location.reload(true);
					$("#goodId").hide();
		      	}
			});
		}
	});
}

/*<![CDATA[*/
jQuery(function($) {
jQuery('body').on('click','#yt0',function(){if(confirm('你确定你要删除这个项目吗?')) {jQuery.yii.submitForm(this,'${phpPath }/store/delete/1',{});return false;} else return false;});
});
/*]]>*/
</script>
</body>
</html>
