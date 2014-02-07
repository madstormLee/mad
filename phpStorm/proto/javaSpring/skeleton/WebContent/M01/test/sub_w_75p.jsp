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
    <td height="14" colspan="2">
    <!--컨텐츠 s 타이틀 -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
    <td height="20" colspan="2" align="left" valign="top"><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">일반사항</span></td>
  </tr>
  <tr>
    <td height="5" colspan="2" align="left" valign="top" background="../A_img/common/M_sub/con_tit2_bg.gif"></td>
  </tr>
    </table>    </td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td height="14" colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="18%" class="M_form_title">성명(한글)</td>
        <td width="32%" class="M_form_tit_td">
          <input name="textfield5" type="text" class="sch" id="textfield5" style="width:100px" />
        </td>
        <td width="15%" class="M_form_title">성명(영문)</td>
        <td width="35%" class="M_form_tit_td2">
          <input name="textfield8" type="text" class="sch" id="textfield8" style="width:100px" />
        </td>
      </tr>
      <tr>
        <td class="M_form_th">주민등록번호</td>
        <td height="25" class="M_form_td">
          <input name="textfield6" type="text" class="sch" id="textfield6" style="width:80px" />
          -
        <input name="textfield11" type="text" class="sch" id="textfield11" style="width:80px" />
        </td>
        <td width="15%" height="25" class="M_form_th">연락처</td>
        <td height="25" class="M_form_td2"><input name="textfield9" type="text" class="sch" id="textfield9" style="width:200px" /></td>
      </tr>
      <tr>
        <td class="M_form_th">휴대전화</td>
        <td height="25" class="M_form_td2"><input name="textfield7" type="text" class="sch" id="textfield7" style="width:150px" /></td>
        <td width="15%" height="25" class="M_form_th" >E-mail</td>
        <td height="25" class="M_view_td2"><span class="M_form_td2">
          <input name="textfield10" type="text" class="sch" id="textfield10" style="width:200px" />
        </span></td>
        </tr>
      <tr>
        <td rowspan="2" class="M_form_th">주소</td>
        <td height="25" colspan="3" class="M_form_td2">
            <input name="textfield" type="text" class="sch" id="textfield" size="5" />
            -
            <input name="textfield2" type="text" class="sch" id="textfield2" size="5" />
            <input name="button2" type="submit" class="btn_4a" id="button2" value="우편번호" />
            </td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="M_form_td2"><input name="textfield4" type="text" class="sch" id="textfield4" style="width:300px" />
          <input name="textfield3" type="text" class="sch" id="textfield3" style="width:100px" /></td>
        </tr>
      <tr>
        <td class="M_form_th">내외국인구분</td>
        <td height="25" class="M_form_td">
            <input name="radio" type="radio" class="Radio" id="radio" value="radio" />
          내국인 &nbsp;
          <input name="radio" type="radio" class="Radio" id="radio2" value="radio" />
          외국인</td>
        <td height="25" class="M_form_th">성별</td>
        <td height="25" class="M_view_td2"><span class="M_form_td">
          <input name="radio" type="radio" class="Radio" id="radio3" value="radio" />
          남자
          &nbsp;
          <input name="radio" type="radio" class="Radio" id="radio4" value="radio" />
여자</span></td>
      </tr>
      <tr>
        <td class="M_form_th">최종학위</td>
        <td height="25" class="M_form_td"><select name="select2" id="select2">
          <option>:: 학위선택 ::</option>
                </select></td>
        <td height="25" class="M_form_th">최종전공</td>
        <td height="25" class="M_view_td2">
          <label>
            <select name="select" id="select">
              <option>:: 전공선택 ::</option>
            </select>
            </label>        </td>
      </tr>
      <tr>
        <td class="M_form_th">최종학교명</td>
        <td height="25" class="M_form_td">
          <input name="textfield12" type="text" class="sch" id="textfield12" style="width:150px" />
       </td>
        <td height="25" class="M_form_th">최종학위논문명</td>
        <td height="25" class="M_view_td2">
          <input name="textfield13" type="text" class="sch" id="textfield13" style="width:150px" />
        </td>
      </tr>
      <tr>
        <td class="M_form_th">전문기능분류</td>
        <td height="25" class="M_form_td"><select name="select3" id="select3">
          <option>:: 선택 ::</option>
                </select></td>
        <td height="25" class="M_form_th">전문기술분류</td>
        <td height="25" class="M_view_td2">
          <input name="textfield14" type="text" class="sch" id="textfield14" style="width:150px" />
          <img src="../A_img/common/M_btn/btn_sch3.gif" width="44" height="15" /></td>
      </tr>
      
      
      

    </table></td>
  </tr>
  <tr>
    <td height="20" colspan="2"></td>
  </tr>
  <tr>
    <td height="20" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="20" colspan="2" align="left" valign="top"><img src="../A_img/common/M_sub/con_tit2_ico.gif" width="14" height="9" /><span class="m_cont_ti2t">소속정보</span></td>
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
    <td height="20" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="18%" class="M_form_title">소속기관명</td>
        <td width="32%" class="M_form_tit_td">
          <input name="textfield15" type="text" class="sch" id="textfield15" style="width:200px" />
       </td>
        <td width="15%" class="M_form_title">부서명</td>
        <td width="35%" class="M_form_tit_td2">
          <input name="textfield15" type="text" class="sch" id="textfield16" style="width:100px" />
       </td>
      </tr>
      <tr>
        <td class="M_form_th">직위</td>
        <td height="25" class="M_form_td">
          <input name="textfield16" type="text" class="sch" id="textfield17" style="width:200px" />
        </td>
        <td width="15%" height="25" class="M_form_th">직책</td>
        <td height="25" class="M_form_td2"><input name="textfield15" type="text" class="sch" id="textfield19" style="width:200px" /></td>
      </tr>
      <tr>
        <td class="M_form_th">연락처</td>
        <td height="25" class="M_form_td2"><input name="textfield15" type="text" class="sch" id="textfield20" style="width:150px" /></td>
        <td width="15%" height="25" class="M_form_th" >Fax</td>
        <td height="25" class="M_view_td2">
          <input name="textfield15" type="text" class="sch" id="textfield21" style="width:200px" />
       </td>
      </tr>
      <tr>
        <td rowspan="2" class="M_form_th">주소</td>
        <td height="25" colspan="3" class="M_form_td2"><input name="textfield15" type="text" class="sch" id="textfield22" size="5" />
          -
          <input name="textfield15" type="text" class="sch" id="textfield23" size="5" />
          <input name="button3" type="submit" class="btn_4a" id="button3" value="우편번호" /></td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="M_form_td2"><input name="textfield15" type="text" class="sch" id="textfield24" style="width:300px" />
            <input name="textfield15" type="text" class="sch" id="textfield25" style="width:100px" /></td>
      </tr>
      
      <tr>
        <td class="M_form_th">기관유형</td>
        <td height="25" colspan="3" class="M_form_td2"><select name="select4" id="select4">
            <option>:: 학위선택 ::</option>
        </select></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td height="20" colspan="2"></td>
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