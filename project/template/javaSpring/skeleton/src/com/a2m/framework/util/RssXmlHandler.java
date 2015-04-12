package com.a2m.framework.util;

import java.io.CharArrayWriter;
import java.util.ArrayList;
import java.util.List;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;


public class RssXmlHandler extends DefaultHandler 
{
	private List rssList;
	private RssDm rssDm;
	
	private CharArrayWriter contents = new CharArrayWriter();
	
	public void startElement(String namespaceURI, String localName, 
			String qName, Attributes attrs) throws SAXException{
			
		contents.reset();
		

		
		if(localName.equals("channel")){		
			rssList = new ArrayList();
		}
		if(localName.equals("item")){		
			rssDm = new RssDm();
		}	
	}

	public void endElement(String namesapceURI, String localName, String qName) 
	    throws SAXException{
		
		if( rssDm != null) {
			if(localName.equals("title")){		
				rssDm.setTitle( contents.toString() );
			}	
			if(localName.equals("link")){		
				rssDm.setLink( contents.toString() );
			}	
			if(localName.equals("description")){		
				rssDm.setDescription( contents.toString() );
			}	
			if(localName.equals("pubDate")){		
				rssDm.setPubdate( contents.toString() );
				rssList.add( rssDm );
			}
			if(localName.equals("category")){		
				rssDm.setCategory( contents.toString() );
			}	
		}
//		System.out.print(contents.toString()+"</"+localName+">\n");
	}

	// characters SAX Event가 발생할 경우에 실행되는 method  
	public void characters(char[] ch, int start, int length) throws SAXException {
		contents.write(ch, start, length);
	}

	// Rss List 반환
	public List getRssList(){
		return rssList;
	}	  
	  
}

