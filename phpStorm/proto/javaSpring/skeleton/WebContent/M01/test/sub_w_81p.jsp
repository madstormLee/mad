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
    <td height="5" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2" rowspan="8" class="M_form_title">장비이미지</td>
        <td class="M_form_tit_td3">장비명한글</td>
        <td colspan="4" class="M_form_tit_td2"><span style="padding-left:5px">
          <input name="textfield2" type="text" class="sch" id="textfield2" style="width:440px" />
        </span></td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">장비명영문</td>
        <td height="25" colspan="4" class="M_form_td2"><span style="padding-left:5px">
          <input name="textfield" type="text" class="sch" id="textfield" style="width:440px" />
        </span></td>
      </tr>
      <tr>
        <td width="15%" height="25" class="M_form_th2">제조사</td>
        <td width="19%" height="25" class="M_form_td2"><input name="textfield3" type="text" class="sch" id="textfield3" style="width:120px" />        </td>
        <td height="25" colspan="2" class="M_form_th2" >모델명</td>
        <td width="26%" height="25" class="M_view_td2">
          <input name="textfield4" type="text" class="sch" id="textfield4" style="width:140px" />
       </td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">공급사</td>
        <td height="25" class="M_form_td2"><input name="textfield5" type="text" class="sch" id="textfield5" style="width:120px" /></td>
        <td height="25" colspan="2" class="M_form_th2">보유기관/설치장소</td>
        <td height="25" class="M_view_td2">
          <select name="select4" id="select4">
          </select>
          <input name="textfield12" type="text" class="sch" id="textfield12" style="width:120px" />
          </td>
      </tr>
      <tr>
        <td rowspan="3" class="M_form_th2">장비규격</td>
        <td rowspan="3" class="M_form_td2"><input name="textfield6" type="text" class="sch" id="textfield6" style="width:120px" /></td>
        <td width="9%" rowspan="2" class="M_form_th2">담당자</td>
        <td width="8%" class="M_form_th2">성명</td>
        <td height="25" class="M_view_td2">
          <input name="textfield10" type="text" class="sch" id="textfield10" style="width:120px" />
              <input name="button2" type="submit" class="btn_2a" id="button2" value="찾기" />          </td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">연락처</td>
        <td height="25" class="M_view_td2">
          <input name="textfield11" type="text" class="sch" id="textfield11" style="width:140px" />
        </td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="M_form_th2">용도</td>
        <td height="25" class="M_view_td2">
          <select name="select3" id="select3">
          </select>
        일일가동가능시간
        <input name="textfield9" type="text" class="sch" id="textfield9" style="width:30px" />
        </td>
      </tr>
      <tr>
        <td height="25" class="M_form_th2">정격정압</td>
        <td height="25" class="M_form_td2"><input name="textfield7" type="text" class="sch" id="textfield7" style="width:120px" /></td>
        <td height="25" colspan="2" class="M_form_th2">정격소비전력</td>
        <td height="25" class="M_view_td2">
          <input name="textfield8" type="text" class="sch" id="textfield8" style="width:140px" />
       </td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="M_form_th"><span class="M_form_th2">
          <input name="fileField2" type="file" id="fileField2" size="12" />
        </span></td>
        <td height="25" class="M_form_th2">장비상태</td>
        <td height="25" class="M_form_td2">
            <select name="select" id="select">
            </select>       </td>
        <td height="25" colspan="2" class="M_form_th2">반출장비유무</td>
        <td height="25" class="M_view_td2">
          <select name="select2" id="select2">
          </select>
       </td>
      </tr>
      <tr>
        <td width="7%" rowspan="8" class="M_form_th">장비<br />
          계약<br />
          정보</td>
        <td width="16%" class="M_form_th2">기자재번호</td>
        <td height="25" colspan="2" class="M_form_td2">
          <input name="textfield13" type="text" class="sch" id="textfield13" style="width:170px" />
        </td>
        <td height="25" colspan="2" class="M_form_th2">계약번호</td>
        <td height="25" class="M_view_td2">
          <input name="textfield22" type="text" class="sch" id="textfield22" style="width:170px" />        </td>
      </tr>
      <tr>
        <td class="M_form_th2">장비고유번호</td>
        <td height="25" colspan="2" class="M_form_td2">
          <input name="textfield14" type="text" class="sch" id="textfield14" style="width:170px" />
        </td>
        <td height="25" colspan="2" class="M_form_th2">신용장번호</td>
        <td height="25" class="M_view_td2">
          <input name="textfield23" type="text" class="sch" id="textfield23" style="width:170px" />        </td>
      </tr>
      <tr>
        <td class="M_form_th2">납품규격</td>
        <td height="25" colspan="2" class="M_form_td2">
          <input name="textfield15" type="text" class="sch" id="textfield15" style="width:170px" />
        </td>
        <td height="25" colspan="2" class="M_form_th2">수입신고번호</td>
        <td height="25" class="M_view_td2"> <input name="textfield23" type="text" class="sch" id="textfield23" style="width:170px" /></td>
      </tr>
      <tr>
        <td class="M_form_th2">외화구입가</td>
        <td height="25" colspan="2" class="M_form_td2">
          <input name="textfield16" type="text" class="sch" id="textfield16" style="width:170px" />
        </td>
        <td height="25" colspan="2" class="M_form_th2">원화구입가</td>
        <td height="25" class="M_view_td2"> <input name="textfield23" type="text" class="sch" id="textfield23" style="width:170px" /></td>
      </tr>
      <tr>
        <td class="M_form_th2">사후관리번호</td>
        <td height="25" colspan="2" class="M_form_td2">
          <input name="textfield17" type="text" class="sch" id="textfield17" style="width:170px" />
        </td>
        <td height="25" colspan="2" class="M_form_th2">내자품목비</td>
        <td height="25" class="M_view_td2"> <input name="textfield23" type="text" class="sch" id="textfield23" style="width:170px" /></td>
      </tr>
      <tr>
        <td class="M_form_th2">H.S.번호</td>
        <td height="25" colspan="2" class="M_form_td2">
          <input name="textfield18" type="text" class="sch" id="textfield18" style="width:170px" />
       </td>
        <td height="25" colspan="2" class="M_form_th2">총구입가</td>
        <td height="25" class="M_view_td2"> <input name="textfield23" type="text" class="sch" id="textfield23" style="width:170px" /></td>
      </tr>
      <tr>
        <td class="M_form_th2">구입일(계약일)</td>
        <td height="25" colspan="2" class="M_form_td2">
          <input name="textfield19" type="text" class="sch" id="textfield19" style="width:130px" />
          <img src="../A_img/common/M_btn/btn_cal.gif" width="15" height="14" />        </span></td>
        <td height="25" colspan="2" class="M_form_th2">납품일</td>
        <td height="25" class="M_view_td2">
          <input name="textfield21" type="text" class="sch" id="textfield21" style="width:130px" />
          <img src="../A_img/common/M_btn/btn_cal.gif" width="15" height="14" /></td>
      </tr>
      <tr>
        <td class="M_form_th2">설치일</td>
        <td height="25" colspan="5" class="M_form_td2">
          <input name="textfield20" type="text" class="sch" id="textfield20" style="width:130px" />
          <img src="../A_img/common/M_btn/btn_cal.gif" alt="" width="15" height="14" /></td>
        </tr>
      <tr>
        <td rowspan="3" class="M_form_th">교육</td>
        <td class="M_form_th2">업체명</td>
        <td height="25" colspan="2" class="M_form_td">
          <input name="textfield27" type="text" class="sch" id="textfield27" style="width:170px" />       </td>
        <td rowspan="3" class="M_form_th">A/S</td>
        <td height="25" class="M_form_th2">업체명</td>
        <td height="25" class="M_view_td2"><input name="textfield24" type="text" class="sch" id="textfield24" style="width:130px" /></td>
      </tr>
      <tr>
        <td class="M_form_th2">담당자</td>
        <td height="25" colspan="2" class="M_form_td"> <input name="textfield27" type="text" class="sch" id="textfield27" style="width:170px" /></td>
        <td height="25" class="M_form_th2">담당자</td>
        <td height="25" class="M_view_td2"><input name="textfield25" type="text" class="sch" id="textfield25" style="width:130px" /></td>
      </tr>
      <tr>
        <td class="M_form_th2">연락처</td>
        <td height="25" colspan="2" class="M_form_td"><input name="textfield27" type="text" class="sch" id="textfield27" style="width:170px" /></td>
        <td height="25" class="M_form_th2">연락처</td>
        <td height="25" class="M_view_td2"><input name="textfield26" type="text" class="sch" id="textfield26" style="width:130px" /></td>
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