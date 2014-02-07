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
          
          <p style="margin:3px 0 0 0;"><img src="../A_img/common/sub_tit_line2.gif" /></p>

              
        <!--테이블 시작 -->	
         <table cellpadding="0" cellspacing="0" class="board_view">
<colgroup>
				<col width="15%" />
				<col width="55%" />
				<col width="15%" />
				<col width="15%" />
			</colgroup>
			<thead>
			<tr>
				<th scope="col">자료명</th>
				<td colspan="5">자료명</td>
			</tr>
			<tr>
				<th scope="col">등록일</th>
				<td>0000-00-00</td>
				<th scope="col">조회수</th>
				<td class="center">100</td>
			</tr>
			</thead>
			<tbody>
			<tr>
			  <th scope="row">내용</th>
			  <td colspan="3" class="subject">텍스트 내용입니다.</td>
			  </tr>
			<tr>
				<th scope="row" class="bot">첨부파일</th>
				<td colspan="3" class="bot"><a href="#" title="새창으로 파일다운받기">게시공고_201071210.hwp</a><br />
<a href="#" title="새창으로 파일다운받기">게시공고_201071210.hwp</a>			
                </td>
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

       
		
				
       
  <!--내용 컨텐츠 s -->  
  </div>
  <!--컨텐츠 박스 1000px -->       
<%@ include file="../A_inc/M_inc_bot.jsp" %>