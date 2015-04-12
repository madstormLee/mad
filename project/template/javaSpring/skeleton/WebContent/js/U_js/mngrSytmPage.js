

// 팝업  폼체크 저장,수정	
function popupFormChk() {
	form1.cont.value = myeditor.outputBodyHTML();
	$("#form1").validate({
		rules: {
			tit: {
				required: true,
				maxlength: 500
			},
			stdt: {
				required: true
			},
			eddt: {
				required: true
			},
			popup_size_hori: {
				required: true,
				maxlength: 4,
				number:true
			},
			popup_size_vert: {
				required: true,
				maxlength: 4,
				number:true
			}			
		},
		messages: {
			tit: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>"
			},
			stdt: { 
				required: "<font color='red'><strong> √</strong></font>"
			},
			eddt: { 
				required: "<font color='red'><strong> √</strong></font>"
			},
			popup_size_hori: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			},
			popup_size_vert: {
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: "<font color='red'><strong> 자릿수 초과</strong></font>",
				number: "<font color='red'><strong> only Number</strong></font>"
			}			

		}
	});
	
	return true;
	
}


//게시판  폼체크 저장,수정	
function bbsFormChk() {
	form1.cont.value = myeditor.outputBodyHTML();

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
	
	return true;
}
//설문 기본 정보 등록 폼 체크
// 
function survInfoCheck() {
	$("#form1").validate({
		rules: {
			tit: {
				required: true,
				maxlength: 500
			},
			stdt: {
				required: true
			},
			eddt: {
				required: true
			}			
		},
		messages: {
			tit: { 
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

//설문 기본 정보 등록 폼 체크
//stdt eddt
function survQustCheck() {
	$("#editform").validate({
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
	
	return true;
}

function survQustCheck2(size) {
	var form = "#form"+size;
	$(form).validate({
		rules:{
			surv_item_nm:{	/* 필수 입력사항 */
				required: true
			}
		},
		messages:{
			surv_item_nm:{
				required: "<font color='red'><strong> √</strong></font>"
			}
		}
	});
	return true;
}

/* 등록된 질문 선택 삭제 */
function survInfoDel(){

	var ch = document.form2.surv_info_seq;//getElementById("surv_info_seq");
	//var chk = document.getElementById("surv_info_seq");
	var chk = Integer.parseInt(ch);
	if(chk.length==undefined){
		alert("등록된 질문이 없습니다.");
		return false;
	}else{
		var rs = "";
		for(var i=0; i<chk.length; i++){
			if(chk[i].checked==true){
				rs = "chk";
			}
		}
		
		if(rs==""){
			alert("질문을 선택해주세요.");
			return false;
		}
	}
	
	if(confirm("정말 삭제하시겠습니까?")){
		return true;
	}
	
	return false;
}

// 설문조사 질문 추가 
function addQstn(){
	var chk = document.form1.surv_info_seq;
	if(chk.length==undefined){
		alert("등록된 질문이 없습니다.");
		return false;
	}else{
		var rs = "";
		for(var i=0; i<chk.length; i++){
			if(chk[i].checked==true){
				rs = "chk";
			}
		}
		
		if(rs==""){
			alert("질문을 선택해주세요.");
			return false;
		}
	}
	
	return true;	

}

function Del(url){	
	if(confirm(" 삭제하시겠습니까?")){
		location.href=url;
	}
}


//메일발송  폼체크 저장,수정	
function mailFormChk() {
	$("#form1").validate({
		rules: {
			tit: {
				required: true,
				maxlength: 500
			},
			cont: {
				required: true,
				maxlength: 4000
			}
		},
		messages: {
			tit: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 25자리 이하여야 합니다."
			},
			cont: { 
				required: "<font color='red'><strong> √</strong></font>",
				maxlength: " 2000자 이하만 입력 가능합니다."
			}
		}
	});	
	return true;
}

//실제 메일 발송
function doMailSent(url){	
	if(confirm("메일을 발송하시겠습니까?")){
		location.href=url;
	}
}



