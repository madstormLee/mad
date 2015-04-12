<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: 대전테크노파크 pims 사업정보관리스템 ::</title>
<link rel="stylesheet" type="text/css" href="../A_css/common.css" />
</head>

<body class="main">
	<div id="pop">
    <h2><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" />사업소개 서브 타이틀</h2>
    <div id="search_list2">
    <table cellpadding="0" cellspacing="0" class="table_sea_1">
			<colgroup>
				<col width="30%" />
				<col width="30%" />
				<col width="40%" />
			</colgroup>
			<tbody>
			<tr>
			  <td class="right">기술분류:</td>
			  <td><select name="list_select2" id="list_select2">
                <option selected="selected">전체</option>
              </select>
		      &nbsp;
		      <select name="list_select3" id="list_select3">
                <option selected="selected">전체</option>
              </select>
		      &nbsp;
		      <select name="list_select4" id="list_select4">
                <option selected="selected">전체</option> 
              </select>
              </td>
              <td rowspan="3"><img src="../A_img/common/M_btn/btn_search2.gif" width="42" height="30" /></td>
			</tr>
			<tr>
			  <td class="right">키워드:</td>
			  <td><input type="text" size="24" id="list_search2" title="검색할 단어를 입력하세요" /></td>
			  </tr>
			<tr>
			  <td class="right">성명:</td>
			  <td><input type="text" size="24" id="list_search3" title="검색할 단어를 입력하세요" /></td>
			  </tr>
			</tbody>
			</table> 
  
      </div>
       
    <!--테이블 시작 -->	
         <table cellpadding="0" cellspacing="0" class="table_style_4">
			<colgroup>
				<col width="10%" />
				<col width="40%" />
				<col width="50%" />
			</colgroup>
			<thead>
			<tr>
				<th>선택</th>
                <th>자료명</th>
				<th>자료명</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			  <td>
			      <input type="checkbox" name="checkbox" id="checkbox" />
			  </td>
			  <td>텍스트 내용입니다.</td>
              <td>텍스트 내용입니다.</td>
			</tr>
			</tbody>
	  </table> 
            <!--테이블 시작 -->	   
               
                
         <!--btn s --> 
          <div class="btn_area">
			<div class="right">
			<span class="btn_pack medium"><input type="submit" value="목록"/></span>   &nbsp;
			</div>
		  </div> 
           <!--btn e --> 
    </div>




</body>
</html>