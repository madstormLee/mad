<style type="text/css">
@import url("../A_css/style.css");
@import url("../A_css/table.css");
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}

-->
</style>
<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<%@ include file="../A_inc/M_inc_top_01.jsp" %>
        <!--컨텐츠 시작 -->
<table width="785" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="769" height="15" colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2"><!--타이틀 s -->
        <table width="785" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="22" align="right"><img src="../A_img/common/M_sub/con_tit_ico.gif" width="22" height="17" /></td>
            <td width="120" height="25" align="left" class="m_cont_tit">타이틀</td>
            <td width="643">&nbsp;</td>
          </tr>
          <tr>
            <td height="2" colspan="2" bgcolor="3366ac"></td>
            <td height="2" background="../A_img/common/M_sub/tit_line_bg.gif"></td>
          </tr>
      </table></td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td height="5" colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2" class="M_form_title">과제신청명</td>
        <td colspan="2" class="M_form_tit_td_cen">신청과제명</td>
        <td width="16%" class="M_form_title">지원신청명</td>
        <td colspan="3" class="M_form_tit_td2_cen">마케팅</td>
      </tr>
      <tr>
        <td width="6%" rowspan="3" class="M_form_th">주관<br />
          기업</td>
        <td width="10%" height="25" class="M_form_th2">기업명</td>
        <td height="25" colspan="2" class="M_form_td_cen">(주)우리기업</td>
        <td width="16%" height="25" class="M_form_th">사업자등록번호</td>
        <td height="25" colspan="3" class="M_form_td2_cen">000-00-00000</td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">법인번호</td>
        <td height="25" colspan="2" class="M_form_td_cen">1234561-1234567</td>
        <td width="16%" height="25" class="M_form_th" >대표자성명</td>
        <td height="25" colspan="3" class="M_form_td2_cen">홍길동</td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">주업종</td>
        <td height="25" colspan="2" class="M_form_td_cen">서비스업</td>
        <td width="16%" height="25" class="M_form_th">주업태</td>
        <td height="25" colspan="3" class="M_form_td2_cen">주업태</td>
      </tr>
      <tr>
        <td rowspan="4" class="M_form_th">총괄<br />
          책임자</td>
        <td height="25" class="M_form_th2">성명</td>
        <td height="25" colspan="2" class="M_form_td_cen">책임자</td>
        <td height="25" class="M_form_th">주민등록번호</td>
        <td height="25" colspan="3" class="M_form_td2_cen">000000-0000000</td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">부서</td>
        <td height="25" colspan="2" class="M_form_td_cen">기획부</td>
        <td height="25" class="M_form_th">전화</td>
        <td height="25" colspan="3" class="M_form_td2_cen">042-000-0000</td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">직위</td>
        <td height="25" colspan="2" class="M_form_td_cen">부장</td>
        <td height="25" class="M_form_th">휴대전화</td>
        <td height="25" colspan="3" class="M_form_td2_cen">010-0000-0000</td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">이메일</td>
        <td height="25" colspan="2" class="M_form_td_cen">email@email.com</td>
        <td height="25" class="M_form_th">팩스</td>
        <td height="25" colspan="3" class="M_form_td2_cen">042-000-0000</td>
      </tr>
      <tr>
        <td rowspan="6" class="M_form_th">신청<br />
          내역</td>
        <td height="25" class="M_form_th2">총사업기간</td>
        <td height="25" colspan="2" class="M_form_td_cen"><input name="textfield3" type="text" class="sch" id="textfield3" size="12" />
          <img src="../A_img/common/M_btn/btn_cal.gif" width="15" height="14" />&nbsp;&nbsp;
          <input name="textfield4" type="text" class="sch" id="textfield4" size="12" />
          <img src="../A_img/common/M_btn/btn_cal.gif" alt="" width="15" height="14" /></td>
        <td height="25" class="M_form_th">산업기술분류</td>
        <td height="25" colspan="3" class="M_form_td2_cen">코드
                     <input name="textfield" type="text" class="sch" id="textfield" size="10" />
                     코드
                     <input name="textfield2" type="text" class="sch" id="textfield2" size="10" />
            &nbsp;
            <input name="button2" type="submit" class="btn_2a" id="button2" value="찾기" />            </td>
      </tr>
      <tr>
        <td rowspan="2" class="M_form_th2">총사업비<br />
          (단위:천원)</td>
        <td width="15%" height="25" class="M_form_th3"><p>지원금</p>
          <p>A</p></td>
        <td width="17%" height="25" class="M_form_th3">민간부담금(현금)<br />
          B</td>
        <td height="25" class="M_form_th3">민간부담금(현물)<br />
          C</td>
        <td width="17%" height="25" class="M_form_th3">민간부담금합계<br />
          (B+C)</td>
        <td height="25" colspan="2" class="M_form_th3">합계<br />
