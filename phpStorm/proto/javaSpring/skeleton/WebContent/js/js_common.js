<!--
/*########################################################
@ 날짜가 제대로 입력되었는지 체크한다.
@ param fyear,fmonth,fday : 년,월,일
@ return String (실패(fail)/성공(alldate:년월일을 합친값))	
#########################################################*/
function dateCheck(fyear,fmonth,fday) {	
	alldate = new Array(3);
	alldate[0] = "fail";
	ftotal_days = 0;
	fdate = fyear+fmonth+fday;
	fdatelen = fdate.length;
	
/*-----------------------------------------------------------
* 숫자가 아닌 문자가 있는지 체크
*-----------------------------------------------------------*/
	for(i=0; i<fdatelen; i++) {										
		if(fdate.charCodeAt(i) <45 || fdate.charCodeAt(i) >57){					
			return alldate;
		}
	}	

/*-----------------------------------------------------------
* 년도가 4자리인지 체크
*-----------------------------------------------------------*/	
	if(fyear.length != 4) {						
		return alldate;
	}

/*-----------------------------------------------------------
* 달이 1~12인지 체크
*-----------------------------------------------------------*/	
	if(fmonth < 1 || fmonth > 12){		
		return alldate;
	}

/*-----------------------------------------------------------
* 달이 1이면 01로 바꾼다.
*-----------------------------------------------------------*/	
	if(fmonth.length == 1) {											
		fmonth = "0"+fmonth;
	}

/*-----------------------------------------------------
* 시작년도의 마지막일자를 구한다.
*-----------------------------------------------------*/
	if(fmonth=="01" || fmonth=="03" || fmonth=="05" || fmonth=="07" || fmonth=="08" || fmonth==10 || fmonth==12) {	
		ftotal_days = 31;
	}else if(fmonth == "02"){
		if(((fyear % 4 == 0) && (fyear % 100 !=0)) || (fyear % 400 == 0)){
			ftotal_days = 29;
		}else{
			ftotal_days = 28;
		}
	}else{
		ftotal_days = 30;
	}

/*-----------------------------------------------------
* 일자가 마지막 일자보다 큰지를 구한다.
*-----------------------------------------------------*/
	if(fday < 1 || fday > ftotal_days){
		return alldate;
	}

/*-----------------------------------------------------
* 일자가 1이면 01로 바꾼다.
*-----------------------------------------------------*/
	if(fday.length == 1) {
		fday = "0"+ fday;
	}

/*-----------------------------------------------------
* 년월일을 합쳐서 리턴한다.
*-----------------------------------------------------*/
	alldate[0] = fyear;
	alldate[1] = fmonth;
	alldate[2] = fday;
	
	return alldate;
}



/*########################################################
@ 시작날짜가 마지막날짜 보다 적은지 체크
@ param str,len : 문자,제한크기
@ return boolean 	
#########################################################*/
function dateRange(fyear,fmonth,fday,eyear,emonth,eday) {
	fdate = fyear + fmonth + fday;
	edate = eyear + emonth + eday;
	if(fdate > edate){
		return false;	
	}else{
		return true;
	}
}



/*########################################################
@ 글자 크기가 맞는지 체크
@ param str,len : 문자,제한크기
@ return boolean 	
#########################################################*/
function lengthCheck(str,len) {	
	num = 0;
	strlen = str.length;
	for(i=0; i<strlen; i++){
		if(str.charCodeAt(i) >=0 && str.charCodeAt(i) <=128){
			num= num+1;
		}else{
			num= num+2;
		}	
	}
	
	if (num > len) {
		return false;
	}else{
		return true;
	}
}


/*########################################################
@ 날짜에 맞는 요일을 출력한다.
@ param year,month,day : 년,월,일
@ return String (실패(fail)/성공(요일이름)	
#########################################################*/

/*-----------------------------------------------------------
* 값을 받아서 요일을 계산한 뒤 return 하는 함수
*-----------------------------------------------------------*/	
function find_yoil(year, month, day) {
	var nYear =  parseInt(year); 
	var nMonth = parseInt(month); 
    var nDay =  parseInt(day); 
	var nDayOfWeek = cala_weekday(nMonth, nDay, nYear);
         
    return day_display(nDayOfWeek);
}

/*-----------------------------------------------------------
* 요일을 계산하는 함수
*-----------------------------------------------------------*/	
function cala_weekday( x_nMonth, x_nDay, x_nYear) { 

        if(x_nMonth >= 3){         
                x_nMonth -= 2; 
        } 
        else { 
                x_nMonth += 10; 
        } 

        if( (x_nMonth == 11) || (x_nMonth == 12) ){ 
                x_nYear--; 
        } 

        var nCentNum = parseInt(x_nYear / 100); 
        var nDYearNum = x_nYear % 100; 

        var g = parseInt(2.6 * x_nMonth - .2); 

        g +=  parseInt(x_nDay + nDYearNum); 
        g += nDYearNum / 4;         
        g = parseInt(g); 
        g += parseInt(nCentNum / 4); 
        g -= parseInt(2 * nCentNum); 
        g %= 7; 
         
        if(x_nYear >= 1700 && x_nYear <= 1751) { 
                g -= 3; 
        } 
        else { 
                if(x_nYear <= 1699) { 
                        g -= 4; 
                } 
        } 
         
        if(g < 0){ 
                g += 7; 
        } 
         
        return g; 
} 

/*-----------------------------------------------------------
* 요일에 해당하는 string을 계산하는 함수
*-----------------------------------------------------------*/	

function day_display(x_nDayOfWeek) { 
	var day_name;
    if(x_nDayOfWeek == 0) { 
        day_name = "일"; 
    } 
    else if(x_nDayOfWeek == 1) { 
        day_name = "월"; 
    } 
    else if(x_nDayOfWeek == 2) { 
		day_name = "화";
    } 
    else if(x_nDayOfWeek == 3) { 
		day_name = "수";
	} 
    else if(x_nDayOfWeek == 4) { 
		day_name = "목";
    } 
    else if(x_nDayOfWeek == 5) { 
		day_name = "금";
    } 
    else if(x_nDayOfWeek == 6) { 
		day_name = "토";
    } 
	else {
		day_name = "fail";
	}
	
	return day_name;
} 

/*########################################################
@ 주민등록번호를 체크한다.
@ param juminNo : 주민등록번호
@ return boolean 	
#########################################################*/
function isJuminType(juminNo) {	
	if (fnrrnCheck(juminNo) || fnfgnCheck(juminNo)) {
		return true;
	}
	return false;
}
// 주민등록번호유효성검사.
function fnrrnCheck(juminNo) {
	var birthYear = juminNo.substring(0,2);
	var birthMonth = juminNo.substring(2,4);
	var birthDay = juminNo.substring(4,6);	
	var genderBit = juminNo.substring(6,7);

	// 주민번호 자리수가 13자리가 아니면 false
	if (juminNo.length != 13) {
		return false;
	}
	
	// 주민번호중 숫자가 아닌값이 포함되어있으면 false
	for (i=0; i<juminNo.length; i++){
		numCheck = juminNo.substring(i,i+1);
		if (numCheck < '0' || numCheck > '9'){ 
			return false;
		}
	}
	
	// 주민번호 (6)번째 자리수가 "1" 또는 "2"이면 1900년대생이고, "3" 또는 "4"이면 2000년대생이다.
	if (genderBit == '1' || genderBit == '2') {
		birthYear = "19" + birthYear
	} else if (birthYear == '3' || birthYear == '4') {
		birthYear = "20" + birthYear
	} else {
		return false;
	}
	
	// 생년에 따른 월과 일이 범위안에 있는가 체크한다.(윤년 확인)
	var days;
	if (birthMonth==1 || birthMonth==3 || birthMonth==5 || birthMonth==7 || birthMonth==8 || birthMonth==10 || birthMonth==12)  days=31;
	else if (birthMonth==4 || birthMonth==6 || birthMonth==9 || birthMonth==11) days=30;
	else if (birthMonth==2)  {
		if (((birthYear % 4)==0) && ((birthYear % 100)!=0) || (birthYear==0)) days=29;
	  	else days=28;
	}
	
	if (birthDay > days) {
		return false;
	}
   
	// check digit bit	
	var checkBit = 0;
	var checkDigit = juminNo.substring(12,13);
	
	checkBit = checkBit + juminNo.substring(0,1) * 2;
	checkBit = checkBit + juminNo.substring(1,2) * 3
	checkBit = checkBit + juminNo.substring(2,3) * 4;
	checkBit = checkBit + juminNo.substring(3,4) * 5;
	checkBit = checkBit + juminNo.substring(4,5) * 6;
	checkBit = checkBit + juminNo.substring(5,6) * 7;
	
	checkBit = checkBit + juminNo.substring(6,7) * 8;
	checkBit = checkBit + juminNo.substring(7,8) * 9;
	checkBit = checkBit + juminNo.substring(8,9) * 2;
	checkBit = checkBit + juminNo.substring(9,10) * 3;
	checkBit = checkBit + juminNo.substring(10,11) * 4;
	checkBit = checkBit + juminNo.substring(11,12) * 5;
		
	checkBit = (11 - (checkBit % 11)) % 10;
	if (checkBit != checkDigit) {
		return false;	
	}
	return true;
}
// 외국인등록번호유효성검사.
function fnfgnCheck(rrn){ 
	var sum = 0;
	if (rrn.length != 13) {
		return false;
	}else if (rrn.substr(6, 1) != 5 && rrn.substr(6, 1) != 6 && rrn.substr(6, 1) != 7 && rrn.substr(6, 1) != 8) {
		return false;
	}
	if (Number(rrn.substr(7, 2)) % 2 != 0) {
		return false;
	}
	for (var i = 0; i < 12; i++) {
		sum += Number(rrn.substr(i, 1)) * ((i % 8) + 2);
	}
	if ((((11 - (sum % 11)) % 10 + 2) % 10) == Number(rrn.substr(12, 1))) {
		return true;
	}
	return false;
}

