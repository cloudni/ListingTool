
package com.lt.backend.job;

import java.io.File;
import java.io.IOException;

import org.apache.log4j.Logger;
import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.springframework.scheduling.quartz.QuartzJobBean;

import com.lt.backend.system.service.IEbayListingService;
import com.lt.dao.po.TrackingTagPO;
import com.lt.platform.util.config.SpringUtil;
/**
 * 用于更新产品的tracking tag
 * @author jameschen
 *
 */
public class TrackingTagJob extends QuartzJobBean
{
	 private Logger logger = Logger.getLogger(TrackingTagJob.class);

	@Override
	protected void executeInternal(JobExecutionContext context)
			throws JobExecutionException
	{
		IEbayListingService ebayListingService = SpringUtil.getBeanByType(IEbayListingService.class);
	    String path = this.getClass().getResource("/").getPath();
	    path = path.replace("/WEB-INF/classes/", "");
	    path = path.replace("/", File.separator);
	    
	    TrackingTagPO trackingTag = new TrackingTagPO();
	    trackingTag.setDescriptionReviseMode(TrackingTagPO.DESCRIPT_REVISE_MODE_COMPARE);
		
	    try
		{
			ebayListingService.batchUpdatePixel(path, trackingTag);
		} catch (Exception e)
		{
			logger.error(e.getMessage(),e);
		}
		
	}
	
}
