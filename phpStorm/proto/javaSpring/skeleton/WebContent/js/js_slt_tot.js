var ContextPath = "/";


$.validator.setDefaults({
	// 서브밋 핸들러
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});

//타당성체크
$().ready(function(){
	$("#form1").validate({
		rules: {
			recv_no: {		//과제번호=접수번호
				required: true,
				maxlength: 20,
				number:false
			},
			assm_date: {		//평가일자
				required: true,
				maxlength: 8,
				number:true
			},
			avg_scre: {		//평점(가점포함)
				required: true,
				maxlength: 5,
				number:true
			},
			ad_pnt: {		//가점
				required: true,
				maxlength: 5,
				number:true
			},
			tot_opin: {		//종합의견
				required: true,
				maxlength:4000,
				number:false
			},
			dvlp_stdt: {		//개발기간
				required: true,
				maxlength:8,
				number:true
			},
			dvlp_eddt: {		//개발기간
				required: true,
				maxlength: 8,
				number:true
			},
			sprt_my: {	//지원금
				required: true,
				maxlength: 20,
				number:true
			},
			priv_cst:{		//민간부담금
				required: true,
				maxlength: 10,
				number:true
			},
			tot_entp_my:{		//총사업비
				required: true,
				maxlength: 20,
				number:true
			},
			scre:{		//점수
				required: true,
				maxlength: 20,
				number:true
			},
			rgla_tech_my:{		//기술료율
				required: true,
				maxlength: 13,
				number:true
			},
			gvmt_sprt_rt:{		//정부지원비율
				required: true,
				maxlength: 10,
				number:true
			}
		},
		messages: {
			recv_no: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			assm_date: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			avg_scre: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			ad_pnt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			tot_opin: {	
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			dvlp_stdt:{	
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'>Only Number</font>"
			},
			dvlp_eddt:{
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			sprt_my:{	
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			priv_cst:{	
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			tot_entp_my:{	
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			scre:{	
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			rgla_tech_my:{		
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			gvmt_sprt_rt:{		
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			}
		}
	});
});

$(function() {
	$( "#assm_date" ).datepicker({
		// 전, 후 일 노출 여부
		showOtherMonths: true,
		// 전, 후 일 선택 여부
		selectOtherMonths: true,
		// 보이기 버튼
		showOn: "button",
		// 버튼 이미지 경로
		buttonImage: ContextPath+"A_img/common/M_btn/btn_cal.gif",
		// 버튼 BOX 미노출 여부
		buttonImageOnly: true,
		// SELECT 년 월 여부
		changeMonth: true,
		// SELECT 년 선택 여부
		changeYear: true,
		// 포맷 형식 
		dateFormat: "yymmdd"
	}),
	$( "#dvlp_stdt" ).datepicker({
		// 전, 후 일 노출 여부
		showOtherMonths: true,
		// 전, 후 일 선택 여부
		selectOtherMonths: true,
		// 보이기 버튼
		showOn: "button",
		// 버튼 이미지 경로
		buttonImage: ContextPath+"A_img/common/M_btn/btn_cal.gif",
		// 버튼 BOX 미노출 여부
		buttonImageOnly: true,
		// SELECT 년 월 여부
		changeMonth: true,
		// SELECT 년 선택 여부
		changeYear: true,
		// 포맷 형식 
		dateFormat: "yymmdd"
	}),
	$( "#dvlp_eddt" ).datepicker({
		// 전, 후 일 노출 여부
		showOtherMonths: true,
		// 전, 후 일 선택 여부
		selectOtherMonths: true,
		// 보이기 버튼
		showOn: "button",
		// 버튼 이미지 경로
		buttonImage: ContextPath+"A_img/common/M_btn/btn_cal.gif",
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


//삭제
function Del(url){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href=url;
	}
}

function js_print(srcStr)
{
	var obj = window.open(srcStr,"print_win","width=800, height=600, scrollbars=yes");
	obj.focus();
}

