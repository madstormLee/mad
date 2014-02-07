/***************************************************************************************
 * 파일명	: js_mouCntt.js
 * 설명		: 관리자 MOU 체결 
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
	$( "#cntt_dt" ).datepicker({
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
	});
});


$().ready(function() {
	$("#form01_v").validate({
		rules: {
			cntt_nm: {
				required: true,
				maxlength: 200,
				number:false
			},
			cntt_cont: {
				required: true,
				maxlength: 2000,
				number:false
			},
			cntt_dt: {
				required: true,
				maxlength: 13,
				number:false
			},
			cntt_inst: {
				required: true,
				maxlength: 250,
				number:false
			},
			dvsn: {
				required: true,
				maxlength: 2,
				number:false
			}
		},
		messages: {
			cntt_nm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			cntt_cont: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			cntt_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			cntt_inst: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			dvsn: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
});


function del(url){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href=url;
	}
}

