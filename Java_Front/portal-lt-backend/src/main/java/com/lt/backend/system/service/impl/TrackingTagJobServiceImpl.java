package com.lt.backend.system.service.impl;

import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.system.service.IEbayLmsClientService;
import com.lt.backend.system.service.ITrackingTagJobService;
import com.lt.dao.mapper.TrackingTagJobErrorDetailMapper;
import com.lt.dao.mapper.TrackingTagJobMapper;
import com.lt.dao.model.TrackingTagJobErrorDetail;
import com.lt.dao.po.TrackingTagJobErrorDetailPO;
import com.lt.dao.po.TrackingTagJobPO;
import com.lt.thirdpartylibrary.ebay.client.LMSClientJobs;
@Service
public class TrackingTagJobServiceImpl implements ITrackingTagJobService
{
	private Logger logger = LoggerFactory.getLogger(getClass());
	
	@Autowired
	private TrackingTagJobMapper trackingTagJobMapper;
	
	@Autowired
	private TrackingTagJobErrorDetailMapper trackingTagJobErrorDetailMapper;
	
	@Autowired
	private IEbayLmsClientService ebayLmsClientService;
	
	@Override
	public void excuteJob()
	{
		List<TrackingTagJobPO> list = trackingTagJobMapper.searchByIsStart(Boolean.FALSE);
		
		for(TrackingTagJobPO po: list)
		{
			po.setIsStart(Boolean.TRUE);
			
			//ebayLmsClientService.end2EndUploadJob(po.getUploadFileName(), po.getDownloadFileName(), po.getUserToken(), po.getId());
			try
			{
				if (LMSClientJobs.end2EndUploadJob(po.getUploadFileName(), po.getDownloadFileName(), po.getUserToken())) {
				     logger.info("\n******\nUploadJobEnd2End finished successfully.");
				     
					 trackingTagJobMapper.updateByPrimaryKeySelective(po);
				 } else {
				     logger.info("UploadJobEnd2End failed.");
				 }
				
			} catch (Exception e)
			{
				e.printStackTrace();
				TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
				detail.setTrackingTagJobId(po.getId());
				detail.setErrorMessage(e.getMessage());
				trackingTagJobErrorDetailMapper.insertSelective(detail);
			} finally {
			}
			 
		}
	}

	@Override
	public void abortJobs()
	{
		List<TrackingTagJobErrorDetailPO> detailList = trackingTagJobErrorDetailMapper.selectAll();
		for(TrackingTagJobErrorDetailPO detail: detailList)
		{
			if(detail.getStep() == 2)
			{
				ebayLmsClientService.abortJob(detail.getEbayToken(), detail.getEbayJobId());
			}
		}
		
	}
}
