<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<%@ include file="/A_inc/doctype.jsp" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<jsp:useBean id="mf" scope="session" class="com.a2m.framework.util.MenuFormatter" />
<%
	
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>기술연계플랫폼</title>
<link rel="stylesheet" type="text/css" href="/A_css/common.css" />

</head>

<body>
<div id="wrap">
<div id="header_map"><img src="/A_img/common/M_sub/m_head_ico.gif" width="22" height="17" /><%=subTit%></div>


<!--컨텐츠 박스 1000px -->       
<div id="con_top_img01">
	<div id="sidebar">
		<h1><a href="/mng/conts/basis/mngr_membInfo00_l.do"><img src="<%=request.getContextPath()%>/A_img/common/M_sub/m_logo.gif" border="0" /></a></h1>
                
        		<div id="sidebar_menu">
                <p><img src="/A_img/common/M_sub/left_menu_top.gif" /></p>
				<%=mf.getMenu() %>
               </div>
	</div>

	<!-- 컨텐츠 박스 s--> 
	<div id="con_box">
   
	 <!--로그인 정보 s -->  
	<%@ include file="/A_inc/M_inc_login.jsp" %>

	 <!--메뉴추가 -->     
	<%@ include file="/A_inc/M_inc_menu.jsp" %>
		  
