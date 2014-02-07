<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>

<%@ include file="../A_inc/M_inc_top_01.jsp" %>

<!-- 컨텐츠 박스 s--> 
<div id="con_box">
   
 <!--로그인 정보 s -->  
<%@ include file="../A_inc/M_inc_login.jsp" %>

 <!--메뉴추가 -->     
<%@ include file="../A_inc/M_inc_menu.jsp" %>
      <!--내용 컨텐츠 s -->
        <div id="con">
		  <h1><img src="../A_img/common/M_sub/con_tit_ico.gif" />과제사업 </h1> 
          <p style="margin:0 0 10px 0;"><img src="../A_img/common/sub_tit_line.gif" /></p>
          
         <!--탭메뉴 -->
          <div class="tab_menu">
			<ul>
			<li class="on"><a href="#">탭메뉴01</a></li>
			<li><a href="#">탭메뉴탭메뉴탭메뉴탭메뉴탭메뉴</a></li>
			<li><a href="#">탭메뉴03</a></li>
			<li class="on"><a href="#">탭메뉴01</a></li>	
			</ul>	
		 </div>
          <!--탭메뉴 -->
          <h2><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" />사업소개 서브 타이틀</h2>
          <p style="margin:3px 0 0 0;"><img src="../A_img/common/sub_tit_line2.gif" /></p>

        <div class="result_count">총 <strong>57</strong>건 [1/6 페이지]</div> 
        <!--search s--> 
        <div class="board_search">
  		<fieldset>
  		<legend>게시물 검색</legend>
		<label for="search_txt"><img src="../A_img/common/board/icon_search.gif" alt="검색" class="txt_search" /></label>
		<select name="">
			<option>제목</option>
			<option>내용</option>
			<option>작성자</option>
		</select>
	 <input type="text" id="search_txt" size="20" title="검색어 입력" value="" class="itxt" />
  		<span style="padding-left:5px"><img src="../A_img/common/M_btn/btn_sch.gif" alt="" width="44" height="15" /></span>
  		</fieldset>
		</div>
        
        <!--테이블 시작 -->	
          <table cellpadding="0" cellspacing="0" class="table_list">
				<colgroup>
					<col width="10%" />
                    <col width="65%" />
                    <col width="15%" />
					<col width="10%" />
				</colgroup>
				<thead>
                <tr>
				  <th scope="col">순번</th>
                  <th scope="col">제목</th>
                  <th scope="col">등록일</th>
				  <th scope="col">조회수</th>
			    </tr>
				</thead>
				<tbody>
				<tr>
					<td>2</td>
			  	  	<td class="left"><a href="sub_v.jsp">제목입니다</a><a href="sub_v2.jsp">.</a></td>
			      <td>0000-00-00</td>
					<td class="ri_line">100</td>
			      </tr>
                  <tr>
					<td>1</td>
			  	  	<td class="left">제목입니다.</td>
				    <td>0000-00-00</td>
					<td class="ri_line">100</td>
			      </tr>
				</tbody>
				</table> 
            <!--테이블 시작 -->	   
               
        <!--페이지s -->
		<div class="pagination">
			<a href="#" class="direction"> &lsaquo; <span>Prev</span></a>
			<a href="#">11</a>
			<strong>12</strong>
			<a href="#">13</a>
			<a href="#">14</a>
			<a href="#">15</a>
			<a href="#">16</a>
			<a href="#">17</a>
			<a href="#">18</a>
			<a href="#">19</a>
			<a href="#">20</a>
			<a href="#" class="direction"><span>Next</span> &rsaquo; </a>
		</div>		
         <!--페이지e -->
         
         <!--btn s --> 
          <div class="btn_area">
			<div class="right">
			<span class="btn_pack medium"><input type="submit" value="등록"/></span>   &nbsp;
			<span class="btn_pack medium"><a href="#">등록</a></span>&nbsp;
			<span class="btn_pack medium"><button type="button">등록</button></span>
			</div>
		  </div> 
          
        </div> 

       
		
				
       
  <!--내용 컨텐츠 s -->  
  </div>
  <!--컨텐츠 박스 1000px -->       
<%@ include file="../A_inc/M_inc_bot.jsp" %>