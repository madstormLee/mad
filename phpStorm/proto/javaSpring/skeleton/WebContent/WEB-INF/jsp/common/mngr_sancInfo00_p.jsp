<%--File Name	: mngr_sancInfo00_p.jsp
	Description : 기업 제재정보 팝업창
	author		: 임지현
	since		: 2011.02.08
	version		: 1.0
--%>
<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>제재정보</title>
<link rel="stylesheet" type="text/css" href="/A_css/common.css" />
</head>
<%@ page import="java.util.Date"%>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Map"%>
<%@ page import="java.lang.Integer"%>
<%@ page import="com.a2m.framework.consts.VarConsts"%>
<jsp:useBean id="ut" class="com.a2m.framework.util.ReqUtils"></jsp:useBean>
<%

	List getSancList = (List)request.getAttribute("getSancList");
	Map listparam = (Map)request.getAttribute("listparam");
	
	String entp_ko_nm = (String)request.getAttribute("entp_ko_nm");
	
	int cPage 		= Integer.parseInt(""+listparam.get("cPage"));
	int intListCnt 	= Integer.parseInt(""+listparam.get("intListCnt"));
	int pageCnt 	= Integer.parseInt(""+listparam.get("pageCnt"));
	int totalCnt 	= Integer.parseInt(""+listparam.get("totalCnt"));
	
	int totalPage = (totalCnt - 1 ) / intListCnt +1 ; /* 총 페이지 수 */

%>
<body class="main">
	<div id="pop">
	<br />
		<h2><img src="/A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><%=entp_ko_nm%></h2>
		<!--테이블 시작 -->	
		<table cellpadding="0" cellspacing="0" class="table_style_4">
			<colgroup>
				<col width="17%" />
				<col width="55%" />
				<col width="27%" />
			</colgroup>
			<thead>
			<tr>
				<th>제재항목</th>
				<th>내용</th>
				<th>기간</th>
			</tr>
			</thead>
			<tbody>
			<%if(getSancList == null || getSancList.isEmpty()){%>
			<tr>
				<td colspan="3">등록된 데이터가 없습니다.</td>
			</tr>
			<%}else{
				Map row = null;
				String cont = "";
				for(int i=0; i<getSancList.size(); i++){
					row = ut.getResultNullChk((Map)getSancList.get(i));
					cont = (String)row.get("CONT");
					cont = ut.cutStr(cont, 50);
			%>
			<tr>
				<td><%=row.get("ITEM_NM")%></td>
				<td><%=row.get("CONT")%></td>
				<td><%=row.get("SANC_STDT")%> ~ <%=row.get("SANC_EDDT")%></td>				
			</tr>
			<%
				}
			}
			%>
			</tbody>
		</table> 
		
		<!--btn s --> 
		<div class="btn_area">
			<div class="right">
			<span class="btn_pack medium"><input type="button" value="닫기" onclick="window.close()" /></span>   &nbsp;
			</div>
		</div> 
		<!--btn e --> 
		
	</div>
	<!--페이지s -->
	<div class="pagination"><%=(String)request.getAttribute("pageNavigator")%></div>		
	<!--페이지e -->
</body>
</html>