document.write('<st'+'yle>');
document.write('td {font-size:12px; font-family:굴림; text-decoration:none; }');
document.write('A:link,A:active,A:visited{text-decoration:none;font-size:12PX;color:#333333;}');
document.write('A:hover {text-decoration:none; color:ff9900}');
document.write('font { font-size: 9pt; }');
document.write('.cnj_input {background-color:rgb(240,240,240);border-width:1pt; height:16pt;cursor:hand;}');
document.write('.cnj_input2 {border-width:1; border-color:rgb(204,204,204); border-style:solid;cursor:hand;}');
document.write('.cnj_input3 { border-width:1; border-style:solid; border-color:#000000; color:#0084D4; background-color:white;cursor:hand;}');
document.write('.cnj_input4 { scrollbar-face-color: #FFCC33;scrollbar-shadow-color: #ffffff;scrollbar-highlight-color: #F3f3f3;scrollbar-3dlight-color: #ffffff;scrollbar-darkshadow-color: #F3f3f3;scrollbar-track-color: #ffffff;scrollbar-arrow-color: #f9f9f9;cursor:hand; }');
document.write('</st'+'yle>');
// 수정 날짜 2002년 12월 4일 
// 편집자 Web Site: http://www.cginjs.com 대부분 주석이 달여 있음 
// | Last Modified:                  15-Oct-2002                |
// | Web Site:                       http://www.yxscripts.com   |
// | EMail:                          m_yangxin@hotmail.com      |

var fontFace="굴림";  // 글꼴 지정
var fontSize=12;  // 글꼴 크기

var titleWidth=90;
var titleMode=1;
var dayWidth=12;
var dayDigits=1;


var borderColor="#FFDE52";  // 테이블 전체 배경색
var titleColor="#FFDE52";    // 년도/월 나오는 상단 타이틀 부분 배경색
var daysColor="#FFFFCC";  // 요일 나오는 부분 배경색
var bodyColor="#ffffff";  // 날짜가 공백인 부분 배경색
var dayColor="#ffffff";  // 현재일이 아닌 날짜 부분 배경색
var currentDayColor="#FFF4CA";  // 현재 일(선택일) 셀 배경색
var footColor="#FFFFCC";  // 닫기/초기화 부분 셀 배경색

var titleFontColor = "#000000";  // 년도/월 나오는 상단 타이틀 부분 글자색
var daysFontColor = "#000000"; // 요일 나오는 부분 글자색
var dayFontColor = "#000000";  // 현재일이 아닌 날짜 부분 글자색
var currentDayFontColor = "#000000";  // 현재 일(선택일) 셀 글자색
var footFontColor = "#000000"; // 닫기/초기화 부분 셀 글자색

var calFormat = "yyyy-mm-dd";  // 날짜 형식 지정

var weekDay = 0;
// ------

// 팝업창 부분
var calWidth=180, calHeight=210, calOffsetX=-200, calOffsetY=16;
var calWin=null;
var winX=0, winY=0;
var cal="cal";
var cals=new Array();
var currentCal=null;

var yxMonths=new Array("1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월");
var yxDays=new Array("일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일", "일요일");
var yxLinks=new Array("[닫기]", "[초기화]");

var isOpera=(navigator.userAgent.indexOf("Opera")!=-1)?true:false;
var isOpera5=(navigator.appVersion.indexOf("MSIE 5")!=-1 && navigator.userAgent.indexOf("Opera 5")!=-1)?true:false;
var isOpera6=(navigator.appVersion.indexOf("MSIE 5")!=-1 && navigator.userAgent.indexOf("Opera 6")!=-1)?true:false;
var isN6=(navigator.userAgent.indexOf("Gecko")!=-1);
var isN4=(document.layers)?true:false;
var isMac=(navigator.userAgent.indexOf("Mac")!=-1);
var isIE=(document.all && !isOpera && (!isMac || navigator.appVersion.indexOf("MSIE 4")==-1))?true:false;

if (isN4) {
  fontSize+=2;
}

var span2="</span>";

function span1(tag) {
  return "<span class='"+tag+"'>";
}
function spanx(tag, color) {
  return "."+tag+" { font-family:"+fontFace+"; font-size:"+fontSize+"px; color:"+color+"; }\n";
}

function a1(tag) {
  return "<a class='"+tag+"' href=";
}

function ax(tag, color) {
  return "."+tag+" { text-decoration:none; color:"+color+"; }\n";
}

