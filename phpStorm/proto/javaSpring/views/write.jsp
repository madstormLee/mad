<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Map"%>
<%@ page import="com.a2m.framework.consts.VarConsts"%>  

<jsp:useBean id="ut" class="com.a2m.framework.util.ReqUtils"></jsp:useBean>
<%
	String cp = request.getContextPath();
	String id = request.getParameter( "id" );

	Map getValue = (Map)request.getAttribute("getValue");	

<? foreach( $info->columns as $name => $column ) : ?>
<?  if ( $name == 'no' ) $name = 'id'; ?>
	String <?=strToLower($name)?> = "";
<? endforeach; ?>

	if(getValue != null) {
<? foreach( $info->columns as $name => $column ) : ?>
		<?=strToLower($name)?> = "" + getValue.get("<?=$name?>");
<? endforeach; ?>
	}		

	String mode, btnLabel;
	if( id==null || "".equals(id)){
		mode = VarConsts.MODE_I;
		btnLabel = "저장";
	}else{
		mode = VarConsts.MODE_U;
		btnLabel = "수정";
	}

	String cdate = ut.getCurrentDate();
%>

<%@ include file="/A_inc/M_inc_top_crm.jsp" %>

 <!--메뉴추가 -->     
<script type="text/javascript" src="<%=cp %>/cheditor/cheditor.js"></script>

<!--내용 컨텐츠 s -->
<h1><?=$config->label?> 작성</h1>
<form id="<?=$config->name?>Form" enctype="multipart/form-data" class="board_search" method="post" action="<?=$viewNames->insert?>.do">
	<input type="hidden" name="mode" value="<%=mode%>" />
	<ul>
<? foreach( $info->columns as $name => $column ) :
		$data = $config->columns->$name;
		$name = strToLower( $name );
		$form = $formFactory->create( $data->type );
		$form->id = $name;
		$form->name = $name;
		$form->label = $data->label;
		?>
		<li><?=$form->getLabel()?> <?=$form?></li>
<? endforeach; ?>
	</ul>
	<button type="submit"><%=btnLabel%></button>
	<!--btn s --> 
	<div class="navi">
		<a href='<?=$viewNames->list?>.do'>리스트</a>
	</div> 
	<!--btn e -->           
</form>       
<!--내용 컨텐츠 s -->  
</div>
<!--컨텐츠 박스 1000px -->       
<%@ include file="/A_inc/M_inc_bot_crm.jsp" %>
