/***************************************************************************************
 * 파일명	: userEntpPage.js
 * 설명		: 기업 마이페이지
 * 작성자	: 임지현
 * 작성일	: 2010.11.03
 * 수정일	:
 ****************************************************************************************/


$.validator.setDefaults({
	// 서브밋 핸들러
	submitHandler: function() {
		if(document.form1.file_yn.value == "Y"){	/* 기업일반현황등록시. */
	       /* var add = document.getElementById("InnoAP1");	
	        	        
	        if(add.GetFileName(0) != ""){
		        document.InnoAP.AddFile(add.GetFileName(0));
		        document.form1["fileTxt"].value = add.GetFileName(0);
	        }*/
			
			InnoAPSubmit(document.form1);
		}else{
			document.form1.submit();
		}
	},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});


	function entpDataDel(url){
		if(confirm("정말 삭제하시겠습니까?")){
			location.href=url;
		}
	}

/*--------------------------------------------------------*
 * 기업 일반현황
 *--------------------------------------------------------*/

// 기업 일반현황 폼 체크
	$().ready(function() {
		$("#entp_form").validate({
			rules: {
				buss_rgst_no: {
					required: true,
					maxlength: 10,
					minlength: 10,
					number:true
				},
				pwd: {
					required: true,
					maxlength: 50,
					number:false
				},
				pwd2: {
					required: true,
					equalTo: "#pwd",
					maxlength: 50,
					number:false
				},
				entp_dvsn: {
					required: true,
					maxlength: 200,
					number:false
				},
				ndst_clsf: {
					required: true,
					maxlength: 200,
					number:false
				},
				entp_pos_info: {
					required: true,
					maxlength: 200,
					number:false
				},
				entp_ko_nm: {
					required: true,
					maxlength: 200,
					number:false
				},
				entp_en_nm: {
					required: true,
					maxlength: 200,
					number:false
				},
				cptn_nm: {
					required: true,
					maxlength: 20,
					number:false
				},
				cptn_rgst_no1: {
					required: true,
					maxlength: 6,
					number:false
				},
				cptn_rgst_no2: {
					required: true,
					maxlength: 7,
					number:false
				},
				open_dt: {
					required: true,
					maxlength: 8,
					number:true
				},
				bcon: {
					required: true,
					maxlength: 100,
					number:false
				},
				kind: {
					required: true,
					maxlength: 100,
					number:false
				},
				entp_post_no: {
					required: true,
					maxlength: 7,
					number:false
				},
				entp_addr1: {
					required: true,
					maxlength: 100,
					number:false
				},
				entp_addr2: {
					required: true,
					maxlength: 100,
					number:false
				},
				link_no1: {
					required: true,
					maxlength: 3,
					number:true
				},
				link_no2: {
					required: true,
					maxlength: 4,
					number:false
				},
				link_no3: {
					required: true,
					maxlength: 4,
					number:false
				},
				fax1: {
					required: true,
					maxlength: 3,
					number:true
				},
				fax2: {
					required: true,
					maxlength: 4,
					number:false
				},
				fax3: {
					required: true,
					maxlength: 4,
					number:false
				},
				lstg_yn: {
					required: true,
					maxlength: 4,
					number:false
				},
				aflt_lbrt_apnt_yn: {
					required: true,
					maxlength: 4,
					number:false
				},
				strg_ndst_clsf: {
					required: true,
					maxlength: 10,
					number:false
				}
			},
			messages: {
				buss_rgst_no: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: " 10자리여야 합니다.",
					minlength: " 10자리여야 합니다.",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				pwd: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				pwd2: {
					required: "<font color='red'><strong> √</strong></font>",
					equalTo: "비밀번호가 일치하지 않습니다.",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				entp_dvsn: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				ndst_clsf: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				entp_pos_info: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				entp_ko_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				entp_en_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				cptn_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				cptn_rgst_no1: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				cptn_rgst_no2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				open_dt: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				bcon: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				kind: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				entp_post_no: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				entp_addr1: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				entp_addr2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				link_no1: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				link_no2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				link_no3: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				fax1: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				fax2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				fax3: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				lstg_yn: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				aflt_lbrt_apnt_yn: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				strg_ndst_clsf: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				}
			}
		});
	});

/*--------------------------------------------------------*
 * 기업 인증보유현황 
 *--------------------------------------------------------*/

/* 폼체크 */

