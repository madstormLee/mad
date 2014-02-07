var xmlDOC		= null;
var aJaxUrl		= null;
var aJaxName	= null;
var targetProc	= null;
var resultXml 	= null;
var aJaxOpt		= null;

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
			xmlDOC = new ActiveXObject("Msxml12.XMLHTTP");
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
		return xmlDOC;
	}
}

function sendRequest1(url, name, opt){
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


function sendRequest(url, name, opt){
	aJaxUrl 	= url;
	aJaxName 	= name;
	aJaxOpt		= opt;	

	xmlDOC = getXmlDom();	
	xmlDOC.async = true; 
	//document.write(aJaxUrl);
	xmlDOC.load(aJaxUrl);
	xmlDOC.onreadystatechange = sendResponse;

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
		resultXml = xmlDOC.responseXML;	
		if(aJaxOpt == "select") {
			returnSelect();
		}else if(aJaxOpt == "load"){
			returnLoad();
		}
	}
} 

/* 기업DB 일반현황
 * SelectBox return */
function returnSelect(){
	var boxName = document.getElementById(aJaxName);
	var objItem = xmlDOC.documentElement.selectNodes("/response/data");
	
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
		
	if(objItem.length > 0) {
		try {
			var arrayValue = new Array(objItem.length);
			for (i=0;i< objItem.length; i++ ) {				
				var node = objItem[i];
				var childNodes = node.childNodes;
				arrayValue[i] = new Array(childNodes.length);
				for(var j=0; j<(childNodes.length); j++) {
					arrayValue[i][j] = childNodes[j].text;							
				}
				boxName.add(new Option(arrayValue[i][1], arrayValue[i][0]));
			}
		}
		catch(e) {
			alert(e);
		}
	}
}	



/* SelectBox 로딩시(안써용) */
function returnLoad(){
	var boxName = document.getElementById(aJaxName);
	var objItem = xmlDOC.documentElement.selectNodes("/response/data");
	if(objItem.length > 0) {
		try {
			var arrayValue = new Array(objItem.length);
			for (i=0;i< objItem.length; i++ ) {				
				var node = objItem[i];
				var childNodes = node.childNodes;
				arrayValue[i] = new Array(childNodes.length);
				for(var j=0; j<(childNodes.length); j++) {
					arrayValue[i][j] = childNodes[j].text;							
				}
				boxName.add(new Option(arrayValue[i][1], arrayValue[i][0]));
				if(arrayValue[i][0]==aValue){
					boxName.options[i+1].selected = true;	
					var rsNm = "";
					if(aName=="entp_dvsn2"){
						document.getElementById("entp_dvsn1").length = 1;
						rsNm = "entp_dvsn1";
						loadSelect(arrayValue[i][2], rsNm);	
					}else if(aName=="entp_dvsn"){
						rsNm = "entp_dvsn2";
						loadSelect(arrayValue[i][2], rsNm);	
					}else if(aName=="ndst_clsf2"){
						document.getElementById("ndst_clsf1").length = 1;
						rsNm = "ndst_clsf1";
						loadSelect(arrayValue[i][0].substring(0, arrayValue[i][0].length-1), rsNm);	
					}else if(aName=="ndst_clsf3"){
						rsNm = "ndst_clsf2";
						loadSelect(arrayValue[i][0].substring(0, arrayValue[i][0].length-1), rsNm);	
					}else if(aName=="ndst_clsf"){
						rsNm = "ndst_clsf3";
						loadSelect(arrayValue[i][0].substring(0, arrayValue[i][0].length-1), rsNm);	
					}
					
				} 
			}
		}
		catch(e) {
			alert(e);
		}
	}
}

