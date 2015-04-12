<%--File Name	: user_aftMng00_p.jsp
	Description : 기업 사후관리 팝업창
	author		: 임지현
	since		: 2011.01.03
	version		: 1.0
--%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title>기업 설문조사</title>
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
	/* 사후관리 데이터 */
	List getEntpAft = (List)request.getAttribute("getEntpAft");	
	/* 사후관리 질문데이터 */
	List getQstnData = (List)request.getAttribute("getQstnData");	
	/* 사후관리 답변데이터 */
	List getAnsrList = (List)request.getAttribute("getAnsrList");	
	/* 설문결과 */
	String getReltList = (String)request.getAttribute("getReltList");	
	
	String seq = (String)request.getParameter("seq");
	
	String tit = "", stdt = "", eddt = "", entp_seq="";
	if(getEntpAft != null && !getEntpAft.isEmpty()){
		Map AftRow = null;
		for(int i=0; i<getEntpAft.size(); i++){
			AftRow = (Map)getEntpAft.get(i);
			tit  = (String)AftRow.get("TIT");
			stdt = (String)AftRow.get("STDT");
			eddt = (String)AftRow.get("EDDT");
			entp_seq = ""+AftRow.get("ENTP_SEQ");
						
		}
	}
	
//	out.println("tit : "+tit+", stdt : "+stdt+", eddt : "+eddt);
	
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
<script language="javascript">

	function setCookie( name, value, expiredays ) { 
		var todayDate = new Date(); 
		todayDate.setDate( todayDate.getDate() + expiredays ); 
		document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";";
	}

	/* 오늘하루열지 않음 체크시 */
	function closeWin() {
		if (form1.chkYn.checked) setCookie("buss_aft", "<%=seq%>" , 1); 
		self.close(); 
	}

/* 답변 체크 Start*/
	
