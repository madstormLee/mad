package com.a2m.framework.util;

import javax.mail.*;
import javax.mail.internet.*;
import javax.activation.*;
import com.sun.mail.smtp.*;
import java.util.*;
import java.io.*;

import java.rmi.RemoteException;
/************************************************************************************************************
* 메일보내기 관리하는 클래스
**************************************************************************************************************/
public class SendMail {
	private String baseHost="webmail.a2m.co.kr";
	private String baseId="wlgusigo87";
	private String basePw="wlgus87";
	private int baseSendType=1;
	private String baseFrom="대전테크노파크<admin@a2m.co.kr>";
	private String err="";

	public SendMail(){
	}
/************************************************************************************************************
* 메일보내기
*
* @ param to : 받는사람
* @ param from : 보내는 사람
* @ param msgSubj : 제목
* @ param msgText : 본문내용
* @ param host : 보내는 메일서버
* @ param id : 인증아이디
* @ param pw : 인증비번
* @ param sendType : 보내는 형식
* @ return : 성공여부
**************************************************************************************************************/
	public boolean mailSend(String to, String from, String msgSubj,String msgText,String host,String id,String pw,int sendType) throws RemoteException {
	
		boolean value=false;
		try {
			from=new String(from.getBytes("KSC5601"),"8859_1");
			to=new String(to.getBytes("KSC5601"),"8859_1");
			Properties props = new Properties();
			props.put("mail.smtp.host", host);
			props.put("mail.smtp.auth", "true");
			MyAuthenticator auth = new MyAuthenticator(id, pw);
			Session sess = Session.getInstance(props, auth);
			Message msg = new MimeMessage(sess);
			msg.setFrom(new InternetAddress(from));
			InternetAddress[] address = {new InternetAddress(to)};
			msg.setRecipients(Message.RecipientType.TO, address);
			msg.setSubject(msgSubj);
			msg.setSentDate(new Date());
			switch(sendType){
				case 1:
					msg.setContent(msgText,"text/html; charset=euc-kr"); // HTML 형식
					break;
				default:			
					msg.setText(msgText); // text 형식
			}
			Transport.send(msg);
			value=true;
		} catch (SendFailedException sfe) {	
			err=err+sfe.toString()+"\n";		
			System.out.println("원인1:"+err);
		} catch (MessagingException mex) {			
			err=err+mex.toString()+"\n";
			System.out.println("원인2:"+err);			
		} catch(Exception e){
			e.printStackTrace();
		}
		return value;
	}
/************************************************************************************************************
* 메일보내기
*
* @ param to : 받는사람
* @ param msgSubj : 제목
* @ param msgText : 본문내용
* @ return : 성공여부
**************************************************************************************************************/
	public boolean mailSend(String to, String msgSubj,String msgText) throws RemoteException {
		return mailSend( to, baseFrom, msgSubj, msgText, baseHost, baseId, basePw, baseSendType);
	}
/************************************************************************************************************
* 파일을 내용을 String 형으로 변환
*
* @ param path : 파일위치
* @ return : 파일내용
**************************************************************************************************************/
	public String fileToStr(String path) throws RemoteException {
		StringBuffer result = new StringBuffer(); 
		try { 
			File newFile =new File(path);
			if(newFile.isFile()){
				BufferedReader in = new BufferedReader (new InputStreamReader(new FileInputStream(newFile))); 
				while (in.ready()){ 
					result.append(in.readLine()); 
					result.append(System.getProperty("line.separator")); 
				} 
				in.close(); 
			}else{
				result.append("파일이 존재하지 않습니다.");
			}
		}catch (Exception e) { 
			e.printStackTrace(); 
		} 
		return result.toString();
	}

	public void setBaseHost(String host){
		baseHost=host;
	}
	public void setBaseId(String id){
		baseId=id;
	}
	public void setBasePw(String pw){
		basePw=pw;
	}
	public void setBaseSendType(int type){
		baseSendType=type;
	}
	public void setBaseFrom(String from){
		baseFrom=from;
	}
	public String getErr(){
		return err;
	}

	
}