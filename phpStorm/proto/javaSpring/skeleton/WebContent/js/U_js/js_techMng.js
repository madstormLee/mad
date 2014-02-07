/***************************************************************************************
 * 파일명	: js_techMng.js
 * 설명		: 관리자 사후관리 > 정산관리 > 기술료관리 
 * 작성자	: 임지현
 * 작성일	: 2011.02.09
 * 수정일	:
 ****************************************************************************************/
var ContextPath = "/";


$().ready(function() {
	$("#form_v").validate({
		rules: {
			tot_pay_mony: {
				required: true,
				maxlength: 20,
				number:true
			},
			dvsn: {
				required: true,
				maxlength: 20,
				number:false
			}
		},
		messages: {
			tot_pay_mony: {
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
/*
//등록
function submitOk() {		
	if( confirm( "등록 하시겠습니까?" ) ){
		form_v.mode.value=mode;
		form_v.submit();
		// 에디터
		//form1.annc_cont.value = myeditor.outputHTML();

		// 파일첨부
		return true;
	}else{
		return false;
	}		
}

// 수정 메소드
function upd() {		
	if(confirm("수정하시겠습니까?")){
		form_v.mode.value=mode;
		form_v.submit();
		return true;
	}else{
		return false;
	}
}
/*
$.validator.setDefaults({
	// 서브밋 핸들러
	submitHandler: function() {		
		var mode = document.form_v.mode.value;
		if( mode == "INSERT" ){
			submitOk();	
		}else if ( mode == "UPDATE" ){
			upd();
		}
	},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});	
*/


