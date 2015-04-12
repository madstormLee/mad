/***************************************************************************************
 * 파일명	: mngrMembPage.js
 * 설명		: 회원 DB
 * 작성자	: 
 * 작성일	: 
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


// 회원 일반정보 폼 체크
	function membFormChk() {
		$("#form1").validate({
			rules: {
				nm_ko: {
					required: true,
					maxlength: 20,
					number:false
				},				
				pwd: {
					required: true,
					maxlength: 20
				},
				nm_en: {
					required: true,
					maxlength: 20,
					number:false
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
					required: true
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
				},
				rgst_id:{
					required: true					
				}
			},
			messages: {
				nm_ko: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number: "<font color='red'><strong> only Number</strong></font>"
				},
				pwd: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength:"<font color='red'><strong> 자릿수 초과</strong></font>"
				},				
				nm_en: {
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
					required: "<font color='red'><strong>√</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				clpn_no2: {
					required: "<font color='red'><strong>√</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				clpn_no3: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				eml: {
					required: "<font color='red'><strong> 이메일형식이 올바르지 않습니다.</strong></font>"
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
				},
				rgst_id:{
					required: "<font color='red'><strong> √</strong></font>"				
				}
			}
		});	
		
	}
	
	
	// 아이디 중복체크
	function doubleChk() {	
		$("#form1").validate({
			rules: {
				rgst_id: {
					required: true,
					maxlength: 10,
					minlength: 5
				}
			},
			messages: {
				rgst_id: { 
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 10자리여야 합니다.</strong></font>",
					minlength: "<font color='red'><strong> 길게해주세요.</strong></font>"
				}
			}
		});
		
		return true;
	}	
	
	
	//	var obj = document.form1;		
	//form1.annc_cont.value = myeditor.outputHTML();
	
	//ID 찾기
	function searchId() {	
		$("#form1").validate({
			rules: {
				eml: {
					required: true,
					maxlength: 20
				},
				name: {
					required: true,
					maxlength: 20
				}				
			},
			messages: {
				eml: { 
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 20자리여야 합니다.</strong></font>"
				},
				name: { 
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 20자리여야 합니다.</strong></font>"
				}
				
			}
		});
		
		return true;
	}	
	
	//PW 찾기
	function searchPw() {	
		$("#form2").validate({
			rules: {
				rgst_id: {
					required: true,
					maxlength: 10
				},
				eml: {
					required: true
				}				
			},
			messages: {
				rgst_id: { 
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 10자리여야 합니다.</strong></font>"
				},
				eml: { 
					required: "<font color='red'><strong> √</strong></font>"
				}
				
			}
		});
		
		return true;
	}	

	
	//약관 동의 
	function formChk() {	
		$("#form1").validate({
			rules: {
				name: {
					required: true,
					maxlength: 10
				},
				juminNo1: {
					required: true,
					maxlength: 6,
					number:true
				},
				juminNo2: {
					required: true,
					maxlength: 7,
					number:true
				}
			},
			messages: {
				name: { 
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 10자리여야 합니다.</strong></font>"
				},
				juminNo1: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				},
				juminNo2: {
					required: "<font color='red'><strong> √</strong></font>",
					maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
					number:"<font color='red'><strong> only Number</strong></font>"
				}			}
		});		
		
		return true;
	}				
	