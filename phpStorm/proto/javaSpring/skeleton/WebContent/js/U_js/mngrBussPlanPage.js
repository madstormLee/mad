/***************************************************************************************
 * 파일명	: mngrBussPlanPage.js
 * 설명		: 관리자 사업계획  
 * 작성자	: 
 * 작성일	: 2011.02.10
 ****************************************************************************************/

//일정관리    폼체크 저장,수정	
function planChk() {	
	form1.cont.value = myeditor.outputBodyHTML();
	$("#form1").validate({
		rules: {
			scdl_nm: {
				required: true,
				maxlength: 200
			},
			stdt: {
				required: true
			},
			eddt: {
				required: true
			}			
		},
		messages: {
			scdl_nm: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: ""
			},
			stdt: { 
				required: "<font color='red'><strong> √</strong></font>"
			},
			eddt: { 
				required: "<font color='red'><strong> √</strong></font>"
			}
			
		}
	});
	
	return true;
}

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
