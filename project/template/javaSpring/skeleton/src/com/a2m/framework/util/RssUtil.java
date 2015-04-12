package com.a2m.framework.util;

import java.util.List;

import com.sun.org.apache.xerces.internal.parsers.SAXParser;


public class RssUtil {	
	public static List getRssUrl(String rssUrl)throws Exception {
		  RssXmlHandler handler =  new RssXmlHandler();
		  SAXParser saxParser = new SAXParser();
		  saxParser.setContentHandler( handler );
		  saxParser.parse( rssUrl );

		  return handler.getRssList();
	}
}
