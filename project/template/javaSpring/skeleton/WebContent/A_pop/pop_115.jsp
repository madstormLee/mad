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
    <h2><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" />&nbsp;기업검색</h2>
    <div id="search_list">
	  <input type="text" size="30" id="list_search" title="검색할 단어를 입력하세요" />
				<br />
				
				  <input type="text" id="list_search2" title="검색할 단어를 입력하세요" value="기업명" size="20" />
			      <input type="text" size="30" id="list_search3" title="검색할 단어를 입력하세요" />
			
			<input type="image" src="../A_img/common/M_btn/btn_search.gif" id="list_btn" class="border_none" alt="검색" />

    </div>       
    <!--테이블 시작 -->	
  <table cellpadding="0" cellspacing="0" class="table_style_4">
			<colgroup>
				<col width="50%" />
				<col width="20%" />
				<col width="30%" />
			</colgroup>
			<thead>
			<tr>
				<th>기업명</th>
                <th>대표자</th>
				<th>연락처</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			  <td>(주)에이투엠</td>
			  <td>대표자</td>
              <td>000-0000-0000.</td>
			</tr>
			</tbody>
			</table> 
            <!--테이블 시작 -->	   
               
                
         <!--btn s --> 
          <div class="btn_area">
			<div class="right">
			<span class="btn_pack medium"><input type="submit" value="창닫기"/></span>   &nbsp;
			</div>
		  </div> 
           <!--btn e --> 
    
    
    </div>



</body>
</html>