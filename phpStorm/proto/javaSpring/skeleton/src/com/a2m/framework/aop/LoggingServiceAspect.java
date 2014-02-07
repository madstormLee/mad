package com.a2m.framework.aop;

import java.text.SimpleDateFormat;
import java.util.Date;

import org.aspectj.lang.JoinPoint;
import org.aspectj.lang.annotation.After;
import org.aspectj.lang.annotation.AfterReturning;
import org.aspectj.lang.annotation.AfterThrowing;
import org.aspectj.lang.annotation.Aspect;
import org.aspectj.lang.annotation.Before;

/**
 * '@Aspect'를 이용하여 Dao클래스가 처리되는 과정을 로그로 보여준다 
 *  (실서버 운영 시 제외 대상)
 * @author zero
 * @version 1.0
 */
@Aspect
public class LoggingServiceAspect {
	private SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd kk:mm:ss");
	
	@Before("execution(public * com.a2m.module..*Service.*()) || execution(public * com.a2m.module..*Service.*(..))")
	public void beforeLogging(JoinPoint joinPoint) {
		String className = joinPoint.getTarget().getClass().getName();
		String methodName = joinPoint.getSignature().getName();
		System.out.println("[S]["+sdf.format(new Date())+"]  <START > - " + className + " > " + methodName);
	}

	@AfterReturning(pointcut="execution(public * com.a2m.module..*Service.*()) || execution(public * com.a2m.module..*Service.*(..))", returning="ret")
	public void returningLogging(JoinPoint joinPoint, Object ret) {
		System.out.println(" ");
		if(ret == null){
			System.out.println("[S]["+sdf.format(new Date())+"]  <RETURN> - null");
		}else{
			System.out.println("[S]["+sdf.format(new Date())+"]  <RETURN> - " + ret.getClass().getName());
		}
	}

	@AfterThrowing(pointcut="execution(public * com.a2m.module..*Service.*()) || execution(public * com.a2m.module..*Service.*(..))", throwing="ex")
	public void throwingLogging(JoinPoint joinPoint, Throwable ex) {
		System.out.println("[S]["+sdf.format(new Date())+"] Exception Occured : " + ex.getMessage());
	}

	@After("execution(public * com.a2m.module..*Service.*()) || execution(public * com.a2m.module..*Service.*(..))")
	public void afterLogging(JoinPoint joinPoint) {
		String className = joinPoint.getTarget().getClass().getName();
		String methodName = joinPoint.getSignature().getName();
		System.out.println("[S]["+sdf.format(new Date())+"]  <END   > - " + className + " > " + methodName);
	}
}
