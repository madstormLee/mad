<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<style type="text/css">
@import url("/A_css/style.css");
@import url("/A_css/table.css");
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}

-->
</style>
<%@ include file="/A_inc/M_inc_top_01.jsp" %>
        <!--컨텐츠 시작 -->
<table width="785" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="769" height="15" colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2"><!--타이틀 s -->
        <table width="785" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="22" align="right"><img src="/A_img/common/M_sub/con_tit_ico.gif" width="22" height="17" /></td>
            <td width="120" height="25" align="left" class="m_cont_tit">타이틀</td>
            <td width="643">&nbsp;</td>
          </tr>
          <tr>
            <td height="2" colspan="2" bgcolor="3366ac"></td>
            <td height="2" background="/A_img/common/M_sub/tit_line_bg.gif"></td>
          </tr>
      </table></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="785" height="31px" border="0" cellpadding="0" cellspacing="0" background="/A_img/common/M_sub/tit2_txt_box.gif">
      <tr>
        <td width="434" height="31" align="right" class="m_cont_txtbox">총 건수 : 10건</td>
        <td width="297" align="right"><span class="m_cont_txtbox">구분</span>:
              <select name="select" id="select">
              </select>
          <input name="textfield" type="text" class="inp_lef" id="textfield" style="width:200px" /></td>
        <td width="54" align="left" style="padding-left:5px"><img src="/A_img/common/M_btn/btn_sch.gif" alt="" width="44" height="15" /></td>
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
        <td height="20" align="left" valign="top"><img src="/A_img/common/M_sub/con_tit2_ico.gif" alt="" width="14" height="9" /><span class="m_cont_ti2t">평가일정정보</span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="left" valign="top"></td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="18%" class="M_view_title">자료명</td>
        <td width="35%" class="M_view_tit_td"><input name="textfield2" type="text" class="sch" id="textfield2" value="분과명" /></td>
        <td width="18%" class="M_view_title">등록일</td>
        <td width="29%" class="M_view_tit_td2"><input name="textfield2" type="text" class="sch" id="textfield2" value="분과명" />        </td>
      </tr>
      <tr>
        <td align="center" class="M_view_th3">평가일자</td>
        <td class="M_view_td3"><input name="textfield3" type="text" class="sch" id="textfield3" value="2011-00-00" size="12" />
            <img src="/A_img/common/M_btn/btn_cal.gif" width="15" height="14" /></td>
        <td class="M_view_th3">평가장소</td>
        <td class="M_view_td2"><input name="textfield4" type="text" class="sch" id="textfield4" value="평가장소" />        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="left" valign="top">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      
      
      <tr>
    <td height="20" align="left" valign="top"><img src="/A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">평가위원정보</span></td>
    <td height="20" align="right" valign="top">
      <input name="button" type="submit" class="btn_4" id="button" value="위원추가" />   </td>
  </tr>
  <tr>
    <td height="5" colspan="2" align="left" valign="top" background="/A_img/common/M_sub/con_tit2_bg.gif"></td>
  </tr>
    </table>    </td>
  </tr>
 
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="5%" class="M_list_tit2">No</td>
        <td width="9%" class="M_list_tit">성명</td>
        <td width="14%" class="M_list_tit">소속</td>
        <td width="12%" class="M_list_tit">휴대전화</td>
        <td width="20%" class="M_list_tit">이메일</td>
        <td width="11%" class="M_list_tit">생년월일</td>
        <td width="21%" class="M_list_tit">주소</td>
        <td width="8%" class="M_list_tit">비고</td>
      </tr>
      <tr>
        <td align="center" class="M_list_td_cen2">5</td>
        <td class="M_list_td_cen">홍길동</td>
        <td class="M_list_td_cen">한밭대학교</td>
        <td class="M_list_td_cen">010-0000-0000</td>
        <td class="M_list_td_cen">hgd@yahoo.com</td>
        <td class="M_list_td_cen">80.12.14</td>
        <td class="M_list_td_cen">대전시 서구 둔산동</td>
        <td class="M_list_td_cen">
            <input name="button3" type="submit" class="btn_2a" id="button3" value="삭제" />        </td>
      </tr>
      
    </table></td>
  </tr>
  
  
  
  
  <tr>
    <td height="30" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="20" align="left" valign="top"><img src="/A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">평가대상과제정보</span></td>
        <td height="20" align="right" valign="top"><input name="button2" type="submit" class="btn_4" id="button2" value="과제추가" />        </td>
      </tr>
      <tr>
        <td height="5" colspan="2" align="left" valign="top" background="/A_img/common/M_sub/con_tit2_bg.gif"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="12%" class="M_list_tit2">공고번호</td>
        <td width="17%" class="M_list_tit">교육시작일</td>
        <td width="13%" class="M_list_tit">접수번호</td>
        <td width="12%" class="M_list_tit">사업자번호</td>
        <td width="21%" class="M_list_tit">기업명</td>
        <td width="9%" class="M_list_tit">대표자</td>
        <td width="9%" class="M_list_tit">신청자</td>
        <td width="7%" class="M_list_tit">비고</td>
      </tr>
      <tr>
        <td align="center" class="M_list_td_cen2"><p>ANC20110001&#13;</p></td>
        <td class="M_list_td_cen">기업지원마케칭사업</td>
        <td class="M_list_td_cen">RD2011000001</td>
        <td class="M_list_td_cen">000-00-00000</td>
        <td class="M_list_td_cen">(주)좋은나라</td>
        <td class="M_list_td_cen">김대표</td>
        <td class="M_list_td_cen">신청자</td>
        <td class="M_list_td_cen"><input name="button3" type="submit" class="btn_2a" id="button3" value="삭제" /> </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
</table>
<%@ include file="/A_inc/M_inc_bot.jsp" %>