<%--File Name	: popup_back.jsp
	Description : 팝업 처리[오픈너 리로드 창 리로드]
	author		: 위성국
	since		: 2011.07.14
	version		: 1.0
--%>
<%@ page contentType="text/html; charset=utf-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>popup_action</title>
<link rel="stylesheet"
	href="<%=request.getContextPath() %>/css/adm/common.css"
	type="text/css" />
<script type="text/javascript">


	history.back();
	window.opener.location.reload();
	

	
</script>
</head>
<body class="bgno">
</body>
</html>