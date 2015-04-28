package com.lt.frontend.home.util;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.annotation.Resource;

import org.springframework.beans.factory.InitializingBean;
import org.springframework.stereotype.Component;

import com.lt.dao.model.ResourceString;
import com.lt.frontend.home.service.IResourceStringService;
import com.lt.platform.framework.core.redis.RedisCacheUtli;

@Component
public class InitLanguage implements InitializingBean {

	@Resource
	private IResourceStringService resourceStringService;
	
	//private HttpServletRequest request;
	
	public void afterPropertiesSet() throws Exception {
		resourceStringService.initResource();
		
		//先删除当前缓存
		/*RedisCacheUtli.delMap("key");
		RedisCacheUtli.delete("lanType");*/
		
//		try {
//			Integer lanType=1;//初始化中文
//			Map<String, String> resourceStringMap = new HashMap<String, String>();
//			List<ResourceString> resourceStringList = resourceStringService.selectByLanguage(lanType);
//			if(null!=resourceStringList && resourceStringList.size()>0){
//				for (int i = 0; i < resourceStringList.size(); i++) {
//					ResourceString resourceString=resourceStringList.get(i);
//					if(null!=resourceString){
//						resourceStringMap.put(resourceString.getKey(), resourceString.getMessage());
//					}
//				}
//			}
//			RedisCacheUtli.setMap(lanType.toString(), resourceStringMap);
//			//RedisCacheUtli.setString("lanType", lanType.toString());
//			
//			lanType=2;//初始化英文
//			resourceStringMap = new HashMap<String, String>();
//			resourceStringList = resourceStringService.selectByLanguage(lanType);
//			if(null!=resourceStringList && resourceStringList.size()>0){
//				for (int i = 0; i < resourceStringList.size(); i++) {
//					ResourceString resourceString=resourceStringList.get(i);
//					if(null!=resourceString){
//						resourceStringMap.put(resourceString.getKey(), resourceString.getMessage());
//					}
//				}
//			}
//			RedisCacheUtli.setMap(lanType.toString(), resourceStringMap);
//			//RedisCacheUtli.setString("lanType", lanType.toString());
//		} catch (Exception e) {
//			//记录log
//		}
	}
	
	/*implements ApplicationListener<ContextRefreshedEvent>*/
	/*public void onApplicationEvent(ContextRefreshedEvent event) {
		System.out.println("-----所有Bean载入完成---");
	}*/
	
	/*public static HttpSession getSession() { 
		HttpSession session = null; 
		try { 
		    session = getRequest().getSession(); 
		} catch (Exception e) {} 
		    return session; 
		} 

	public static HttpServletRequest getRequest() { 
		ServletRequestAttributes attrs = (ServletRequestAttributes) RequestContextHolder.getRequestAttributes(); 
		return attrs.getRequest(); 
	}*/
       
}
