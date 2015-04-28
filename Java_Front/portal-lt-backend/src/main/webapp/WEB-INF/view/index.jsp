<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - EBayAttributeSet</title>
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
<a href="${phpPath }">Home</a> &raquo; <span>eBay Attribute Sets</span></div><!-- breadcrumbs -->
	
    
    
    
	<div class="span-19">
	<div id="content">
		
<h1>eBay Attribute Sets</h1>

<div>
    <table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid gray;" >
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Is Active</th>
            <th>Action</th>
        </tr>
        <div id="yw0" class="list-view">
<div class="summary">Displaying 1-8 of 8 results.</div>

<div class="items">

<tr>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/view/id/1">1</a></td>
    <td>GetSellerList Item compatible level 893</td>
    <td>Yes</td>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/update/id/1">Edit</a><!--&nbsp;|&nbsp;--></td>
</tr>
<tr>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/view/id/2">2</a></td>
    <td>GetCategories category compatible level 895</td>
    <td>Yes</td>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/update/id/2">Edit</a><!--&nbsp;|&nbsp;--></td>
</tr>
<tr>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/view/id/3">3</a></td>
    <td>GeteBayDetails compatible level 893</td>
    <td>Yes</td>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/update/id/3">Edit</a><!--&nbsp;|&nbsp;--></td>
</tr>
<tr>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/view/id/4">4</a></td>
    <td>GetCategoryFeatures FeatureDefinitions &amp; SiteDefaults compatible level 893</td>
    <td>Yes</td>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/update/id/4">Edit</a><!--&nbsp;|&nbsp;--></td>
</tr>
<tr>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/view/id/5">5</a></td>
    <td>GetCategoryFeatures compatible level 893</td>
    <td>Yes</td>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/update/id/5">Edit</a><!--&nbsp;|&nbsp;--></td>
</tr>
<tr>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/view/id/6">6</a></td>
    <td>GetSellerDashboard compatible level 893</td>
    <td>Yes</td>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/update/id/6">Edit</a><!--&nbsp;|&nbsp;--></td>
</tr>
<tr>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/view/id/7">7</a></td>
    <td>GetSellerList Seller compatible level 893</td>
    <td>Yes</td>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/update/id/7">Edit</a><!--&nbsp;|&nbsp;--></td>
</tr>
<tr>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/view/id/8">8</a></td>
    <td>GetUser compatible level 905</td>
    <td>Yes</td>
    <td><a href="${phpPath }/eBay/eBayAttributeSet/update/id/8">Edit</a><!--&nbsp;|&nbsp;--></td>
</tr>
</div>
<div class="keys" style="display:none" title="${phpPath }/eBay/eBayAttributeSet"><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span></div>
</div>    </table>
</div>


	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
	<div class="portlet" id="yw2">
<div class="portlet-decoration">
<div class="portlet-title">Operations</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw3">
<li><a href="${phpPath }/eBay/eBayAttributeSet/create">Create eBayAttributeSet</a></li>
</ul></div>
</div>	</div><!-- sidebar -->
</div>

	<div class="clear"></div>

	<%@ include file="/common/footer.jsp"%><!-- footer -->

</div><!-- page -->

<script type="text/javascript" src="/assets/6caa43f1/listview/jquery.yiilistview.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('#yw0').yiiListView({'ajaxUpdate':['yw0'],'ajaxVar':'ajax','pagerClass':'pager','loadingClass':'list-view-loading','sorterClass':'sorter','enableHistory':false});
});
/*]]>*/
</script>
</body>
</html>
