<%--File Name	: popup_close.jsp
	Description : 팝업 닫기 공통
	author		: 임지현
	since		: 2010.11.25
	version		: 1.0
--%>
<%@ page contentType="text/html; charset=utf-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BIZPORTAL</title>
<link rel="stylesheet"
	href="<%=request.getContextPath() %>/css/adm/common.css"
	type="text/css" />
<script type="text/javascript">


	window.close();
	window.opener.location.reload();
	

	
</script>
</head>
<body class="bgno">
</body>
</html>