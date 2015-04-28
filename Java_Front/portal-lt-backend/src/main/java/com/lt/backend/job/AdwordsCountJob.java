package com.lt.backend.job;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.springframework.scheduling.quartz.QuartzJobBean;

import com.lt.backend.system.service.ITransactionAuthorizeService;
import com.lt.platform.util.config.SpringUtil;

public class AdwordsCountJob extends QuartzJobBean
{

	@Override
	protected void executeInternal(JobExecutionContext context)
			throws JobExecutionException
	{
		
		 Calendar calendar = Calendar.getInstance();
		 calendar.setTime(new Date());
		 calendar.add(Calendar.DAY_OF_MONTH, -2);
		 Date date = calendar.getTime();
		 String reportDate = new SimpleDateFormat("yyyy-MM-dd").format(date);
		 
		ITransactionAuthorizeService transactionAuthorizeService = SpringUtil.getBeanByType(ITransactionAuthorizeService.class);
		transactionAuthorizeService.updateCampaignCost(reportDate);
	}
}
