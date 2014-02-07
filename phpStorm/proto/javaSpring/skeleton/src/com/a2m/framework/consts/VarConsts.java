package com.a2m.framework.consts;

public class VarConsts {
	/* ======================================= SESSION */
	/**
	 *  종류 = SESSION<br>
	 *  타입 = String<br>
	 *  값   = 'SESSION_USER' 
	 */	
	public static final String SESS_USER = "SESSION_USER";
	
	/* ======================================= MODE */
	/**
	 *  종류 = MODE <br>
	 *  타입 = String <br>
	 *  값   = '파일저장경로'<br> 
	 *  설명 = 파일디렉토리 설정
	 */
	public static final String FILE_PATH = "/file";
	/**
	 *  종류 = MODE <br>
	 *  타입 = String <br>
	 *  값   = '기업DB 실서버 파일경로'<br> 
	 *  설명 = 파일디렉토리 설정
	 */
	public static final String EB_FILE_FULLPATH = "D:/EB/file";
	/**
	 *  종류 = MODE <br>
	 *  타입 = String <br>
	 *  값   = 'INSERT'<br> 
	 *  설명 = 등록모드 처리
	 */
	public static final String MODE_I = "INSERT";
	/**
	 *  종류 = MODE  <br>
	 *  타입 = String  <br>
	 *  값   = 'UPDATE' <br> 
	 *  설명 = 수정모드 처리
	 */	
	public static final String MODE_U = "UPDATE";
	/**
	 *  종류 = MODE<br>
	 *  타입 = String<br>
	 *  값   = 'DELETE'<br> 
	 *  설명 = 삭제모드 처리
	 */	
	public static final String MODE_D = "DELETE";
	/**
	 *  종류 = MODE<br> 
	 *  타입 = String<br> 
	 *  값   = 'DELETE_ALL' <br>
	 *  설명 = 관련데이터 전체 삭제 모드 처리
	 */
	public static final String MODE_DA = "DELETE_ALL";
	/**
	 *  종류 = MODE<br>
	 *  타입 = String<br>
	 *  값   = 'SAVE'<br> 
	 *  설명 = 등록 또는 수정(쿼리에서 분기하여 프로시저로 처리) 모드 처리
	 */
	public static final String MODE_S = "SAVE";	
	
	
	public static final String FILE_AGMT ="AGMT"; //협약변경체결
}
