/***************************************************************************************
 * 파일명	: common.js
 * 설명		: 공통
 * 작성자	: 임지현
 * 작성일	: 2010.11.19
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


// 로그인 시 폼 체크
$().ready(function() {
	$("#login").validate({
		rules: {
			user_id: {		//아이디
				required: true,
				maxlength: 20,
				number:false
			},
			pw: {		//비밀번호
				required: true,
				maxlength: 50,
				number:false
			}
			
		},
		messages: {
			user_id: {
				required: "",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			}
			,
			pw: {
				required: "",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			}
		}
	});
});
	
	
// 약관동의 폼 체크
	function joinOkCheck() {
		$("#form1").validate({
			rules: {
				buss_no: {
					required: true,
					maxlength: 10,
					minlength: 10,
					number:true
				},
				pwd: {
					required: true,
					maxlength: 100,
					number:false
				},
				ok:"required"
			},
			messages: {
				buss_no: { 
					required: "",
					maxlength: " 10자리여야 합니다.",
					minlength: " 10자리여야 합니다.",
					number: " Only Number"
				},
				pwd: { 
					required: "",
					maxlength: "",
					number: " Only Number"
				},
				ok:""
			}
		});
		
		return true;
	}
	
	
// 사업자번호 중복체크
	function bussFormChk() {
		$("#form1").validate({
			rules: {
				buss_rgst_no: {
					required: true,
					maxlength: 10,
					minlength: 10,
					number:true
				}
			},
			messages: {
				buss_rgst_no: { 
					required: "",
					maxlength: " 10자리여야 합니다.",
					minlength: " 10자리여야 합니다.",
					number: "<font color='red'>Only Number</font>"
				}
			}
		});
		
		return true;
	}

