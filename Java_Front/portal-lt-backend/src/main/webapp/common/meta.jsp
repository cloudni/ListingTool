<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<base href="${pageContext.request.scheme}://${pageContext.request.serverName}:${pageContext.request.serverPort}${pageContext.request.contextPath}/">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/main.css" />
	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/form.css" />

    <!-- start of custom CSS file -->
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/dropdownmenu/css/dropdown/dropdown.css" />
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/dropdownmenu/css/dropdown/dropdown.vertical.rtl.css" />
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/dropdownmenu/css/dropdown/themes/default/default.ultimate.css" />
    <!-- end of custom CSS file -->
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/bulletins.css"/>

	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/list-view-styles.css" />
	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/grid-view-styles.css" />
	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/detail-view-styles.css" />
	<link rel="stylesheet" type="text/css" href="${ctxPath}/css/pager.css" />
	
	<script type="text/javascript" src="${ctxPath}/js/jquery.js"></script>
	<script type="text/javascript" src="${ctxPath}/js/jquery-1.8.0.min.js"></script>

<script type="text/javascript" src="${ctxPath}/js/common.js"></script>

<!-- 翻页控件 -->
<%-- <script  type="text/javascript" src="${ctxPath}/js/page.js"></script> --%>

<script type="text/javascript" src="${ctxPath}/js/jquery.yiigridview.js"></script>

<!-- 页面验证 -->
<link rel="stylesheet" type="text/css" href="${ctxPath}/css/validate-css/screen.css" />
<script type="text/javascript" src="${ctxPath}/js/jquery.validate.js"></script>

<!---翻页样式new--->
<!-- <link rel="stylesheet" type="text/css" href="${ctxPath}/css/common.css" /> -->

<!-- 播放器插件 -->
<link href="${ctxPath}/plugin/jPlayer-2.9.2/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${ctxPath}/plugin/jPlayer-2.9.2/dist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			$(this).jPlayer("setMedia", {
				mp3: "${ctxPath}/audio/1.mp3"
			});/*.jPlayer("play");*/
		},
		swfPath: "${ctxPath}/plugin/jPlayer-2.9.2/dist/jplayer",
		supplied: "m4a, oga, mp3",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true
	});
	
	if("${user.userId}" != "") {
		initWs();
	}
});

var ws = null;
//创建ws连接
function initWs() {
	var target = "/home/messageTip";
    if (window.location.protocol == 'http:') {
    	target = 'ws://' + window.location.host + "${ctxPath}" + target + '?userId=${user.userId}';
    } else {
    	target = 'wss://' + window.location.host + "${ctxPath}" + target + '?userId=${user.userId}';
    }
	if ('WebSocket' in window) {
	    ws = new WebSocket(target);
	} else if ('MozWebSocket' in window) {
	    ws = new MozWebSocket(target);
	} else {
	    alert('WebSocket is not supported by this browser.');
	    return;
	}
	ws.onopen = function () {
	    setConnected(true);
	    //console.log('Info: WebSocket connection opened.');
	};
	ws.onmessage = function (event) {
		//console.log('Received: ' + event.data);
	    $("#jquery_jplayer_1").jPlayer( "play" );  
	};
	ws.onclose = function (event) {
	    setConnected(false);
	   // console.log('Info: WebSocket connection closed, Code: ' + event.code + (event.reason == "" ? "" : ", Reason: " + event.reason));
	};
}
</script>
