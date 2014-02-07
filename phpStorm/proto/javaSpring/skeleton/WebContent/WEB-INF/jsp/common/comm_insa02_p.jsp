<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>직원 조회</title>
<link rel="stylesheet" type="text/css" href="/A_css/common.css" />
<script type="text/javascript"
	src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<link rel="stylesheet" type="text/css" href="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/css/redmond/jquery-ui-1.8.6.custom.css" media="screen" />
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-latest.js"></script> 
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery.validate.js" ></script>


<%@ page import="java.util.List"%>
<%@ page import="java.util.Map"%>
<%@ page import="com.a2m.framework.consts.VarConsts"%>  
<jsp:useBean id="ut" class="com.a2m.framework.util.ReqUtils"></jsp:useBean>
<%
	List list = (List)request.getAttribute("getList");
	Map row = null;
	String result = (String)request.getAttribute("result");
	String word = (String)request.getAttribute("word");
	String gubun = (String)request.getAttribute("gubun");
	String num = (String)request.getAttribute("num");//한 페이지에서 여러 담당자를 조회할 때 
	
	if(word != null){		         
		word			= (String)request.getAttribute("word");          
	}
%>
<script type="text/javascript">
function setVal(id,nm){	
	$(opener.document).find('#nm').val(nm);
	window.close();
}
</script>
</head>

<body class="main">
	<div id="pop">
    <h2><img src="/A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" />직원 </h2>
    <script type="text/javascript" src="<%=request.getContextPath() %>/js/U_js/mngrPrfsPage.js"></script>
	<form name="form1" id="form1" method="post"  action="<%=request.getContextPath() %>/mngr/common/comm_insa02_p.do" >	
    <div id="search_list">
			<fieldset>
				<legend>직원 검색</legend>
				<label for="list_select" class="blind"> 검색 항목 선택</label>
				선택:<select name="gubun" id="gubun">
					<option value="insa_nm" <%if("insa_nm".equals(gubun)){%> selected <%}%>>직원명</option>
    			</select>
				<label for="word" class="blind">게시판 검색 단어</label>
				<input type="text" size="24" name="word" id="word" value="<%=word %>" title="검색할 단어를 입력하세요" />
				<label for="list_btn" class="blind">게시판 검색 버튼</label>
			    
			    <input type="image" src="/A_img/common/M_btn/btn_search.gif" id="list_btn" class="border_none" alt="검색" />
			</fieldset>
      </div>	
      	   
    <!--테이블 시작 -->	
         <table cellpadding="0" cellspacing="0" class="table_style_4">
			<colgroup>
				<col width="30%" />
				<col width="" />
			</colgroup>
			
			<tbody>
		       <%if(list == null || list.isEmpty()){ %>
					<tr>
						<td colspan="3" class="ri_line">직원을 검색하세요.</td>
					</tr>
				<%}else{ 
					for(int i = 0;i < list.size();i++){ 
						row = ut.getResultNullChk((Map)list.get(i)); 				
					%>
					<tr align="center">
					   	<td><a href="javascript:setVal('<%=row.get("SABUN")%>', '<%=row.get("NM")%>')"><%=row.get("NM")%></a>&nbsp; </td>
				        <td class="ri_line"><a href="javascript:setVal('<%=row.get("SABUN")%>', '<%=row.get("NM")%>')"><%=row.get("ORG_NM_FULL")%></a>&nbsp;</td>
					</tr>
					<%} %>
				<%} %> 												
			</tbody>
			</table> 
            <!--테이블 시작 -->	   
               
    </form>
    </div>



</body>
</html>