package com.lt.backend.system.service;

import com.ebay.marketplace.services.AbortJobResponse;
import com.ebay.marketplace.services.CreateUploadJobResponse;
import com.ebay.marketplace.services.GetJobStatusResponse;
import com.ebay.marketplace.services.GetJobsResponse;
/**
 * 定义LMS大数据交换接口
 * @author jameschen
 *
 */
public interface IBulkDataExchangeService
{
	/**
	 * 初始化LMS上传接口参数
	 * @param userToken ebay的userToken
	 * @param serverUrl	ebay lms 上传接口的url
	 * @param ltJobId lt_tracking_tag_job的主键，用于错误时候，关联错误详情表
	 */
	public void initThreadLocalPara(String userToken, String serverUrl, Integer ltJobId);
	
	/**
	 * 创建上传LMS接口的任务
	 * @param uploadJobType 接口类型
	 * @return
	 */
	public CreateUploadJobResponse createUploadJob(String uploadJobType);
	
	/**
	 * 开启上传LMS接口的任务
	 * @param jobid lms的job id
	 * @return
	 */
	public boolean startUploadJob(String jobid);
	/**
	 * 获取LMS接口任务的状态
	 * @param jobId lms的job id
	 * @return
	 */
	public GetJobStatusResponse getJobStatus(String jobId);
	
	/**
	 * 根据条件获取LMS接口job状态集合
	 * @param conditionsStr
	 * @return
	 */
	public GetJobsResponse getCreateJobs(String conditionsStr);
	
	/**
	 * 根据job id终止LMS当前任务
	 * @param jobId
	 * @return
	 */
	public boolean abortJobs(String jobId);
}
