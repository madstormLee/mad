<%--File Name	: <?=$viewNames->view?>.jsp
	Description : <?=$info->location?> 
	author		: <?=$info->writer?> 
	generated   : <?=date('Y-m-d')?> 
	version		: 1.0
--%>

<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Map"%>
<%@ page import="com.a2m.framework.consts.VarConsts"%>  

<jsp:useBean id="ut" class="com.a2m.framework.util.ReqUtils"></jsp:useBean>
<%
	String cp = request.getContextPath();

	Map getValue = (Map)request.getAttribute("getValue");	

<? foreach( $config->columns as $name => $column ) : ?>
	String <?=strToLower($name)?> = "";
<? endforeach; ?>

	if(getValue != null) {
<? foreach( $config->columns as $name => $column ) : ?>
		<?=strToLower($name)?> = "" + getValue.get("<?=$name?>");
		if ( "null".equals(<?=strToLower($name)?>) ) <?=strToLower($name)?> = "";
<? endforeach; ?>
	}		

	String cdate = ut.getCurrentDate();
%>

<%@ include file="/A_inc/M_inc_top_crm.jsp" %>

 <!--메뉴추가 -->     
<script type="text/javascript" src="<%=cp %>/cheditor/cheditor.js"></script>

<!--내용 컨텐츠 s -->
<h1><?=$config->label?> 보기</h1>
<div id="<?=$config->name?>">
	<table>
		<thead>
		<tr>
			<th>제목</th>
			<th>내용</th>
		<tr>
		</thead>
		<tbody>
<? foreach( $info->columns as $name => $column) :?>
		<tr>
			<td class='title'><?=$config->columns->$name->label?></td>
			<td><%=<?=strToLower($name)?>%></td>
		<tr>
<? endforeach; ?>
		<tbody>
	</table>
	<div class="navi">
		<a href='<?=$viewNames->list?>.do'>리스트</a>
	</div> 
</div>       

<!--내용 컨텐츠 s -->  
</div>
<!--컨텐츠 박스 1000px -->       
<%@ include file="/A_inc/M_inc_bot_crm.jsp" %>