/*########################################################
@ 숫자에 comma를 찍는다.
@ param value : 숫자를 받아온다.
@ return String (실패(fail)/성공(comma가 찍힌 요일)	
#########################################################*/
function wonCheck(str){
	returnVal = "false";	
   	strlen = str.length;

//	숫자와 comma가 아닌지 체크
	for(i=0; i<strlen; i++) {															
		if(str.charCodeAt(i)!=44 && (str.charCodeAt(i) <48 || str.charCodeAt(i) >57)){	
			return returnVal;
		}
	}

//	comma가 있으면 comma를 없앤다.
  	str_01 = "";
  	str_02 = str.split(",");
	for(k=0;k<str_02.length;k++) {
		str_01 = str_01+str_02[k];		
  	}

//	값의 크기가 10자리 보다 크면
	if(str_01.length >10) {					
		return returnVal;
	}

// 자리수에 맞게 comma를 넣는다.
	comma_01="";
	comma_02="";
	comma_03="";
	str_01Len = str_01.length;
	strVal_01 = str_01.substring(str_01Len - 3,str_01Len);
	strVal_02 = str_01.substring(str_01Len - 6,str_01Len-3);
	strVal_03 = str_01.substring(str_01Len - 9,str_01Len-6);
	strVal_04 = str_01.substring(0,str_01Len-9);
	if(str_01Len >3) comma_01 = ",";
	if(str_01Len >6) comma_02 = ",";
	if(str_01Len >9) comma_03 = ",";
	strVal =strVal_04 + comma_03 + strVal_03 + comma_02 + strVal_02 +comma_01 + strVal_01 ;
	
	return strVal;
}
/*########################################################
@ 숫자에 comma를 빼고 앞뒤 값을 비교한다.
@ param value : 숫자를 받아온다.
@ return String (실패(fail)/성공(comma가 찍힌 요일)	
#########################################################*/
function wonCompare(str1, str2){
	returnVal = "false";	
   	
//	comma가 있으면 comma를 없앤다.
  	str1_01 = "";
  	str1_02 = str1.split(",");
	for(k=0;k<str1_02.length;k++) {
		str1_01 = str1_01+str1_02[k];
  	}
//	comma가 있으면 comma를 없앤다.
  	str2_01 = "";
  	str2_02 = str2.split(",");
	for(k=0;k<str2_02.length;k++) {
		str2_01 = str2_01 + str2_02[k];
  	}

//comma를 뺀 값을 서로 비교 한다.
	if (eval(str1_01) > eval(str2_01)) {
		return returnVal;
	}

	return true;
}
/*########################################################
@ comma를 뺀 글자 크기가 맞는지 체크
@ param str,len : 문자,제한크기
@ return boolean 	
#########################################################*/
function comlengthCheck(str,len) {	
	num = 0;


//	comma가 있으면 comma를 없앤다.
  	str_01 = "";
  	str_02 = str.split(",");
	for(k=0;k<str_02.length;k++) {
		str_01 = str_01+str_02[k];
  	}
	strlen = str_01.length;
	
	for(i=0; i<strlen; i++){
		if(str.charCodeAt(i) >=0 && str.charCodeAt(i) <=128){
			num= num+1;
		}else{
			num= num+2;
		}	
	}
	
	if (num > len) {
		return false;
	}else{
		return true;
	}
}

//메일 형식체크(맞으면 true 틀리면 false)
function isMailType(name,message){
	var standard="0123456789abcdefghijklmnopqrstuvwxyz_-.@";
	if(name.value.indexOf("@")==-1||name.value.indexOf(".")==-1){
		alert(message);
		name.focus();
		return false;
	}else{
		for (i=0;i<name.value.length;i++ ){
			if(standard.indexOf(name.value.charAt(i))==-1){
				alert(message);
				name.focus();
				return false;
				break;
			}
		}
	}
	return true;
}

//공란제거
function trim(strValue){
	var rValue="";
	for(i=0;i<strValue.length;i++){
		if(strValue.charAt(i)==" "){
			rValue=rValue+"";
		}else{
			rValue=rValue+strValue.charAt(i);
		}
	}
	return rValue;
}
//널체크(널이면 true, 널이아니면 false)
function isNull(name,message){
	if(!trim(name.value)){
		alert(message);
		name.value="";
		name.focus();
		return true;
	}
}

//널체크(널이면 true, 널이아니면 false)
function isNullHide(name,message){
	if(!trim(name.value)){
		alert(message);
		name.value="";
		return true;
	}
}

// Initialize arrays. 
var months = new Array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"); 
var daysInMonth = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
var days = new Array("일", "월", "화", "수", "목", "금", "토"); 
var targetField;

var X;
var Y;

function showCalendar(target)
{
	X = (event.clientX + document.body.scrollLeft) - 150;
    Y = (event.clientY + document.body.scrollTop)+10; 
	document.all['cal'].style.display='block';
	document.all['cal'].style.left=X; //left;
	document.all['cal'].style.top=Y; //top;

	targetField = target;

	document.onmousedown = hideCal;
}

function hideCal()
{
	currentX = (event.clientX + document.body.scrollLeft);
	currentY = (event.clientY + document.body.scrollTop);

	if (currentX < X || currentX > (X+150) || currentY < Y || currentY > (Y+190))
	{
		document.all['cal'].style.display='none';
	}

}

function getDays(month, year) 
{ 
	// Test for leap year when February is selected. 
	if (1 == month) 
	return ((0 == year % 4) && (0 != (year % 100))) || 
	(0 == year % 400) ? 29 : 28; 
	else 
	return daysInMonth[month]; 
} 

function getToday() 
{
	// Generate today's date. 
	this.now = new Date(); 
	this.year= this.now.getYear(); 
	this.year = this.year % 100; 
	/* -------------------------------------------------------------*/ 
	// Y2K incompatibility.. added 1900 if last 2 digits of year 
	// were >= 50, added 2000 if < 50. 

	this.year = ((this.year < 50) ? (2000 + this.year) : (1900 + this.year)); 
	/* -------------------------------------------------------------*/ 
	if (((this.year % 4 == 0) && !(this.year % 100 == 0))||(this.year % 400 ==0)) 
	daysInMonth[1]++; 

	this.month = this.now.getMonth(); 
	this.day = this.now.getDate(); 
} 

	// Start with a calendar for today. 
	today = new getToday(); 

function newCalendar() 
{
	today = new getToday();
	var parseYear = parseInt(document.all.year.value);
	var newCal = new Date(parseYear, document.all.month.selectedIndex, 1);
	var day = -1;
	var startDay = newCal.getDay();
	var daily = 0;

	if ((today.year == newCal.getYear()) && (today.month == newCal.getMonth()))
		day = today.day;
	// Cache the calendar table's tBody section, dayList. 
	var tableCal = document.all.calendar.tBodies.dayList;
	var intDaysInMonth = getDays(newCal.getMonth(), newCal.getYear());
	for (var intWeek = 0; intWeek < tableCal.rows.length; intWeek++)
		for (var intDay = 0; intDay < tableCal.rows[intWeek].cells.length; intDay++)
		{
			var cell = tableCal.rows[intWeek].cells[intDay];
			// Start counting days.
			if ((intDay == startDay) && (0 == daily))
				daily = 1;
			// Highlight the current day.
			cell.className = (day == daily) ? "today" : "";
			// Output the day number into the cell. 
			if ((daily > 0) && (daily <= intDaysInMonth)) 
				cell.innerText = daily++; 
			else 
				cell.innerText = ""; 
		} 
} 

function getDate() 
{ 
	if ("TD" == event.srcElement.tagName) 
	// Test whether day is valid. 
	if ("" != event.srcElement.innerText) { 
		sYear=year.value; 
		sMonth=month.options(month.selectedIndex).text; 
		(sMonth < 10)?(sMonth="0"+sMonth.toString()):(sMonth=sMonth.toString()); 
		sDay=event.srcElement.innerText; 
		(sDay < 10)?(sDay="0"+sDay.toString()):(sDay=sDay.toString()); 

		var click_date = sYear.toString()+sMonth.toString()+sDay.toString(); 
		var targetFormField = eval(targetField);

		targetFormField.value = click_date.substring(0,4)+"-"+click_date.substring(4,6)+"-"+click_date.substring(6);

		document.all['cal'].style.display='none';
	} 
}

function hangul()
{
	if((event.keyCode < 12592) || (event.keyCode > 12687))
		event.returnValue = false
		alert("한글만 입력해주세요");
}
//추가 2007,01,16
function url_go(url){
	location.href=url;
}
function url_go_home(){
	location.href="/index.jsp?popup_sta=no_popup";
}
function go_eng_home(){
	location.href="/eng/index.jsp";
}

function readingZeroToSpace(vOneObject, vTwoObject)
{
   vTwoObject.value = parseInt(vOneObject.value, 10);
}

/*******************************************************************
변수의 공백을 0으로 바꾼다. 바꾸길 원하는 대상은 숫자의 형태여야한다.
숫자,문자 체크안함.
"  101" -> 00101 으로 바뀜
vOneObject는 바뀌기전 객체(form.xx)
vTwoObject는 바뀐후에 값이들어가기를 원하는 객체(form.yy)
********************************************************************/
function readingSpaceToZero(vOneObject, vTwoObject)
{
   vTwoObject.value = vOneObject.value.replace(/ /g, 0);
}

