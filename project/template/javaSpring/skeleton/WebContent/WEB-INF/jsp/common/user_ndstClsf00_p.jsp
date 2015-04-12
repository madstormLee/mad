<%--File Name	: user_ndstClsf00_p.jsp
	Description : 사용자 업종별 검색 > 표준산업분류 팝업창
	author		: 임지현
	since		: 2010.12.08
	version		: 1.0
--%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title>표준산업분류</title>
<link rel="stylesheet" type="text/css"
	href="<%=request.getContextPath()%>/css/popup.css" />
<link rel="stylesheet" type="text/css"
	href="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/css/ui-lightness/jquery-ui-1.8.5.custom.css"
	media="screen" />
</head>
<%@ page contentType="text/html; charset=utf-8"%>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Map"%>
<%@ page import="com.a2m.framework.consts.VarConsts"%>
<jsp:useBean id="ut" class="com.a2m.framework.util.ReqUtils"></jsp:useBean>
<%
	/* 사업체대분류 코드 */
	List getDvsnLargeCode = (List)request.getAttribute("getDvsnLargeCode");	
	/* 산업분류 1단계 코드 */
	List getClsfOneCode = (List)request.getAttribute("getClsfOneCode");	
	/* 표준산업분류 리스트 */
	List getClsfList = (List)request.getAttribute("getClsfList");	
	
	Map listparam = (Map)request.getAttribute("listparam");
	
	/* 검색 파라메터값  */
	String word = ut.getEmptyResult2((String)request.getParameter("word"), "");		
	String gubun = ut.getEmptyResult2((String)request.getParameter("gubun"), "");
	
	int cPage 		= Integer.parseInt(""+listparam.get("cPage"));
	int intListCnt 	= Integer.parseInt(""+listparam.get("intListCnt"));
	int pageCnt 	= Integer.parseInt(""+listparam.get("pageCnt"));
	int totalCnt 	= Integer.parseInt(""+listparam.get("totalCnt"));
	
	int totalPage = (totalCnt - 1 ) / intListCnt +1 ; /* 총 페이지 수 */

%>
<body>
<script type="text/javascript"
	src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript"
	src="<%=request.getContextPath() %>/js/jquery.validate.pack.js"></script>
<script type="text/javascript"
	src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery.validate.js"></script>
<script type="text/javascript"
	src="<%=request.getContextPath() %>/js/U_js/common.js"></script>
<script type="text/javascript">

	function modeChg(flag){
		if(flag=="1"){
			document.getElementById("keyword").style.display = "block";
			document.getElementById("clsf").style.display = "none";
		}else{
			document.getElementById("keyword").style.display = "none";
			document.getElementById("clsf").style.display = "block";
		}
	}

</script>
<!-- 셀렉트박스 처리(Xml) -->
<script type="text/javascript"
	src="<%=request.getContextPath() %>/js/ajax.js"></script>
<script>
	/* 사업체 대분류 선택시 */
	function dvsnChg1(val){
		var url	 = "<%=request.getContextPath()%>/mngr/db_mng/common/mngr_selXml00_t.do?code="+val+"&flag=1";
		var name = "entp_dvsn2";
		var opt  = "select";			
		sendRequest( url, name, opt );
	}
	/* 사업체 중분류 선택시 */
	function dvsnChg2(val){
		var url	 = "<%=request.getContextPath()%>/mngr/db_mng/common/mngr_selXml00_t.do?code="+val+"&flag=1";
		var name = "entp_dvsn";
		var opt  = "select";			
		sendRequest( url, name, opt );
	}
	/* 산업분류 1단계 선택시 */
	function clsfChg1(val){
		var url	 = "<%=request.getContextPath()%>/mngr/db_mng/common/mngr_selXml00_t.do?code="+val+"&flag=2";
		var name = "ndst_clsf2";
		var opt  = "select";			
		sendRequest( url, name, opt );
	}
	/* 산업분류 2단계 선택시 */
	function clsfChg2(val){
		var url	 = "<%=request.getContextPath()%>/mngr/db_mng/common/mngr_selXml00_t.do?code="+val+"&flag=2";
		var name = "ndst_clsf3";
		var opt  = "select";			
		sendRequest( url, name, opt );
	}
	/* 산업분류 3단계 선택시 */
	function clsfChg3(val){
		var url	 = "<%=request.getContextPath()%>/mngr/db_mng/common/mngr_selXml00_t.do?code="+val+"&flag=2";
		var name = "ndst_clsf";
		var opt  = "select";			
		sendRequest( url, name, opt );
	}


	function setVal(key){
		$(opener.document).find('#tpbs_word').val(key);
		window.close();
	}
	
</script>
<form name="form1" id="form1"
	action="<%=request.getContextPath() %>/user/common/user_ndstClsf00_p.do"
	method="post"><input type="hidden" name="mode" value="1" />
