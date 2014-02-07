<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: 대전테크노파크 pims 사업정보관리스템 ::</title>
<link rel="stylesheet" type="text/css" href="/css/common.css" />
<link rel="stylesheet" type="text/css" href="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/css/redmond/jquery-ui-1.8.6.custom.css" media="screen" />
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-latest.js"></script> 
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/js/jquery-ui-1.8.5.custom/js/jquery.validate.js" ></script>
<script type="text/javascript">
$().ready(function() {
	$("#form1").validate({
		rules: {
			sabun: {		//아이디
				required: true,
				maxlength: 20,
				number:false
			},
			pw: {		//비밀번호
				required: true,
				maxlength: 50,
				number:false
			}
			
		},
		messages: {
			sabun: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			}
			,
			pw: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			}
		}
	});
});
</script>
</head>

<body class="login">
 <div id="admin_login_outer">
 <div id="admin_login_inner">
 <form name="form1" action="mngLogin_t.do" method="post" onsubmit="return true">
	<table cellpadding="0" cellspacing="0" class="table_admin_login">
		<colgroup>
			<col width="80%" />
			<col width="20%" />
		</colgroup>
		<tbody>
		<tr>
		  <td>
		  	<input type="text" name="sabun" id="sabun" value=""  tabindex="1"/>
		  </td>
		  <td rowspan="2"><input type="image" src="/U_img/btn/btn_adm_login.gif" width="55" height="56" style="border: 0px" /></td>
		</tr>
        <tr>
		  <td><input type="password" name="pw" id="pw" value="" tabindex="2"/></td>
		</tr>
		</tbody>
	</table> 
 </form>
</div>
</div>
    


</body>
</html>
