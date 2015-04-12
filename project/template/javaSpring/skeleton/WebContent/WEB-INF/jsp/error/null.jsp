<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>[NullPointerException]에러</title>
<style type="text/css">
body,textarea {
	font-family: 굴림;
	font-size: small;
	padding: 20;
}
</style>
</head>
<body>
요청을 처리하는 과정에서 문제가 발생했습니다(java.lang.NullPointerException)
<hr align="left" width="80%" />
<textarea cols="90" rows="20">${exception.message}</textarea>
</body>
</html>