$.validator.setDefaults({
	// 서브밋 핸들러
	// submitHandler: function() {},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});


/* 답변필수체크 */
$().ready(function() {
	$("#form1").validate({
		rules:{
		<%if(getQstnData == null || getQstnData.isEmpty()){%>
			tmp:{	/* 임시 */
				required: false
			},
		<%}else{
			Map row = null;
			String pool_seq = "", flag ="";
			for(int i=0; i<getQstnData.size(); i++){
				row = ut.getResultNullChk((Map)getQstnData.get(i));
				pool_seq = (String)row.get("POOL_SEQ");
				flag = "Y".equals((String)row.get("NCS_RGST_YN"))?"true":"false";
				if("20100404".equals((String)row.get("ANSR_CD"))){ 	/* 주관식일때 */ 	
					if("20100407".equals((String)row.get("ANSR_FRMT_CD"))){	/* 단답형일때 */	
		%>
			ansr_cont<%=i+1%>:{	
				required: <%=flag%>
			},
		<%
					}else if("20100408".equals((String)row.get("ANSR_FRMT_CD"))){	/* 의견란일때 */	
		%>
			ansr_cont<%=i+1%>:{	
				required: <%=flag%>
			},
		<%
					}else if("20100409".equals((String)row.get("ANSR_FRMT_CD"))){	/* 숫자형일때 */	
		%>
			ansr_cont<%=i+1%>:{	
				required: <%=flag%>,
				number: true
			},
		<%
					}
				}else if("20100405".equals((String)row.get("ANSR_CD"))){	/* 객관식일때 */
					if(getAnsrList == null || getAnsrList.isEmpty()){
		%>
			tmp:{
				required: true
			},
		<%
					}else{
						Map row2 = null;
						String div = "N";
						for(int j=0; j<getAnsrList.size(); j++){					/* 답변데이타 */
							row2 = ut.getResultNullChk((Map)getAnsrList.get(j));
							if(pool_seq.equals(""+row2.get("POOL_SEQ")) && "N".equals(div)){
								div = "Y";
		%>
			ansr_seq<%=i+1%>:{
				required: <%=flag%>
			},
		<%						
							}
						}
					}
					
				}
			}
		}
		%>
			tmp2:{	/* 임시2 */
				required: false
			}
		},
		messages:{
		<%if(getQstnData == null || getQstnData.isEmpty()){%>
			tmp:{	/* 임시 */
				required: ""
			},
		<%}else{
			Map row = null;
			String pool_seq = "";
			for(int i=0; i<getQstnData.size(); i++){
				row = ut.getResultNullChk((Map)getQstnData.get(i));
				pool_seq = (String)row.get("POOL_SEQ");
				if("20100404".equals((String)row.get("ANSR_CD"))){ 	/* 주관식일때 */ 	
					if("20100407".equals((String)row.get("ANSR_FRMT_CD"))){	/* 단답형일때 */	
		%>
			ansr_cont<%=i+1%>:{	
				required: ""
			},
		<%
					}else if("20100408".equals((String)row.get("ANSR_FRMT_CD"))){	/* 의견란일때 */	
		%>
			ansr_cont<%=i+1%>:{	
				required: ""
			},
		<%
					}else if("20100409".equals((String)row.get("ANSR_FRMT_CD"))){	/* 숫자형일때 */	
		%>
			ansr_cont<%=i+1%>:{	
				required: "",
				number:"<font color='red'><strong> only Number</strong></font>"
			},
		<%
					}
				}else if("20100405".equals((String)row.get("ANSR_CD"))){	/* 객관식일때 */
					if(getAnsrList == null || getAnsrList.isEmpty()){
		%>
			tmp:{
				required: ""
			},
		<%
					}else{
						Map row2 = null;
						String div = "N";
						for(int j=0; j<getAnsrList.size(); j++){					/* 답변데이타 */
							row2 = ut.getResultNullChk((Map)getAnsrList.get(j));
							if(pool_seq.equals(""+row2.get("POOL_SEQ")) && "N".equals(div)){
								div = "Y";
		%>
			ansr_seq<%=i+1%>:{
				required: ""
			},
		<%
							}
						}
					}
					
				}
			}
		}
		%>
			tmp2:{	/* 임시2 */
				required: ""
			}
		}
	});
});
	
/* 답변 체크 End*/
 
</script>
<form name="form1" id="form1"
	action="<%=request.getContextPath() %>/user/common/user_aftMng00_t.do"
	method="post"><input type="hidden" name="mode"
	value="<%=VarConsts.MODE_I%>" /> <input type="hidden" name="seq"
	id="seq" value="<%=seq%>" /> <input type="hidden" name="entp_seq"
	id="entp_seq" value="<%=entp_seq%>" /> <input type="hidden" name="tmp"
	id="tmp" value="" /> <input type="hidden" name="tmp2" id="tmp2"
	value="" />
<div id="pop_wrap">
<div id="pop_header">
<h1><%=tit%></h1>
</div>
<div id="pop_container">
<div class="pop_content" style="height: 100%"><!-- 사후관리질문Start -->
<%if("0".equals(getReltList)){ %>
<div class="aft_mng" align="left">
<ul>
	<%if(getQstnData == null || getQstnData.isEmpty()){%>
	<li class="article">
	<p class="q"><span class="trigger">등록된 질문이 없습니다.</span></p>
	</li>
	<%}else{
						Map row = null;
						String pool_seq = "";
						for(int i=0; i<getQstnData.size(); i++){
							row = ut.getResultNullChk((Map)getQstnData.get(i));
							pool_seq = (String)row.get("POOL_SEQ");
					%>
	<li class="article">
	<p class="q"><span class="trigger">Q: <%=row.get("QSTN")%></span><input
		type="hidden" name="qstn_seq" value="<%=row.get("QSTN_SEQ")%>" /><input
		type="hidden" name="ansr_cd" value="<%=row.get("ANSR_CD")%>" /></p>
	<%		if("20100404".equals((String)row.get("ANSR_CD"))){ 	/* 주관식일때 */ 	
								if("20100407".equals((String)row.get("ANSR_FRMT_CD")) || "20100409".equals((String)row.get("ANSR_FRMT_CD"))){	/* 숫자형이나 단답형일때 */		%>
	<p class="a"><label for="ansr_cont<%=i+1%>" class="iLabel">답변</label>
	<input type="text" name="ansr_cont<%=i+1%>" id="ansr_cont<%=i+1%>"
		value="" size="60" /></p>
	<%			}else if("20100408".equals((String)row.get("ANSR_FRMT_CD"))){	/* 의견란일때 */	%>
	<p class="a"><label for="ansr_cont<%=i+1%>" class="iLabel">답변</label><textarea
		name="ansr_cont<%=i+1%>" id="ansr_cont<%=i+1%>" cols="50" rows="10"
		class="iText"></textarea></p>
	<%			}		 
							}else if("20100405".equals((String)row.get("ANSR_CD"))){	/* 객관식일때 */
								String type="";
								type = "Y".equals((String)row.get("PLR_ANSR_YN"))?"checkbox":"radio";	/* 단일형이냐, 복수형이냐 */
								if(getAnsrList == null || getAnsrList.isEmpty()){
					%>
	<p class="a">보기가없습니다.</p>
	<%
								}else{
									Map row2 = null;
									for(int j=0; j<getAnsrList.size(); j++){					/* 답변데이타 */
										row2 = ut.getResultNullChk((Map)getAnsrList.get(j));
										if(pool_seq.equals(""+row2.get("POOL_SEQ"))){
					%>
	<p class="a">&nbsp;&nbsp;<input type="<%=type%>"
		name="ansr_seq<%=i+1%>" id="ansr_seq<%=j+1%>"
		value="<%=row2.get("ANSR_SEQ")%>" /> <label for="ansr_seq<%=j+1%>"><%=row2.get("ANSR")%></label></p>
	<%
										}
									}
								}
							}
					%>
	</li>
	<%
						}
					}
					%>
</ul>
</div>
<%}else{%>
<div class="pop_box">
<div class="center">
<p>설문에 응답해 주셔서 감사합니다.</p>
</div>
</div>
<div class="center"><span class="btn_pack medium"><input
	type="button" onclick="self.close();" value="닫기" /></span></div>
<%} %> <!-- 사후관리 질문End --></div>
<br />
<%if("0".equals(getReltList)){ %>
<div class="btn_area">
<div class="fLeft"><input type="checkbox" name="chkYn" id="chkYn"
	value="" onclick="closeWin();" /><label for="chkYn">오늘 하루 이창을
열지 않음</label></div>
<div class="fRight"><span class="btn_pack medium"><input
	type="submit" value="설문완료" /></span> <span class="btn_pack medium"><input
	type="button" onclick="self.close();" value="닫기" /></span></div>
</div>
<%} %>
</div>
</div>
</form>
<!-- //wrap -->
</body>
</html>