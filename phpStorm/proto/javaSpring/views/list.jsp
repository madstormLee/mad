<%--File Name	: <?=$viewNames->list?>.jsp
	Description : <?=$info->location?> 
	author		: <?=$info->writer?> 
	generated   : <?=date('Y-m-d')?> 
	version		: 1.0
--%>

<%@ page contentType="text/html; charset=utf-8"%>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Map"%>
<%@ page import="com.a2m.framework.consts.VarConsts"%>

<jsp:useBean id="ut" class="com.a2m.framework.util.ReqUtils"></jsp:useBean>
<%
	List list = (List)request.getAttribute("getList");
	Map listparam = (Map)request.getAttribute("listparam");
	
	int cPage 		= Integer.parseInt(""+listparam.get("cPage"));
	int intListCnt 	= Integer.parseInt(""+listparam.get("intListCnt"));
	int pageCnt 	= Integer.parseInt(""+listparam.get("pageCnt"));
	int totalCnt 	= Integer.parseInt(""+listparam.get("totalCnt"));
	
	Map row = null;
	int totalPage = (totalCnt - 1 ) / intListCnt +1 ;
	
	String params = "";
	
	/* 검색 파라메터값  */
<? foreach( $info->searchColumns as $name => $search ) : ?>
<? if ( $search->show == false ) continue; ?>
	String <?=strToLower($name)?> = ut.getEmptyResult2( (String)request.getParameter("<?=$name?>"), "");
<? endforeach; ?>
%>

<!-- 컨텐츠 박스 s-->
<%@ include file="/A_inc/M_inc_top_crm.jsp" %>
	<!--내용 컨텐츠 s -->
	<div id="con">
	<h1><?=$config->label?> 목록</h1>

	<p class="result_count">총 <strong><%=totalCnt%></strong>건 [<%=cPage %>/<%=totalPage %>페이지]</p>
	
	<form id="<?=$config->name?>SearchForm" class="board_search" method="get" action="?">
		<fieldset>
			<legend>게시물 검색</legend> 
			<ul>
<? foreach( $info->searchColumns as $name => $search ) :
				$data = $config->columns->$name;
				$name = strToLower( $name );
				$formUnit = $formFactory->create( $data->type );
				$formUnit->id = $name;
				$formUnit->name = $name;
				$formUnit->label = $data->label;
				$formUnit->value = "<%=$name%>";
				?>
				<li><?=$formUnit->getLabel()?> <?=$formUnit?></li>
<? endforeach; ?>
			</ul>
			<button class='btnSearch' type="submit">검색</button>
		</fieldset>
	</form>
		
	<!--테이블 시작 -->
	<table class="table_style_2">
		<thead>
			<tr>
				<th>번호</th>
<? foreach( $info->columns as $name => $column) : ?>
				<th><?=$config->columns->$name->label?></th>
<? endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<% for(int i = 0;i < list.size();i++){
				row = ut.getResultNullChk((Map)list.get(i)); %>
			<tr>
				<td><%=totalCnt-(i+((cPage-1)*intListCnt))%></td>
<? foreach( $info->columns as $name => $column ) : ?>
<? if ( $column->href ) : ?>
				<td class='title'><a href="<?=$viewNames->view?>.do?id=<%=row.get("ID")%>"><%=row.get("<?=strToUpper($name)?>")%></a></td>
<? else : ?>
				<td><%=row.get("<?=strToUpper($name)?>")%></td>
<? endif; ?>
<? endforeach; ?>
			</tr>
			<%	} //end for %>
		</tbody>
	</table>

	<% if(list == null || list.isEmpty()){ %>
	<p class='noContent'>데이터가 없습니다.</p>
	<% } %>

	<!--테이블 시작 --> 
	
	<!--페이지s -->
	<div class="pagination"><%=(String)request.getAttribute("pageNavigator")%></div>
	<!--페이지e --> 
	
	<!--btn s -->
	<div class="btn_area">
		<a class="btn_pack medium" href='<?=$viewNames->write?>.do'>등록</a>
	</div>
	
	</div>
	<!--내용 컨텐츠 s -->
</div>
<!--컨텐츠 박스 1000px -->
<%@ include file="/A_inc/M_inc_bot_crm.jsp"%>
