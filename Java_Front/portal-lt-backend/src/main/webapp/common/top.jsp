<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<div id="header" class="container">
		<div id="logo" class="left">Item Tool Manage</div>
        <div class="right"><h5 class="append-1 prepend-top" style="vertical-align: text-bottom;">
                                    admin&nbsp;|&nbsp;<a href="${ctxPath}/logout.shtml">Logout</a>                        </h5></div>
	</div><!-- header -->

	<div id="menu-top">
		<ul id="nav" class="dropdown dropdown-horizontal">
<li><a href="${phpPath }/site/index">Home</a></li>
<li><a href="${phpPath }/company">User</a></li>
<li class="dir"><span>eBay</span>
<ul>
<li><a href="${phpPath }/eBay/eBayApiKey">Manage API Keys</a></li>
<li class="dir"><span>Manage Attribute</span>
<ul>
<li><a href="${phpPath }/eBay/eBayAttributeSet">Sets</a></li>
<li><a href="${phpPath }/eBay/eBayEntityType">Entity Types</a></li>
<li><a href="${phpPath }/eBay/eBayAttribute">Attributes</a></li>
</ul>
</li>
</ul>
</li>
<li><a href="${phpPath }/ticket">Ticket</a></li>
<li><a href="${phpPath }/resourceString">Localization</a></li>
<li class="dir"><span>Announcement</span>
<ul>
<li><a href="${phpPath }/notification">Notification</a></li>
<li><a href="${phpPath }/bulletin">Bulletin Board</a></li>
</ul>
</li>
<li><a href="${ctxPath}/company/transaction/list.shtml">Transaction</a></li>
<li><a href="${ctxPath}/category/ebay/home.shtml">category</a></li>
<li class="dir"><span>Help</span>
<ul>
<li><a href="${phpPath }/site/page?view=about">About</a></li>
<li><a href="${phpPath }/site/contact">Contact</a></li>
</ul>
</li>
</ul>	</div>