<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>과제정보</title>
<link rel="stylesheet" type="text/css" href="/A_css/common.css" />
</head>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Map"%>
<%@ page import="java.lang.Integer"%>
<%@ page import="com.a2m.framework.consts.VarConsts"%>
<jsp:useBean id="ut" class="com.a2m.framework.util.ReqUtils"></jsp:useBean>
<%

	Map getValue = (Map)request.getAttribute("getValue");
	List getInstList = (List)request.getAttribute("getInstList");
	
	String prjt_nm="", sprt_ara_cd="", entp_ko_nm="", buss_no="", copr_no="", cptn_nm="", kind="", bcon="", nm_ko="", chrg_regno1="",
		   dptm_nm="", link_no="", pstn="", clpn_no="", eml="", fax="", entp_stdt="", entp_eddt="", tech_clsf_nm="", sprt_my="",
		   priv_cst="", priv_nknd="", priv_bc="", priv_abc="", stf_nm="", stf_blng="", stf_tel="", stf_fax="", stf_eml="",
		   goal="", cont="", expc_effc="", keyw_ko="", keyw_eng="", ndst_clsf_nm="", buss_rgst_no="",
		   buss_img_real="", buss_img_nm="", att_dcmt_file="", sprt_ara_nm="";
	
	String prjt_no = (String)request.getParameter("prjt_no");
	
	if(getValue!=null){
		prjt_nm 	= (String)getValue.get("PRJT_NM");
		sprt_ara_cd = (String)getValue.get("SPRT_ARA_CD");
		sprt_ara_nm = (String)getValue.get("SPRT_ARA_NM");
		entp_ko_nm 	= (String)getValue.get("ENTP_KO_NM");
		buss_no 	= (String)getValue.get("BUSS_NO");
		copr_no 	= (String)getValue.get("COPR_NO");
		cptn_nm 	= (String)getValue.get("CPTN_NM");
		kind 		= (String)getValue.get("KIND");
		bcon 		= (String)getValue.get("BCON");
		nm_ko 		= (String)getValue.get("NM_KO");
		chrg_regno1 = (String)getValue.get("CHRG_REGNO1");
		dptm_nm 	= (String)getValue.get("DPTM_NM");
		link_no 	= (String)getValue.get("LINK_NO");
		pstn 		= (String)getValue.get("PSTN");
		clpn_no 	= (String)getValue.get("CLPN_NO");
		eml 		= (String)getValue.get("EML");
		fax 		= (String)getValue.get("FAX");
		entp_stdt 	= (String)getValue.get("ENTP_STDT");
		entp_eddt 	= (String)getValue.get("ENTP_EDDT");
		tech_clsf_nm = (String)getValue.get("TECH_CLSF_NM");
		ndst_clsf_nm = (String)getValue.get("NDST_CLSF_NM");
		sprt_my 	= (String)getValue.get("SPRT_MY");
		priv_cst	= (String)getValue.get("PRIV_CST");
		priv_nknd	= (String)getValue.get("PRIV_NKND");
		priv_bc 	= (String)getValue.get("PRIV_BC");
		priv_abc 	= (String)getValue.get("PRIV_ABC");
		stf_nm 		= (String)getValue.get("STF_NM");
		stf_blng 	= (String)getValue.get("STF_BLNG");
		stf_tel 	= (String)getValue.get("STF_TEL");
		stf_fax		= (String)getValue.get("STF_FAX");
		stf_eml 	= (String)getValue.get("STF_EML");
		goal 		= (String)getValue.get("GOAL");
		cont 		= (String)getValue.get("CONT");
		expc_effc 	= (String)getValue.get("EXPC_EFFC");
		keyw_ko 	= (String)getValue.get("KEYW_KO");
		keyw_eng	= (String)getValue.get("KEYW_ENG");
		buss_img_real= (String)getValue.get("BUSS_IMG_REAL");
		buss_img_nm	= (String)getValue.get("BUSS_IMG_NM");
		att_dcmt_file	= (String)getValue.get("ATT_DCMT_FILE");
		buss_rgst_no= (String)getValue.get("BUSS_RGST_NO");
		
	}
	String brn = buss_rgst_no.substring(0,3)+"-"+buss_rgst_no.substring(3,5)+"-"+buss_rgst_no.substring(5);

