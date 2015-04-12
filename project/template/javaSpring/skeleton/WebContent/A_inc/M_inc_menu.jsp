<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
       <div id="gnb_menu">
		<ul class="gnb">
		
        	<li><a href="<%=request.getContextPath() %>/mng/conts/basis/mngr_membInfo00_l.do"><img src="<%=request.getContextPath() %>/A_img/common/M_sub/m_menu01<%if("01".equals(pos)){%>_r<%}%>.gif" alt="기초DB"/></a></li>
        	<li><a href="<%=request.getContextPath() %>/mng/conts/buss_annc/mngr_buss_annc00_l.do"><img src="<%=request.getContextPath() %>/A_img/common/M_sub/m_menu02<%if("02".equals(pos)){%>_r<%}%>.gif"  alt="사업공고"/></a></li>
        	<li><a href="<%=request.getContextPath() %>/mngr/buss_plan/mngr_bussDvsn00_l.do"><img src="<%=request.getContextPath() %>/A_img/common/M_sub/m_menu03<%if("03".equals(pos)){%>_r<%}%>.gif"  alt="사업계획"/></a></li>
            <li><a href="<%=request.getContextPath() %>/mng/conts/aftMng/mngr_ccltMng00_l.do" ><img src="<%=request.getContextPath() %>/A_img/common/M_sub/m_menu04<%if("04".equals(pos)){%>_r<%}%>.gif"  alt="사후관리"/></a></li>
            <li><a href="<%=request.getContextPath() %>/mngr/stat_sch/mngr_sltBussSch00_l.do"><img src="<%=request.getContextPath() %>/A_img/common/M_sub/m_menu05<%if("05".equals(pos)){%>_r<%}%>.gif"  alt="현황검색"/></a></li>
			<li><a href="<%=request.getContextPath() %>/mngr/sytmMng/mngr_ndstClsf00_l.do" ><img src="<%=request.getContextPath() %>/A_img/common/M_sub/m_menu06<%if("06".equals(pos)){%>_r<%}%>.gif"  alt="시스템관리"/></a></li>
        </ul>
   	  </div>
<!-- menu//  -->