<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<base href="${pageContext.request.scheme}://${pageContext.request.serverName}:${pageContext.request.serverPort}${pageContext.request.contextPath}/">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
 
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

    <!-- start of bulletin model css file-->
    <link rel="stylesheet" type="text/css" href="${ctxPath}/css/bulletins.css"/>
    <!--start of bulletin model css file-->

	<script type="text/javascript" src="${ctxPath}/js/jquery.js"></script>
	<script type="text/javascript" src="${ctxPath}/js/jquery-1.8.0.min.js"></script>

    <link rel="stylesheet" type="text/css" href="${ctxPath}/themes/facebook/css/main.css" />

	<script type="text/javascript" src="${ctxPath}/js/jquery.min.js"></script>
	<script type="text/javascript" src="${ctxPath}/js/jquery.easyui.min.js"></script>
	
	<%--userList--%>
<link rel="stylesheet" type="text/css" href="${ctxPath}/css/styles.css" />
<link rel="stylesheet" type="text/css" href="${ctxPath}/css/detailviewStyles.css" />
<link rel="stylesheet" type="text/css" href="${ctxPath}/css/pager.css" />
<!-- <script type="text/javascript" src="/assets/b2e913db/jquery.js"></script>
<script type="text/javascript" src="/assets/b2e913db/jquery.ba-bbq.js"></script> -->

<!-- 翻页控件 -->
<%-- <script type="text/javascript" src="${ctxPath}/js/page.js"></script> --%>

<!-- 页面验证 -->
<link rel="stylesheet" type="text/css" href="${ctxPath}/css/validate-css/screen.css" />
<script type="text/javascript" src="${ctxPath}/js/jquery.validate.js"></script>

<script type="text/javascript" src="${ctxPath}/js/common.js"></script>

<!---翻页样式new--->
<link rel="stylesheet" type="text/css" href="${ctxPath}/css/common.css" />

<!-- 判断全局浏览器引入样式 -->
	<script type="text/javascript">
        window.onload = function () {setstyle('facebook');}
    </script>
    
<!-- 播放器相关 -->
<link href="${ctxPath}/plugin/jPlayer-2.9.2/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${ctxPath}/plugin/jPlayer-2.9.2/dist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript">
/**$(document).ready(function(){
	//提示音播发器初始化动作
	$("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			$(this).jPlayer("setMedia", {
				mp3: "1.mp3"
			});//.jPlayer("play")
		},
		swfPath: "../../dist/jplayer",
		supplied: "m4a, oga, mp3",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true
	});
	
	initWs();
});

var ws = null;
//创建ws连接
function initWs() {
	var target = "";
    if (window.location.protocol == 'http:') {
    	target = 'ws://' + window.location.host + target + '?userId=${user.userId}';
    } else {
    	target = 'wss://' + window.location.host + target + '?userId=${user.userId}';
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
	    log('Info: WebSocket connection opened.');
	};
	ws.onmessage = function (event) {
	    log('Received: ' + event.data);
	    $("#jquery_jplayer_1").jPlayer( "play" );  
	};
	ws.onclose = function (event) {
	    setConnected(false);
	    log('Info: WebSocket connection closed, Code: ' + event.code + (event.reason == "" ? "" : ", Reason: " + event.reason));
	};
}*/
</script>