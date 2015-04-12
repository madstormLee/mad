package com.a2m.framework.util;

import java.util.HashMap;
import java.util.Iterator;
import java.io.File;
import java.text.NumberFormat;
import java.text.SimpleDateFormat;
import java.util.List;
import java.util.Map;
import java.util.Calendar;
import java.util.Date;

import javax.servlet.http.HttpServletRequest;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.apache.commons.lang.StringUtils;
import org.w3c.dom.Document;
import org.w3c.dom.NodeList;

public final class ReqUtils {
	public static Map getParameterMap(HttpServletRequest request) {
		Map map = new HashMap();
        try {
            Map paramerterMap = request.getParameterMap();
            Iterator iter = paramerterMap.keySet().iterator();
            String key = null;
            String[] value = null;
            while(iter.hasNext()) {
                key = (String)iter.next();
                value = (String []) paramerterMap.get(key);                
                if(value.length > 1){
                	map.put(key, value);
                }else{
                	map.put(key, value[0]);
                }               
            }
        } catch(Exception e) {
            System.out.println("            <<<ReqUtils - getParameterMap(HttpServletRequest request)>>>");
            System.out.println("            "+e.getMessage());
        }
        return map;
	}
	
	public static Map getParameterMap(HttpServletRequest request, String type) {
		Map map = new HashMap();
		try {
			Map paramerterMap = request.getParameterMap();
			Iterator iter = paramerterMap.keySet().iterator();
			String key = null;
			String[] value = null;
			while(iter.hasNext()) {
				key = (String)iter.next();
				value = (String []) paramerterMap.get(key);
				if(value.length > 1 || type.equals("array")){
					map.put(key, value);
				}else{
					map.put(key, value[0]);
				}               
			}
		} catch(Exception e) {
			System.out.println("            <<<ReqUtils - getParameterMap(HttpServletRequest request)>>>");
			System.out.println("            "+e.getMessage());
		}
		return map;
	}
	
	public static Map getEmptyResult(String resultColumns) {
		Map map = null;
		if(resultColumns != null && !resultColumns.equals("")){
			map = new HashMap();
			String[] columns = StringUtils.split(resultColumns, ",");
			for(int i = 0;i < columns.length;i++){
				map.put(columns[i], "");
			}
		}	
		return map;
	}
	
	/******************************************************************
	 * 널데이터 체크(String 형식)
	 * @param getVal 데이터값  
	 * @param chgdata 널일때 교체할 값
	 ******************************************************************/
	public static String getEmptyResult2(String getVal, String chgdata) {
		String rVal = getVal;
		
		if(getVal == null || getVal.equals("") || getVal.equals("null")){
			rVal = chgdata;
		}
		
		return rVal;
	}
	
	/******************************************************************
	 * 원하는 길이만큼 자르기.(String 형식)
	 * @param str 데이터값  
	 * @param num 자를 길이
	 ******************************************************************/
	public static String cutStr(String str, int num) {
		String tmp = ""; 
		if ( str.length() > num ){
			tmp = str.substring( 0, num ) + "...";
		}else{
			tmp = str;
		}
		return tmp;
	}
	
	/******************************************************************
	 * 널데이터 체크(String 형식)
	 * @param getVal 데이터값  
	 * @param chgdata 널일때 교체할 값
	 ******************************************************************/
	public static String getEmptyResult2(String getVal) {
		String rVal = getVal;
		
		if(getVal == null || getVal.equals("") || getVal.equals("null")){
			rVal = "";
		}
		
		return rVal;
	}
	
	/******************************************************************
	 * 널데이터 체크(Map 형식)
	 * @param map 데이터  
	 ******************************************************************/
	public static Map getResultNullChk(Map map) {
		Map rMap = new HashMap();
		Iterator iter = map.keySet().iterator();
        String key = null;
        String value = null;
        try{
	        while(iter.hasNext()) {
	            key = (String)iter.next();
	            value = ""+map.get(key);
	            
	            if(value!=null&&!"null".equals(value)&&value!=""){	            	
	            	rMap.put(key, value);
	            }else{	 	            	
	            	rMap.put(key, "");	            	
	            }
	        }
        
        }catch(Exception e){
        	System.out.println("getResultNullChk:"+e.getMessage());
        }
			
		return rMap;
	}
	

	/******************************************************************
	 * 현재년도구하기
	 ******************************************************************/
	 public String getCurrYear()
	{
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy");
		String currYear = formatter.format(new java.util.Date());
		return currYear;
	}


