/***************************************************************************************
 * 파일명	: js_recvProc.js
 * 설명		: 관리자 접수처리 
 * 작성자	: 임지현
 * 작성일	: 2011.02.09
 * 수정일	:
 ****************************************************************************************/



function send(){
	if(js_isChk()){
		if(confirm("접수처리 하시겠습니까?")){
			return true;
		}else{
			return false;
		}
	}else{
		alert("접수처리 할 과제를 선택해 주시기 바랍니다.");
		return false;
	}

}

function js_chkall(val)
{
	var obj = document.getElementsByName("chk");
	try{
		if(obj.length > 0)
		{
			for(var i = 0; i < obj.length; i++)
			{
				obj[i].checked = val;
			}
		}
		else
		{
			document.form1.chk.checked = document.form1.allchk.checked;
		}

	}
	catch(e){
	}
}

function js_isChk()
{
	var obj = document.form1.chk;
	var isChkVal = false;
	try{
		if(obj.length > 1)
		{
			for(var i = 0; i < obj.length; i++)
			{
				if(obj[i].checked ==true)
				{
					isChkVal = true;
					break;
				}
			}
		}
		else
		{
			if(obj.checked ==true)
			{
				isChkVal = true;
			}
		}

	}
	catch(e){
	}

	return isChkVal;
}


/**
 * 검색 : 사업구분 
 * **/

function dvsnChg1(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=4";
	var name = "sch_gubun1";
	var opt  = "select";			
	sendRequest( url, name, opt );
}
