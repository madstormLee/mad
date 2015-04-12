/***************************************************************************************
 * 파일명	: js_chrgApnt.js
 * 설명		: 관리자 접수처리 
 * 작성자	: 임지현
 * 작성일	: 2011.02.09
 * 수정일	:
 ****************************************************************************************/

var contextPath = "/";

function define(){
	if(js_isChk()){
		if(confirm("담당자 확정처리 하시겠습니까?")){
			return true;
		}else{
			return false;
		}
	}else{
		alert("담당자확정 할 과제를 선택해 주시기 바랍니다.");
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
		//alert("error");
	}

	return isChkVal;
}

function chrgChg(u_rl){
	if(js_isChk()){
		var url = u_rl;
		var name = "chrgChg";
		var opt = "width=400px, height=300px, scrollbars=no, location=no, status=no";
		window.open(url, name, opt);
	}else{
		alert("변경할 담당자를 선택해 주세요");
	}
}



function submit(id){
	if(confirm("선택하신 담당자로 변경하시겠습니까?")){
		var chrg_id = document.form1.chrg_id;
		if(chrg_id.length > 1){
			for(var i=0; i<chrg_id.length; i++){
				chrg_id[i].value = id;
			}
		}else{
			chrg_id.value = id;
		}
		document.form1.submit();
	}
}
