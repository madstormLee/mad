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
          <h2><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" />사업소개 서브 타이틀</h2>
          <p style="margin:3px 0 0 0;"><img src="../A_img/common/sub_tit_line2.gif" /></p>
        
        
        <table class="table_style_1">
			   <caption>&nbsp; </caption>
				<colgroup>
					<col width="10%" />
					<col width="15%" />
                    <col width="15%" />
					<col width="20%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="20%" />
				</colgroup>
				<tbody>
				<tr>
					<th colspan="2" rowspan="8" class="photo">장비이미지</th>
			  	  	<th>장비명한글</th>
			  	  	<td colspan="4"></td>
                  </tr>
				<tr>
				  <th>장비명영문</th>
				  <td colspan="4"></td>
				  </tr>
				<tr>
				  <th>제조사</th>
				  <td>1111111111</td>
				  <th colspan="2">모델명</th>
				  <td width="30">11111</td>
				  </tr>
				<tr>
				  <th>공급사</th>
				  <td></td>
				  <th colspan="2">설치장소</th>
				  <td></td>
				  </tr>
				<tr>
				  <th rowspan="2">장비규격</th>
				  <td rowspan="2"></td>
				  <th rowspan="2">담당자</th>
				  <th class="in">성명</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">연락처</th>
				  <td></td>
				  </tr>
				<tr>
				  <th>&nbsp;</th>
				  <td></td>
				  <th colspan="2">용도</th>
				  <td></td>
				  </tr>
				<tr>
				  <th>전격정압</th>
				  <td></td>
				  <th colspan="2">정격소비전력</th>
				  <td></td>
				  </tr>
				<tr>
				  <th rowspan="8">장비<br />
			      계약<br />
			      번호<br /></th>
				  <th class="in">기자재번호</th>
				  <td colspan="2">&nbsp;</td>
				  <th colspan="2">계약번호</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">장비고유번호</th>
				  <td colspan="2">&nbsp;</td>
				  <th colspan="2">신용장번호</th>
				  <td></td>
				  </tr>
				<tr>
				  <th height="20"  class="in">납품규격</th>
				  <td colspan="2">&nbsp;</td>
				  <th colspan="2">수입신고번호</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">외화구입가</th>
				  <td colspan="2">&nbsp;</td>
				  <th colspan="2">원화구입가</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">사후관리번호</th>
				  <td colspan="2">&nbsp;</td>
				  <th colspan="2">내자품목비</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">H.S.번호</th>
				  <td colspan="2">&nbsp;</td>
				  <th colspan="2">총구입가</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">구입일(계약일)</th>
				  <td colspan="2">&nbsp;</td>
				  <th colspan="2">납품일</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">설치일</th>
				  <td colspan="5">&nbsp;</td>
				  </tr>
				<tr>
				  <th rowspan="3">교육</th>
				  <th class="in">업체명</th>
				  <td colspan="2">&nbsp;</td>
				  <th rowspan="3">A/S</th>
				  <th  class="in">업체명</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">담당자</th>
				  <td colspan="2">&nbsp;</td>
				  <th  class="in">담당자</th>
				  <td></td>
				  </tr>
				<tr>
				  <th class="in">연락처</th>
				  <td colspan="2">&nbsp;</td>
				  <th class="in">연락처</th>
				  <td></td>
				  </tr>
				</tbody>
  		</table> 
         
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