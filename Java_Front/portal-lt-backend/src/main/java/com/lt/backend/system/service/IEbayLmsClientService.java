package com.lt.backend.system.service;

public interface IEbayLmsClientService
{
	 public boolean end2EndUploadJob(String uploadFileName, String downloadFileName, String userToken, Integer ltJobId);
	 
	 public boolean abortJob(String userToken, String jobId);
}
