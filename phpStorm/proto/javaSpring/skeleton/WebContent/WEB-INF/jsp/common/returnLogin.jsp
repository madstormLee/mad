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

<%
	String rs = (String)request.getAttribute("rs");
	if("JoinOk".equals(rs)){
%>
		alert("회원가입을 축하합니다. \n로그인하세요.");
		location.href="/usrLogin.do";
<%
	}else{
%>
		alert("회원가입이 정상적으로 이루어지지 않았습니다. \n 다시 등록해주시기 바랍니다.");
		location.href="/user/ndvd_info/user_membJoin00_i.do";
<%		
	}
%>
	
</script>
</head>
<body class="bgno">
</body>
</html>