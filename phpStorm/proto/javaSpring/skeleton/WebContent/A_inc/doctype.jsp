<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<%@ page import="org.springframework.web.util.WebUtils"%>
<%@ page import="com.a2m.framework.consts.VarConsts"%>
<%@ page import="java.util.Map"%>
<%
//Session Info
Map Sessinfo = (Map)WebUtils.getSessionAttribute(request, VarConsts.SESS_USER);
String sess_id = "", sess_nm="", sess_lev="", sess_dept="",sess_dept_nm="", sess_pos_cd="";

//START TEMP; 임시로 로그인 정보 박아놓기.
if(Sessinfo==null){
	Sessinfo = new java.util.HashMap();
}
Sessinfo.put("SABUN", "djtp");
Sessinfo.put("NM", "관리자");
Sessinfo.put("LEV", "ADM");
Sessinfo.put("ORG_CD", "11001");
Sessinfo.put("ORG_NM", "산업평가팀");
//Sessinfo.put("POS_CD", null);
//END TEMP

if(Sessinfo != null){
	
	for(Object o : Sessinfo.keySet()){
		System.out.println(o+" : "+Sessinfo.get(o));
	}
	
	sess_id 		= (String)Sessinfo.get("SABUN"); //로그인 아이디
	sess_nm 		= (String)Sessinfo.get("NM");// 성명
	sess_lev 		= (String)Sessinfo.get("LEV");//등급  ADM:관리자 ,MID:중간관리자[원장/센터장/단장/실장] ,CHG:담당자
	sess_dept 		= (String)Sessinfo.get("ORG_CD");//조직코드
	sess_dept_nm	= (String)Sessinfo.get("ORG_NM");//조직명
	sess_pos_cd		= (String)Sessinfo.get("POS_CD");//직위

}else{
	response.sendRedirect("/mngrLogin.do");
}
if(sess_id==null||sess_id.equals("null")){
	response.sendRedirect("/mngrLogin.do");
}

String reqPageInfo=request.getRequestURI();//현재 페이지정보
String subTit="",pos="";
if(reqPageInfo.indexOf("/db_mng/")>0||reqPageInfo.indexOf("/basis/")>0){ subTit="홈 &gt; 기초DB"	;pos="01";
}else if(reqPageInfo.indexOf("/buss_annc/")>0){	subTit="홈 &gt; 사업공고"		;pos="02";
}else if(reqPageInfo.indexOf("/buss_plan/")>0){	subTit="홈 &gt; 기술애로관리"	;pos="03";
}else if(reqPageInfo.indexOf("/aft_mng/")>0){	subTit="홈 &gt; 사후관리"		;pos="04";
}else if(reqPageInfo.indexOf("/stat_sch/")>0){	subTit="홈 &gt; 커뮤니티관리"	;pos="05";
}else if(reqPageInfo.indexOf("/systm_mng/")>0 ||reqPageInfo.indexOf("/sytmMng/")>0){subTit="홈 &gt; 시스템관리"	;pos="06";
}
%>