package com.a2m.framework.aop;

import java.text.SimpleDateFormat;
import java.util.Date;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.handler.HandlerInterceptorAdapter;

/**
 * DefaultAnnotationHandlerMapping => HandlerInterceptorAdapter를 이용한 
 *  요청 확인용
 *  (실서버 운영 시 제외 대상)
 * @author zero
 * @version 1.0
 */

public class LoggingHandlerAspect extends HandlerInterceptorAdapter{

	private SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd kk:mm:ss");
	
	@Override
	public boolean preHandle(HttpServletRequest request,
			HttpServletResponse response, Object handler) throws Exception {

		String className = handler.getClass().getName();
		String reqUri = request.getRequestURI();
		System.out.println("[C]["+sdf.format(new Date())+"]  <START > - " + className + "("+reqUri+")");
		return true;
	}
	
	@Override
	public void postHandle(HttpServletRequest request,
			HttpServletResponse response, Object handler,
			ModelAndView modelAndView) throws Exception {
		System.out.println("[C]["+sdf.format(new Date())+"]  <VIEW > - " + modelAndView.getViewName());
		//System.out.println("[C]["+sdf.format(new Date())+"]  <MODEL> - " + modelAndView.getModel());
	}
	
	@Override
	public void afterCompletion(HttpServletRequest request,
			HttpServletResponse response, Object handler, Exception ex)
			throws Exception {
		String className = handler.getClass().getName();
		if(ex != null){
			System.out.println("[C]["+sdf.format(new Date())+"] Exception Occured : " + ex.getMessage());
		}
		
		System.out.println("[C]["+sdf.format(new Date())+"]  <END   > - " + className);		
	}
}
