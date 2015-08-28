package com.lt.backend.system.service;

import com.ebay.marketplace.services.UploadFileResponse;
import com.lt.backend.system.util.FileTransferException;
/**
 * 用于封装LMS上传下载接口
 * @author jameschen
 *
 */
public interface IFileTransferService
{
	/**
	 * 初始化LMS上传接口参数
	 * @param userToken ebay的userToken
	 * @param serverUrl	ebay lms 上传接口的url
	 * @param ltJobId lt_tracking_tag_job的主键，用于错误时候，关联错误详情表
	 */
	public void initThreadLocalPara(String userToken, String serverUrl, Integer ltJobId);
	/**
	 * 通过LMS上传指定文件
	 * @param xmlFile 文件路径
	 * @param jobId	LMS的jobid
	 * @param fileReferenceId LMS的fileReferenceId
	 * @return
	 * @throws FileTransferException
	 */
	public boolean uploadFile(String xmlFile,String jobId, String fileReferenceId);
	/**
	 * 通过LMS下载处理结果
	 * @param fileName 下载本地的文件路径
	 * @param jobId LMS的jobid
	 * @param fileReferenceId LMS的下载fileReferenceId
	 * @return
	 * @throws FileTransferException
	 */
	public boolean downloadFile(String fileName, String jobId,String fileReferenceId);
}
