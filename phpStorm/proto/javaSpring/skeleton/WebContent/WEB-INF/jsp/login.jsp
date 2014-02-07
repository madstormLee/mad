<%@page contentType="text/html;charset=UTF-8"%>
<%@ include file="/inc/doctype.jsp"%>
<title>BIZPORTAL</title>
<%@ include file="/inc/header.jsp"%>

<%
	String mode = request.getParameter("mode");

	if("".equals(mode)){
		mode = "in";
	}
%>

<div class="page_title">
<div class="page_title_left">
<h1>로그인</h1>
</div>
<div class="site_path"><a href="/">홈</a> &gt; <a class="b"
	href="#">로그인</a></div>
</div>
<script type="text/javascript"
	src="<%=request.getContextPath() %>/js/U_js/common.js"></script>
<form name="form1" id="form1"
	action="<%=request.getContextPath() %>/login.do" method="post"
	onsubmit="return LoginformCheck();"><input type="hidden"
	name="mode" value="<%=mode%>" />

<div class="mem_login">
<div class="login_form">
<div class="login_left"><img
	src="<%=request.getContextPath()%>/images/member/login_tit.gif"
	alt="Member Login" /></div>
<div class="login_right">
<dl>
	<dd><input type="radio" id="gubun1" name="gubun" value="1"
		checked="checked" /> <label for="gubun1">기업</label> <input
		type="radio" id="gubun2" name="gubun" value="2" /> <label
		for="gubun2">기관</label></dd>
</dl>
<dl>
	<dt><label for="buss_no">사업자등록번호</label></dt>
	<dd><input type="text" name="buss_no" id="buss_no" class="itxt"
		size="20" /></dd>
	<dt><label for="pwd">비밀번호</label></dt>
	<dd><input type="password" name="pwd" id="pwd" class="itxt"
		size="20" /></dd>
</dl>

<input type="image"
	src="<%=request.getContextPath()%>/images/member/btn_login.gif"
	alt="로그인" class="btn" /></div>
</div>

</div>


</form>
<%@ include file="/inc/footer.jsp"%>