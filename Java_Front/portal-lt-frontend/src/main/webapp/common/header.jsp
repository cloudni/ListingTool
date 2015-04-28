<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<div id="menu-top">
	<ul id="nav" class="dropdown dropdown-horizontal">
		<li class="active">
			<a href="${phpPath}/site/index">${session.menu_home }</a>
			<!-- <a href="${ctxPath}/index.shtml">${session.menu_home }</a> -->
		</li>
		<li class="dir"><a href="${phpPath }/eBay/eBay">eBay</a>
			<ul>
				<li><a href="${phpPath }/eBay/eBayListing">${session.ebay_listing }</a></li>
				<li><a href="${phpPath }/eBay/eBayListing/bulkUpdate">${session.bulk_update_ebay_listing }</a></li>
				<li><a href="${phpPath }/eBay/eBayTargetAndTrack">${session.target_and_track }</a></li>
			</ul></li>
		<li class="dir"><span>${session.menu_system }</span>
			<ul>
				<!-- java
					<li><a href="${ctxPath}/user/listUser.shtml">${session.user_manage_label }</a></li>
					<li><a href="${ctxPath}/department/listDepartment.shtml">${session.menu_manage_department }</a></li>
					<li><a href="${ctxPath}/company/listCompany.shtml">${session.menu_manage_company }</a></li>
				 -->
				<li><a href="${phpPath}/User">${session.user_manage_label }</a></li>
				<li><a href="${phpPath}/department">${session.menu_manage_department }</a></li>
				<li><a href="${phpPath}/Store">${session.store_manage_menu }</a></li>
				<%-- <li><a href="${ctxPath}/goods/listGoods.shtml">商品管理</a></li> --%>
				<li><a href="${phpPath}/Company">${session.menu_manage_company }</a></li>
			</ul></li>
		<li class="dir"><span>${session.menu_help }</span>
			<ul>
				<li><a href="${phpPath }/ticket">${session.ticket_title }</a></li>
				<li><a href="${phpPath}/notification">${session.notification_title }</a></li>
				<!-- <li><a href="${ctxPath}/notification/listNotification.shtml">${session.notification_title }</a></li>-->
				<li><a href="${phpPath }/site/page?view=about">${session.menu_help_about }</a></li>
				<li><a href="${phpPath }/site/contact">${session.contact_title }</a></li>
			</ul></li>
	</ul>
</div>
<!-- mainmenu -->
<!-- breadcrumbs -->

<!-- 播放器 -->
<div style="display: none;">
	<div id="jquery_jplayer_1" class="jp-jplayer"></div>
</div>
