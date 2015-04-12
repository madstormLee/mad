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
    <td height="14" colspan="2"><table width="785" height="31px" border="0" cellpadding="0" cellspacing="0" background="../A_img/common/M_sub/tit2_txt_box.gif">
      <tr>
        <td width="434" height="31" align="right" class="m_cont_txtbox">총 건수 : 10건</td>
        <td width="297" align="right"><span class="m_cont_txtbox">구분</span>:
              <select name="select" id="select">
              </select>
          <input name="textfield" type="text" class="inp_lef" id="textfield" style="width:200px" /></td>
        <td width="54" align="left" style="padding-left:5px"><img src="../A_img/common/M_btn/btn_sch.gif" alt="" width="44" height="15" /></td>
      </tr>
    </table></td>
  </tr>
  
  <!--타이틀2 s -->
  <tr>
    <td height="20" colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="left" valign="top">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
    <td height="20" align="left" valign="top"><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">학력</span></td>
    <td height="20" align="right" valign="top">
      <input name="button" type="submit" class="btn_2" id="button" value="추가" />   </td>
  </tr>
  <tr>
    <td height="5" colspan="2" align="left" valign="top" background="../A_img/common/M_sub/con_tit2_bg.gif"></td>
  </tr>
    </table>    </td>
  </tr>
 
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="6%" class="M_list_tit2">순번</td>
        <td width="12%" class="M_list_tit">교육시작일</td>
        <td width="12%" class="M_list_tit">교육종료일</td>
        <td width="20%" class="M_list_tit">학교명</td>
        <td width="17%" class="M_list_tit">전공</td>
        <td width="11%" class="M_list_tit">이수학위</td>
        <td width="22%" class="M_list_tit">학위논문명</td>
      </tr>
      <tr>
        <td align="center" class="M_list_td_cen2">5</td>
        <td class="M_list_td_cen2">0000-00-00</td>
        <td class="M_list_td_cen2">0000-00-00</td>
        <td class="M_list_td">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  
  
  
  
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="20" align="left" valign="top"><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">경력및 겸임활동</span></td>
        <td height="20" align="right" valign="top"><input name="button2" type="submit" class="btn_2" id="button2" value="추가" />        </td>
      </tr>
      <tr>
        <td height="5" colspan="2" align="left" valign="top" background="../A_img/common/M_sub/con_tit2_bg.gif"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="6%" class="M_list_tit2">순번</td>
        <td width="12%" class="M_list_tit">교육시작일</td>
        <td width="12%" class="M_list_tit">교육종료일</td>
        <td width="20%" class="M_list_tit">학교명</td>
        <td width="17%" class="M_list_tit">전공</td>
        <td width="11%" class="M_list_tit">이수학위</td>
        <td width="22%" class="M_list_tit">학위논문명</td>
      </tr>
      <tr>
        <td align="center" class="M_list_td_cen2">5</td>
        <td class="M_list_td_cen2">0000-00-00</td>
        <td class="M_list_td_cen2">0000-00-00</td>
        <td class="M_list_td">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
</table>
<%@ include file="../A_inc/M_inc_bot.jsp" %>