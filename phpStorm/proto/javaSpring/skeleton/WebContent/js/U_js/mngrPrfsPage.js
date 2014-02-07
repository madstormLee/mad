/***************************************************************************************
 * 파일명	: mngrPrfsPage.js
 * 설명		: 전문가 DB
 * 작성자	: 임지현
 * 작성일	: 2010.11.25
 * 수정일	:
 ****************************************************************************************/

$.validator.setDefaults({
	// 서브밋 핸들러
	//submitHandler: function() {},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});


//$().ready(function() {

/* 데이타 삭제 */

	function prfsDataDel(url){
		if(confirm("정말 삭제하시겠습니까?")){
			location.href=url;
		}
	}

/*--------------------------------------------------------*
 * 전문가 일반정보
 *--------------------------------------------------------*/

// 전문가 일반정보 폼 체크
	function prfsInfoFormChk() {
		$("#form1").validate({
			rules: {
				nm_ko: {
					required: true,
					maxlength: 20,
					number:false
				},
				nm_en: {
					required: true,
					maxlength: 20,
					number:false
				},
				rgst_no1: {
					required: true,
					maxlength: 6,
					number:true
				},
				rgst_no2: {
					required: true,
					maxlength: 7,
					number:true
				},
				link_no1: {
					maxlength: 4,
					number:true
				},
				link_no2: {
					maxlength: 4,
					number:true
				},
				link_no3: {
					maxlength: 4,
					number:true
				},
				clpn_no1: {
					required: true,
					maxlength: 4,
					number:true
				},
				clpn_no2: {
					required: true,
					maxlength: 4,
					number:true
				},
				clpn_no3: {
					required: true,
					maxlength: 4,
					number:true
				},
				eml: {
					email: true
				},
				addr_post_no: {
					required: true,
					maxlength: 7,
					number:false
				},
				addr1: {
					required: true,
					maxlength: 100
				},
				addr2: {
					required: true,
					maxlength: 100
				},
				fnl_mjor: {
					required: true,
					maxlength: 100
				},
				blng_inst_nm: {
					required: true,
					maxlength: 100,
					number:false
				}
			},
			messages: {
				buss_no: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: " 10자리여야 합니다.",
					minlength: " 10자리여야 합니다.",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				nm_ko: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				nm_en: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				rgst_no1: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				rgst_no2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				link_no1: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				link_no2: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				link_no3: {
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				clpn_no1: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				clpn_no2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				clpn_no3: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				eml: {
					email: "<font color='red'><strong> 이메일형식이 올바르지 않습니다.</strong></font>"
				},
				addr_post_no: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				addr1: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				addr2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				fnl_mjor: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				blng_inst_nm: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				}
			}
		});
		return true;
	}
	
	
	/* 학력 입력 폼 체크 */

	function scshFormChk(){
		$("#form1").validate({
			rules:{
				edu_stdt:{
					required: true,
					maxlength: 8,
					number:true
				},
				edu_eddt:{
					required: true,
					maxlength: 8,
					number:true
				},
				schl_nm:{
					required: true,
					maxlength: 100,
					number:false
				},
				mjor:{
					required: true,
					maxlength: 100,
					number:false
				},
				cmpl_degr:{
					required: true,
					number:false
				},
				degr_thes_nm:{
					maxlength: 200
				}
			},
			messages:{
				edu_stdt:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				edu_eddt:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				schl_nm:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				mjor:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				cmpl_degr:{
					required: "<font color='red'><strong> √</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				degr_thes_nm:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				}
			}
		});
	
	}
	
	/* 경력 및 겸임활동 입력 폼 체크 */
	
	function crerFormChk(){
		$("#form1").validate({
			rules:{
				work_stdt:{
					required: true,
					maxlength: 8,
					number:true
				},
				work_eddt:{
					required: false,
					maxlength: 8,
					number:true
				},
				work:{
					required: true,
					maxlength: 50
				},
				work_dptm:{
					required: true,
					maxlength: 50
				},
				duty:{
					required: true,
					maxlength: 50
				},
				work_cont:{
					required: true,
					maxlength: 500
				}
			},
			messages:{
				work_stdt:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				work_eddt:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				work:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				work_dptm:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				duty:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				work_cont:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				}
			}
		});
		
	}
	
	
	/* 연구논문 및 저서 입력 폼 체크 */
	
	function rschAuthFormChk(){
		$("#form1").validate({
			rules:{
				rsch_tit:{
					required: true,
					maxlength: 500,
					number:false
				},
				pblc_yyyy:{
					required: true,
					maxlength: 4,
					number:true
				},
				pblc_mm:{
					required: true,
					maxlength: 2,
					number:true
				},
				pbls:{
					required: true,
					maxlength: 100
				},
				thes_no:{
					maxlength: 20
				},
				main_auth:{
					maxlength: 20
				},
				cath:{
					maxlength: 50
				},
				crsp:{
					maxlength: 50
				}
			},
			messages:{
				rsch_tit:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				pblc_yyyy:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				pblc_mm:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				pbls:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				thes_no:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				main_auth:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				cath:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				crsp:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				}
			}
		});
	}
	
	
	/* 자격증 및 포상 입력 폼 체크 */
	
	function lcnsFormChk(){
		$("#form1").validate({
			rules:{
				dvsn:{
					required: true,
					maxlength: 8,
					number:false
				},
				get_yyyy:{
					required: true,
					maxlength: 4,
					number:true
				},
				lcns_nm:{
					required: true,
					maxlength: 100
				},
				pblc_inst:{
					required: true,
					maxlength: 100
				}
			},
			messages:{
				dvsn:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				get_yyyy:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				lcns_nm:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				pblc_inst:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				}
			}
		});
	}
	
	
	
	/* 학회 및 협회활동 입력 폼 체크 */
	
	function asscAtFormChk(){
		$("#form1").validate({
			rules:{
				stdt:{
					maxlength: 8,
					number:true
				},
				eddt:{
					maxlength: 8,
					number:true
				},
				assc_nm:{
					required: true,
					maxlength: 100
				},
				pstn:{
					maxlength: 50
				},
				chrg_work:{
					maxlength: 200
				}
			},
			messages:{
				stdt:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				eddt:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				assc_nm:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				pstn:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				chrg_work:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				}
			}
		});
	}
	
	
	
	/* 정부출연과제수행실적 입력 폼 체크 */
	
	function gvmtRsltFormChk(){
		$("#form1").validate({
			rules:{
				buss_nm:{
					maxlength: 100,
					number:false
				},
				prjt_no:{
					maxlength: 20,
					number:false
				},
				prjt_nm:{
					required: true,
					maxlength: 200
				},
				stdt:{
					maxlength: 8,
					number:true
				},
				eddt:{
					maxlength: 8,
					number:true
				},
				gvmt_supp:{
					maxlength: 12,
					number:true
				},
				sprt_inst:{
					maxlength: 50
				}
			},
			messages:{
				buss_nm:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				prjt_no:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				prjt_nm:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				stdt:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				eddt:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				gvmt_supp:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				sprt_inst:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				}
			}
		});
	}
	
	/* 지적재산권 입력 폼 체크 */
	
	function inteFormChk(){
		$("#form1").validate({
			rules:{
				dvsn:{
					required: true
				},
				lcns_rgst_no:{
					maxlength: 20,
					number:false
				},
				lcns_rgst_dt:{
					required: true,
					maxlength: 8,
					number:true
				},
				lcns_nm:{
					required: true,
					maxlength: 300
				},
				invt_man:{
					maxlength: 10
				},
				rgst_man:{
					maxlength: 100
				}
			},
			messages:{
				dvsn:{
					required: "<font color='red'><strong> √</strong></font>"
				},
				lcns_rgst_no:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				lcns_rgst_dt:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				lcns_nm:{
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				invt_man:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				},
				rgst_man:{
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
				}
			}
		});
	}
	
	
	
/* 평가위원 신청정보  입력 폼 체크 */

function cmitFormChk(){
	$("#form1").validate({
		rules:{		
			ord_0:{
				required: true,
				maxlength: 20
			},
			keyw:{
				required: true,
				maxlength: 250
			}
		},
		messages:{
			ord_0:{
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			},
			keyw:{
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			}
			
		}
	});
}
	
function doDataDel(url){	
	if(confirm(" 삭제하시겠습니까?")){
		location.href=url;
	}
}	
//위원 제재 정보 
function cmitRestnChk(){
	$("#form1").validate({
		rules:{
			cmit_assm:{
				required: true
			},		
			restn_stdt:{
				required: true,
				maxlength: 8,
				number:true
			},
			restn_eddt:{
				required: true,
				maxlength: 8,
				number:true
			},
			restn_cont:{
				maxlength: 200
			}			
		},
		messages:{
			restn_stdt:{
				required: "<font color='red'><strong> √</strong></font>"
			},
			restn_stdt:{
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>"
			},
			restn_eddt:{
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number:"<font color='red'><strong> only Number</strong></font>"
			},
			restn_eddt:{
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			}			
		}
	});
}		