%>
<script type="text/javascript">
function printWindow() {
	factory.printing.header       = "";
	factory.printing.footer       = "";
	factory.printing.portrait     = true;
	factory.printing.leftMargin   = 20.0;
	factory.printing.topMargin    = 15.0;
	factory.printing.rightMargin  = 20.0;
	factory.printing.bottomMargin = 15.0;
	factory.printing.Print(false, window);
}
function displaybtn(){
	//인쇄 시 출력하기 이미지 버튼 안보이도록 설정하는 알고리즘
	//출력하기 버튼 클릭하면 처음에 출력버튼을 숨겼다가 인쇄 후 0.05초정도 후에 다시 출력하기 버튼 디스플레이한다.
	 setTimeout(showprintbtn,50)
}
function showprintbtn(){
	//출력하기 버튼 디스플레이
	document.getElementById('idControls').style.display = "inline";
}
function printWindowPriview() {
	factory.printing.header = ""; //윗쪽타이틀
	factory.printing.footer = ""; //아랫쪽타이틀
	factory.printing.portrait = true; //인쇄레이아웃설정, 가로(false), 세로(true)
	factory.printing.leftMargin = 0.5; //왼쪽여백
	factory.printing.topMargin = 0.5;//윗쪽여백
	factory.printing.rightMargin = 0.5; //오른쪽여백
	factory.printing.bottomMargin = 0.5; //아랫쪽여백
	factory.printing.Preview();


	var templateSupported = factory.printing.IsTemplateSupported();
	var controls = idControls.all.tags("input");
	for ( i = 0; i < controls.length; i++ ) {
		controls[i].disabled = false;
		if ( templateSupported && controls[i].className == "ie55" ){
			controls[i].style.display = "inline";
		}
	}
}
</script>
<body class="main">
	<div id="pop">
    <h2><img src="/A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" />기본정보</h2>
       
	<!--테이블 시작 -->	
		<table class="table_style_4" summary="과제기본정보">
			<caption>과제기본정보</caption>
			<colgroup>
				<col width="10%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
			</colgroup>
			<tbody>
			<tr>
				<th colspan="2">과제(신청)명</th>
				<td colspan="2" class="table_text_left"><%=prjt_nm%></td>
				<th>지원분야</th>
				<td colspan="2" class="table_text_left"> <%=sprt_ara_nm%></td>
			</tr>
			<tr>
				<th rowspan="3">주관<br />기업</th>
				<th class="in">기업명</th>
				<td colspan="2" class="table_text_left"><%=entp_ko_nm%></td>
				<th>사업자등록번호</th>
				<td colspan="2" class="table_text_left"><%=brn %></td>
			</tr>
			<tr>
				<th class="in">법인번호</th>
				<td colspan="2" class="table_text_left"><%=copr_no%></td>
				<th>대표자 성명</th>
				<td colspan="2" class="table_text_left"><%=cptn_nm%></td>
			</tr>
			<tr>
				<th class="in">주업종</th>
				<td colspan="2" class="table_text_left"><%=kind%></td>
				<th>주업태</th>
				<td colspan="2" class="table_text_left"><%=bcon%></td>
			</tr>
			<tr>
				<th rowspan="4"><p>총괄<br />책임자</p></th>
				<th class="in">성명</th>
				<td colspan="2" class="table_text_left"><%=nm_ko%></td>
				<th>주민등록번호</th>
				<td colspan="2" class="table_text_left"><%=chrg_regno1%>-*******</td>
			</tr>
			<tr>
				<th class="in">부서</th>
				<td colspan="2" class="table_text_left"><%=dptm_nm%></td>
				<th>전화</th>
				<td colspan="2" class="table_text_left"><%=link_no%></td>
			</tr>
			<tr>
				<th class="in">직위</th>
				<td colspan="2" class="table_text_left"><%=pstn%></td>
				<th>휴대전화</th>
				<td colspan="2" class="table_text_left"><%=clpn_no%></td>
			</tr>
			<tr>
				<th class="in">이메일</th>
				<td colspan="2" class="table_text_left"><%=eml%></td>
				<th>팩스</th>
				<td colspan="2" class="table_text_left"><%=fax%></td>
			</tr>
			<tr>
				<th rowspan="<%=getInstList.size()+8 %>">신청<br />내역</th>
				<th class="in">총사업기간</th>
				<td colspan="2" class="table_text_left"><%=entp_stdt+" ~ "+entp_eddt%></td>
				<th>산업기술분류</th>
				<td colspan="2" class="table_text_left"><%=tech_clsf_nm%></td>
			</tr>
			<tr>
				<th rowspan="2" class="in"><p>총사업비<br /></p></th>
				<th class="in">출연금<br />
					(시비/국비)A</th>
				<th class="in">민간부담금<br />
					(현금)B</th>
				<th class="in">민간부담금<br />
					(현물)C</th>
				<th class="in">민간부담금합계<br />
				(B+C)</th>
				<th class="in">합계<br />
				(A+B+c)</th>
			</tr>
			<tr>
				<td class="center"><%=ut.numFormat(""+(Long.parseLong(ut.getEmptyResult2(sprt_my,"0"))*1000))%>&nbsp;(원)</td>
				<td class="center"><%=ut.numFormat(""+(Long.parseLong(ut.getEmptyResult2(priv_cst,"0"))*1000))%>&nbsp;(원)</td>
				<td class="center"><%=ut.numFormat(""+(Long.parseLong(ut.getEmptyResult2(priv_nknd,"0"))*1000))%>&nbsp;(원)</td>
				<td class="center"><%=ut.numFormat(""+(Long.parseLong(ut.getEmptyResult2(priv_bc,"0"))*1000))%>&nbsp;(원)</td>
				<td class="center"><%=ut.numFormat(""+(Long.parseLong(ut.getEmptyResult2(priv_abc,"0"))*1000))%>&nbsp;(원)</td>
			</tr>
			<tr>
				<th rowspan="2" class="in">실무담당자</th>
				<th class="in">성명</th>
				<th class="in">소속</th>
				<th class="in">연락처</th>
				<th class="in">팩스</th>
				<th class="in">이메일</th>
			</tr>
			<tr>
				<td class="center"><%=ut.getEmptyResult2(stf_nm,"&nbsp;")%></td>
				<td class="center"><%=stf_blng%></td>
				<td class="center"><%=ut.telNum((String)stf_tel)%></td>
				<td class="center"><%=ut.telNum((String)stf_fax)%></td>
				<td class="center"><%=stf_eml%></td>
			</tr> 
			<tr>
				<th>전략산업분류</th>
				<td colspan="6" class="table_text_left"><%=ndst_clsf_nm%></td>
			</tr>
			<tr>
				<th colspan="6">참여(공급기관)/위탁기관</th>
			</tr>
			<tr>
				<th>참여/위탁구분</th>
				<th>업체명</th>
				<th>책임자성명</th>
				<th>주민등록번호</th>
				<th>연락처</th>
				<th>유형</th>
			</tr>
			<%if(getInstList.equals("") || getInstList.isEmpty()){ %>		
			<tr>
				<td colspan="7">참여/위탁기관 정보가 없습니다.</td>
			</tr>
			<%
			}else{ 
				Map ro =null;
				for(int i=0; i<getInstList.size(); i++){
					ro = ut.getResultNullChk((Map)getInstList.get(i));
					String reg = (String)ro.get("CHRG_REGNO");//주민등록번호
					String reg1 = reg.substring(0,6);
					String reg2 = reg.substring(6,13);
					String reg3="*******";
					
					
			%>
			<tr>
				<td><%=ro.get("DVSN")%></td>
				<td><%=ro.get("ENTP_KO_NM")%></td>
				<td><%=ro.get("CHRG_NM")%></td>
				<td><%=reg1 %>-<%=reg3 %></td>
				<td><%=ut.telNum((String)ro.get("CHRG_TEL"))%></td>
				<td><%=ro.get("TYPE")%></td>
			</tr>
			<% 
					}
				}
			%>
			<tr>
				<th colspan="2">사업계획서</th>
				<td colspan="5" class="table_text_left"><%if(!"".equals(buss_img_real)){%><a href="<%=request.getContextPath()%>/common/down.do?prjt_no=<%=prjt_no%>&file_div=buss"><%=buss_img_nm%></a><%}%></td>
			</tr>
			<tr>
				<th colspan="2">첨부서류</th>
				<td colspan="5" class="table_text_left">
				<%
					String arr[] = null;
					if(!"".equals(att_dcmt_file)){
						arr = att_dcmt_file.split("\\|");
						if(arr.length > 0){
							String[] att = null;
							for(int i=0; i<arr.length; i++){
								att = arr[i].split("\\*");
				%>	<a href="<%=request.getContextPath()%>/common/down.do?nm=<%=att[0]%>&real=<%=att[1]%>&file_div=att"><%=att[0]%></a>
				<%
							}
						}
					}
				%></td>
			</tr>
			<tr>
				<th colspan="2">목표<br />(1500자이내)</th>
				<td colspan="5" class="table_text_left"><%=ut.textToHtml(goal)%></td>
			</tr>
			<tr>
				<th colspan="2">내용<br />(1500자이내)</th>
				<td colspan="5" class="table_text_left"><%=ut.textToHtml(cont)%></td>
			</tr>
			<tr>
				<th colspan="2">기대효과<br />(1500자이내)</th>
				<td colspan="5" class="table_text_left"><%=ut.textToHtml(expc_effc)%></td>
			</tr>
			<tr>
				<th colspan="7" >키워드</th>
			</tr>
			<tr>
				<th colspan="2">한글</th>
				<td colspan="5" class="table_text_left"><%=keyw_ko%></td>
			</tr>
			<tr>
				<th colspan="2">영문</th>
				<td colspan="5" class="table_text_left"><%=keyw_eng%></td>
			</tr>
			</tbody>
		</table> 
        <object id=factory style="display:none"
		  classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814"
		  codebase="/js/smsx.cab#Version=6,6,440,20">
		</object>        
         <!--btn s --> 
          <div class="btn_area">
			<div class="right" id="idControls">
			<span class="btn_pack medium"><a href="javascript:document.getElementById('idControls').style.display='none';printWindow();displaybtn();">인쇄하기</a></span>
			<span class="btn_pack medium"><input type="button" onclick="window.close();" value="닫기"/></span>   &nbsp;
			</div>
		  </div> 
           <!--btn e --> 
    
    
    </div>



</body>
</html>