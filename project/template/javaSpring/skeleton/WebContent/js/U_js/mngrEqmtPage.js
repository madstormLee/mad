/***************************************************************************************
 * 파일명	: mngrEqmtPage.js
 * 설명		: 장비DB
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

//장비 DB  폼체크 저장,수정	
function eqmtFormChk() {     
	$("#form1").validate({
		rules: {
			eqmt_ko_nm: {
				required: true,
				maxlength: 200
			},
			hold_inst: {
				required: true
			},
			used: {
				required: true
			},
			eqmt_sts: {
				required: true
			}			
		},
		messages: {
			eqmt_ko_nm: { 
				required: "",
				maxlength: ""
			},
			hold_inst: { 
				required: ""
			},
			used: { 
				required: ""
			},
			eqmt_sts: { 
				required: ""
			}
		}
	});
	
	return true;
}

//장비활용내역  사업자명 검색 
function bussFormChk() {
	$("#form1").validate({
		rules: {
		word: {
				required: true,
				maxlength: 100
			}
		},
		messages: {
			word: { 
				required: "",
				maxlength: ""
			}
		}
	});
	
	return true;
}	
	
//장비활용내역  폼체크 저장,수정	
function eqmtHistFormChk() {
	$("#form1").validate({
		rules: {
			eqmt_no: {
				required: true,
				maxlength: 100
			},
			eqmt_rundd: {
				required: true,
				maxlength: 10,
				number:true
			},
			eqmt_runtm: {
				required: true,
				maxlength: 2,
				number:true
			},
			hold_inst: {
				required: true
			}
		},
		messages: {
			eqmt_no: { 
				required: "",
				maxlength: ""
			},
			eqmt_rundd: { 
				required: "",
				maxlength: "",
				number:"" 
			},
			eqmt_runtm: { 
				required: "",
				maxlength: "",
				number:""
			},
			hold_inst: { 
				required: ""
			}
		}
	});
	
	return true;
}


function doDataDel(url){	
	if(confirm(" 삭제하시겠습니까?")){
		location.href=url;
	}
}

function doCreate(){		
	var add = document.getElementById("InnoAP1");
	for (var j = 0; j < add.GetCount; j++){	
		document.InnoAP.AddFile(add.GetFileName(j));
	    document.form1["fileTxt"].value = 1;	    
	}	
	InnoAPSubmit(document.form1);
}

//장비활용내역 년 검색
function searchRunY(val){	
	var yyyy = val;
	var url	 = 'mngr_eqmtUseHist00_i.do?yyyy='+yyyy;	
	location.href=url;
}

//장비활용내역 월 검색
function searchRunM(mm){
	var i = form1.yyyy.selectedIndex;
	var yyyy = document.form1.yyyy.options[i].value;
	var mm = mm;
	var url	 = 'mngr_eqmtUseHist00_i.do?yyyy='+yyyy+"&amp;mm="+mm;	
	location.href=url;
}