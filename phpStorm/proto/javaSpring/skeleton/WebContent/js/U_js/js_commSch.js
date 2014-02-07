/***************************************************************************************
 * 파일명	: js_commSch.js
 * 설명		: 공통_검색
 * 작성자	: 임지현
 * 작성일	: 2011.02.09
 * 수정일	:
 ****************************************************************************************/

var ContextPath = "";

/* 사업구분  */

function dvsnChg1(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=4";
	var name = "hrnk_buss_dvsn";
	var opt  = "select";		
	sendRequest( url, name, opt );
}

function dvsnChg2(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=4";
	var name = "hrnk_buss_dvsn1";
	var opt  = "select";			
	sendRequest( url, name, opt );
}

function dvsnChg3(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=4";
	var name = "hrnk_buss_dvsn2";
	var opt  = "select";		
	sendRequest( url, name, opt );
}

/* 하위 부서 검색  */
function orgChg(val){	
	var url	 = ContextPath + "/mngr/common/comm_selorgXml00_s.do?org_cd="+val;
	var name = "org";
	var opt  = "select";		
	sendRequest( url, name, opt );
}