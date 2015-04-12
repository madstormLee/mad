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
    <td height="15" colspan="2"></td>
  </tr>
  <tr>
    <td height="5" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="20" colspan="2" align="left" valign="top"><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">실태조사종합의견</span></td>
      </tr>
      <tr>
        <td height="5" colspan="2" align="left" valign="top" background="../A_img/common/M_sub/con_tit2_bg.gif"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td height="5" colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      
      <tr>
        <td colspan="2" class="M_view_title">접수번호</td>
        <td height="25" colspan="2" class="M_view_tit_td">RD20100001</td>
        <td height="25" colspan="2" class="M_view_titri">심사일</td>
        <td height="25" colspan="2" class="M_view_tit_td2">
          <input name="textfield3" type="text" class="sch" id="textfield3" size="15" />
          <img src="../A_img/common/M_btn/btn_cal.gif" width="15" height="14" /></td>
        </tr>
      <tr>
        <td colspan="2" class="M_form_th">신청기업</td>
        <td height="25" colspan="2" class="M_form_td2">(주)에이투엠</td>
        <td height="25" colspan="2" class="M_form_th">평점(가점포함)</td>
        <td height="25" colspan="2" class="M_form_td2"><input name="textfield5" type="text" class="sch" id="textfield5" size="15" /></td>
      </tr>
      <tr>
        <td colspan="2" class="M_form_th">합계</td>
        <td height="25" colspan="2" class="M_form_td"><span class="M_form_td2">
          <input name="textfield9" type="text" class="sch" id="textfield9" size="20" />
        </span></td>
        <td height="25" colspan="2" class="M_form_th">평점</td>
        <td height="25" colspan="2" class="M_form_td2"><input name="textfield2" type="text" class="sch" id="textfield2" size="20" /></td>
        </tr>
      
      
      <tr>
        <td colspan="2" class="M_form_th">종합의견</td>
        <td height="25" colspan="6" class="M_form_td2" style="padding:5px 0 5px 10px">
            <textarea name="textarea" id="textarea" cols="80" rows="5"></textarea>        </td>
        </tr>
      <tr>
        <td width="4%" rowspan="4" class="M_form_th">신<br />
          청</td>
        <td width="11%" class="M_form_th">개발기간</td>
        <td height="25" colspan="2" align="center" class="M_form_td"><p>0000-00-00 ~ 0000-00-00&#13;</p></td>
        <td width="5%" rowspan="4" class="M_form_th">조<br />
          정</td>
        <td width="14%" class="M_form_th">개발기간</td>
        <td height="25" colspan="2" class="M_form_td2"><input name="textfield3" type="text" class="sch" id="textfield3" size="10" />
          <img src="../A_img/common/M_btn/btn_cal.gif" width="15" height="14" />&nbsp;
          <input name="textfield" type="text" class="sch" id="textfield" size="10" />
          <img src="../A_img/common/M_btn/btn_cal.gif" width="15" height="14" /></td>
      </tr>
      <tr>
        <td rowspan="3" class="M_form_th">사업비<br />
          (단위:천원)</td>
        <td width="11%" height="25" class="M_form_th2">지원금</td>
        <td width="17%" class="M_form_td"><p>100,000&#13;</p></td>
        <td rowspan="3" class="M_form_th">사업비<br />
          (단위:천원)</td>
        <td width="15%" height="25" class="M_form_th2">지원금</td>
        <td width="23%" class="M_form_td2"><input name="textfield4" type="text" class="sch" id="textfield4" size="15" /></td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">민간부담금<br />
          (현금/현물)</td>
        <td class="M_form_td">20,000 / 30,000</td>
        <td height="25" class="M_form_th2">민간부담금<br />
          (현금/현물)</td>
        <td class="M_form_td2"><input name="textfield6" type="text" class="sch" id="textfield6" size="8" />
          /
          <input name="textfield7" type="text" class="sch" id="textfield7" size="8" /></td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">총사업비</td>
        <td class="M_form_td"><p>150,000&#13;</p></td>
        <td height="25" class="M_form_th2">총사업비</td>
        <td class="M_form_td2"><input name="textfield8" type="text" class="sch" id="textfield8" size="15" /></td>
      </tr>
      
      
      
      
      
      
      
      
    </table></td>
  </tr>
  
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td height="10" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="25" colspan="5" class="M_form_th4">평가정보</td>
      </tr>
      <tr>
        <td width="13%" height="25" class="M_form_th_le">성명</td>
        <td width="19%" height="25" class="M_form_th_le">소속</td>
        <td width="32%" height="25" class="M_form_th_le">점수</td>
        <td width="36%" height="25" colspan="2" class="M_form_th_ri">의견</td>
      </tr>
      <tr>
        <td height="25" align="center" class="M_form_td_le">김위원</td>
        <td height="25" align="center" class="M_form_td_le">한국대학교</td>
        <td height="25" align="center" class="M_form_td_le"><input name="textfield10" type="text" class="sch" id="textfield10" size="15" />
        </td>
        <td height="25" colspan="2" class="M_form_td_ri"><input name="textfield11" type="text" class="sch" id="textfield11" size="40" />
        </td>
      </tr>
      <tr>
        <td height="25" class="M_form_th">첨부파일</td>
        <td height="25" colspan="4" class="M_form_td2"><input name="fileField2" type="file" class="sch" id="fileField2" />
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2" align="right"><input name="button" type="submit" class="btn_2" id="button" value="저장" />
      &nbsp;
    <input name="button" type="submit" class="btn_3" id="button" value="창닫기" />
    &nbsp;</td>
  </tr>
</table>
<%@ include file="../A_inc/M_inc_bot.jsp" %>