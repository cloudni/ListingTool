<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<c:set var="ctxPath" value="${pageContext.request.contextPath}" scope="request"/>
<c:set var="phpPath" value="http://manage.itemtool.com/index.php" scope="request"/>
<script>
var base="${ctxPath}";
var phpPath="${phpPath}";
var lanType="${sessionScope.lanType}";
</script>