/*
3개의 지역번호,국번,번호를 ex)02-2334-3455 형태로 합침
tel1는 지역번호
tel2는 국번
tel3는 번호
fieldName은 error message를 보낼때의 객체명
*/
function mergyPhoneNo(tel1,tel2,tel3,fieldName)
{
   var telAll = ""                                                                      // 전화번호전체를 받을 변수 선언
   var errorMsg = "정확한" + fieldName + "값을 입력해 주세요";  //fieldName이 있을때의 error Message 변수를 생성
   //세개의 번호를 for문으로 숫자,공백체크하는 function으로 체크후 telAll으로 합침
   for(i=1;i<4;i++)
   {
      var tel = eval("tel"+i);                      //tel1,tel2,tel3를 한꺼번에 체크하기 위해 i와 조합
      tel = getNonSpaceNumber(tel);        //숫자,공백체크한후 tel이라는 변수에 다시 넣어줌

      //공백체크한 값이 있으면 telAll에 3개의 번호를 합쳐줌.
      if(tel)
      {
      //둘째 전화번호, 즉 국 부터 -를 붙이기 위해
         if (i==1)
         {
            telAll = tel
         }
         else
         {
            telAll = telAll + "-" + tel ;
         }
      }
      //공백체크한 값이 없으면 fieldName이 있는경우 message 보여주고 return false 시킴
      else
      {
         if("undefined" == typeof(fieldName))
         {
         }
         else
         {
            alert(errorMsg);
         }
         return false;
      }
   }
   alert (telAll);
}

/*
function checkCalendarFromTo(date1, date2, fieldName1, fieldName2)
- 기간을 체크
date1 :  첫번째 일자값
date2 :  두번째 일자값
fieldName1 : 첫번째 일자값의 이름
fieldName2 : en번째 일자값의 이름
*/
function checkCalendarFromTo(date1, date2, fieldName1, fieldName2)
{
   if (date1== false || date2 == false )
   {
      return false;
   }

   var gap =eval(date2) - eval(date1);  // 받아온 날짜값을 숫자로 바꾼후 계산한다

   // 종료일자에서 시작일자를 뺀값이 0보다 적다면(시작일자가 크다면)
   if(gap < 0 )
   {
      alert(fieldName1+"의 날짜는 " +fieldName2 + "의 날짜보다 이전이거나 동일하여야 합니다");
      return false;
   }

   return true;

}

/*
string을 입력받아 공백제거하고 순수 숫자열만 return
문자일경우 false return
str은 string
*/
function getNonSpaceNumber(str)
{
   var i     = 0;              // looping을 돌기위해 필요한 임시변수
   var returnStr  = "";     // 반환값을 저장시킬 변수
   var len = str.length;   // 파라메터의 문자열 길이를 담아주는 변수
   //string을 한글자씩 비교하는 while문
   while (i<len)
   {
      var sub   = str.substring(i,i+1)    //한글자를 잘라옴
      var code =  sub.charCodeAt(0)  //잘라온 글자의 아스키코드를 담아주는 변수
      //한글자씩 잘라온 것이 공백인지를 검사하는 if문
      if (code==32)
      {
      }
      else
      {
         var returnStr = returnStr +  sub;
         // 전화번호 값이 문자인 경우 return false 시킴
         if (code < 48  || code > 58)
         {
            return false;
         }
      }
      i++;
   }
   return returnStr;
}

/*
02-2334-3455 형태로 합쳐저 있는 값을 3개의 지역번호,국번,번호로 분리
tel1는 지역번호가 있는 textbox객체이름
tel2는 국번번호가 있는 textbox객체이름
tel3는 번호번호가 있는 textbox객체이름
*/
function splitPhoneNo(telAll,tel1,tel2,tel3)
{
   var tel = telAll.split("-");

   for (i=0;i<tel.length;i++)
   {
      //분리된 전화번호를 객체변수로 받음
      var telName = eval("tel"+(i+1));

      //입력받은 전화번호 textbox객체에 값을 세팅
      telName.value = ""
      telName.value =  tel[i];
   }
}



/*
02-2334-3455 형태로 합쳐저 있는 값을 3개의 지역번호,국번,번호로 분리
sido는 시도코드
telAll은 전체전화번호
tel1는 지역번호가 있는 textbox객체이름
tel2는 국번번호가 있는 textbox객체이름
tel3는 번호번호가 있는 textbox객체이름

*/
function phoneNoWithLocal(sido,telAll,tel1,tel2,tel3)
{
   var tel = telAll.split("-");           // 전화번호분리

   //시도코드 존재여부 확인
   if ( tel[0] == "" )
   {
      //시도코드로 지역번호 찾기
      jusoToLocalNo(sido,tel1);
   }
   else
   {
      //체크된 전화번호 textbox 객체에 값을 세팅
      tel1.value =  "";
      tel1.value =  tel[0];
   }

   //체크된 전화번호 객체에 값을 세팅
   tel2.value =  "";
   tel3.value =  "";
   tel2.value =  tel[1];
   tel3.value =  tel[2];
}

//입력된 값이 숫자인지를 체크.
function checkNumber(num , fieldName)
{

   var num_temp = Number(num);
   var errorMesg = fieldName+" 값을 숫자로 입력하십시요";
   var nullMesg = fieldName+" 값을 입력하십시요";

   //값이 있다면
   if(num != "")
   {
      //숫자면 false반환 - if는 문자라면
      if(isNaN(num_temp))
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg);
         }
         return false;
      }
      else  //숫자라면.
      {
         return true;
      }
   }
   else
   {
      if("undefined" == typeof(fieldName)){}
      else
      {
         alert(nullMesg);
      }
      return false;
   }
}

//메세지를 상태창에 뿌리자
function setStatusToStatusBar(vWorkGubun)
{
   if("insert" == vWorkGubun)
   {
      window.status = "입력이 완료되었습니다.";
      setTimeout("setStatusInit()", 3000);
   }
   else if("set" == vWorkGubun)
   {
      window.status = "수정이 완료되었습니다.";
      setTimeout("setStatusInit()", 3000);
   }
   else if("delete" == vWorkGubun)
   {
      window.status = "삭제가 완료되었습니다.";
      setTimeout("setStatusInit()", 3000);
   }
   else if("select" == vWorkGubun)
   {
      window.status = "조회가 완료되었습니다.";
      setTimeout("setStatusInit()", 3000);
   }
   else
   {
      setStatusInit();
   }

}

//메세지를 상태창에서 삭제하자.
function setStatusInit()
{
   window.status = "";

}

/*
이미지 바꾸기..
이벤트가 발생한 객체의 src를 넣어준 img로 세팅해준다.
*/
function swapImage(img)
{
   window.event.srcElement.src = img;
}


/* 입력 필드에 들어온 데이타의 크기를 계산하는 Function */
function checkSize(obj , maxSize, allowNull, fieldName)
{
	var data = obj.value;
   var size = 0;
   var fieldSize = "";
   var errorMesg = fieldName + "의 값이 크기를 초과합니다";
   var errorMesg1 = fieldName + "에 특수문자가 존재합니다";

   if( trim(data) == "" )
   {
      if( allowNull == "N" || allowNull == "n" )
      {
         return true;
      }

      if("undefined" == typeof(fieldName)){}
      else
      {
		 alert(fieldName + "을(를) 반드시 입력 또는 선택하여야 합니다.");
      }
		obj.focus();
		obj.select();

      return false;
   }

   fieldSize = data.length;
   for(i=0; i<fieldSize; i++)
   {
      //특수 문자 체크  ",&,$
      if( data.charCodeAt(i) == 34 || data.charCodeAt(i) == 38 || data.charCodeAt(i) == 36 || data.charCodeAt(i) == 39)
      {
        	if("undefined" == typeof(fieldName)){}
        	else
        	{
            alert(errorMesg1);
        	}
			obj.focus();
			obj.select();
            return false;
      }
      //한글이 들어오면 255보다 크다
      if( data.charCodeAt(i) > 255 )
      {
         size += 2;
      }
      else
      {
         size += 1;
      }
   }

   if( maxSize < size )
   {
     if("undefined" == typeof(fieldName)){}
     else
     {
        alert(errorMesg);
     }
		obj.focus();
		obj.select();
        return false;
   }
   else
   {
      return true;
   }

  return true;
}

/*
체크박스에서 Enter값이 들어오면 체크상태를 반전시켜줌
*/
function checkEnterCheckBox(xx)
{
	var yy =	chkEnter();
	if(yy)
	{
		if(xx.checked)
		{
			xx.checked = false;
		}
		else if(! xx.checked)
		{
			xx.checked = true;
		}
	}
}

/*
Enter를 체크하여 Enter 이면 true 아니면 false를 반환
*/
function chkEnter()
{
	var ok = true;
	var no = false;
  	if(event.keyCode == 13)
  	{
		return ok;
  	}
  	else
  	{
  		return no;
  	}
}

/*
입력창 자동이동 스크립트
*/
function moveNext(varControl, varNext)
{
	if(event.keyCode == 9 || event.keyCode == 16)
	{
		return;
	}
	else
	{
   	if(varControl.value.length == varControl.maxLength)
   	{
      	varNext.focus();
   	}
   }
}

/*
tab키를 눌렀을때 원하는곳에 focus를 가게 한다
*/
function checkTab(xx)
{
  	if(event.keyCode == 0)
  	{
		xx.focus();
  	}
}

