/***************************************************************************************
 * 파일명	: js_agmtMng.js
 * 설명		: 관리자 협약체결 
 * 작성자	: 임지현
 * 작성일	: 2011.02.09
 * 수정일	:
 ****************************************************************************************/

$.validator.setDefaults({
	// 서브밋 핸들러
	// submitHandler: function() {},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});

/* mngr_agmtMng00_l.jsp */

var ContextPath = "/";

function js_isChk(obj)
{
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
	//	alert("error");
	}

	return isChkVal;
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

function attSubmit(){
	var obj = document.form1.prjt_no;
	if(js_isChk(obj)){
		if(confirm("접수처리 하시겠습니까?")){
			return true;
		}else{
			return false;
		}
	}else{
		alert("과제를 선택해주세요");
		return false;
	}
}

/* mngr_agmtMng01_l.jsp  */

/************************88
 * @flag : agmtOk - 협약완료(상태값 40으로 변경)
 * 		   sltOk - 2순위 -> 1순위로 변경(기본양식에서 선정결과를 A로 변경)
 * 		   outOk - 탈락확정(상태값 99로 변경)
 * @mode : sts - 상태값변경
 * 		   slt - 선정결과 변경 
 */
function define(flag, prjtno){
	var obj = document.form1;
	obj.action = "/mngr/buss_invti/mngr_agmtMng01_lt.do";
	obj.prjt_no.value = prjtno;
	if(flag == "agmtOk"){
		if(confirm("협약확정처리 하시겠습니까?")){
			obj.mode.value = "sts";
			obj.prjt_cd.value = "40";
			obj.submit();
		}
	}else if(flag == "sltOk"){
		if(confirm("1순위로 선정하시겠습니까?")){
			obj.mode.value = "slt";
			obj.submit();
		}
	}else if(flag == "outOk"){
		if(confirm("탈락확정처리 하시겠습니까?")){
			obj.mode.value = "sts";
			obj.prjt_cd.value = "99";
			obj.submit();
		}
	}
}

/* mngr_agmtMng01_v.jsp  */


//달력
$(function() {
	$( "#agmt_dt" ).datepicker({
		// 전, 후 일 노출 여부
		showOtherMonths: true,
		// 전, 후 일 선택 여부
		selectOtherMonths: true,
		// 보이기 버튼
		showOn: "button",
		// 버튼 이미지 경로
		buttonImage: "/A_img/common/M_btn/btn_cal.gif",
		// 버튼 BOX 미노출 여부
		buttonImageOnly: true,
		// SELECT 년 월 여부
		changeMonth: true,
		// SELECT 년 선택 여부
		changeYear: true,
		// 포맷 형식 
		dateFormat: "yymmdd"
	})
});


$().ready(function() {
	$("#form_v").validate({
		rules: {
			sprt_prepay: {
				required: true,
				maxlength: 10,
				number:true
			},
			sprt_midpay: {
				required: true,
				maxlength: 10,
				number:true
			},
			sprt_balnc: {
				required: true,
				maxlength: 10,
				number:true
			},
			agmt_dt: {
				required: true,
				maxlength: 13
			},
			note: {
				required: true,
				maxlength: 2000
			}
		},
		messages: {
			sprt_prepay: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			sprt_midpay: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			sprt_balnc: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			agmt_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			},
			note: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			}
		}
	});
});


