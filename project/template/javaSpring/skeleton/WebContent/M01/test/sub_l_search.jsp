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
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><img src="../A_img/common/M_sub/sea_box_topimg.gif" width="785" height="5" /></td>
        </tr>
      <tr>
        <td align="center" background="../A_img/common/M_sub/sea_box_cenimg.gif"><table width="631" height="124" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="74" height="15" align="right"><img src="../A_img/common/M_ico/m_ico_jum.gif" width="8" height="7" /><span class="m_search_txt">구분</span> :</td>
            <td height="15" colspan="3" align="left" style="padding-left:5px">
              <select name="select3" id="select3">
                <option>: :선택 ::</option>
                </select>
              <input name="textfield2" type="text" class="sch" id="textfield2" style="width:300px" /></td>
            <td width="143" height="15" align="left"><img src="../A_img/common/M_btn/btn_sch.gif" alt="" width="44" height="15" /></td>
          </tr>
          <tr>
            <td height="15" align="right"><img src="../A_img/common/M_ico/m_ico_jum.gif" width="8" height="7" /><span class="m_search_txt">업태</span> : </td>
            <td width="128" height="15" align="left" style="padding-left:5px">
              <select name="select" id="select">
                <option>: :선택 ::</option>
              </select>
            </span></td>
            <td width="150" height="15" align="right" style="padding-left:5px"><img src="../A_img/common/M_ico/m_ico_jum.gif" alt="" width="8" height="7" /><span class="m_search_txt">부설연구소지정유무 :</span></td>
            <td width="136" height="15" align="left" style="padding-left:5px">
              <select name="select2" id="select2">
                <option>: :선택 ::</option>
              </select>
            </span></td>
            <td height="15" align="left" style="padding-left:5px">&nbsp;</td>
          </tr>
          <tr>
            <td height="15" align="right"><img src="../A_img/common/M_ico/m_ico_jum.gif" alt="" width="8" height="7" /><span class="m_search_txt">지역</span> : </td>
            <td height="15" align="left"  style="padding-left:5px">
              <select name="select6" id="select6">
                <option>: :선택 ::</option>
              </select>
            </span></td>
            <td height="15" align="right"><img src="../A_img/common/M_ico/m_ico_jum.gif" alt="" width="8" height="7" /><span class="m_search_txt">지역선도기업지정유무 :</span></td>
            <td height="15" align="left" style="padding-left:5px">
              <select name="select4" id="select4">
                <option>: :선택 ::</option>
              </select>
            </span></td>
            <td height="15" align="left" style="padding-left:5px">&nbsp;</td>
          </tr>
          <tr>
            <td height="15" align="right"><img src="../A_img/common/M_ico/m_ico_jum.gif" alt="" width="8" height="7" /><span class="m_search_txt">기업규모</span> : </td>
            <td height="15" align="left" style="padding-left:5px">
            <select name="select7" id="select7">
              <option>: :선택 ::</option>
            </select>
              </span></td>
            <td height="15" align="right" style="padding-left:5px"><img src="../A_img/common/M_ico/m_ico_jum.gif" alt="" width="8" height="7" /><span class="m_search_txt">입주기업여부 :</span></td>
            <td height="15" align="left" style="padding-left:5px">
              <select name="select5" id="select5">
                <option>: :선택 ::</option>
              </select>
            </span></td>
            <td height="15" align="left" style="padding-left:5px">&nbsp;</td>
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
    <td height="20" colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="left" valign="top"><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">타이틀</span></td>
  </tr>
  <tr>
    <td height="5" colspan="2" align="left" valign="top" background="../A_img/common/M_sub/con_tit2_bg.gif"></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="8%" class="M_list_tit2">순번</td>
        <td width="14%" class="M_list_tit">아이디</td>
        <td width="13%" class="M_list_tit">성명</td>
        <td width="22%" class="M_list_tit">이메일</td>
        <td width="19%" class="M_list_tit">소속</td>
        <td width="15%" class="M_list_tit">연락처</td>
        <td width="9%" class="M_list_tit">최종학력</td>
      </tr>
      <tr>
        <td align="center" class="M_list_td_cen2">5</td>
        <td class="M_list_td"><a href="sub_v.php">자료명</a></td>
        <td class="M_list_td">&nbsp;</td>
        <td class="M_list_td">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
        <td class="M_list_td_cen">042-523-8541</td>
        <td class="M_list_td_cen">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" class="M_list_td_cen2">5</td>
        <td class="M_list_td">자료명</td>
        <td class="M_list_td">&nbsp;</td>
        <td class="M_list_td">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
        <td class="M_list_td_cen">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" colspan="2"><!--페이지  -->
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
      </table></td>
  </tr>
  <tr>
    <td height="14" colspan="2" align="center"><img src="../A_img/common/M_btn/btn_prev2.gif" width="17" height="13" />&nbsp;<img src="../A_img/common/M_btn/btn_prev.gif" width="41" height="13" /> 123 <img src="../A_img/common/M_btn/btn_next.gif" width="41" height="13" />&nbsp;<img src="../A_img/common/M_btn/btn_next2.gif" width="17" height="13" /></td>
  </tr>
  
  
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
</table>
<%@ include file="../A_inc/M_inc_bot.jsp" %>