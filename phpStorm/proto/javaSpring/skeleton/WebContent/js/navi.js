//글로벌 네비게이션(2Depth 메뉴그룹)에 대한 마우스 또는 키보드 반응(보임/숨김)설정
function activeGNB(id, tot_mn) {
	for(num=1; num<=tot_mn; num++) document.getElementById('gm'+num).style.display='none'; //D2MG1~D2MG4 까지 숨긴 다음
	document.getElementById(id).style.display='block'; //해당 ID만 보임
}
//로컬 네비게이션(4Depth 메뉴그룹)에 대한 마우스 또는 키보드 반응(보임/숨김)설정
function activeLNB(id, tot_mn) {
	for(num=1; num<=tot_mn; num++) document.getElementById('lm'+num).style.display='none'; //D4MG1~D4MG4 까지 숨긴 다음
	document.getElementById(id).style.display='block'; //해당 ID만 보임
}