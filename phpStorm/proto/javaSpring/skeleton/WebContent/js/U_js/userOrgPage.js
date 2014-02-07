/***************************************************************************************
 * 파일명	: userOrgPage.js
 * 설명		: 기관 마이페이지
 * 작성자	: 임지현
 * 작성일	: 2010.11.19
 * 수정일	:
 ****************************************************************************************/

$.validator.setDefaults({
	// 서브밋 핸들러
	submitHandler: function() {
	//alert(document.form1);
		if(document.form1.file_yn.value == "Y"){
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


//$().ready(function() {

/* 데이타 삭제 */

	function orgDataDel(url){
		if(confirm("정말 삭제하시겠습니까?")){
			location.href=url;
		}
	}



/*--------------------------------------------------------*
 * 기관 일반현황
 *--------------------------------------------------------*/

// 기관 일반현황 폼 체크
	$().ready(function() {
		$("#org_form").validate({
			rules: {
				buss_no: {
					required: true,
					maxlength: 10,
					minlength: 10,
					number:true
				},
				pwd: {
					required: true,
					equalTo: "#pwd2",
					maxlength: 50,
					number:false
				},
				pwd2: {
					required: true,
					maxlength: 50,
					number:false
				},
				inst_ko_nm: {
					required: true,
					maxlength: 200,
					number:false
				},
				inst_en_nm: {
					required: true,
					maxlength: 200,
					number:false
				},
				copr_no: {
					maxlength: 20
				},
				cptn_nm: {
					required: true,
					maxlength: 20,
					number:false
				},
				open_dt: {
					maxlength: 8,
					number:true
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
				fax2: {
					maxlength: 4,
					number:true
				},
				fax3: {
					maxlength: 4,
					number:true
				},
				web: {
					maxlength: 260
				},
				man_cunt: {
					maxlength: 4,
					number:true
				},
				org_csrt: {
					maxlength: 50
				},
				main_buld: {
					maxlength: 10,
					number:true
				},
				main_buld_grnd: {
					maxlength: 10,
					number:true
				},
				main_buld_fclt: {
					maxlength: 500
				},
				hold_eqip_relt_site: {
					maxlength: 260
				},
				movin_entp_cunt: {
					maxlength: 4,
					number:true
				},
				pont_inst: {
					maxlength: 50
				}
			},
			messages: {
				buss_no: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: " 10자리여야 합니다.",
					minlength: " 10자리여야 합니다.",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				pwd: {
					required: "<font color='red'><strong> √</strong></font>",
					equalTo: "비밀번호가 일치하지 않습니다.",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				pwd2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				inst_ko_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				inst_en_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				copr_no: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				cptn_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				open_dt: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
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
				fax2: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				fax3: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				web: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				man_cunt: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				org_csrt: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				main_buld: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				main_buld_grnd: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				main_buld_fclt: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				hold_eqip_relt_site: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				movin_entp_cunt: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				pont_inst: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				}
			}
		});
	});
	
/*--------------------------------------------------------*
 * 기관 사업현황
 *--------------------------------------------------------*/
	
// 기관 사업현황 폼 체크
	function bussStatFormChk() {
		$("#form1").validate({
			rules: {
				buss_nm: {
					required: true,
					maxlength: 100,
					number:false
				},
				buss_stdt: {
					required: true,
					maxlength: 8,
					number:true
				},
				buss_eddt: {
					required: true,
					maxlength: 8,
					number:true
				},
				buss_ntmy: {
					maxlength: 12,
					number:true
				},
				buss_dtmy: {
					maxlength: 12,
					number:true
				},
				buss_pvfc: {
					maxlength: 12,
					number:true
				}
			},
			messages: {
				buss_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: " 10자리여야 합니다.",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				buss_stdt: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: ""
				},
				buss_eddt: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> Only Number</strong></font>"
				},
				buss_ntmy: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> Only Number</strong></font>"
				},
				buss_dtmy: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> Only Number</strong></font>"
				},
				buss_pvfc: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> Only Number</strong></font>"
				}
			}
		});
		
		return true;
	}
	
/*--------------------------------------------------------*
 * 기관 장비현황
 *--------------------------------------------------------*/
	
// 기관 장비현황 폼 체크
	function eqmtStatFormChk() {
		$("#form1").validate({
			rules: {
				eqmt_ko_nm: {
					required: true,
					maxlength: 100,
					number:false
				},
				eqmt_en_nm: {
					required: true,
					maxlength: 100,
					number:false
				},
				eqmt_desc: {
					required: true,
					maxlength: 4000,
					number:false
				},
				hold_inst: {
					required: true,
					maxlength: 100,
					number:false
				},
				eqmt_chrg: {
					required: true,
					maxlength: 20,
					number:false
				},
				eqmt_link_no: {
					required: true,
					maxlength: 13,
					number:false
				}
			},
			messages: {
				eqmt_ko_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				eqmt_en_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				eqmt_desc: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> Only Number</strong></font>"
				},
				hold_inst: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> Only Number</strong></font>"
				},
				eqmt_chrg: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> Only Number</strong></font>"
				},
				eqmt_link_no: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> Only Number</strong></font>"
				}
			}
		});
		
		return true;
	}

