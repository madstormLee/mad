var ContextPath = "";

// 달력
$(function() {
	var dates = $( "#buss_prod_stdt, #buss_prod_eddt" ).datepicker({
		defaultDate: null,
		changeMonth: true,
		numberOfMonths: 1,
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
		dateFormat: "yymmdd",
		onSelect: function( selectedDate ) {
			var option = this.id == "buss_prod_stdt" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});

$().ready(function() {
	$("#form1").validate({
		rules: {
			bussnm: {		//사업구분
				required: true,
				maxlength: 300,
				number:false
			},
			main_org: {		//주관부처
				required: true,
				maxlength: 10,
				number:false
			},
			org_chrg: {		//부처담당자
				required: true,
				maxlength: 20,
				number:false
			},
			org_link_no: {		//부처연락처
				required: true,
				maxlength: 15,
				number:false
			},
			sprt_clsf_1: {		//지원내역분류상위코드
				required: true,
				maxlength: 10,
				number:false
			},
			sprt_clsf_2: {		//지원내역분류하위코드
				required: true,
				maxlength: 10,
				number:false
			},
			buss_sort: {		//사업종류
				required: true,
				maxlength: 10,
				number:false
			},
			proc: {		//프로세스
				required: true,
				maxlength: 10,
				number:false
			},
			org_cd: {		//담당부서
				required: true,
				maxlength: 10,
				number:false
			},
			chrg_id: {		//공고명
				required: true,
				maxlength: 20,
				number:false
			},
			buss_prod_stdt: {		//공고명
				required: true,
				maxlength: 10,
				number:false
			},
			buss_prod_eddt: {		//공고명
				required: true,
				maxlength: 10,
				number:false
			},
			tot_sprt_mony: {		//공고명
				required: true,
				maxlength: 12,
				number:true
			},
			buss_cont_sumy: {		//공고명
				required: false,
				maxlength: 4000,
				number:false
			}
			
		},
		messages: {
			bussnm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			main_org: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			org_chrg: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			sprt_clsf_1: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			sprt_clsf_2: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			buss_sort: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			proc: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			org_cd: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			chrg_id: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			buss_prod_stdt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			buss_prod_eddt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			tot_sprt_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			buss_cont_sumy: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			}
		}
	});
});


//등록		
function submitOk() {		
	if( confirm( "등록 하시겠습니까?" ) ){
		document.form1.submit();
	}else{
		return false;
	}		
}

// 수정 메소드
function upd() {		
	if(confirm("수정하시겠습니까?")){
		document.form1.submit();
	}

}



$.validator.setDefaults({
	// 서브밋 핸들러
	submitHandler: function() {		
		var mode = document.form1.mode.value;
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

/* 사업분류 대분류 선택시 */
function dvsnChg1(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=4";
	var name = "hrnk_buss_dvsn";
	var opt  = "select";			
	sendRequest( url, name, opt );
}

function dvsnChg2(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=4";
	var name = "hrnk_buss_dvsn1";
	var opt  = "select";			
	sendRequest( url, name, opt );
}

/* 지원내역분류 선택시 */
function cdChg1(val)
{
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=5";
	var name = "sprt_clsf_2";
	var opt  = "select";			
	sendRequest( url, name, opt );
}

function js_print(srcStr)
{
	var obj = window.open(srcStr,"print_win","width=800, height=700, scrollbars=yes");
	obj.focus();
}

