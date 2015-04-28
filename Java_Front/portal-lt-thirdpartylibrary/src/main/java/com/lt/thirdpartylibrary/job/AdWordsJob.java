package com.lt.thirdpartylibrary.job;

import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.springframework.scheduling.quartz.QuartzJobBean;

import com.lt.platform.util.config.SpringUtil;
import com.lt.thirdpartylibrary.googleadwords.service.IReportService;

/**
 * AdWords定时任务
 * 
 * 
 */
public class AdWordsJob extends QuartzJobBean{

    
    @Override
    protected void executeInternal(JobExecutionContext context)throws JobExecutionException {
        IReportService reportService = (IReportService) SpringUtil.getBean("reportServiceImpl");
        // 下载报表
        reportService.downloadAdwordsReport();
    }
    
    /**
     * 下载报表
     */
//    @Scheduled(cron = "0 0/1 0 * * ?")
//    public void downloadReport() {
//        reportService.downloadAdwordsReport();
//    }

}