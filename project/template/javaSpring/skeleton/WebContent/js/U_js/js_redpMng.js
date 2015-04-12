/***************************************************************************************
 * 파일명	: js_redpMng.js
 * 설명		: 관리자 사후관리 > 정산관리 > 환수금관리 
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


var ContextPath = "/";

//달력
$(function() {
	$( "#annc_dt" ).datepicker({
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
	$( "#pay_dttm" ).datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		showOn: "button",
		buttonImage: "/A_img/common/M_btn/btn_cal.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: "yymmdd"
	}),
	$( "#use_dt" ).datepicker({
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
	$("#form_v").validate({
		rules: {
			annc_dt: {
				required: true,
				maxlength: 8,
				number:false
			},
			pay_mthd: {
				required: true,
				maxlength: 10,
				number:false
			}
		},
		messages: {
			annc_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			pay_mthd: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	$("#form_p").validate({
		rules: {
			use_dt: {
				required: true,
				number:false
			},
			item: {
				required: true,
				number:false
			},
			dvsn: {
				required: true,
				number:false
			},
			cont: {
				required: true,
				number:false
			},
			mony: {
				required: true,
				number:true
			},
			resn: {
				required: true,
				number:false
			}
		},
		messages: {
			use_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			item: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			dvsn: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			cont: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			resn: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
});

/* 과제정보 팝업창에서 데이터 셋팅 */
function setData(prjt_no, entp_ko_nm, sprt_my, sprt_balc, tot_retmy, ntac_mony){
	opener.setData2(prjt_no, entp_ko_nm, sprt_my, sprt_balc, tot_retmy, ntac_mony);
	window.close();
}

/* 받아온 데이터 값 */
function setData2(prjt_no, entp_ko_nm, sprt_my, sprt_balc, tot_retmy, ntac_mony){
	var obj = document.form_v;
	obj.prjt_no.value = prjt_no;
	obj.entp_ko_nm.value = entp_ko_nm;
	obj.sprt_my.value = sprt_my;
	obj.sprt_balc.value = sprt_balc;
	obj.tot_retmy.value = tot_retmy;
	obj.ntac_mony.value = ntac_mony;
}

function redpDel(url){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href=url;
	}
}


