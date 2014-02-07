var ContextPath = "/";


function js_mngrbuss00Check()
{
	//form1.annc_cont.value = myeditor.outputHTML();
	//return true;
}
//타당성체크
$().ready(function(){
	$("#form1").validate({
		rules: {
			nm: {		//성명
				required: true,
				maxlength: 50,
				number:false
			},
			regno: {		//주민번호
				required: true,
				maxlength:13,
				number:true
			},
			ti_prjt_ptcp: {		//본과제참여율
				required: false,
				maxlength:10,
				number:true
			},
			ta_prjt_ptcp: {		//타과제참여율
				required: false,
				maxlength:10,
				number:true
			},
			get_yyyy: {		//취득년도
				required: true,
				maxlength:15,
				number:true
			},
			sal: {		//연봉
				required: false,
				maxlength:15,
				number:true
			}
		},
		messages: {
			nm: {		//성명
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			regno: {		//주민번호
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			ti_prjt_ptcp: {		//본과제참여율
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			ta_prjt_ptcp: {		//타과제참여율
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			get_yyyy: {		//취득년도
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'>Only Number</font>"
			},
			sal: {		//연봉
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
		// 에디터
		//form1.annc_cont.value = myeditor.outputHTML();

		// 파일첨부
		return InnoAPSubmit(document.form1);
	}else{
		return false;
	}		
}

