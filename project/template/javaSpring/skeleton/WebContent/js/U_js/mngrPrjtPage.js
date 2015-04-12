/***************************************************************************************
 * 파일명	: mngrPrjtPage.js
 * 설명		: 관리자 성과등록  스크립트
 * 작성자	: gsy
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

// 팝업  폼체크 저장,수정	
function frutFormChk() {
	$("#form1").validate({
		rules: {
			prdc_nm: {
				required: true,
				maxlength: 200
			}
		},
		messages: {
			prdc_nm: { 
				required: "",
				maxlength: ""
			}
		}
	});
	
	return true;
}
