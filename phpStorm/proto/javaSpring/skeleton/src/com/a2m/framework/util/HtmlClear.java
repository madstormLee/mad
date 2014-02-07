package com.a2m.framework.util;

import java.io.UnsupportedEncodingException;

public class HtmlClear {
	
    public static String sub_String(String title, int max) {
	  	  int strlen = max;		
	  	  int bylen = 0;
	  	  char c;
	  	  int c_lenc = title.length();

  		  if (c_lenc > max - 1 ) {
  			  strlen = 0;
  			  for (int x = 0 ; bylen < (max - 1) * 2 && strlen < c_lenc ; x++) {
   			    c = title.charAt(strlen);
  			    bylen++;
  			    strlen++;
  	           if ( c  >  255  || (c > 64 && c < 91)) bylen++;
     	           }
  	      }
  					  
  		  if (c_lenc > strlen) {
  			 title = title.substring(0, strlen) + "..";
  		  }

  		  return title;
	  }	
}