/*
textarea 입력 필드에 들어온 데이타의 크기를 계산과 특수문자를 체크하는 Function
*/
function checkTextArea(data , maxSize, allowNull, fieldName)
{
   var size = 0;
   var fieldSize = "";
   var errorMesg = fieldName + "의 값이 크기를 초과합니다";
//   var checkSpecialCharerrorMesg = data + "중에 특수문자가 있습니다!";

   if( trim(data) == "" )
   {
      if( allowNull == "N" || allowNull == "n" )
      {
         return true;
      }

      if("undefined" == typeof(fieldName)){}
      else
      {
		 alert(fieldName + "을(를) 반드시 입력 또는 선택하여야 합니다.");
      }
      return false;
   }

   fieldSize = data.length;


   if( checkSpecialChar(data, allowNull, fieldName ) ) // 특수문자가 없을때는 true를 리턴함.
   {
      fieldSize = data.length;

      for(i=0; i<fieldSize; i++)
      {
         //한글이 들어오면 255보다 크다
         if( data.charCodeAt(i) > 255 )
         {
            size += 2;
         }
         else
         {
            size += 1;
         }
      }

      if( maxSize < size )
      {
         //메세지가 없으면 alert을 뿌려주지 않겠다.
         if("undefined" == typeof(fieldName)){}
         else
         {
           alert(errorMesg);
         }
         return false;
      }
      else
      {
         return true;
      }

   } // if checkSpecialChar(data) == true end
   else
   {
     //메세지가 없으면 alert을 뿌려주지 않겠다.
         if("undefined" == typeof(fieldName)){}
         else
         {
//         alert(checkSpecialCharerrorMesg);
         }
         return false;

   }// if checkSpecialChar(data) == false end

   return true;
}

/*
일 체크 function
*/
function checkDay(vDay, allowNull, fieldName)
{
   if( trim(vDay) == "" )
   {
      if( allowNull == "N" || allowNull == "n" )
      {
         return true;
      }

      if("undefined" == typeof(fieldName)){}
      else
      {
		 alert(fieldName + "을(를) 반드시 입력 또는 선택하여야 합니다.");
      }
      return false;
   }

	if(isNaN(vDay) || vDay > 31 || vDay == 0)
	{
		if("undefined" == typeof(fieldName)){}
		else
		{
			alert(fieldName+" 필드는 1-31값만 허용합니다.");
		}
		return false;
	}

	if(vDay.length == 1)
		return "0"+vDay;

	return vDay;
}

/*
월 체크 function
*/
function checkMonth(vMonth, allowNull, fieldName)
{
   if( trim(vMonth) == "" )
   {
      if( allowNull == "N" || allowNull == "n" )
      {
         return true;
      }

      if("undefined" == typeof(fieldName)){}
      else
      {
		 alert(fieldName + "을(를) 반드시 입력 또는 선택하여야 합니다.");
      }
      return false;
   }

	if(isNaN(vMonth) || vMonth > 12 || vMonth == 0)
	{
		if("undefined" == typeof(fieldName)){}
		else
		{
			alert(fieldName+" 필드는 1-12값만 허용합니다.");
		}
		return false;
	}
	if(vMonth.length == 1)
		return "0"+vMonth;
	return vMonth;
}

/*
년 체크
*/
function checkYear(year, allowNull, fieldName)
{
   var year_temp  = Number(year);
   var errorMesg = fieldName + "값을 숫자로 입력하십시오";
   var isYearMsg = "년도 4 자리를 입력하십시오";

   if( trim(year) == "" )
   {
      if( allowNull == "N" || allowNull == "n" )
      {
         return true;
      }
      if("undefined" == typeof(fieldName)){}
      else
      {
		 alert(fieldName + "을(를) 반드시 입력 또는 선택하여야 합니다.");
      }
      return false;
   }


   if(isNaN(year_temp))
   {
      if("undefined" == typeof(fieldName)){}
      else
      {
         alert(errorMesg);
      }
      return false;
   }
   else if(year.length != 4)
   {
      if("undefined" == typeof(fieldName)){}
      else
      {
         alert(isYearMsg);
      }
      return false;
   }
   else
   {
      return year;
   }
}

/* 년월일을 합해주는 함수
월,일이 두자리가 아닐경우 0을붙혀 두자리로 만듬
*/
function sumCalender(year, month, day)
{
   //월이 두자리가 아닐경우 앞에 "0"을 붙여서 두자리로  만듬"
   if(month.length != 0 &&  month < 10 && month.indexOf(0) == -1 )
   {
      month = "0" + month;
   }

   //일이 두자리가 아닐경우 앞에 "0"을 붙여서 두자리로 만듬"
   if(day.length != 0 &&  day < 10 && day.indexOf(0) == -1 )
   {
      day = "0" + day;
   }

   return year+month+day;
}


