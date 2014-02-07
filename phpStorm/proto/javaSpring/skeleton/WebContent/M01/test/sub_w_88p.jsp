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
        <td width="18%" class="M_form_title">총괄/기본/세부사업</td>
        <td colspan="5" class="M_form_tit_td2">
            <select name="select" id="select">
            </select> &nbsp;<select name="select" id="select">
            </select> &nbsp;<select name="select" id="select">
            </select>        </td>
        </tr>
      <tr>
        <td class="M_form_th">사업명</td>
        <td width="26%" height="25" class="M_form_td">
            <input name="textfield" type="text" class="sch" id="textfield" />        </td>
        <td width="16%" height="25" class="M_form_th">주관부처</td>
        <td width="40%" height="25" colspan="2" class="M_form_td2">
          <select name="select2" id="select2">
          </select>        </td>
      </tr>
      <tr>
        <td class="M_form_th">지역내역분류</td>
        <td height="25" class="M_form_td">
        <select name="select2" id="select2">
          </select>&nbsp;<select name="select2" id="select2">
          </select>          </td>
        <td height="25" class="M_form_th">부처담당자</td>
        <td height="25" colspan="2" class="M_form_td2">
          <input name="textfield2" type="text" class="sch" id="textfield2" />       </td>
      </tr>
      <tr>
        <td class="M_form_th">사업종류</td>
        <td height="25" class="M_form_td"><select name="select4" id="select4">
        </select></td>
        <td height="25" class="M_form_th">부처연락처</td>
        <td height="25" colspan="2" class="M_form_td2"><input name="textfield2" type="text" class="sch" id="textfield2" /></td>
      </tr>
      <tr>
        <td class="M_form_th">프로세스</td>
        <td height="25" class="M_form_td"><select name="select5" id="select5">
        </select></td>
        <td height="25" class="M_form_th">담당부서</td>
        <td height="25" colspan="2" class="M_form_td2"><select name="select3" id="select3">
        </select></td>
      </tr>
      <tr>
        <td class="M_form_th">사업진행업무</td>
        <td height="25" class="M_form_td"><select name="select6" id="select6">
        </select></td>
        <td height="25" class="M_form_th">담당자</td>
        <td height="25" colspan="2" class="M_form_td2"><input name="textfield2" type="text" class="sch" id="textfield2" size="20" />
              <input name="button2" type="submit" class="btn_2a" id="button2" value="찾기" />          </td>
      </tr>
      <tr>
        <td rowspan="5" class="M_form_th">진행절차살정</td>
        <td height="25" colspan="4" class="M_form_td2">신청:
          <input name="checkbox4" type="checkbox" class="Radio" id="checkbox4" /></td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="M_form_td2">선정:서면평가
          <input name="checkbox5" type="checkbox" class="Radio" id="checkbox5" />
&nbsp;&nbsp;&nbsp;실태조사
<input name="checkbox5" type="checkbox" class="Radio" id="checkbox6" />
&nbsp;발표평가
<input name="checkbox5" type="checkbox" class="Radio" id="checkbox7" /></td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="M_form_td2">중간:보고서요청
          <input name="checkbox6" type="checkbox" class="Radio" id="checkbox8" />
&nbsp;실태조사
<input name="checkbox6" type="checkbox" class="Radio" id="checkbox9" />
&nbsp;발표평가
<input name="checkbox6" type="checkbox" class="Radio" id="checkbox10" /></td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="M_form_td2">중간:보고서요청
          <input name="checkbox2" type="checkbox" class="Radio" id="checkbox11" />
&nbsp;실태조사
<input name="checkbox2" type="checkbox" class="Radio" id="checkbox12" />
&nbsp;발표평가
<input name="checkbox2" type="checkbox" class="Radio" id="checkbox13" /></td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="M_form_td2">사후:사업비정산
          <input name="checkbox" type="checkbox" class="Radio" id="checkbox" /></td>
        </tr>
      <tr>
        <td class="M_form_th">사업내용요약</td>
        <td height="25" colspan="4" class="M_form_td2" style="padding:5px 5px 5px 10px">
            <textarea name="textarea" id="textarea" cols="45" rows="5" style="width:500px"></textarea>        </td>
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
    <input name="button" type="submit" class="btn_2" id="button" value="취소" /></td>
  </tr>
  <tr>
    <td height="20" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="20" colspan="2" align="left" valign="top"><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">총괄/기본/세부:<span class="M_form_td">
          <select name="select7" id="select7">
          </select>
          <select name="select8" id="select8">
          </select>
          <select name="select9" id="select9">
          </select>
        </span></span></td>
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
    <td height="14" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="18%" class="M_form_titlele">사업코드</td>
        <td class="M_form_titlele">사업명</td>
        <td class="M_form_title">주관부처</td>
        <td class="M_form_titri">총사업비</td>
        </tr>
      <tr>
        <td align="center" class="M_form_td_le">사업명</td>
        <td width="45%" height="25" class="M_form_td_le">사업명</td>
        <td width="19%" height="25" align="center" class="M_form_td_le">주관부처</td>
        <td width="18%" height="25" align="center" class="M_form_td_ri">&nbsp;</td>
      </tr>
      

    </table></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
</table>
<%@ include file="../A_inc/M_inc_bot.jsp" %>