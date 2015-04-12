<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>

<%@ include file="../A_i nc/M_inc_top_01.jsp" %>

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
    <table cellpadding="0" cellspacing="0" class="board_write">
	   <colgroup>
		   <col width="15%" />
		   <col width="55%" />
		   <col width="15%" />
		   <col width="15%" />
	   </colgroup>
	     <thead>
		 <tr>
		   <th scope="row"><label for="name">제목</label></th>
		   <td><input type="text" name="calendar2" id="calendar2" width="200px"/></td>
		   <th scope="row"><label for="calendar">작성일</label></th>
	       <td><input type="text" name="calendar" id="calendar" width="80px"/></td>
		 </tr>
         </thead>
         <tbody>
		 <tr>
			 <th scope="row"><label for="contents">내용</label></th>
			 <td colspan="3"><textarea rows="15" cols="60" id="contents" name="contents" style="width:95%"></textarea></td>
		 </tr>
	     <tr>
	       <th scope="row">첨부파일</th>
	       <td>
	          <input type="file" id="file" name="file" title="두번째 첨부파일" size="60" />
              <input type="file" id="file" name="file" title="두번째 첨부파일" size="60" />
              <input type="file" id="file" name="file" title="두번째 첨부파일" size="60" />		      </td>
	       <td colspan="2" valign="top"><a href="#"><img src="../A_img/common/M_btn/btn_top.gif" alt="첨부파일 삭제" /><img src="../A_img/common/M_btn/btn_bottom.gif" alt="첨부파일 추가" /></a></td>
         </tr>
	   </tbody>
      </table>
            <!--테이블 e -->	   
               
                
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