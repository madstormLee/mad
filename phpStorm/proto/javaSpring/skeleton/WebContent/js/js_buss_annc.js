var ContextPath = "";

//달력
$(function() {
	
	var dates = $( "#annc_stdt, #annc_eddt" ).datepicker({
		defaultDate: null,
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: "yymmdd",
		showOtherMonths: true,
		selectOtherMonths: true,
		showOn: "button",
		buttonImage: "/A_img/common/M_btn/btn_cal.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		onSelect: function( selectedDate ) {
			var option = this.id == "annc_stdt" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	
});

function js_mngrbuss00Check()
{
	form1.annc_cont.value = myeditor.outputBodyHTML();
	return true;
}
//타당성체크
$().ready(function(){
	$("#form1").validate({
		rules: {
			buss_yyyy:{	// 사업년도
				required: true
			},
			annc_nm: { 	//공고명
				required: true,
				maxlength:500,
				number:false
			},
			annc_stdt: {		//접수시작일
				required: true,
				maxlength:8,
				number:true
			},
			annc_eddt: {		//접수종료일
				required: true,
				maxlength:8,
				number:true
			}
		},
		messages: {
			buss_yyyy: { // 사업년도
				required: "<font color='red'><strong> √</strong></font>"
			},
			annc_nm: { //공고명
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			annc_stdt: {		//접수시작일
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			annc_eddt: {		//접수종료일
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 자릿수 초과 ",
				number: "<font color='red'>Only Number</font>"
			},
			buss_dvsn: {	// 사업구분
				required: "<font color='red'><strong> √</strong></font>"
			}
		}
	});
});


//등록		
function submitOk() {		
	if( confirm( "등록 하시겠습니까?" ) ){
		// 에디터
		document.form1.annc_cont.value = myeditor.outputBodyHTML();
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
		
		form1.annc_cont.value = myeditor.outputBodyHTML();

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

/* 사업분류 대분류 선택시 -작성 수정 용
function dvsnChg1(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=4";
	var name = "buss_dvsn";
	var opt  = "select";			
	sendRequest( url, name, opt );
}

function dvsnChg2(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=5";
	var name = "buss_cd";
	var opt  = "text";			
	sendRequest( url, name, opt );
}

/* 사업분류 대분류 선택시 - 검색박스 용
function dvsnChgSch(val){
	var url	 = ContextPath + "/common/mngr_selXml00_t.do?code="+val+"&flag=4";
	var name = "sch_buss";
	var opt  = "select";			
	sendRequest( url, name, opt );
}
*/