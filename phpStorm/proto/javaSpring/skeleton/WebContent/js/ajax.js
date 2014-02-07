var xmlDOC		= null;
var aJaxUrl		= null;
var aJaxName	= null;
var targetProc	= null;
var resultXml 	= null;
var aJaxOpt		= null;
var aJaxDat 	= null;
var tmp			= "ie";

var aValue 		= null;
var aName 		= null;


function getXmlDom() {
	var xmlDomProgIDs = [
							"Microsoft.XMLDOM",
							"Microsoft.XMLHTTP"];
							
	for(var i = 0; i < xmlDomProgIDs.length; i++) {
		try {
			xmlDOC = new ActiveXObject(xmlDomProgIDs[i]);
			return xmlDOC;
		}
		catch(e) {
		}
	}
	throw alert("MSXML 이 설치되어 있지 않습니다!");
}

function getXmlHTTP() {
	if(window.ActiveXObject){
		try{
			xmlDOC = new ActiveXObject("Microsoft.XMLDOM");
			return xmlDOC;
		}catch(e1){
			try{
				xmlDOC = new ActiveXObject("Microsoft.XMLHTTP");
				return xmlDOC;
			}catch(e2){}
		}
	}
	else if(window.XMLHttpRequest){
		xmlDOC	= new XMLHttpRequest();
		tmp = "ff";
		return xmlDOC;
	}
}

function sendRequest(url, name, opt){
	aJaxUrl 	= url;
	aJaxName 	= name;
	aJaxOpt		= opt;	

	//xmlDOC = getXmlDom();
	xmlDOC = getXmlHTTP();
	if(xmlDOC != null){
		if(window.ActiveXObject){
			xmlDOC.async = true; 
			xmlDOC.load(aJaxUrl);
			xmlDOC.onreadystatechange = sendResponse;
		}
		else
		{
			//alert(aJaxUrl);
			if(aJaxUrl.indexOf("?") > 0)
			{
				aJaxDat = aJaxUrl.substring(aJaxUrl.indexOf("?"),aJaxUrl.length);
			}
			xmlDOC.open("GET",aJaxUrl,true);
			xmlDOC.onload = sendResponse;
			xmlDOC.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlDOC.send(aJaxDat);
		}
	}
	else
	{
		alert("xml이 설치되지 않았습니다.");
	}

	/*
	xmlDOC = getXmlHTTP();	
	
	xmlDOC.open("GET",aJaxUrl,false);
	xmlDOC.onreadystatechange = sendResponse;
	xmlDOC.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=euc-kr");
	alert(xmlDOC.responseXML);
	xmlDOC.send('');	
*/
	//alert(aJaxUrl);
}

function sendResponse () {
	if(xmlDOC.readyState == 4) {
		//resultXml = xmlDOC.responseXML;
		if(tmp == "ff")
		{
			var xmlParser = new DOMParser();
			xmlDOC = xmlParser.parseFromString(xmlDOC.responseText, 'text/xml');
		}

		if(aJaxOpt == "select") {
			returnSelect();
		}else if(aJaxOpt == "load"){
			returnLoad();
		}else if(aJaxOpt == "text"){
			returnText();
		}
	}
} 

 /* SelectBox return */
