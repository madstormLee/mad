var root="http://" + document.location.host ;
function menu(fcode,fnum){
	var page="",num="";
	switch(fcode){
		case 1://과제수행변경
			switch(fnum){
				case 0:
					page="/U01/U01_01/V_mod_01_l.php";break;						
		    }
			break;
		case 2://과제평가
			switch(fnum){
				case 0:
					page="/U02/U02_01/V_val_01_l.php";break;				
			}
			break;
		case 3://과제선정
			switch(fnum){
				case 0:
					page="/U03/U03_01/V_sel_01_l.php";break;				
			}
			break;
		case 4://고객지원
			switch(fnum){
				case 0:
					page="/U04/U04_01/V_bod_01_l.php";break;				
         	}
			break;
		case 5://연구회
			switch(fnum){
				case 0:
					page="/U05/U05_01/V_com_01_l.php";break;				
			}
			break;	
		case 6://설문조사
			switch(fnum){
				case 0:
					page="/U06/U06_01/V_que_01_l.php";break;				
			}
			break;	
		case 7://로그인
			switch(fnum){
				case 0:
					page="/U07/U07_01/V_mem_01_l.php";break;				
			}
			break;	
		case 8://사이트맵
			switch(fnum){
				case 0:
					page="/U08/U08_01/V_map_01_l.php";break;				
			}
			break;	
	}
	location.href=root+page;
}

