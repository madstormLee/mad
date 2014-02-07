<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<div id="login">     
<div id="login_loc">
	<img src="<%=request.getContextPath()%>/A_img/common/M_sub/m_login_ico.gif" /><span class="name"><%=sess_nm %></span> 님 환영합니다.
	
	<span class="btn_pack small">
		<a href="<%=request.getContextPath() %>/mng/conts/basis/mngr_insa_mng01_v.do?sabun=<%=sess_id%>" 
         onclick="window.open(this.href,'info_pop','width=550px, height=300px, scrollbars=yes, location=no, status=no'); return false;" >PW변경</a>
	</span>
	<span class="btn_pack small">
		<a href="<%=request.getContextPath() %>/mng/conts/basis/site_map00_p.do" onclick="window.open(this.href,'info_pop','width=680px, height=950px, scrollbars=yes, location=no, status=no'); return false;" >사이트맵</a>
	</span>
	<!-- 
	<span class="btn_pack small">
		<a href="http://pims.djtp.or.kr/infofile/mngr.pdf" target="_blank">지침서</a>
	</span>
	 -->
</div> 
<div id="login_btn">
		<a href="<%=request.getContextPath()%>/A_inc/logOut.jsp">
			<img src="<%=request.getContextPath()%>/A_img/common/M_sub/m_btn_logout.gif" border="0"/>
		 </a>
	</div>