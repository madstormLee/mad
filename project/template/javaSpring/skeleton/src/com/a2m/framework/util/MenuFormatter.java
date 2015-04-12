package com.a2m.framework.util;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.util.Iterator;

import org.json.*;

public class MenuFormatter {
	private String getNavigationStringFromJson(){
		String ret = "";
		try{
			File jsonFile = new File("d:/navi.json");
			BufferedReader br = new BufferedReader(new FileReader(jsonFile));
			String line;
			while((line = br.readLine())!=null)
				ret += line;
		} catch(IOException e){
			e.printStackTrace();
		}
		return ret;
	}
	
	public String getMenu(){
		String json = getNavigationStringFromJson();
		String ret = "";
		try{
			JSONObject rootObject = new JSONObject(json);
			Iterator topLevelIterator = rootObject.keys();
			while(topLevelIterator.hasNext()){
				JSONObject topLevelMenu = rootObject.getJSONObject(""+topLevelIterator.next());
				ret += addTopLevelMenu(topLevelMenu);
				if(topLevelMenu.has("subs")){
					ret += "<ul class=\"fall\">";
					JSONObject children = topLevelMenu.getJSONObject("subs");
					Iterator secondLevelIterator = children.keys();
					while(secondLevelIterator.hasNext()){
						JSONObject secondLevelMenu = children.getJSONObject(""+secondLevelIterator.next());
						ret += addSecondLevelMenu(secondLevelMenu);
					}
					ret += "</ul>";
				}
			}
		} catch(Exception e){
			e.printStackTrace();
		}
		
		return ret;
	}
	
	private String addTopLevelMenu(JSONObject j) throws JSONException{
		return "<h3><img src=\"/images/mng/sub/left_menu_ico2.gif\" /><a href=\""+j.getString("href")+"\" style=\"text-decoration: none;\">" + j.getString("label")+"</a></h3>";
	}
	private String addSecondLevelMenu(JSONObject j) throws JSONException{
		return "<li><img src=\"/images/mng/sub/left_menu_ico3.gif\" /><a href=\""+j.getString("href")+"\" style=\"text-decoration: none;\">" + j.getString("label")+"</a></li>";
	}
	
	//old
	public String getMenu2(){
		String json = getNavigationStringFromJson();
		System.out.println("json:\n"+json);
		String ret = "";
		try{
			//first-level
			JSONArray topLevelItem = new JSONArray(json);
			for(int i=0;i<topLevelItem.length();i++){
				JSONObject object = topLevelItem.getJSONObject(i);
				ret += "<h3><img src=\"/images/mng/sub/left_menu_ico2.gif\" /><a href=\""+object.getString("href")+"\" style=\"text-decoration: none;\">" + object.getString("label")+"</a></h3>";

				
				//second-level
				JSONArray secondLevelItem = new JSONArray(object.getJSONArray("subs"));
				if(secondLevelItem!=null && secondLevelItem.length()>0){
					ret += "<ul class=\"fall\">";
					for(int j=0;j<secondLevelItem.length();j++){
						JSONObject secondLevelObject = secondLevelItem.getJSONObject(i);
						ret += "<li>";
						ret += "<img src=\"/images/mng/sub/left_menu_ico3.gif\" />";
						ret += "<a href=\""+ secondLevelObject.getString("href")+"\" style=\"text-decoration: none;\">"+secondLevelObject.getString("label");
						ret += "</a>";
						ret += "</li>";
					}
					
					ret += "</ul>";
				}
				
			}
			//JSONArray topLevelItems = object.get
			
		} catch(JSONException e){
			e.printStackTrace();
		}
		
		return ret;
		
	}
}
