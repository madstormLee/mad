/***************************************************************************************
 * 파일명	: mngrAftMngPage.js
 * 설명		: 관리자 성과등록  스크립트
 * 작성자	:
 * 작성일	: 2011.01.13
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

$(function() {
	var ContextPath ="/";
	$( "#pblc_yyyy_mm" ).datepicker({
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

$(function() {
	var ContextPath ="/";
	$( "#scsh_dt" ).datepicker({
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

// 사업화   폼체크 저장,수정	
function frutFormChk() {
	$("#form1").validate({
		rules: {
			prdc_nm: {
				required: true,
				maxlength: 200
			},
			frut_yyyy: {
				required: true				
			},
			sale_mony: {
				required: true,
				number:true				
			},
			expt_mony: {
				required: true,
				number:true				
			},
			buss_takeprod: {
				required: false,
				number:true	
			}
		},
		messages: {
			prdc_nm: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'>200자 이하이여야 합니다.</font>"
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			sale_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			expt_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			buss_takeprod: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}
//논문   폼체크 저장,수정	
function thesFormChk() {
	$("#form1").validate({
		
		rules: {
			tit_ko: {
				required: true,
				maxlength: 200
			},
			frut_yyyy: {
				required: true,
				number:true
			},
			isbn_num: {
				number:true
			},
			dvsn: {
				required: true
			},
			pblc_yyyy_mm: {
				required: true,
				maxlength: 8,
				number:true				
			}	
		},
		messages: {
			tit_ko: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: ""
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			isbn_num: {
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			dvsn: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			pblc_yyyy_mm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'><strong> only Number</strong></font>"
			}			
		}
	});
	
	return true;
}

//특허 프로그램    폼체크 저장,수정	
function ptntFormChk() {
	$("#form1").validate({
		rules: {
			dsgn_ko: {
				required: true,
				maxlength: 200
			},
			dvsn: {
				required: true
			},
			frut_yyyy: {
				required: true
			}
		},
		messages: {
			dsgn_ko: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: ""
			},
			dvsn: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>"
			}
		}
	});
	
	return true;
}

//인증    폼체크 저장,수정	
function certFormChk() {
	$("#form1").validate({
		rules: {
			certnm_ko: {
				required: true,
				maxlength: 200
			},
			frut_yyyy: {
				required: true
			}
		},
		messages: {
			certnm_ko: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> √</strong></font>"
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>"
			}
		}
	});
	
	return true;
}

//계약    폼체크 저장,수정	
function ctrcFormChk() {
	$("#form1").validate({
		rules: {
			ctrcnm: {
				required: true,
				maxlength: 200
			},
			frut_yyyy: {
				required: true
			},
			ctrc_mony: {
				required: true,
				number:true
			},
			buss_rgst_no: {
				required: true,
				maxlength:10,
				number:true
			}
		},
		messages: {
			ctrcnm: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> √</strong></font>"
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			ctrc_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			buss_rgst_no: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

//상담    폼체크 저장,수정	
function cnstFormChk() {
	$("#form1").validate({
		rules: {
			cnst_nm: {
				required: true,
				maxlength: 200
			},
			frut_yyyy: {
				required: true
			},
			cnst_mony: {
				required: true,
				number:true
			},
			buss_rgst_no: {
				required: true,
				maxlength:10,
				number:true
			}
		},
		messages: {
			cnst_nm: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> √</strong></font>"
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			cnst_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			buss_rgst_no: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

//투자유치    폼체크 저장,수정	
function ivstFormChk() {
	$("#form1").validate({
		rules: {
			dsgn: {
				required: true,
				maxlength: 200
			},
			frut_yyyy: {
				required: true
			},
			ivst_mony: {
				required: true,
				number:true
			},
			buss_rgst_no: {
				required: true,
				maxlength:10,
				number:true
			}
		},
		messages: {
			dsgn: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> √</strong></font>"
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			ivst_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			buss_rgst_no: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

//해외거점     폼체크 저장,수정	
function ovrsFormChk() {
	$("#form1").validate({
		rules: {
			offi_nm: {
				required: true,
				maxlength: 200
			},
			frut_yyyy: {
				required: true
			},
			cstr_mony: {
				required: true,
				maxlength:10,
				number:true
			}
		},
		messages: {
			offi_nm: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: ""
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			cstr_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

//시장개척      폼체크 저장,수정	
function mktopenFormChk() {
	$("#form1").validate({
		rules: {
			offi_nm: {
				required: true,
				maxlength: 200
			},
			frut_yyyy: {
				required: true
			},
			take_mony: {
				required: true,
				number:true
			}
		},
		messages: {
			offi_nm: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: ""
			},
			frut_yyyy: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			take_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

//신규고용      폼체크 저장,수정	
function newEmplFormChk() {
	$("#form1").validate({
		rules: {
			frut_yyyy: {
				required: true
			},
			rsch_empy: {
				required: false,
				number: true
			},
			prtn_empy: {
				required: false,
				number: true
			},
			etc_empy: {
				required: false,
				number: true
			}
		},
		messages: {
			frut_yyyy: { 
				required: "<font color='red'><strong> √</strong></font>"
			},
			rsch_empy: { 
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			prtn_empy: { 
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			etc_empy: { 
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

//기술이전       폼체크 저장,수정	
function techFormChk() {
	$("#form1").validate({
		rules: {
			frut_yyyy: {
				required: true
			},
			ctrc_mony: {
				required: false,
				number:true
			},
			mony: {
				required: false,
				number:true
			},
			yyyy_mony: {
				required: false,
				number:true
			}
		},
		messages: {
			frut_yyyy: { 
				required: "<font color='red'><strong> √</strong></font>"
			},
			ctrc_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			yyyy_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

//수입대체효과       폼체크 저장,수정	
function imptFormChk() {
	$("#form1").validate({
		rules: {
			frut_yyyy: {
				required: true
			},
			impt_prdc_mony: {
				required: true,
				number:true
			},
			dvlp_prdc_mony: {
				required: true,
				number:true
			},
			sel: {
				required: true,
				number:true
			}
		},
		messages: {
			frut_yyyy: { 
				required: "<font color='red'><strong> √</strong></font>"
			},
			impt_prdc_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			dvlp_prdc_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			sel: {
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}
//기술수준 향상기여도       폼체크 저장,수정	
function techlevFormChk() {
	$("#form1").validate({
		rules: {
			dvlp_tech_levl: {
				required: true,
				number:true
			},
			dvlp_tech_yyyy: {
				required: true,
				number:true
			},
			dvlp_comp_tech_yyyy: {
				required: true,
				number:true
			},
			ed_tech_yyyy_1: {
				required: true,
				number:true
			},
			ed_tech_yyyy_2: {
				required: true,
				number:true
			},
			ed_tech_yyyy_3: {
				required: true,
				number:true
			},
			dvlp_tech_gap_yyyy: {
				required: true,
				number:true
			},
			dvlp_comp_gap_yyyy: {
				required: true,
				number:true
			},
			ed_levl_yyyy_1: {
				required: true,
				number:true
			},
			ed_levl_yyyy_2: {
				required: true,
				number:true
			},
			ed_levl_yyyy_3: {
				required: true,
				number:true
			},
			dvlp_comp_tech_levl: {
				required: true,
				number:true
			},
			ed_tech_levl_1: {
				required: true,
				number:true
			},
			ed_tech_levl_2: {
				required: true,
				number:true
			},
			ed_tech_levl_3: {
				required: true,
				number:true
			},
			dvlp_tech_gap: {
				required: true,
				number:true
			},
			dvlp_comp_tech_gap: {
				required: true,
				number:true
			},
			ed_levl_1: {
				required: true,
				number:true
			},
			ed_levl_yyyy_3: {
				required: true,
				number:true
			},
			ed_levl_2: {
				required: true,
				number:true
			},
			ed_levl_3: {
				required: true,
				number:true
			}
		},
		messages: {
			dvlp_tech_levl: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			dvlp_tech_yyyy: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			dvlp_comp_tech_yyyy: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_tech_yyyy_1: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_tech_yyyy_2: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_tech_yyyy_3: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			dvlp_tech_gap_yyyy: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			dvlp_comp_gap_yyyy: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_levl_yyyy_1: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_levl_yyyy_2: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_levl_yyyy_3: { 
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			dvlp_comp_tech_levl: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_tech_levl_1: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_tech_levl_2: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_tech_levl_3: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			dvlp_tech_gap: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			dvlp_comp_tech_gap: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_levl_1: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_levl_yyyy_3: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_levl_2: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			},
			ed_levl_3: {
				required: "<font color='red'><strong> √</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>" 
			}
		}
	});
	
	return true;
}


//데이터 삭제 
function prfsDataDel(url){	
	if(confirm(" 삭제하시겠습니까?")){
		location.href=url;
	}
}		

//데이터  승인 
function prfsDataAprv(url){	
	if(confirm(" 승인하시겠습니까?")){
		location.href=url;
	}
}		