<div id="pop_wrap">
<div id="pop_header">
<h1>표준산업분류코드 검색</h1>
</div>
<div id="pop_container">
<div class="pop_content" style="height: 500px">
<div class="btn_area">
<div class="left"><span class="btn_pack medium"><input
	type="button" onclick="modeChg('1')" value="키워드 검색" /></span> <span
	class="btn_pack medium"><input type="button"
	onclick="modeChg('2')" value="표준산업분류" /></span></div>
</div>
<div><select name="gubun">
	<option value="cd_nm" <%if("cd_nm".equals(gubun)){%>
		selected="selected" <%}%>>분류명칭</option>
	<option value="cd_id" <%if("cd_id".equals(gubun)){%>
		selected="selected" <%}%>>코드번호</option>
</select> <input type="text" id="word" name="word" size="20" value="<%=word%>"
	title="검색어 입력" /> <input type="image"
	src="<%=request.getContextPath() %>/images/common/board/btn_search.gif"
	alt="검색" /></div>
<!-- 키워드검색Start -->
<div class="board" id="keyword">
<table class="tbl_type_list" summary="표준산업분류 - 번호, 제목, 날짜, 글쓴이, 조회수">
	<caption>표준산업분류</caption>
	<colgroup>
		<col width="7%"></col>
		<col width="10%"></col>
		<col width="15%"></col>
		<col width="18%"></col>
		<col width="25%"></col>
		<col width="25%"></col>
	</colgroup>
	<thead>
		<tr>
			<th scope="col" class="first">번호</th>
			<th scope="col" class="subject"><span>코드번호</span></th>
			<th scope="col"><span>대분류</span></th>
			<th scope="col"><span>중분류</span></th>
			<th scope="col"><span>소분류</span></th>
			<th scope="col" class="last"><span>세분류</span></th>
		</tr>
	</thead>
	<tbody>
		<%if(getClsfList == null || getClsfList.isEmpty()){%>
		<tr>
			<td class="num" colspan="6">:: No Data ::</td>
		</tr>
		<%}else{ 
					Map row = null;
					for(int i=0; i<getClsfList.size(); i++){
						row = ut.getResultNullChk((Map)getClsfList.get(i));
				%>
		<tr onclick="setVal('<%=row.get("CD_ID")%>')" style="cursor: pointer;">
			<td class="num"><%=totalCnt-(i+((cPage-1)*intListCnt))%></td>
			<td class="num"><%=row.get("CD_ID")%></td>
			<td class="num"><%=row.get("NM1")%></td>
			<td class="num"><%=row.get("NM2")%></td>
			<td class="num"><%=row.get("NM3")%></td>
			<td class="num"><%=row.get("NM4")%></td>
		</tr>
		<%
					}
				} 
				
				%>
	</tbody>
</table>
<br />
<div class="pagination"><%=(String)request.getAttribute("pageNavigator")%></div>
</div>
<!-- 키워드검색End --> <!-- 표준산업분류Start -->
<div class="board" id="clsf" style="display: none;">
<table class="tbl_type_list" summary="표준산업분류 - 산업분류">
	<caption>표준산업분류</caption>
	<colgroup>
		<col width="20%"></col>
		<col width="80%"></col>
	</colgroup>
	<thead>
		<tr>
			<th scope="col" class="first">번호</th>
			<th scope="col" class="last"><span>표준산업분류</span></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="num">대분류</td>
			<td class="num"><select name="ndst_clsf1" id="ndst_clsf1"
				onchange="clsfChg1(this.value)" style="width: 400px;">
				<option value="">선택</option>
				<% 	if(getClsfOneCode == null || getClsfOneCode.isEmpty()){ %>
				<option value="">없음</option>
				<% 	}else{
								Map row = null;
								String sel="";
								for(int i= 0; i< getClsfOneCode.size(); i++){
									row = ut.getResultNullChk((Map)getClsfOneCode.get(i));
						%>
				<option value="<%=row.get("CD_ID")%>" <%=sel%>><%=row.get("CD_NM")%></option>

				<%
								}
							}
						%>
			</select></td>
		</tr>
		<tr>
			<td class="num">중분류</td>
			<td class="num"><select name="ndst_clsf2" id="ndst_clsf2"
				onchange="clsfChg2(this.value)" style="width: 400px;">
				<option value="">선택</option>
			</select></td>
		</tr>
		<tr>
			<td class="num">소분류</td>
			<td class="num"><select name="ndst_clsf3" id="ndst_clsf3"
				onchange="clsfChg3(this.value)" style="width: 400px;">
				<option value="">선택</option>
			</select></td>
		</tr>
		<tr>
			<td class="num">세분류</td>
			<td class="num"><select name="ndst_clsf" id="ndst_clsf"
				style="width: 400px;">
				<option value="">선택</option>
			</select></td>
		</tr>

	</tbody>
</table>
<br />
<div class="pagination"><%=(String)request.getAttribute("pageNavigator")%></div>
</div>



<!-- 표준산업분류End --></div>
<div class="btn_area">
<div class="right"><span class="btn_pack medium"><input
	type="button" onclick="window.close();" value="닫기" /></span></div>
</div>
</div>
</div>
</form>
<!-- //wrap -->
</body>
</html>