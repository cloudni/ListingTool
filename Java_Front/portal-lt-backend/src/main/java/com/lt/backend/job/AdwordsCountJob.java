
package com.lt.backend.job;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import org.apache.log4j.Logger;
import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.springframework.scheduling.quartz.QuartzJobBean;

import com.lt.backend.system.service.ITransactionAuthorizeService;
import com.lt.platform.util.config.SpringUtil;
/**
 * 用于统计扣款的定时器
 * @author jameschen
 *
 */
public class AdwordsCountJob extends QuartzJobBean
{
	 private Logger logger = Logger.getLogger(AdwordsCountJob.class);
	 
	 private static final int COUNT_DAYS = 1;//统计天数，如是1，只统计前一天的，如果是2，统计前两天的
	 private static final String DATE_FORMAT = "yyyy-MM-dd";

	@Override
	protected void executeInternal(JobExecutionContext context)
			throws JobExecutionException
	{
		 Calendar calendar = Calendar.getInstance();
		 calendar.setTime(new Date());
		 
		 for(int i = 0; i < COUNT_DAYS; i ++)
		 {
			calendar.add(Calendar.DATE, -1);
			Date date = calendar.getTime();
			String reportDate = new SimpleDateFormat(DATE_FORMAT).format(date);
			 
			logger.info("统计扣款日期：" + reportDate + "，开始时间：" + new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(new Date()));
			
			ITransactionAuthorizeService transactionAuthorizeService = SpringUtil.getBeanByType(ITransactionAuthorizeService.class);
			try
			{
				transactionAuthorizeService.updateCampaignCost(reportDate);
			} catch (Exception e)
			{
				logger.error("统计扣款异常\n" + e.getMessage(), e);
			}
			logger.info("统计扣款日期：" + reportDate + "，结束时间：" + new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(new Date()));
		 }
	}
	
}
