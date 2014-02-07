<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String error = ""+request.getAttribute("error");
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>기업회원 로그인 에러</title>
<style type="text/css">
body,textarea {
	font-family: 굴림;
	font-size: small;
	padding: 20;
}
</style>
</head>
<body>
	<script language="javascript">
		alert("<%=error%>");
		document.location.href="/usrLogin.do";
	</script>
</body>
</html>