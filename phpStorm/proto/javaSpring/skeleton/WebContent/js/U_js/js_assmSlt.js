/***************************************************************************************
 * 파일명	: js_assmSlt.js
 * 설명		: 관리자 접수처리 
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

 
/* mngr_assmSlt00_l.jsp */

//달력
$(function() {
	$( "#sch_assmdt" ).datepicker({
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
	
	var dates = $( "#bfrn_stud_stdt, #bfrn_stud_eddt" ).datepicker({
		defaultDate: null,
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: "yymmdd",
		showOtherMonths: true,
		selectOtherMonths: true,
		showOn: "button",
		buttonImage: "/A_img/common/M_btn/btn_cal.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		onSelect: function( selectedDate ) {
			var option = this.id == "bfrn_stud_stdt" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});



/* mngr_assmSlt00_p.jsp */


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
		alert("검색결과가 없습니다");
	}

	return isChkVal;
}

function select(){
	var obj = document.form1.prfs_no;
	if(js_isChk(obj)){
		if(confirm("평가위원으로 지정하시겠습니까?")){
			return true;
		}else{
			return false;
		}
	}else{
		alert("전문가를 선택해주세요");
		return false;
	}
}


/* 산업기술 대분류 선택시 */
function ndsfChg2(val){
	var url	 = "/common/mngr_selXml00_t.do?code="+val+"&flag=6";
	var name = "tech_cd3";
	var opt  = "select";			
	if(val != "")
	{
		sendRequest( url, name, opt );
	}
	else
	{
		document.getElementById(name).length=1;
	}
}

function ndsfChg1(val){
	var url	 = "/common/mngr_selXml00_t.do?code="+val+"&flag=6";
	var name = "tech_cd2";
	var opt  = "select";			
	if(val != "")
	{
		sendRequest( url, name, opt );
	}
	else
	{
		document.getElementById(name).length=1;
	}
}



/* mngr_assmSlt00_v.jsp */

$().ready(function() {
	$("#form_v").validate({
		rules: {
			sdv_nm: {
				required: true,
				maxlength: 50,
				number:false
			},
			assm_dt: {
				required: true,
				maxlength: 13,
				number:false
			},
			assm_plce: {
				required: true,
				maxlength: 50,
				number:false
			}
		},
		messages: {
			sdv_nm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			assm_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			assm_plce: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
});

//달력
$(function() {
	$( "#assm_dt" ).datepicker({
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

function del(url){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href=url;
	}
}


/* mngr_assmSlt01_p.jsp */


function prjtsel(){
	var obj = document.form1.prjt_no;
	if(js_isChk(obj)){
		if(confirm("과제를 등록하시겠습니까?")){
			return true;
		}else{
			return false;
		}
	}else{
		alert("과제를 선택해주세요");
		return false;
	}
}
