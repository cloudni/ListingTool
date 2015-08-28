package com.lt.backend.job;

import java.io.IOException;
import java.util.Iterator;
import java.util.Map;
import java.util.Set;

import javax.websocket.Session;

import org.apache.log4j.Logger;
import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.springframework.scheduling.quartz.QuartzJobBean;

import com.lt.backend.home.controller.WsController;
import com.lt.dao.mapper.AdChangeLogMapper;
import com.lt.dao.mapper.TransactionChangeLogMapper;
import com.lt.platform.util.config.SpringUtil;

public class MessageTipJob extends QuartzJobBean
{
	private static Logger logger = Logger.getLogger(MessageTipJob.class);
	public static final String FORMAT = "{\"type\":\"%s\", \"message\":\"%s\"}";
	
	@Override
	protected void executeInternal(JobExecutionContext context)
			throws JobExecutionException
	{
		Map<String, Session> sessionMap = WsController.getSessionMap();
		if(sessionMap != null && !sessionMap.isEmpty())
		{
			TransactionChangeLogMapper transactionChangeLogMapper = (TransactionChangeLogMapper) SpringUtil.getBean("transactionChangeLogMapper");
			Integer transactionChangeLogCount = transactionChangeLogMapper.countByStatus(0);
			
			AdChangeLogMapper adChangeLogMapper = (AdChangeLogMapper) SpringUtil.getBean("adChangeLogMapper");
			Integer adChangeLogCount = adChangeLogMapper.countByStatus(0);
			
			if(transactionChangeLogCount != null && transactionChangeLogCount > 0)
			{
				sendMessage(sessionMap, "transactionChangeLog");
			} else if(adChangeLogCount != null && adChangeLogCount > 0)
			{
				sendMessage(sessionMap, "adChangeLog");
			}
		}
		
	}
	
	private static void sendMessage(Map<String, Session> sessionMap, String sign)
	{
		Set<String> keySet = sessionMap.keySet();
		Iterator<String> it = keySet.iterator();
		while(it.hasNext())
		{
			String key = it.next();
			Session session = sessionMap.get(key);
			try
			{
				session.getBasicRemote().sendText(String.format(FORMAT, sign, "1"), Boolean.TRUE);
				logger.info("成功推送消息给：管理员(" + key + "), 原因：对象" + sign + "有未读消息");
			} catch (IOException e)
			{
				e.printStackTrace();
			}
		}
	}
}


