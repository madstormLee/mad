<%

/*
response.setStatus(301);
response.setHeader( "Location", request.getContextPath() + "/mng/conts/sytmMng/mngr_bbs00_l.do" );
response.setHeader( "Connection", "close" );
*/
%>
<script>
location.href="<%=request.getContextPath()%>/mng/conts/sytmMng/mngr_bbs00_l.do?bbs_id=3";
</script>