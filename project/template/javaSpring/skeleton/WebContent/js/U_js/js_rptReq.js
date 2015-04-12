/***************************************************************************************
 * 파일명	: js_rptReq.js
 * 설명		: 관리자 보고서접수요청 
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
	var obj = document.getElementsByName("prjt_no");
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
			document.form1.prjt_no.checked = document.form1.allchk.checked;
		}

	}
	catch(e){
	}
}

function js_isChk()
{
	var obj = document.form1.prjt_no;
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


function request(url){
	if(confirm("보고서요청하시겠습니까?")){
		location.href=url;
	}
}