function certstatFormChk(){
	$("#form1").validate({
		rules: {
			cert_dvsn: {
				required: true,
				maxlength: 8,
				number:false
			},
			inot_dvsn: {
				required: true,
				maxlength: 8,
				number:false
			},
			cert_rgst_dt: {
				required: true,
				maxlength: 8,
				number:true
			},
			cert_rgst_no: {
				required: true,
				maxlength: 20,
				number:true
			}
		},
		messages: {
			cert_dvsn: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			inot_dvsn: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			cert_rgst_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			cert_rgst_no: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}


/*--------------------------------------------------------*
 * 기업 정부지원사업수행정보 
 *--------------------------------------------------------*/

/* 폼체크 */

function gvmtBussFormChk(){
	$("#form1").validate({
		rules: {
			buss_nm: {
				required: true,
				maxlength: 100,
				number:false
			},
			prjt_no: {
				required: true,
				maxlength: 20,
				number:false
			},
			prjt_nm: {
				required: true,
				maxlength: 200,
				number:false
			},
			prjt_stdt: {
				required: true,
				maxlength: 8,
				number:true
			},
			prjt_eddt: {
				required: true,
				maxlength: 8,
				number:true
			},
			gvmt_supp: {
				required: true,
				maxlength: 10,
				number:true
			},
			role_dvsn: {
				required: true,
				maxlength: 8,
				number:false
			},
			sprt_inst: {
				required: true,
				maxlength: 50,
				number:false
			},
			fulf_rslt: {
				required: true,
				maxlength: 8,
				number:false
			}
		},
		messages: {
			buss_nm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			prjt_no: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			prjt_nm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			prjt_stdt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			prjt_eddt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			gvmt_supp: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			role_dvsn: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			sprt_inst: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			fulf_rslt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

/*--------------------------------------------------------*
 * 기업 보유기술 
 *--------------------------------------------------------*/

/* 폼체크 */

function holdTechFormChk(){
	$("#form1").validate({
		rules: {
			tech_nm_ko: {
				required: true,
				maxlength: 200,
				number:false
			},
			tech_nm_en: {
				required: true,
				maxlength: 200,
				number:false
			},
			chrg_nm: {
				required: true,
				maxlength: 20,
				number:false
			},
			chrg_duty: {
				required: true,
				maxlength: 20,
				number:false
			},
			chrg_link_no: {
				required: true,
				maxlength: 15,
				number:false
			},
			chrg_eml: {
				required: true,
				maxlength: 50,
				number:false,
				email:true
			},
			tech_spec: {
				required: true,
				maxlength: 500,
				number:false
			},
			relt_buss_buss_nm: {
				maxlength: 100
			},
			relt_buss_prjt_nm: {
				maxlength: 200
			},
			relt_buss_main_inst_nm: {
				maxlength: 100
			},
			relt_buss_prjt_stdt: {
				maxlength: 8,
				number:true
			},
			relt_buss_prjt_eddt: {
				maxlength: 8,
				number:true
			},
			keyw_ko: {
				maxlength: 100
			},
			keyw_en: {
				maxlength: 100
			}
		},
		messages: {
			tech_nm_ko: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			tech_nm_en: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			chrg_nm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			chrg_duty: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			chrg_link_no: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			chrg_eml: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>",
				email: "형식이 올바르지 않습니다."
			},
			tech_spec: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			relt_buss_buss_nm: {
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			},
			relt_buss_prjt_nm: {
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			},
			relt_buss_main_inst_nm: {
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			},
			relt_buss_prjt_stdt: {
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			relt_buss_prjt_eddt: {
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			keyw_ko: {
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			},
			keyw_en: {
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			}
		}
	});
	
	return true;
}

/*--------------------------------------------------------*
 * 기업 산업재산권보유현황 
 *--------------------------------------------------------*/

/* 폼체크 */

function lcnsHoldFormChk(){

	$("#form1").validate({
		rules: {
			dvsn: {
				required: true,
				maxlength: 8,
				number:false
			},
			lcns_nm: {
				required: true,
				maxlength: 300,
				number:false
			},
			cert_rgst_dt: {
				required: true,
				maxlength: 8,
				number:false
			},
			cert_rgst_no: {
				required: true,
				maxlength: 20,
				number:false
			}
		},
		messages: {
			dvsn: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			lcns_nm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			cert_rgst_dt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			cert_rgst_no: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	});
	
	return true;
}

/*--------------------------------------------------------*
 * 기업 년도별경영실적 
 *--------------------------------------------------------*/

/* 폼체크 */

function yyyyAdmnFormChk(){
	
	$("#form1").validate({
		rules: {
			yyyy: {
				required: true,
				maxlength: 4,
				number:false
			},
			fund: {
				required: true,
				maxlength: 12,
				number:true
			},
			asst: {
				required: true,
				maxlength: 12,
				number:true
			},
			sale: {
				required: true,
				maxlength: 12,
				number:true
			},
			expt: {
				required: true,
				maxlength: 12,
				number:true
			},
			debt: {
				required: true,
				maxlength: 12,
				number:true
			},
			main_cus: {
				required: true,
				maxlength: 100,
				number:false
			}
		},
		messages: {
			yyyy: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			fund: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			asst: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			sale: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			expt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			debt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			main_cus: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	})
	
	return true;
}

/*--------------------------------------------------------*
 * 기업 연구개발및설비투자 
 *--------------------------------------------------------*/

/* 폼체크 */

function rschFcltFormChk(){
	
	$("#form1").validate({
		rules: {
			yyyy: {
				required: true,
				maxlength: 4,
				number:true
			},
			year_rsch_dvlp_mony: {
				required: true,
				maxlength: 12,
				number:true
			},
			year_eqmt_ivst_mony: {
				required: true,
				maxlength: 12,
				number:true
			},
			natn_rsch_dvlp_fulf_cunt: {
				required: true,
				maxlength: 4,
				number:true
			},
			natn_rsch_dvlp_fulf_amnt: {
				required: true,
				maxlength: 12,
				number:true
			},
			dist_rsch_dvlp_fulf_cunt: {
				required: true,
				maxlength: 4,
				number:true
			},
			dist_rsch_dvlp_fulf_amnt: {
				required: true,
				maxlength: 12,
				number:true
			}
		},
		messages: {
			yyyy: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			year_rsch_dvlp_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			year_eqmt_ivst_mony: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			natn_rsch_dvlp_fulf_cunt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			natn_rsch_dvlp_fulf_amnt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			dist_rsch_dvlp_fulf_cunt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			dist_rsch_dvlp_fulf_amnt: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	})
	
	return true;
}


/*--------------------------------------------------------*
 * 기업 년도별 고용현황 
 *--------------------------------------------------------*/

/* 폼체크 */

function yyyyEmplFormChk(){
	
	$("#form1").validate({
		rules: {
			yyyy: {
				required: true,
				maxlength: 4,
				number:false
			},
			admn_part: {
				required: true,
				maxlength: 5,
				number:true
			},
			offi_part: {
				required: true,
				maxlength: 5,
				number:true
			},
			tech_part: {
				required: true,
				maxlength: 5,
				number:true
			},
			fuct_part: {
				required: true,
				maxlength: 5,
				number:true
			},
			rglr: {
				required: true,
				maxlength: 5,
				number:true
			},
			non_rglr: {
				required: true,
				maxlength: 5,
				number:true
			}
		},
		messages: {
			yyyy: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			admn_part: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			offi_part: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			tech_part: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			fuct_part: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			rglr: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			non_rglr: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "",
				number: "<font color='red'><strong> only Number</strong></font>"
			}
		}
	})
	
	return true;
}


/*--------------------------------------------------------*
 * 기업 생산제품 
 *--------------------------------------------------------*/

/* 폼체크 */

function mnpdStatFormChk(){
	
	$("#form1").validate({
		rules: {
			prdc_cd: {
				required: true
			},
			prdc_nm: {
				required: true,
				maxlength: 100
			}
		},
		messages: {
			prdc_cd: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			prdc_nm: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: ""
			}
		}
	})
	
	return true;
}

$().ready(function() {
	$("#sanc_form").validate({
		rules: {
			s_item: {
				required: true
			},
			sanc_stdt: {
				required: true
			},
			sanc_eddt: {
				required: true
			}
		},
		messages: {
			s_item: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			sanc_stdt: {
				required: "<font color='red'><strong> √</strong></font>"
			},
			sanc_eddt: {
				required: "<font color='red'><strong> √</strong></font>"
			}
		}
	})
	return true;
});	


//제재 정보  등록 수정 
function sancCU(){	
	var add = document.getElementById("InnoAP1");
	for (var j = 0; j < add.GetCount; j++)
	{		
	    document.InnoAP.AddFile(add.GetFileName(j));
	    document.form1["fileTxt"].value = 1;	    	    
	}	
	InnoAPSubmit(document.form1);
}	

function sancInfoDataDel(url){	
	if(confirm(" 삭제하시겠습니까?")){
		location.href=url;
	}
}
