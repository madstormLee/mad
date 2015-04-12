/***************************************************************************************
 * 파일명	: js_techMng.js
 * 설명		: 관리자 사후관리 > 정산관리 > 기술료관리 
 * 작성자	: 임지현
 * 작성일	: 2011.02.09
 * 수정일	:
 ****************************************************************************************/
var ContextPath = "/";

$.validator.setDefaults({
	// 서브밋 핸들러
	submitHandler: function() {
		if(chkPlanDt()){
			document.form_p.submit();
		}
	},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});


//달력
$(function() {
	$( "#pay_plan_dt" ).datepicker({
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
	}),
	$( "#pay_dt" ).datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		showOn: "button",
		buttonImage: "/A_img/common/M_btn/btn_cal.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: "yymmdd"
	})
});


$().ready(function() {
		
	$("#form_p").validate({
		rules: {
			pay_plan_dt: {
				required: true,
				maxlength: 20,
				number:false
			},
			pay_mony: {
				required: true,
				maxlength: 20,
				number:true
			},
			pay_mthd: {
				required: true,
				maxlength: 10,
				number:false
			},
			stoc_no: {
				required: false,
				maxlength: 12,
				number:false
			},
			pay_dt: {
				required: false,
				maxlength: 20,
				number:true
			}
		},
		messages: {
			pay_plan_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			pay_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			pay_mthd: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			stoc_no: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			pay_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
});

/* 과제정보 팝업창에서 데이터 셋팅 */
function setData(prjt_no, entp_ko_nm, sprt_my, tech_rat){
	opener.setData2(prjt_no, entp_ko_nm, sprt_my, tech_rat);
	window.close();
}

/* 받아온 데이터 값 */
function setData2(prjt_no, entp_ko_nm, sprt_my, tech_rat){
	var obj = document.form_v;
	obj.prjt_no.value = prjt_no;
	obj.entp_ko_nm.value = entp_ko_nm;
	obj.sprt_my.value = sprt_my;
	obj.tech_rat.value = tech_rat;
}

function techDel(url){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href=url;
	}
}


