package com.a2m.framework.util;

import java.util.Locale;

import org.springframework.context.MessageSource;
import org.springframework.context.NoSuchMessageException;

public final class MsgUtils {
	
	private static MessageSource msgSource;
	
	public void setMsgSource(MessageSource msgSource){
		MsgUtils.msgSource = msgSource;
	}
	
	public static String getMessage(String msgId){
		String msg = null;
		try {
			msg = msgSource.getMessage("welcome", new Object[0], Locale.getDefault()); 
		}catch(NoSuchMessageException e){
			System.out.println("            <<<MsgUtils - getMsg(String msgId)>>>");
            System.out.println("            "+e.getMessage());
		}
		return msg;
	}
}
