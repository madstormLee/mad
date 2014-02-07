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
			prjt_no: {		//과제번호
				required: true,
				maxlength: 20,
				number:false
			},
			buss_no: {		//사업자번호
				required: true,
				maxlength:10,
				number:true
			},
			altr_req_date: {		//변경요청일자
				required: true,
				maxlength:12,
				number:true
			},
			altr_resn: {		//변경사유
				required: true,
				maxlength: 2000,
				number:false
			},
			altr_req_cont: {	//변경요청사항
				required: true,
				maxlength: 2000,
				number:false
			},
			aprv_yn:{		//승인여부
				required: true,
				number:false
			},
			altr_pre_cont:{		//변경전내용
				required: true,
				maxlength: 4000,
				number:false
			},
			altr_aft_cont:{		//변경후내용
				required: true,
				maxlength: 4000,
				number:false
			}
		},
		messages: {
			prjt_no: { //과제번호
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			buss_no: { //사업자번호
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			altr_req_date: { //변경요청일자
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			altr_resn: { //변경사유
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			altr_req_cont: {	//변경요청사항
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			aprv_yn:{	//승인여부
				required: "<font color='red'><strong> √</strong></font>",
				number: "<font color='red'>Only Number</font>"
			},
			altr_pre_cont:{	//변경전내용
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			altr_aft_cont:{	//변경후내용
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			}
		}
	});
});

$(function() {
	$( "#altr_req_date" ).datepicker({
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
$( "#altr_proc_date" ).datepicker({
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
})
;
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

// 수정 메소드
function upd() {		
	if(confirm("수정하시겠습니까?")){
		var obj = document.form1;
		
		//form1.annc_cont.value = myeditor.outputHTML();

			for (var i = 0; i < document.InnoAP.GetCount; i++) {
				// 사용자가 제거하지 않은 임시 파일의 경우
				// g_ExistFiles 배열에서 해당 아이디값을 키로 갖는
				// 변수의 플래그를 true 로 설정 한다.
				if (document.InnoAP.IsTempFile(i)) {						
					g_ExistFiles[document.InnoAP.GetFileID(i)] = true;
				}
			}				
			for (var key in g_ExistFiles) {					
				// 임시파일의 id 를 각각
				// exist_file 과 deleted_file 변수에 배열형태로 담아 전송한다.
				if (g_ExistFiles[key] == true) {						
					document.InnoAP.AppendPostData("exist_file", key);
				}
				else {
					document.InnoAP.AppendPostData("deleted_file", key);
				}
			}

			var ret = InnoAPSubmit(obj);
			
			// 리스트에 파일이 없어 form이 직접 전송 되는 경우
			if (ret == true) {
				var oForm = document.edit_form;
				for (var key in g_ExistFiles) {
					// form에 지워진 파일의 수 만큼 key를 추가한다.
					var oInput  = document.createElement('<input type="hidden" name="deleted_file" value="' + key + '">');
					alert(oInput);
					oForm.insertAdjacentElement("afterBegin", oInput);
				}
			}
	
			return ret;		
	}

}

//삭제
function Del(url){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href=url;
	}
}

$.validator.setDefaults({
	// 서브밋 핸들러
	submitHandler: function() {		
		var mode = document.form1.mode.value;
		if( mode == "INSERT" ){
			submitOk();	
		}else if ( mode == "UPDATE" ){
			upd();
		}
	},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});	
