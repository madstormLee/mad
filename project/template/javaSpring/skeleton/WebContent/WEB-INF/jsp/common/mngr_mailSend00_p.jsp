<%--File Name	: mngr_mailSend00_p.jsp
	Description : 관리자 메일전송 모듈
	author		: 
	since		: 2011.01.24
	version		: 1.0
--%>
<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>기업지원 메일전송</title>
<link rel="stylesheet" type="text/css" href="/A_css/common.css" />

<link rel="stylesheet" type="text/css" href="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/css/ui-lightness/jquery-ui-1.8.5.custom.css" media="screen" />

<jsp:useBean id="ut" class="com.a2m.framework.util.ReqUtils"></jsp:useBean>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Map"%>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery.validate.js" ></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/U_js/common.js"></script>

</head>

<body class="main">
	<div id="pop">
    <h2><img src="/A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" />기업지원 메일전송</h2>
  <!--테이블 시작 -->	
         <table cellpadding="0" cellspacing="0" class="table_style_4">
			<colgroup>
				<col width="10%" />
				<col width="40%" />
			</colgroup>
			<thead>
			</thead>
			<tbody>
				<tr>
				  <th>받는사람</th>
				  <td><label for="temp1" class="iLabel">받는사람</label>
							<input type="text" name="" class="iText"  id="temp1"/></td>
				</tr>
				
				<tr>
				  <th>제목</th>
				  <td><label for="temp1" class="iLabel">제목</label>
							<input type="text" name="" class="iText"  id="temp1"/></td>
				</tr>

				<tr>
				  <th>내용</th>
				  <td><label for="temp1" class="iLabel">내용</label>
							<textarea name="" cols="80" rows="5" class="iText" id="temp2"></textarea></td>
				</tr>
				
				</tbody>
			</table> 
            <!--테이블 시작 -->	   
               
                
         <!--btn s --> 
          <div class="btn_area">
			<div class="right">
			<span class="btn_pack medium"><input type="button" value="닫기" onclick="window.close();" /></span>
			</div>
		  </div> 
           <!--btn e --> 
    
    
    </div>



</body>
</html>