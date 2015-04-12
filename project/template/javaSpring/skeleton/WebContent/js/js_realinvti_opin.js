/***************************************************************************************
 * 파일명	: js_realinvti_opin.js
 * 설명		: 관리자 실태조사종합의견 
 * 작성자	: 임지현
 * 작성일	: 2011.02.09
 * 수정일	:
 ****************************************************************************************/

$.validator.setDefaults({
	// 서브밋 핸들러
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});


var ContextPath = "/";

//달력
$(function() {
	$( "#inspc_date" ).datepicker({
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
	$( "#invti_date" ).datepicker({
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
	$("#form1").validate({
		rules: {
			inspc_date: {
				required: true,
				number:false
			},
			sum: {
				required: true,
				number:false
			},
			avg_scre: {
				required: true,
				number:false
			},
			tot_opin: {
				required: true,
				number:false
			},
			invti_date: {
				required: true,
				number:false
			},
			invti_type: {
				required: true,
				number:false
			},
			invter_nm: {	//조사자성명
				required: true,
				number:false
			},
			blng: {		//조사자소속
				required: true,
				number:false
			},
			pstn: {		//조사자직위
				required: true,
				number:false
			}
		},
		messages: {
			inspc_date: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			sum: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			avg_scre: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			tot_opin: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			invti_date: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			invti_type: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			invter_nm: {	//조사자성명
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			blng: {		//조사자소속
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			pstn: {		//조사자직위
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
});

