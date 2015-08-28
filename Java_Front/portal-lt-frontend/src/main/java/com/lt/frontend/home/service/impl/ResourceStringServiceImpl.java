package com.lt.frontend.home.service.impl;

import java.util.EnumSet;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Service;

import com.lt.dao.mapper.ResourceStringMapper;
import com.lt.dao.model.ResourceString;
import com.lt.frontend.home.service.IResourceStringService;
import com.lt.frontend.home.util.bean.Language;
import com.lt.platform.framework.core.redis.RedisCacheUtli;

@Service
public class ResourceStringServiceImpl implements IResourceStringService {
	
	private Logger logger = LoggerFactory
			.getLogger(this.getClass());
	
	public static final String REDIS_KEY_I18N = "i18n";
	public static final String SESSION = "session";
	public static final String LANGAUGE_TYPE = "lanType";
	
	@Resource
	private ResourceStringMapper resourceStringMapper;
	
	public List<ResourceString> selectByLanguage(Short language) 
	{
		return resourceStringMapper.selectByLanguage(language);
	}
	
	@Override
	public void initResource()
	{
		Map<Short, Map<String, String>> resMap = new HashMap<Short, Map<String, String>>();
		Map<String, String> resChlidMap = null;
		try 
		{
			RedisCacheUtli.delete(REDIS_KEY_I18N);//如果已存在，移出
			
			EnumSet<Language> enumSet = EnumSet.allOf(Language.class );
			List<ResourceString> resourceStringList = resourceStringMapper.selectAll();
	        for (Language languageEnum : enumSet) 
	        {
	          Iterator<ResourceString> iter = resourceStringList.listIterator();
	          Short language = Short.parseShort(languageEnum.toString());
	          
	          resChlidMap = new HashMap<String, String>();
	          while(iter.hasNext()) 
	          {
	        	  ResourceString res = iter.next();
	        	 
	        	  if(language == res.getLanguage()) 
	        	  {
	        		  resChlidMap.put(res.getKey(), res.getMessage());
	        		  iter.remove();
	        	  }
	          }
	          
	          if(!resChlidMap.isEmpty()) 
	          {
	        	  resMap.put(language, resChlidMap);
	          }
	        }
	        if(!resMap.isEmpty()) {
	        	RedisCacheUtli.setMap(REDIS_KEY_I18N, resMap);
	        }
		} catch(Exception e) {
			logger.warn(e.toString());
		}
		
	}

	@SuppressWarnings("unchecked")
	public void getResource(HttpServletRequest request)
	{
		Map<Integer, Map<String, String>> resMap = null;
		Map<String, String> resChildMap = null;
		try
		{
			HttpSession session = request.getSession();
			Object sessionObj = session.getAttribute(SESSION);
			Object languageTypeObj = session.getAttribute(LANGAUGE_TYPE);
			Object curLanguageTypeObj = request.getParameter(LANGAUGE_TYPE);
			//默认中文
			Short curLanguageType = curLanguageTypeObj != null? Short.parseShort(curLanguageTypeObj.toString()): (languageTypeObj != null?Short.parseShort(languageTypeObj.toString()):Language.LANGUAGE_CN.getCode());
			if (null == sessionObj || (curLanguageTypeObj != null && languageTypeObj != curLanguageTypeObj))
			{
				//先从redis中取
				try
				{
					resMap = RedisCacheUtli.getMap(REDIS_KEY_I18N);
					if(resMap == null) 
					{
						initResource();//如果为空而不是抛异常，重新初始化redis。
						resMap = RedisCacheUtli.getMap(REDIS_KEY_I18N);
					}
					resChildMap = resMap == null ? null : resMap.get(curLanguageType);
				} catch (Exception e)
				{
					logger.warn(e.getMessage());
				}
				
				//如果redis取异常，或者没有值，则从数据库取
				if (null == resChildMap)
				{
					resChildMap = new HashMap<String, String>();
					List<ResourceString> resourceStringList = resourceStringMapper.selectByLanguage(curLanguageType);
					if (null != resourceStringList && resourceStringList.size() > 0)
					{
						for (ResourceString res: resourceStringList)
						{
							resChildMap.put(res.getKey(), res.getMessage());
						}
					}
				}
				
				session.setAttribute(SESSION, resChildMap);
				session.setAttribute(LANGAUGE_TYPE, curLanguageType);
			}
		} catch (Exception e)
		{
			e.printStackTrace();
		}
	}

}