	/******************************************************************
	 * 현재날짜
	 ******************************************************************/
	public String getToDate() 
	{
		String thisdate = "";
		try
		{
			java.util.Date todate = new java.util.Date();
			java.text.SimpleDateFormat sysdate = new java.text.SimpleDateFormat("yyyy-MM-dd", java.util.Locale.KOREA);
			thisdate = sysdate.format(todate);
		} catch (Exception e) {}
		return thisdate;
	}
	
	
	/******************************************************************************************************
	* 해당페이지 네비게이션 바를 만든다.
	* @param total 총갯수
	* @param list_per_limit 한페이당 보여주눈 줄수
	* @param page_per_limit 페이지 묶음 단위
	* @param page 현재페이지
	* @return String 형으로 페이지 네비게이션 바를 그린다.
	*******************************************************************************************************/
		public String paging(int total,int list_per_limit,int page_per_limit,int page){
			
			int total_page_temp=total%list_per_limit==0 ? 0:1;
			int total_page = (total/list_per_limit)+total_page_temp;

			if (page==0) page = 1;
			int page_list_temp=page%page_per_limit==0 ? 0:1;
			int page_list =(page/page_per_limit)+page_list_temp-1 ;
			String  navigation="";
			int prev_page=0;
			// 페이지 리스트의 첫번째가 아닌 경우엔 [1]...[prev] 버튼을 생성한다.
			if (page_list>0){
				navigation = "<a href=\"javascript:goPage('1');\" class='urLnkFunction'>["+1+"]</a> ";
				prev_page = page_list * page_per_limit ;
				navigation += "<a href=\"javascript:goPage('"+prev_page+"');\">[◀]</a> ";
			}

			// 페이지 목록 가운데 부분 출력
			int page_end = (page_list + 1) * page_per_limit;
			if (page_end > total_page) page_end = total_page;

			for (int setpage = page_list * page_per_limit + 1; setpage <= page_end; setpage++){
				if(setpage==page_end){
					if (setpage == page){
						navigation += "<font color='#0066CC'><strong>"+setpage+"</strong></font> ";
					}else{
						navigation += "<a href=\"javascript:goPage('"+setpage+"')\" class='urLnkFunction'>"+setpage+"</a> ";
					}
				}else{
					if (setpage == page){
						navigation += "<font color='#0066CC'><strong>"+setpage+"</strong></font> ";
					}else{
						navigation += "<a href=\"javascript:goPage('"+setpage+"')\" class='urLnkFunction'>"+setpage+"</a> ";
					}
				}
			}

			// 페이지 목록 맨 끝이 $total_page 보다 작을 경우에만, [next]...[total_page] 버튼을 생성한다.
			if (page_end < total_page){
				int next_page = (page_list + 1) * page_per_limit + 1;
				navigation += "<a href=\"javascript:goPage('"+next_page+"')\">[▶]</a> ";
				navigation += "<a href=\"javascript:goPage('"+total_page+"');\" class='urLnkFunction'>["+total_page+"]</a>";
			}

			return navigation;
		}

	/******************************************************************
	 * 문자열을 UTF-8 변환
	 * @param str 문자열  
	 ******************************************************************/
	public static String getEncode(String str) {
		try{
			return java.net.URLEncoder.encode(str, "UTF-8");
		}catch (Exception e){
			return "";
		}
	}
	
	 /******************************************************************
	  * 폴더 만들기
	  * @param  
	  ******************************************************************/ 
	public static void upFolder(HttpServletRequest request, String path ) {
		String upFolder = request.getRealPath(path); 
		//System.out.println("upFolder param : "+upFolder);
		File upDir = new File(upFolder);
		if (!upDir.exists()) { 
		//파일디렉토리없으면 만들기
			if(upDir.mkdir()) System.out.println(upFolder+" make ok");
			else System.out.println(upFolder+" make fail!!");
		}
	}

	
	 /******************************************************************
	  * 'YYYYMMDD' 형태의 String형을 Date형으로 만들어 리턴
	  * @param  
	  ******************************************************************/ 
    public static Date stringToDate( String d ) {

        int year = Integer.parseInt(d.substring(0, 4)); 
        int month = Integer.parseInt(d.substring(4, 6)); 
        int day = Integer.parseInt(d.substring(6));

        Calendar cdate = java.util.Calendar.getInstance(); 
        cdate.set(Calendar.YEAR, year); 
        cdate.set(Calendar.MONTH, month); 
        cdate.set(Calendar.DATE, day); 

        Date ddate = cdate.getTime(); // java.sql.Date 가 아님..  
        return ddate;
    }
	 /******************************************************************
	  * System의 현재 날짜를 yyyyMMdd형식으로 반환하는 method 
	  * @param  
	  ******************************************************************/ 
    public static String getCurrentDate()
    {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyyMMdd");
		String currDate = formatter.format(new java.util.Date());
		return currDate;        
    }
    