function calOBJ(name, title, field, form) {
  this.name = name;
  this.title = title;
  this.field = field;
  this.formName = form;
  this.form = null
}

function setFont(font, size) {
  if (font != "") {
    fontFace=font;
  }
  if (size > 0) {
    fontSize=size;

    if (isN4) {
      fontSize+=2;
    }
  }
}

function setWidth(tWidth, tMode, dWidth, dDigits) {
  if (tWidth > 0) {
    titleWidth=tWidth;
  }
  if (tMode == 1 || tMode == 2) {
    titleMode=tMode;
  }
  if (dWidth > 0) {
    dayWidth=dWidth;
  }
  if (dDigits > 0) {
    dayDigits=dDigits;
  }
}

function setColor(tColor, dsColor, bColor, dColor, cdColor, fColor, bdColor) {
  if (tColor != "") {
    titleColor=tColor;
  }
  if (dsColor != "") {
    daysColor=dsColor;
  }
  if (bColor != "") {
    bodyColor=bColor;
  }
  if (dColor != "") {
    dayColor=dColor;
  }
  if (cdColor != "") {
    currentDayColor=cdColor;
  }
  if (fColor != "") {
    footColor=fColor;
  }
  if (bdColor != "") {
    borderColor=bdColor;
  }
}

function setFontColor(tColorFont, dsColorFont, dColorFont, cdColorFont, fColorFont) {
  if (tColorFont != "") {
    titleFontColor=tColorFont;
  }
  if (dsColorFont != "") {
    daysFontColor=dsColorFont;
  }
  if (dColorFont != "") {
    dayFontColor=dColorFont;
  }
  if (cdColorFont != "") {
    currentDayFontColor=cdColorFont;
  }
  if (fColorFont != "") {
    footFontColor=fColorFont;
  }
}

function setFormat(format) {
  calFormat = format;
}

function setSize(width, height, ox, oy) {
  if (width > 0) {
    calWidth=width;
  }
  if (height > 0) {
    calHeight=height;
  }

  calOffsetX=ox;
  calOffsetY=oy;
}

function setWeekDay(wDay) {
  if (wDay == 0 || wDay == 1) {
    weekDay = wDay;
  }
}

function setMonthNames(janName, febName, marName, aprName, mayName, junName, julName, augName, sepName, octName, novName, decName) {
  if (janName != "") {
    yxMonths[0] = janName;
  }
  if (febName != "") {
    yxMonths[1] = febName;
  }
  if (marName != "") {
    yxMonths[2] = marName;
  }
  if (aprName != "") {
    yxMonths[3] = aprName;
  }
  if (mayName != "") {
    yxMonths[4] = mayName;
  }
  if (junName != "") {
    yxMonths[5] = junName;
  }
  if (julName != "") {
    yxMonths[6] = julName;
  }
  if (augName != "") {
    yxMonths[7] = augName;
  }
  if (sepName != "") {
    yxMonths[8] = sepName;
  }
  if (octName != "") {
    yxMonths[9] = octName;
  }
  if (novName != "") {
    yxMonths[10] = novName;
  }
  if (decName != "") {
    yxMonths[11] = decName;
  }
}

function setDayNames(sunName, monName, tueName, wedName, thuName, friName, satName) {
  if (sunName != "") {
    yxDays[0] = sunName;
    yxDays[7] = sunName;
  }
  if (monName != "") {
    yxDays[1] = monName;
  }
  if (tueName != "") {
    yxDays[2] = tueName;
  }
  if (wedName != "") {
    yxDays[3] = wedName;
  }
  if (thuName != "") {
    yxDays[4] = thuName;
  }
  if (friName != "") {
    yxDays[5] = friName;
  }
  if (satName != "") {
    yxDays[6] = satName;
  }
}

function setLinkNames(closeLink, clearLink) {
  if (closeLink != "") {
    yxLinks[0] = closeLink;
  }
  if (clearLink != "") {
    yxLinks[1] = clearLink;
  }
}

function addCalendar(name, title, field, form) {
  cals[cals.length] = new calOBJ(name, title, field, form);
}

function findCalendar(name) {
  for (var i = 0; i < cals.length; i++) {
    if (cals[i].name == name) {
      if (cals[i].form == null) {
        if (cals[i].formName == "") {
          if (document.forms[0]) {
            cals[i].form = document.forms[0];
          }
        }
        else if (document.forms[cals[i].formName]) {
          cals[i].form = document.forms[cals[i].formName];
        }
      }

      return cals[i];
    }
  }

  return null;
}

