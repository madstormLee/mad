/***************************************************************************************
 * 파일명	: js_ccltMng.js
 * 설명	: 관리자 사후관리 > 정산관리 > 사업비정산 
 * 작성자	: 위성국
 * 작성일	: 2011.02.15
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
	$( "#tot_dvlp_stdt" ).datepicker({
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
	$( "#tot_dvlp_endt" ).datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		showOn: "button",
		buttonImage: "/A_img/common/M_btn/btn_cal.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: "yymmdd"
	}),
	$( "#cclt_prod_stdt" ).datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		showOn: "button",
		buttonImage: "/A_img/common/M_btn/btn_cal.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: "yymmdd"
	}),
	$( "#cclt_prod_endt" ).datepicker({
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

function ccltDel(url){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href=url;
	}
}

function chkNum(obj){
	if(isNaN(obj.value)){
		alert('숫자만 가능합니다.');
		obj.value='0';
		return;
	}
	pageSum();
	
}
function pageSum(){
	var obj=document.form1;
	var a_val=parseInt(obj.tmp_11.value);//정부출연금
	var tmp12=parseInt(obj.tmp_12.value);//민간부담금현금
	var b_val=parseInt(obj.tmp_15.value);//현금합계
	var tmp16=parseInt(obj.tmp_16.value);//현물합계
	var c_val=parseInt(obj.use_mony_cash.value);//사용금액현금
	var use_obj=parseInt(obj.use_mony_nknd.value);//사용금액_현물
	var e_val=parseInt(obj.itrt.value);//발생이자
	var d_val=b_val-c_val+e_val;//사용잔액현금
	var tmp21=tmp16-use_obj;//사용잔액현물
	var not_confirm=parseInt(obj.ntac_mony.value);//불인정금액
	var g_val=d_val+not_confirm;//정산잔액_현금
	var tmp32=tmp21;//사용잔액_현물
	var h_val=parseInt(obj.fwyy_mony.value);//차년도이월액
	var i_val=g_val-h_val;//최종잔액
	var j_val=parseInt(i_val*a_val/b_val);//정부출연금잔액(환수대상액);
	var local_money=parseInt(obj.dtmy_1.value);//지방비
	var local_money2=parseInt(obj.dtmy_2.value);//지방비2


	obj.use_balc.value=d_val;
	obj.tmp_21.value=tmp21;
	obj.tmp_31.value=g_val;
	obj.tmp_32.value=tmp32;
	obj.tmp_33.value=i_val;
	obj.tmp_34.value=j_val;
	obj.ntmy_balc.value=parseInt(g_val*((a_val-local_money-local_money2)/b_val)/1000)*1000;//천단위 이하 절사
	obj.dtmy_balc_1.value=parseInt(g_val*(local_money/b_val)/1000)*1000;//천단위 이하 절사
	obj.dtmy_balc_2.value=parseInt(g_val*(local_money2/b_val)/1000)*1000;//천단위 이하 절사
	obj.priv_cash_balc.value=parseInt(g_val*(tmp12/b_val));
}
