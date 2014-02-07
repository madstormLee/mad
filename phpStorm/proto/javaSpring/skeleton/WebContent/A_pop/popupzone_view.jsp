<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>popupzone 상세보기</title>
<link rel="stylesheet" type="text/css" href="../css/popup.css" />

    <body style="background:#FFFFF7;">

        <div id="pop_wrapper">

            <div id="pop_top">
            <!--타이틀 영역 -->
                <div id="pop_top_left">
                  <h1>POPUPZONE VIEW</h1>
                </div>
                <div id="pop_top_center"></div>
                </div>
                
            <div id="pop_center">

                <div id="con_info_tit">
                팝업 내용 들어갈 곳

                </div>

            </div>

<!--버튼영역 -->
            <div id="pop_btm">
                <div id="pop_btm_left"></div>
                <div id="pop_btm_center"></div>
                <div id="pop_btm_right"><a href="javascript:self.close();"><img src="../U_img/popup/pop_btm_right.gif" width="150" height="34" alt="창닫기" title="창닫기"></a></div>
            </div>
        </div>
    </body>
</html>