(A+B+C)</td>
      </tr>
      <tr>
        <td height="25" class="M_form_td2_cen">
          <input name="textfield10" type="text" class="sch" id="textfield10" size="10" />        </td>
        <td height="25" class="M_form_td2_cen"><input name="textfield11" type="text" class="sch" id="textfield11" size="10" /></td>
        <td height="25" class="M_list_td_cen">
          <input name="textfield12" type="text" class="sch" id="textfield12" size="10" />        </td>
        <td height="25" class="M_form_td2_cen"><input name="textfield13" type="text" class="sch" id="textfield13" size="10" /></td>
        <td height="25" colspan="2" class="M_form_td2_cen"><input name="textfield14" type="text" class="sch" id="textfield14" size="10" /></td>
      </tr>
      <tr>
        <td rowspan="2" class="M_form_th2">실무담당자</td>
               <td width="15%" height="25" class="M_form_th3"><p>성명</p>          </td>
        <td width="17%" height="25" class="M_form_th3">소속</td>
        <td height="25" class="M_form_th3">연락처</td>
        <td width="17%" height="25" class="M_form_th3">팩스</td>
        <td height="25" colspan="2" class="M_form_th3">이메일</td>
      </tr>
      <tr>
        <td height="25" class="M_form_td2_cen">
          <input name="textfield15" type="text" class="sch" id="textfield15" size="10" />       </td>
        <td height="25" class="M_form_td2_cen"><input name="textfield16" type="text" class="sch" id="textfield16" size="10" /></td>
        <td height="25" class="M_form_td2_cen"><input name="textfield17" type="text" class="sch" id="textfield17" size="10" /></td>
        <td height="25" class="M_form_td2_cen"><input name="textfield18" type="text" class="sch" id="textfield18" size="10" /></td>
        <td height="25" colspan="2" class="M_form_td2_cen"><input name="textfield19" type="text" class="sch" id="textfield19" size="10" /></td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">6T</td>
        <td height="25" class="M_form_td2" style="padding-left:20px;">
            <select name="select" id="select">
              <option>:::선택:::</option>
            </select>        </td>
        <td height="25" class="M_form_th3">전략산업분류</td>
        <td height="25" colspan="4" class="M_form_td2" style="padding-left:23px;">
          <select name="select2" id="select2">
            <option>:::선택:::</option>
          </select>       </td>
        </tr>
      <tr>
        <td colspan="2" rowspan="3" class="M_form_th">참여(공급기관)<br />
          /위탁기관</td>
        <td height="25" class="M_form_th3">참여/위탁구분</td>
        <td height="25" class="M_form_th3">업체명</td>
        <td height="25" class="M_form_th3">책임자성명</td>
        <td height="25" class="M_form_th3">주민등록번호</td>
        <td width="11%" height="25" class="M_form_th3">연락처</td>
        <td width="8%" class="M_form_th3">유형</td>
      </tr>
      <tr>
        <td height="25" class="M_form_td2_cen">참여</td>
        <td height="25" class="M_form_td2_cen">참여기업</td>
        <td height="25" class="M_form_td2_cen">이순신</td>
        <td height="25" class="M_form_td2_cen">000000-0000000</td>
        <td height="25" class="M_form_td2_cen">010-0000-0000</td>
        <td height="25" class="M_form_td2_cen">공급</td>
      </tr>
      <tr>
        <td height="25" class="M_form_td2_cen">위탁</td>
        <td height="25" class="M_form_td2_cen">위탁기업</td>
        <td height="25" class="M_form_td2_cen">유관순</td>
        <td height="25" class="M_form_td2_cen">000000-0000000</td>
        <td height="25" class="M_form_td2_cen">010-0000-0000</td>
        <td height="25" class="M_form_td2_cen">위탁</td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="M_form_th">사업계획서</td>
        <td height="25" colspan="6" class="M_form_td2">사업계획서.hwp</td>
        </tr>
      <tr>
        <td height="25" colspan="2" class="M_form_th">첨부서류</td>
        <td height="25" colspan="6" class="M_form_td2">첨부파일1.hwp</td>
        </tr>
      
      
    </table></td>
  </tr>
  
  
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2" align="right"><input name="button" type="submit" class="btn_2" id="button" value="저장" />
      &nbsp;
    <input name="button" type="submit" class="btn_2" id="button" value="삭제" />
    &nbsp;
    <input name="button" type="submit" class="btn_2" id="button" value="목록" /></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
</table>
<%@ include file="../A_inc/M_inc_bot.jsp" %>