var ContextPath = "";

//게시판  폼체크 저장,수정	
function bbsFormChk() 
{
	form1.cont.value = myeditor.outputBodyHTML();
	return true;
}
$().ready(function(){
	$("#form1").validate({
		rules: {
			tit: {
				required: true,
				maxlength: 500
			}
		},
		messages: {
			tit: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: ""
			}
		}
	});
});


//등록		
function submitOk() {		
	if( confirm( "등록 하시겠습니까?" ) ){
		// 에디터
		document.form1.cont.value = myeditor.outputBodyHTML();
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
		
		form1.cont.value = myeditor.outputBodyHTML();

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