/*
날짜 체크하는 Function NOT NULL
구분 : N - null체크 안함
*/
function checkCalendar(year, month, day, allowNull, fieldName)
{
   // 날짜가 8자인지 체크
   var date = "";
   var errorMesg  = fieldName + "의 년도가 틀립니다 예) 2001/01/31";
   var errorMesg1 = fieldName + "의 년도가 틀립니다 예) 2001/01/31";
   var errorMesg2 = fieldName + "의 월이 틀립니다 예) 2001/01/31";
   var errorMesg3 = fieldName + "의 일자가 틀립니다 예) 2001/01/31";
   year  = trim(year) ;
   month = trim(month) ;
   day   = trim(day) ;

   date = year+month+day;

   if (( date.length == 0 ) && ( allowNull == "N" || allowNull == "n" ))
   {
      return true;
   }

   //년도의 4자리수 체크
   if( year.length != 4 )
   {
      if("undefined" == typeof(fieldName)){}
      else
      {
         alert(errorMesg1);
      }
      return false;
   }

   if ( month.length == 0 )
   {
      alert(errorMesg2);
      return false;
   }


   if ( day.length == 0 )
   {
      alert(errorMesg3);
      return false;
   }


   //월이 두자리가 아닐경우 앞에 "0"을 붙여서 두자리로  만듬"
   if(month.length != 0 &&  month < 10 && month.indexOf(0) == -1 )
   {
      month = "0" + month;
   }

   //일이 두자리가 아닐경우 앞에 "0"을 붙여서 두자리로 만듬"
   if(day.length != 0 &&  day < 10 && day.indexOf(0) == -1 )
   {
      day = "0" + day;
   }

   date = year+month+day;

   if( date.length != 8  )
   {

      if("undefined" == typeof(fieldName)){}
      else
      {
		 alert(fieldName + "을(를) 반드시 입력 또는 선택하여야 합니다.");
      }
      return false;
   }


   //날짜가 숫자인지 체크
   if( !checkNumber(date, "일자") )
   {
     return false;
   }

   // 월이 12 보다 큰 수가 있는지 체크
   if(month > 12 || month == 0)
   {
      if("undefined" == typeof(fieldName)){}
      else
      {
         alert(errorMesg2);
      }
      return false;
   }

   // 일 체크
   if(month == 01)
   {
      if(day > 31 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }
   else if(month == 02)
   {
      //윤년 조사
      if(((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0))
      {
         if(day > 29 || day == 0)
         {
            if("undefined" == typeof(fieldName)){}
            else
            {
               alert(errorMesg3);
            }
            return false;
         }
      }
      else
      {
         if(day > 28 || day == 0)
         {
            if("undefined" == typeof(fieldName)){}
            else
            {
               alert(errorMesg3);
            }
            return false
         }
      }
   }
   else if(month == 03)
   {
      if(day > 31 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }
   else if(month == 04)
   {
      if(day > 30 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }

   else if(month == 05)
   {
      if(day > 31 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }

   else if(month == 06)
   {
      if(day > 30 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }

   else if(month == 07)
   {
      if(day > 31 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }

   else if(month == 08)
   {
      if(day > 31 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }

   else if(month == 09)
   {
      if(day > 30 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }

   else if(month == 10)
   {
      if(day > 31 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }

   else if(month == 11)
   {
      if(day > 30 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }

   else if(month == 12)
   {
      if(day > 31 || day == 0)
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
            alert(errorMesg3);
         }
         return false
      }
   }
   return date
}



//숫자가 들어가야할 필드에 숫자가 들어있는지 체크하는 Function2
   function checkNumber(num , fieldName)
   {

      var num_temp = Number(num);
      var errorMesg = fieldName+" 값을 숫자로 입력하십시요";
      var nullMesg = fieldName+" 값을 입력하십시요";

      if(num != "")
      {
         if(isNaN(num_temp))
         {
            alert(errorMesg);
            return false;
         }
         else
         {
            return true;
         }
      }
      else
      {
         alert(nullMesg);
         return false;
      }
   }


/*
자신의 자식윈도우 닫기
*/
function closeWindow(childwin)
{
   for(i=0; i<childwin.length; i++)
   {
      if("undefined" != typeof(childwin[i]))
      {
         childwin[i].close();
      }
   }
}



/*
공백체크
*/
function checkEmpty( arg, fieldName )
{
   var errorMesg = fieldName+"은(는) 반드시 존재하여야 합니다";

   if( trim(arg) == "" )
   {
      if("undefined" == typeof(fieldName)){}
      else
      {
         alert(errorMesg);
      }
      return false;
   }
   return true;   // 공백이 아니라면
}

/*
문자열 앞뒤에있는 공백없에기
*/
function trim( arg )
{
   var st = 0;
   var len = arg.length;

   //문자열앞에 공백문자가 들어 있는 Index 추출
   while( (st < len) && (arg.charCodeAt(st) == 32) )
   {
      st++;
   }
   //문자열뒤에 공백문자가 들어 있는 Index 추출
   while( (st < len) && (arg.charCodeAt(len-1) == 32) )
   {
      len--;
   }
   return ((st > 0) || (len < arg.length)) ? arg.substring(st, len) : arg;
}

/*
특수문자 체크
*/
function checkSpecialChar( arg, allowNull, fieldName )
{
   var fieldSize = arg.length;
   var errorMesg = fieldName + "에 특수문자( 예)\",\' )가 존재합니다";

   if( trim(arg) == "" )
   {
      if( allowNull == "N" || allowNull == "n" )
      {
         return true;
      }

      if("undefined" == typeof(fieldName)){}
      else
      {
		 alert(fieldName + "을(를) 반드시 입력 또는 선택하여야 합니다.");
      }
      return false;
   }

   for(i=0; i<fieldSize; i++)
   {
      if( arg.charCodeAt(i) == 34 || arg.charCodeAt(i) == 39 ) // " ' 문자인지체크
      {
         if("undefined" == typeof(fieldName)){}
         else
         {
           alert(errorMesg);
         }
         return false;
      }
   }

   return true;
}

/*
전화번호에서 지역번호 자동입력
xx는 시도코드
yy는 찍힐 객체
*/
function jusoToLocalNo(xx,yy)
{
	switch(xx)
	{
		case "11" : yy.value = "02";//서울
						break;
		case "41" : yy.value = "031";//경기
						break;
		case "28" : yy.value = "032";//인천
						break;
		case "42" : yy.value = "033";//강원
						break;
		case "44" : yy.value = "041";//충남
						break;
		case "30" : yy.value = "042";//대전
						break;
		case "43" : yy.value = "043";//충북
						break;
		case "26" : yy.value = "051";//부산
						break;
		case "31" : yy.value = "052";//울산
						break;
		case "27" : yy.value = "053";//대구
						break;
		case "47" : yy.value = "054";//경북
						break;
		case "48" : yy.value = "055";//경남
						break;
		case "46" : yy.value = "061";//전남
						break;
		case "29" : yy.value = "062";//광주
						break;
		case "45" : yy.value = "063";//전북
						break;
		case "49" : yy.value = "064";//제주
						break;
	}
}

/*
주민번호 체크하는 Function
*/
function checkJMBeonHo( num1, num2, allowNull)
{
   var number = num1 + num2;
   var errorMesg = "주민등록번호를 입력 하셔야 합니다";
   var errorMesg1 = "주민등록번호의 생년월일 오류입니다";

   if( trim(number) == "" )
   {
      if( allowNull == "N" || allowNull == "n" )
      {
         return true;
      }

      alert("주민번호를 반드시 입력 또는 선택하여야 합니다.");
      return false;
   }


   if( 13 != number.length && 14 != number.length )
   {
      alert(errorMesg);
      return false;
   }
   else
   {
      var Year = num1.substring(0,2);
      if( "3" == num2.substring(0,1) || "4" == num2.substring(0,1) )
      {
         Year = "20" + Year;
      }
      else
      {
         Year = "19" + Year;
      }

      var Month = num1.substring(2,4);
      var Day = num1.substring(4,6);

      if( checkCalendar(Year, Month, Day, "") )
      {
         return true;
      }
      else
      {
         alert(errorMesg1);
         return false;
      }
   }
}


/* Programmed by Song chi-wook
Role : Retacgular box in table 
*/
function defaultStatus()
{
	var lec = document.all.lecture;
	for (var i=0;i<lec.length;i++)
	{
		document.all.lecture[i].style.border = "1 solid #EFEFEF";
		document.all.lecture[i].style.backgroundColor = "";
	}
}

function mouseOnTD(obj)
{
	obj.style.border = "1 solid gray";
	obj.style.backgroundColor = "white";
	obj.style.cursor = "hand";
}



/*
  컴마로 구분된 숫자를 컴마를 제거하고 리턴해준다.
*/
function onlyNumber(str,allowNull,fieldName)
{
   if( trim(str) == "" )
   {
      if( allowNull == "N" || allowNull == "n" )
      {
         return true;
      }

      if("undefined" == typeof(fieldName)){}
      else
      {
		 alert(fieldName + "을(를) 반드시 입력 또는 선택하여야 합니다.");
       return false;
      }
   }

   var src = new String(str);
   var rtn_value = '';

	for (var i=0; i< src.length; i++) 
	{
      var ch = src.charAt(i);
		
      if(i==0)
      {
         if( !(ch>='0' && ch<='9') )
         {
            if(ch!='-')
            {
               alert(fieldName + "의 시작은 숫자 또는 -기호만 허용합니다."+ch);
               return false;
            }
         }
      }
      else
		{
		   if ( !((ch>='0' && ch<='9') || ch!=',' || ch!='.') )
			{ 
            alert(fieldName + "은 숫자 또는 , 또는 .만 허용합니다.");
            return false;
			}
		}
    }

    for (var i=0; i<src.length; i++)
    {
        var ch = src.charAt(i);
        if( (ch >= '0' && '9' >= ch) || ch == '-' || ch == '.')
        {
            rtn_value = rtn_value + ch;
        }
    }

    return rtn_value;
} 

//--날짜 입력시 YYYY-MM-DD 형식으로 바꿔주는 Function--//
function inputDate(F)
{
	if ((event.keyCode==9)||(event.keyCode==16)){}
	else
	{
		if(!(((event.keyCode>=35)&&(event.keyCode<=40))||(event.keyCode==8)))
		{
			em = event.srcElement;
			va = em.value ;
			sp = va.split(F);
			sj = sp.join("");
			switch(sj.length)
			{
				case 4:
					em.value=sj+F;
					break;
				case 6:
					sj=sj.substring(0,4)+F+sj.substring(4,6)+F;
					em.value=sj;
					break;
				case 8: case 9: case 10:
					sj=sj.substring(0,4)+F+sj.substring(4,6)+F+sj.substring(6,8);
					em.value=sj;
					break;
			}
		}
	}
}

//--숫자 입력시 999,999,999 형식으로 바꿔주는 Function--//
function inputMoney(F)
{
	if ((event.keyCode==9)||(event.keyCode==16)){}
	else
	{
		if(!(((event.keyCode>=35)&&(event.keyCode<=40))||(event.keyCode==8)))
		{
			em = event.srcElement;
			va = em.value ;
			sp = va.split(F);
			sj = sp.join("");
			switch(sj.length)
			{
				case 4:
					sj=sj.substring(0,1)+F+sj.substring(1,4);
					em.value=sj;
					break;
				case 5:
					sj=sj.substring(0,2)+F+sj.substring(2,5);
					em.value=sj;
					break;
				case 6:
					sj=sj.substring(0,3)+F+sj.substring(3,6);
					em.value=sj;
					break;
				case 7: 
					sj=sj.substring(0,1)+F+sj.substring(1,4)+F+sj.substring(4,7);
					em.value=sj;
					break;
				case 8: 
					sj=sj.substring(0,2)+F+sj.substring(2,5)+F+sj.substring(5,8);
					em.value=sj;
					break;
				case 9: 
					sj=sj.substring(0,3)+F+sj.substring(3,6)+F+sj.substring(6,9);
					em.value=sj;
					break;
				case 10: 
					sj=sj.substring(0,1)+F+sj.substring(1,4)+F+sj.substring(4,7)+F+sj.substring(7,10);
					em.value=sj;
					break;
				case 11: 
					sj=sj.substring(0,2)+F+sj.substring(2,5)+F+sj.substring(5,8)+F+sj.substring(8,11);
					em.value=sj;
					break;
				case 12: 
					sj=sj.substring(0,3)+F+sj.substring(3,6)+F+sj.substring(6,9)+F+sj.substring(9,12);
					em.value=sj;
					break;
				case 13: 
					sj=sj.substring(0,1)+F+sj.substring(1,4)+F+sj.substring(4,7)+F+sj.substring(7,10)+F+sj.substring(10,13);
					em.value=sj;
					break;
				case 14: 
					sj=sj.substring(0,2)+F+sj.substring(2,5)+F+sj.substring(5,8)+F+sj.substring(8,11)+F+sj.substring(11,14);
					em.value=sj;
					break;
				case 15: 
					sj=sj.substring(0,3)+F+sj.substring(3,6)+F+sj.substring(6,9)+F+sj.substring(8,12)+F+sj.substring(12,15);
					em.value=sj;
					break;
				case 16: 
					sj=sj.substring(0,1)+F+sj.substring(1,4)+F+sj.substring(4,7)+F+sj.substring(7,10)+F+sj.substring(10,13)+F+sj.substring(13,16);
					em.value=sj;
					break;
				case 17: 
					sj=sj.substring(0,2)+F+sj.substring(2,5)+F+sj.substring(5,8)+F+sj.substring(8,11)+F+sj.substring(11,14)+F+sj.substring(14,17);
					em.value=sj;
					break;
				case 18: 
					sj=sj.substring(0,3)+F+sj.substring(3,6)+F+sj.substring(6,9)+F+sj.substring(9,12)+F+sj.substring(12,15)+F+sj.substring(15,18);
					em.value=sj;
					break;
				case 19: 
					sj=sj.substring(0,1)+F+sj.substring(1,4)+F+sj.substring(4,7)+F+sj.substring(7,10)+F+sj.substring(10,13)+F+sj.substring(13,17)+F+sj.substring(17,20);
					em.value=sj;
					break;
			}
		}
	}
}

//--날짜 입력시 YYYY-MM-DD 형식으로 바꿔주는 Function--//
function inputInt(F)
{
	if ((event.keyCode==9)||(event.keyCode==16)){}
	else
	{
		if(!(((event.keyCode>=35)&&(event.keyCode<=40))||(event.keyCode==8)))
		{
			em = event.srcElement;
			va = em.value ;
			sp = va.split(F);
			sj = sp.join("");
			switch(sj.length)
			{
				case 3:
					em.value=sj+F;
					break;
				case 6:
					sj=sj.substring(0,3)+F+sj.substring(3,6)+F;
					em.value=sj;
					break;
				case 9: 
					sj=sj.substring(0,3)+F+sj.substring(3,6)+F+sj.substring(6,9);
					em.value=sj;
					break;
			}
		}
	}
}

//--숫자만 입력되게 하는 Function--//
function inputNum()
{
	em = event.srcElement;
	if(event.keyCode == 109 && em.length == 1)
		return;
	if((event.keyCode <48)||(event.keyCode >57))
		event.returnValue=false;
}

//--유효한 날짜인지 체크하는 Function--//
function goodDate(date)
{
	date=date.replace(".","").replace(".","").replace("/","").replace("/","");
	for(i=0;i<date.length;i++)
	{
		ck=date.charAt(i);
		if (!(ck>="0" && ck<="9"))
		{
			return false;
			break;
		}
	}
	if(date.length!=8)
	{
		return false;
	}
	else
	{
		year = date.substring(0, 4);
		month = date.substring(4, 6);
		day = date.substring(6, 8);
		if(month < 1 || month > 12)
			return false;
		if(day < 1 || day > 31)
			return false;
		if(year < 0 || year > 9999)
			return false;
		if(month == 4 || month == 6 || month == 9 || month == 11)
		{
			if (day == 31)
				return false;
		}
		if(month == 2)
		{
			if (isNaN(parseInt(year/4)))
				return false;
			if (day > 29)
				return false;
			if (day == 29 && ((year/4) != parseInt(year/4)))
				return false;
		}
	}
	return true;
}

//--시작일과 종료일 유효성 체크하는 Function--//
function compDate(fDate, tDate)
{
	fDate=fDate.replace(".","").replace(".","").replace("/","").replace("/","");
	tDate=tDate.replace(".","").replace(".","").replace("/","").replace("/","");
	if (fDate < tDate)
	{
		return true;
	}
	return false;
}





function js_commaErase(obj) {
    var rtn_value = '';
    for (var i=0; i< obj.value.length; i++) {
        var ch = obj.value.charAt(i);
        if( ch != ',') {
            rtn_value = rtn_value + ch;
        }
    }
    obj.value = rtn_value;
    obj.select();
    return;
} 

function js_commaErase2(num) {
    var rtn_value = '';
    for (var i=0; i< num.length; i++) {
        var ch = num.charAt(i);
        if( ch != ',') {
            rtn_value = rtn_value + ch;
        }
    }
    return rtn_value;
} 

function js_removeSpace(str) {
	var src = new String(str);
	var tar = new String();
	var i, len=src.length;
	for (i=0; i < len; i++) {
		if (src.charAt(i) == ' ')
            tar += '';
        else
            tar += src.charAt(i);
    }
    return tar;
}

function js_Space_chk(obj) {
	var src =obj.value;
	var i, len=obj.value.length;
	for (i=0; i < len; i++) {
		if (src.charAt(i) == ' ') {
	        alert('공백은 허용 하지 않습니다.');
		    obj.focus();
		    obj.select();
			break;
		}
    }
    return ;
}


function js_checkDigits(obj) {
    var err_status = '';
    var src = new String(obj.value);
    var tar = new String();
    var ch2 = new String();
    var ch3 = 0;
    tar = js_removeSpace(src);
    if (tar == '') return;
    if (js_validateCheck(obj) == 'false') {
        alert('금액은 15자리 이하로 입력하세요.');
        obj.focus();
    }
    for (var i=0; i< tar.length; i++) {
        var ch = tar.charAt(i);
        if (ch >= '0' && ch <='9') ch2 += tar.charAt(i);
        if ((ch < '0' || '9' < ch) && ch != ',' && ch != '-' && ch != '.')         err_status = '1';
        if ((i != 0 && ch == '-') || (tar.length == 1 && ch == '-'))  err_status = '1';
    }
    ch3 = parseInt(ch2);
    if(ch3 == 0) tar = '0';
    if( err_status != '1')
        obj.value = js_makeComma(js_convert(tar));
    else {
        alert('숫자(- 부호 포함)만 입력이 가능합니다.');
        obj.focus();
    }
    return;
}       

function js_convert(str) {
    var src = new String(str);
    var rtn_value = '';
    for (var i=0; i<src.length; i++) {
        var ch = src.charAt(i);
        if( (ch >= '0' && '9' >= ch) || ch == '-' || ch == '.') {
            rtn_value = rtn_value + ch;
        }
    }
    if( rtn_value.length = 0) {
        rtn_value = 0;
    }
    return rtn_value;
} 

function js_validateCheck(obj) {
    var src = new String(obj.value);
    var split1 = '';     // Sign '-' 부호 저장
    var split2 = '';     // 정수부분 저장
    var split3 = '';     // 소숫점 이하자리 저장
    if (src.charAt(0) == '-') {
        split1 = '-';
        src = src.substr(1);
    }
    if (src.indexOf('.') >= 0) {
        split2 = src.substring(0,src.indexOf('.'));
        split3 = src.substr(src.indexOf('.'));
    }
    else{
        split2 = src;
        split3 = '';    
    }
    if(split2.length > 15) return 'false';
    else return 'true';
}

function js_makeComma(str) {
    var src = new String(str);
    var len;
    var i = 0;
    var pos = 0;
    var split1 = '';     // Sign '-' 부호 저장
    var split2 = '';     // 정수부분 저장
    var split3 = '';     // 소숫점 이하자리 저장
    var rtn_value = '';
    if (src.charAt(0) == '-') {
        split1 = '-';
        src = src.substr(1);
    }
    if (src.indexOf('.') >= 0) {
        split2 = src.substring(0,src.indexOf('.'));
        split3 = src.substr(src.indexOf('.'));
    }
    else{
        split2 = src;
        split3 = '';    
    }
    len = split2.length;
    //  Comma ',' 추가 루틴
    for(var i = 0; i < len; i++) {
        pos  = len - i;
        rtn_value = rtn_value + split2.charAt(i);
        if(pos != 1 && pos % 3 == 1) {
            rtn_value = rtn_value + ',';
        }
    }
    return split1+rtn_value+split3;
}

function js_yearCheck(obj) {
    var arg = obj.value;
    if (arg.length != 2) {
        alert('년도는 YY의 형태로 입력하세요.');
        obj.focus();
        obj.select();
    }
    if(js_numberCheck(arg)) {
        alert('문자가 포함될수 없습니다.');
        obj.focus();
        obj.select();
    }
    return;
}

function js_numberCheck(str) {
    var src = new String(str);
    var tar = true;
    var i, len=src.length;
    for (i=0; i < len; i++) {
        if ((src.charAt(i) < '0') | (src.charAt(i) > '9'))
            return false;
    }
    return true;
}

function js_numberCheck3(obj) {
    var str = obj.value;
    var src = new String(str);
    var tar = true;
    var i, len=src.length;
    for (i=0; i < len; i++) {
        if((src.charAt(i) != '-') & (src.charAt(i) != ' ')){
            if ((src.charAt(i) < '0') | (src.charAt(i) > '9')){
                tar = false;
            }    
        }
    }
    if(tar == false){
        alert('문자가 포함될수 없습니다....');
        obj.focus();
        obj.select();
    } 
}

function js_tab_order(arg,nextname,len) {
    if (arg.value.length == len) {
        nextname.focus() ;
        return ;
    } 
}

function js_isFieldBlank(obj) { 
    var str = obj.value;
	return (str == '' || str.charAt(0) == ' ') ? true : false;
}

function js_isBlank(str) { 
	return (str == '' || str.charAt(0) == ' ') ? true : false;
}

function js_removeChar(str, chr) {
    var src = new String(str);
    var tar = new String();
    var i, len=src.length;
    for (i=0; i < len; i++) {
        if (src.charAt(i) == chr)
            tar += '';
        else
            tar += src.charAt(i);
    }
    return tar;
}

function js_removeChar2(obj) {
    var src = new String(obj.value);
    var tar = new String();
    var i, len=src.length;
    for (i=0; i < len; i++) {
        if (src.charAt(i) == '/')
            tar += '';
        else
            tar += src.charAt(i);
    }
    obj.value = tar;
}

function js_dateEditMask(str, chr, flag) {
    var src = new String(str);
    var tar = new String();
    var yea = src.substring(0, 4); // year
    var mon = src.substring(4, 6); // month
    if(flag == '2') return tar = yea + chr + mon;
    else {
        var da  = src.substring(6, 8); // day
        return tar = yea + chr + mon + chr + da;
    }
}

function js_dateCheck(obj) {
    var err  = 0;
    var chartest = obj.value;
    ival  = obj.value;
    if (ival == '') return;
    chartest = js_removeChar(chartest,'/');
    if(chartest.length != 8) {
        alert('YYYYMMDD의 형식으로 입력하십시요.');
        obj.focus();
        return;
    }
    cen = chartest.substring(0, 2); // century
    if (cen > 19) {
        yea = chartest.substring(0, 4); // year
    } else {
        yea = chartest.substring(2, 4); // year
    }
    mon = chartest.substring(4, 6); // month
    da  = chartest.substring(6, 8); // day
    //들어온 값 검색 - 문자인지..
    if(!js_numberCheck(chartest)) {
        alert('문자가 입력될수 없습니다.');
        obj.focus();
        return;
    }
    //기본적인 일, 월, 년 에러 검색
    if(mon < 1 || mon > 12) err = 1;
    if(da  < 1 || da  > 31) err = 1;
    if (cen < 20) {
        if(yea < 0 || yea > 99) err = 1;
    }
    if(cen < 19) err = 1;
    if(err == 1) {
        alert('날짜 형식에 맞지 않습니다.');
        obj.focus();
        return;
    }
    d = new Date(yea, mon - 1, da);
    if(yea != d.getYear() || mon != (d.getMonth() + 1)) {
        alert('날짜 형식에 맞지 않습니다.');
        obj.focus();
        return;
    }
    else{
         if (cen > 19) {
             obj.value = yea + '/' + mon + '/' + da;
         } else {
             obj.value = cen + yea + '/' + mon + '/' + da;
         }
    }
}

function js_FieldCompare(FromField, ToField) { 
    str1 = FromField.value;
    str2 = ToField.value;
    return str1 > str2 ? false : true;
}

function js_Compare(FromDate, ToDate) { 
    return FromDate > ToDate ? false : true;
}

function js_checkTime(obj) {
    var err_status = '';
    var src = new String(obj.value);
    var tar = new String();
    var ch2 = new String();
    var ch3 = 0;
    tar = js_removeSpace(src);
    if (tar == '') return;
    for (var i=0; i< tar.length; i++) {
        var ch = tar.charAt(i);
        if (ch >= '0' && ch <='9') ch2 += tar.charAt(i);
        if ((ch < '0' || '9' < ch) && ch != ':') err_status = '1';
        if ((i != 2 && ch == ':') || (tar.length == 1 && ch == ':')) err_status = '1';
    }
    if(ch2.length != 4) err_status = '2';
    ch3 = parseInt(ch2);
    if ((ch3 < 0) || (ch3 > 2359)) err_status = '2';
    if( err_status == '1') {
        alert('숫자( : 포함)만 입력이 가능합니다.');
        obj.focus();
    } else if(err_status == '2') {
        alert('시간형식에 맞지 않습니다.');
        obj.focus();
    } else {
        obj.value = js_makeColon(ch2);
    }
    return;
}

function js_makeColon(str) {
    var src = new String(str);
    var split1 = '';     // 시간 저장
    var split2 = '';     // 분 저장
    split1 = src.substring(0,2);
    split2 = src.substring(2);
    return split1+':'+split2;
}

function js_colonErase(obj) {
    var tar = js_removeChar(obj.value,':');
    obj.value = tar;
    return;
}

function js_removeQuot(obj) {
	if ( ( obj.value.indexOf("'") != -1 ) || ( obj.value.indexOf("\"") != -1 ) ) {
		alert('작은 따옴표와 큰 따옴표는 입력을 허용하지 않습니다.');

		while ( obj.value.indexOf("'") != -1) {
			obj.value = obj.value.replace("'", " ");
		}

		while ( obj.value.indexOf("\"") != -1) {
			obj.value = obj.value.replace("\"", " ");
		}

		obj.focus();
		obj.select();
	}
	return ;
}

function title_js_removeQuot(obj) {
	if ( ( obj.value.indexOf("'") != -1 ) || ( obj.value.indexOf("\"") != -1 ) ) {
		alert('제안 제목에는 작은 따옴표와 큰 따옴표의 입력을 허용하지 않습니다.');

		while ( obj.value.indexOf("'") != -1) {
			obj.value = obj.value.replace("'", " ");
		}

		while ( obj.value.indexOf("\"") != -1) {
			obj.value = obj.value.replace("\"", " ");
		}

		obj.focus();
		obj.select();
	}
	return ;
}


function js_checkQuot(obj) {
	if ( ( obj.value.indexOf("'") != -1 ) || ( obj.value.indexOf("\"") != -1 ) ) {
		alert('작은 따옴표와 큰 따옴표는 입력을 허용하지 않습니다.');

		obj.focus();
		obj.select();
	}
	return ;
}

function js_numberCheck2(obj) {
    var arg = obj.value;
    
    if(js_numberCheck(arg) == false) {
        alert('문자가 포함될수 없습니다.');
        obj.focus();
        obj.select();
    }
    return;
}

function js_showMessageWindow(msgNo, comment, url) {
	reURL = self.showModalDialog("/SislErrorMsg.jsp?msgNo=" + msgNo + "&comment=" + comment, url,
								 "title:no;status:no;center:yes;help:no;minimize:no;maximize:no;border:thin;statusbar:no;dialogWidth:200px;dialogHeight:125px");

	if (reURL == "reload") {
		location.reload();
	}
	else if (reURL != "") location.href = reURL;
	return ;
}

/////////////////textarea length값 체크/////////////////////////////////
function IsEmptyRtnMsg(obj,msg,len) {
	var toCheck = obj.value;
	var chkstr = toCheck + "";
	var is_Space = true;

	if (len != null) {
		if (StrLeng(obj.value) > len)   {
    		alert(msg + " 한글 " + len/2 + ",영문 "+len+"자 이내로 입력하십시오.");
        	obj.focus();
        	obj.select();
        	return true;
    	} else {
    	return false;
    	}
	}else return false;

}

// 한글 입력길이와 체크
function StrLeng(str)	{
    var i;
    var strLen;
    var strByte;
    strLen = str.length;
    var IEYES = 0;
    var menufacture = navigator.appName;
    var version = navigator.appVersion;
    if( ( menufacture.indexOf('마이크로소프트') >= 0 || menufacture.indexOf('Microsoft') >= 0 )
   && (version.indexOf('4.0') >= 0 || version.indexOf('5.0') >= 0
       || version.indexOf('6.0') >= 0 || version.indexOf('7.0') >= 0
       || version.indexOf('8.0') >= 0 || version.indexOf('9.0') >= 0 ) )
    {
       IEYES = 1;
    }
    // IE4.0 이상
    if(IEYES == 1)
    {
        for(i=0, strByte=0;i<strLen;i++)
        {
            if(str.charAt(i) >= ' ' && str.charAt(i) <= '~' )
                strByte++;
            else
                strByte += 2;
        }
        return strByte;
    }
    // Netscape일 경우
    else
    {
        return strLen;
    }

}

function defaultStatus_2(){
	var lec = document.all.lecture;
	for (var i=0;i<lec.length;i++){
		document.all.lecture[i].style.border = "1 solid #EFEFEF";
		document.all.lecture[i].style.backgroundColor = "";
	}
}

function mouseOnTD_2(obj)
{
	obj.style.border = "1 solid #6188CA";
	obj.style.backgroundColor = "white";
	obj.style.cursor = "hand";
}

function mouseOnTD_post(obj)
{
	obj.style.border = "1 solid gray";
	obj.style.backgroundColor = "white";
	obj.style.cursor = "hand";
}
function defaultStatus_post(obj){
	obj.style.border = "1 solid white";
	obj.style.backgroundColor = "";
}

function radio_1(){
	document.all.lec_1.style.display='';
}
function radio_1_no(){
	document.all.lec_1.style.display='none';
}
function radio_2(){
	document.all.lec_2.style.display='';
}
function radio_2_no(){
	document.all.lec_2.style.display='none';
}
function radio_3(){
	document.all.lec_3.style.display='';
}
function radio_3_no(){
	document.all.lec_3.style.display='none';
}
function radio_4(){
	document.all.lec_4.style.display='';
}
function radio_4_no(){
	document.all.lec_4.style.display='none';
}
function radio_5(){
	document.all.lec_5.style.display='';
}
function radio_5_no(){
	document.all.lec_5.style.display='none';
}
function find_img_over(){ 
	document.all.find_lec.style.display='';
}	
function find_img_over_no(){
	document.all.find_lec.style.display='none';
}

Xoffset=-150;
Yoffset=15;
var navok,navno,ie=(document.all),posY=-800;
if(navigator.appName=='Netscape'){
  (document.layers)?navok=true:navno=true;
}

function get_mouse(e){
  var x=(navok)?e.pageX:event.x+document.body.scrollLeft;
  ply.left=x+Xoffset;
  var y=(navok)?e.pageY:event.y+document.body.scrollTop;
  ply.top=y+posY;
}

function hideit(){
  if(!navno){
    posY=-800;
    ply.visibility='hidden';
  }
} 
function na_open_window(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
{
  toolbar_str = toolbar ? 'yes' : 'no';
  menubar_str = menubar ? 'yes' : 'no';
  statusbar_str = statusbar ? 'yes' : 'no';
  scrollbar_str = scrollbar ? 'yes' : 'no';
  resizable_str = resizable ? 'yes' : 'no';
  window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
}

function file_check_2(f_name){
	var msg = "";
	var gy = true;
	if(f_name != ""){
		for (var i=0; i<f_name.length; i++) 
		{
			var ch = f_name.charAt(i);
			if(ch=='.') {
				var chk_f_name = f_name.substring(i);
				chk_f_name = chk_f_name.toLowerCase();
				if((chk_f_name =='.jsp') || (chk_f_name =='.html') || (chk_f_name =='.js') || (chk_f_name =='.sql') || (chk_f_name =='.class') || (chk_f_name =='.java') || (chk_f_name =='.exe') || (chk_f_name =='.php') || (chk_f_name =='.php3')  || (chk_f_name =='.inc') || (chk_f_name =='.pl') || (chk_f_name =='.asp')){
					msg = f_name.substring(i)+" 의 확장자를 가진 화일은 파일첨부 하지 못합니다.";
					gy = false;
				} else {
					gy = true;
				}
				break;
			}
		}
		if(gy){
			if(js_checkQuot_2(f_name)){
				gy = true;
			} else {
				msg = "특수문자를 가진 화일은 파일첨부 하지 못합니다. (예: ', \" ,\/)";
				gy = false;
			}
		}	

		if(gy){
			if(chk_teng(f_name)){
				gy = true;
			} else {
				msg = "화일명에 '..'의 문자가 포함된 화일은 첨부 하지 못합니다.";			
				gy = false;
			}	
		}

		if(gy){
			if(chk_comma(f_name)){
				gy = true;
			} else {
				msg = "화일명에 '.'의 문자가 하나 이상 포함된 화일은 첨부 하지 못합니다.";			
				gy = false;
			}	
		}

		if(gy){
			return true;
		} else {
			alert(msg);
			return false;
		}

	} else {
		return true;
	}
}

function chk_teng(f_name){
	for (var i=0; i<f_name.length; i++) 
	{
	  var ch = f_name.charAt(i);
		 if(ch=='.') 
		 {
			var chk_f_name = f_name.substring(i,i+2);
			if(chk_f_name =='..'){
				break;
				return false;
			} else {
				return true;
			}
		 }
	}
}
function chk_comma(f_name){
	var ii=0;
	for (var i=0; i<f_name.length; i++) 
	{
		var ch = f_name.charAt(i);
		if(ch=='.') ii++;
	}
	if(ii==1){
		return true;
	} else {
		return false;
	}
}

function js_checkQuot_2(objval) {
	if ( (objval.indexOf("'") != -1 ) || (objval.indexOf("\"") != -1 ) ||  (objval.indexOf("\/") != -1 ) ) {
		return false;
	} else {
		return  true;
	}
}

function view_xipisooning_cosjn12_3_2001_gnngi23_url_internetgo_menu_ingurl_fg_nationalnanofab_infomation_tag_homepage_viewinfo(url_info){
	url_info = url_info.substring(30);
	location.href =url_info;
}
function nnfc_65525_url_homepage_cascate_cosjn12_3_2005_gnngi_url_substring_menu_ingurl_fg_5001_nationalnanofab_infomation_tag_homepage_viewinfo(url_info){
	url_info = url_info.substring(30);
	location.href =url_info;
}
function go_url_cascate_cosjn12_72_2005_gnngi_url_windows_substring_menu_ingurl_fg_78001_nationalnanofab_infomation_tag_page_viewinfo(url_info){
	url_info = url_info.substring(30);
	location.href =url_info;
}
function riix_url_cascate_cosjn12_nngi_url_windows_substring_menu_ingurl_fg_2005_nationalnanofab_xxy232_n_tag_page_freeview(url_info){
	url_info = url_info.substring(30);
	location.href =url_info;
}
function coromlls_url_cascate_cosjn12_adf_lkjijkk_gnngi_url_x_ywindows_substring_menu_ingurl_fg_001_nationalnanofab_infomation_tag_page_(url_info){
	url_info = url_info.substring(30);
	location.href =url_info;
}
function maxliknk_url_cascate_cosjn12_gnngi_url_windows_cosnsiln_xxx_y_substring_menu_ingurl_fg_78001_nationalnanofab_infomation_tag_page_viewinfo(url_info){
	url_info = url_info.substring(30);
	location.href =url_info;
}
function file_check_img(f_name){
	if(f_name != ""){
		for (var i=0; i<f_name.length; i++) 
		{
		  var ch = f_name.charAt(i);
			 if(ch=='.') 
			 {
				var chk_f_name = f_name.substring(i);
				if((chk_f_name !='.JPG') & (chk_f_name !='.JPEG') & (chk_f_name !='.jpg') & (chk_f_name !='.jpeg') & (chk_f_name !='.gif') & (chk_f_name !='.GIF') ){
					alert("'jpg' 또는 'gif' 의 파일만 등록합니다.");
					return false;
				} else {
					return true;
				}
				break;
			 }
		}
	} else {
		return true;
	}
}
function chk_jumin(){ 
  var str_jumin1 = document.member.jumin1.value; 
  var str_jumin2 = document.member.jumin2.value; 
   var digit=0 
  for (var i=0;i<str_jumin1.length;i++){ 
   var str_dig=str_jumin1.substring(i,i+1); 
   if (str_dig<'0' || str_dig>'9'){ 
    digit=digit+1 
  } 
         if ((str_jumin1 == '') || ( digit != 0 )){ 
   alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.'); 
   document.member.jumin1.focus(); 
   return false;    
         } 
  var digit1=0 
  for (var i=0;i<str_jumin2.length;i++){ 
   var str_dig1=str_jumin2.substring(i,i+1); 
   if (str_dig1<'0' || str_dig1>'9'){ 
    digit1=digit1+1 
   } 
  } 
         if ((str_jumin2 == '') || ( digit1 != 0 )){ 
   alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.'); 
   document.member.jumin2.focus(); 
   return false;    
         } 
         if (str_jumin1.substring(2,3) > 1){ 
   alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.'); 
   document.member.jumin1.focus(); 
   return ;    
         } 
         if (str_jumin1.substring(4,5) > 3){ 
   alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.'); 
   document.member.jumin1.focus(); 
   return false;    
         } 
         if (str_jumin2.substring(0,1) > 4 || str_jumin2.substring(0,1) == 0){ 
   alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.'); 
   document.member.jumin2.focus(); 
   return false;    
         } 
         var a1=str_jumin1.substring(0,1) 
         var a2=str_jumin1.substring(1,2) 
         var a3=str_jumin1.substring(2,3) 
         var a4=str_jumin1.substring(3,4) 
         var a5=str_jumin1.substring(4,5) 
         var a6=str_jumin1.substring(5,6) 
         var check_digit=a1*2+a2*3+a3*4+a4*5+a5*6+a6*7 
         var b1=str_jumin2.substring(0,1) 
         var b2=str_jumin2.substring(1,2) 
         var b3=str_jumin2.substring(2,3) 
         var b4=str_jumin2.substring(3,4) 
         var b5=str_jumin2.substring(4,5) 
         var b6=str_jumin2.substring(5,6) 
         var b7=str_jumin2.substring(6,7) 
         var check_digit=check_digit+b1*8+b2*9+b3*2+b4*3+b5*4+b6*5 
         check_digit = check_digit%11 
         check_digit = 11 - check_digit 
         check_digit = check_digit%10 
         if (check_digit != b7){ 
   alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.'); 
   document.member.jumin2.focus(); 
   return false;    
         } 
         else{
			return true;
		 }
 } 
} 


function chucknull_obj(f_name,log){
	if(eval(f_name+".value")==""){
		alert(log);
		eval(f_name+".focus()");
		return false;
	} else {
		return true;
	}
}

function js_commaErase_cal(val) {
    var rtn_value = '';
    for (var i=0; i< val.length; i++) {
        var ch = val.charAt(i);
        if( ch != ',') {
            rtn_value = rtn_value + ch;
        }
    }
    return  rtn_value;
} 

//메일 형식체크(맞으면 true 틀리면 false)
function isMailType(name,message){
	var standard="0123456789abcdefghijklmnopqrstuvwxyz_-.@";
	if(name.value.indexOf("@")==-1||name.value.indexOf(".")==-1){
		alert(message);
		name.focus();
		return false;
	}else{
		for (i=0;i<name.value.length;i++ ){
			if(standard.indexOf(name.value.charAt(i))==-1){
				alert(message);
				name.focus();
				return false;
				break;
			}
		}
	}
	return true;
}

//공란제거
function trim(strValue){
	var rValue="";
	for(i=0;i<strValue.length;i++){
		if(strValue.charAt(i)==" "){
			rValue=rValue+"";
		}else{
			rValue=rValue+strValue.charAt(i);
		}
	}
	return rValue;
}
//널체크(널이면 true, 널이아니면 false)
function isNull(name,message){
	if(!trim(name.value)){
		alert(message);
		name.value="";
		name.focus();
		return true;
	}
}

/*에디터셋팅*/
_editor_url = "/A_edit/";                     
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);

if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
	document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
	document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { 
	document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); 
}

function setEditor(fieldName){
	var config = new Object();    // create new config object
	config.width = "100%";
	config.height = "200px";
	config.bodyStyle = 'background-color: white; font-family: ; font-size: x-small;';
	config.debug = 0;


	config.toolbar = [
		['fontname'],
		['fontsize'],    
		['linebreak'],
		['bold','italic','underline','separator'],
		['justifyleft','justifycenter','justifyright','separator'],
		['OrderedList','UnOrderedList','Outdent','Indent','separator'],
		['forecolor','backcolor','separator'],
		['HorizontalRule','Createlink','separator'],
	];

	config.fontnames = {
		"굴림":       "굴림",
		"바탕":       "바탕",
		"돋음":       "돋음",
		"궁서":       "궁서",
		"Arial":           "arial, helvetica, sans-serif",
		"Courier New":     "courier new, courier, mono",
		"Georgia":         "Georgia, Times New Roman, Times, Serif",
		"Tahoma":          "Tahoma, Arial, Helvetica, sans-serif",
		"Times New Roman": "times new roman, times, serif",
		"Verdana":         "Verdana, Arial, Helvetica, sans-serif",
		"impact":          "impact",
		"WingDings":       "WingDings"
		
	};
	config.fontsizes = {
		"1 (8 pt)":  "1",
		"2 (10 pt)": "2",
		"3 (12 pt)": "3",
		"4 (14 pt)": "4",
		"5 (18 pt)": "5",
		"6 (24 pt)": "6",
		"7 (36 pt)": "7"
	  };
	editor_generate(fieldName,config);
}

function reSizeImg(obj,size){
	var imgWidth=obj.width;
	var imgHeight=obj.height;
	var imgRate=1;
	if(imgWidth>=imgHeight){		
		if(size<imgWidth) imgRate=imgWidth/size;				
	}else{		
		if(size<imgHeight) imgRate=imgHeight/size;			
	}
	
	obj.width=imgWidth/imgRate;
	obj.height=imgHeight/imgRate;
}
//-->