function returnSelect(){
	var boxName = document.getElementById(aJaxName);
	var objItem = xmlDOC.documentElement;
	objItem = objItem.getElementsByTagName("data");

	boxName.length = 1;
	
	/* 제품 카테고리 */
	if(aJaxName=="prdc_cd"){
		boxName.length = 1;
	}
	
	/* 산업기술분류 */
	if(aJaxName=="tech_cd2"){						/* 대분류선택시 */
		boxName.length = 1;
		document.getElementById("tech_cd3").length = 1;
	}else if(aJaxName=="tech_cd3"){				/* 중분류선택시 */
		boxName.length = 1;
	}
	
	/* 사업체구분 */
	if(aJaxName=="entp_dvsn2"){						/* 대분류선택시 */
		boxName.length = 1;
		document.getElementById("entp_dvsn").length = 1;
	}else if(aJaxName=="entp_dvsn"){				/* 중분류선택시 */
		boxName.length = 1;
	}
	
	/* 표준산업분류 */
	if(aJaxName=="ndst_clsf2"){						/* 1단계선택시 */
		boxName.length = 1;
		document.getElementById("ndst_clsf2").length = 1;
		document.getElementById("ndst_clsf3").length = 1;
		document.getElementById("ndst_clsf").length = 1;
	}else if(aJaxName=="ndst_clsf3"){				/* 2단계선택시 */
		boxName.length = 1;
		document.getElementById("ndst_clsf3").length = 1;
		document.getElementById("ndst_clsf").length = 1;
	}else if(aJaxName=="ndst_clsf"){				/* 3단계선택시 */
		boxName.length = 1;
	}	
	
	/* 보유기관 선택시 장비 리스트 */
	if(aJaxName=="eqmt_no"){			
		boxName.length = 1;
	}
	
	/*상위 사업 구분*/
	if(aJaxName=="hrnk_buss_dvsn1")
	{
		document.getElementById("hrnk_buss_dvsn").length = 1;
	}
	else if(aJaxName=="hrnk_buss_dvsn2")
	{
		document.getElementById("hrnk_buss_dvsn1").length = 1;
		document.getElementById("hrnk_buss_dvsn").length = 1;
	}
	else if(aJaxName=="hrnk_buss_dvsn3")
	{
		document.getElementById("hrnk_buss_dvsn2").length = 1;
		document.getElementById("hrnk_buss_dvsn1").length = 1;
		document.getElementById("hrnk_buss_dvsn").length = 1;
	}
	
	/*사업 구분*/
	if(aJaxName=="buss_dvsn1")
	{
		document.getElementById("buss_dvsn").length = 1;
	}
	else if(aJaxName=="buss_dvsn2")
	{
		document.getElementById("buss_dvsn1").length = 1;
		document.getElementById("buss_dvsn").length = 1;
	}
	else if(aJaxName=="buss_dvsn3")
	{
		document.getElementById("buss_dvsn2").length = 1;
		document.getElementById("buss_dvsn1").length = 1;
		document.getElementById("buss_dvsn").length = 1;
	}
	
	/* 부서  리스트 */
	if(aJaxName=="org"){			
		boxName.length = 1;
	}
	
	/*현황검색 > 기업검색 -시작*/
	/*표준산업분류*/
	if(aJaxName=="clsf_cd4")
	{
		document.getElementById("clsf_cd4").length = 1;
	}
	else if(aJaxName=="clsf_cd3")
	{
		document.getElementById("clsf_cd4").length = 1;
		document.getElementById("clsf_cd3").length = 1;
	}
	else if(aJaxName=="clsf_cd2")
	{
		document.getElementById("clsf_cd4").length = 1;
		document.getElementById("clsf_cd3").length = 1;
		document.getElementById("clsf_cd2").length = 1;
	}
	
	/*기업구분*/
	if(aJaxName=="dvsn_cd2")
	{
		document.getElementById("dvsn_cd3").length = 1;
	}
	else if(aJaxName=="dvsn_cd1")
	{
		document.getElementById("dvsn_cd3").length = 1;
		document.getElementById("dvsn_cd2").length = 1;
	}

	/*현황검색 > 기업검색 -끝*/
	
	if(objItem.length > 0) {
		try {
			var arrayValue = new Array(objItem.length);
			for (i=0;i< objItem.length; i++ ) {				
				var node = objItem[i];
				var childNodes = node.childNodes;
				arrayValue[i] = new Array(childNodes.length);
				
				var a = 0;
				for(var j=0; j<(childNodes.length); j++) {
					if(childNodes[j].nodeName != "#text")
					{
						arrayValue[i][a] = childNodes[j].text;
						a++;
					}
				}
				boxName.add(new Option(arrayValue[i][1], arrayValue[i][0]));
			}
		}
		catch(e) {
			alert(e);
		}
	}
}	

function returnText(){
	var boxName = document.getElementById(aJaxName);
	var objItem = xmlDOC.documentElement.selectNodes("/response/data");
	if(objItem.length > 0) {
		try {				
			var node = objItem[0];
			var childNodes = node.childNodes;
			
			boxName.value = childNodes[0].text;
			if(aJaxName=="buss_cd")
			{
				js_chkCd();
			}
		}
		catch(e) {
			alert(e);
		}
	}
}


