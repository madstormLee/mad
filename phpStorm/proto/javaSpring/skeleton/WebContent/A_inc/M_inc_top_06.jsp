<%@ page contentType="text/html; charset=utf-8" %>
<%@ include file="/A_inc/doctype.jsp" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>기술연계플랫폼</title>
<link rel="stylesheet" type="text/css" href="<%=request.getContextPath() %>/A_css/common.css" />
<link rel="stylesheet" type="text/css" href="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/css/redmond/jquery-ui-1.8.6.custom.css" media="screen" />
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-latest.js"></script> 
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery.validate.js" ></script>
<!-- 달력s -->
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/development-bundle/ui/jquery-ui-1.8.5.custom.js"></script>
<style type="text/css" >
	#ui-datepicker-div{	font-size: 84%;}
</style>
<!-- 달력e -->
<style type="text/css">
<!--
-->
</style>

</head>

<body>
<div id="wrap">
<div id="header_map"><img src="<%=request.getContextPath() %>/A_img/common/M_sub/m_head_ico.gif" width="22" height="17" /><%=subTit%></div>

<!--컨텐츠 박스 1000px -->       
<div id="con_top_img01">
	<div id="sidebar">
		<h1><a href="<%=request.getContextPath() %>/mng/conts/basis/mngr_membInfo00_l.do"><img src="<%=request.getContextPath()%>/A_img/common/M_sub/m_logo.gif" border="0" /></a></h1>
            <!--<div id="sidebar_quick"><p><img src="<%=request.getContextPath() %>/A_img/common/M_sub/quick_img.gif" /></p></div> -->
                
        		<div id="sidebar_menu">
                <p><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_top.gif" /></p>
                <h2><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico.gif" />시스템관리</h2>
                <h3><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico2.gif"  width="10" height="7" />
                     <a href="<%=request.getContextPath() %>/mngr/sytmMng/mngr_ndstClsf00_l.do" style="text-decoration:none;">                	  
                	  <%
	                   	if(reqPageInfo.indexOf("_ndstClsf")>=0){ %><b><font color="orange">산업표준분류</font></b><%
	                   	}else{%>산업표준분류<%
	                   	}
	                   	%>	                	  
                	  </a>	                
                </h3>
                
                <h3><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico2.gif" width="10" height="7" />
                       <a href="<%=request.getContextPath() %>/mngr/sytmMng/mngr_ndstTech00_l.do" style="text-decoration:none;">                	  
                	  <%
	                   	if(reqPageInfo.indexOf("_ndstTech")>=0){ %><b><font color="orange">산업기술분류</font></b><%
	                   	}else{%>산업기술분류<%
	                   	}
	                   	%>	                	  
                	  </a>	                
                </h3>
                <h3><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico2.gif" width="10" height="7" />
                	<a href="<%=request.getContextPath() %>/mngr/sytmMng/mngr_codeMng00_l.do?type=3" style="text-decoration:none;">                	  
                	  <%
	                   	if(reqPageInfo.indexOf("type=3")>=0){ %><b><font color="orange">코드관리</font></b><%
	                   	}else{%>코드관리<%
	                   	}
	                   	%>	                	  
                	  </a>
                </h3>           	                                       
                <h3><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico2.gif" width="10" height="7" />
                	<a href="<%=request.getContextPath() %>/mng/conts/systm_mng/mngr_insa_mng00_l.do" style="text-decoration:none;">                	  
                	  <%
	                   	if(reqPageInfo.indexOf("_insa")>=0){ %><b><font color="orange">내부사용자관리</font></b><%
	                   	}else{%>내부사용자관리<%
	                   	}
	                   	%>	                	  
                	  </a>
                </h3>
                <h3><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico2.gif" width="10" height="7" />  
                	 <a href="<%=request.getContextPath() %>/mng/conts/systm_mng/mngr_popup00_l.do" style="text-decoration:none;">                	  
                	  <%
	                   	if(reqPageInfo.indexOf("_popup")>=0){ %><b><font color="orange">팝업관리</font></b><%
	                   	}else{%>팝업관리<%
	                   	}
	                   	%>	                	  
                	  </a>	                
                </h3>
                <h3> <img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico2.gif" width="10" height="7" />
              		게시판관리
                </h3>
                <ul class="fall">
					<li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" /><a href="<%=request.getContextPath() %>/mng/conts/sytmMng/mngr_bbs00_l.do?bbs_id=1" style="text-decoration:none;">                	  
                	  <%
	                   	if(reqPageInfo.indexOf("bbs_id=1")>=0){ %><b><font color="orange">공지사항</font></b><%
	                   	}else{%>공지사항<%
	                   	}
	                   	%>	                	  
                	  </a>	  
					</li>
				   	<li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" /><a href="<%=request.getContextPath() %>/mng/conts/sytmMng/mngr_bbs00_l.do?bbs_id=3" style="text-decoration:none;">
				   		<%
	                   	if(reqPageInfo.indexOf("bbs_id=3")>=0){ %><b><font color="orange">서식자료</font></b><%
	                   	}else{%>서식자료<%
	                   	}
	                   	%>	                	  
                	  </a>
                	</li>	   	
				    <li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" /><a href="<%=request.getContextPath() %>/mng/conts/sytmMng/mngr_bbs00_l.do?bbs_id=2" style="text-decoration:none;">
				   		<%
	                   	if(reqPageInfo.indexOf("bbs_id=3")>=0){ %><b><font color="orange">기타자료</font></b><%
	                   	}else{%>기타자료<%
	                   	}
	                   	%>	                	  
                	  </a>
                	</li>   	
				    <li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" /><a href="<%=request.getContextPath() %>/mng/conts/sytmMng/mngr_bbs00_l.do?bbs_id=4" style="text-decoration:none;">
				   		<%
	                   	if(reqPageInfo.indexOf("bbs_id=3")>=0){ %><b><font color="orange">홍보이미지</font></b><%
	                   	}else{%>홍보이미지<%
	                   	}
	                   	%>	                	  
                	  </a>
                	</li>
				    <li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" /><a href="<%=request.getContextPath() %>/mng/conts/sytmMng/mngr_bbs00_l.do?bbs_id=5" style="text-decoration:none;">
				   		<%
	                   	if(reqPageInfo.indexOf("bbs_id=3")>=0){ %><b><font color="orange">홍보동영상</font></b><%
	                   	}else{%>홍보동영상<%
	                   	}
	                   	%>	                	  
                	  </a>
                	</li>
				    <li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" /><a href="<%=request.getContextPath() %>/mng/conts/sytmMng/mngr_bbs00_l.do?bbs_id=6" style="text-decoration:none;">
				   		<%
	                   	if(reqPageInfo.indexOf("bbs_id=3")>=0){ %><b><font color="orange">홍보발간자료</font></b><%
	                   	}else{%>홍보발간자료<%
	                   	}
	                   	%>	                	  
                	  </a>
                	</li>
				    <li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" /><a href="<%=request.getContextPath() %>/mng/conts/sytmMng/mngr_bbs00_l.do?bbs_id=6" style="text-decoration:none;">
				   		<%
	                   	if(reqPageInfo.indexOf("bbs_id=3")>=0){ %><b><font color="orange">성공사례</font></b><%
	                   	}else{%>성공사례<%
	                   	}
	                   	%>	                	  
                	  </a>
                	</li>
				    <li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" />
				    	<a href="<%=request.getContextPath() %>/mngr/sytmMng/mngr_popup00_l.do" style="text-decoration:none;">                	  
					<%
						if(reqPageInfo.indexOf("_popup")>=0){ %><b><font color="orange">게시판권한관리</font></b><%
						}else{%>게시판권한관리<%
						}
					%>	                	  
						</a>
				    </li>
				</ul>
				<h3> <img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico2.gif" width="10" height="7" />
					설문관리
                </h3>
                <ul class="fall">
					<li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" />
						<a href="<%=request.getContextPath() %>/mng/conts/systm_mng/mngr_survInfo00_l.do">설문관리</a>
					</li>
				   	<li><img src="<%=request.getContextPath() %>/A_img/common/M_sub/left_menu_ico3.gif" />
						<a href="<%=request.getContextPath() %>/mng/conts/systm_mng/mngr_survInfo01_l.do">설문항목관리</a>
					</li>	 
				</ul>	                                                            
			</div>
</div>
 