function getDayName(y,m,d) {
  var wd=new Date(y,m,d);
  return yxDays[wd.getDay()].substring(0,3);
}

function getMonthFromName(m3) {
  for (var i = 0; i < yxMonths.length; i++) {
    if (yxMonths[i].toLowerCase().substring(0,3) == m3.toLowerCase()) {
      return i;
    }
  }

  return 0;
}

function getFormat() {
 var calF = calFormat;

 calF = calF.replace(/\\/g, '\\\\');
 calF = calF.replace(/\//g, '\\\/');
 calF = calF.replace(/\[/g, '\\\[');
 calF = calF.replace(/\]/g, '\\\]');
 calF = calF.replace(/\(/g, '\\\(');
 calF = calF.replace(/\)/g, '\\\)');
 calF = calF.replace(/\{/g, '\\\{');
 calF = calF.replace(/\}/g, '\\\}');
 calF = calF.replace(/\</g, '\\\<');
 calF = calF.replace(/\>/g, '\\\>');
 calF = calF.replace(/\|/g, '\\\|');
 calF = calF.replace(/\*/g, '\\\*');
 calF = calF.replace(/\?/g, '\\\?');
 calF = calF.replace(/\+/g, '\\\+');
 calF = calF.replace(/\^/g, '\\\^');
 calF = calF.replace(/\$/g, '\\\$');

 calF = calF.replace(/dd/i, '\\d\\d');
 calF = calF.replace(/mm/i, '\\d\\d');
 calF = calF.replace(/yyyy/i, '\\d\\d\\d\\d');
 calF = calF.replace(/day/i, '\\w\\w\\w');
 calF = calF.replace(/mon/i, '\\w\\w\\w');

 return new RegExp(calF);
}

function getDateNumbers(date) {
 var y, m, d;

 var yIdx = calFormat.search(/yyyy/i);
 var mIdx = calFormat.search(/mm/i);
 var m3Idx = calFormat.search(/mon/i);
 var dIdx = calFormat.search(/dd/i);


  y=date.substring(yIdx,yIdx+4)-0;
  if (mIdx != -1) {
    m=date.substring(mIdx,mIdx+2)-1;
  }
  else {
    var m = getMonthFromName(date.substring(m3Idx,m3Idx+3));
  }
  d=date.substring(dIdx,dIdx+2)-0;

  return new Array(y,m,d);
}

function hideCal() {
  calWin.close();
  calWin = null;
  window.status = "";
}

function getLeftIE(x,m) {
  var dx=0;
  if (x.tagName=="TD"){
    dx=x.offsetLeft;
  }
  else if (x.tagName=="TABLE") {
    dx=x.offsetLeft;
    if (m) { dx+=(x.cellPadding!=""?parseInt(x.cellPadding):2); m=false; }
  }
  return dx+(x.parentElement.tagName=="BODY"?0:getLeftIE(x.parentElement,m));
}
function getTopIE(x,m) {
  var dy=0;
  if (x.tagName=="TR"){
    dy=x.offsetTop;
  }
  else if (x.tagName=="TABLE") {
    dy=x.offsetTop;
    if (m) { dy+=(x.cellPadding!=""?parseInt(x.cellPadding):2); m=false; }
  }
  return dy+(x.parentElement.tagName=="BODY"?0:getTopIE(x.parentElement,m));
}

function getLeftN4(l) { return l.pageX; }
function getTopN4(l) { return l.pageY; }

function getLeftN6(l) { return l.offsetLeft; }
function getTopN6(l) { return l.offsetTop; }

function lastDay(d) {
  var yy=d.getFullYear(), mm=d.getMonth();
  for (var i=31; i>=28; i--) {
    var nd=new Date(yy,mm,i);
    if (mm == nd.getMonth()) {
      return i;
    }
  }
}

function firstDay(d) {
  var yy=d.getFullYear(), mm=d.getMonth();
  var fd=new Date(yy,mm,1);
  return fd.getDay();
}

function dayDisplay(i) {
  if (dayDigits == 0) {
    return yxDays[i];
  }
  else {
    return yxDays[i].substring(0,dayDigits);
  }
}

function calTitle(d) {
  var yy=d.getFullYear(), mm=yxMonths[d.getMonth()];
  var s;

  if (titleMode == 2) {
    s="<tr align='center' bgcolor='"+titleColor+"'>"+
       "<td colspan='7'>\n"+
       "<table cellpadding='0' cellspacing='0' border='0'>"+
       "<tr align='center' valign='middle'>"+
       "<td align='right'>"+
        span1("title")+"<b>"+a1("titlea")+

	// 이전 년도
	"'javascript:if(window.opener && !window.opener.closed && window.opener.moveYear) window.opener.moveYear(-10)' title='이전 년도'> ≪</a> "+
	a1("titlea")+

	// 이전 월
	"'javascript:if(window.opener && !window.opener.closed && window.opener.moveYear) window.opener.moveYear(-1)' title='이전 월'>< </a></b>"+
	span2+
	"</td>"+

	"<td width='"+titleWidth+"'>"+span1("title") +yy+"년 "+mm+" "+span2+"</td>"+   // 타이틀 년도 / 월 나오는 부분

	"<td align='left'>"+
	span1("title")+"<b>"+a1("titlea")+

	// 다음 월
	"'javascript:if (window.opener && !window.opener.closed && window.opener.moveYear) window.opener.moveYear(1)' title='다음 월'> ></a> "+  
	
	// 다음 년도
	a1("titlea")+"'javascript:if (window.opener && !window.opener.closed && window.opener.moveYear) window.opener.moveYear(10)' title='다음 년도'>≫ </a></b>"+
	span2+
	
	"</td></tr>"+
	"<tr align='center' valign='middle'><td align='right'>"+
	+span1("title")+"<b>"+a1("titlea")+
	
	// 이전 월
	"'javascript:if (window.opener && !window.opener.closed && window.opener.prepMonth) window.opener.prepMonth("+d.getMonth()+")' title='이전 월'> < </a>"+
	
	"</b>"+span2+"</td>"+
	"<td width='"+titleWidth+"'><b>"+span1("title")+mm+span2+"</b></td>"+
	"<td align='left'>"+span1("title")+"<b>"+a1("titlea")+

	// 이전 년도
	"'javascript:if (window.opener && !window.opener.closed && window.opener.nextMonth) window.opener.nextMonth("+d.getMonth()+")' title='이전 년도'> < </a></b>"+
	+span2+

	"</td></tr></table>\n"+
	"</td></tr><tr align='center' bgcolor='"+daysColor+"'>";
  }
  else {
    s="<tr align='center' bgcolor='"+titleColor+"'>\n"+
    "<td colspan='7'>\n"+
    "<table cellpadding='0' cellspacing='0' border='0'>\n"+
    "<tr align='center' valign='middle'><td>\n"+
     span1("title")+"<b>"+a1("titlea")+
    "'javascript:if(window.opener && !window.opener.closed && window.opener.moveYear) window.opener.moveYear(-1)' title='이전 연도'> ≪</a> "+
    a1("titlea")+"'javascript:if (window.opener && !window.opener.closed && window.opener.prepMonth) window.opener.prepMonth("+d.getMonth()+")' title='이전 월'><</a></b>"+
    span2+"</td>\n"+
    "<td width='"+titleWidth+"'>\n"+
    "<nobr>"+span1("title") +yy+"년 "+mm+" "+span2+"</nobr>\n"+   // 타이틀 년도 / 월 나오는 부분
    "</td>\n<td>\n"+
    span1("title")+"<b>"+a1("titlea")+
    "'javascript:if (window.opener && !window.opener.closed && window.opener.nextMonth) window.opener.nextMonth("+d.getMonth()+")' title='다음 월'> ></a> "+
    a1("titlea")+"'javascript:if(window.opener && !window.opener.closed && window.opener.moveYear) window.opener.moveYear(1)' title='다음 년도'>≫ </a></b>"+
    span2+"</td>\n"+
    "</tr></table>\n"+
    "</td></tr>\n"+
    "<tr align='center' bgcolor='"+daysColor+"'>\n";
  }

  for (var i=weekDay; i<weekDay+7; i++) {
    s+="<td width='"+dayWidth+"'>"+span1("days")+dayDisplay(i)+span2+"</td>";
  }

  s+="</tr>";

  return s;
}

function calHeader() {   // 표 head 시작 부분
  return "<head>\n<title>"+currentCal.title+"</title>"+
           "\n<style type='text/css'>\n"+
	   spanx("title",titleFontColor)+spanx("days",daysFontColor)+spanx("foot",footColor)+spanx("day",dayFontColor)+spanx("currentDay",currentDayFontColor)+ax("titlea",titleFontColor)+ax("daya",dayFontColor)+ax("currenta",currentDayFontColor)+ax("foota",footFontColor)+
	   "</style>\n"+
	   "</head>\n"+
	   "<body>\n"+
	   "<table align='center' border='0' bgcolor='"+borderColor+"' cellspacing='0' cellpadding='1'>\n"+
	   "<tr>\n"+
	   "<td>\n"+
	   "<table cellspacing='1' cellpadding='3' border='0'>";
}



function calFooter() {    // 표 FOOT 시작 부분
  return "<tr bgcolor='"+footColor+"'>"+
	   "<td colspan='7' align='center'>"+
	   span1("foot")+""+a1("foota")+
	   "'javascript:if (window.opener && !window.opener.closed && window.opener.hideCal) window.opener.hideCal()'>"+
	   yxLinks[0]+"</a>  "+       // 닫기 링크
	   a1("foota")+
	   "'javascript:if (window.opener && !window.opener.closed && window.opener.clearDate) window.opener.clearDate()'>"+
	   yxLinks[1]+"</a>"+  // 초기화 링크
	   span2+"</td></tr>"+
	   "</table>\n</td></tr></table>\n</body>";
}

function calBody(d,day) {
  var s="", dayCount=1, fd=firstDay(d), ld=lastDay(d);

  if (weekDay > 0 && fd == 0) {
    fd = 7;
  }

  for (var i=0; i<6; i++) {
    s+="<tr align='center' bgcolor='"+bodyColor+"'>";
    for (var j=weekDay; j<weekDay+7; j++) {
      if (i*7+j<fd || dayCount>ld) {
        s+="<td>"+span1("day")+" "+span2+"</td>";
      }
      else {
        var bgColor=dayColor;
        var fgTag="day";
        var fgTagA="daya";
        if (dayCount==day) { 
          bgColor=currentDayColor; 
          fgTag="currentDay";
          fgTagA="currenta";
        }
        
        s+="<td bgcolor='"+bgColor+"'>"+
	span1(fgTag)+a1(fgTagA)+
	"'javascript: if (window.opener && !window.opener.closed && window.opener.pickDate) window.opener.pickDate("+dayCount+")'>"+
	(dayCount++)+
	"</a>"+span2+
	"</td>";
      }
    }
    s+="</tr>";
  }

  return s;
}

function moveYear(dy) {
  cY+=dy;
  var nd=new Date(cY,cM,1);
  changeCal(nd);
}

function prepMonth(m) {
  cM=m-1;
  if (cM<0) { cM=11; cY--; }
  var nd=new Date(cY,cM,1);
  changeCal(nd);
}

function nextMonth(m) {
  cM=m+1;
  if (cM>11) { cM=0; cY++;}
  var nd=new Date(cY,cM,1);
  changeCal(nd);
}

function changeCal(d) {
  var dd = 0;

  if (currentCal != null) {
    var calRE = getFormat();

    if (currentCal.form[currentCal.field].value!="" && calRE.test(currentCal.form[currentCal.field].value)) {
      var cd = getDateNumbers(currentCal.form[currentCal.field].value);
      if (cd[0] == d.getFullYear() && cd[1] == d.getMonth()) {
        dd=cd[2];
      }
    }
    else {
      var cd = new Date();
      if (cd.getFullYear() == d.getFullYear() && cd.getMonth() == d.getMonth()) {
        dd=cd.getDate();
      }
    }
  }

  var calendar=calHeader()+calTitle(d)+calBody(d,dd)+calFooter();

  calWin.document.open();
  calWin.document.write(calendar);
  calWin.document.close();
}

function markClick(e) {
  if (isIE || isOpera6) {
    winX=event.screenX;
    winY=event.screenY;
  }
  else if (isN4 || isN6) {
    winX=e.screenX;
    winY=e.screenY;

    document.routeEvent(e);
  }

  return true;
}

function showCal(name) {
  var lastCal=currentCal;
  var d=new Date(), hasCal=false;

  currentCal = findCalendar(name);

  if (currentCal != null && currentCal.form != null && currentCal.form[currentCal.field]) {
    var calRE = getFormat();

    if (currentCal.form[currentCal.field].value!="" && calRE.test(currentCal.form[currentCal.field].value)) {
      var cd = getDateNumbers(currentCal.form[currentCal.field].value);
      d=new Date(cd[0],cd[1],cd[2]);

      cY=cd[0];
      cM=cd[1];
      dd=cd[2];
    }
    else {
      cY=d.getFullYear();
      cM=d.getMonth();
      dd=d.getDate();
    }

    var calendar=calHeader()+calTitle(d)+calBody(d,dd)+calFooter();

    if (calWin != null && !calWin.closed) {
      hasCal=true;
      calWin.moveTo(winX+calOffsetX,winY+calOffsetY);
    }

    if (!hasCal) {
      if (isIE || isOpera6) {
        calWin=window.open("","cal","toolbar=0,width="+calWidth+",height="+calHeight+",left="+(winX+calOffsetX)+",top="+(winY+calOffsetY));
      }
      else {
        calWin=window.open("","cal","toolbar=0,width="+calWidth+",height="+calHeight+",screenx="+(winX+calOffsetX)+",screeny="+(winY+calOffsetY));
      }
    }

    calWin.document.open();
    calWin.document.write(calendar);
    calWin.document.close();

    calWin.focus();
  }
  else {
    if (currentCal == null) {
      window.status = "Calendar ["+name+"] not found.";
    }
    else if (!currentCal.form) {
      window.status = "Form ["+currentCal.formName+"] not found.";
    }
    else if (!currentCal.form[currentCal.field]) {
      window.status = "Form Field ["+currentCal.formName+"."+currentCal.field+"] not found.";
    }

    if (lastCal != null) {
      currentCal = lastCal;
    }
  }
}

function get2Digits(n) {
  return ((n<10)?"0":"")+n;
}

function clearDate() {
  currentCal.form[currentCal.field].value="";
  hideCal();
}

function pickDate(d) {
  hideCal();
  window.focus();

  var date=calFormat;
  date = date.replace(/yyyy/i, cY);
  date = date.replace(/mm/i, get2Digits(cM+1));
  date = date.replace(/MON/, yxMonths[cM].substring(0,3).toUpperCase());
  date = date.replace(/Mon/i, yxMonths[cM].substring(0,3));
  date = date.replace(/dd/i, get2Digits(d));
  date = date.replace(/DAY/, getDayName(cY,cM,d).toUpperCase());
  date = date.replace(/day/i, getDayName(cY,cM,d));

  currentCal.form[currentCal.field].value=date;
  // IE5/Mac needs focus to show the value, weird.
  currentCal.form[currentCal.field].focus();
}
// ------

// user functions
function checkDate(name) {
  var thisCal = findCalendar(name);

  if (thisCal != null && thisCal.form != null && thisCal.form[thisCal.field]) {
    var calRE = getFormat();

    if (calRE.test(thisCal.form[thisCal.field].value)) {
      return 0;
    } else {
      return 1;
    }
  } else {
    return 2;
  }
}

function getCurrentDate() {
  var date=calFormat, d = new Date();
  date = date.replace(/yyyy/i, d.getFullYear());
  date = date.replace(/mm/i, get2Digits(d.getMonth()+1));
  date = date.replace(/dd/i, get2Digits(d.getDate()));

  return date;
}

function compareDates(date1, date2) {
  var calRE = getFormat();
  var d1, d2;

  if (calRE.test(date1)) {
    d1 = getNumbers(date1);
  } else {
    d1 = getNumbers(getCurrentDate());
  }

  if (calRE.test(date2)) {
    d2 = getNumbers(date2);
  } else {
    d2 = getNumbers(getCurrentDate());
  }

  var dStr1 = d1[0] + "" + d1[1] + "" + d1[2];
  var dStr2 = d2[0] + "" + d2[1] + "" + d2[2];

  if (dStr1 == dStr2) {
    return 0;
  } else if (dStr1 > dStr2) {
    return 1;
  } else {
    return -1;
  }
}

function getNumbers(date) {
  var calRE = getFormat();
  var y, m, d;

  if (calRE.test(date)) {
    var yIdx = calFormat.search(/yyyy/i);
    var mIdx = calFormat.search(/mm/i);
    var m3Idx = calFormat.search(/mon/i);
    var dIdx = calFormat.search(/dd/i);

    y=date.substring(yIdx,yIdx+4);
    if (mIdx != -1) {
      m=date.substring(mIdx,mIdx+2);
    } else {
      var mm=getMonthFromName(date.substring(m3Idx,m3Idx+3))+1;
      m=(mm<10)?("0"+mm):(""+mm);
    }
    d=date.substring(dIdx,dIdx+2);

    return new Array(y,m,d);
  } else {
    return new Array("", "", "");
  }
}
// ------

if (isN4 || isN6) {
  document.captureEvents(Event.CLICK);
}
document.onclick=markClick;