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
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" height="23px" border="0" cellpadding="0" cellspacing="0" background="../A_img/common/M_tap/tap_menu_bg.gif">
      <tr>
        <td class="tap_txt0204">기본정보</td>
        <td class="tap_txt0204_ov">tap0204r</td>
        <td class="tap_txt0507">tap0507</td>
        <td class="tap_txt0507_ov">tap0507</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="20" align="left" valign="top"><img src="../A_img/common/M_sub/con_tit2_ico.gif" alt="" width="14" height="9" /><span class="m_cont_ti2t">참여연구원</span></td>
        </tr>
      <tr>
        <td height="5" align="left" valign="top" background="../A_img/common/M_sub/con_tit2_bg.gif"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><img src="../A_img/common/M_sub/sea_box_topimg.gif" width="785" height="5" /></td>
        </tr>
      <tr>
        <td align="center" background="../A_img/common/M_sub/sea_box_cenimg.gif" style="padding:10px 0 5px 0">
        <table width="750" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="8%" rowspan="2" class="M_list_tit4_le">성명</td>
            <td class="M_list_tit4">주민등록번호</td>
            <td class="M_list_tit4">구분</td>
            <td class="M_list_tit4">소속기관</td>
            <td class="M_list_tit4">직위</td>
            <td class="M_list_tit4">학교</td>
            <td class="M_list_tit4">연구담당분야</td>
          </tr>
          <tr>
            <td width="13%" class="M_list_tit4">전공</td>
            <td width="14%" class="M_list_tit4">학위</td>
            <td width="18%" class="M_list_tit4">본과제참여율</td>
            <td width="18%" class="M_list_tit4">타과제참여율</td>
            <td width="13%" class="M_list_tit4">취득년도</td>
            <td width="16%" class="M_list_tit4">연봉(천원)</td>
          </tr>
          <tr>
            <td align="center" class="M_list_td_cen2">5</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" class="M_list_td_cen2">5</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" class="M_list_td_cen2">&nbsp;</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
            <td class="M_list_td_cen">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="5" align="center" background="../A_img/common/M_sub/sea_box_cenimg.gif"></td>
      </tr>
      <tr>
        <td align="center" background="../A_img/common/M_sub/sea_box_cenimg.gif"><table width="750" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="right">
                <input name="button" type="submit" class="btn_2" id="button" value="등록" />
                <input name="button" type="submit" class="btn_2" id="button" value="삭제" />
                <input name="button" type="submit" class="btn_2" id="button" value="취소" />            </td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td><img src="../A_img/common/M_sub/sea_box_botimg.gif" width="785" height="6" /></td>
        </tr>
      
    </table></td>
  </tr>
  
  <!--타이틀2 s -->
  <tr>
    <td height="10" colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="14" colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="8%" rowspan="2" class="M_list_tit4_le">성명</td>
        <td class="M_list_tit4">주민등록번호</td>
        <td class="M_list_tit4">구분</td>
        <td class="M_list_tit4">소속기관</td>
        <td class="M_list_tit4">직위</td>
        <td class="M_list_tit4">학교</td>
        <td class="M_list_tit4">연구담당분야</td>
      </tr>
      <tr>
        <td width="15%" class="M_list_tit4">전공</td>
        <td width="13%" class="M_list_tit4">학위</td>
        <td width="19%" class="M_list_tit4">본과제참여율</td>
        <td width="16%" class="M_list_tit4">타과제참여율</td>
        <td width="13%" class="M_list_tit4">취득년도</td>
        <td width="16%" class="M_list_tit4">연봉(천원)</td>
      </tr>
      <tr>
        <td rowspan="2" align="center" class="M_list_td_cen2">홍길동</td>
        <td class="M_list_td_cen">000000-*******</td>
        <td class="M_list_td_cen">참여기업</td>
        <td class="M_list_td_cen">(주)좋은나라</td>
        <td class="M_list_td_cen">팀장</td>
        <td class="M_list_td_cen">대전대학교</td>
        <td class="M_list_td_cen">시스템</td>
      </tr>
      <tr>
        <td class="M_list_td_cen">컴퓨터공학</td>
        <td class="M_list_td_cen">박사</td>
        <td class="M_list_td_cen">20%</td>
        <td class="M_list_td_cen">50%</td>
        <td class="M_list_td_cen">2000</td>
        <td class="M_list_td_cen">30,000</td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td height="20" colspan="2"><!--페이지  --></td>
  </tr>
</table>

<%@ include file="../A_inc/M_inc_bot.jsp" %>