	/****************************************************************************************************
	*텍스트문자의 공백과 줄내림표시를 html형식으로 변경
	* @param text 텍스트문자
	* @return String html문자
	****************************************************************************************************/
	public String textToHtml(String text){
		String txt = getEmptyResult2(text);
		return txt.replaceAll(" ","&nbsp;").replaceAll("\n","<br>");
	}
	/****************************************************************************************************
	*숫자형 데이터를 회계단위로 표현(10000=>10,000)
	* @param numData 텍스트형 숫자 데이타
	* @return String 변형된 데이타
	****************************************************************************************************/
	public String numFormat(String numData){
		NumberFormat nf=NumberFormat.getInstance();
		String chgDataType="0";
		try{
			chgDataType=nf.format(Long.parseLong(numData));
		}catch(Exception e){
			System.out.println(e.getMessage());
		}
		return chgDataType;
	}
	/****************************************************************************************************
	*yyyymmdd형택의 문자열을 yyyy-mm-dd형태로 변경
	* @param yyyymmdd 텍스트문자
	* @return yyyy-mm-dd 텍스트문자
	****************************************************************************************************/
	public String cvtDate(String yyyymmdd){
		String rval="";
		if(!yyyymmdd.equals("") && yyyymmdd.length() >= 8){
			rval=yyyymmdd.substring(0,4)+"-"+yyyymmdd.substring(4,6)+"-"+yyyymmdd.substring(6,8);
		}
		
		return rval;
	}
	
	/****************************************************************************************************
	*RSS 서비스 데이터를 파싱해서 배열 형태로 돌려줌 
	* @param url RSS서비스 주소
	* @param item 해당 필드 갯수
	* @param start 시작 item 위치
	* @param count 가지고 올 목록갯수
	* @return 2차원배열로 첫번째 위치는 목록갯수 두번째 위치는 필드 위치입니다.
	****************************************************************************************************/
	public String[][] getXmlList(String url,int item,int start,int count){
		String [][] list=null;
		try {
            DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
            DocumentBuilder builder = factory.newDocumentBuilder();
            // parse() 메소드에 들어갈 수 있는 인자 중, 아래처럼 URI String 도 있습니다.
            Document doc = builder.parse(url);
            NodeList rss = doc.getElementsByTagName("rss");
         
            NodeList channel = rss.item(0).getChildNodes();
            
            // _n 변수에 <channel> ~~~ </channel> 속 노드들 정보가 들어갑니다.
            NodeList _n = channel.item(1).getChildNodes();
            list = new String[count][item];
            int l=0;
            for (int i=start; i<(start+count*2); i=i+2) {
                // 예제에서는 RSS 피드중 상단 블로그 정보 부분만 콘솔로 출력해 봅니다.
            	int k=0;
            	for(int j=1;j<(item*2);j=j+2){            		
            		list[l][k] = _n.item(i).getChildNodes().item(j).getTextContent();            		
            		k++;
            	}
            	l++;
            }            
        } catch(Exception e) {
            System.out.println(e.toString());
        }	
        
        return list;
	}	

	/****************************************************************************************************
	*00000000000형택의 문자열을 00-0000-0000 또는 000-0000-0000형태로 변경(전화번호 데이터에 사용)
	* @param 00000000000 텍스트문자
	* @return 00-0000-0000 또는 000-0000-0000 텍스트문자 length의 return값은 int임!!
	****************************************************************************************************/
	public String telNum(String tel){
		String rval="";
		if(!tel.equals("") && 11 == tel.length()){			
			rval=tel.substring(0,3)+"-"+tel.substring(3,7)+"-"+tel.substring(7,11);			
		}else if(!tel.equals("") && 10 == tel.length()){
			if("2".equals(tel.substring(1,2))){				
				rval=tel.substring(0,2)+"-"+tel.substring(2,6)+"-"+tel.substring(6,10);				
			}else{				
				rval=tel.substring(0,3)+"-"+tel.substring(3,6)+"-"+tel.substring(6,10);				
			}
		}else if(!tel.equals("") && 9 == tel.length()){			
			rval=tel.substring(0,2)+"-"+tel.substring(2,5)+"-"+tel.substring(5,9);			
		}else{			
			rval = tel;			
		}		
		return rval;
	}
	/****************************************************************************************************
	*배열형태의 데이터를 특정 구분자 값으로 엮어 String 형태로 만들기
	* @param String[] data 데이터
	* @param String needle 구분자
	* @return String 값
	****************************************************************************************************/
	public String join(String[] data,String needle){
		String rVal="";	
		if(data!=null){
			for(int i=0;i<data.length;i++){
				if(i==0){
					rVal+=data[i];
				}else{
					rVal+=needle+data[i];
				}
			}
		}
		return rVal;
	}
	
	/****************************************************************************************************
	*문자열이 오로지 숫자인지를 확인. true이면 모두 숫자열, false이면 문자열 중의 한 요소는 무조건 문자 포함됨.
	* @param String data 데이터
	* @return boolean 값
	****************************************************************************************************/
	public boolean isInt(String str){
		int size=str.length();
		for(int i=0; i<size ; i++){
			int tmp=(int)str.charAt(i);
			if(tmp>=48 || tmp<=57){
				return true;
			}
		}
		return false;
	}
}