/***************************************************************************************
 * 파일명	: js_ntwkBuss.js
 * 설명		: 관리자 네트워크사업 
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
	$( "#met_dttm" ).datepicker({
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
			met_tit: {
				required: true,
				maxlength: 250,
				number:false
			},
			met_cont: {
				required: true,
				maxlength: 2000,
				number:false
			},
			entr_man_cunt: {
				required: true,
				maxlength: 10,
				number:false
			},
			met_dttm: {
				required: true,
				maxlength: 25,
				number:false
			}
		},
		messages: {
			met_tit: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			met_cont: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			entr_man_cunt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			met_dttm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	$("#form00_v").validate({
		rules: {
			out_chrg_nm: {
				required: true,
				number:false
			}
		},
		messages: {
			out_chrg_nm: {
				required: "<font color='red'><strong> √</strong></font>",
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

function sendData(nm_ko, memb_no){
	opener.setData(nm_ko, memb_no);
	window.close();
}

function setData(nm_ko, memb_no){
	var obj = document.form00_v;
	obj.out_chrg_nm.value = nm_ko;
	obj.out_chrg_id.value = memb_no;
}

